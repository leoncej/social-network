<?php
  class Messages extends Controller {
    public function __construct(){
      // ensure only logged in users can access the page
      if(!isLoggedIn()){
        redirect('users/login');
      }

      $this->messageModel = $this->model('Message');
      $this->postModel = $this->model('Post');
      $this->userModel = $this->model('User');
      $this->activityModel = $this->model('Activity');
    }

    public function index(){
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

      // get posts
      $data = [
        'id' => $_SESSION['user_id'],
        'hub_id' => $_SESSION['user_hub_id']
      ];

      $messages = $this->messageModel->getMessages($data);

      // filter messages to just one from each chat, the most recent
      $i = -1;
      foreach($messages as $message){
        $instances_of_chat_id = 0;
        $i += 1;
        // delete messages that are now to or from an inactive user
        $toId = $this->userModel->getUserById($message->toId);
        $fromId = $this->userModel->getUserById($message->fromId);
        if($toId && $fromId){
          // skip
        } else {
          die('123');
          // $this->messageModel->deleteMessage($message->messageId);
        }

        // get user profile picture
        if($message->toId != $_SESSION['user_id']){
          $user = $this->userModel->getUserById($message->toId);
        } else {
          $user = $this->userModel->getUserById($message->fromId);
        }

        $message->status = $user->status;
        $message->colour = $user->colour;
        if($user->img){
          // decode b64 to img
          $message->profileImg = base64_decode($user->img);
        } else {
          $message->profileImg = '';
        }

        foreach($messages as $checking_message){
          if($message->chat_id == $checking_message->chat_id){
            $instances_of_chat_id += 1;
            if($instances_of_chat_id > 1){
              unset($messages[$i]);
            }
          }
        }
      }

      // revert to descending order for correct display
      $messages = array_reverse($messages);

      $hubmates = $this->userModel->getHubmates($_SESSION['user_hub_id']);

      foreach($hubmates as $mate){
        // get user profile picture
        if($mate->img){
          // decode b64 to img
          $mate->img = base64_decode($mate->img);
        }
      }

      $data = [
        'removed_from_hub' => $removedFromHub,
        'created_new_hub' => $createdNewHub,
        'messages' => $messages,
        'mates' => $hubmates
      ];

      $this->view('messages/index', $data);
    }

    public function new(){
      $mates = $this->userModel->getHubmates($_SESSION['user_hub_id']);

      // check to see if its  a POST request
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // sanitize POST array
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        if(!empty($_POST['message_two'])){
          // get the ID in parenthesis
          preg_match('#\((.*?)\)#', $_POST['message_two'], $match);
          $toId = $match[1];

          // get the name
          preg_match('/[^(]*/', $_POST['message_two'], $match);
          $toName = $match[0];
        } else {
          $toId = '';
          $toName = '';
        }

        if($toId > $_SESSION['user_id']){
          $chatId = $_SESSION['user_id'] . $toId;
        } else {
          $chatId = $toId . $_SESSION['user_id'];
        }

        // encode b64 string
        $b64 = base64_encode(trim($_POST['whisper_b64_img']));

        $data = [
          'to_id' => $toId,
          'to_name' => $toName,
          'from_id' => $_SESSION['user_id'],
          'from_name' => $_SESSION['user_name'],
          'mates' => $mates,
          'message' => trim($_POST['message']),
          'img' => $b64,
          'chat_id' => $chatId,
          'hub_id' => $_SESSION['user_hub_id'],
          'to_name_err' => '',
          'message_err' => ''
        ];

        // validate data
        if($data['to_name'] == null){
          $data['to_name_err'] = 'Please select the recipient for your whisper';
        }

        if(empty($data['message']) && empty($data['img'])){
          $data['message_err'] = 'Please enter your message or attach an image to send';
        }

        // ensure no errors
        if(empty($data['to_name_err']) && empty($data['message_err'])){
          if($this->messageModel->send($data)){
            redirect('messages/index', $data);
          } else {
            die('Oops! Something went wrong');
          }
        } else {
          // load view with errors
          $this->view('messages/new', $data);
        }

      } else {

        $data = [
          'to_id' => '',
          'to_name' => '',
          'from_id' => $_SESSION['user_id'],
          'from_name' => $_SESSION['user_name'],
          'mates' => $mates,
          'message' => ''
        ];

        $this->view('messages/new', $data);
      }
    }

    public function compose($toId){
      if($toId > $_SESSION['user_id']){
        $chatId = $_SESSION['user_id'] . $toId;
      } else {
        $chatId = $toId . $_SESSION['user_id'];
      }

      // check to see if its  a POST request
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // sanitize POST array
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // encode b64 string
        $b64 = base64_encode(trim($_POST['whisper_b64_img']));

        $data = [
          'to_id' => $toId,
          'to_name' => trim($_POST['to_name']),
          'from_id' => $_SESSION['user_id'],
          'from_name' => $_SESSION['user_name'],
          'chat_id' => $chatId,
          'message' => trim($_POST['message']),
          'img' => $b64,
          'hub_id' => $_SESSION['user_hub_id'],
          'to_name_err' => '',
          'message_err' => ''
        ];

        // validate data
        if(empty($data['to_name'])){
          $data['to_name_err'] = 'Please enter the recipient for your whisper';
        }

        if(empty($data['message']) && empty($data['img'])){
          $data['message_err'] = 'Please enter your message or attach an image to send';
        }

        // ensure no errors
        if(empty($data['to_name_err']) && empty($data['message_err'])){
          if($this->messageModel->send($data)){
            redirect('messages/index', $data);
          } else {
            die('Oops! Something went wrong');
          }
        } else {
          // load view with errors
          $this->view('messages/compose', $data);
        }

      } else {
        // get user name to auto-populate
        $user = $this->userModel->getUserById($toId);

        $userName = $user->name . " " . $user->last_name;
        $data = [
          'to_id' => $toId,
          'to_name' => $userName,
          'from_id' => $_SESSION['user_id'],
          'from_name' => $_SESSION['user_name'],
          'chat_id' => $chatId,
          'message' => ''
        ];

        $this->view('messages/compose', $data);
      }
    }

    public function show($chatId){
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

      $data = [
        'chat_id' => $chatId,
        'hub_id' => $_SESSION['user_hub_id']
      ];

      $messages = $this->messageModel->getMessageChain($data);

      if(empty($messages)){
        $empty = true;
      } else {
        $empty = false;

        // set the seen flag to 1 if the session user is the message recipient
        foreach($messages as $message){
          if($message->to_id == $_SESSION['user_id']){
            if($message->seen == 0){
              $data = [
                'id' => $message->messageId,
                'seen' => 1,
                'seen_at' => date('Y-m-d H:i:s')
              ];

              $this->messageModel->updateMessageSeenFlag($data);
              $chatUserId = $message->from_id;
            }
          } else {
            $chatUserId = $message->to_id;
          }
        }

        $data = [
          'id' => $user->id,
          'seen' => 0,
          'hub_id' => $_SESSION['user_hub_id']
        ];
        $newMessages = $this->messageModel->getAllUnseenUserMessages($data);
        // ommit unseen messages the session user has sent
        $messageCounter = 0;
        foreach($newMessages as $message){
          if($message->fromId == $_SESSION['user_id']){
            $messageCounter += 1;
          }
        }

        if($_SESSION['user_hub_id'] == $user->hub_1_id){
          $_SESSION['user_hub_1_whispers'] = count($newMessages) - $messageCounter;
        } elseif($_SESSION['user_hub_id'] == $user->hub_2_id){
          $_SESSION['user_hub_2_whispers'] = count($newMessages) - $messageCounter;
        } elseif($_SESSION['user_hub_id'] == $user->hub_3_id){
          $_SESSION['user_hub_3_whispers'] = count($newMessages) - $messageCounter;
        } elseif($_SESSION['user_hub_id'] == $user->hub_4_id){
          $_SESSION['user_hub_4_whispers'] = count($newMessages) - $messageCounter;
        } elseif($_SESSION['user_hub_id'] == $user->hub_5_id){
          $_SESSION['user_hub_5_whispers'] = count($newMessages) - $messageCounter;
        }
      }

      // check to see if its  a POST request
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // sanitize POST array
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        if(isset($_POST['pingBtn'])){
          $data = [
            'removed_from_hub' => $removedFromHub,
            'created_new_hub' => $createdNewHub,
            'empty' => false,
            'to_id' => $_POST['to_id'],
            'to_name' => $_POST['to_name'],
            'from_id' => $_SESSION['user_id'],
            'from_name' => $_SESSION['user_name'],
            'chat_id' => $chatId,
            'img' => '',
            'message' => 'PSST!!',
            'hub_id' => $_SESSION['user_hub_id'],
            'messages' => $messages,
            'message_err' => ''
          ];

          // ensure no errors
          if(empty($data['message_err'])){
            if($this->messageModel->send($data)){
              redirect('messages/show/' . $chatId, $data);
            } else {
              die('Oops! Something went wrong');
            }
          }
        }

        // encode b64 string
        $b64 = base64_encode(trim($_POST['whisper_b64_img']));

        $data = [
          'removed_from_hub' => $removedFromHub,
          'created_new_hub' => $createdNewHub,
          'empty' => false,
          'to_id' => $_POST['to_id'],
          'to_name' => $_POST['to_name'],
          'from_id' => $_SESSION['user_id'],
          'from_name' => $_SESSION['user_name'],
          'chat_id' => $chatId,
          'img' => $b64,
          'message' => trim($_POST['message']),
          'hub_id' => $_SESSION['user_hub_id'],
          'messages' => $messages,
          'message_err' => ''
        ];

        // validate data
        if(empty($data['message']) && empty($data['img'])){
          $data['message_err'] = 'Please enter your message or attach an image to send';
        }

        // ensure no errors
        if(empty($data['message_err'])){
          if($this->messageModel->send($data)){
            redirect('messages/show/' . $chatId, $data);
          } else {
            die('Oops! Something went wrong');
          }

        } else {
          $messages = $this->messageModel->getMessageChain($data);

          if(empty($messages)){
            $toId = str_replace($_SESSION['user_id'], "", $chatId);
            $user = $this->userModel->getUserById($toId);

            if($user->img){
              // decode b64 to img
              $img = base64_decode($user->img);
            } else {
              $img = '';
            }

            $data = [
              'removed_from_hub' => $removedFromHub,
              'created_new_hub' => $createdNewHub,
              'empty' => true,
              'chat_id' => $chatId,
              'status' => $user->status,
              'colour' => $user->colour,
              'img' => $img,
              'to_name' => $user->name . " " . $user->last_name,
              'to_id' => $toId,
              'message_err' => 'Please enter your message or attach an image to send'
            ];

            // load view with errors
            $this->view('messages/show', $data);
          } else {
            // get Hubmate profile picture
            $user = $this->userModel->getUserById($chatUserId);
            $status = $user->status;
            $colour = $user->colour;
            if($user->img){
              // decode b64 to img
              $img = base64_decode($user->img);
            } else {
              $img = '';
            }

            $data = [
              'chat_id' => $chatId,
              'hub_id' => $_SESSION['user_hub_id']
            ];

            $data['removed_from_hub'] = $removedFromHub;
            $data['created_new_hub'] = $createdNewHub;
            $data['messages'] = $messages;
            $data['empty'] = false;
            $data['chat_id'] = $chatId;
            $data['empty'] = false;
            $data['status'] = $status;
            $data['colour'] = $colour;
            $data['img'] = $img;
            $data['message_err'] = 'Please enter your message or attach an image to send';

            // decode any imgs
            foreach($messages as $message){
              if($message->img){
                $message->img = base64_decode($message->img);
              }
              // latest message flag
              $message->latest = 0;
            }

            // flag the most recent message for delivered/seen flag
            end($messages)->latest = 1;

            // load view with errors
            $this->view('messages/show', $data);
          }
        }

      } elseif(!empty($messages)) {
        foreach($messages as $message){
          if($message->to_id == $_SESSION['user_id']){
              $chatUserId = $message->from_id;
            } else {
              $chatUserId = $message->to_id;
            }
          }

        // get Hubmate profile picture
        $user = $this->userModel->getUserById($chatUserId);
        $status = $user->status;
        $colour = $user->colour;
        if($user->img){
          // decode b64 to img
          $img = base64_decode($user->img);
        } else {
          $img = '';
        }

        // decode any imgs
        foreach($messages as $message){
          if($message->img){
            $message->img = base64_decode($message->img);
          }
          // latest message flag
          $message->latest = 0;
        }

        // flag the most recent message for delivered/seen flag
        end($messages)->latest = 1;

        $data = [
          'removed_from_hub' => $removedFromHub,
          'created_new_hub' => $createdNewHub,
          'empty' => false,
          'status' => $status,
          'colour' => $colour,
          'img' => $img,
          'messages' => $messages
        ];

        $this->view('messages/show', $data);
      } else {
        $toId = str_replace($_SESSION['user_id'], "", $chatId);
        $user = $this->userModel->getUserById($toId);

        if($user->img){
          // decode b64 to img
          $img = base64_decode($user->img);
        } else {
          $img = '';
        }

        $data = [
          'removed_from_hub' => $removedFromHub,
          'created_new_hub' => $createdNewHub,
          'empty' => true,
          'chat_id' => $chatId,
          'status' => $user->status,
          'colour' => $user->colour,
          'img' => $img,
          'to_name' => $user->name . " " . $user->last_name,
          'to_id' => $toId,
          'message_err' => ''
        ];

        $this->view('messages/show', $data);
      }
    }
  }
?>
