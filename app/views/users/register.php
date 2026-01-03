<!-- metadata -->
<?php $pageTitle = "Join Us"; ?>
<?php $pageDesc = "Join TheHub today! Create your own Hubs, post Shouts, send Whispers and much more."; ?>
<?php $pageRobots = "index"; ?>
<?php require APPROOT . '/views/inc/header.php'; ?>
  <div class="row">
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
    <div class="col-md-6 mx-auto login-forms register-forms">
      <div class="card card-body mt-5 login-cards">
        <p class="text-muted cabin-font text-right">Step 1</p>
        <h2 class="cabin-font text-hub-dark-purple">Create an account</h2>
        <form action="<?php echo URLROOT; ?>/users/register" method="post">
          <div class="form-group">
            <label for="name" class="cabin-font text-hub-dark-purple">First Name: <sup>*</sup></label>
            <input type="text" name="name" class="form-control form-control-lg <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['name']; ?>" style="font-size:1em;">
            <span class="invalid-feedback"><?php echo $data['name_err']; ?></span>
          </div>
          <div class="form-group">
            <label for="last_name" class="cabin-font text-hub-dark-purple">Last Name: <sup>*</sup></label>
            <input type="text" name="last_name" class="form-control form-control-lg <?php echo (!empty($data['last_name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['last_name']; ?>" style="font-size:1em;">
            <span class="invalid-feedback"><?php echo $data['last_name_err']; ?></span>
          </div>
          <div class="form-group">
            <label for="email" class="cabin-font text-hub-dark-purple">Email: <sup>*</sup></label>
            <input type="email" name="email" class="form-control form-control-lg <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>" style="font-size:1em;">
            <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
          </div>
          <div class="form-group">
            <label for="password" class="cabin-font text-hub-dark-purple">Password: <sup>*</sup></label>
            <div class="input-group" id="showHidePassword">
              <input type="password" name="password" class="form-control form-control-lg <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['password']; ?>" style="font-size:1em;">
              <div class="input-group-addon p-2 pl-3">
                <a href="" class="text-dark"><i class="bi bi-eye-slash" aria-hidden="true"></i></a>
              </div>
              <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
            </div>
          </div>
          <div class="form-group">
            <label for="confirm_password" class="cabin-font text-hub-dark-purple">Confirm Password: <sup>*</sup></label>
            <div class="input-group" id="showHidePassword">
              <input type="password" name="confirm_password" class="form-control form-control-lg <?php echo (!empty($data['confirm_password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['confirm_password']; ?>" style="font-size:1em;">
              <div class="input-group-addon p-2 pl-3">
                <a href="" class="text-dark"><i class="bi bi-eye-slash" aria-hidden="true"></i></a>
              </div>
              <span class="invalid-feedback"><?php echo $data['confirm_password_err']; ?></span>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <input type="submit" value="Next" class="btn btn-success btn-block cabin-font">
            </div>
            <div class="col">
              <a href="<?php echo URLROOT; ?>" class="btn btn-block cabin-font text-hub-dark-purple">Already have an account?</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
