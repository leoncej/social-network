<!-- metadata -->
<?php $pageTitle = "Edit Profile"; ?>
<?php $pageDesc = "User Profile Edit Description"; ?>
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
  <div class="card card-body mt-5">
    <h2 class="cabin-font text-hub-dark-purple">Edit Profile</h2>
    <form action="<?php echo URLROOT; ?>/users/edit/<?php echo $_SESSION['user_id']; ?>" method="post">
      <div class="form-group d-flex justify-content-center">
        <div class="d-flex justify-content-center">
          <?php if($data['img']) : ?>
            <div id="uploadedProfileImg" class="rounded-circle border border-<?php echo $data['colour']; ?>" style="height:10em;width:10em;overflow:hidden;border-width:.2em !important;background-image:url(<?php echo $data['img']; ?>);background-size:15em;background-position:50% 50%;background-repeat:no-repeat;"></div>
          <?php else : ?>
            <div id="uploadedProfileImg" class="rounded-circle border border-<?php echo $data['colour']; ?>" style="display:none;height:10em;width:10em;overflow:hidden;border-width:.2em !important;background-size:15em;background-position:50% 50%;background-repeat:no-repeat;"></div>
          <?php endif; ?>
        </div>
        <?php if($data['img']) : ?>
          <i class="fa fa-user-circle text-<?php echo $data['colour']; ?>" id="placeholderPicture" style="display:none;font-size:10em;"></i>
        <?php else : ?>
          <i class="fa fa-user-circle text-<?php echo $data['colour']; ?>" id="placeholderPicture" style="font-size:10em;"></i>
        <?php endif; ?>
      </div>
      <div class="d-flex justify-content-center">
        <label for="uploadPhoto" class="cabin-font text-primary" style="cursor:pointer;"><strong>Upload new profile photo</strong></label>
        <input type="file" name="img" id="uploadPhoto" style="opacity:0;position:absolute;z-index:-1;">
        <textarea name="profile_b64_img" class="d-none" id="profileB64Img"><?php echo $data['img']; ?></textarea>
      </div>
      <div class="d-flex justify-content-center mb-4">
        <?php if($data['img']) : ?>
          <p class="cabin-font text-danger" id="imgCancelBtn" style="cursor:pointer;"><a onclick="clearImg()"><strong>Remove profile photo</strong></a></p>
        <?php else : ?>
          <p class="cabin-font text-danger" id="imgCancelBtn" style="visibility:hidden;cursor:pointer;"><a onclick="clearImg()"><strong>Remove profile photo</strong></a></p>
        <?php endif; ?>
      </div>
      <div class="form-group colour-picker">
        <label for="name" class="cabin-font">Colour Picker: </label>
        <div class="form-group d-flex justify-content-center">
          <?php if($data['colour'] == 'primary') : ?>
            <div class="colour-picker-selector rounded-circle d-flex justify-content-center m-3" id="bg-primary" style="height:1.75em;width:1.75em;border:.1em solid rgb(56,27,68);">
              <a href="#">
                <div class="colour-picker-icon rounded-circle bg-primary #" style="height:1.5em;width:1.5em;">
                </div>
              </a>
            </div>
          <?php else : ?>
            <div class="colour-picker-selector rounded-circle d-flex justify-content-center m-3 border-light" id="bg-primary" style="height:1.75em;width:1.75em;border:.1em solid rgb(56,27,68);">
              <a href="#">
                <div class="colour-picker-icon rounded-circle bg-primary #" style="height:1.5em;width:1.5em;">
                </div>
              </a>
            </div>
          <?php endif; ?>
          <?php if($data['colour'] == 'secondary') : ?>
            <div class="colour-picker-selector rounded-circle d-flex justify-content-center m-3" id="bg-secondary" style="height:1.75em;width:1.75em;border:.1em solid rgb(56,27,68);">
              <a href="#">
                <div class="colour-picker-icon rounded-circle bg-secondary #" style="height:1.5em;width:1.5em;">
                </div>
              </a>
            </div>
          <?php else : ?>
            <div class="colour-picker-selector rounded-circle d-flex justify-content-center m-3 border-light" id="bg-secondary" style="height:1.75em;width:1.75em;border:.1em solid rgb(56,27,68);">
              <a href="#">
                <div class="colour-picker-icon rounded-circle bg-secondary #" style="height:1.5em;width:1.5em;">
                </div>
              </a>
            </div>
          <?php endif; ?>
          <?php if($data['colour'] == 'success') : ?>
            <div class="colour-picker-selector rounded-circle d-flex justify-content-center m-3" id="bg-success" style="height:1.75em;width:1.75em;border:.1em solid rgb(56,27,68);">
              <a href="#">
                <div class="colour-picker-icon rounded-circle bg-success #" style="height:1.5em;width:1.5em;">
                </div>
              </a>
            </div>
          <?php else : ?>
            <div class="colour-picker-selector rounded-circle d-flex justify-content-center m-3 border-light" id="bg-success" style="height:1.75em;width:1.75em;border:.1em solid rgb(56,27,68);">
              <a href="#">
                <div class="colour-picker-icon rounded-circle bg-success #" style="height:1.5em;width:1.5em;">
                </div>
              </a>
            </div>
          <?php endif; ?>
          <?php if($data['colour'] == 'danger') : ?>
            <div class="colour-picker-selector rounded-circle d-flex justify-content-center m-3" id="bg-danger" style="height:1.75em;width:1.75em;border:.1em solid rgb(56,27,68);">
              <a href="#">
                <div class="colour-picker-icon rounded-circle bg-danger #" style="height:1.5em;width:1.5em;">
                </div>
              </a>
            </div>
          <?php else : ?>
            <div class="colour-picker-selector rounded-circle d-flex justify-content-center m-3 border-light" id="bg-danger" style="height:1.75em;width:1.75em;border:.1em solid rgb(56,27,68);">
              <a href="#">
                <div class="colour-picker-icon rounded-circle bg-danger #" style="height:1.5em;width:1.5em;">
                </div>
              </a>
            </div>
          <?php endif; ?>
        </div>
        <div class="form-group d-flex justify-content-center">
          <?php if($data['colour'] == 'warning') : ?>
            <div class="colour-picker-selector rounded-circle d-flex justify-content-center m-3" id="bg-warning" style="height:1.75em;width:1.75em;border:.1em solid rgb(56,27,68);">
              <a href="#">
                <div class="colour-picker-icon rounded-circle bg-warning #" style="height:1.5em;width:1.5em;">
                </div>
              </a>
            </div>
          <?php else : ?>
            <div class="colour-picker-selector rounded-circle d-flex justify-content-center m-3 border-light" id="bg-warning" style="height:1.75em;width:1.75em;border:.1em solid rgb(56,27,68);">
              <a href="#">
                <div class="colour-picker-icon rounded-circle bg-warning #" style="height:1.5em;width:1.5em;">
                </div>
              </a>
            </div>
          <?php endif; ?>
          <?php if($data['colour'] == 'info') : ?>
            <div class="colour-picker-selector rounded-circle d-flex justify-content-center m-3" id="bg-info" style="height:1.75em;width:1.75em;border:.1em solid rgb(56,27,68);">
              <a href="#">
                <div class="colour-picker-icon rounded-circle bg-info #" style="height:1.5em;width:1.5em;">
                </div>
              </a>
            </div>
          <?php else : ?>
            <div class="colour-picker-selector rounded-circle d-flex justify-content-center m-3 border-light" id="bg-info" style="height:1.75em;width:1.75em;border:.1em solid rgb(56,27,68);">
              <a href="#">
                <div class="colour-picker-icon rounded-circle bg-info #" style="height:1.5em;width:1.5em;">
                </div>
              </a>
            </div>
          <?php endif; ?>
          <?php if($data['colour'] == 'dark') : ?>
            <div class="colour-picker-selector rounded-circle d-flex justify-content-center m-3" id="bg-dark" style="height:1.75em;width:1.75em;border:.1em solid rgb(56,27,68);">
              <a href="#">
                <div class="colour-picker-icon rounded-circle bg-dark #" style="height:1.5em;width:1.5em;">
                </div>
              </a>
            </div>
          <?php else : ?>
            <div class="colour-picker-selector rounded-circle d-flex justify-content-center m-3 border-light" id="bg-dark" style="height:1.75em;width:1.75em;border:.1em solid rgb(56,27,68);">
              <a href="#">
                <div class="colour-picker-icon rounded-circle bg-dark #" style="height:1.5em;width:1.5em;">
                </div>
              </a>
            </div>
          <?php endif; ?>
        </div>
        <textarea name="colour" class="d-none" id="colourPicker"><?php echo $data['colour']; ?></textarea>
      </div>
      <div class="form-group">
        <label for="name" class="cabin-font">Name: <sup>*</sup></label>
        <input type="text" name="name" class="form-control form-control-lg <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['name']; ?>" style="font-size:1em;">
        <span class="invalid-feedback"><?php echo $data['name_err']; ?></span>
      </div>
      <div class="form-group">
        <label for="last_name" class="cabin-font">Last Name: <sup>*</sup></label>
        <input type="text" name="last_name" class="form-control form-control-lg <?php echo (!empty($data['last_name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['last_name']; ?>" style="font-size:1em;">
        <span class="invalid-feedback"><?php echo $data['last_name_err']; ?></span>
      </div>
      <div class="form-group">
        <label for="about" class="cabin-font">About:</label>
        <textarea name="about" class="form-control form-control-lg" style="font-size:1em;"><?php echo $data['about']; ?></textarea>
      </div>
      <div class="form-group">
        <label for="location" class="cabin-font">Location:</label>
        <input type="text" name="location" class="form-control form-control-lg" value="<?php echo $data['location']; ?>" style="font-size:1em;">
      </div>
      <div class="row mx-1 pull-right">
        <input type="submit" class="btn btn-success mr-3 cabin-font" value="Save">
        <a class="btn btn-light cabin-font" href="<?php echo URLROOT; ?>/users/profile/<?php echo $_SESSION['user_id']; ?>">Cancel</a>
      </div>
    </form>
  </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
