<?php
  class Pages extends Controller {
    public function __construct(){
      $this->postModel = $this->model('Post');
      $this->userModel = $this->model('User');
      $this->commentModel = $this->model('Comment');
      $this->messageModel = $this->model('Message');
      $this->hubModel = $this->model('Hub');
      $this->inviteModel = $this->model('Invite');
      $this->activityModel = $this->model('Activity');
    }

    public function index(){
      if(isLoggedIn()){
        redirect('posts/index');
      }

      // $this->view('pages/index', $data);
      $this->view('pages/index');
    }

    public function about(){
      if(isLoggedIn()){
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
      } else {
        $removedFromHub = '';
        $createdNewHub = 0;
      }

      $data = [
        'removed_from_hub' => $removedFromHub,
        'created_new_hub' => $createdNewHub,
        'title' => 'How TheHub works',
        'intro' => 'Social networks are the new norm for how many of us keep in touch with one another, but imagine one where you can feel free to post whatever you wish, knowing only your closest family and friends would see. One that you can feel as though you own. One that can be a more creative replacement for a group chat: Welcome to TheHub',
        'subIntro' => 'Here you have a place where you can escape and feel comfortable enough to not just be yourself, but to express who you really are. In TheHub you have total control, and with that control, you can create the world you really want to live in; no strangers, no distractions, just you and those closest',
        'heading1' => 'Make your own Hubs',
        'description1' => "Ever fancied a whole social networking site just for your own group chats? Welcome to your Hub. With you being in full control as to who is in your Hub and whose invited, you can create your own social Hubs and flick between them as you wish. Have a friendsHub, a familyHub, a workHub, or a whatever-you-want-to-call-it-Hub. Be in control of who you interact with and how",
        'heading2' => 'Connect with your Hubmates +',
        'description2' => "Gone are the days where you receive requests from strangers or feel restricted as to what you can post because you're not quite sure whose watching. Each user has a unique ID and this is how you can find and add your Hubmates to eliminate the ability of strangers stumbling across you or your Hub. Simply search for your Hubmates ID and invite them to your Hub",
        'heading3' => 'Shout all about it!',
        'description3' => "Feeling like you want to share something with your Hubmates for them to view, star and comment? Shout about it! Our Shout feature is the way you can share something for all your Hubmates to view and interact with",
        'heading4' => 'Stars Stars Stars',
        'description4' => "If you like what someone shouted, star it! If you agree with what someone is shouting, star it! Or if you just want to be that supportive friend and show you've got their back, star it! Stars are a quick way to show your appreciation for what someone is shouting. Get enough stars on your own Shouts and you can unlock the Bronze, Silver and Gold accounts",
        'heading5' => 'Shh! Let me tell you something...',
        'description5' => "Sometimes, even amongst your friends and family, things aren't worth shouting about. Here in your Hub you can send Whispers to your Hubmates and only the recipient will see this message. Send images, view when your Whisper has been seen, and should you really need a Hubmates attention, 'PSST!! them. 'PSST!!' is a button that sends an attention grabbing message, so you can be ignored no more!"
      ];
      $this->view('pages/about', $data);
    }

    public function help(){
      if(isLoggedIn()){
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
      } else {
        $removedFromHub = '';
        $createdNewHub = 0;
      }

      $data = [
        'removed_from_hub' => $removedFromHub,
        'created_new_hub' => $createdNewHub,
        'title' => 'How TheHub works',
        'intro' => 'Social networks are the new norm for how many of us keep in touch with one another, but imagine one where you can feel free to post whatever you wish, knowing only your closest family and friends would see. One that you can feel as though you own. One that can be a more creative replacement for a group chat: Welcome to TheHub',
        'heading1' => 'Make your own Hubs',
        'description1' => "Ever fancied a whole social networking site just for your own group chats? Welcome to your Hub. With you being in full control as to who is in your Hub and whose invited, you can create your own social Hubs and flick between them as you wish. Have a friendsHub, a familyHub, a workHub, or a whatever-you-want-to-call-it-Hub. Be in control of who you interact with and how",
        'heading2' => 'Connect with your Hubmates +',
        'description2' => "Gone are the days where you receive requests from strangers or feel restricted as to what you can post because you're not quite sure whose watching. Each user has a unique ID and this is how you can find and add your Hubmates to eliminate the ability of strangers stumbling across you or your Hub. Simply search for your Hubmates ID and invite them to your Hub",
        'heading3' => 'Shout all about it!',
        'description3' => "Feeling like you want to share something with your Hubmates for them to view, star and comment? Shout about it! Our Shout feature is the way you can share something for all your Hubmates to view and interact with",
        'heading4' => 'Stars Stars Stars',
        'description4' => "If you like what someone shouted, star it! If you agree with what someone is shouting, star it! Or if you just want to be that supportive friend and show you've got their back, star it! Stars are a quick way to show your appreciation for what someone is shouting. Get enough stars on your own Shouts and you can unlock the Bronze, Silver and Gold accounts",
        'heading5' => 'Shh! Let me tell you something...',
        'description5' => "Sometimes, even amongst your friends and family, things aren't worth shouting about. Here in your Hub you can send Whispers to your Hubmates and only the recipient will see this message. Send images, view when your Whisper has been seen, and should you really need a Hubmates attention, 'PSST!! them. 'PSST!!' is a button that sends an attention grabbing message, so you can be ignored no more!"
      ];
      $this->view('pages/help', $data);
    }

    public function notifications(){
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

      $hubPosts = $this->postModel->getPostsByHubId($_SESSION['user_hub_id']);
      $comments = $this->commentModel->getCommentsByHubId($_SESSION['user_hub_id']);

      // set the current Hubs activity to 0
      if($_SESSION['user_hub_id'] == $_SESSION['user_hub_1_id']){
        $_SESSION['user_hub_1_notifications'] = 0;
      } elseif($_SESSION['user_hub_id'] == $_SESSION['user_hub_2_id']){
        $_SESSION['user_hub_2_notifications'] = 0;
      } elseif($_SESSION['user_hub_id'] == $_SESSION['user_hub_3_id']){
        $_SESSION['user_hub_3_notifications'] = 0;
      } elseif($_SESSION['user_hub_id'] == $_SESSION['user_hub_4_id']){
        $_SESSION['user_hub_4_notifications'] = 0;
      } elseif($_SESSION['user_hub_id'] == $_SESSION['user_hub_5_id']){
        $_SESSION['user_hub_5_notifications'] = 0;
      }

      $hubActivity = $this->activityModel->getActivitiesByHubId($_SESSION['user_hub_id']);

      // update the seen flag
      $postActivityData = [
        'to_id' => $_SESSION['user_id'],
        'seen' => 0
      ];
      $unseenActivities = $this->activityModel->getActivitiesByToId($postActivityData);

      foreach($unseenActivities as $unseenActivity){
        $data = [
          'id' => $unseenActivity->id,
          'seen' => 1
        ];
        $this->activityModel->updatePostActivitySeenFlag($data);
      }

      // add the date key
      foreach($hubPosts as $post){
        // check if post contains an image
        if($post->postImg){
          $post->postImg = base64_decode($post->postImg);
        } else {
          $post->postImg = '';
        }
        // get user profile picture
        $postUser = $this->userModel->getUserById($post->userId);
        $post->colour = $postUser->colour;
        if($postUser->img){
          // decode b64 to img
          $post->img = base64_decode($postUser->img);
        } else {
          $post->img = '';
        }

        $post->date = $post->postCreated;
        $post->pointer = 'POST';
      }
      foreach($hubActivity as $activity){
        // check the user is still in the db
        if($this->userModel->getUserById($activity->user_id)){
          $activity->deletedAccount = 0;
        } else {
          $activity->user_id = '';
          $activity->deletedAccount = 1;
        }

        $activity->date = $activity->activityCreated;
        $activity->pointer = 'ACTIVITY';

        if($activity->type == 'Name'){
          // get user profile picture
          $activityUser = $this->userModel->getUserById($activity->user_id);
          $activity->colour = $activityUser->colour;
          if($activityUser->img){
            // decode b64 to img
            $activity->img = base64_decode($activityUser->img);
          } else {
            $activity->img = '';
          }
          $activity->pointer = 'NAME';
        } elseif($activity->type == 'Remove'){
          // check the remover user is still in the db
          if($this->userModel->getUserById($activity->remover_id)){
            $activity->deletedRemoverAccount = 0;
          } else {
            $activity->remover_id = '';
            $activity->deletedRemoverAccount = 1;
          }

          // get remover profile picture
          $removerUser = $this->userModel->getUserById($activity->remover_id);
          $activity->removerColour = $removerUser->colour;
          if($removerUser->img){
            // decode b64 to img
            $activity->removerImg = base64_decode($removerUser->img);
          } else {
            $activity->removerImg = '';
          }
          $activity->pointer = 'REMOVE';
        } elseif($activity->type == 'Star'){
          // get post info
          $post = $this->postModel->getPostById($activity->post_id);
          $activity->postUserId = $post->user_id;
          $postUser = $this->userModel->getUserById($post->user_id);
          $activity->postUserName = $postUser->name . " " . $postUser->last_name;

          // get user profile picture
          $activityUser = $this->userModel->getUserById($activity->user_id);
          $activity->colour = $activityUser->colour;
          if($activityUser->img){
            // decode b64 to img
            $activity->img = base64_decode($activityUser->img);
          } else {
            $activity->img = '';
          }
          $activity->pointer = 'STAR';
        }
      }
      foreach($comments as $comment){
        // get post author
        $post = $this->postModel->getPostById($comment->postId);
        $postAuthor = $this->userModel->getUserById($post->user_id);
        $comment->postUserId = $postAuthor->id;
        $comment->postUser = $postAuthor->name . " " . $postAuthor->last_name;

        // get user profile picture
        $commentUser = $this->userModel->getUserById($comment->fromId);
        $comment->colour = $commentUser->colour;
        if($commentUser->img){
          // decode b64 to img
          $comment->img = base64_decode($commentUser->img);
        } else {
          $comment->img = '';
        }

        // set the seen flag to 1
        $data = [
          'id' => $comment->commentId,
          'seen' => 1
        ];
        $this->commentModel->updateCommentSeenFlag($data);

        $comment->date = $comment->commentCreated;
        $comment->pointer = 'COMMENT';
      }

      $hubActivityReversed = array_reverse($hubActivity);
      foreach($hubActivityReversed as $activity){
        // get the date the logged in user joined the sessions Hub
        if($activity->type == 'Join'){
          if($activity->user_id == $_SESSION['user_id']){
            $joined = $activity->created_at;
          }
        }
      }

      $allActivity = array_merge($comments, $hubPosts, $hubActivity);

      // sort by date
      function date_compare($element1, $element2){
        $datetime1 = strtotime($element1->date);
        $datetime2 = strtotime($element2->date);
        return $datetime1 - $datetime2;
      }

      usort($allActivity, 'date_compare');

      // descending order
      $allActivity = array_reverse($allActivity);

      $data = [
        'removed_from_hub' => $removedFromHub,
        'created_new_hub' => $createdNewHub,
        'activities' => $allActivity,
        'joined' => $joined
      ];

      $this->view('pages/notifications', $data);
    }

    public function invites(){
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
      // check for Hub invites
      $invites = $this->inviteModel->getInviteByUserId($_SESSION['user_id']);
      // set the seen flag to 1
      foreach($invites as $invite){
        // check the user is still in the db
        if($this->userModel->getUserById($invite->from_id)){
          $invite->deletedAccount = 0;
          // get user profile picture
          $inviteUser = $this->userModel->getUserById($invite->fromId);
          $invite->colour = $inviteUser->colour;
          if($inviteUser->img){
            // decode b64 to img
            $invite->img = base64_decode($inviteUser->img);
          } else {
            $invite->img = '';
          }
        } else {
          $invite->user_id = '';
          $invite->deletedAccount = 1;
        }

        $data = [
          'id' => $invite->id,
          'seen' => 1
        ];
        $this->inviteModel->updateInviteSeenFlag($data);
      }


      // check the user has an available Hub in their Database
      if($user->hub_1_id != 0 && $user->hub_2_id != 0 && $user->hub_3_id != 0 && $user->hub_4_id != 0 && $user->hub_5_id != 0){
        // user already is in 5 Hubs so is unable to accept the invite
        $data = [
          'removed_from_hub' => $removedFromHub,
          'created_new_hub' => $createdNewHub,
          'invites' => $invites,
          'hubLimitReached' => 1
        ];
        $this->view('pages/invites', $data);
      }

      // set invites number back to 0 as they have now been seen
      $_SESSION['user_invites'] = 0;

      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // sanitize POST array
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        if(isset($_POST['acceptBtn'])){
          $inviteId = trim($_POST['inviteId']);

          $inviteAcceptData = [
            'id' => $inviteId,
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
              'removed_from_hub' => $removedFromHub,
              'created_new_hub' => $createdNewHub,
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
              'removed_from_hub' => $removedFromHub,
              'created_new_hub' => $createdNewHub,
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
              'removed_from_hub' => $removedFromHub,
              'created_new_hub' => $createdNewHub,
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
              'removed_from_hub' => $removedFromHub,
              'created_new_hub' => $createdNewHub,
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
              'removed_from_hub' => $removedFromHub,
              'created_new_hub' => $createdNewHub,
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
          $data = [
            'removed_from_hub' => $removedFromHub,
            'created_new_hub' => $createdNewHub,
            'id' => $invite->inviteId,
            'accepted' => 0,
            'declined' => 1
          ];
          $this->inviteModel->updateInviteResponse($data);

          // delete invite
          $this->inviteModel->deleteInvite($invite->id);

          redirect('pages/invites', $data);
        }
      }

      $invites = array_reverse($invites);

      $data = [
        'removed_from_hub' => $removedFromHub,
        'created_new_hub' => $createdNewHub,
        'invites' => $invites,
        'hubLimitReached' => 0
      ];
      $this->view('pages/invites', $data);
    }

    public function settings(){
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
      $mates = $this->userModel->getHubmates($_SESSION['user_hub_id']);

      $defaultHub = $user->hub_id;
      $noOfHubs = 5;
      $noOfMates = count($mates);

      // count how many hubs the session user is include in
      if($user->hub_1_id != 0){
        $noOfHubs -= 1;
      }
      if($user->hub_2_id != 0){
        $noOfHubs -= 1;
      }
      if($user->hub_3_id != 0){
        $noOfHubs -= 1;
      }
      if($user->hub_4_id != 0){
        $noOfHubs -= 1;
      }
      if($user->hub_5_id != 0){
        $noOfHubs -= 1;
      }

      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // sanitize POST array
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        if(isset($_POST['updateHubnameBtn'])){
          $data = [
            'removed_from_hub' => $removedFromHub,
            'created_new_hub' => $createdNewHub,
            'default_hub' => $defaultHub,
            'id' => $_SESSION['user_hub_id'],
            'name' => trim($_POST['hubname']),
            'hubname_err' => '',
            'no_of_hubs' => $noOfHubs,
            'no_of_mates' => $noOfMates,
            'user' => $user
          ];

          // validate data
          if(empty($data['name'])){
            $error = 'Please enter a name for your Hub';
            $data['hubname_err'] = 'Please enter a name for your Hub';
          } elseif($data['name'] == $_SESSION['user_hub']){
            $error = 'Hubname is already in use';
            $data['hubname_err'] = 'This is alreaady the Hubname in use';
          } elseif(strlen($data['name']) > 20){
            $error = 'Hubname entered is too long';
            $data['hubname_err'] = 'Hubname must be less than 20 characters long';
          } elseif(preg_match('/\s/', $data['name'])){
            $error = 'Hubname cannot contain any spaces';
            $data['hubname_err'] = 'Hubname cannot contain any spaces';
          }

          // ensure no errors
          if(empty($data['hubname_err'])){
            if($this->hubModel->updateHubname($data)){
              flash('success_message', 'Updated Hubname');
              $hubName = $this->hubModel->getHubById($_SESSION['user_hub_id'])->name;
              if($_SESSION['user_hub_1_id'] == $_SESSION['user_hub_id']){
                $_SESSION['user_hub_1'] = $hubName;
              } elseif($_SESSION['user_hub_2_id'] == $_SESSION['user_hub_id']){
                $_SESSION['user_hub_2'] = $hubName;
              } elseif($_SESSION['user_hub_3_id'] == $_SESSION['user_hub_id']){
                $_SESSION['user_hub_3'] = $hubName;
              } elseif($_SESSION['user_hub_4_id'] == $_SESSION['user_hub_id']){
                $_SESSION['user_hub_4'] = $hubName;
              } elseif($_SESSION['user_hub_5_id'] == $_SESSION['user_hub_id']){
                $_SESSION['user_hub_5'] = $hubName;
              }
              $_SESSION['user_hub'] = $hubName;

              // update hubs activity
              $activityData = [
                'hub_id' => $_SESSION['user_hub_id'],
                'hub' => trim($_POST['hubname']),
                'user_id' => $_SESSION['user_id'],
                'user' => $_SESSION['user_name'],
                'type' => 'Name',
                'to_id' => 0,
                'post_id' => 0,
                'comment_id' => 0,
                'remover_id' => 0,
                'remover_name' => '',
                'notify_user' => 0
              ];

              $this->activityModel->addActivity($activityData);

              redirect('posts/index', $data);
            } else {
              die('Oops! Something went wrong');
            }
          } else {
            errorFlash('error_message', $error);
            // load view with errors
            $this->view('pages/settings', $data);
          }
        } elseif(isset($_POST['makeDefaultHubBtn'])){
          $data = [
            'removed_from_hub' => $removedFromHub,
            'created_new_hub' => $createdNewHub,
            'id' => $_SESSION['user_id'],
            'hub' => $_SESSION['user_hub'],
            'hub_id' => $_SESSION['user_hub_id']
          ];

          if($this->userModel->updateUserDefaultHub($data)){
            flash('success_message', 'Changed Default Hub');
            redirect('posts/index', $data);
          } else {
            die('Oops! Something went wrong');
          }
        } elseif(isset($_POST['createNewHubBtn'])){
          $data = [
            'removed_from_hub' => $removedFromHub,
            'created_new_hub' => $createdNewHub,
            'default_hub' => $defaultHub,
            'hubname' => trim($_POST['new_hubname']),
            'new_hubname_err' => '',
            'no_of_hubs' => $noOfHubs,
            'no_of_mates' => $noOfMates,
            'user' => $user
          ];

          // validate data
          if(empty($data['hubname'])){
            $error = 'Please enter a name for your new Hub';
            $data['new_hubname_err'] = 'Please enter a name for your new Hub';
          } elseif(strlen($data['hubname']) > 20){
            $error = 'New Hubname entered is too long';
            $data['new_hubname_err'] = 'Hubname must be less than 20 characters long';
          } elseif(preg_match('/\s/', $data['hubname'])){
            $error = 'Hubname cannot contain any spaces';
            $data['new_hubname_err'] = 'Hubname cannot contain any spaces';
          }

          // ensure no errors
          if(empty($data['new_hubname_err'])){
            $id = $this->hubModel->addHub($data);
            if($id){
              flash('success_message', 'New Hub Created');
              // switch to the new hub and divert to search Hubmates page
              $_SESSION['user_hub_id'] = $id;
              $_SESSION['user_hub'] = $data['hubname'];

              // sessions for the navbar
              if($_SESSION['user_hub_1_id'] == 0){
                $_SESSION['user_hub_1_id'] = $id;
                $_SESSION['user_hub_1'] = $data['hubname'];
              } elseif($_SESSION['user_hub_2_id'] == 0){
                $_SESSION['user_hub_2_id'] = $id;
                $_SESSION['user_hub_2'] = $data['hubname'];
              } elseif($_SESSION['user_hub_3_id'] == 0){
                $_SESSION['user_hub_3_id'] = $id;
                $_SESSION['user_hub_3'] = $data['hubname'];
              } elseif($_SESSION['user_hub_4_id'] == 0){
                $_SESSION['user_hub_4_id'] = $id;
                $_SESSION['user_hub_4'] = $data['hubname'];
              } elseif($_SESSION['user_hub_5_id'] == 0){
                $_SESSION['user_hub_5_id'] = $id;
                $_SESSION['user_hub_5'] = $data['hubname'];
              }

              // store new hub in users databases
              if($user->hub_1_id == 0){
                $data = [
                  'id' => $_SESSION['user_id'],
                  'hub_id' => $id
                ];
                $this->userModel->updateHub1($data);
              } elseif($user->hub_2_id == 0){
                $data = [
                  'id' => $_SESSION['user_id'],
                  'hub_id' => $id
                ];
                $this->userModel->updateHub2($data);
              } elseif($user->hub_3_id == 0){
                $data = [
                  'id' => $_SESSION['user_id'],
                  'hub_id' => $id
                ];
                $this->userModel->updateHub3($data);
              } elseif($user->hub_4_id == 0){
                $data = [
                  'id' => $_SESSION['user_id'],
                  'hub_id' => $id
                ];
                $this->userModel->updateHub4($data);
              } elseif($user->hub_5_id == 0){
                $data = [
                  'id' => $_SESSION['user_id'],
                  'hub_id' => $id
                ];
                $this->userModel->updateHub5($data);
              }
              redirect('posts/index', $data);
            } else {
              die('Oops! Something went wrong');
            }
          } else {
            errorFlash('error_message', $error);
            // load view with errors
            $this->view('pages/settings', $data);
          }
        } elseif(isset($_POST['leaveHubBtn'])){
          // button will be disabled if this is the users only Hub so there is no need to hanlde this logic here
          $data = [
            'removed_from_hub' => $removedFromHub,
            'created_new_hub' => $createdNewHub,
            'id' => $_SESSION['user_id'],
            'hub_id' => 0
          ];

          if($user->hub_1_id == $_SESSION['user_hub_id']){
            if($this->userModel->updateHub1($data)){
              // if the sessions Hub has no more users delete the Hub
              if($noOfMates == 1){
                // delete all outstanding invites to the Hub before deleting
                $hubInvites = $this->inviteModel->getAllHubInvites($_SESSION['user_hub_id']);
                foreach($hubInvites as $invite){
                  $this->inviteModel->deleteInvite($invite->id);
                }
                $this->hubModel->deleteHub($_SESSION['user_hub_id']);
              }

              if($user->hub_2_id != 0){
                // delete all posts and comments made by the user in that Hub
                $hubPosts = $this->postModel->getPostsByHubId($_SESSION['user_hub_id']);
                foreach($hubPosts as $post){
                  if($post->user_id == $_SESSION['user_id']){
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
                  'from_id' => $_SESSION['user_id'],
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
                  'id' => $_SESSION['user_id'],
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userMessages = $this->messageModel->getMessages($messagesData);

                foreach($userMessages as $message){
                  $this->messageModel->deleteMessage($message->messageId);
                }

                // update hubs activity
                $activityData = [
                  'hub_id' => $_SESSION['user_hub_id'],
                  'hub' => $_SESSION['user_hub'],
                  'user_id' => $_SESSION['user_id'],
                  'user' => $_SESSION['user_name'],
                  'type' => 'Leave',
                  'to_id' => 0,
                  'post_id' => 0,
                  'comment_id' => 0,
                  'remover_id' => 0,
                  'remover_name' => '',
                  'notify_user' => 0
                ];

                $this->activityModel->addActivity($activityData);

                // switch to the new hub and divert to search Hubmates page
                $_SESSION['user_hub_1_id'] = 0;
                $_SESSION['user_hub_1'] = '';
                $_SESSION['user_hub_id'] = $user->hub_2_id;
                $hub = $this->hubModel->getHubById($user->hub_2_id);
                $_SESSION['user_hub'] = $hub->name;

                // check if the left Hub was their default and change if so to avoid complications on future sign ins
                $data = [
                  'removed_from_hub' => $removedFromHub,
                  'created_new_hub' => $createdNewHub,
                  'id' => $_SESSION['user_id'],
                  'hub' => $_SESSION['user_hub'],
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $this->userModel->updateUserDefaultHub($data);

                errorFlash('success_message', 'Hub Left');
                $_SESSION['flash_error_message'] = 'Hub Left';
                redirect('posts/index');
              } elseif($user->hub_3_id != 0){
                // delete all posts and comments made by the user in that Hub
                $hubPosts = $this->postModel->getPostsByHubId($_SESSION['user_hub_id']);
                foreach($hubPosts as $post){
                  if($post->user_id == $_SESSION['user_id']){
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
                  'from_id' => $_SESSION['user_id'],
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
                  'id' => $_SESSION['user_id'],
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userMessages = $this->messageModel->getMessages($messagesData);

                foreach($userMessages as $message){
                  $this->messageModel->deleteMessage($message->messageId);
                }

                // update hubs activity
                $activityData = [
                  'hub_id' => $_SESSION['user_hub_id'],
                  'hub' => $_SESSION['user_hub'],
                  'user_id' => $_SESSION['user_id'],
                  'user' => $_SESSION['user_name'],
                  'type' => 'Leave',
                  'to_id' => 0,
                  'post_id' => 0,
                  'comment_id' => 0,
                  'remover_id' => 0,
                  'remover_name' => '',
                  'notify_user' => 0
                ];

                $this->activityModel->addActivity($activityData);

                // switch to the new hub and divert to search Hubmates page
                $_SESSION['user_hub_1_id'] = 0;
                $_SESSION['user_hub_1'] = '';
                $_SESSION['user_hub_id'] = $user->hub_3_id;
                $hub = $this->hubModel->getHubById($user->hub_3_id);
                $_SESSION['user_hub'] = $hub->name;

                // check if the left Hub was their default and change if so to avoid complications on future sign ins
                $data = [
                  'removed_from_hub' => $removedFromHub,
                  'created_new_hub' => $createdNewHub,
                  'id' => $_SESSION['user_id'],
                  'hub' => $_SESSION['user_hub'],
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $this->userModel->updateUserDefaultHub($data);

                errorFlash('success_message', 'Hub Left');
                $_SESSION['flash_error_message'] = 'Hub Left';
                redirect('posts/index');
              } elseif($user->hub_4_id != 0){
                // delete all posts and comments made by the user in that Hub
                $hubPosts = $this->postModel->getPostsByHubId($_SESSION['user_hub_id']);
                foreach($hubPosts as $post){
                  if($post->user_id == $_SESSION['user_id']){
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
                  'from_id' => $_SESSION['user_id'],
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
                  'id' => $_SESSION['user_id'],
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userMessages = $this->messageModel->getMessages($messagesData);

                foreach($userMessages as $message){
                  $this->messageModel->deleteMessage($message->messageId);
                }

                // update hubs activity
                $activityData = [
                  'hub_id' => $_SESSION['user_hub_id'],
                  'hub' => $_SESSION['user_hub'],
                  'user_id' => $_SESSION['user_id'],
                  'user' => $_SESSION['user_name'],
                  'type' => 'Leave',
                  'to_id' => 0,
                  'post_id' => 0,
                  'comment_id' => 0,
                  'remover_id' => 0,
                  'remover_name' => '',
                  'notify_user' => 0
                ];

                $this->activityModel->addActivity($activityData);

                // switch to the new hub and divert to search Hubmates page
                $_SESSION['user_hub_1_id'] = 0;
                $_SESSION['user_hub_1'] = '';
                $_SESSION['user_hub_id'] = $user->hub_4_id;
                $hub = $this->hubModel->getHubById($user->hub_4_id);
                $_SESSION['user_hub'] = $hub->name;

                // check if the left Hub was their default and change if so to avoid complications on future sign ins
                $data = [
                  'removed_from_hub' => $removedFromHub,
                  'created_new_hub' => $createdNewHub,
                  'id' => $_SESSION['user_id'],
                  'hub' => $_SESSION['user_hub'],
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $this->userModel->updateUserDefaultHub($data);

                errorFlash('success_message', 'Hub Left');
                $_SESSION['flash_error_message'] = 'Hub Left';
                redirect('posts/index');
              } elseif($user->hub_5_id != 0){
                // delete all posts and comments made by the user in that Hub
                $hubPosts = $this->postModel->getPostsByHubId($_SESSION['user_hub_id']);
                foreach($hubPosts as $post){
                  if($post->user_id == $_SESSION['user_id']){
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
                  'from_id' => $_SESSION['user_id'],
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
                  'id' => $_SESSION['user_id'],
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userMessages = $this->messageModel->getMessages($messagesData);

                foreach($userMessages as $message){
                  $this->messageModel->deleteMessage($message->messageId);
                }

                // update hubs activity
                $activityData = [
                  'hub_id' => $_SESSION['user_hub_id'],
                  'hub' => $_SESSION['user_hub'],
                  'user_id' => $_SESSION['user_id'],
                  'user' => $_SESSION['user_name'],
                  'type' => 'Leave',
                  'to_id' => 0,
                  'post_id' => 0,
                  'comment_id' => 0,
                  'remover_id' => 0,
                  'remover_name' => '',
                  'notify_user' => 0
                ];

                $this->activityModel->addActivity($activityData);

                // switch to the new hub and divert to search Hubmates page
                $_SESSION['user_hub_1_id'] = 0;
                $_SESSION['user_hub_1'] = '';
                $_SESSION['user_hub_id'] = $user->hub_5_id;
                $hub = $this->hubModel->getHubById($user->hub_5_id);
                $_SESSION['user_hub'] = $hub->name;

                // check if the left Hub was their default and change if so to avoid complications on future sign ins
                $data = [
                  'removed_from_hub' => $removedFromHub,
                  'created_new_hub' => $createdNewHub,
                  'id' => $_SESSION['user_id'],
                  'hub' => $_SESSION['user_hub'],
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $this->userModel->updateUserDefaultHub($data);

                errorFlash('success_message', 'Hub Left');
                $_SESSION['flash_error_message'] = 'Hub Left';
                redirect('posts/index');
              }
            } else {
              die('Oops! Something went wrong');
            }
          } elseif($user->hub_2_id == $_SESSION['user_hub_id']){
            if($this->userModel->updateHub2($data)){
              // if the sessions Hub has no more users delete the Hub
              if($noOfMates == 1){
                // delete all outstanding invites to the Hub before deleting
                $hubInvites = $this->inviteModel->getAllHubInvites($_SESSION['user_hub_id']);
                foreach($hubInvites as $invite){
                  $this->inviteModel->deleteInvite($invite->id);
                }
                $this->hubModel->deleteHub($_SESSION['user_hub_id']);
              }

              if($user->hub_1_id != 0){
                // delete all posts and comments made by the user in that Hub
                $hubPosts = $this->postModel->getPostsByHubId($_SESSION['user_hub_id']);
                foreach($hubPosts as $post){
                  if($post->user_id == $_SESSION['user_id']){
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
                  'from_id' => $_SESSION['user_id'],
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
                  'id' => $_SESSION['user_id'],
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userMessages = $this->messageModel->getMessages($messagesData);

                foreach($userMessages as $message){
                  $this->messageModel->deleteMessage($message->messageId);
                }

                // update hubs activity
                $activityData = [
                  'hub_id' => $_SESSION['user_hub_id'],
                  'hub' => $_SESSION['user_hub'],
                  'user_id' => $_SESSION['user_id'],
                  'user' => $_SESSION['user_name'],
                  'type' => 'Leave',
                  'to_id' => 0,
                  'post_id' => 0,
                  'comment_id' => 0,
                  'remover_id' => 0,
                  'remover_name' => '',
                  'notify_user' => 0
                ];

                $this->activityModel->addActivity($activityData);

                // switch to the new hub and divert to search Hubmates page
                $_SESSION['user_hub_2_id'] = 0;
                $_SESSION['user_hub_2'] = '';
                $_SESSION['user_hub_id'] = $user->hub_1_id;
                $hub = $this->hubModel->getHubById($user->hub_1_id);
                $_SESSION['user_hub'] = $hub->name;

                // check if the left Hub was their default and change if so to avoid complications on future sign ins
                $data = [
                  'removed_from_hub' => $removedFromHub,
                  'created_new_hub' => $createdNewHub,
                  'id' => $_SESSION['user_id'],
                  'hub' => $_SESSION['user_hub'],
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $this->userModel->updateUserDefaultHub($data);

                errorFlash('success_message', 'Hub Left');
                $_SESSION['flash_error_message'] = 'Hub Left';
                redirect('posts/index');
              } elseif($user->hub_3_id != 0){
                // delete all posts and comments made by the user in that Hub
                $hubPosts = $this->postModel->getPostsByHubId($_SESSION['user_hub_id']);
                foreach($hubPosts as $post){
                  if($post->user_id == $_SESSION['user_id']){
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
                  'from_id' => $_SESSION['user_id'],
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
                  'id' => $_SESSION['user_id'],
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userMessages = $this->messageModel->getMessages($messagesData);

                foreach($userMessages as $message){
                  $this->messageModel->deleteMessage($message->messageId);
                }

                // update hubs activity
                $activityData = [
                  'hub_id' => $_SESSION['user_hub_id'],
                  'hub' => $_SESSION['user_hub'],
                  'user_id' => $_SESSION['user_id'],
                  'user' => $_SESSION['user_name'],
                  'type' => 'Leave',
                  'to_id' => 0,
                  'post_id' => 0,
                  'comment_id' => 0,
                  'remover_id' => 0,
                  'remover_name' => '',
                  'notify_user' => 0
                ];

                $this->activityModel->addActivity($activityData);

                // switch to the new hub and divert to search Hubmates page
                $_SESSION['user_hub_2_id'] = 0;
                $_SESSION['user_hub_2'] = '';
                $_SESSION['user_hub_id'] = $user->hub_3_id;
                $hub = $this->hubModel->getHubById($user->hub_3_id);
                $_SESSION['user_hub'] = $hub->name;

                // check if the left Hub was their default and change if so to avoid complications on future sign ins
                $data = [
                  'removed_from_hub' => $removedFromHub,
                  'created_new_hub' => $createdNewHub,
                  'id' => $_SESSION['user_id'],
                  'hub' => $_SESSION['user_hub'],
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $this->userModel->updateUserDefaultHub($data);

                errorFlash('success_message', 'Hub Left');
                $_SESSION['flash_error_message'] = 'Hub Left';
                redirect('posts/index');
              } elseif($user->hub_4_id != 0){
                // delete all posts and comments made by the user in that Hub
                $hubPosts = $this->postModel->getPostsByHubId($_SESSION['user_hub_id']);
                foreach($hubPosts as $post){
                  if($post->user_id == $_SESSION['user_id']){
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
                  'from_id' => $_SESSION['user_id'],
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
                  'id' => $_SESSION['user_id'],
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userMessages = $this->messageModel->getMessages($messagesData);

                foreach($userMessages as $message){
                  $this->messageModel->deleteMessage($message->messageId);
                }

                // update hubs activity
                $activityData = [
                  'hub_id' => $_SESSION['user_hub_id'],
                  'hub' => $_SESSION['user_hub'],
                  'user_id' => $_SESSION['user_id'],
                  'user' => $_SESSION['user_name'],
                  'type' => 'Leave',
                  'to_id' => 0,
                  'post_id' => 0,
                  'comment_id' => 0,
                  'remover_id' => 0,
                  'remover_name' => '',
                  'notify_user' => 0
                ];

                $this->activityModel->addActivity($activityData);

                // switch to the new hub and divert to search Hubmates page
                $_SESSION['user_hub_2_id'] = 0;
                $_SESSION['user_hub_2'] = '';
                $_SESSION['user_hub_id'] = $user->hub_4_id;
                $hub = $this->hubModel->getHubById($user->hub_4_id);
                $_SESSION['user_hub'] = $hub->name;

                // check if the left Hub was their default and change if so to avoid complications on future sign ins
                $data = [
                  'removed_from_hub' => $removedFromHub,
                  'created_new_hub' => $createdNewHub,
                  'id' => $_SESSION['user_id'],
                  'hub' => $_SESSION['user_hub'],
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $this->userModel->updateUserDefaultHub($data);

                errorFlash('success_message', 'Hub Left');
                $_SESSION['flash_error_message'] = 'Hub Left';
                redirect('posts/index');
              } elseif($user->hub_5_id != 0){
                // delete all posts and comments made by the user in that Hub
                $hubPosts = $this->postModel->getPostsByHubId($_SESSION['user_hub_id']);
                foreach($hubPosts as $post){
                  if($post->user_id == $_SESSION['user_id']){
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
                  'from_id' => $_SESSION['user_id'],
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
                  'id' => $_SESSION['user_id'],
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userMessages = $this->messageModel->getMessages($messagesData);

                foreach($userMessages as $message){
                  $this->messageModel->deleteMessage($message->messageId);
                }

                // update hubs activity
                $activityData = [
                  'hub_id' => $_SESSION['user_hub_id'],
                  'hub' => $_SESSION['user_hub'],
                  'user_id' => $_SESSION['user_id'],
                  'user' => $_SESSION['user_name'],
                  'type' => 'Leave',
                  'to_id' => 0,
                  'post_id' => 0,
                  'comment_id' => 0,
                  'remover_id' => 0,
                  'remover_name' => '',
                  'notify_user' => 0
                ];

                $this->activityModel->addActivity($activityData);

                // switch to the new hub and divert to search Hubmates page
                $_SESSION['user_hub_2_id'] = 0;
                $_SESSION['user_hub_2'] = '';
                $_SESSION['user_hub_id'] = $user->hub_5_id;
                $hub = $this->hubModel->getHubById($user->hub_5_id);
                $_SESSION['user_hub'] = $hub->name;

                // check if the left Hub was their default and change if so to avoid complications on future sign ins
                $data = [
                  'removed_from_hub' => $removedFromHub,
                  'created_new_hub' => $createdNewHub,
                  'id' => $_SESSION['user_id'],
                  'hub' => $_SESSION['user_hub'],
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $this->userModel->updateUserDefaultHub($data);

                errorFlash('success_message', 'Hub Left');
                $_SESSION['flash_error_message'] = 'Hub Left';
                redirect('posts/index');
              }
            } else {
              die('Oops! Something went wrong');
            }
          } elseif($user->hub_3_id == $_SESSION['user_hub_id']){
            if($this->userModel->updateHub3($data)){
              // if the sessions Hub has no more users delete the Hub
              if($noOfMates == 1){
                // delete all outstanding invites to the Hub before deleting
                $hubInvites = $this->inviteModel->getAllHubInvites($_SESSION['user_hub_id']);
                foreach($hubInvites as $invite){
                  $this->inviteModel->deleteInvite($invite->id);
                }
                $this->hubModel->deleteHub($_SESSION['user_hub_id']);
              }

              if($user->hub_1_id != 0){
                // delete all posts and comments made by the user in that Hub
                $hubPosts = $this->postModel->getPostsByHubId($_SESSION['user_hub_id']);
                foreach($hubPosts as $post){
                  if($post->user_id == $_SESSION['user_id']){
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
                  'from_id' => $_SESSION['user_id'],
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
                  'id' => $_SESSION['user_id'],
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userMessages = $this->messageModel->getMessages($messagesData);

                foreach($userMessages as $message){
                  $this->messageModel->deleteMessage($message->messageId);
                }

                // update hubs activity
                $activityData = [
                  'hub_id' => $_SESSION['user_hub_id'],
                  'hub' => $_SESSION['user_hub'],
                  'user_id' => $_SESSION['user_id'],
                  'user' => $_SESSION['user_name'],
                  'type' => 'Leave',
                  'to_id' => 0,
                  'post_id' => 0,
                  'comment_id' => 0,
                  'remover_id' => 0,
                  'remover_name' => '',
                  'notify_user' => 0
                ];

                $this->activityModel->addActivity($activityData);

                // switch to the new hub and divert to search Hubmates page
                $_SESSION['user_hub_3_id'] = 0;
                $_SESSION['user_hub_3'] = '';
                $_SESSION['user_hub_id'] = $user->hub_1_id;
                $hub = $this->hubModel->getHubById($user->hub_1_id);
                $_SESSION['user_hub'] = $hub->name;

                // check if the left Hub was their default and change if so to avoid complications on future sign ins
                $data = [
                  'removed_from_hub' => $removedFromHub,
                  'created_new_hub' => $createdNewHub,
                  'id' => $_SESSION['user_id'],
                  'hub' => $_SESSION['user_hub'],
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $this->userModel->updateUserDefaultHub($data);

                errorFlash('success_message', 'Hub Left');
                $_SESSION['flash_error_message'] = 'Hub Left';
                redirect('posts/index');
              } elseif($user->hub_2_id != 0){
                // delete all posts and comments made by the user in that Hub
                $hubPosts = $this->postModel->getPostsByHubId($_SESSION['user_hub_id']);
                foreach($hubPosts as $post){
                  if($post->user_id == $_SESSION['user_id']){
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
                  'from_id' => $_SESSION['user_id'],
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
                  'id' => $_SESSION['user_id'],
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userMessages = $this->messageModel->getMessages($messagesData);

                foreach($userMessages as $message){
                  $this->messageModel->deleteMessage($message->messageId);
                }

                // update hubs activity
                $activityData = [
                  'hub_id' => $_SESSION['user_hub_id'],
                  'hub' => $_SESSION['user_hub'],
                  'user_id' => $_SESSION['user_id'],
                  'user' => $_SESSION['user_name'],
                  'type' => 'Leave',
                  'to_id' => 0,
                  'post_id' => 0,
                  'comment_id' => 0,
                  'remover_id' => 0,
                  'remover_name' => '',
                  'notify_user' => 0
                ];

                $this->activityModel->addActivity($activityData);

                // switch to the new hub and divert to search Hubmates page
                $_SESSION['user_hub_3_id'] = 0;
                $_SESSION['user_hub_3'] = '';
                $_SESSION['user_hub_id'] = $user->hub_2_id;
                $hub = $this->hubModel->getHubById($user->hub_2_id);
                $_SESSION['user_hub'] = $hub->name;

                // check if the left Hub was their default and change if so to avoid complications on future sign ins
                $data = [
                  'removed_from_hub' => $removedFromHub,
                  'created_new_hub' => $createdNewHub,
                  'id' => $_SESSION['user_id'],
                  'hub' => $_SESSION['user_hub'],
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $this->userModel->updateUserDefaultHub($data);

                errorFlash('success_message', 'Hub Left');
                $_SESSION['flash_error_message'] = 'Hub Left';
                redirect('posts/index');
              } elseif($user->hub_4_id != 0){
                // delete all posts and comments made by the user in that Hub
                $hubPosts = $this->postModel->getPostsByHubId($_SESSION['user_hub_id']);
                foreach($hubPosts as $post){
                  if($post->user_id == $_SESSION['user_id']){
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
                  'from_id' => $_SESSION['user_id'],
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
                  'id' => $_SESSION['user_id'],
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userMessages = $this->messageModel->getMessages($messagesData);

                foreach($userMessages as $message){
                  $this->messageModel->deleteMessage($message->messageId);
                }

                // update hubs activity
                $activityData = [
                  'hub_id' => $_SESSION['user_hub_id'],
                  'hub' => $_SESSION['user_hub'],
                  'user_id' => $_SESSION['user_id'],
                  'user' => $_SESSION['user_name'],
                  'type' => 'Leave',
                  'to_id' => 0,
                  'post_id' => 0,
                  'comment_id' => 0,
                  'remover_id' => 0,
                  'remover_name' => '',
                  'notify_user' => 0
                ];

                $this->activityModel->addActivity($activityData);

                // switch to the new hub and divert to search Hubmates page
                $_SESSION['user_hub_3_id'] = 0;
                $_SESSION['user_hub_3'] = '';
                $_SESSION['user_hub_id'] = $user->hub_4_id;
                $hub = $this->hubModel->getHubById($user->hub_4_id);
                $_SESSION['user_hub'] = $hub->name;

                // check if the left Hub was their default and change if so to avoid complications on future sign ins
                $data = [
                  'removed_from_hub' => $removedFromHub,
                  'created_new_hub' => $createdNewHub,
                  'id' => $_SESSION['user_id'],
                  'hub' => $_SESSION['user_hub'],
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $this->userModel->updateUserDefaultHub($data);

                errorFlash('success_message', 'Hub Left');
                $_SESSION['flash_error_message'] = 'Hub Left';
                redirect('posts/index');
              } elseif($user->hub_5_id != 0){
                // delete all posts and comments made by the user in that Hub
                $hubPosts = $this->postModel->getPostsByHubId($_SESSION['user_hub_id']);
                foreach($hubPosts as $post){
                  if($post->user_id == $_SESSION['user_id']){
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
                  'from_id' => $_SESSION['user_id'],
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
                  'id' => $_SESSION['user_id'],
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userMessages = $this->messageModel->getMessages($messagesData);

                foreach($userMessages as $message){
                  $this->messageModel->deleteMessage($message->messageId);
                }

                // update hubs activity
                $activityData = [
                  'hub_id' => $_SESSION['user_hub_id'],
                  'hub' => $_SESSION['user_hub'],
                  'user_id' => $_SESSION['user_id'],
                  'user' => $_SESSION['user_name'],
                  'type' => 'Leave',
                  'to_id' => 0,
                  'post_id' => 0,
                  'comment_id' => 0,
                  'remover_id' => 0,
                  'remover_name' => '',
                  'notify_user' => 0
                ];

                $this->activityModel->addActivity($activityData);

                // switch to the new hub and divert to search Hubmates page
                $_SESSION['user_hub_3_id'] = 0;
                $_SESSION['user_hub_3'] = '';
                $_SESSION['user_hub_id'] = $user->hub_5_id;
                $hub = $this->hubModel->getHubById($user->hub_5_id);
                $_SESSION['user_hub'] = $hub->name;

                // check if the left Hub was their default and change if so to avoid complications on future sign ins
                $data = [
                  'removed_from_hub' => $removedFromHub,
                  'created_new_hub' => $createdNewHub,
                  'id' => $_SESSION['user_id'],
                  'hub' => $_SESSION['user_hub'],
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $this->userModel->updateUserDefaultHub($data);

                errorFlash('success_message', 'Hub Left');
                $_SESSION['flash_error_message'] = 'Hub Left';
                redirect('posts/index');
              }
            } else {
              die('Oops! Something went wrong');
            }
          } elseif($user->hub_4_id == $_SESSION['user_hub_id']){
            if($this->userModel->updateHub4($data)){
              // if the sessions Hub has no more users delete the Hub
              if($noOfMates == 1){
                // delete all outstanding invites to the Hub before deleting
                $hubInvites = $this->inviteModel->getAllHubInvites($_SESSION['user_hub_id']);
                foreach($hubInvites as $invite){
                  $this->inviteModel->deleteInvite($invite->id);
                }
                $this->hubModel->deleteHub($_SESSION['user_hub_id']);
              }

              if($user->hub_1_id != 0){
                // delete all posts and comments made by the user in that Hub
                $hubPosts = $this->postModel->getPostsByHubId($_SESSION['user_hub_id']);
                foreach($hubPosts as $post){
                  if($post->user_id == $_SESSION['user_id']){
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
                  'from_id' => $_SESSION['user_id'],
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
                  'id' => $_SESSION['user_id'],
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userMessages = $this->messageModel->getMessages($messagesData);

                foreach($userMessages as $message){
                  $this->messageModel->deleteMessage($message->messageId);
                }

                // update hubs activity
                $activityData = [
                  'hub_id' => $_SESSION['user_hub_id'],
                  'hub' => $_SESSION['user_hub'],
                  'user_id' => $_SESSION['user_id'],
                  'user' => $_SESSION['user_name'],
                  'type' => 'Leave',
                  'to_id' => 0,
                  'post_id' => 0,
                  'comment_id' => 0,
                  'remover_id' => 0,
                  'remover_name' => '',
                  'notify_user' => 0
                ];

                $this->activityModel->addActivity($activityData);

                // switch to the new hub and divert to search Hubmates page
                $_SESSION['user_hub_4_id'] = 0;
                $_SESSION['user_hub_4'] = '';
                $_SESSION['user_hub_id'] = $user->hub_1_id;
                $hub = $this->hubModel->getHubById($user->hub_1_id);
                $_SESSION['user_hub'] = $hub->name;

                // check if the left Hub was their default and change if so to avoid complications on future sign ins
                $data = [
                  'removed_from_hub' => $removedFromHub,
                  'created_new_hub' => $createdNewHub,
                  'id' => $_SESSION['user_id'],
                  'hub' => $_SESSION['user_hub'],
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $this->userModel->updateUserDefaultHub($data);

                errorFlash('success_message', 'Hub Left');
                $_SESSION['flash_error_message'] = 'Hub Left';
                redirect('posts/index');
              } elseif($user->hub_2_id != 0){
                // delete all posts and comments made by the user in that Hub
                $hubPosts = $this->postModel->getPostsByHubId($_SESSION['user_hub_id']);
                foreach($hubPosts as $post){
                  if($post->user_id == $_SESSION['user_id']){
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
                  'from_id' => $_SESSION['user_id'],
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
                  'id' => $_SESSION['user_id'],
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userMessages = $this->messageModel->getMessages($messagesData);

                foreach($userMessages as $message){
                  $this->messageModel->deleteMessage($message->messageId);
                }

                // update hubs activity
                $activityData = [
                  'hub_id' => $_SESSION['user_hub_id'],
                  'hub' => $_SESSION['user_hub'],
                  'user_id' => $_SESSION['user_id'],
                  'user' => $_SESSION['user_name'],
                  'type' => 'Leave',
                  'to_id' => 0,
                  'post_id' => 0,
                  'comment_id' => 0,
                  'remover_id' => 0,
                  'remover_name' => '',
                  'notify_user' => 0
                ];

                $this->activityModel->addActivity($activityData);

                // switch to the new hub and divert to search Hubmates page
                $_SESSION['user_hub_4_id'] = 0;
                $_SESSION['user_hub_4'] = '';
                $_SESSION['user_hub_id'] = $user->hub_2_id;
                $hub = $this->hubModel->getHubById($user->hub_2_id);
                $_SESSION['user_hub'] = $hub->name;

                // check if the left Hub was their default and change if so to avoid complications on future sign ins
                $data = [
                  'removed_from_hub' => $removedFromHub,
                  'created_new_hub' => $createdNewHub,
                  'id' => $_SESSION['user_id'],
                  'hub' => $_SESSION['user_hub'],
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $this->userModel->updateUserDefaultHub($data);

                errorFlash('success_message', 'Hub Left');
                $_SESSION['flash_error_message'] = 'Hub Left';
                redirect('posts/index');
              } elseif($user->hub_3_id != 0){
                // delete all posts and comments made by the user in that Hub
                $hubPosts = $this->postModel->getPostsByHubId($_SESSION['user_hub_id']);
                foreach($hubPosts as $post){
                  if($post->user_id == $_SESSION['user_id']){
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
                  'from_id' => $_SESSION['user_id'],
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
                  'id' => $_SESSION['user_id'],
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userMessages = $this->messageModel->getMessages($messagesData);

                foreach($userMessages as $message){
                  $this->messageModel->deleteMessage($message->messageId);
                }

                // update hubs activity
                $activityData = [
                  'hub_id' => $_SESSION['user_hub_id'],
                  'hub' => $_SESSION['user_hub'],
                  'user_id' => $_SESSION['user_id'],
                  'user' => $_SESSION['user_name'],
                  'type' => 'Leave',
                  'to_id' => 0,
                  'post_id' => 0,
                  'comment_id' => 0,
                  'remover_id' => 0,
                  'remover_name' => '',
                  'notify_user' => 0
                ];

                $this->activityModel->addActivity($activityData);

                // switch to the new hub and divert to search Hubmates page
                $_SESSION['user_hub_4_id'] = 0;
                $_SESSION['user_hub_4'] = '';
                $_SESSION['user_hub_id'] = $user->hub_3_id;
                $hub = $this->hubModel->getHubById($user->hub_3_id);
                $_SESSION['user_hub'] = $hub->name;

                // check if the left Hub was their default and change if so to avoid complications on future sign ins
                $data = [
                  'removed_from_hub' => $removedFromHub,
                  'created_new_hub' => $createdNewHub,
                  'id' => $_SESSION['user_id'],
                  'hub' => $_SESSION['user_hub'],
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $this->userModel->updateUserDefaultHub($data);

                errorFlash('success_message', 'Hub Left');
                $_SESSION['flash_error_message'] = 'Hub Left';
                redirect('posts/index');
              } elseif($user->hub_5_id != 0){
                // delete all posts and comments made by the user in that Hub
                $hubPosts = $this->postModel->getPostsByHubId($_SESSION['user_hub_id']);
                foreach($hubPosts as $post){
                  if($post->user_id == $_SESSION['user_id']){
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
                  'from_id' => $_SESSION['user_id'],
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
                  'id' => $_SESSION['user_id'],
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userMessages = $this->messageModel->getMessages($messagesData);

                foreach($userMessages as $message){
                  $this->messageModel->deleteMessage($message->messageId);
                }

                // update hubs activity
                $activityData = [
                  'hub_id' => $_SESSION['user_hub_id'],
                  'hub' => $_SESSION['user_hub'],
                  'user_id' => $_SESSION['user_id'],
                  'user' => $_SESSION['user_name'],
                  'type' => 'Leave',
                  'to_id' => 0,
                  'post_id' => 0,
                  'comment_id' => 0,
                  'remover_id' => 0,
                  'remover_name' => '',
                  'notify_user' => 0
                ];

                $this->activityModel->addActivity($activityData);

                // switch to the new hub and divert to search Hubmates page
                $_SESSION['user_hub_4_id'] = 0;
                $_SESSION['user_hub_4'] = '';
                $_SESSION['user_hub_id'] = $user->hub_5_id;
                $hub = $this->hubModel->getHubById($user->hub_5_id);
                $_SESSION['user_hub'] = $hub->name;

                // check if the left Hub was their default and change if so to avoid complications on future sign ins
                $data = [
                  'removed_from_hub' => $removedFromHub,
                  'created_new_hub' => $createdNewHub,
                  'id' => $_SESSION['user_id'],
                  'hub' => $_SESSION['user_hub'],
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $this->userModel->updateUserDefaultHub($data);

                errorFlash('success_message', 'Hub Left');
                $_SESSION['flash_error_message'] = 'Hub Left';
                redirect('posts/index');
              }
            } else {
              die('Oops! Something went wrong');
            }
          } elseif($user->hub_5_id == $_SESSION['user_hub_id']){
            if($this->userModel->updateHub5($data)){
              // if the sessions Hub has no more users delete the Hub
              if($noOfMates == 1){
                // delete all outstanding invites to the Hub before deleting
                $hubInvites = $this->inviteModel->getAllHubInvites($_SESSION['user_hub_id']);
                foreach($hubInvites as $invite){
                  $this->inviteModel->deleteInvite($invite->id);
                }
                $this->hubModel->deleteHub($_SESSION['user_hub_id']);
              }

              if($user->hub_1_id != 0){
                // delete all posts and comments made by the user in that Hub
                $hubPosts = $this->postModel->getPostsByHubId($_SESSION['user_hub_id']);
                foreach($hubPosts as $post){
                  if($post->user_id == $_SESSION['user_id']){
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
                  'from_id' => $_SESSION['user_id'],
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
                  'id' => $_SESSION['user_id'],
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userMessages = $this->messageModel->getMessages($messagesData);

                foreach($userMessages as $message){
                  $this->messageModel->deleteMessage($message->messageId);
                }

                // update hubs activity
                $activityData = [
                  'hub_id' => $_SESSION['user_hub_id'],
                  'hub' => $_SESSION['user_hub'],
                  'user_id' => $_SESSION['user_id'],
                  'user' => $_SESSION['user_name'],
                  'type' => 'Leave',
                  'to_id' => 0,
                  'post_id' => 0,
                  'comment_id' => 0,
                  'remover_id' => 0,
                  'remover_name' => '',
                  'notify_user' => 0
                ];

                $this->activityModel->addActivity($activityData);

                // switch to the new hub and divert to search Hubmates page
                $_SESSION['user_hub_5_id'] = 0;
                $_SESSION['user_hub_5'] = '';
                $_SESSION['user_hub_id'] = $user->hub_1_id;
                $hub = $this->hubModel->getHubById($user->hub_1_id);
                $_SESSION['user_hub'] = $hub->name;

                // check if the left Hub was their default and change if so to avoid complications on future sign ins
                $data = [
                  'removed_from_hub' => $removedFromHub,
                  'created_new_hub' => $createdNewHub,
                  'id' => $_SESSION['user_id'],
                  'hub' => $_SESSION['user_hub'],
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $this->userModel->updateUserDefaultHub($data);

                errorFlash('success_message', 'Hub Left');
                $_SESSION['flash_error_message'] = 'Hub Left';
                redirect('posts/index');
              } elseif($user->hub_2_id != 0){
                // delete all posts and comments made by the user in that Hub
                $hubPosts = $this->postModel->getPostsByHubId($_SESSION['user_hub_id']);
                foreach($hubPosts as $post){
                  if($post->user_id == $_SESSION['user_id']){
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
                  'from_id' => $_SESSION['user_id'],
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
                  'id' => $_SESSION['user_id'],
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userMessages = $this->messageModel->getMessages($messagesData);

                foreach($userMessages as $message){
                  $this->messageModel->deleteMessage($message->messageId);
                }

                // update hubs activity
                $activityData = [
                  'hub_id' => $_SESSION['user_hub_id'],
                  'hub' => $_SESSION['user_hub'],
                  'user_id' => $_SESSION['user_id'],
                  'user' => $_SESSION['user_name'],
                  'type' => 'Leave',
                  'to_id' => 0,
                  'post_id' => 0,
                  'comment_id' => 0,
                  'remover_id' => 0,
                  'remover_name' => '',
                  'notify_user' => 0
                ];

                $this->activityModel->addActivity($activityData);

                // switch to the new hub and divert to search Hubmates page
                $_SESSION['user_hub_5_id'] = 0;
                $_SESSION['user_hub_5'] = '';
                $_SESSION['user_hub_id'] = $user->hub_2_id;
                $hub = $this->hubModel->getHubById($user->hub_2_id);
                $_SESSION['user_hub'] = $hub->name;

                // check if the left Hub was their default and change if so to avoid complications on future sign ins
                $data = [
                  'removed_from_hub' => $removedFromHub,
                  'created_new_hub' => $createdNewHub,
                  'id' => $_SESSION['user_id'],
                  'hub' => $_SESSION['user_hub'],
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $this->userModel->updateUserDefaultHub($data);

                errorFlash('success_message', 'Hub Left');
                $_SESSION['flash_error_message'] = 'Hub Left';
                redirect('posts/index');
              } elseif($user->hub_3_id != 0){
                // delete all posts and comments made by the user in that Hub
                $hubPosts = $this->postModel->getPostsByHubId($_SESSION['user_hub_id']);
                foreach($hubPosts as $post){
                  if($post->user_id == $_SESSION['user_id']){
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
                  'from_id' => $_SESSION['user_id'],
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
                  'id' => $_SESSION['user_id'],
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userMessages = $this->messageModel->getMessages($messagesData);

                foreach($userMessages as $message){
                  $this->messageModel->deleteMessage($message->messageId);
                }

                // update hubs activity
                $activityData = [
                  'hub_id' => $_SESSION['user_hub_id'],
                  'hub' => $_SESSION['user_hub'],
                  'user_id' => $_SESSION['user_id'],
                  'user' => $_SESSION['user_name'],
                  'type' => 'Leave',
                  'to_id' => 0,
                  'post_id' => 0,
                  'comment_id' => 0,
                  'remover_id' => 0,
                  'remover_name' => '',
                  'notify_user' => 0
                ];

                $this->activityModel->addActivity($activityData);

                // switch to the new hub and divert to search Hubmates page
                $_SESSION['user_hub_5_id'] = 0;
                $_SESSION['user_hub_5'] = '';
                $_SESSION['user_hub_id'] = $user->hub_3_id;
                $hub = $this->hubModel->getHubById($user->hub_3_id);
                $_SESSION['user_hub'] = $hub->name;

                // check if the left Hub was their default and change if so to avoid complications on future sign ins
                $data = [
                  'removed_from_hub' => $removedFromHub,
                  'created_new_hub' => $createdNewHub,
                  'id' => $_SESSION['user_id'],
                  'hub' => $_SESSION['user_hub'],
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $this->userModel->updateUserDefaultHub($data);

                errorFlash('success_message', 'Hub Left');
                $_SESSION['flash_error_message'] = 'Hub Left';
                redirect('posts/index');
              } elseif($user->hub_4_id != 0){
                // delete all posts and comments made by the user in that Hub
                $hubPosts = $this->postModel->getPostsByHubId($_SESSION['user_hub_id']);
                foreach($hubPosts as $post){
                  if($post->user_id == $_SESSION['user_id']){
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
                  'from_id' => $_SESSION['user_id'],
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
                  'id' => $_SESSION['user_id'],
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $userMessages = $this->messageModel->getMessages($messagesData);

                foreach($userMessages as $message){
                  $this->messageModel->deleteMessage($message->messageId);
                }

                // update hubs activity
                $activityData = [
                  'hub_id' => $_SESSION['user_hub_id'],
                  'hub' => $_SESSION['user_hub'],
                  'user_id' => $_SESSION['user_id'],
                  'user' => $_SESSION['user_name'],
                  'type' => 'Leave',
                  'to_id' => 0,
                  'post_id' => 0,
                  'comment_id' => 0,
                  'remover_id' => 0,
                  'remover_name' => '',
                  'notify_user' => 0
                ];

                $this->activityModel->addActivity($activityData);

                // switch to the new hub and divert to search Hubmates page
                $_SESSION['user_hub_5_id'] = 0;
                $_SESSION['user_hub_5'] = '';
                $_SESSION['user_hub_id'] = $user->hub_4_id;
                $hub = $this->hubModel->getHubById($user->hub_4_id);
                $_SESSION['user_hub'] = $hub->name;

                // check if the left Hub was their default and change if so to avoid complications on future sign ins
                $data = [
                  'removed_from_hub' => $removedFromHub,
                  'created_new_hub' => $createdNewHub,
                  'id' => $_SESSION['user_id'],
                  'hub' => $_SESSION['user_hub'],
                  'hub_id' => $_SESSION['user_hub_id']
                ];

                $this->userModel->updateUserDefaultHub($data);

                errorFlash('success_message', 'Hub Left');
                $_SESSION['flash_error_message'] = 'Hub Left';
                redirect('posts/index');
              } else {
                die('Oops! Something went wrong');
              }
            }
          }
        } elseif(isset($_POST['newEmailBtn'])){
          $data = [
            'removed_from_hub' => $removedFromHub,
            'created_new_hub' => $createdNewHub,
            'default_hub' => $defaultHub,
            'no_of_hubs' => $noOfHubs,
            'no_of_mates' => $noOfMates,
            'user' => $user,
            'id' => $_SESSION['user_id'],
            'email' => trim($_POST['new_email']),
            'new_email_err' => ''
          ];

          // validate email
          if(empty($data['email'])){
            $error = 'Please enter an email address';
            $data['new_email_err'] = 'Please enter an email address';
          } elseif($this->userModel->findUserByEmail($data['email'])){
            $error = 'Email address provided is already a user';
            $data['new_email_err'] = 'This email is already taken';
          } elseif(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
            $error = 'Invalid email address provided';
            $data['new_email_err'] = 'Please enter a valid email address';
          } elseif($data['email'] == $user->email){
            $error = 'You are already using this email address';
            $data['new_email_err'] = 'You are already using this email address';
          }

          if(empty($data['new_email_err'])){
            if($this->userModel->updateUserEmail($data)){
              flash('success_message', 'Email changed');
              redirect('posts/index', $data);
            } else {
              die('Oops! Something went wrong');
            }
          } else {
            errorFlash('error_message', $error);
            // load view with errors
            $this->view('pages/settings', $data);
          }
        } elseif(isset($_POST['newPasswordBtn'])){
          $noOfErrors = 0;

          $data = [
            'removed_from_hub' => $removedFromHub,
            'created_new_hub' => $createdNewHub,
            'default_hub' => $defaultHub,
            'no_of_hubs' => $noOfHubs,
            'no_of_mates' => $noOfMates,
            'user' => $user,
            'id' => $_SESSION['user_id'],
            'current_password' => trim($_POST['password']),
            'new_password' => trim($_POST['new_password']),
            'confirm_password' => trim($_POST['confirm_password']),
            'password_err' => '',
            'new_password_err' => '',
            'confirm_password_err' => ''
          ];

          // validate current password
          if(empty($data['current_password'])){
            $noOfErrors += 1;
            $error = 'Please enter your current password';
            $data['password_err'] = 'Please enter your current password';
          }

          $checkPasswordData = [
            'id' => $_SESSION['user_id'],
            'email' => $user->email,
            'password' => $data['current_password']
          ];

          $passwordMatch = $this->userModel->checkPassword($checkPasswordData);

          if(!$passwordMatch){
            $noOfErrors += 1;
            $error = 'Incorrect Password';
            $data['password_err'] = 'Current password incorrect';
          }

          // validate new password
          $uppercase = preg_match('@[A-Z]@', $data['new_password']);
          $lowercase = preg_match('@[a-z]@', $data['new_password']);
          $number    = preg_match('@[0-9]@', $data['new_password']);
          if(empty($data['new_password'])){
            $noOfErrors += 1;
            $error = 'Please enter a new password';
            $data['new_password_err'] = 'Please enter a password';
          } elseif(strlen($data['new_password']) < 6){
            $noOfErrors += 1;
            $error = 'Password must contain at least 6 characters';
            $data['new_password_err'] = 'Password must contain at least 6 characters';
          } elseif(!$uppercase || !$lowercase || !$number){
            $noOfErrors += 1;
            $error = 'Password must contain at least one lower case letter, one upper case letter and a number';
            $data['new_password_err'] = 'Password must contain at least one lower case letter, one upper case letter and a number';
          }

          // validate confirm password
          if(empty($data['confirm_password'])){
            $noOfErrors += 1;
            $error = 'Please re-enter your new password';
            $data['confirm_password_err'] = 'Please re-enter password';
          } elseif($data['confirm_password'] != $data['new_password']){
            $noOfErrors += 1;
            $error = 'New passwords do not match';
            $data['confirm_password_err'] = 'New passwords do not match';
          }

          if(empty($data['password_err']) && empty($data['new_password_err']) && empty($data['confirm_password_err'])){
            // hash password before posting to database
            $data['new_password'] = password_hash($data['new_password'], PASSWORD_DEFAULT);

            $data = [
              'removed_from_hub' => $removedFromHub,
              'created_new_hub' => $createdNewHub,
              'id' => $_SESSION['user_id'],
              'password' => $data['new_password']
            ];

            if($this->userModel->updateUserPassword($data)){
              flash('success_message', 'Password changed');
              redirect('posts/index', $data);
            } else {
              die('Oops! Something went wrong');
            }
          } else {
            if($noOfErrors > 1){
              errorFlash('error_message', 'You have multiple errors with your password entries');
            } else {
              errorFlash('error_message', $error);
            }

            // load view with errors
            $this->view('pages/settings', $data);
          }
        } elseif(isset($_POST['deleteAccountBtn'])){
          // delete all user messages (and chains)
          $allMessages = $this->messageModel->getAllUserMessages($_SESSION['user_id']);
          foreach($allMessages as $message){
            $this->messageModel->deleteMessage($message->messageId);
          }

          // delete all user posts and its comments
          $allPosts = $this->postModel->getPostsByUserId($_SESSION['user_id']);
          foreach($allPosts as $post){
            // delete comments
            $allComments = $this->commentModel->getComments($post->postId);
            foreach($allComments as $comment){
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

          // delete all remaining user comments on posts that may be in other Hubs
          $allComments = $this->commentModel->getCommentsByUserId($_SESSION['user_id']);
          foreach($allComments as $comment){
            $this->commentModel->deleteComment($comment->commentId);
          }

          // delete Hub(s) if the user is the only member
          if($user->hub_1_id != 0){
            // update hubs activity
            $hub = $this->hubModel->getHubById($user->hub_1_id)->name;

            $activityData = [
              'hub_id' => $user->hub_1_id,
              'hub' => $hub,
              'user_id' => $_SESSION['user_id'],
              'user' => $_SESSION['user_name'],
              'type' => 'Leave',
              'to_id' => 0,
              'post_id' => 0,
              'comment_id' => 0,
              'remover_id' => 0,
              'remover_name' => '',
              'notify_user' => 0
            ];

            $this->activityModel->addActivity($activityData);

            $mates = $this->userModel->getHubmates($user->hub_1_id);
            if(count($mates) == 1){
              // delete all outstanding invites to the Hub before deleting
              $hubInvites = $this->inviteModel->getAllHubInvites($user->hub_1_id);
              foreach($hubInvites as $invite){
                $this->inviteModel->deleteInvite($invite->id);
              }
              $this->hubModel->deleteHub($user->hub_1_id);
            }
          }
          if($user->hub_2_id != 0){
            // update hubs activity
            $hub = $this->hubModel->getHubById($user->hub_2_id)->name;

            $activityData = [
              'hub_id' => $user->hub_2_id,
              'hub' => $hub,
              'user_id' => $_SESSION['user_id'],
              'user' => $_SESSION['user_name'],
              'type' => 'Leave',
              'to_id' => 0,
              'post_id' => 0,
              'comment_id' => 0,
              'remover_id' => 0,
              'remover_name' => '',
              'notify_user' => 0
            ];

            $this->activityModel->addActivity($activityData);

            $mates = $this->userModel->getHubmates($user->hub_2_id);
            if(count($mates) == 1){
              // delete all outstanding invites to the Hub before deleting
              $hubInvites = $this->inviteModel->getAllHubInvites($user->hub_2_id);
              foreach($hubInvites as $invite){
                $this->inviteModel->deleteInvite($invite->id);
              }
              $this->hubModel->deleteHub($user->hub_2_id);
            }
          }
          if($user->hub_3_id != 0){
            // update hubs activity
            $hub = $this->hubModel->getHubById($user->hub_3_id)->name;

            $activityData = [
              'hub_id' => $user->hub_3_id,
              'hub' => $hub,
              'user_id' => $_SESSION['user_id'],
              'user' => $_SESSION['user_name'],
              'type' => 'Leave',
              'to_id' => 0,
              'post_id' => 0,
              'comment_id' => 0,
              'remover_id' => 0,
              'remover_name' => '',
              'notify_user' => 0
            ];

            $this->activityModel->addActivity($activityData);

            $mates = $this->userModel->getHubmates($user->hub_3_id);
            if(count($mates) == 1){
              // delete all outstanding invites to the Hub before deleting
              $hubInvites = $this->inviteModel->getAllHubInvites($user->hub_3_id);
              foreach($hubInvites as $invite){
                $this->inviteModel->deleteInvite($invite->id);
              }
              $this->hubModel->deleteHub($user->hub_3_id);
            }
          }
          if($user->hub_4_id != 0){
            // update hubs activity
            $hub = $this->hubModel->getHubById($user->hub_4_id)->name;

            $activityData = [
              'hub_id' => $user->hub_4_id,
              'hub' => $hub,
              'user_id' => $_SESSION['user_id'],
              'user' => $_SESSION['user_name'],
              'type' => 'Leave',
              'to_id' => 0,
              'post_id' => 0,
              'comment_id' => 0,
              'remover_id' => 0,
              'remover_name' => '',
              'notify_user' => 0
            ];

            $this->activityModel->addActivity($activityData);

            $mates = $this->userModel->getHubmates($user->hub_4_id);
            if(count($mates) == 1){
              // delete all outstanding invites to the Hub before deleting
              $hubInvites = $this->inviteModel->getAllHubInvites($user->hub_4_id);
              foreach($hubInvites as $invite){
                $this->inviteModel->deleteInvite($invite->id);
              }
              $this->hubModel->deleteHub($user->hub_4_id);
            }
          }
          if($user->hub_5_id != 0){
            // update hubs activity
            $hub = $this->hubModel->getHubById($user->hub_5_id)->name;

            $activityData = [
              'hub_id' => $user->hub_5_id,
              'hub' => $hub,
              'user_id' => $_SESSION['user_id'],
              'user' => $_SESSION['user_name'],
              'type' => 'Leave',
              'to_id' => 0,
              'post_id' => 0,
              'comment_id' => 0,
              'remover_id' => 0,
              'remover_name' => '',
              'notify_user' => 0
            ];

            $this->activityModel->addActivity($activityData);

            $mates = $this->userModel->getHubmates($user->hub_5_id);
            if(count($mates) == 1){
              // delete all outstanding invites to the Hub before deleting
              $hubInvites = $this->inviteModel->getAllHubInvites($user->hub_5_id);
              foreach($hubInvites as $invite){
                $this->inviteModel->deleteInvite($invite->id);
              }
              $this->hubModel->deleteHub($user->hub_5_id);
            }
          }

          // delete user and logout
          $this->userModel->deleteUser($_SESSION['user_id']);
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
      } else {

        $data = [
          'removed_from_hub' => $removedFromHub,
          'created_new_hub' => $createdNewHub,
          'default_hub' => $defaultHub,
          'no_of_hubs' => $noOfHubs,
          'no_of_mates' => $noOfMates,
          'user' => $user
        ];
        $this->view('pages/settings', $data);
      }
    }

    public function privacy(){
      if(isLoggedIn()){
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
      } else {
        $removedFromHub = '';
        $createdNewHub = 0;
      }

      $data = [
        'removed_from_hub' => $removedFromHub,
        'created_new_hub' => $createdNewHub,
      ];
      $this->view('pages/privacy', $data);
    }

    public function terms(){
      if(isLoggedIn()){
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
      } else {
        $removedFromHub = '';
        $createdNewHub = 0;
      }

      $data = [
        'removed_from_hub' => $removedFromHub,
        'created_new_hub' => $createdNewHub,
      ];
      $this->view('pages/terms', $data);
    }
  }
?>
