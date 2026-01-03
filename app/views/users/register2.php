<!-- metadata -->
<?php $pageTitle = "Join Us"; ?>
<?php $pageDesc = "Register2 Description"; ?>
<?php $pageRobots = "noindex"; ?>
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
    <div class="d-none">
      <input type="text" name="name" value="<?php echo $data['name']; ?>">
      <input type="text" name="last_name" value="<?php echo $data['last_name']; ?>">
      <input type="text" name="email" value="<?php echo $data['email']; ?>">
      <input type="text" name="password" value="<?php echo $data['password']; ?>">
    </div>
    <div class="col-md-6 mx-auto login-forms register-forms">
      <div class="card card-body mt-5 login-cards">
        <p class="text-muted cabin-font text-right">Step 2</p>
        <h2 class="cabin-font text-hub-dark-purple">Create an account</h2>
        <form autocomplete="off" action="<?php echo URLROOT; ?>/users/register2" method="post">
          <div class="form-group">
            <label for="about" class="cabin-font text-hub-dark-purple">About:</label>
            <textarea type="text" name="about" class="form-control form-control-lg" style="font-size:1em;"><?php echo $data['about']; ?></textarea>
          </div>
          <div class="form-group">
            <label for="location" class="cabin-font text-hub-dark-purple">Location:</label>
            <input type="text" name="location" class="form-control form-control-lg" value="<?php echo $data['location']; ?>" style="font-size:1em;">
          </div>
          <div class="form-group mb-0">
            <label for="hubname" class="cabin-font text-hub-dark-purple">Hubname: <sup>*</sup></label>
            <input type="text" name="hubname" class="form-control form-control-lg <?php echo (!empty($data['hubname_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['hubname']; ?>" style="font-size:1em;">
            <span class="invalid-feedback"><?php echo $data['hubname_err']; ?></span>
          </div>
          <small class="cabin-font">You can enter other Hubs once your account is registered</small>
          <div class="form-check mt-4">
            <input type="checkbox" class="form-check-input" id="confirmCheckbox" name="checkbox" required>
            <label class="form-check-label cabin-font" for="confirmCheckbox">By selecting this checkbox you are confirming that you are above the age of 13. For more information, please visit our <a href="<?php echo URLROOT; ?>/pages/privacy">Privacy Policy</a></label>
          </div>
          <br>
          <br>
          <br>
          <div class="row">
            <div class="col">
              <input type="submit" value="Register" class="btn btn-success btn-block cabin-font">
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
