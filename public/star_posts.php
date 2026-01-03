<?php
  session_start();

  $postId = $_POST['post_id'];
  $starred = $_POST['starred'];
  $userId = $_POST['user_id'];
  $postUserId = $_POST['post_user_id'];
  $userName = $_POST['user_name'];
  $userColour = $_POST['user_colour'];
  $userImg = $_POST['user_img'];

  define('DB_HOST', 'localhost');
  define('DB_USER', 'root');
  define('DB_PASS', '1471chelsea');
  define('DB_NAME', 'thehub');
  // define('DB_HOST', 'localhost');
  // define('DB_USER', 'thehub');
  // define('DB_PASS', '1471chelsea!!#');
  // define('DB_NAME', 'thehub');

  require_once '../app/libraries/Database.php';
  $db = new Database;

  // starred is reversed for its purpose here
  if($starred == 0){
    $starred = 1;
  } else {
    $starred = 0;
  }

  if($starred){
    $data = [
      'post_id' => $postId,
      'user_id' => $userId,
      'user_name' => $userName
    ];
    $db->query('INSERT INTO stars (post_id, user_id, user_name) VALUES(:post_id, :user_id, :user_name)');
    // bind values
    $db->bind(':post_id', $data['post_id']);
    $db->bind(':user_id', $data['user_id']);
    $db->bind(':user_name', $data['user_name']);

    // execute
    $db->execute();

    // update post record
    $db->query('SELECT * FROM posts WHERE id = :id');
    $db->bind(':id', $postId);

    $post = $db->single();

    $currentStarCount = intval($post->stars);
    $starCount = $currentStarCount + 1;

    $postData = [
      'id' => $postId,
      'stars' => $starCount
    ];
    $db->query('UPDATE posts SET stars = :stars WHERE id = :id');
    // bind values
    $db->bind(':id', $postData['id']);
    $db->bind(':stars', $postData['stars']);

    // execute
    $db->execute();

    // update activity
    $db->query('SELECT *,
                activities.id as activityId,
                activities.hub_id as hubId,
                activities.post_id as postId,
                activities.user_id as userId,
                activities.user as user,
                activities.type as type,
                activities.created_at as activityCreated
                FROM activities
                WHERE activities.post_id = :post_id
                ORDER BY activities.created_at DESC
                ');

    $db->bind(':post_id', $postId);

    $postActivities = $db->resultSet();
    print_r($postActivities);

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
        // update hubs activity, notifying post author
        $activityData = [
          'hub_id' => $_SESSION['user_hub_id'],
          'hub' => $_SESSION['user_hub'],
          'user_id' => $_SESSION['user_id'],
          'user' => $_SESSION['user_name'],
          'to_id' => $post->user_id,
          'type' => 'Star',
          'post_id' => $postId,
          'comment_id' => 0,
          'remover_id' => 0,
          'remover_name' => '',
          'notify_user' => 0
        ];

        $db->query('INSERT INTO activities (hub_id, hub, user_id, user, to_id, type, post_id, comment_id, remover_id, remover_name, notify_user) VALUES(:hub_id, :hub, :user_id, :user, :to_id, :type, :post_id, :comment_id, :remover_id, :remover_name, :notify_user)');
        // bind values
        $db->bind(':hub_id', $activityData['hub_id']);
        $db->bind(':hub', $activityData['hub']);
        $db->bind(':user_id', $activityData['user_id']);
        $db->bind(':user', $activityData['user']);
        $db->bind(':to_id', $activityData['to_id']);
        $db->bind(':type', $activityData['type']);
        $db->bind(':post_id', $activityData['post_id']);
        $db->bind(':comment_id', $activityData['comment_id']);
        $db->bind(':remover_id', $activityData['remover_id']);
        $db->bind(':remover_name', $activityData['remover_name']);
        $db->bind(':notify_user', $activityData['notify_user']);

        // execute
        $db->execute();
      } else {
        // update hubs activity
        $activityData = [
          'hub_id' => $_SESSION['user_hub_id'],
          'hub' => $_SESSION['user_hub'],
          'user_id' => $_SESSION['user_id'],
          'user' => $_SESSION['user_name'],
          'to_id' => 0,
          'type' => 'Star',
          'post_id' => $postId,
          'comment_id' => 0,
          'remover_id' => 0,
          'remover_name' => '',
          'notify_user' => 0
        ];

        $db->query('INSERT INTO activities (hub_id, hub, user_id, user, to_id, type, post_id, comment_id, remover_id, remover_name, notify_user) VALUES(:hub_id, :hub, :user_id, :user, :to_id, :type, :post_id, :comment_id, :remover_id, :remover_name, :notify_user)');
        // bind values
        $db->bind(':hub_id', $activityData['hub_id']);
        $db->bind(':hub', $activityData['hub']);
        $db->bind(':user_id', $activityData['user_id']);
        $db->bind(':user', $activityData['user']);
        $db->bind(':to_id', $activityData['to_id']);
        $db->bind(':type', $activityData['type']);
        $db->bind(':post_id', $activityData['post_id']);
        $db->bind(':comment_id', $activityData['comment_id']);
        $db->bind(':remover_id', $activityData['remover_id']);
        $db->bind(':remover_name', $activityData['remover_name']);
        $db->bind(':notify_user', $activityData['notify_user']);

        // execute
        $db->execute();
      }
    }

    // needs to add star from post users account
    $db->query('SELECT * FROM users WHERE id = :id');
    $db->bind(':id', $postUserId);
    $user = $db->single();

    $userStars = $user->stars + 1;

    $data = [
      'id' => $postUserId,
      'stars' => $userStars
    ];
    $db->query('UPDATE users SET stars = :stars WHERE id = :id');
    // bind values
    $db->bind(':id', $data['id']);
    $db->bind(':stars', $data['stars']);

    // execute
    $db->execute();
  } else {
    $data = [
      'post_id' => $postId,
      'user_id' => $userId
    ];
    $db->query('DELETE FROM stars WHERE post_id = :post_id AND user_id = :user_id');
    // bind values
    $db->bind(':post_id', $data['post_id']);
    $db->bind(':user_id', $data['user_id']);

    // execute
    $db->execute();

    // update post record
    $db->query('SELECT * FROM posts WHERE id = :id');
    $db->bind(':id', $postId);

    $post = $db->single();

    $currentStarCount = intval($post->stars);
    $starCount = $currentStarCount - 1;

    $postData = [
      'id' => $postId,
      'stars' => $starCount
    ];
    $db->query('UPDATE posts SET stars = :stars WHERE id = :id');
    // bind values
    $db->bind(':id', $postData['id']);
    $db->bind(':stars', $postData['stars']);

    // execute
    $db->execute();

    // remove activity
    $db->query('SELECT *,
                activities.id as activityId,
                activities.hub_id as hubId,
                activities.post_id as postId,
                activities.user_id as userId,
                activities.user as user,
                activities.type as type,
                activities.created_at as activityCreated
                FROM activities
                WHERE activities.post_id = :post_id
                ORDER BY activities.created_at DESC
                ');

    $db->bind(':post_id', $postId);

    $postActivities = $db->resultSet();

    foreach($postActivities as $activity){
      if($activity->type == 'Star'){
        if($activity->user_id == $_SESSION['user_id']){
          $id = $activity->id;
          $db->query('DELETE FROM activities WHERE id = :id');
          // bind values
          $db->bind(':id', $id);

          // execute
          $db->execute();
        }
      }
    }

    // remove star from users account
    $db->query('SELECT * FROM users WHERE id = :id');
    $db->bind(':id', $postUserId);
    $user = $db->single();

    $userStars = $user->stars - 1;

    $data = [
      'id' => $postUserId,
      'stars' => $userStars
    ];
    $db->query('UPDATE users SET stars = :stars WHERE id = :id');
    // bind values
    $db->bind(':id', $data['id']);
    $db->bind(':stars', $data['stars']);

    // execute
    $db->execute();
  }
?>
