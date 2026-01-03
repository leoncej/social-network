<!-- metadata -->
<?php $pageTitle = "Forgot Password"; ?>
<?php $pageDesc = "Forgot Password Description"; ?>
<?php $pageRobots = "noindex"; ?>
<?php require APPROOT . '/views/inc/header.php'; ?>
    <div class="row">
      <div class="box"></div>
      <div class="box"></div>
      <div class="box"></div>
      <div class="box"></div>
      <div class="box"></div>
      <div class="box"></div>
      <div class="col-md-6 mx-auto login-forms password-form">
        <div class="card card-body mt-5 bg-white login-cards">
          <h2 class="cabin-font text-hub-dark-purple">Password Reset</h2>
          <p class="cabin-font text-hub-dark-purple">Don't worry, we've all been there! Just enter your email address and we'll send you a password reset link</p>
          <form action="<?php echo URLROOT; ?>/users/password" method="post">
            <div class="form-group">
              <label for="email" class="cabin-font text-hub-dark-purple">Email:</label>
              <input type="email" name="email" class="form-control form-control-lg <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" style="font-size:1em;">
              <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
            </div>
            <div class="row mt-4">
              <div class="col">
                <input type="submit" value="Reset" class="btn btn-success btn-block cabin-font">
              </div>
              <div class="col">
                <a href="<?php echo URLROOT; ?>" class="btn btn-block cabin-font text-hub-dark-purple">Cancel</a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
