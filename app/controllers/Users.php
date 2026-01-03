<?php
  class Users extends Controller {
    public function __construct(){
      $this->userModel = $this->model('User');
      $this->postModel = $this->model('Post');
      $this->messageModel = $this->model('Message');
      $this->commentModel = $this->model('Comment');
      $this->inviteModel = $this->model('Invite');
      $this->hubModel = $this->model('Hub');
      $this->activityModel = $this->model('Activity');
      $this->starModel = $this->model('Star');
    }

    public function register(){
      // check for POST
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // process form

        // sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // init data
        $data = [
          'name' => trim($_POST['name']),
          'last_name' => trim($_POST['last_name']),
          'email' => trim($_POST['email']),
          'password' => trim($_POST['password']),
          'confirm_password' => trim($_POST['confirm_password']),
          'name_err' => '',
          'email_err' => '',
          'password_err' => '',
          'confirm_password_err' => ''
        ];

        // validate name
        if(empty($data['name'])){
          $data['name_err'] = 'Please enter your first name';
        }

        if(empty($data['last_name'])){
          $data['last_name_err'] = 'Please enter your last name';
        }

        // validate email
        if(empty($data['email'])){
          $data['email_err'] = 'Please enter an email address';
        } elseif($this->userModel->findUserByEmail($data['email'])){
          $data['email_err'] = 'This email is already taken';
        } elseif(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
          $data['email_err'] = 'Please enter a valid email address';
        }

        // validate password
        $uppercase = preg_match('@[A-Z]@', $data['password']);
        $lowercase = preg_match('@[a-z]@', $data['password']);
        $number    = preg_match('@[0-9]@', $data['password']);
        if(empty($data['password'])){
          $data['password_err'] = 'Please enter a password';
        } elseif(strlen($data['password']) < 6){
          $data['password_err'] = 'Password must be at least 6 characters';
        } elseif(!$uppercase || !$lowercase || !$number){
          $data['password_err'] = 'Password must contain at least one lower case letter, one upper case letter and a number';
        }

        // validate confirm password
        if(empty($data['confirm_password'])){
          $data['confirm_password_err'] = 'Please confirm password';
        } else {
          if($data['password'] != $data['confirm_password']){
            $data['confirm_password_err'] = 'Passwords do not match';
          }
        }

        // ensure errors are empty
        if(empty($data['name_err']) && empty($data['last_name_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])){
          // validated

          // hash password
          $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

          // redirect to next step
          $_SESSION['register_name'] = $data['name'];
          $_SESSION['register_last_name'] = $data['last_name'];
          $_SESSION['register_email'] = $data['email'];
          $_SESSION['register_password'] = $data['password'];
          redirect('users/register2');

        } else {
          // load view with errors
          $this->view('users/register', $data);
        }

      } else {
        // init data
        $data = [
          'name' => '',
          'last_name' => '',
          'email' => '',
          'password' => '',
          'confirm_password' => '',
          'name_err' => '',
          'last_name_err' => '',
          'email_err' => '',
          'password_err' => '',
          'confirm_password_err' => ''
        ];

        // load view
        $this->view('users/register', $data);
      }
    }

    public function register2(){
      // ensure register step 1 has been completed, if not redirect to it
      if(!isset($_SESSION['register_name'])){
        redirect('users/register');
      }

      // check for POST
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // process form

        // sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // init data
        $data = [
          'name' => $_SESSION['register_name'],
          'last_name' => $_SESSION['register_last_name'],
          'email' => $_SESSION['register_email'],
          'password' => $_SESSION['register_password'],
          'about' => trim($_POST['about']),
          'location' => trim($_POST['location']),
          'colour' => 'secondary',
          'hubname' => trim($_POST['hubname']),
          'hubname_err' => '',
          'img' => '',
          'img2' => '',
          'img3' => '',
          'hub_2_id' => 0,
          'hub_3_id' => 0,
          'hub_4_id' => 0,
          'hub_5_id' => 0,
          'removed_hub' => 0
        ];

        // validate data
        if(empty($data['hubname'])){
          $data['hubname_err'] = 'Please enter a Hubname';
        } elseif(strlen($data['hubname']) > 20){
          $error = 'Hubname entered is too long';
          $data['hubname_err'] = 'Hubname must be less than 20 characters long';
        } elseif(preg_match('/\s/', $data['hubname'])){
          $data['hubname_err'] = 'Hubname cannot contain any spaces';
        }

        // ensure errors are empty
        if(empty($data['hubname_err'])){
          // create hub

          $id = $this->hubModel->addHub($data);
          $data['hub_id'] = $id;
          $data['hub_1_id'] = $id;
          // register user

          $userId = $this->userModel->register($data);
          if($userId){
            flash('success_message', 'Welcome to your first Hub!');

            // update hubs activity
            $activityData = [
              'hub_id' => $id,
              'hub' => $data['hubname'],
              'user_id' => $userId,
              'user' => $data['name'],
              'type' => 'Join',
              'to_id' => 0,
              'post_id' => 0,
              'comment_id' => 0,
              'remover_id' => 0,
              'remover_name' => '',
              'notify_user' => 0
            ];

            $this->activityModel->addActivity($activityData);

            // registration email
            $to = 'jakeleonce@outlook.com';
            // $to = $data['email'];
            $subject = 'Welcome to TheHub!';
            $from = 'info@homeofthehub.com';

            // To send HTML mail, the Content-type header must be set
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

            // Create email headers
            $headers .= 'From: '.$from."\r\n".
                'Reply-To: '.$from."\r\n" .
                'X-Mailer: PHP/' . phpversion();

            // base64 images
            $path = URLROOT . '/public/img/hub_logo.png';
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $imgData = file_get_contents($path);
            $hubB64 = 'data:image/' . $type . ';base64,' . base64_encode($imgData);

            $path = URLROOT . '/public/img/party_popper_emoji.png';
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $imgData = file_get_contents($path);
            $emojiB64 = 'data:image/' . $type . ';base64,' . base64_encode($imgData);

            $path = URLROOT . '/public/img/social/facebook.png';
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $imgData = file_get_contents($path);
            $facebookB64 = 'data:image/' . $type . ';base64,' . base64_encode($imgData);

            $path = URLROOT . '/public/img/social/instagram.png';
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $imgData = file_get_contents($path);
            $instagramB64 = 'data:image/' . $type . ';base64,' . base64_encode($imgData);

            $path = URLROOT . '/public/img/social/twitter.png';
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $imgData = file_get_contents($path);
            $twitterB64 = 'data:image/' . $type . ';base64,' . base64_encode($imgData);

            // Compose a simple HTML email message
            $message = "<html><body>";
            $message .= "<div style='margin:auto;padding:20px;padding-bottom:30px;background-color:#f7f7f9;border-radius:.25rem;border:1px solid rgba(0,0,0,.125);text-align:center;'>";
            $message .= "<img src='" . $hubB64 . "' alt='thehub' style='height:3em;display:block;margin:auto;'>";
            $message .= "<h1 style='text-align:center;'>Welcome Hubmate!</h1>";
            $message .= "<img src='" . $emojiB64 . "' alt='emoji' style='height:3.5em;display:block;margin:auto;'>";
            $message .= "<p style='text-align:center;'>A big hello from us here at <strong style='color:rgb(56,27,68);'>The<span style='color:rgb(115,79,150);'>Hub</span></strong>! Thank you for registering " . $data['name'] . ", your Hub ID is <strong>" . $userId . "</strong>.</p>";
            $message .= "<p style='text-align:center;'>You're all set and ready to begin your journey.</p><br>";
            $message .= "<p style='text-align:center;'>Learn more about us here</p>";
            $message .= "<a href='" . URLROOT . "/pages/about' style='cursor:pointer;color:#fff;background-color:rgb(56,27,68);border-color:rgb(56,27,68);text-align:center;padding:.375rem .75rem;border-radius:.25rem;text-decoration:none;'>Find out more</a>";
            $message .= "<p></p>";
            $message .= "<p></p>";
            $message .= "<p></p><br>";
            $message .= "<tr style='margin:10px;text-align:center;'><td>";
            $message .= "<a href='https://facebook.com' style='cursor:pointer;padding:10px;margin:10px;text-align:center;'><img src='" . $facebookB64 . "' alt='facebook/thehub' style='height:2em'></a>";
            $message .= "<a href='https://instagram.com' style='cursor:pointer;padding:10px;margin:10px;text-align:center;'><img src='" . $instagramB64 . "' alt='instagram/thehub' style='height:2em'></a>";
            $message .= "<a href='https://twitter.com' style='cursor:pointer;padding:10px;margin:10px;text-align:center;'><img src='" . $twitterB64 . "' alt='twitter/thehub' style='height:2em'></a>";
            $message .= "</td></tr>";
            $message .= "</div>";
            $message .= "<br></body></html>";

            // Sending email
            // if(mail($to, $subject, $message, $headers)){
            //   echo 'Email sent.';
            // } else {
            //   echo 'Unable to send email.';
            // }

            // redirect('users/login');
            $user = $this->userModel->getUserById($userId);

            if($user){
              // create session variables
              $this->createUserSession($user);
            }
          } else {
            die('Oops! Something went wrong');
          }

        } else {
          // load view with errors
          $this->view('users/register2', $data);
        }

      } else {
        // init data
        $data = [
          'name' => $_SESSION['register_name'],
          'last_name' => $_SESSION['register_last_name'],
          'email' => $_SESSION['register_email'],
          'password' => $_SESSION['register_password'],
          'about' => '',
          'location' => '',
          'hubname' => 'My',
          'hubname_err' => ''
        ];

        // load view
        $this->view('users/register2', $data);
      }
    }

    public function password(){
      // check for POST
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $email = trim($_POST['email']);
        $user = $this->userModel->findUserByEmail($email);

        $data = [
          'email' => $email
        ];

        if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
          $data['email_err'] = 'Please enter a valid email address';
        } elseif(!$this->userModel->findUserByEmail($email)){
          $data['email_err'] = 'User not found';
        }

        if(empty($data['email_err'])){
          flash('success_message', 'A password reset link has been sent. Please check your inbox');

          $data['user'] = $user;
          // send password reset link

          redirect('users/login');
        } else {
          // load view with errors
          $this->view('users/password', $data);
        }
      } else {
        // load view
        $this->view('users/password');
      }
    }

    public function login(){
      // check for POST
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // process form

        // sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // init data
        $data = [
          'email' => trim($_POST['email']),
          'password' => trim($_POST['password']),
          'email_err' => '',
          'password_err' => '',
        ];

        // validate email
        if(empty($data['email'])){
          $data['email_err'] = 'Please enter your email address';
        }

        // validate password
        if(empty($data['password'])){
          $data['password_err'] = 'Please enter your password';
        }

        // check for user and email
        if($this->userModel->findUserByEmail($data['email'])){
          // user found
        } else {
          // no user found
          $data['email_err'] = 'User not recognized';
        }

        // ensure errors are empty
        if(empty($data['email_err']) && empty($data['password_err'])){
          // validated
          $loggedInUser = $this->userModel->login($data['email'], $data['password']);

          if($loggedInUser){
            // create session variables
            $this->createUserSession($loggedInUser);
          } else {
            $data['password_err'] = 'Incorrect password';

            $this->view('users/login', $data);
          }

        } else {
          // load view with errors
          $this->view('users/login', $data);
        }

      } else {
        // init data
        $data = [
          'email' => '',
          'password' => '',
          'email_err' => '',
          'password_err' => '',
        ];

        // load view
        $this->view('users/login', $data);
      }
    }

    public function createUserSession($user){
      $userName = $user->name . " " . $user->last_name;
      $_SESSION['seen_welcome_message'] = 0;
      $_SESSION['user_id'] = $user->id;
      if($user->img){
        $_SESSION['user_img'] = base64_decode($user->img);
      } else {
        $_SESSION['user_img'] = '';
      }
      $_SESSION['user_colour'] = $user->colour;
      $_SESSION['user_name'] = $userName;
      $_SESSION['user_email'] = $user->email;
      $_SESSION['user_hub'] = $user->hub;
      $_SESSION['user_hub_id'] = $user->hub_id;
      $_SESSION['flash_message'] = '';
      $_SESSION['flash_error_message'] = '';
      $_SESSION['user_hub_1_notifications'] = 0;
      $_SESSION['user_hub_2_notifications'] = 0;
      $_SESSION['user_hub_3_notifications'] = 0;
      $_SESSION['user_hub_4_notifications'] = 0;
      $_SESSION['user_hub_5_notifications'] = 0;

      if($user->hub_1_id != 0){
        $hub = $this->hubModel->getHubById($user->hub_1_id);
        $_SESSION['user_hub_1_id'] = $user->hub_1_id;
        $_SESSION['user_hub_1'] = $hub->name;

        $postData = [
          'user_id' => $_SESSION['user_id'],
          'hub_id' => $_SESSION['user_hub_1_id']
        ];
        $posts = $this->postModel->getUserPostsByHubId($postData);

        // get number of unseen activities (posts and comments)
        $activityData = [
          'to_id' => $user->id,
          'seen' => 0
        ];
        $unseenActivities = $this->activityModel->getActivitiesByToId($activityData);

        // check if activities are for the correct Hub
        $activityCounter = 0;
        foreach($unseenActivities as $activity){
          if($activity->hubId != $user->hub_1_id){
            $activityCounter += 1;
          }
        }

        $notificationCount = count($unseenActivities) - $activityCounter;

        $_SESSION['user_hub_1_notifications'] += $notificationCount;

        $data = [
          'id' => $user->id,
          'seen' => 0,
          'hub_id' => $user->hub_1_id
        ];

        $newMessages = $this->messageModel->getAllUnseenUserMessages($data);
        // ommit unseen messages the session user has sent
        $messageCounter = 0;
        foreach($newMessages as $message){
          if($message->fromId == $_SESSION['user_id']){
            $messageCounter += 1;
          }
        }
        $_SESSION['user_hub_1_whispers'] = count($newMessages) - $messageCounter;

      } else {
        $_SESSION['user_hub_1_id'] = 0;
        $_SESSION['user_hub_1'] = '';
        $_SESSION['user_hub_1_notifications'] = 0;
        $_SESSION['user_hub_1_whispers'] = 0;
      }

      if($user->hub_2_id != 0){
        $hub = $this->hubModel->getHubById($user->hub_2_id);
        $_SESSION['user_hub_2_id'] = $user->hub_2_id;
        $_SESSION['user_hub_2'] = $hub->name;

        $postData = [
          'user_id' => $_SESSION['user_id'],
          'hub_id' => $_SESSION['user_hub_2_id']
        ];
        $posts = $this->postModel->getUserPostsByHubId($postData);

        // get number of unseen activities (posts and comments)
        $activityData = [
          'to_id' => $user->id,
          'seen' => 0
        ];
        $unseenActivities = $this->activityModel->getActivitiesByToId($activityData);

        // check if activities are for the correct Hub
        $activityCounter = 0;
        foreach($unseenActivities as $activity){
          if($activity->hubId != $user->hub_2_id){
            $activityCounter += 1;
          }
        }

        $notificationCount = count($unseenActivities) - $activityCounter;

        $_SESSION['user_hub_2_notifications'] += $notificationCount;

        $data = [
          'id' => $user->id,
          'seen' => 0,
          'hub_id' => $user->hub_2_id
        ];

        $newMessages = $this->messageModel->getAllUnseenUserMessages($data);
        // ommit unseen messages the session user has sent
        $messageCounter = 0;
        foreach($newMessages as $message){
          if($message->fromId == $_SESSION['user_id']){
            $messageCounter += 1;
          }
        }
        $_SESSION['user_hub_2_whispers'] = count($newMessages) - $messageCounter;

      } else {
        $_SESSION['user_hub_2_id'] = 0;
        $_SESSION['user_hub_2'] = '';
        $_SESSION['user_hub_2_notifications'] = 0;
        $_SESSION['user_hub_2_whispers'] = 0;
      }

      if($user->hub_3_id != 0){
        $hub = $this->hubModel->getHubById($user->hub_3_id);
        $_SESSION['user_hub_3_id'] = $user->hub_3_id;
        $_SESSION['user_hub_3'] = $hub->name;

        $postData = [
          'user_id' => $_SESSION['user_id'],
          'hub_id' => $_SESSION['user_hub_3_id']
        ];
        $posts = $this->postModel->getUserPostsByHubId($postData);

        // get number of unseen activities (posts and comments)
        $activityData = [
          'to_id' => $user->id,
          'seen' => 0
        ];
        $unseenActivities = $this->activityModel->getActivitiesByToId($activityData);

        // check if activities are for the correct Hub
        $activityCounter = 0;
        foreach($unseenActivities as $activity){
          if($activity->hubId != $user->hub_3_id){
            $activityCounter += 1;
          }
        }

        $notificationCount = count($unseenActivities) - $activityCounter;

        $_SESSION['user_hub_3_notifications'] += $notificationCount;

        $data = [
          'id' => $user->id,
          'seen' => 0,
          'hub_id' => $user->hub_3_id
        ];

        $newMessages = $this->messageModel->getAllUnseenUserMessages($data);
        // ommit unseen messages the session user has sent
        $messageCounter = 0;
        foreach($newMessages as $message){
          if($message->fromId == $_SESSION['user_id']){
            $messageCounter += 1;
          }
        }
        $_SESSION['user_hub_3_whispers'] = count($newMessages) - $messageCounter;

      } else {
        $_SESSION['user_hub_3_id'] = 0;
        $_SESSION['user_hub_3'] = '';
        $_SESSION['user_hub_3_notifications'] = 0;
        $_SESSION['user_hub_3_whispers'] = 0;
      }

      if($user->hub_4_id != 0){
        $hub = $this->hubModel->getHubById($user->hub_4_id);
        $_SESSION['user_hub_4_id'] = $user->hub_4_id;
        $_SESSION['user_hub_4'] = $hub->name;

        $postData = [
          'user_id' => $_SESSION['user_id'],
          'hub_id' => $_SESSION['user_hub_4_id']
        ];
        $posts = $this->postModel->getUserPostsByHubId($postData);

        // get number of unseen activities (posts and comments)
        $activityData = [
          'to_id' => $user->id,
          'seen' => 0
        ];
        $unseenActivities = $this->activityModel->getActivitiesByToId($activityData);

        // check if activities are for the correct Hub
        $activityCounter = 0;
        foreach($unseenActivities as $activity){
          if($activity->hubId != $user->hub_4_id){
            $activityCounter += 1;
          }
        }

        $notificationCount = count($unseenActivities) - $activityCounter;

        $_SESSION['user_hub_4_notifications'] += $notificationCount;

        $data = [
          'id' => $user->id,
          'seen' => 0,
          'hub_id' => $user->hub_4_id
        ];

        $newMessages = $this->messageModel->getAllUnseenUserMessages($data);
        // ommit unseen messages the session user has sent
        $messageCounter = 0;
        foreach($newMessages as $message){
          if($message->fromId == $_SESSION['user_id']){
            $messageCounter += 1;
          }
        }
        $_SESSION['user_hub_4_whispers'] = count($newMessages) - $messageCounter;

      } else {
        $_SESSION['user_hub_4_id'] = 0;
        $_SESSION['user_hub_4'] = '';
        $_SESSION['user_hub_4_notifications'] = 0;
        $_SESSION['user_hub_4_whispers'] = 0;
      }

      if($user->hub_5_id != 0){
        $hub = $this->hubModel->getHubById($user->hub_5_id);
        $_SESSION['user_hub_5_id'] = $user->hub_5_id;
        $_SESSION['user_hub_5'] = $hub->name;

        $postData = [
          'user_id' => $_SESSION['user_id'],
          'hub_id' => $_SESSION['user_hub_5_id']
        ];
        $posts = $this->postModel->getUserPostsByHubId($postData);

        // get number of unseen activities (posts and comments)
        $activityData = [
          'to_id' => $user->id,
          'seen' => 0
        ];
        $unseenActivities = $this->activityModel->getActivitiesByToId($activityData);

        // check if activities are for the correct Hub
        $activityCounter = 0;
        foreach($unseenActivities as $activity){
          if($activity->hubId != $user->hub_5_id){
            $activityCounter += 1;
          }
        }

        $notificationCount = count($unseenActivities) - $activityCounter;

        $_SESSION['user_hub_5_notifications'] += $notificationCount;

        $data = [
          'id' => $user->id,
          'seen' => 0,
          'hub_id' => $user->hub_5_id
        ];

        $newMessages = $this->messageModel->getAllUnseenUserMessages($data);
        // ommit unseen messages the session user has sent
        $messageCounter = 0;
        foreach($newMessages as $message){
          if($message->fromId == $_SESSION['user_id']){
            $messageCounter += 1;
          }
        }
        $_SESSION['user_hub_5_whispers'] = count($newMessages) - $messageCounter;

      } else {
        $_SESSION['user_hub_5_id'] = 0;
        $_SESSION['user_hub_5'] = '';
        $_SESSION['user_hub_5_notifications'] = 0;
        $_SESSION['user_hub_5_whispers'] = 0;
      }

      // get notification data
      $user = $this->userModel->getUserById($_SESSION['user_id']);
      // check for new Hub invites
      $invites = $this->inviteModel->getNewInvitesByUserId($_SESSION['user_id']);

      $noOfInvites = count($invites);

      $_SESSION['user_invites'] = $noOfInvites;

      // update users status to online
      $data = [
        'id' => $user->id,
        'status' => 'online'
      ];
      $this->userModel->updateUserStatus($data);

      redirect('pages/index');
    }

    public function profile($id){
      if(!isLoggedIn()){
        redirect('users\login');
      }

      // check for unseen seen flag
      $userData = [
        'notify_user' => $_SESSION['user_id'],
        'seen' => 0
      ];
      $unseenRemovedActivity = $this->activityModel->getActivitiesByNotifyUser($userData);

      if(!empty($unseenRemovedActivity)){
        $removedFromHub = $unseenRemovedActivity;
        foreach($unseenRemovedActivity as $activity){
          $removedFromHub = $activity->hub;
          $createdNewHub = $activity->created_new_hub;

          // set session variables
          if($createdNewHub){
            $_SESSION['user_hub_id'] = $activity->created_new_hub;
            $_SESSION['user_hub'] = 'New';
          } elseif($_SESSION['user_hub_id'] == $removedFromHub){
            // if the Hub they have been removed from was their session Hub
            $user = $this->userModel->getUserById($_SESSION['user_id']);
            $_SESSION['user_hub_id'] = $user->hub_id;
            $_SESSION['user_hub'] = $user->hub;
          }
        }

        // mark as seen
        $data = [
          'id' => $unseenRemovedActivity->id,
          'seen' => 1
        ];
        $this->activityModel->updatePostActivitySeenFlag($data);
      } else {
        $removedFromHub = '';
        $createdNewHub = 0;
      }

      $user = $this->userModel->getUserById($_SESSION['user_id']);

      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // flash('success_message', 'Welcome to your new Hub!');
        // sanitize POST array
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        if(isset($_POST['removeHubmateBtn'])){
          $user = $this->userModel->getUserById($id);
          $mates = $this->userModel->getHubmates($_SESSION['user_hub_id']);

          $defaultHub = $user->hub_id;
          $noOfHubs = 5;
          $noOfMates = count($mates);

          // button will be disabled if this is the users only Hub so there is no need to hanlde this logic here
          $data = [
            'id' => $id,
            'hub_id' => 0
          ];

          if($user->hub_1_id == $_SESSION['user_hub_id']){
            if($this->userModel->updateHub1($data)){
              if($user->hub_2_id != 0){
                // delete all posts and comments made by the user in that Hub
                $hubPosts = $this->postModel->getPostsByHubId($_SESSION['user_hub_id']);
                foreach($hubPosts as $post){
                  if($post->user_id == $id){
                    $hubComments = $this->commentModel->getCommentsByPostId($post->postId);
                    foreach($hubComments as $comment){
                        $this->commentModel->deleteComment($comment->commentId);
                        // delete all comment activities
                        $commentActivities = $this->activityModel->getActivitiesByCommentId($comment->commentId);
                        foreach($commentActivities as $comment){
                          $this->activityModel->deleteActivity($comment->commentId);
                        }
                    }
                    $this->postModel->deletePost($post->postId);

                    $postActivities = $this->activityModel->getActivitiesByPostId($post->postId);
                    foreach($postActivities as $activity){
                      $this->activityModel->deleteActivity($activity->activityId);
                    }
                  }
                }

                // delete all user comments on other posts
                $commentData = [
                  'from_id' => $id,
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userComments = $this->commentModel->getUserCommentsByHubId($commentData);
                foreach($userComments as $comment){
                    $this->commentModel->deleteComment($comment->commentId);
                    // delete all comment activities
                    $commentActivities = $this->activityModel->getActivitiesByCommentId($comment->commentId);
                    foreach($commentActivities as $comment){
                      $this->activityModel->deleteActivity($comment->commentId);
                    }
                }

                // delete all user messages in that Hub
                $messagesData = [
                  'id' => $id,
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userMessages = $this->messageModel->getMessages($messagesData);

                foreach($userMessages as $message){
                  $this->messageModel->deleteMessage($message->messageId);
                }

                $hubmates = $this->userModel->getHubmates($_SESSION['user_hub_id']);
                foreach($hubmates as $mate){
                  if($mate->userId != $id){
                    // update hubs activity
                    $activityData = [
                      'hub_id' => $_SESSION['user_hub_id'],
                      'hub' => $_SESSION['user_hub'],
                      'user_id' => $id,
                      'user' => $user->name . " " . $user->last_name,
                      'to_id' => $mate->userId,
                      'type' => 'Remove',
                      'remover_id' => $_SESSION['user_id'],
                      'remover_name' => $_SESSION['user_name'],
                      'notify_user' => 0,
                      'created_new_hub' => 0,
                      'post_id' => 0,
                      'comment_id' => 0
                    ];

                    $this->activityModel->addRemoverActivity($activityData);
                  }
                }

                // update notify_user activity
                $activityData = [
                  'hub_id' => $_SESSION['user_hub_id'],
                  'hub' => $_SESSION['user_hub'],
                  'user_id' => $id,
                  'user' => $user->name . " " . $user->last_name,
                  'to_id' => 0,
                  'type' => 'Remove',
                  'remover_id' => $_SESSION['user_id'],
                  'remover_name' => $_SESSION['user_name'],
                  'notify_user' => $id,
                  'created_new_hub' => 0,
                  'post_id' => 0,
                  'comment_id' => 0
                ];

                $this->activityModel->addRemoverActivity($activityData);

                // check if the left Hub was their default and change if so to avoid complications on future sign ins
                if($user->hub_id == $_SESSION['user_hub_id']){
                  $newDefaultHub = $this->hubModel->getHubById($user->hub_2_id);
                  $data = [
                    'id' => $id,
                    'hub' => $newDefaultHub->name,
                    'hub_id' => $user->hub_2_id
                  ];

                  $this->userModel->updateUserDefaultHub($data);
                }

                errorFlash('success_message', 'Hubmate Removed');
                $_SESSION['flash_error_message'] = 'Hubmate Removed';
                redirect('users/profile/' . $id);
              } elseif($user->hub_3_id != 0){
                // delete all posts and comments made by the user in that Hub
                $hubPosts = $this->postModel->getPostsByHubId($_SESSION['user_hub_id']);
                foreach($hubPosts as $post){
                  if($post->user_id == $id){
                    $hubComments = $this->commentModel->getCommentsByPostId($post->postId);
                    foreach($hubComments as $comment){
                        $this->commentModel->deleteComment($comment->commentId);
                        // delete all comment activities
                        $commentActivities = $this->activityModel->getActivitiesByCommentId($comment->commentId);
                        foreach($commentActivities as $comment){
                          $this->activityModel->deleteActivity($comment->commentId);
                        }
                    }
                    $this->postModel->deletePost($post->postId);

                    $postActivities = $this->activityModel->getActivitiesByPostId($post->postId);
                    foreach($postActivities as $activity){
                      $this->activityModel->deleteActivity($activity->activityId);
                    }
                  }
                }

                // delete all user comments on other posts
                $commentData = [
                  'from_id' => $id,
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userComments = $this->commentModel->getUserCommentsByHubId($commentData);
                foreach($userComments as $comment){
                    $this->commentModel->deleteComment($comment->commentId);
                    // delete all comment activities
                    $commentActivities = $this->activityModel->getActivitiesByCommentId($comment->commentId);
                    foreach($commentActivities as $comment){
                      $this->activityModel->deleteActivity($comment->commentId);
                    }
                }

                // delete all user messages in that Hub
                $messagesData = [
                  'id' => $id,
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userMessages = $this->messageModel->getMessages($messagesData);

                foreach($userMessages as $message){
                  $this->messageModel->deleteMessage($message->messageId);
                }

                $hubmates = $this->userModel->getHubmates($_SESSION['user_hub_id']);
                foreach($hubmates as $mate){
                  if($mate->userId != $id){
                    // update hubs activity
                    $activityData = [
                      'hub_id' => $_SESSION['user_hub_id'],
                      'hub' => $_SESSION['user_hub'],
                      'user_id' => $id,
                      'user' => $user->name . " " . $user->last_name,
                      'to_id' => $mate->userId,
                      'type' => 'Remove',
                      'remover_id' => $_SESSION['user_id'],
                      'remover_name' => $_SESSION['user_name'],
                      'notify_user' => 0,
                      'created_new_hub' => 0,
                      'post_id' => 0,
                      'comment_id' => 0
                    ];

                    $this->activityModel->addRemoverActivity($activityData);
                  }
                }

                // update notify_user activity
                $activityData = [
                  'hub_id' => $_SESSION['user_hub_id'],
                  'hub' => $_SESSION['user_hub'],
                  'user_id' => $id,
                  'user' => $user->name . " " . $user->last_name,
                  'to_id' => 0,
                  'type' => 'Remove',
                  'remover_id' => $_SESSION['user_id'],
                  'remover_name' => $_SESSION['user_name'],
                  'notify_user' => $id,
                  'created_new_hub' => 0,
                  'post_id' => 0,
                  'comment_id' => 0
                ];

                $this->activityModel->addRemoverActivity($activityData);

                // check if the left Hub was their default and change if so to avoid complications on future sign ins
                if($user->hub_id == $_SESSION['user_hub_id']){
                  $newDefaultHub = $this->hubModel->getHubById($user->hub_3_id);
                  $data = [
                    'id' => $id,
                    'hub' => $newDefaultHub->name,
                    'hub_id' => $user->hub_3_id
                  ];

                  $this->userModel->updateUserDefaultHub($data);
                }

                errorFlash('success_message', 'Hubmate Removed');
                $_SESSION['flash_error_message'] = 'Hubmate Removed';
                redirect('users/profile/' . $id);
              } elseif($user->hub_4_id != 0){
                // delete all posts and comments made by the user in that Hub
                $hubPosts = $this->postModel->getPostsByHubId($_SESSION['user_hub_id']);
                foreach($hubPosts as $post){
                  if($post->user_id == $id){
                    $hubComments = $this->commentModel->getCommentsByPostId($post->postId);
                    foreach($hubComments as $comment){
                        $this->commentModel->deleteComment($comment->commentId);
                        // delete all comment activities
                        $commentActivities = $this->activityModel->getActivitiesByCommentId($comment->commentId);
                        foreach($commentActivities as $comment){
                          $this->activityModel->deleteActivity($comment->commentId);
                        }
                    }
                    $this->postModel->deletePost($post->postId);

                    $postActivities = $this->activityModel->getActivitiesByPostId($post->postId);
                    foreach($postActivities as $activity){
                      $this->activityModel->deleteActivity($activity->activityId);
                    }
                  }
                }

                // delete all user comments on other posts
                $commentData = [
                  'from_id' => $id,
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userComments = $this->commentModel->getUserCommentsByHubId($commentData);
                foreach($userComments as $comment){
                    $this->commentModel->deleteComment($comment->commentId);
                    // delete all comment activities
                    $commentActivities = $this->activityModel->getActivitiesByCommentId($comment->commentId);
                    foreach($commentActivities as $comment){
                      $this->activityModel->deleteActivity($comment->commentId);
                    }
                }

                // delete all user messages in that Hub
                $messagesData = [
                  'id' => $id,
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userMessages = $this->messageModel->getMessages($messagesData);

                foreach($userMessages as $message){
                  $this->messageModel->deleteMessage($message->messageId);
                }

                $hubmates = $this->userModel->getHubmates($_SESSION['user_hub_id']);
                foreach($hubmates as $mate){
                  if($mate->userId != $id){
                    // update hubs activity
                    $activityData = [
                      'hub_id' => $_SESSION['user_hub_id'],
                      'hub' => $_SESSION['user_hub'],
                      'user_id' => $id,
                      'user' => $user->name . " " . $user->last_name,
                      'to_id' => $mate->userId,
                      'type' => 'Remove',
                      'remover_id' => $_SESSION['user_id'],
                      'remover_name' => $_SESSION['user_name'],
                      'notify_user' => 0,
                      'created_new_hub' => 0,
                      'post_id' => 0,
                      'comment_id' => 0
                    ];

                    $this->activityModel->addRemoverActivity($activityData);
                  }
                }

                // update notify_user activity
                $activityData = [
                  'hub_id' => $_SESSION['user_hub_id'],
                  'hub' => $_SESSION['user_hub'],
                  'user_id' => $id,
                  'user' => $user->name . " " . $user->last_name,
                  'to_id' => 0,
                  'type' => 'Remove',
                  'remover_id' => $_SESSION['user_id'],
                  'remover_name' => $_SESSION['user_name'],
                  'notify_user' => $id,
                  'created_new_hub' => 0,
                  'post_id' => 0,
                  'comment_id' => 0
                ];

                $this->activityModel->addRemoverActivity($activityData);

                // check if the left Hub was their default and change if so to avoid complications on future sign ins
                if($user->hub_id == $_SESSION['user_hub_id']){
                  $newDefaultHub = $this->hubModel->getHubById($user->hub_4_id);
                  $data = [
                    'id' => $id,
                    'hub' => $newDefaultHub->name,
                    'hub_id' => $user->hub_4_id
                  ];

                  $this->userModel->updateUserDefaultHub($data);
                }

                errorFlash('success_message', 'Hubmate Removed');
                $_SESSION['flash_error_message'] = 'Hubmate Removed';
                redirect('users/profile/' . $id);
              } elseif($user->hub_5_id != 0){
                // delete all posts and comments made by the user in that Hub
                $hubPosts = $this->postModel->getPostsByHubId($_SESSION['user_hub_id']);
                foreach($hubPosts as $post){
                  if($post->user_id == $id){
                    $hubComments = $this->commentModel->getCommentsByPostId($post->postId);
                    foreach($hubComments as $comment){
                        $this->commentModel->deleteComment($comment->commentId);
                        // delete all comment activities
                        $commentActivities = $this->activityModel->getActivitiesByCommentId($comment->commentId);
                        foreach($commentActivities as $comment){
                          $this->activityModel->deleteActivity($comment->commentId);
                        }
                    }
                    $this->postModel->deletePost($post->postId);

                    $postActivities = $this->activityModel->getActivitiesByPostId($post->postId);
                    foreach($postActivities as $activity){
                      $this->activityModel->deleteActivity($activity->activityId);
                    }
                  }
                }

                // delete all user comments on other posts
                $commentData = [
                  'from_id' => $id,
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userComments = $this->commentModel->getUserCommentsByHubId($commentData);
                foreach($userComments as $comment){
                    $this->commentModel->deleteComment($comment->commentId);
                    // delete all comment activities
                    $commentActivities = $this->activityModel->getActivitiesByCommentId($comment->commentId);
                    foreach($commentActivities as $comment){
                      $this->activityModel->deleteActivity($comment->commentId);
                    }
                }

                // delete all user messages in that Hub
                $messagesData = [
                  'id' => $id,
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userMessages = $this->messageModel->getMessages($messagesData);

                foreach($userMessages as $message){
                  $this->messageModel->deleteMessage($message->messageId);
                }

                $hubmates = $this->userModel->getHubmates($_SESSION['user_hub_id']);
                foreach($hubmates as $mate){
                  if($mate->userId != $id){
                    // update hubs activity
                    $activityData = [
                      'hub_id' => $_SESSION['user_hub_id'],
                      'hub' => $_SESSION['user_hub'],
                      'user_id' => $id,
                      'user' => $user->name . " " . $user->last_name,
                      'to_id' => $mate->userId,
                      'type' => 'Remove',
                      'remover_id' => $_SESSION['user_id'],
                      'remover_name' => $_SESSION['user_name'],
                      'notify_user' => 0,
                      'created_new_hub' => 0,
                      'post_id' => 0,
                      'comment_id' => 0
                    ];

                    $this->activityModel->addRemoverActivity($activityData);
                  }
                }

                // update notify_user activity
                $activityData = [
                  'hub_id' => $_SESSION['user_hub_id'],
                  'hub' => $_SESSION['user_hub'],
                  'user_id' => $id,
                  'user' => $user->name . " " . $user->last_name,
                  'to_id' => 0,
                  'type' => 'Remove',
                  'remover_id' => $_SESSION['user_id'],
                  'remover_name' => $_SESSION['user_name'],
                  'notify_user' => $id,
                  'created_new_hub' => 0,
                  'post_id' => 0,
                  'comment_id' => 0
                ];

                $this->activityModel->addRemoverActivity($activityData);

                // check if the left Hub was their default and change if so to avoid complications on future sign ins
                if($user->hub_id == $_SESSION['user_hub_id']){
                  $newDefaultHub = $this->hubModel->getHubById($user->hub_5_id);
                  $data = [
                    'id' => $id,
                    'hub' => $newDefaultHub->name,
                    'hub_id' => $user->hub_5_id
                  ];

                  $this->userModel->updateUserDefaultHub($data);
                }

                errorFlash('success_message', 'Hubmate Removed');
                $_SESSION['flash_error_message'] = 'Hubmate Removed';
                redirect('users/profile/' . $id);
              } else {
                // delete all posts and comments made by the user in that Hub
                $hubPosts = $this->postModel->getPostsByHubId($_SESSION['user_hub_id']);
                foreach($hubPosts as $post){
                  if($post->user_id == $id){
                    $hubComments = $this->commentModel->getCommentsByPostId($post->postId);
                    foreach($hubComments as $comment){
                        $this->commentModel->deleteComment($comment->commentId);
                        // delete all comment activities
                        $commentActivities = $this->activityModel->getActivitiesByCommentId($comment->commentId);
                        foreach($commentActivities as $comment){
                          $this->activityModel->deleteActivity($comment->commentId);
                        }
                    }
                    $this->postModel->deletePost($post->postId);

                    $postActivities = $this->activityModel->getActivitiesByPostId($post->postId);
                    foreach($postActivities as $activity){
                      $this->activityModel->deleteActivity($activity->activityId);
                    }
                  }
                }

                // delete all user comments on other posts
                $commentData = [
                  'from_id' => $id,
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userComments = $this->commentModel->getUserCommentsByHubId($commentData);
                foreach($userComments as $comment){
                    $this->commentModel->deleteComment($comment->commentId);
                    // delete all comment activities
                    $commentActivities = $this->activityModel->getActivitiesByCommentId($comment->commentId);
                    foreach($commentActivities as $comment){
                      $this->activityModel->deleteActivity($comment->commentId);
                    }
                }

                // delete all user messages in that Hub
                $messagesData = [
                  'id' => $id,
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userMessages = $this->messageModel->getMessages($messagesData);

                foreach($userMessages as $message){
                  $this->messageModel->deleteMessage($message->messageId);
                }

                // this is the users only Hub, so create new
                $date = [
                  'hubname' => 'New'
                ];

                $newHubId = $this->hubModel->addHub($date);

                $hub1Data = [
                  'id' => $id,
                  'hub_id' => $newHubId
                ];
                $this->userModel->updateHub1($hub1Data);

                $data = [
                  'id' => $id,
                  'hub' => 'New',
                  'hub_id' => $newHubId
                ];

                $this->userModel->updateUserDefaultHub($data);

                $hubmates = $this->userModel->getHubmates($_SESSION['user_hub_id']);
                foreach($hubmates as $mate){
                  if($mate->userId != $id){
                    // update hubs activity
                    $activityData = [
                      'hub_id' => $_SESSION['user_hub_id'],
                      'hub' => $_SESSION['user_hub'],
                      'user_id' => $id,
                      'user' => $user->name . " " . $user->last_name,
                      'to_id' => $mate->userId,
                      'type' => 'Remove',
                      'remover_id' => $_SESSION['user_id'],
                      'remover_name' => $_SESSION['user_name'],
                      'notify_user' => 0,
                      'created_new_hub' => $newHubId,
                      'post_id' => 0,
                      'comment_id' => 0
                    ];

                    $this->activityModel->addRemoverActivity($activityData);
                  }
                }

                // update notify_user activity
                $activityData = [
                  'hub_id' => $_SESSION['user_hub_id'],
                  'hub' => $_SESSION['user_hub'],
                  'user_id' => $id,
                  'user' => $user->name . " " . $user->last_name,
                  'to_id' => 0,
                  'type' => 'Remove',
                  'remover_id' => $_SESSION['user_id'],
                  'remover_name' => $_SESSION['user_name'],
                  'notify_user' => $id,
                  'created_new_hub' => $newHubId,
                  'post_id' => 0,
                  'comment_id' => 0
                ];

                $this->activityModel->addRemoverActivity($activityData);

                errorFlash('success_message', 'Hubmate Removed');
                $_SESSION['flash_error_message'] = 'Hubmate Removed';
                redirect('users/profile/' . $id);
              }
            } else {
              die('Oops! Something went wrong');
            }
          } elseif($user->hub_2_id == $_SESSION['user_hub_id']){
            if($this->userModel->updateHub2($data)){
              if($user->hub_1_id != 0){
                // delete all posts and comments made by the user in that Hub
                $hubPosts = $this->postModel->getPostsByHubId($_SESSION['user_hub_id']);
                foreach($hubPosts as $post){
                  if($post->user_id == $id){
                    $hubComments = $this->commentModel->getCommentsByPostId($post->postId);
                    foreach($hubComments as $comment){
                        $this->commentModel->deleteComment($comment->commentId);
                        // delete all comment activities
                        $commentActivities = $this->activityModel->getActivitiesByCommentId($comment->commentId);
                        foreach($commentActivities as $comment){
                          $this->activityModel->deleteActivity($comment->commentId);
                        }
                    }
                    $this->postModel->deletePost($post->postId);

                    $postActivities = $this->activityModel->getActivitiesByPostId($post->postId);
                    foreach($postActivities as $activity){
                      $this->activityModel->deleteActivity($activity->activityId);
                    }
                  }
                }

                // delete all user comments on other posts
                $commentData = [
                  'from_id' => $id,
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userComments = $this->commentModel->getUserCommentsByHubId($commentData);
                foreach($userComments as $comment){
                    $this->commentModel->deleteComment($comment->commentId);
                    // delete all comment activities
                    $commentActivities = $this->activityModel->getActivitiesByCommentId($comment->commentId);
                    foreach($commentActivities as $comment){
                      $this->activityModel->deleteActivity($comment->commentId);
                    }
                }

                // delete all user messages in that Hub
                $messagesData = [
                  'id' => $id,
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userMessages = $this->messageModel->getMessages($messagesData);

                foreach($userMessages as $message){
                  $this->messageModel->deleteMessage($message->messageId);
                }

                $hubmates = $this->userModel->getHubmates($_SESSION['user_hub_id']);
                foreach($hubmates as $mate){
                  if($mate->userId != $id){
                    // update hubs activity
                    $activityData = [
                      'hub_id' => $_SESSION['user_hub_id'],
                      'hub' => $_SESSION['user_hub'],
                      'user_id' => $id,
                      'user' => $user->name . " " . $user->last_name,
                      'to_id' => $mate->userId,
                      'type' => 'Remove',
                      'remover_id' => $_SESSION['user_id'],
                      'remover_name' => $_SESSION['user_name'],
                      'notify_user' => 0,
                      'created_new_hub' => 0,
                      'post_id' => 0,
                      'comment_id' => 0
                    ];

                    $this->activityModel->addRemoverActivity($activityData);
                  }
                }

                // update notify_user activity
                $activityData = [
                  'hub_id' => $_SESSION['user_hub_id'],
                  'hub' => $_SESSION['user_hub'],
                  'user_id' => $id,
                  'user' => $user->name . " " . $user->last_name,
                  'to_id' => 0,
                  'type' => 'Remove',
                  'remover_id' => $_SESSION['user_id'],
                  'remover_name' => $_SESSION['user_name'],
                  'notify_user' => $id,
                  'created_new_hub' => 0,
                  'post_id' => 0,
                  'comment_id' => 0
                ];

                $this->activityModel->addRemoverActivity($activityData);

                // check if the left Hub was their default and change if so to avoid complications on future sign ins
                if($user->hub_id == $_SESSION['user_hub_id']){
                  $newDefaultHub = $this->hubModel->getHubById($user->hub_1_id);
                  $data = [
                    'id' => $id,
                    'hub' => $newDefaultHub->name,
                    'hub_id' => $user->hub_1_id
                  ];

                  $this->userModel->updateUserDefaultHub($data);
                }

                errorFlash('success_message', 'Hubmate Removed');
                $_SESSION['flash_error_message'] = 'Hubmate Removed';
                redirect('users/profile/' . $id);
              } elseif($user->hub_3_id != 0){
                // delete all posts and comments made by the user in that Hub
                $hubPosts = $this->postModel->getPostsByHubId($_SESSION['user_hub_id']);
                foreach($hubPosts as $post){
                  if($post->user_id == $id){
                    $hubComments = $this->commentModel->getCommentsByPostId($post->postId);
                    foreach($hubComments as $comment){
                        $this->commentModel->deleteComment($comment->commentId);
                        // delete all comment activities
                        $commentActivities = $this->activityModel->getActivitiesByCommentId($comment->commentId);
                        foreach($commentActivities as $comment){
                          $this->activityModel->deleteActivity($comment->commentId);
                        }
                    }
                    $this->postModel->deletePost($post->postId);

                    $postActivities = $this->activityModel->getActivitiesByPostId($post->postId);
                    foreach($postActivities as $activity){
                      $this->activityModel->deleteActivity($activity->activityId);
                    }
                  }
                }

                // delete all user comments on other posts
                $commentData = [
                  'from_id' => $id,
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userComments = $this->commentModel->getUserCommentsByHubId($commentData);
                foreach($userComments as $comment){
                    $this->commentModel->deleteComment($comment->commentId);
                    // delete all comment activities
                    $commentActivities = $this->activityModel->getActivitiesByCommentId($comment->commentId);
                    foreach($commentActivities as $comment){
                      $this->activityModel->deleteActivity($comment->commentId);
                    }
                }

                // delete all user messages in that Hub
                $messagesData = [
                  'id' => $id,
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userMessages = $this->messageModel->getMessages($messagesData);

                foreach($userMessages as $message){
                  $this->messageModel->deleteMessage($message->messageId);
                }

                $hubmates = $this->userModel->getHubmates($_SESSION['user_hub_id']);
                foreach($hubmates as $mate){
                  if($mate->userId != $id){
                    // update hubs activity
                    $activityData = [
                      'hub_id' => $_SESSION['user_hub_id'],
                      'hub' => $_SESSION['user_hub'],
                      'user_id' => $id,
                      'user' => $user->name . " " . $user->last_name,
                      'to_id' => $mate->userId,
                      'type' => 'Remove',
                      'remover_id' => $_SESSION['user_id'],
                      'remover_name' => $_SESSION['user_name'],
                      'notify_user' => 0,
                      'created_new_hub' => 0,
                      'post_id' => 0,
                      'comment_id' => 0
                    ];

                    $this->activityModel->addRemoverActivity($activityData);
                  }
                }

                // update notify_user activity
                $activityData = [
                  'hub_id' => $_SESSION['user_hub_id'],
                  'hub' => $_SESSION['user_hub'],
                  'user_id' => $id,
                  'user' => $user->name . " " . $user->last_name,
                  'to_id' => 0,
                  'type' => 'Remove',
                  'remover_id' => $_SESSION['user_id'],
                  'remover_name' => $_SESSION['user_name'],
                  'notify_user' => $id,
                  'created_new_hub' => 0,
                  'post_id' => 0,
                  'comment_id' => 0
                ];

                $this->activityModel->addRemoverActivity($activityData);

                // check if the left Hub was their default and change if so to avoid complications on future sign ins
                if($user->hub_id == $_SESSION['user_hub_id']){
                  $newDefaultHub = $this->hubModel->getHubById($user->hub_3_id);
                  $data = [
                    'id' => $id,
                    'hub' => $newDefaultHub->name,
                    'hub_id' => $user->hub_3_id
                  ];

                  $this->userModel->updateUserDefaultHub($data);
                }

                errorFlash('success_message', 'Hubmate Removed');
                $_SESSION['flash_error_message'] = 'Hubmate Removed';
                redirect('users/profile/' . $id);
              } elseif($user->hub_4_id != 0){
                // delete all posts and comments made by the user in that Hub
                $hubPosts = $this->postModel->getPostsByHubId($_SESSION['user_hub_id']);
                foreach($hubPosts as $post){
                  if($post->user_id == $id){
                    $hubComments = $this->commentModel->getCommentsByPostId($post->postId);
                    foreach($hubComments as $comment){
                        $this->commentModel->deleteComment($comment->commentId);
                        // delete all comment activities
                        $commentActivities = $this->activityModel->getActivitiesByCommentId($comment->commentId);
                        foreach($commentActivities as $comment){
                          $this->activityModel->deleteActivity($comment->commentId);
                        }
                    }
                    $this->postModel->deletePost($post->postId);

                    $postActivities = $this->activityModel->getActivitiesByPostId($post->postId);
                    foreach($postActivities as $activity){
                      $this->activityModel->deleteActivity($activity->activityId);
                    }
                  }
                }

                // delete all user comments on other posts
                $commentData = [
                  'from_id' => $id,
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userComments = $this->commentModel->getUserCommentsByHubId($commentData);
                foreach($userComments as $comment){
                    $this->commentModel->deleteComment($comment->commentId);
                    // delete all comment activities
                    $commentActivities = $this->activityModel->getActivitiesByCommentId($comment->commentId);
                    foreach($commentActivities as $comment){
                      $this->activityModel->deleteActivity($comment->commentId);
                    }
                }

                // delete all user messages in that Hub
                $messagesData = [
                  'id' => $id,
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userMessages = $this->messageModel->getMessages($messagesData);

                foreach($userMessages as $message){
                  $this->messageModel->deleteMessage($message->messageId);
                }

                $hubmates = $this->userModel->getHubmates($_SESSION['user_hub_id']);
                foreach($hubmates as $mate){
                  if($mate->userId != $id){
                    // update hubs activity
                    $activityData = [
                      'hub_id' => $_SESSION['user_hub_id'],
                      'hub' => $_SESSION['user_hub'],
                      'user_id' => $id,
                      'user' => $user->name . " " . $user->last_name,
                      'to_id' => $mate->userId,
                      'type' => 'Remove',
                      'remover_id' => $_SESSION['user_id'],
                      'remover_name' => $_SESSION['user_name'],
                      'notify_user' => 0,
                      'created_new_hub' => 0,
                      'post_id' => 0,
                      'comment_id' => 0
                    ];

                    $this->activityModel->addRemoverActivity($activityData);
                  }
                }

                // update notify_user activity
                $activityData = [
                  'hub_id' => $_SESSION['user_hub_id'],
                  'hub' => $_SESSION['user_hub'],
                  'user_id' => $id,
                  'user' => $user->name . " " . $user->last_name,
                  'to_id' => 0,
                  'type' => 'Remove',
                  'remover_id' => $_SESSION['user_id'],
                  'remover_name' => $_SESSION['user_name'],
                  'notify_user' => $id,
                  'created_new_hub' => 0,
                  'post_id' => 0,
                  'comment_id' => 0
                ];

                $this->activityModel->addRemoverActivity($activityData);

                // check if the left Hub was their default and change if so to avoid complications on future sign ins
                if($user->hub_id == $_SESSION['user_hub_id']){
                  $newDefaultHub = $this->hubModel->getHubById($user->hub_4_id);
                  $data = [
                    'id' => $id,
                    'hub' => $newDefaultHub->name,
                    'hub_id' => $user->hub_4_id
                  ];

                  $this->userModel->updateUserDefaultHub($data);
                }

                errorFlash('success_message', 'Hubmate Removed');
                $_SESSION['flash_error_message'] = 'Hubmate Removed';
                redirect('users/profile/' . $id);
              } elseif($user->hub_5_id != 0){
                // delete all posts and comments made by the user in that Hub
                $hubPosts = $this->postModel->getPostsByHubId($_SESSION['user_hub_id']);
                foreach($hubPosts as $post){
                  if($post->user_id == $id){
                    $hubComments = $this->commentModel->getCommentsByPostId($post->postId);
                    foreach($hubComments as $comment){
                        $this->commentModel->deleteComment($comment->commentId);
                        // delete all comment activities
                        $commentActivities = $this->activityModel->getActivitiesByCommentId($comment->commentId);
                        foreach($commentActivities as $comment){
                          $this->activityModel->deleteActivity($comment->commentId);
                        }
                    }
                    $this->postModel->deletePost($post->postId);

                    $postActivities = $this->activityModel->getActivitiesByPostId($post->postId);
                    foreach($postActivities as $activity){
                      $this->activityModel->deleteActivity($activity->activityId);
                    }
                  }
                }

                // delete all user comments on other posts
                $commentData = [
                  'from_id' => $id,
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userComments = $this->commentModel->getUserCommentsByHubId($commentData);
                foreach($userComments as $comment){
                    $this->commentModel->deleteComment($comment->commentId);
                    // delete all comment activities
                    $commentActivities = $this->activityModel->getActivitiesByCommentId($comment->commentId);
                    foreach($commentActivities as $comment){
                      $this->activityModel->deleteActivity($comment->commentId);
                    }
                }

                // delete all user messages in that Hub
                $messagesData = [
                  'id' => $id,
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userMessages = $this->messageModel->getMessages($messagesData);

                foreach($userMessages as $message){
                  $this->messageModel->deleteMessage($message->messageId);
                }

                $hubmates = $this->userModel->getHubmates($_SESSION['user_hub_id']);
                foreach($hubmates as $mate){
                  if($mate->userId != $id){
                    // update hubs activity
                    $activityData = [
                      'hub_id' => $_SESSION['user_hub_id'],
                      'hub' => $_SESSION['user_hub'],
                      'user_id' => $id,
                      'user' => $user->name . " " . $user->last_name,
                      'to_id' => $mate->userId,
                      'type' => 'Remove',
                      'remover_id' => $_SESSION['user_id'],
                      'remover_name' => $_SESSION['user_name'],
                      'notify_user' => 0,
                      'created_new_hub' => 0,
                      'post_id' => 0,
                      'comment_id' => 0
                    ];

                    $this->activityModel->addRemoverActivity($activityData);
                  }
                }

                // update notify_user activity
                $activityData = [
                  'hub_id' => $_SESSION['user_hub_id'],
                  'hub' => $_SESSION['user_hub'],
                  'user_id' => $id,
                  'user' => $user->name . " " . $user->last_name,
                  'to_id' => 0,
                  'type' => 'Remove',
                  'remover_id' => $_SESSION['user_id'],
                  'remover_name' => $_SESSION['user_name'],
                  'notify_user' => $id,
                  'created_new_hub' => 0,
                  'post_id' => 0,
                  'comment_id' => 0
                ];

                $this->activityModel->addRemoverActivity($activityData);

                // check if the left Hub was their default and change if so to avoid complications on future sign ins
                if($user->hub_id == $_SESSION['user_hub_id']){
                  $newDefaultHub = $this->hubModel->getHubById($user->hub_5_id);
                  $data = [
                    'id' => $id,
                    'hub' => $newDefaultHub->name,
                    'hub_id' => $user->hub_5_id
                  ];

                  $this->userModel->updateUserDefaultHub($data);
                }

                errorFlash('success_message', 'Hubmate Removed');
                $_SESSION['flash_error_message'] = 'Hubmate Removed';
                redirect('users/profile/' . $id);
              } else {
                // delete all posts and comments made by the user in that Hub
                $hubPosts = $this->postModel->getPostsByHubId($_SESSION['user_hub_id']);
                foreach($hubPosts as $post){
                  if($post->user_id == $id){
                    $hubComments = $this->commentModel->getCommentsByPostId($post->postId);
                    foreach($hubComments as $comment){
                        $this->commentModel->deleteComment($comment->commentId);
                        // delete all comment activities
                        $commentActivities = $this->activityModel->getActivitiesByCommentId($comment->commentId);
                        foreach($commentActivities as $comment){
                          $this->activityModel->deleteActivity($comment->commentId);
                        }
                    }
                    $this->postModel->deletePost($post->postId);

                    $postActivities = $this->activityModel->getActivitiesByPostId($post->postId);
                    foreach($postActivities as $activity){
                      $this->activityModel->deleteActivity($activity->activityId);
                    }
                  }
                }

                // delete all user comments on other posts
                $commentData = [
                  'from_id' => $id,
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userComments = $this->commentModel->getUserCommentsByHubId($commentData);
                foreach($userComments as $comment){
                    $this->commentModel->deleteComment($comment->commentId);
                    // delete all comment activities
                    $commentActivities = $this->activityModel->getActivitiesByCommentId($comment->commentId);
                    foreach($commentActivities as $comment){
                      $this->activityModel->deleteActivity($comment->commentId);
                    }
                }

                // delete all user messages in that Hub
                $messagesData = [
                  'id' => $id,
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userMessages = $this->messageModel->getMessages($messagesData);

                foreach($userMessages as $message){
                  $this->messageModel->deleteMessage($message->messageId);
                }

                // this is the users only Hub, so create new
                $date = [
                  'hubname' => 'New'
                ];

                $newHubId = $this->hubModel->addHub($date);

                $hub1Data = [
                  'id' => $id,
                  'hub_id' => $newHubId
                ];
                $this->userModel->updateHub1($hub1Data);

                $data = [
                  'id' => $id,
                  'hub' => 'New',
                  'hub_id' => $newHubId
                ];

                $this->userModel->updateUserDefaultHub($data);

                $hubmates = $this->userModel->getHubmates($_SESSION['user_hub_id']);
                foreach($hubmates as $mate){
                  if($mate->userId != $id){
                    // update hubs activity
                    $activityData = [
                      'hub_id' => $_SESSION['user_hub_id'],
                      'hub' => $_SESSION['user_hub'],
                      'user_id' => $id,
                      'user' => $user->name . " " . $user->last_name,
                      'to_id' => $mate->userId,
                      'type' => 'Remove',
                      'remover_id' => $_SESSION['user_id'],
                      'remover_name' => $_SESSION['user_name'],
                      'notify_user' => 0,
                      'created_new_hub' => $newHubId,
                      'post_id' => 0,
                      'comment_id' => 0
                    ];

                    $this->activityModel->addRemoverActivity($activityData);
                  }
                }

                // update notify_user activity
                $activityData = [
                  'hub_id' => $_SESSION['user_hub_id'],
                  'hub' => $_SESSION['user_hub'],
                  'user_id' => $id,
                  'user' => $user->name . " " . $user->last_name,
                  'to_id' => 0,
                  'type' => 'Remove',
                  'remover_id' => $_SESSION['user_id'],
                  'remover_name' => $_SESSION['user_name'],
                  'notify_user' => $id,
                  'created_new_hub' => $newHubId,
                  'post_id' => 0,
                  'comment_id' => 0
                ];

                $this->activityModel->addRemoverActivity($activityData);

                errorFlash('success_message', 'Hubmate Removed');
                $_SESSION['flash_error_message'] = 'Hubmate Removed';
                redirect('users/profile/' . $id);
              }
            } else {
              die('Oops! Something went wrong');
            }
          } elseif($user->hub_3_id == $_SESSION['user_hub_id']){
            if($this->userModel->updateHub3($data)){
              if($user->hub_1_id != 0){
                // delete all posts and comments made by the user in that Hub
                $hubPosts = $this->postModel->getPostsByHubId($_SESSION['user_hub_id']);
                foreach($hubPosts as $post){
                  if($post->user_id == $id){
                    $hubComments = $this->commentModel->getCommentsByPostId($post->postId);
                    foreach($hubComments as $comment){
                        $this->commentModel->deleteComment($comment->commentId);
                        // delete all comment activities
                        $commentActivities = $this->activityModel->getActivitiesByCommentId($comment->commentId);
                        foreach($commentActivities as $comment){
                          $this->activityModel->deleteActivity($comment->commentId);
                        }
                    }
                    $this->postModel->deletePost($post->postId);

                    $postActivities = $this->activityModel->getActivitiesByPostId($post->postId);
                    foreach($postActivities as $activity){
                      $this->activityModel->deleteActivity($activity->activityId);
                    }
                  }
                }

                // delete all user comments on other posts
                $commentData = [
                  'from_id' => $id,
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userComments = $this->commentModel->getUserCommentsByHubId($commentData);
                foreach($userComments as $comment){
                    $this->commentModel->deleteComment($comment->commentId);
                    // delete all comment activities
                    $commentActivities = $this->activityModel->getActivitiesByCommentId($comment->commentId);
                    foreach($commentActivities as $comment){
                      $this->activityModel->deleteActivity($comment->commentId);
                    }
                }

                // delete all user messages in that Hub
                $messagesData = [
                  'id' => $id,
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userMessages = $this->messageModel->getMessages($messagesData);

                foreach($userMessages as $message){
                  $this->messageModel->deleteMessage($message->messageId);
                }

                $hubmates = $this->userModel->getHubmates($_SESSION['user_hub_id']);
                foreach($hubmates as $mate){
                  if($mate->userId != $id){
                    // update hubs activity
                    $activityData = [
                      'hub_id' => $_SESSION['user_hub_id'],
                      'hub' => $_SESSION['user_hub'],
                      'user_id' => $id,
                      'user' => $user->name . " " . $user->last_name,
                      'to_id' => $mate->userId,
                      'type' => 'Remove',
                      'remover_id' => $_SESSION['user_id'],
                      'remover_name' => $_SESSION['user_name'],
                      'notify_user' => 0,
                      'created_new_hub' => 0,
                      'post_id' => 0,
                      'comment_id' => 0
                    ];

                    $this->activityModel->addRemoverActivity($activityData);
                  }
                }

                // update notify_user activity
                $activityData = [
                  'hub_id' => $_SESSION['user_hub_id'],
                  'hub' => $_SESSION['user_hub'],
                  'user_id' => $id,
                  'user' => $user->name . " " . $user->last_name,
                  'to_id' => 0,
                  'type' => 'Remove',
                  'remover_id' => $_SESSION['user_id'],
                  'remover_name' => $_SESSION['user_name'],
                  'notify_user' => $id,
                  'created_new_hub' => 0,
                  'post_id' => 0,
                  'comment_id' => 0
                ];

                $this->activityModel->addRemoverActivity($activityData);

                // check if the left Hub was their default and change if so to avoid complications on future sign ins
                if($user->hub_id == $_SESSION['user_hub_id']){
                  $newDefaultHub = $this->hubModel->getHubById($user->hub_1_id);
                  $data = [
                    'id' => $id,
                    'hub' => $newDefaultHub->name,
                    'hub_id' => $user->hub_1_id
                  ];

                  $this->userModel->updateUserDefaultHub($data);
                }

                errorFlash('success_message', 'Hubmate Removed');
                $_SESSION['flash_error_message'] = 'Hubmate Removed';
                redirect('users/profile/' . $id);
              } elseif($user->hub_2_id != 0){
                // delete all posts and comments made by the user in that Hub
                $hubPosts = $this->postModel->getPostsByHubId($_SESSION['user_hub_id']);
                foreach($hubPosts as $post){
                  if($post->user_id == $id){
                    $hubComments = $this->commentModel->getCommentsByPostId($post->postId);
                    foreach($hubComments as $comment){
                        $this->commentModel->deleteComment($comment->commentId);
                        // delete all comment activities
                        $commentActivities = $this->activityModel->getActivitiesByCommentId($comment->commentId);
                        foreach($commentActivities as $comment){
                          $this->activityModel->deleteActivity($comment->commentId);
                        }
                    }
                    $this->postModel->deletePost($post->postId);

                    $postActivities = $this->activityModel->getActivitiesByPostId($post->postId);
                    foreach($postActivities as $activity){
                      $this->activityModel->deleteActivity($activity->activityId);
                    }
                  }
                }

                // delete all user comments on other posts
                $commentData = [
                  'from_id' => $id,
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userComments = $this->commentModel->getUserCommentsByHubId($commentData);
                foreach($userComments as $comment){
                    $this->commentModel->deleteComment($comment->commentId);
                    // delete all comment activities
                    $commentActivities = $this->activityModel->getActivitiesByCommentId($comment->commentId);
                    foreach($commentActivities as $comment){
                      $this->activityModel->deleteActivity($comment->commentId);
                    }
                }

                // delete all user messages in that Hub
                $messagesData = [
                  'id' => $id,
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userMessages = $this->messageModel->getMessages($messagesData);

                foreach($userMessages as $message){
                  $this->messageModel->deleteMessage($message->messageId);
                }

                $hubmates = $this->userModel->getHubmates($_SESSION['user_hub_id']);
                foreach($hubmates as $mate){
                  if($mate->userId != $id){
                    // update hubs activity
                    $activityData = [
                      'hub_id' => $_SESSION['user_hub_id'],
                      'hub' => $_SESSION['user_hub'],
                      'user_id' => $id,
                      'user' => $user->name . " " . $user->last_name,
                      'to_id' => $mate->userId,
                      'type' => 'Remove',
                      'remover_id' => $_SESSION['user_id'],
                      'remover_name' => $_SESSION['user_name'],
                      'notify_user' => 0,
                      'created_new_hub' => 0,
                      'post_id' => 0,
                      'comment_id' => 0
                    ];

                    $this->activityModel->addRemoverActivity($activityData);
                  }
                }

                // update notify_user activity
                $activityData = [
                  'hub_id' => $_SESSION['user_hub_id'],
                  'hub' => $_SESSION['user_hub'],
                  'user_id' => $id,
                  'user' => $user->name . " " . $user->last_name,
                  'to_id' => 0,
                  'type' => 'Remove',
                  'remover_id' => $_SESSION['user_id'],
                  'remover_name' => $_SESSION['user_name'],
                  'notify_user' => $id,
                  'created_new_hub' => 0,
                  'post_id' => 0,
                  'comment_id' => 0
                ];

                $this->activityModel->addRemoverActivity($activityData);

                // check if the left Hub was their default and change if so to avoid complications on future sign ins
                if($user->hub_id == $_SESSION['user_hub_id']){
                  $newDefaultHub = $this->hubModel->getHubById($user->hub_2_id);
                  $data = [
                    'id' => $id,
                    'hub' => $newDefaultHub->name,
                    'hub_id' => $user->hub_2_id
                  ];

                  $this->userModel->updateUserDefaultHub($data);
                }

                errorFlash('success_message', 'Hubmate Removed');
                $_SESSION['flash_error_message'] = 'Hubmate Removed';
                redirect('users/profile/' . $id);
              } elseif($user->hub_4_id != 0){
                // delete all posts and comments made by the user in that Hub
                $hubPosts = $this->postModel->getPostsByHubId($_SESSION['user_hub_id']);
                foreach($hubPosts as $post){
                  if($post->user_id == $id){
                    $hubComments = $this->commentModel->getCommentsByPostId($post->postId);
                    foreach($hubComments as $comment){
                        $this->commentModel->deleteComment($comment->commentId);
                        // delete all comment activities
                        $commentActivities = $this->activityModel->getActivitiesByCommentId($comment->commentId);
                        foreach($commentActivities as $comment){
                          $this->activityModel->deleteActivity($comment->commentId);
                        }
                    }
                    $this->postModel->deletePost($post->postId);

                    $postActivities = $this->activityModel->getActivitiesByPostId($post->postId);
                    foreach($postActivities as $activity){
                      $this->activityModel->deleteActivity($activity->activityId);
                    }
                  }
                }

                // delete all user comments on other posts
                $commentData = [
                  'from_id' => $id,
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userComments = $this->commentModel->getUserCommentsByHubId($commentData);
                foreach($userComments as $comment){
                    $this->commentModel->deleteComment($comment->commentId);
                    // delete all comment activities
                    $commentActivities = $this->activityModel->getActivitiesByCommentId($comment->commentId);
                    foreach($commentActivities as $comment){
                      $this->activityModel->deleteActivity($comment->commentId);
                    }
                }

                // delete all user messages in that Hub
                $messagesData = [
                  'id' => $id,
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userMessages = $this->messageModel->getMessages($messagesData);

                foreach($userMessages as $message){
                  $this->messageModel->deleteMessage($message->messageId);
                }

                $hubmates = $this->userModel->getHubmates($_SESSION['user_hub_id']);
                foreach($hubmates as $mate){
                  if($mate->userId != $id){
                    // update hubs activity
                    $activityData = [
                      'hub_id' => $_SESSION['user_hub_id'],
                      'hub' => $_SESSION['user_hub'],
                      'user_id' => $id,
                      'user' => $user->name . " " . $user->last_name,
                      'to_id' => $mate->userId,
                      'type' => 'Remove',
                      'remover_id' => $_SESSION['user_id'],
                      'remover_name' => $_SESSION['user_name'],
                      'notify_user' => 0,
                      'created_new_hub' => 0,
                      'post_id' => 0,
                      'comment_id' => 0
                    ];

                    $this->activityModel->addRemoverActivity($activityData);
                  }
                }

                // update notify_user activity
                $activityData = [
                  'hub_id' => $_SESSION['user_hub_id'],
                  'hub' => $_SESSION['user_hub'],
                  'user_id' => $id,
                  'user' => $user->name . " " . $user->last_name,
                  'to_id' => 0,
                  'type' => 'Remove',
                  'remover_id' => $_SESSION['user_id'],
                  'remover_name' => $_SESSION['user_name'],
                  'notify_user' => $id,
                  'created_new_hub' => 0,
                  'post_id' => 0,
                  'comment_id' => 0
                ];

                $this->activityModel->addRemoverActivity($activityData);

                // check if the left Hub was their default and change if so to avoid complications on future sign ins
                if($user->hub_id == $_SESSION['user_hub_id']){
                  $newDefaultHub = $this->hubModel->getHubById($user->hub_4_id);
                  $data = [
                    'id' => $id,
                    'hub' => $newDefaultHub->name,
                    'hub_id' => $user->hub_4_id
                  ];

                  $this->userModel->updateUserDefaultHub($data);
                }

                errorFlash('success_message', 'Hubmate Removed');
                $_SESSION['flash_error_message'] = 'Hubmate Removed';
                redirect('users/profile/' . $id);
              } elseif($user->hub_5_id != 0){
                // delete all posts and comments made by the user in that Hub
                $hubPosts = $this->postModel->getPostsByHubId($_SESSION['user_hub_id']);
                foreach($hubPosts as $post){
                  if($post->user_id == $id){
                    $hubComments = $this->commentModel->getCommentsByPostId($post->postId);
                    foreach($hubComments as $comment){
                        $this->commentModel->deleteComment($comment->commentId);
                        // delete all comment activities
                        $commentActivities = $this->activityModel->getActivitiesByCommentId($comment->commentId);
                        foreach($commentActivities as $comment){
                          $this->activityModel->deleteActivity($comment->commentId);
                        }
                    }
                    $this->postModel->deletePost($post->postId);

                    $postActivities = $this->activityModel->getActivitiesByPostId($post->postId);
                    foreach($postActivities as $activity){
                      $this->activityModel->deleteActivity($activity->activityId);
                    }
                  }
                }

                // delete all user comments on other posts
                $commentData = [
                  'from_id' => $id,
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userComments = $this->commentModel->getUserCommentsByHubId($commentData);
                foreach($userComments as $comment){
                    $this->commentModel->deleteComment($comment->commentId);
                    // delete all comment activities
                    $commentActivities = $this->activityModel->getActivitiesByCommentId($comment->commentId);
                    foreach($commentActivities as $comment){
                      $this->activityModel->deleteActivity($comment->commentId);
                    }
                }

                // delete all user messages in that Hub
                $messagesData = [
                  'id' => $id,
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userMessages = $this->messageModel->getMessages($messagesData);

                foreach($userMessages as $message){
                  $this->messageModel->deleteMessage($message->messageId);
                }

                $hubmates = $this->userModel->getHubmates($_SESSION['user_hub_id']);
                foreach($hubmates as $mate){
                  if($mate->userId != $id){
                    // update hubs activity
                    $activityData = [
                      'hub_id' => $_SESSION['user_hub_id'],
                      'hub' => $_SESSION['user_hub'],
                      'user_id' => $id,
                      'user' => $user->name . " " . $user->last_name,
                      'to_id' => $mate->userId,
                      'type' => 'Remove',
                      'remover_id' => $_SESSION['user_id'],
                      'remover_name' => $_SESSION['user_name'],
                      'notify_user' => 0,
                      'created_new_hub' => 0,
                      'post_id' => 0,
                      'comment_id' => 0
                    ];

                    $this->activityModel->addRemoverActivity($activityData);
                  }
                }

                // update notify_user activity
                $activityData = [
                  'hub_id' => $_SESSION['user_hub_id'],
                  'hub' => $_SESSION['user_hub'],
                  'user_id' => $id,
                  'user' => $user->name . " " . $user->last_name,
                  'to_id' => 0,
                  'type' => 'Remove',
                  'remover_id' => $_SESSION['user_id'],
                  'remover_name' => $_SESSION['user_name'],
                  'notify_user' => $id,
                  'created_new_hub' => 0,
                  'post_id' => 0,
                  'comment_id' => 0
                ];

                $this->activityModel->addRemoverActivity($activityData);

                // check if the left Hub was their default and change if so to avoid complications on future sign ins
                if($user->hub_id == $_SESSION['user_hub_id']){
                  $newDefaultHub = $this->hubModel->getHubById($user->hub_5_id);
                  $data = [
                    'id' => $id,
                    'hub' => $newDefaultHub->name,
                    'hub_id' => $user->hub_5_id
                  ];

                  $this->userModel->updateUserDefaultHub($data);
                }

                errorFlash('success_message', 'Hubmate Removed');
                $_SESSION['flash_error_message'] = 'Hubmate Removed';
                redirect('users/profile/' . $id);
              } else {
                // delete all posts and comments made by the user in that Hub
                $hubPosts = $this->postModel->getPostsByHubId($_SESSION['user_hub_id']);
                foreach($hubPosts as $post){
                  if($post->user_id == $id){
                    $hubComments = $this->commentModel->getCommentsByPostId($post->postId);
                    foreach($hubComments as $comment){
                        $this->commentModel->deleteComment($comment->commentId);
                        // delete all comment activities
                        $commentActivities = $this->activityModel->getActivitiesByCommentId($comment->commentId);
                        foreach($commentActivities as $comment){
                          $this->activityModel->deleteActivity($comment->commentId);
                        }
                    }
                    $this->postModel->deletePost($post->postId);

                    $postActivities = $this->activityModel->getActivitiesByPostId($post->postId);
                    foreach($postActivities as $activity){
                      $this->activityModel->deleteActivity($activity->activityId);
                    }
                  }
                }

                // delete all user comments on other posts
                $commentData = [
                  'from_id' => $id,
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userComments = $this->commentModel->getUserCommentsByHubId($commentData);
                foreach($userComments as $comment){
                    $this->commentModel->deleteComment($comment->commentId);
                    // delete all comment activities
                    $commentActivities = $this->activityModel->getActivitiesByCommentId($comment->commentId);
                    foreach($commentActivities as $comment){
                      $this->activityModel->deleteActivity($comment->commentId);
                    }
                }

                // delete all user messages in that Hub
                $messagesData = [
                  'id' => $id,
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userMessages = $this->messageModel->getMessages($messagesData);

                foreach($userMessages as $message){
                  $this->messageModel->deleteMessage($message->messageId);
                }

                // this is the users only Hub, so create new
                $date = [
                  'hubname' => 'New'
                ];

                $newHubId = $this->hubModel->addHub($date);

                $hub1Data = [
                  'id' => $id,
                  'hub_id' => $newHubId
                ];
                $this->userModel->updateHub1($hub1Data);

                $data = [
                  'id' => $id,
                  'hub' => 'New',
                  'hub_id' => $newHubId
                ];

                $this->userModel->updateUserDefaultHub($data);

                $hubmates = $this->userModel->getHubmates($_SESSION['user_hub_id']);
                foreach($hubmates as $mate){
                  if($mate->userId != $id){
                    // update hubs activity
                    $activityData = [
                      'hub_id' => $_SESSION['user_hub_id'],
                      'hub' => $_SESSION['user_hub'],
                      'user_id' => $id,
                      'user' => $user->name . " " . $user->last_name,
                      'to_id' => $mate->userId,
                      'type' => 'Remove',
                      'remover_id' => $_SESSION['user_id'],
                      'remover_name' => $_SESSION['user_name'],
                      'notify_user' => 0,
                      'created_new_hub' => $newHubId,
                      'post_id' => 0,
                      'comment_id' => 0
                    ];

                    $this->activityModel->addRemoverActivity($activityData);
                  }
                }

                // update notify_user activity
                $activityData = [
                  'hub_id' => $_SESSION['user_hub_id'],
                  'hub' => $_SESSION['user_hub'],
                  'user_id' => $id,
                  'user' => $user->name . " " . $user->last_name,
                  'to_id' => 0,
                  'type' => 'Remove',
                  'remover_id' => $_SESSION['user_id'],
                  'remover_name' => $_SESSION['user_name'],
                  'notify_user' => $id,
                  'created_new_hub' => $newHubId,
                  'post_id' => 0,
                  'comment_id' => 0
                ];

                $this->activityModel->addRemoverActivity($activityData);

                errorFlash('success_message', 'Hubmate Removed');
                $_SESSION['flash_error_message'] = 'Hubmate Removed';
                redirect('users/profile/' . $id);
              }
            } else {
              die('Oops! Something went wrong');
            }
          } elseif($user->hub_4_id == $_SESSION['user_hub_id']){
            if($this->userModel->updateHub4($data)){
              if($user->hub_1_id != 0){
                // delete all posts and comments made by the user in that Hub
                $hubPosts = $this->postModel->getPostsByHubId($_SESSION['user_hub_id']);
                foreach($hubPosts as $post){
                  if($post->user_id == $id){
                    $hubComments = $this->commentModel->getCommentsByPostId($post->postId);
                    foreach($hubComments as $comment){
                        $this->commentModel->deleteComment($comment->commentId);
                        // delete all comment activities
                        $commentActivities = $this->activityModel->getActivitiesByCommentId($comment->commentId);
                        foreach($commentActivities as $comment){
                          $this->activityModel->deleteActivity($comment->commentId);
                        }
                    }
                    $this->postModel->deletePost($post->postId);

                    $postActivities = $this->activityModel->getActivitiesByPostId($post->postId);
                    foreach($postActivities as $activity){
                      $this->activityModel->deleteActivity($activity->activityId);
                    }
                  }
                }

                // delete all user comments on other posts
                $commentData = [
                  'from_id' => $id,
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userComments = $this->commentModel->getUserCommentsByHubId($commentData);
                foreach($userComments as $comment){
                    $this->commentModel->deleteComment($comment->commentId);
                    // delete all comment activities
                    $commentActivities = $this->activityModel->getActivitiesByCommentId($comment->commentId);
                    foreach($commentActivities as $comment){
                      $this->activityModel->deleteActivity($comment->commentId);
                    }
                }

                // delete all user messages in that Hub
                $messagesData = [
                  'id' => $id,
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userMessages = $this->messageModel->getMessages($messagesData);

                foreach($userMessages as $message){
                  $this->messageModel->deleteMessage($message->messageId);
                }

                $hubmates = $this->userModel->getHubmates($_SESSION['user_hub_id']);
                foreach($hubmates as $mate){
                  if($mate->userId != $id){
                    // update hubs activity
                    $activityData = [
                      'hub_id' => $_SESSION['user_hub_id'],
                      'hub' => $_SESSION['user_hub'],
                      'user_id' => $id,
                      'user' => $user->name . " " . $user->last_name,
                      'to_id' => $mate->userId,
                      'type' => 'Remove',
                      'remover_id' => $_SESSION['user_id'],
                      'remover_name' => $_SESSION['user_name'],
                      'notify_user' => 0,
                      'created_new_hub' => 0,
                      'post_id' => 0,
                      'comment_id' => 0
                    ];

                    $this->activityModel->addRemoverActivity($activityData);
                  }
                }

                // update notify_user activity
                $activityData = [
                  'hub_id' => $_SESSION['user_hub_id'],
                  'hub' => $_SESSION['user_hub'],
                  'user_id' => $id,
                  'user' => $user->name . " " . $user->last_name,
                  'to_id' => 0,
                  'type' => 'Remove',
                  'remover_id' => $_SESSION['user_id'],
                  'remover_name' => $_SESSION['user_name'],
                  'notify_user' => $id,
                  'created_new_hub' => 0,
                  'post_id' => 0,
                  'comment_id' => 0
                ];

                $this->activityModel->addRemoverActivity($activityData);

                // check if the left Hub was their default and change if so to avoid complications on future sign ins
                if($user->hub_id == $_SESSION['user_hub_id']){
                  $newDefaultHub = $this->hubModel->getHubById($user->hub_1_id);
                  $data = [
                    'id' => $id,
                    'hub' => $newDefaultHub->name,
                    'hub_id' => $user->hub_1_id
                  ];

                  $this->userModel->updateUserDefaultHub($data);
                }

                errorFlash('success_message', 'Hubmate Removed');
                $_SESSION['flash_error_message'] = 'Hubmate Removed';
                redirect('users/profile/' . $id);
              } elseif($user->hub_2_id != 0){
                // delete all posts and comments made by the user in that Hub
                $hubPosts = $this->postModel->getPostsByHubId($_SESSION['user_hub_id']);
                foreach($hubPosts as $post){
                  if($post->user_id == $id){
                    $hubComments = $this->commentModel->getCommentsByPostId($post->postId);
                    foreach($hubComments as $comment){
                        $this->commentModel->deleteComment($comment->commentId);
                        // delete all comment activities
                        $commentActivities = $this->activityModel->getActivitiesByCommentId($comment->commentId);
                        foreach($commentActivities as $comment){
                          $this->activityModel->deleteActivity($comment->commentId);
                        }
                    }
                    $this->postModel->deletePost($post->postId);

                    $postActivities = $this->activityModel->getActivitiesByPostId($post->postId);
                    foreach($postActivities as $activity){
                      $this->activityModel->deleteActivity($activity->activityId);
                    }
                  }
                }

                // delete all user comments on other posts
                $commentData = [
                  'from_id' => $id,
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userComments = $this->commentModel->getUserCommentsByHubId($commentData);
                foreach($userComments as $comment){
                    $this->commentModel->deleteComment($comment->commentId);
                    // delete all comment activities
                    $commentActivities = $this->activityModel->getActivitiesByCommentId($comment->commentId);
                    foreach($commentActivities as $comment){
                      $this->activityModel->deleteActivity($comment->commentId);
                    }
                }

                // delete all user messages in that Hub
                $messagesData = [
                  'id' => $id,
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userMessages = $this->messageModel->getMessages($messagesData);

                foreach($userMessages as $message){
                  $this->messageModel->deleteMessage($message->messageId);
                }

                $hubmates = $this->userModel->getHubmates($_SESSION['user_hub_id']);
                foreach($hubmates as $mate){
                  if($mate->userId != $id){
                    // update hubs activity
                    $activityData = [
                      'hub_id' => $_SESSION['user_hub_id'],
                      'hub' => $_SESSION['user_hub'],
                      'user_id' => $id,
                      'user' => $user->name . " " . $user->last_name,
                      'to_id' => $mate->userId,
                      'type' => 'Remove',
                      'remover_id' => $_SESSION['user_id'],
                      'remover_name' => $_SESSION['user_name'],
                      'notify_user' => 0,
                      'created_new_hub' => 0,
                      'post_id' => 0,
                      'comment_id' => 0
                    ];

                    $this->activityModel->addRemoverActivity($activityData);
                  }
                }

                // update notify_user activity
                $activityData = [
                  'hub_id' => $_SESSION['user_hub_id'],
                  'hub' => $_SESSION['user_hub'],
                  'user_id' => $id,
                  'user' => $user->name . " " . $user->last_name,
                  'to_id' => 0,
                  'type' => 'Remove',
                  'remover_id' => $_SESSION['user_id'],
                  'remover_name' => $_SESSION['user_name'],
                  'notify_user' => $id,
                  'created_new_hub' => 0,
                  'post_id' => 0,
                  'comment_id' => 0
                ];

                $this->activityModel->addRemoverActivity($activityData);

                // check if the left Hub was their default and change if so to avoid complications on future sign ins
                if($user->hub_id == $_SESSION['user_hub_id']){
                  $newDefaultHub = $this->hubModel->getHubById($user->hub_2_id);
                  $data = [
                    'id' => $id,
                    'hub' => $newDefaultHub->name,
                    'hub_id' => $user->hub_2_id
                  ];

                  $this->userModel->updateUserDefaultHub($data);
                }

                errorFlash('success_message', 'Hubmate Removed');
                $_SESSION['flash_error_message'] = 'Hubmate Removed';
                redirect('users/profile/' . $id);
              } elseif($user->hub_3_id != 0){
                // delete all posts and comments made by the user in that Hub
                $hubPosts = $this->postModel->getPostsByHubId($_SESSION['user_hub_id']);
                foreach($hubPosts as $post){
                  if($post->user_id == $id){
                    $hubComments = $this->commentModel->getCommentsByPostId($post->postId);
                    foreach($hubComments as $comment){
                        $this->commentModel->deleteComment($comment->commentId);
                        // delete all comment activities
                        $commentActivities = $this->activityModel->getActivitiesByCommentId($comment->commentId);
                        foreach($commentActivities as $comment){
                          $this->activityModel->deleteActivity($comment->commentId);
                        }
                    }
                    $this->postModel->deletePost($post->postId);

                    $postActivities = $this->activityModel->getActivitiesByPostId($post->postId);
                    foreach($postActivities as $activity){
                      $this->activityModel->deleteActivity($activity->activityId);
                    }
                  }
                }

                // delete all user comments on other posts
                $commentData = [
                  'from_id' => $id,
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userComments = $this->commentModel->getUserCommentsByHubId($commentData);
                foreach($userComments as $comment){
                    $this->commentModel->deleteComment($comment->commentId);
                    // delete all comment activities
                    $commentActivities = $this->activityModel->getActivitiesByCommentId($comment->commentId);
                    foreach($commentActivities as $comment){
                      $this->activityModel->deleteActivity($comment->commentId);
                    }
                }

                // delete all user messages in that Hub
                $messagesData = [
                  'id' => $id,
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userMessages = $this->messageModel->getMessages($messagesData);

                foreach($userMessages as $message){
                  $this->messageModel->deleteMessage($message->messageId);
                }

                $hubmates = $this->userModel->getHubmates($_SESSION['user_hub_id']);
                foreach($hubmates as $mate){
                  if($mate->userId != $id){
                    // update hubs activity
                    $activityData = [
                      'hub_id' => $_SESSION['user_hub_id'],
                      'hub' => $_SESSION['user_hub'],
                      'user_id' => $id,
                      'user' => $user->name . " " . $user->last_name,
                      'to_id' => $mate->userId,
                      'type' => 'Remove',
                      'remover_id' => $_SESSION['user_id'],
                      'remover_name' => $_SESSION['user_name'],
                      'notify_user' => 0,
                      'created_new_hub' => 0,
                      'post_id' => 0,
                      'comment_id' => 0
                    ];

                    $this->activityModel->addRemoverActivity($activityData);
                  }
                }

                // update notify_user activity
                $activityData = [
                  'hub_id' => $_SESSION['user_hub_id'],
                  'hub' => $_SESSION['user_hub'],
                  'user_id' => $id,
                  'user' => $user->name . " " . $user->last_name,
                  'to_id' => 0,
                  'type' => 'Remove',
                  'remover_id' => $_SESSION['user_id'],
                  'remover_name' => $_SESSION['user_name'],
                  'notify_user' => $id,
                  'created_new_hub' => 0,
                  'post_id' => 0,
                  'comment_id' => 0
                ];

                $this->activityModel->addRemoverActivity($activityData);

                // check if the left Hub was their default and change if so to avoid complications on future sign ins
                if($user->hub_id == $_SESSION['user_hub_id']){
                  $newDefaultHub = $this->hubModel->getHubById($user->hub_3_id);
                  $data = [
                    'id' => $id,
                    'hub' => $newDefaultHub->name,
                    'hub_id' => $user->hub_3_id
                  ];

                  $this->userModel->updateUserDefaultHub($data);
                }

                errorFlash('success_message', 'Hubmate Removed');
                $_SESSION['flash_error_message'] = 'Hubmate Removed';
                redirect('users/profile/' . $id);
              } elseif($user->hub_5_id != 0){
                // delete all posts and comments made by the user in that Hub
                $hubPosts = $this->postModel->getPostsByHubId($_SESSION['user_hub_id']);
                foreach($hubPosts as $post){
                  if($post->user_id == $id){
                    $hubComments = $this->commentModel->getCommentsByPostId($post->postId);
                    foreach($hubComments as $comment){
                        $this->commentModel->deleteComment($comment->commentId);
                        // delete all comment activities
                        $commentActivities = $this->activityModel->getActivitiesByCommentId($comment->commentId);
                        foreach($commentActivities as $comment){
                          $this->activityModel->deleteActivity($comment->commentId);
                        }
                    }
                    $this->postModel->deletePost($post->postId);

                    $postActivities = $this->activityModel->getActivitiesByPostId($post->postId);
                    foreach($postActivities as $activity){
                      $this->activityModel->deleteActivity($activity->activityId);
                    }
                  }
                }

                // delete all user comments on other posts
                $commentData = [
                  'from_id' => $id,
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userComments = $this->commentModel->getUserCommentsByHubId($commentData);
                foreach($userComments as $comment){
                    $this->commentModel->deleteComment($comment->commentId);
                    // delete all comment activities
                    $commentActivities = $this->activityModel->getActivitiesByCommentId($comment->commentId);
                    foreach($commentActivities as $comment){
                      $this->activityModel->deleteActivity($comment->commentId);
                    }
                }

                // delete all user messages in that Hub
                $messagesData = [
                  'id' => $id,
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userMessages = $this->messageModel->getMessages($messagesData);

                foreach($userMessages as $message){
                  $this->messageModel->deleteMessage($message->messageId);
                }

                $hubmates = $this->userModel->getHubmates($_SESSION['user_hub_id']);
                foreach($hubmates as $mate){
                  if($mate->userId != $id){
                    // update hubs activity
                    $activityData = [
                      'hub_id' => $_SESSION['user_hub_id'],
                      'hub' => $_SESSION['user_hub'],
                      'user_id' => $id,
                      'user' => $user->name . " " . $user->last_name,
                      'to_id' => $mate->userId,
                      'type' => 'Remove',
                      'remover_id' => $_SESSION['user_id'],
                      'remover_name' => $_SESSION['user_name'],
                      'notify_user' => 0,
                      'created_new_hub' => 0,
                      'post_id' => 0,
                      'comment_id' => 0
                    ];

                    $this->activityModel->addRemoverActivity($activityData);
                  }
                }

                // update notify_user activity
                $activityData = [
                  'hub_id' => $_SESSION['user_hub_id'],
                  'hub' => $_SESSION['user_hub'],
                  'user_id' => $id,
                  'user' => $user->name . " " . $user->last_name,
                  'to_id' => 0,
                  'type' => 'Remove',
                  'remover_id' => $_SESSION['user_id'],
                  'remover_name' => $_SESSION['user_name'],
                  'notify_user' => $id,
                  'created_new_hub' => 0,
                  'post_id' => 0,
                  'comment_id' => 0
                ];

                $this->activityModel->addRemoverActivity($activityData);

                // check if the left Hub was their default and change if so to avoid complications on future sign ins
                if($user->hub_id == $_SESSION['user_hub_id']){
                  $newDefaultHub = $this->hubModel->getHubById($user->hub_5_id);
                  $data = [
                    'id' => $id,
                    'hub' => $newDefaultHub->name,
                    'hub_id' => $user->hub_5_id
                  ];

                  $this->userModel->updateUserDefaultHub($data);
                }

                errorFlash('success_message', 'Hubmate Removed');
                $_SESSION['flash_error_message'] = 'Hubmate Removed';
                redirect('users/profile/' . $id);
              } else {
                // delete all posts and comments made by the user in that Hub
                $hubPosts = $this->postModel->getPostsByHubId($_SESSION['user_hub_id']);
                foreach($hubPosts as $post){
                  if($post->user_id == $id){
                    $hubComments = $this->commentModel->getCommentsByPostId($post->postId);
                    foreach($hubComments as $comment){
                        $this->commentModel->deleteComment($comment->commentId);
                        // delete all comment activities
                        $commentActivities = $this->activityModel->getActivitiesByCommentId($comment->commentId);
                        foreach($commentActivities as $comment){
                          $this->activityModel->deleteActivity($comment->commentId);
                        }
                    }
                    $this->postModel->deletePost($post->postId);

                    $postActivities = $this->activityModel->getActivitiesByPostId($post->postId);
                    foreach($postActivities as $activity){
                      $this->activityModel->deleteActivity($activity->activityId);
                    }
                  }
                }

                // delete all user comments on other posts
                $commentData = [
                  'from_id' => $id,
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userComments = $this->commentModel->getUserCommentsByHubId($commentData);
                foreach($userComments as $comment){
                    $this->commentModel->deleteComment($comment->commentId);
                    // delete all comment activities
                    $commentActivities = $this->activityModel->getActivitiesByCommentId($comment->commentId);
                    foreach($commentActivities as $comment){
                      $this->activityModel->deleteActivity($comment->commentId);
                    }
                }

                // delete all user messages in that Hub
                $messagesData = [
                  'id' => $id,
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userMessages = $this->messageModel->getMessages($messagesData);

                foreach($userMessages as $message){
                  $this->messageModel->deleteMessage($message->messageId);
                }

                // this is the users only Hub, so create new
                $date = [
                  'hubname' => 'New'
                ];

                $newHubId = $this->hubModel->addHub($date);

                $hub1Data = [
                  'id' => $id,
                  'hub_id' => $newHubId
                ];
                $this->userModel->updateHub1($hub1Data);

                $data = [
                  'id' => $id,
                  'hub' => 'New',
                  'hub_id' => $newHubId
                ];

                $this->userModel->updateUserDefaultHub($data);

                $hubmates = $this->userModel->getHubmates($_SESSION['user_hub_id']);
                foreach($hubmates as $mate){
                  if($mate->userId != $id){
                    // update hubs activity
                    $activityData = [
                      'hub_id' => $_SESSION['user_hub_id'],
                      'hub' => $_SESSION['user_hub'],
                      'user_id' => $id,
                      'user' => $user->name . " " . $user->last_name,
                      'to_id' => $mate->userId,
                      'type' => 'Remove',
                      'remover_id' => $_SESSION['user_id'],
                      'remover_name' => $_SESSION['user_name'],
                      'notify_user' => 0,
                      'created_new_hub' => $newHubId,
                      'post_id' => 0,
                      'comment_id' => 0
                    ];

                    $this->activityModel->addRemoverActivity($activityData);
                  }
                }

                // update notify_user activity
                $activityData = [
                  'hub_id' => $_SESSION['user_hub_id'],
                  'hub' => $_SESSION['user_hub'],
                  'user_id' => $id,
                  'user' => $user->name . " " . $user->last_name,
                  'to_id' => 0,
                  'type' => 'Remove',
                  'remover_id' => $_SESSION['user_id'],
                  'remover_name' => $_SESSION['user_name'],
                  'notify_user' => $id,
                  'created_new_hub' => $newHubId,
                  'post_id' => 0,
                  'comment_id' => 0
                ];

                $this->activityModel->addRemoverActivity($activityData);

                errorFlash('success_message', 'Hubmate Removed');
                $_SESSION['flash_error_message'] = 'Hubmate Removed';
                redirect('users/profile/' . $id);
              }
            } else {
              die('Oops! Something went wrong');
            }
          } elseif($user->hub_5_id == $_SESSION['user_hub_id']){
            if($this->userModel->updateHub5($data)){
              if($user->hub_1_id != 0){
                // delete all posts and comments made by the user in that Hub
                $hubPosts = $this->postModel->getPostsByHubId($_SESSION['user_hub_id']);
                foreach($hubPosts as $post){
                  if($post->user_id == $id){
                    $hubComments = $this->commentModel->getCommentsByPostId($post->postId);
                    foreach($hubComments as $comment){
                        $this->commentModel->deleteComment($comment->commentId);
                        // delete all comment activities
                        $commentActivities = $this->activityModel->getActivitiesByCommentId($comment->commentId);
                        foreach($commentActivities as $comment){
                          $this->activityModel->deleteActivity($comment->commentId);
                        }
                    }
                    $this->postModel->deletePost($post->postId);

                    $postActivities = $this->activityModel->getActivitiesByPostId($post->postId);
                    foreach($postActivities as $activity){
                      $this->activityModel->deleteActivity($activity->activityId);
                    }
                  }
                }

                // delete all user comments on other posts
                $commentData = [
                  'from_id' => $id,
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userComments = $this->commentModel->getUserCommentsByHubId($commentData);
                foreach($userComments as $comment){
                    $this->commentModel->deleteComment($comment->commentId);
                    // delete all comment activities
                    $commentActivities = $this->activityModel->getActivitiesByCommentId($comment->commentId);
                    foreach($commentActivities as $comment){
                      $this->activityModel->deleteActivity($comment->commentId);
                    }
                }

                // delete all user messages in that Hub
                $messagesData = [
                  'id' => $id,
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userMessages = $this->messageModel->getMessages($messagesData);

                foreach($userMessages as $message){
                  $this->messageModel->deleteMessage($message->messageId);
                }

                $hubmates = $this->userModel->getHubmates($_SESSION['user_hub_id']);
                foreach($hubmates as $mate){
                  if($mate->userId != $id){
                    // update hubs activity
                    $activityData = [
                      'hub_id' => $_SESSION['user_hub_id'],
                      'hub' => $_SESSION['user_hub'],
                      'user_id' => $id,
                      'user' => $user->name . " " . $user->last_name,
                      'to_id' => $mate->userId,
                      'type' => 'Remove',
                      'remover_id' => $_SESSION['user_id'],
                      'remover_name' => $_SESSION['user_name'],
                      'notify_user' => 0,
                      'created_new_hub' => 0,
                      'post_id' => 0,
                      'comment_id' => 0
                    ];

                    $this->activityModel->addRemoverActivity($activityData);
                  }
                }

                // update notify_user activity
                $activityData = [
                  'hub_id' => $_SESSION['user_hub_id'],
                  'hub' => $_SESSION['user_hub'],
                  'user_id' => $id,
                  'user' => $user->name . " " . $user->last_name,
                  'to_id' => 0,
                  'type' => 'Remove',
                  'remover_id' => $_SESSION['user_id'],
                  'remover_name' => $_SESSION['user_name'],
                  'notify_user' => $id,
                  'created_new_hub' => 0,
                  'post_id' => 0,
                  'comment_id' => 0
                ];

                $this->activityModel->addRemoverActivity($activityData);

                // check if the left Hub was their default and change if so to avoid complications on future sign ins
                if($user->hub_id == $_SESSION['user_hub_id']){
                  $newDefaultHub = $this->hubModel->getHubById($user->hub_1_id);
                  $data = [
                    'id' => $id,
                    'hub' => $newDefaultHub->name,
                    'hub_id' => $user->hub_1_id
                  ];

                  $this->userModel->updateUserDefaultHub($data);
                }

                errorFlash('success_message', 'Hubmate Removed');
                $_SESSION['flash_error_message'] = 'Hubmate Removed';
                redirect('users/profile/' . $id);
              } elseif($user->hub_2_id != 0){
                // delete all posts and comments made by the user in that Hub
                $hubPosts = $this->postModel->getPostsByHubId($_SESSION['user_hub_id']);
                foreach($hubPosts as $post){
                  if($post->user_id == $id){
                    $hubComments = $this->commentModel->getCommentsByPostId($post->postId);
                    foreach($hubComments as $comment){
                        $this->commentModel->deleteComment($comment->commentId);
                        // delete all comment activities
                        $commentActivities = $this->activityModel->getActivitiesByCommentId($comment->commentId);
                        foreach($commentActivities as $comment){
                          $this->activityModel->deleteActivity($comment->commentId);
                        }
                    }
                    $this->postModel->deletePost($post->postId);

                    $postActivities = $this->activityModel->getActivitiesByPostId($post->postId);
                    foreach($postActivities as $activity){
                      $this->activityModel->deleteActivity($activity->activityId);
                    }
                  }
                }

                // delete all user comments on other posts
                $commentData = [
                  'from_id' => $id,
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userComments = $this->commentModel->getUserCommentsByHubId($commentData);
                foreach($userComments as $comment){
                    $this->commentModel->deleteComment($comment->commentId);
                    // delete all comment activities
                    $commentActivities = $this->activityModel->getActivitiesByCommentId($comment->commentId);
                    foreach($commentActivities as $comment){
                      $this->activityModel->deleteActivity($comment->commentId);
                    }
                }

                // delete all user messages in that Hub
                $messagesData = [
                  'id' => $id,
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userMessages = $this->messageModel->getMessages($messagesData);

                foreach($userMessages as $message){
                  $this->messageModel->deleteMessage($message->messageId);
                }

                $hubmates = $this->userModel->getHubmates($_SESSION['user_hub_id']);
                foreach($hubmates as $mate){
                  if($mate->userId != $id){
                    // update hubs activity
                    $activityData = [
                      'hub_id' => $_SESSION['user_hub_id'],
                      'hub' => $_SESSION['user_hub'],
                      'user_id' => $id,
                      'user' => $user->name . " " . $user->last_name,
                      'to_id' => $mate->userId,
                      'type' => 'Remove',
                      'remover_id' => $_SESSION['user_id'],
                      'remover_name' => $_SESSION['user_name'],
                      'notify_user' => 0,
                      'created_new_hub' => 0,
                      'post_id' => 0,
                      'comment_id' => 0
                    ];

                    $this->activityModel->addRemoverActivity($activityData);
                  }
                }

                // update notify_user activity
                $activityData = [
                  'hub_id' => $_SESSION['user_hub_id'],
                  'hub' => $_SESSION['user_hub'],
                  'user_id' => $id,
                  'user' => $user->name . " " . $user->last_name,
                  'to_id' => 0,
                  'type' => 'Remove',
                  'remover_id' => $_SESSION['user_id'],
                  'remover_name' => $_SESSION['user_name'],
                  'notify_user' => $id,
                  'created_new_hub' => 0,
                  'post_id' => 0,
                  'comment_id' => 0
                ];

                $this->activityModel->addRemoverActivity($activityData);

                // check if the left Hub was their default and change if so to avoid complications on future sign ins
                if($user->hub_id == $_SESSION['user_hub_id']){
                  $newDefaultHub = $this->hubModel->getHubById($user->hub_2_id);
                  $data = [
                    'id' => $id,
                    'hub' => $newDefaultHub->name,
                    'hub_id' => $user->hub_2_id
                  ];

                  $this->userModel->updateUserDefaultHub($data);
                }

                errorFlash('success_message', 'Hubmate Removed');
                $_SESSION['flash_error_message'] = 'Hubmate Removed';
                redirect('users/profile/' . $id);
              } elseif($user->hub_3_id != 0){
                // delete all posts and comments made by the user in that Hub
                $hubPosts = $this->postModel->getPostsByHubId($_SESSION['user_hub_id']);
                foreach($hubPosts as $post){
                  if($post->user_id == $id){
                    $hubComments = $this->commentModel->getCommentsByPostId($post->postId);
                    foreach($hubComments as $comment){
                        $this->commentModel->deleteComment($comment->commentId);
                        // delete all comment activities
                        $commentActivities = $this->activityModel->getActivitiesByCommentId($comment->commentId);
                        foreach($commentActivities as $comment){
                          $this->activityModel->deleteActivity($comment->commentId);
                        }
                    }
                    $this->postModel->deletePost($post->postId);

                    $postActivities = $this->activityModel->getActivitiesByPostId($post->postId);
                    foreach($postActivities as $activity){
                      $this->activityModel->deleteActivity($activity->activityId);
                    }
                  }
                }

                // delete all user comments on other posts
                $commentData = [
                  'from_id' => $id,
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userComments = $this->commentModel->getUserCommentsByHubId($commentData);
                foreach($userComments as $comment){
                    $this->commentModel->deleteComment($comment->commentId);
                    // delete all comment activities
                    $commentActivities = $this->activityModel->getActivitiesByCommentId($comment->commentId);
                    foreach($commentActivities as $comment){
                      $this->activityModel->deleteActivity($comment->commentId);
                    }
                }

                // delete all user messages in that Hub
                $messagesData = [
                  'id' => $id,
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userMessages = $this->messageModel->getMessages($messagesData);

                foreach($userMessages as $message){
                  $this->messageModel->deleteMessage($message->messageId);
                }

                $hubmates = $this->userModel->getHubmates($_SESSION['user_hub_id']);
                foreach($hubmates as $mate){
                  if($mate->userId != $id){
                    // update hubs activity
                    $activityData = [
                      'hub_id' => $_SESSION['user_hub_id'],
                      'hub' => $_SESSION['user_hub'],
                      'user_id' => $id,
                      'user' => $user->name . " " . $user->last_name,
                      'to_id' => $mate->userId,
                      'type' => 'Remove',
                      'remover_id' => $_SESSION['user_id'],
                      'remover_name' => $_SESSION['user_name'],
                      'notify_user' => 0,
                      'created_new_hub' => 0,
                      'post_id' => 0,
                      'comment_id' => 0
                    ];

                    $this->activityModel->addRemoverActivity($activityData);
                  }
                }

                // update notify_user activity
                $activityData = [
                  'hub_id' => $_SESSION['user_hub_id'],
                  'hub' => $_SESSION['user_hub'],
                  'user_id' => $id,
                  'user' => $user->name . " " . $user->last_name,
                  'to_id' => 0,
                  'type' => 'Remove',
                  'remover_id' => $_SESSION['user_id'],
                  'remover_name' => $_SESSION['user_name'],
                  'notify_user' => $id,
                  'created_new_hub' => 0,
                  'post_id' => 0,
                  'comment_id' => 0
                ];

                $this->activityModel->addRemoverActivity($activityData);

                // check if the left Hub was their default and change if so to avoid complications on future sign ins
                if($user->hub_id == $_SESSION['user_hub_id']){
                  $newDefaultHub = $this->hubModel->getHubById($user->hub_3_id);
                  $data = [
                    'id' => $id,
                    'hub' => $newDefaultHub->name,
                    'hub_id' => $user->hub_3_id
                  ];

                  $this->userModel->updateUserDefaultHub($data);
                }

                errorFlash('success_message', 'Hubmate Removed');
                $_SESSION['flash_error_message'] = 'Hubmate Removed';
                redirect('users/profile/' . $id);
              } elseif($user->hub_4_id != 0){
                // delete all posts and comments made by the user in that Hub
                $hubPosts = $this->postModel->getPostsByHubId($_SESSION['user_hub_id']);
                foreach($hubPosts as $post){
                  if($post->user_id == $id){
                    $hubComments = $this->commentModel->getCommentsByPostId($post->postId);
                    foreach($hubComments as $comment){
                        $this->commentModel->deleteComment($comment->commentId);
                        // delete all comment activities
                        $commentActivities = $this->activityModel->getActivitiesByCommentId($comment->commentId);
                        foreach($commentActivities as $comment){
                          $this->activityModel->deleteActivity($comment->commentId);
                        }
                    }
                    $this->postModel->deletePost($post->postId);

                    $postActivities = $this->activityModel->getActivitiesByPostId($post->postId);
                    foreach($postActivities as $activity){
                      $this->activityModel->deleteActivity($activity->activityId);
                    }
                  }
                }

                // delete all user comments on other posts
                $commentData = [
                  'from_id' => $id,
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userComments = $this->commentModel->getUserCommentsByHubId($commentData);
                foreach($userComments as $comment){
                    $this->commentModel->deleteComment($comment->commentId);
                    // delete all comment activities
                    $commentActivities = $this->activityModel->getActivitiesByCommentId($comment->commentId);
                    foreach($commentActivities as $comment){
                      $this->activityModel->deleteActivity($comment->commentId);
                    }
                }

                // delete all user messages in that Hub
                $messagesData = [
                  'id' => $id,
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userMessages = $this->messageModel->getMessages($messagesData);

                foreach($userMessages as $message){
                  $this->messageModel->deleteMessage($message->messageId);
                }

                $hubmates = $this->userModel->getHubmates($_SESSION['user_hub_id']);
                foreach($hubmates as $mate){
                  if($mate->userId != $id){
                    // update hubs activity
                    $activityData = [
                      'hub_id' => $_SESSION['user_hub_id'],
                      'hub' => $_SESSION['user_hub'],
                      'user_id' => $id,
                      'user' => $user->name . " " . $user->last_name,
                      'to_id' => $mate->userId,
                      'type' => 'Remove',
                      'remover_id' => $_SESSION['user_id'],
                      'remover_name' => $_SESSION['user_name'],
                      'notify_user' => 0,
                      'created_new_hub' => 0,
                      'post_id' => 0,
                      'comment_id' => 0
                    ];

                    $this->activityModel->addRemoverActivity($activityData);
                  }
                }

                // update notify_user activity
                $activityData = [
                  'hub_id' => $_SESSION['user_hub_id'],
                  'hub' => $_SESSION['user_hub'],
                  'user_id' => $id,
                  'user' => $user->name . " " . $user->last_name,
                  'to_id' => 0,
                  'type' => 'Remove',
                  'remover_id' => $_SESSION['user_id'],
                  'remover_name' => $_SESSION['user_name'],
                  'notify_user' => $id,
                  'created_new_hub' => 0,
                  'post_id' => 0,
                  'comment_id' => 0
                ];

                $this->activityModel->addRemoverActivity($activityData);

                // check if the left Hub was their default and change if so to avoid complications on future sign ins
                if($user->hub_id == $_SESSION['user_hub_id']){
                  $newDefaultHub = $this->hubModel->getHubById($user->hub_4_id);
                  $data = [
                    'id' => $id,
                    'hub' => $newDefaultHub->name,
                    'hub_id' => $user->hub_4_id
                  ];

                  $this->userModel->updateUserDefaultHub($data);
                }

                errorFlash('success_message', 'Hubmate Removed');
                $_SESSION['flash_error_message'] = 'Hubmate Removed';
                redirect('users/profile/' . $id);
              } else {
                // delete all posts and comments made by the user in that Hub
                $hubPosts = $this->postModel->getPostsByHubId($_SESSION['user_hub_id']);
                foreach($hubPosts as $post){
                  if($post->user_id == $id){
                    $hubComments = $this->commentModel->getCommentsByPostId($post->postId);
                    foreach($hubComments as $comment){
                        $this->commentModel->deleteComment($comment->commentId);
                        // delete all comment activities
                        $commentActivities = $this->activityModel->getActivitiesByCommentId($comment->commentId);
                        foreach($commentActivities as $comment){
                          $this->activityModel->deleteActivity($comment->commentId);
                        }
                    }
                    $this->postModel->deletePost($post->postId);

                    $postActivities = $this->activityModel->getActivitiesByPostId($post->postId);
                    foreach($postActivities as $activity){
                      $this->activityModel->deleteActivity($activity->activityId);
                    }
                  }
                }

                // delete all user comments on other posts
                $commentData = [
                  'from_id' => $id,
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userComments = $this->commentModel->getUserCommentsByHubId($commentData);
                foreach($userComments as $comment){
                    $this->commentModel->deleteComment($comment->commentId);
                    // delete all comment activities
                    $commentActivities = $this->activityModel->getActivitiesByCommentId($comment->commentId);
                    foreach($commentActivities as $comment){
                      $this->activityModel->deleteActivity($comment->commentId);
                    }
                }

                // delete all user messages in that Hub
                $messagesData = [
                  'id' => $id,
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userMessages = $this->messageModel->getMessages($messagesData);

                foreach($userMessages as $message){
                  $this->messageModel->deleteMessage($message->messageId);
                }

                // this is the users only Hub, so create new
                $date = [
                  'hubname' => 'New'
                ];

                $newHubId = $this->hubModel->addHub($date);

                $data = [
                  'id' => $id,
                  'hub' => 'New',
                  'hub_id' => $newHubId
                ];

                $this->userModel->updateUserDefaultHub($data);

                $hub1Data = [
                  'id' => $id,
                  'hub_id' => $newHubId
                ];
                $this->userModel->updateHub1($hub1Data);

                $hubmates = $this->userModel->getHubmates($_SESSION['user_hub_id']);
                foreach($hubmates as $mate){
                  if($mate->userId != $id){
                    // update hubs activity
                    $activityData = [
                      'hub_id' => $_SESSION['user_hub_id'],
                      'hub' => $_SESSION['user_hub'],
                      'user_id' => $id,
                      'user' => $user->name . " " . $user->last_name,
                      'to_id' => $mate->userId,
                      'type' => 'Remove',
                      'remover_id' => $_SESSION['user_id'],
                      'remover_name' => $_SESSION['user_name'],
                      'notify_user' => 0,
                      'created_new_hub' => $newHubId,
                      'post_id' => 0,
                      'comment_id' => 0
                    ];

                    $this->activityModel->addRemoverActivity($activityData);
                  }
                }

                // update notify_user activity
                $activityData = [
                  'hub_id' => $_SESSION['user_hub_id'],
                  'hub' => $_SESSION['user_hub'],
                  'user_id' => $id,
                  'user' => $user->name . " " . $user->last_name,
                  'to_id' => 0,
                  'type' => 'Remove',
                  'remover_id' => $_SESSION['user_id'],
                  'remover_name' => $_SESSION['user_name'],
                  'notify_user' => $id,
                  'created_new_hub' => $newHubId,
                  'post_id' => 0,
                  'comment_id' => 0
                ];

                $this->activityModel->addRemoverActivity($activityData);

                errorFlash('success_message', 'Hubmate Removed');
                $_SESSION['flash_error_message'] = 'Hubmate Removed';
                redirect('users/profile/' . $id);
              }
            }
          } else {
            die('Oops! Something went wrong');
          }
        }
        if(isset($_POST['updatePostBtn'])){
          // encode b64 string
          $b64 = base64_encode(trim($_POST['post-edit-b64-img']));

          $data = [
            'removed_from_hub' => $removedFromHub,
            'created_new_hub' => $createdNewHub,
            'id' => trim($_POST['post-id']),
            'title' => trim($_POST['post-title']),
            'img' => $b64,
            'user_id' => $_SESSION['user_id'],
            'edited' => 1,
            'title_err' => '',
            'body_err' => ''
          ];

          // validate data
          if(empty($data['title'])  && empty($data['img'])){
            $data['title_err'] = 'Please enter your message or attach an image to shout';
          }

          // ensure no errors
          if(empty($data['title_err'])){
            if($this->postModel->updatePost($data)){
              flash('success_message', 'Shout Updated');
              $_SESSION['flash_message'] = 'Shout Updated';
              redirect('posts/show/' . $data['id']);
              die($_SESSION['flash_message']);
            } else {
              die('Oops! Something went wrong');
            }

          } else {
            // load view with errors
            $this->view('users/profile/' . $id, $data);
          }
        } elseif(isset($_POST['deletePostBtn'])){
          // get existing post from model
          $post = $this->postModel->getPostById($_POST['post-id']);
          // check for owner
          if($post->user_id != $_SESSION['user_id']){
            redirect('users/profile/' . $id);
          }

          if($this->postModel->deletePost($post->id)){
            errorFlash('success_message', 'Shout Removed');
            $_SESSION['flash_error_message'] = 'Shout Removed';

            // delete comments
            $postComments = $this->commentModel->getCommentsByPostId($post->id);
            foreach($postComments as $comment){
              $this->commentModel->deleteComment($comment->commentId);
            }

            $postActivities = $this->activityModel->getActivitiesByPostId($post->id);
            foreach($postActivities as $activity){
              $this->activityModel->deleteActivity($activity->activityId);
            }

            // $posts = $this->postModel->getPostsByUserId($id);
            $user = $this->userModel->getUserById($id);
            // decode b64 to img if set
            $b64 = $user->img;
            if($b64){
              // decode b64 to img
              $user->img = base64_decode($b64);
            }

            $mates = $this->userModel->getHubmates($_SESSION['user_hub_id']);
            // remove self from array
            $matesCounter = 0;
            foreach($mates as $mate){
              if($mate->id == $_SESSION['user_id']){
                unset($mates[$matesCounter]);
              } else {
                $matesCounter += 1;
              }
            }

            $noOfMates = count($mates);
            $hubmateBool = false;

            $posts = $this->postModel->getPostsByHubId($_SESSION['user_hub_id']);
            $postCounter = 0;
            foreach($posts as $post){
              if($post->user_id != $id){
                unset($posts[$postCounter]);
                $postCounter += 1;
              } else {
                // decode post img
                if($post->postImg){
                  $post->postImg = base64_decode($post->postImg);
                }
                $postCounter += 1;
              }
            }

            // comments
            $comments = [];
            foreach($posts as $post){
              $postId = $post->postId;
              $getComments = $this->commentModel->getComments($postId);
              $threeComments = array_slice($getComments, -3);

              // get user profile picture
              foreach($threeComments as $comment){
                $commentUser = $this->userModel->getUserById($comment->fromId);
                $comment->user_id = $commentUser->id;
                $comment->user = $commentUser->name . ' ' . $commentUser->last_name;
                $comment->colour = $commentUser->colour;
                if($commentUser->img){
                  // decode b64 to img
                  $comment->img = base64_decode($commentUser->img);
                } else {
                  $comment->img = '';
                }
              }

              $comments[] = [
                'post_id' => $postId,
                'comments' => $threeComments,
                'count' => count($getComments)
              ];
            }

            if($user->hub_1_id == $_SESSION['user_hub_id'] || $user->hub_2_id == $_SESSION['user_hub_id'] || $user->hub_3_id == $_SESSION['user_hub_id'] || $user->hub_4_id == $_SESSION['user_hub_id'] || $user->hub_5_id == $_SESSION['user_hub_id']){
              $hubmateBool = true;
            }

            // check to see if the the user has already been invited to join their hub
            $requestId = $_SESSION['user_id'] . $id . $_SESSION['user_hub_id'];
            $invite = $this->inviteModel->getInviteById($requestId);

            // check to see if the the user has received an invite from this profile
            $invitesReceived = $this->inviteModel->getInviteByUserId($_SESSION['user_id']);
            $inviteReceived = array();
            foreach($invitesReceived as $i){
              if($i->fromId == $id){
                array_push($inviteReceived, $i);
              }
            }

            $data = [
              'removed_from_hub' => $removedFromHub,
              'created_new_hub' => $createdNewHub,
              'posts' => $posts,
              'comments' => $comments,
              'user' => $user,
              'no_of_mates' => $noOfMates,
              'mates_bool' => $hubmateBool,
              'invited' => $invite,
              'invite_received' => $inviteReceived,
              'hubLimitReached' => 0
            ];

            // check the user has an available Hub in their Database
            if($user->hub_1_id != 0 && $user->hub_2_id != 0 && $user->hub_3_id != 0 && $user->hub_4_id != 0 && $user->hub_5_id != 0){
              $data['hubLimitReached'] = 1;
            }

            $this->view('users/profile', $data);
          } else {
            die('Oops! Something went wrong');
          }
        } elseif(isset($_POST['acceptBtn'])){
          $inviteId = trim($_POST['inviteId']);
          $dbInvite = $this->inviteModel->getInviteById($inviteId);

          $inviteAcceptData = [
            'id' => $dbInvite->id,
            'accepted' => 1,
            'declined' => 0
          ];

          $this->inviteModel->updateInviteResponse($inviteAcceptData);

          $hubId = trim($_POST['hubId']);
          $hubName = trim($_POST['hubName']);

          // update hubs activity
          $activityData = [
            'hub_id' => $hubId,
            'hub' => $hubName,
            'user_id' => $_SESSION['user_id'],
            'user' => $_SESSION['user_name'],
            'type' => 'Join',
            'to_id' => 0,
            'post_id' => 0,
            'comment_id' => 0,
            'remover_id' => 0,
            'remover_name' => '',
            'notify_user' => 0
          ];

          $this->activityModel->addActivity($activityData);

          // add the Hub to the users database
          if($user->hub_1_id == 0){
            // update session variables
            $_SESSION['user_hub'] = $hubName;
            $_SESSION['user_hub_id'] = $hubId;
            $_SESSION['user_hub_1_id'] = $hubId;
            $_SESSION['user_hub_1'] = $hubName;

            $data = [
              'removed_from_hub' => 0,
              'created_new_hub' => 0,
              'id' => $_SESSION['user_id'],
              'hub_id' => $hubId
            ];

            // redirect to the new Hub
            if($this->userModel->updateHub1($data)){
              flash('success_message', 'Welcome to your new Hub!');
              // delete all other invites to the newly joined Hub
              $AllHubInvitesData = [
                'id' => $_SESSION['user_id'],
                'hub_id' => $hubId
              ];

              $allHubInvites = $this->inviteModel->getAllUserInvitesByHubId($AllHubInvitesData);

              foreach($allHubInvites as $invite){
                $this->inviteModel->deleteInvite($invite->id);
              }

              redirect('posts/index', $data);
            } else {
              die('Oops! Something went wrong');
            }

          } elseif($user->hub_2_id == 0){
            // update session variables
            $_SESSION['user_hub'] = $hubName;
            $_SESSION['user_hub_id'] = $hubId;
            $_SESSION['user_hub_2_id'] = $hubId;
            $_SESSION['user_hub_2'] = $hubName;

            $data = [
              'removed_from_hub' => 0,
              'created_new_hub' => 0,
              'id' => $_SESSION['user_id'],
              'hub_id' => $hubId
            ];

            // redirect to the new Hub
            if($this->userModel->updateHub2($data)){
              flash('success_message', 'Welcome to your new Hub!');
              // delete all other invites to the newly joined Hub
              $AllHubInvitesData = [
                'id' => $_SESSION['user_id'],
                'hub_id' => $hubId
              ];

              $allHubInvites = $this->inviteModel->getAllUserInvitesByHubId($AllHubInvitesData);

              foreach($allHubInvites as $invite){
                $this->inviteModel->deleteInvite($invite->id);
              }

              redirect('posts/index', $data);
            } else {
              die('Oops! Something went wrong');
            }

          } elseif($user->hub_3_id == 0){
            // update session variables
            $_SESSION['user_hub'] = $hubName;
            $_SESSION['user_hub_id'] = $hubId;
            $_SESSION['user_hub_3_id'] = $hubId;
            $_SESSION['user_hub_3'] = $hubName;

            $data = [
              'removed_from_hub' => 0,
              'created_new_hub' => 0,
              'id' => $_SESSION['user_id'],
              'hub_id' => $hubId
            ];

            // redirect to the new Hub
            if($this->userModel->updateHub3($data)){
              flash('success_message', 'Welcome to your new Hub!');
              // delete all other invites to the newly joined Hub
              $AllHubInvitesData = [
                'id' => $_SESSION['user_id'],
                'hub_id' => $hubId
              ];

              $allHubInvites = $this->inviteModel->getAllUserInvitesByHubId($AllHubInvitesData);

              foreach($allHubInvites as $invite){
                $this->inviteModel->deleteInvite($invite->id);
              }

              redirect('posts/index', $data);
            } else {
              die('Oops! Something went wrong');
            }

          } elseif($user->hub_4_id == 0){
            // update session variables
            $_SESSION['user_hub'] = $hubName;
            $_SESSION['user_hub_id'] = $hubId;
            $_SESSION['user_hub_4_id'] = $hubId;
            $_SESSION['user_hub_4'] = $hubName;

            $data = [
              'removed_from_hub' => 0,
              'created_new_hub' => 0,
              'id' => $_SESSION['user_id'],
              'hub_id' => $hubId
            ];

            // redirect to the new Hub
            if($this->userModel->updateHub4($data)){
              flash('success_message', 'Welcome to your new Hub!');
              // delete all other invites to the newly joined Hub
              $AllHubInvitesData = [
                'id' => $_SESSION['user_id'],
                'hub_id' => $hubId
              ];

              $allHubInvites = $this->inviteModel->getAllUserInvitesByHubId($AllHubInvitesData);

              foreach($allHubInvites as $invite){
                $this->inviteModel->deleteInvite($invite->id);
              }

              redirect('posts/index', $data);
            } else {
              die('Oops! Something went wrong');
            }

          } elseif($user->hub_5_id == 0){
            // update session variables
            $_SESSION['user_hub'] = $hubName;
            $_SESSION['user_hub_id'] = $hubId;
            $_SESSION['user_hub_5_id'] = $hubId;
            $_SESSION['user_hub_5'] = $hubName;

            $data = [
              'removed_from_hub' => 0,
              'created_new_hub' => 0,
              'id' => $_SESSION['user_id'],
              'hub_id' => $hubId
            ];

            // redirect to the new Hub
            if($this->userModel->updateHub5($data)){
              flash('success_message', 'Welcome to your new Hub!');
              // delete all other invites to the newly joined Hub
              $AllHubInvitesData = [
                'id' => $_SESSION['user_id'],
                'hub_id' => $hubId
              ];

              $allHubInvites = $this->inviteModel->getAllUserInvitesByHubId($AllHubInvitesData);

              foreach($allHubInvites as $invite){
                $this->inviteModel->deleteInvite($invite->id);
              }

              redirect('posts/index', $data);
            } else {
              die('Oops! Something went wrong');
            }
          }
        } elseif(isset($_POST['rejectBtn'])){
          $inviteId = trim($_POST['inviteId']);
          $dbInvite = $this->inviteModel->getInviteById($inviteId);

          $data = [
            'removed_from_hub' => 0,
            'created_new_hub' => 0,
            'id' => $dbInvite->id,
            'accepted' => 0,
            'declined' => 1
          ];
          $this->inviteModel->updateInviteResponse($data);

          // delete invite
          if($this->inviteModel->deleteInvite($dbInvite->id)){
            redirect('users/profile/' . $id);
          } else {
            die('Oops! Something went wrong');
          }
        } elseif(isset($_POST['invite'])){

          $inviteId = $_SESSION['user_id'] . $id . $_SESSION['user_hub_id'];

          $data = [
            'removed_from_hub' => $removedFromHub,
            'created_new_hub' => $createdNewHub,
            'hub_id' => $_SESSION['user_hub_id'],
            'hub_name' => $_SESSION['user_hub'],
            'to_id' => $id,
            'from_id' => $_SESSION['user_id'],
            'from_name' => $_SESSION['user_name'],
            'invite_id' => $inviteId
          ];

          if($this->inviteModel->sendInvite($data)){
            redirect('users/profile/' . $data['to_id']);
          } else {
            die('Oops! Something went wrong');
          }
        } elseif(isset($_POST['pending'])){
          $inviteId = $_SESSION['user_id'] . trim($_POST['to_id']) . $_SESSION['user_hub_id'];
          $dbInvite = $this->inviteModel->getInviteById($inviteId);

          // delete invite
          if($this->inviteModel->deleteInvite($dbInvite->id)){
            redirect('users/profile/' . $id);
          } else {
            die('Oops! Something went wrong');
          }
        }
      }

      // $posts = $this->postModel->getPostsByUserId($id);
      $user = $this->userModel->getUserById($id);
      if($user){
        // decode b64 to img if set
        $b64 = $user->img;
        if($b64){
          // decode b64 to img
          $user->img = base64_decode($b64);
        }

        $mates = $this->userModel->getHubmates($_SESSION['user_hub_id']);
        // remove self from array
        $matesCounter = 0;
        foreach($mates as $mate){
          if($mate->id == $_SESSION['user_id']){
            unset($mates[$matesCounter]);
          } else {
            $matesCounter += 1;
          }
        }

        $noOfMates = count($mates);
        $hubmateBool = false;

        $posts = $this->postModel->getPostsByHubId($_SESSION['user_hub_id']);
        $postCounter = 0;
        foreach($posts as $post){
          if($post->user_id != $id){
            unset($posts[$postCounter]);
            $postCounter += 1;
          } else {
            // decode post img
            if($post->postImg){
              $post->postImg = base64_decode($post->postImg);
            }
            $postCounter += 1;
          }
        }

        // comments
        $comments = [];
        foreach($posts as $post){
          $postId = $post->postId;
          $getComments = $this->commentModel->getComments($postId);
          $threeComments = array_slice($getComments, -3);

          // check if post has been liked by session user
          $data = [
            'post_id' => $postId,
            'user_id' => $_SESSION['user_id']
          ];

          $starred = $this->starModel->getStarByUserAndPostId($data);
          if($starred){
            $post->starred = true;
          } else {
            $post->starred = false;
          }

          $postStarUsers = [];
          $stars = $this->starModel->getStarsByPostId($postId);
          foreach($stars as $star){
            $starredUser = $this->userModel->getUserById($star->user_id);

            if($starredUser->img){
              // decode b64 to img
              $starredUser->img = base64_decode($starredUser->img);
            } else {
              $starredUser->img = '';
            }

            array_push($postStarUsers, $starredUser);
            $post->starredUser = $postStarUsers;
          }

          // get user profile picture
          foreach($threeComments as $comment){
            $commentUser = $this->userModel->getUserById($comment->fromId);
            $comment->user_id = $commentUser->id;
            $comment->user = $commentUser->name . ' ' . $commentUser->last_name;
            $comment->colour = $commentUser->colour;
            if($commentUser->img){
              // decode b64 to img
              $comment->img = base64_decode($commentUser->img);
            } else {
              $comment->img = '';
            }
          }

          $comments[] = [
            'post_id' => $postId,
            'comments' => $threeComments,
            'count' => count($getComments)
          ];
        }

        if($user->hub_1_id == $_SESSION['user_hub_id'] || $user->hub_2_id == $_SESSION['user_hub_id'] || $user->hub_3_id == $_SESSION['user_hub_id'] || $user->hub_4_id == $_SESSION['user_hub_id'] || $user->hub_5_id == $_SESSION['user_hub_id']){
          $hubmateBool = true;
        }

        // check to see if the the user has already been invited to join their hub
        $requestId = $_SESSION['user_id'] . $id . $_SESSION['user_hub_id'];
        $invite = $this->inviteModel->getInviteById($requestId);

        // check to see if the the user has received an invite from this profile
        $invitesReceived = $this->inviteModel->getInviteByUserId($_SESSION['user_id']);
        $inviteReceived = array();
        foreach($invitesReceived as $i){
          if($i->fromId == $id){
            array_push($inviteReceived, $i);
          }
        }

        $data = [
          'removed_from_hub' => $removedFromHub,
          'created_new_hub' => $createdNewHub,
          'posts' => $posts,
          'comments' => $comments,
          'user' => $user,
          'no_of_mates' => $noOfMates,
          'mates_bool' => $hubmateBool,
          'invited' => $invite,
          'invite_received' => $inviteReceived,
          'hubLimitReached' => 0
        ];

        // check the user has an available Hub in their Database
        if($user->hub_1_id != 0 && $user->hub_2_id != 0 && $user->hub_3_id != 0 && $user->hub_4_id != 0 && $user->hub_5_id != 0){
          $data['hubLimitReached'] = 1;
        }

        if($_SESSION['flash_message']){
          flash('success_message', $_SESSION['flash_message']);
        } elseif($_SESSION['flash_error_message']){
          errorFlash('success_message', $_SESSION['flash_error_message']);
        }
      } else {
        $data = '';
      }

      $this->view('users/profile', $data);
    }

    public function edit($id){
      if(!isLoggedIn()){
        redirect('users\login');
      }

      // check for unseen seen flag
      $userData = [
        'notify_user' => $_SESSION['user_id'],
        'seen' => 0
      ];
      $unseenRemovedActivity = $this->activityModel->getActivitiesByNotifyUser($userData);

      if(!empty($unseenRemovedActivity)){
        $removedFromHub = $unseenRemovedActivity;
        foreach($unseenRemovedActivity as $activity){
          $removedFromHub = $activity->hub;
          $createdNewHub = $activity->created_new_hub;

          // set session variables
          if($createdNewHub){
            $_SESSION['user_hub_id'] = $activity->created_new_hub;
            $_SESSION['user_hub'] = 'New';
          } elseif($_SESSION['user_hub_id'] == $removedFromHub){
            // if the Hub they have been removed from was their session Hub
            $user = $this->userModel->getUserById($_SESSION['user_id']);
            $_SESSION['user_hub_id'] = $user->hub_id;
            $_SESSION['user_hub'] = $user->hub;
          }
        }

        // mark as seen
        $data = [
          'id' => $unseenRemovedActivity->id,
          'seen' => 1
        ];
        $this->activityModel->updatePostActivitySeenFlag($data);
      } else {
        $removedFromHub = '';
        $createdNewHub = 0;
      }

      // check to see if its  a POST request
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // sanitize POST array
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // encode b64 string
        $b64 = base64_encode(trim($_POST['profile_b64_img']));

        if($b64){
          $_SESSION['user_img'] = base64_decode($b64);
        } else {
          $_SESSION['user_img'] = '';
        }

        $data = [
          'removed_from_hub' => $removedFromHub,
          'created_new_hub' => $createdNewHub,
          'id' => $id,
          'img' => $b64,
          'colour' => trim($_POST['colour']),
          'name' => trim($_POST['name']),
          'last_name' => trim($_POST['last_name']),
          'about' => trim($_POST['about']),
          'location' => trim($_POST['location']),
          'user_id' => $_SESSION['user_id'],
          'name_err' => '',
          'last_name_err' => ''
        ];

        // validate data
        if(empty($data['name'])){
          $data['name_err'] = 'Please enter your name';
        }
        if(empty($data['last_name'])){
          $data['last_name_err'] = 'Please enter your last name';
        }

        // ensure no errors
        if(empty($data['name_err']) && empty($data['last_name_err'])){
          if($this->userModel->updateUser($data)){
            flash('success_message', 'Updated User details');

            // update session user color
            $_SESSION['user_colour'] = $data['colour'];

            redirect('users/profile/' . $_SESSION['user_id'], $data);
          } else {
            die('Oops! Something went wrong');
          }
        } else {
          $user = $this->userModel->getUserById($id);
          // decode b64 to img
          if($user->img){
            $data['img'] = base64_decode($user->img);
          }
          // load view with errors
          $this->view('users/edit', $data);
        }

      } else {
        // get existing user from model
        $user = $this->userModel->getUserById($id);
        // check for owner
        if($user->id != $_SESSION['user_id']){
          redirect('users/profile', $data);
        }

        // decode b64 to img
        if($user->img){
          $img = base64_decode($user->img);
        } else {
          $img = '';
        }

        $data = [
          'removed_from_hub' => $removedFromHub,
          'created_new_hub' => $createdNewHub,
          'id' => $id,
          'img' => $img,
          'colour' => $user->colour,
          'name' => $user->name,
          'last_name' => $user->last_name,
          'about' => $user->about,
          'location' => $user->location
        ];

        $this->view('users/edit', $data);
      }
    }

    public function mates($id){
      $hubmates = $this->userModel->getHubmates($_SESSION['user_hub_id']);
      foreach($hubmates as $mate){
        // get user profile picture
        if($mate->img){
          // decode b64 to img
          $mate->img = base64_decode($mate->img);
        }
      }

      $data = [
        'calling_id' => $id,
        'hub_mates' => $hubmates
      ];

      $this->view('users/mates', $data);
    }

    public function search(){
      if(!isLoggedIn()){
        redirect('users\login');
      }

      // check for unseen seen flag
      $userData = [
        'notify_user' => $_SESSION['user_id'],
        'seen' => 0
      ];
      $unseenRemovedActivity = $this->activityModel->getActivitiesByNotifyUser($userData);

      if(!empty($unseenRemovedActivity)){
        $removedFromHub = $unseenRemovedActivity;
        foreach($unseenRemovedActivity as $activity){
          $removedFromHub = $activity->hub;
          $createdNewHub = $activity->created_new_hub;

          // set session variables
          if($createdNewHub){
            $_SESSION['user_hub_id'] = $activity->created_new_hub;
            $_SESSION['user_hub'] = 'New';
          } elseif($_SESSION['user_hub_id'] == $removedFromHub){
            // if the Hub they have been removed from was their session Hub
            $user = $this->userModel->getUserById($_SESSION['user_id']);
            $_SESSION['user_hub_id'] = $user->hub_id;
            $_SESSION['user_hub'] = $user->hub;
          }
        }

        // mark as seen
        $data = [
          'id' => $unseenRemovedActivity->id,
          'seen' => 1
        ];
        $this->activityModel->updatePostActivitySeenFlag($data);
      } else {
        $removedFromHub = '';
        $createdNewHub = 0;
      }

      $hubmates = $this->userModel->getHubmates($_SESSION['user_hub_id']);

      foreach($hubmates as $mate){
        // get user profile picture
        if($mate->img){
          // decode b64 to img
          $mate->img = base64_decode($mate->img);
        }
      }

      // check to see if its  a POST request
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // sanitize POST array
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        if(isset($_POST['invite'])){
          $id = trim($_POST['to_id']);
          $inviteId = $_SESSION['user_id'] . $id . $_SESSION['user_hub_id'];
          $user = $this->userModel->getUserById($id);
          // get user profile picture
          if($user->img){
            // decode b64 to img
            $user->img = base64_decode($user->img);
          }

          $data = [
            'removed_from_hub' => $removedFromHub,
            'created_new_hub' => $createdNewHub,
            'hub_id' => $_SESSION['user_hub_id'],
            'hub_name' => $_SESSION['user_hub'],
            'to_id' => $id,
            'from_id' => $_SESSION['user_id'],
            'from_name' => $_SESSION['user_name'],
            'invite_id' => $inviteId,
            'user' => $user,
            'mates' => $hubmates
          ];

          if($this->inviteModel->sendInvite($data)){
            $data['connect_btn'] = 1;
            $data['invited'] = true;
            $this->view('users/search', $data);
          } else {
            die('Oops! Something went wrong');
          }
        } elseif(isset($_POST['pending'])){
          $id = trim($_POST['to_id']);
          $inviteId = $_SESSION['user_id'] . $id . $_SESSION['user_hub_id'];
          $dbInvite = $this->inviteModel->getInviteById($inviteId);
          $user = $this->userModel->getUserById($id);
          // get user profile picture
          if($user->img){
            // decode b64 to img
            $user->img = base64_decode($user->img);
          }

          $data['user'] = $user;
          $data['mates'] = $hubmates;
          $data['connect_btn'] = 1;
          $data['invited'] = '';

          // delete invite
          if($this->inviteModel->deleteInvite($dbInvite->id)){
            $this->view('users/search', $data);
          } else {
            die('Oops! Something went wrong');
          }
        }

        // check to see if they have already invited the user to join their hub
        $requestId = $_SESSION['user_id'] . trim($_POST['search']) . $_SESSION['user_hub_id'];;
        $invite = $this->inviteModel->getInviteById($requestId);
        // check invite is set and isn't set to the standard 1 that is returned
        if($invite){
          $alreadyInvited = true;
        }

        $data = [
          'removed_from_hub' => $removedFromHub,
          'created_new_hub' => $createdNewHub,
          'user' => null,
          'mates' => $hubmates,
          'connect_btn' => 1,
          'search' => trim($_POST['search']),
          'search_err' => '',
          'invited' => isset($alreadyInvited) ? $alreadyInvited : ''
        ];

        // check if searched user ID was a match
        $counter = 0;
        $users = $this->userModel->getAllUsers();
        foreach($users as $user){
          if($user->id == $data['search']){
            $data['user'] = $user;

            // get user profile picture
            if($user->img){
              // decode b64 to img
              $data['user']->img = base64_decode($user->img);
            }

            $counter = 1;
          }
        }

        if($counter == 0){
          $data['user'] = null;
          $data['search_err'] = 'Hubmate not found';
        }

        // check if the searched user was self or already in hub
        foreach($hubmates as $hubmate){
          if($data['search'] == $hubmate->id){
            $data['connect_btn'] = 0;
          }
        }

        if($data['search'] == $_SESSION['user_id']) {
          $data['connect_btn'] = 0;
        }

        // validate data
        if(empty($data['search'])){
          $data['search_err'] = 'Please enter your Hubmates ID';
        }

        if(intval($data['search']) == 0){
          $data['search_err'] = 'Please enter a valid Hubmate ID';
        }

        // ensure no errors
        if(empty($data['search_err'])){
          flash('success_message', 'Hubmate found');
          $this->view('users/search', $data);
        } else {
          // load view with errors
          $this->view('users/search', $data);
        }

      } else {

        $data = [
          'removed_from_hub' => $removedFromHub,
          'created_new_hub' => $createdNewHub,
          'user' => null,
          'mates' => $hubmates,
          'connect_btn' => 1,
          'search' => ''
        ];

        $this->view('users/search', $data);
      }
    }

    public function logout(){
      // update users status to offline
      $data = [
        'id' => $_SESSION['user_id'],
        'status' => 'offline'
      ];
      $this->userModel->updateUserStatus($data);

      unset($_SESSION['user_id']);
      unset($_SESSION['user_name']);
      unset($_SESSION['user_email']);
      unset($_SESSION['user_hub']);
      unset($_SESSION['user_hub_id']);
      unset($_SESSION['user_hub_1_id']);
      unset($_SESSION['user_hub_1']);
      unset($_SESSION['user_hub_2_id']);
      unset($_SESSION['user_hub_2']);
      unset($_SESSION['user_hub_3_id']);
      unset($_SESSION['user_hub_3']);
      unset($_SESSION['user_hub_4_id']);
      unset($_SESSION['user_hub_4']);
      unset($_SESSION['user_hub_5_id']);
      unset($_SESSION['user_hub_5']);
      unset($_SESSION['user_hub_1_notifications']);
      unset($_SESSION['user_hub_1_whispers']);
      unset($_SESSION['user_hub_2_notifications']);
      unset($_SESSION['user_hub_2_whispers']);
      unset($_SESSION['user_hub_3_notifications']);
      unset($_SESSION['user_hub_3_whispers']);
      unset($_SESSION['user_hub_4_notifications']);
      unset($_SESSION['user_hub_4_whispers']);
      unset($_SESSION['user_hub_5_notifications']);
      unset($_SESSION['user_hub_5_whispers']);
      unset($_SESSION['user_invites']);

      session_destroy();
      redirect('');
    }
  }
?>
