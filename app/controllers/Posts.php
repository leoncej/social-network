<?php
  class Posts extends Controller {
    public function __construct(){
      // ensure only logged in users can access the page
      if(!isLoggedIn()){
        redirect('users/login');
      }

      $this->postModel = $this->model('Post');
      $this->userModel = $this->model('User');
      $this->commentModel = $this->model('Comment');
      $this->activityModel = $this->model('Activity');
      $this->starModel = $this->model('Star');
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

      // get hub posts
      $posts = $this->postModel->getPostsByHubId($_SESSION['user_hub_id']);

      // comments
      $comments = [];
      foreach($posts as $post){
        // starred users
        $postStarUsers = [];
        $postId = $post->postId;
        $getComments = $this->commentModel->getComments($postId);
        $threeComments = array_slice($getComments, -3);

        $user = $this->userModel->getUserById($post->userId);
        $post->colour = $user->colour;
        if($user->img){
          // decode b64 to img
          $post->profileImg = base64_decode($user->img);
        } else {
          $post->profileImg = '';
        }

        // decode post img
        if($post->postImg){
          $post->postImg = base64_decode($post->postImg);
        }

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
          }
        }

        $comments[] = [
          'post_id' => $postId,
          'comments' => $threeComments,
          'count' => count($getComments)
        ];
      }

      // check to see if its  a POST request
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // sanitize POST array
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        if(isset($_POST['removeOkayBtn'])){
          // check for unseen seen flag
          $userData = [
            'notify_user' => $_SESSION['user_id'],
            'seen' => 0
          ];
          $unseenRemovedActivity = $this->activityModel->getActivitiesByNotifyUser($userData);

          if(!empty($unseenRemovedActivity)){
            foreach($unseenRemovedActivity as $activity){
              $activityId = $activity->activityId;
            }
          }
          $data = [
            'id' => $activityId,
            'seen' => 1
          ];

          $this->activityModel->updatePostActivitySeenFlag($data);
          redirect('posts/index');
        } elseif(isset($_POST['updatePostBtn'])){
          // encode b64 string
          $b64 = base64_encode(trim($_POST['post-edit-b64-img']));

          $data = [
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
            } else {
              die('Oops! Something went wrong');
            }
          }
        } elseif(isset($_POST['deletePostBtn'])){
          // get existing post from model
          $post = $this->postModel->getPostById($_POST['post-id']);
          // check for owner
          if($post->user_id != $_SESSION['user_id']){
            redirect('posts/index');
          }

          if($this->postModel->deletePost($post->id)){
            errorFlash('success_message', 'Shout Removed');
            $_SESSION['flash_error_message'] = 'Shout Removed';

            // delete comments
            $postComments = $this->commentModel->getCommentsByPostId($post->id);
            foreach($postComments as $comment){
              $this->commentModel->deleteComment($comment->commentId);
            }

            // delete activites
            $postActivities = $this->activityModel->getActivitiesByPostId($post->id);
            foreach($postActivities as $activity){
              $this->activityModel->deleteActivity($activity->activityId);
            }
            redirect('posts/index');
          } else {
            die('Oops! Something went wrong');
          }
        }

        if(isset($_POST['shoutBtn'])){
          // encode b64 string
          $b64 = base64_encode(trim($_POST['shout_b64_img']));

          $data = [
            'title' => trim($_POST['title']),
            'body' => '',
            'img' => $b64,
            'user_id' => $_SESSION['user_id'],
            'hub_id' => $_SESSION['user_hub_id'],
            'user_colour' => $_SESSION['user_colour'],
            'edited' => '0',
            'title_err' => '',
            'body_err' => ''
          ];

          // validate data
          if(empty($data['title']) && empty($data['img'])){
            $data['title_err'] = 'Please enter your message or attach an image to shout';
          }

          // ensure no errors
          if(empty($data['title_err'])){
            $postId = $this->postModel->addPost($data);
            if($postId){
              flash('success_message', 'Shout Added');

              // update hubs activity for each hubmate
              $hubmates = $this->userModel->getHubmates($_SESSION['user_hub_id']);
              foreach($hubmates as $mate){
                // omit self from post data
                if($mate->id != $_SESSION['user_id']){
                  $activityData = [
                    'hub_id' => $_SESSION['user_hub_id'],
                    'hub' => $_SESSION['user_hub_id'],
                    'user_id' => $_SESSION['user_id'],
                    'user' => $_SESSION['user_name'],
                    'to_id' => $mate->id,
                    'type' => 'Post',
                    'post_id' => $postId,
                    'comment_id' => 0,
                    'remover_id' => 0,
                    'remover_name' => '',
                    'notify_user' => 0
                  ];

                  $this->activityModel->addPostActivity($activityData);
                }
              }

              redirect('posts/index');
            } else {
              die('Oops! Something went wrong');
            }

          } else {
            $data = [
              'removed_from_hub' => $removedFromHub,
              'created_new_hub' => $createdNewHub,
              'title' => '',
              'title_err' => 'Please enter your message or attach an image to shout',
              'posts' => $posts,
              'comments' => $comments
            ];

            // load view with errors
            $this->view('posts/index', $data);
          }
        }
      } else {

        $data = [
          'removed_from_hub' => $removedFromHub,
          'created_new_hub' => $createdNewHub,
          'title' => '',
          'posts' => $posts,
          'comments' => $comments
        ];

        $this->view('posts/index', $data);
      }
      $_SESSION['flash_message'] = '';
      $_SESSION['flash_error_message'] = '';
    }

    public function add(){
      // check to see if its  a POST request
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // sanitize POST array
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // encode b64 string
        $b64 = base64_encode(trim($_POST['shout_b64_img']));

        $data = [
          'title' => trim($_POST['title']),
          'img' => $b64,
          'body' => trim($_POST['body']),
          'user_id' => $_SESSION['user_id'],
          'hub_id' => $_SESSION['user_hub_id'],
          'title_err' => '',
          'body_err' => ''
        ];

        // validate data
        if(empty($data['title']) && empty($data['img'])){
          $data['title_err'] = 'Please enter your message or attach an image to shout';
        }

        if(empty($data['body'])){
          $data['body_err'] = 'Please enter body text';
        }

        // ensure no errors
        if(empty($data['title_err']) && empty($data['body_err'])){
          $postId = $this->postModel->addPost($data);
          if($postId){
            flash('success_message', 'Post Added');

            // update hubs activity for each hubmate
            $hubmates = $this->userModel->getHubmates($_SESSION['user_hub_id']);
            foreach($hubmates as $mate){
              // omit self from post data
              if($mate->id != $_SESSION['user_id']){
                $activityData = [
                  'hub_id' => $_SESSION['user_hub_id'],
                  'hub' => $_SESSION['user_hub_id'],
                  'user_id' => $_SESSION['user_id'],
                  'user' => $_SESSION['user_name'],
                  'to_id' => $mate->id,
                  'type' => 'Post',
                  'post_id' => $postId
                ];

                $this->activityModel->addPostActivity($activityData);
              }
            }

            redirect('posts/index');
          } else {
            die('Oops! Something went wrong');
          }

        } else {
          // load view with errors
          $this->view('posts/add', $data);
        }

      } else {
        $data = [
          'title' => '',
          'body' => ''
        ];

        $this->view('posts/add', $data);
      }
    }

    public function edit($id){
      // check to see if its  a POST request
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // sanitize POST array
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // encode b64 string
        $b64 = base64_encode(trim($_POST['shout_b64_img']));

        $data = [
          'id' => $id,
          'title' => trim($_POST['title']),
          'img' => $b64,
          'body' => trim($_POST['body']),
          'user_id' => $_SESSION['user_id'],
          'title_err' => '',
          'body_err' => ''
        ];

        // validate data
        if(empty($data['title'])  && empty($data['img'])){
          $data['title_err'] = 'Please enter your message or attach an image to shout';
        }

        if(empty($data['body'])){
          $data['body_err'] = 'Please enter body text';
        }

        // ensure no errors
        if(empty($data['title_err']) && empty($data['body_err'])){
          if($this->postModel->updatePost($data)){
            flash('success_message', 'Post Updated');
            redirect('posts/show/' . $id);
          } else {
            die('Oops! Something went wrong');
          }

        } else {
          // load view with errors
          $this->view('posts/edit', $data);
        }

      } else {
        // get existing post from model
        $post = $this->postModel->getPostById($id);
        // check for owner
        if($post->user_id != $_SESSION['user_id']){
          redirect('posts/index');
        }

        // decode post img
        if($post->img){
          $img = base64_decode($post->img);
        } else {
          $img = '';
        }

        $data = [
          'id' => $id,
          'img' => $img,
          'title' => $post->title,
          'body' => $post->body
        ];

        $this->view('posts/edit', $data);
      }
    }

    public function show($id){
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

      $post = $this->postModel->getPostById($id);
      $user = $this->userModel->getUserById($post->user_id);
      if($user->img){
        // decode b64 to img
        $user->img = base64_decode($user->img);
      }
      $comments = $this->commentModel->getComments($id);

      // check to see if its  a POST request
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // sanitize POST array
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $userName = $_SESSION['user_name'];

        // decode imgs
        if($post->img){
          $post->img = base64_decode($post->img);
        }

        // get user profile picture
        foreach($comments as $comment){
          $commentUser = $this->userModel->getUserById($comment->fromId);
          $comment->colour = $commentUser->colour;
          if($commentUser->img){
            // decode b64 to img
            $comment->img = base64_decode($commentUser->img);
          }
        }

        if(isset($_POST['starPostBtn'])){
          // check if post has already been liked by session user
          $data = [
            'post_id' => $id,
            'user_id' => $_SESSION['user_id']
          ];

          $starred = $this->starModel->getStarByUserAndPostId($data);
          if($starred){
            $this->starModel->removeStar($data);
            // update post record
            $post = $this->postModel->getPostById($id);

            // decode post img
            if($post->img){
              $post->img = base64_decode($post->img);
            }

            $currentStarCount = intval($post->stars);
            $starCount = $currentStarCount - 1;

            $postData = [
              'id' => $id,
              'stars' => $starCount
            ];
            $this->postModel->updatePostStars($postData);

            // remove star from users account
            $user = $this->userModel->getUserById($post->user_id);
            $userStars = $user->stars - 1;

            $data = [
              'id' => $post->user_id,
              'stars' => $userStars
            ];
            $this->userModel->updateUserStars($data);

            // remove activity
            $postActivities = $this->activityModel->getActivitiesByPostId($id);
            foreach($postActivities as $activity){
              if($activity->type == 'Star'){
                if($activity->user_id == $_SESSION['user_id']){
                  $this->activityModel->deleteActivity($activity->id);
                }
              }
            }

            $starList = $this->starModel->getStarsByPostId($id);

            foreach($starList as $star){
              $starUser = $this->userModel->getUserById($star->user_id);
              if($starUser->img){
                // decode b64 to img
                $star->img = base64_decode($starUser->img);
              } else {
                $star->img = '';
              }
              $star->colour = $starUser->colour;
            }

            $user = $this->userModel->getUserById($post->user_id);
            if($user->img){
              // decode b64 to img
              $user->img = base64_decode($user->img);
            }

            $data = [
              'removed_from_hub' => $removedFromHub,
              'created_new_hub' => $createdNewHub,
              'post' => $post,
              'starred' => false,
              'no_of_stars' => count($starList),
              'star_list' => $starList,
              'user' => $user,
              'comments' => $comments
            ];

            $this->view('posts/show', $data);
          } else {
            $data['user_name'] = $userName;
            $this->starModel->starPost($data);
            // update post record
            $post = $this->postModel->getPostById($id);

            // decode post img
            if($post->img){
              $post->img = base64_decode($post->img);
            }

            $currentStarCount = intval($post->stars);
            $starCount = $currentStarCount + 1;

            $postData = [
              'id' => $id,
              'stars' => $starCount
            ];
            $this->postModel->updatePostStars($postData);

            // update activity
            $postActivities = $this->activityModel->getActivitiesByPostId($id);

            $alreadyNotified = false;
            foreach($postActivities as $activity){
              if($activity->type == 'Star'){
                if($activity->user_id == $_SESSION['user_id']){
                  $alreadyNotified = true;
                }
              }
            }

            if(!$alreadyNotified){
              if($post->user_id != $_SESSION['user_id']){
                // update hubs activity
                $activityData = [
                  'hub_id' => $_SESSION['user_hub_id'],
                  'hub' => $_SESSION['user_hub'],
                  'user_id' => $_SESSION['user_id'],
                  'user' => $_SESSION['user_name'],
                  'to_id' => $post->user_id,
                  'type' => 'Star',
                  'post_id' => $id
                ];

                $this->activityModel->addPostActivity($activityData);
              }
            }

            // add star for users account
            $user = $this->userModel->getUserById($post->user_id);
            $userStars = $user->stars + 1;

            $data = [
              'id' => $post->user_id,
              'stars' => $userStars
            ];
            $this->userModel->updateUserStars($data);

            $starList = $this->starModel->getStarsByPostId($id);

            foreach($starList as $star){
              $starUser = $this->userModel->getUserById($star->user_id);
              if($starUser->img){
                // decode b64 to img
                $star->img = base64_decode($starUser->img);
              } else {
                $star->img = '';
              }
              $star->colour = $starUser->colour;
            }

            $user = $this->userModel->getUserById($post->user_id);
            if($user->img){
              // decode b64 to img
              $user->img = base64_decode($user->img);
            }

            $data = [
              'removed_from_hub' => $removedFromHub,
              'created_new_hub' => $createdNewHub,
              'post' => $post,
              'starred' => true,
              'no_of_stars' => count($starList),
              'star_list' => $starList,
              'user' => $user,
              'comments' => $comments
            ];

            $this->view('posts/show', $data);
          }
        }

        // check if post has been liked by session user
        $data = [
          'post_id' => $id,
          'user_id' => $_SESSION['user_id']
        ];

        $starred = $this->starModel->getStarByUserAndPostId($data);
        if($starred){
          $starred = true;

        } else {
          $starred = false;
        }

        $data = [
          'removed_from_hub' => $removedFromHub,
          'created_new_hub' => $createdNewHub,
          'post' => $post,
          'user' => $user,
          'post_id' => $id,
          'from_id' => $_SESSION['user_id'],
          'from_name' => $userName,
          'hub_id' => $_SESSION['user_hub_id'],
          'starred' => $starred,
          'comment' => $_POST['comment'],
          'comments' => $comments,
          'comment_err' => ''
        ];

        // validate data
        if(empty($data['comment'])){
          $data['comment_err'] = 'Please enter your comment';
        }

        // ensure no errors
        if(empty($data['comment_err'])){
          $commentId = $this->commentModel->addComment($data);
          if($commentId){
            flash('success_message', 'Comment Added');

            // update hubs activity for each hubmate
            $hubmates = $this->userModel->getHubmates($_SESSION['user_hub_id']);
            foreach($hubmates as $mate){
              // omit self from post data
              if($mate->id != $_SESSION['user_id']){
                $activityData = [
                  'hub_id' => $_SESSION['user_hub_id'],
                  'hub' => $_SESSION['user_hub_id'],
                  'user_id' => $_SESSION['user_id'],
                  'user' => $_SESSION['user_name'],
                  'to_id' => $mate->id,
                  'post_id' => $id,
                  'type' => 'Comment',
                  'comment_id' => $commentId,
                  'remover_id' => 0,
                  'remover_name' => '',
                  'notify_user' => 0
                ];

                $this->activityModel->addCommentActivity($activityData);
              }
            }

            redirect('posts/show/' . $id, $data);
          } else {
            die('Oops! Something went wrong');
          }

        } else {
          // check if post has been liked by session user
          $starredData = [
            'post_id' => $id,
            'user_id' => $_SESSION['user_id']
          ];

          $starred = $this->starModel->getStarByUserAndPostId($starredData);

          if($starred){
            $starred = true;
          } else {
            $starred = false;
          }

          $starList = $this->starModel->getStarsByPostId($id);

          foreach($starList as $star){
            $starUser = $this->userModel->getUserById($star->user_id);
            if($starUser->img){
              // decode b64 to img
              $star->img = base64_decode($starUser->img);
            } else {
              $star->img = '';
            }
            $star->colour = $starUser->colour;
          }

          $data['starred'] = $starred;
          $data['no_of_stars'] = count($starList);
          $data['star_list'] = $starList;

          // load view with errors
          $this->view('posts/show', $data);
        }

      } else {
        // get user profile picture
        foreach($comments as $comment){
          $commentUser = $this->userModel->getUserById($comment->fromId);
          $comment->colour = $commentUser->colour;
          if($commentUser->img){
            // decode b64 to img
            $comment->img = base64_decode($commentUser->img);
          }
        }

        // decode post img
        if($post->img){
          $post->img = base64_decode($post->img);
        }

        // check if post has been liked by session user
        $data = [
          'post_id' => $id,
          'user_id' => $_SESSION['user_id']
        ];

        $starred = $this->starModel->getStarByUserAndPostId($data);
        if($starred){
          $starred = true;
        } else {
          $starred = false;
        }

        $starList = $this->starModel->getStarsByPostId($id);

        foreach($starList as $star){
          $starUser = $this->userModel->getUserById($star->user_id);
          if($starUser->img){
            // decode b64 to img
            $star->img = base64_decode($starUser->img);
          } else {
            $star->img = '';
          }
          $star->colour = $starUser->colour;
        }

        if($_SESSION['flash_message']){
          flash('success_message', $_SESSION['flash_message']);
        }

        $data = [
          'removed_from_hub' => $removedFromHub,
          'created_new_hub' => $createdNewHub,
          'post' => $post,
          'starred' => $starred,
          'no_of_stars' => count($starList),
          'star_list' => $starList,
          'user' => $user,
          'comments' => $comments
        ];

        $this->view('posts/show', $data);
        $_SESSION['flash_message'] = '';
      }
    }

    public function delete($id){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // get existing post from model
        $post = $this->postModel->getPostById($id);
        // check for owner
        if($post->user_id != $_SESSION['user_id']){
          redirect('posts/index');
        }

        if($this->postModel->deletePost($id)){
          flash('post_message', 'Post Removed');

          // delete comments
          $postComments = $this->commentModel->getCommentsByPostId($id);
          foreach($postComments as $comment){
            $this->commentModel->deleteComment($comment->commentId);
          }

          $postActivities = $this->activityModel->getActivitiesByPostId($post->postId);
          foreach($postActivities as $activity){
            $this->activityModel->deleteActivity($activity->activityId);
          }
          redirect('posts/index');
        } else {
          die('Oops! Something went wrong');
        }
      } else {
        redirect('posts/index');
      }
    }
  }
?>
