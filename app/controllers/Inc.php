<?php
  class Inc extends Controller {
    public function __construct(){
      $this->userModel = $this->model('User');
      $this->hubModel = $this->model('Hub');
    }

    public function navbar(){
      $users = $this->userModel->getUserById($_SESSION['user_id']);

      // check to see if its  a POST request
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $hubId = $_POST['requested_hub_id'];

        $hub = $this->hubModel->getHubById($hubId);
        $hubName = $hub->name;

        $_SESSION['user_hub'] = $hubName;
        $_SESSION['user_hub_id'] = $hubId;

        redirect('posts/index');

      } else {
        $this->view('inc/navbar');
      }
    }
  }
?>
