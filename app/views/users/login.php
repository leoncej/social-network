<!-- metadata -->
<?php $pageTitle = "Welcome"; ?>
<?php $pageDesc = "Create an account or log in to TheHub - A new, fun & private way to keep in touch with those closest to you."; ?>
<?php $pageRobots = "index"; ?>
<?php require APPROOT . '/views/inc/header.php'; ?>
  <?php if(!isset($_COOKIE['firsttime'])) : ?>
    <?php setcookie("firsttime", "no", /* EXPIRE */); ?>
    <div class="loader-container bg-hub-grape d-flex justify-content-center" style="position:fixed;left:0;top:0;">
      <img src="<?php echo URLROOT; ?>/public/img/hub_logo.png" class="rounded load-hub-img mr-2" style="height:4em;margin-top:40vh;">
      <span class="pre-loader"><span class="pre-loader-inner"></span></span>
    </div>

    <div class="row wrapper" style="opacity:0;transition: opacity 1s ease-in;">
  <?php else : ?>
    <div class="row wrapper">
  <?php endif; ?>
    <div class="box"></div>
    <div class="box"></div>
    <div class="box"></div>
    <div class="box"></div>
    <div class="box"></div>
    <div class="box"></div>
    <div class="col-md-6 mx-auto mt-5 cabin-font text-hub-dark-purple login-messages">
      <h4 class="text-dark my-5">Create your own Hubs</h4>
      <h4 class="text-dark my-5">Remove the interference of others</h4>
      <h4 class="text-dark my-2">Make <span class="poppins-font text-hub-grape">The<span class="text-lilac">Hub</SPAN></span> your own</h4>
      <div class="card bg-success mt-5">
        <h6 class="montserrat-font text-center text-white pt-2">APP COMING SOON</h6>
      </div>
    </div>
    <div class="col-md-5 mx-auto login-forms">
      <div class="card card-body mt-5 login-cards login">
        <span class="cabin-font"><?php flash('success_message'); ?></span>
        <h2 class="cabin-font text-hub-dark-purple">Login</h2>
        <form action="<?php echo URLROOT; ?>/users/login" method="post">
          <div class="form-group">
            <label for="email" class="cabin-font text-hub-dark-purple">Email:</label>
            <input type="email" name="email" class="form-control form-control-lg <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>" style="font-size:1em;">
            <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
          </div>
          <div class="form-group">
            <label for="password" class="cabin-font text-hub-dark-purple">Password:</label>
            <div class="input-group" id="showHidePassword">
              <input type="password" name="password" class="form-control form-control-lg <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['password']; ?>" style="font-size:1em;">
              <div class="input-group-addon p-2 pl-3">
                <a href="" class="text-dark"><i class="bi bi-eye-slash" aria-hidden="true"></i></a>
              </div>
              <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
            </div>
          </div>
          <a href="<?php echo URLROOT; ?>/users/password" class="cabin-font">Forgot Password?</a>
          <div class="row mt-4">
            <div class="col">
              <input type="submit" value="Login" class="btn btn-success btn-block cabin-font">
            </div>
            <div class="col">
              <a href="<?php echo URLROOT; ?>/users/register" class="btn btn-block cabin-font">No account? Sign up</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
