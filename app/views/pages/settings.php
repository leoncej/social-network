<!-- metadata -->
<?php $pageTitle = "Settings"; ?>
<?php $pageDesc = "Settings Description"; ?>
<?php $pageRobots = "noindex,nofollow"; ?>
<?php require APPROOT . '/views/inc/header.php'; ?>
  <!-- check if user has been removed from a Hub -->
  <div data-toggle="modal" class="modal fade" id="removedFromHubModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog cabin-font" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Hub Removal</h5>
        </div>
        <div class="modal-body">
          <p>You have been removed from <?php echo $data['removed_from_hub']; ?>Hub. As a result it will no longer appear on your Hub list.</p>
          <?php if($data['created_new_hub']) : ?>
            <p>Since <?php echo $data['removed_from_hub']; ?>Hub was the only Hub you were in at the time, we have put you in your own NewHub. You can invite Hubmates to join this Hub as normal.</p>
          <?php endif; ?>
        </div>
        <div class="modal-footer">
          <form action="<?php echo URLROOT; ?>/posts/index" method="post">
            <input type="submit" name="removeOkayBtn" value="Okay" class="btn btn-light cabin-font">
          </form>
        </div>
      </div>
    </div>
  </div>
  <?php if($data['removed_from_hub']) : ?>
    <a data-toggle="modal" data-target="#removedFromHubModal" data-keyboard="false" data-backdrop="static" id="removedModalToggle"></a>
  <?php endif; ?>
  <span class="cabin-font"><?php flash('error_message'); ?></span>
  <h1 class="mt-3 cabin-font text-hub-dark-purple">Settings</h1>
  <h3 class="text-muted text-right my-4 cabin-font">Hub Settings</h3>
  <h5 class="cabin-font text-hub-dark-purple">Change Hubname?</h5>
  <form action="<?php echo URLROOT; ?>/pages/settings" method="post">
    <div class="form-group">
      <label for="hubname" class="cabin-font">Hubname: </label>
      <input type="text" name="hubname" class="form-control form-control-lg test-muted <?php echo (!empty($data['hubname_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $_SESSION['user_hub']; ?>" style="font-size:1em;">
      <span class="invalid-feedback"><?php echo $data['hubname_err']; ?></span>
    </div>
    <?php if($_SESSION['user_hub_id'] == $data['default_hub']) : ?>
      <input type="submit" class="btn btn-primary cabin-font" value="Default Hub" disabled>
    <?php else : ?>
      <input type="submit" class="btn btn-primary cabin-font" name="makeDefaultHubBtn" value="Make Default">
    <?php endif; ?>
    <input type="submit" class="btn btn-success pull-right cabin-font" name="updateHubnameBtn" value="Change">
  </form>
  <br>
  <ul class="list-unstyled cabin-font">
    <li>Hubname: <?php echo $_SESSION['user_hub'] ?></li>
    <li>Hub ID: <?php echo $_SESSION['user_hub_id'] ?></li>
    <li>Hubmates: <?php echo $data['no_of_mates'] ?></li>
    <form action="<?php echo URLROOT; ?>/pages/settings" method="post">
      <?php if($data['no_of_hubs'] == 4) : ?>
        <input type="submit" class="btn btn-danger mt-3" name="leaveHubBtn" value="Leave Hub" disabled>
        <br>
        <small class="text-muted">You are unable to leave this Hub as it is the only Hub you are in. If you wish to leave it, please create a new Hub first</small>
      <?php else : ?>
        <input type="submit" class="btn btn-danger my-3" name="leaveHubBtn" value="Leave Hub">
      <?php endif; ?>
    </form>
  </ul>
  <h5 class="cabin-font text-hub-dark-purple">Create a new Hub?</h5>
  <form action="<?php echo URLROOT; ?>/pages/settings" method="post">
    <div class="form-group">
      <label for="new_hubname" class="cabin-font">New Hubname: </label>
      <input type="text" name="new_hubname" class="form-control form-control-lg test-muted <?php echo (!empty($data['new_hubname_err'])) ? 'is-invalid' : ''; ?>" style="font-size:1em;">
      <span class="invalid-feedback"><?php echo $data['new_hubname_err']; ?></span>
    </div>
    <?php if($data['no_of_hubs'] == 0) : ?>
      <input type="submit" class="btn btn-success pull-right cabin-font" name="createNewHubBtn" value="Create" disabled>
      <br>
      <br>
      <p class="text-muted cabin-font">You are unable to create anymore Hubs as you have reached the limit (5.) If you wish to create a new Hub, please leave one you are currently in beforehand</p>
    <?php else : ?>
      <input type="submit" class="btn btn-success pull-right cabin-font" name="createNewHubBtn" value="Create">
      <p class="text-muted cabin-font">You can enter <?php echo $data['no_of_hubs']; ?> more Hubs (limit: 5)</p>
    <?php endif; ?>
  </form>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <h3 class="text-muted text-right mt-4 cabin-font text-hub-dark-purple">Account Settings</h3>
  <p class="text-muted text-right mb-4 cabin-font">Stars: <?php echo $data['user']->stars; ?></p>
  <h5 class="cabin-font text-hub-dark-purple">Change email address?</h5>
  <form action="<?php echo URLROOT; ?>/pages/settings" method="post">
    <div class="form-group">
      <label for="new_email" class="cabin-font">Email: </label>
      <input type="text" name="new_email" class="form-control form-control-lg test-muted <?php echo (!empty($data['new_email_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['user']->email; ?>" style="font-size:1em;">
      <span class="invalid-feedback"><?php echo $data['new_email_err']; ?></span>
    </div>
    <input type="submit" class="btn btn-success pull-right cabin-font" name="newEmailBtn" value="Change">
  </form>
  <br>
  <br>
  <br>
  <h5 class="cabin-font text-hub-dark-purple">Change password?</h5>
  <form action="<?php echo URLROOT; ?>/pages/settings" method="post">
    <div class="form-group">
      <label for="password" class="cabin-font">Current Password: </label>
      <div class="input-group" id="showHidePassword">
        <input type="password" name="password" class="form-control form-control-lg text-muted <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" style="font-size:1em;">
        <div class="input-group-addon p-2 pl-3">
          <a href="" class="text-dark"><i class="bi bi-eye-slash" aria-hidden="true"></i></a>
        </div>
        <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
      </div>
    </div>
    <div class="form-group">
      <label for="new_password" class="cabin-font">New Password: </label>
      <div class="input-group" id="showHidePassword">
        <input type="password" name="new_password" class="form-control form-control-lg text-muted <?php echo (!empty($data['new_password_err'])) ? 'is-invalid' : ''; ?>" style="font-size:1em;">
        <div class="input-group-addon p-2 pl-3">
          <a href="" class="text-dark"><i class="bi bi-eye-slash" aria-hidden="true"></i></a>
        </div>
        <span class="invalid-feedback"><?php echo $data['new_password_err']; ?></span>
      </div>
    </div>
    <div class="form-group">
      <label for="confirm_password" class="cabin-font">Confirm Password: </label>
      <div class="input-group" id="showHidePassword">
        <input type="password" name="confirm_password" class="form-control form-control-lg text-muted <?php echo (!empty($data['confirm_password_err'])) ? 'is-invalid' : ''; ?>" style="font-size:1em;">
        <div class="input-group-addon p-2 pl-3">
          <a href="" class="text-dark"><i class="bi bi-eye-slash" aria-hidden="true"></i></a>
        </div>
        <span class="invalid-feedback"><?php echo $data['confirm_password_err']; ?></span>
      </div>
    </div>
    <input type="submit" class="btn btn-success pull-right cabin-font" name="newPasswordBtn" value="Change">
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog cabin-font" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Are you sure?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>If you delete your account it cannot be recovered. All your data will be lost.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light cabin-font" data-dismiss="modal">Cancel</button>
            <input type="submit" class="btn text-danger cabin-font" name="deleteAccountBtn" value="Delete">
          </div>
        </div>
      </div>
    </div>
    <br>
    <br>
    <br>
    <button type="button" class="btn my-3 text-danger pull-right cabin-font" data-toggle="modal" data-target="#deleteModal">
      Delete Account
    </button>
  </form>
<?php require APPROOT . '/views/inc/footer.php'; ?>
