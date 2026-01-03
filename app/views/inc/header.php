<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?php echo $pageDesc; ?>">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="robots" content="<?php echo $pageRobots; ?>">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://unpkg.com/aos@2.3.0/dist/aos.css">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Cabin&family=Poppins:wght@600&family=Montserrat:wght@500&display=swap" rel="stylesheet">
  <link rel="icon" href="<?php echo URLROOT; ?>/public/img/hub_logo.png">
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/style.css">
  <?php if(isset($_SESSION['user_id'])) : ?>
    <title><?php echo $_SESSION['user_hub']; ?>Hub &#124; <?php echo $pageTitle; ?></title>
  <?php else : ?>
    <title><?php echo SITENAME; ?> &#124; <?php echo $pageTitle; ?></title>
  <?php endif; ?>
</head>
<?php if(isset($_SESSION['user_id'])) : ?>
  <body id="bodyTag">
<?php else : ?>
  <body id="bodyTag">
<?php endif; ?>
  <?php require APPROOT . '/views/inc/navbar.php' ?>
  <?php if(isset($_SESSION['user_id'])) : ?>
    <?php if($_SESSION['seen_welcome_message'] < 1) : ?>
      <div class="loader-container bg-white d-flex justify-content-center" style="position:fixed;left:0;top:0;">
        <div class="d-flex flex-column">
          <div class="d-flex justify-content-center">
            <?php if($_SESSION['user_img']) : ?>
              <div class="rounded-circle login-loader-img border ml-1 mt-2 mb-n1 border-<?php echo $_SESSION['user_colour']; ?>" style="display:inline-block;margin-top:35vh !important;height:6em;width:6em;overflow:hidden;border-width:.2em !important;background-image:url(<?php echo $_SESSION['user_img']; ?>);background-size:8.4em;background-position:50% 50%;background-repeat:no-repeat;"></div> &nbsp;
            <?php else : ?>
              <i class="fa fa-user-circle login-loader-img text-<?php echo $_SESSION['user_colour']; ?>" style="font-size:60px;font-align:center;margin-top:35vh;border-radius:50%;"></i> &nbsp;
            <?php endif; ?>
          </div>
          <div class="d-flex welcome-pre-loader">
            <h1 class="poppins-font text-hub-grape mr-2">welcome</h1>
            <span class="login-loader"><span class="login-loader-inner"></span></span>
          </div>
        </div>
      </div>
    <?php endif; ?>
    <?php $_SESSION['seen_welcome_message'] += 1; ?>
  <?php endif; ?>
    <div class="container header-container">
