<?php
  session_start();

  // flash message helper
  // example - flash('register_success', 'You are now registered')
  function flash($name = '', $message = '', $class = 'alert alert-success'){
    if(!empty($name)){
      if(!empty($message) && empty($_SESSION[$name])){
        if(!empty($_SESSION[$name])){
          unset($_SESSION[$name]);
        }
        if(!empty($_SESSION[$name . '_class'])){
          unset($_SESSION[$name . '_class']);
        }
        $_SESSION[$name] = $message;
        $_SESSION[$name . '_class'] = $class;
      } elseif(empty($message) && !empty($_SESSION[$name])){
        $class = !empty($_SESSION[$name . '_class']) ? $_SESSION[$name . '_class'] : '';
        echo '<div class="fadeOutDown" id="flash-container"><div class="'.$class.' fadeOutDown" id="msg-flash">'.$_SESSION[$name].'</div></div>';
        unset($_SESSION[$name]);
        unset($_SESSION[$name . '_class']);
      }
    }
  }

  // error flash message
  function errorFlash($name = '', $message = '', $class = 'alert alert-danger'){
    if(!empty($name)){
      if(!empty($message) && empty($_SESSION[$name])){
        if(!empty($_SESSION[$name])){
          unset($_SESSION[$name]);
        }
        if(!empty($_SESSION[$name . '_class'])){
          unset($_SESSION[$name . '_class']);
        }
        $_SESSION[$name] = $message;
        $_SESSION[$name . '_class'] = $class;
      } elseif(empty($message) && !empty($_SESSION[$name])){
        $class = !empty($_SESSION[$name . '_class']) ? $_SESSION[$name . '_class'] : '';
        echo '<div class="fadeOutDown" id="flash-container"><div class="'.$class.' fadeOutDown" id="msg-flash">'.$_SESSION[$name].'</div></div>';
        unset($_SESSION[$name]);
        unset($_SESSION[$name . '_class']);
      }
    }
  }

  function isLoggedIn(){
    if(isset($_SESSION['user_id'])){
      return true;
    } else {
      return false;
    }
  }
?>
