<!-- metadata -->
<?php $pageTitle = "Hubmates"; ?>
<?php $pageDesc = "Search Description"; ?>
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
  <h1 class="cabin-font text-hub-dark-purple">Search for Hubmates</h1>
  <?php if(isset($data['welcome_msg'])) : ?>
    <p><?php echo $data['welcome_msg']; ?></p>
  <?php else : ?>
    <p class="cabin-font mb-3">To search for a Hubmate, simply enter their Hubmate ID below</p>
  <?php endif; ?>
  <form action="<?php echo URLROOT; ?>/users/search" method="post" class="my-5">
    <div class="form-group">
      <div class="input-group">
        <input type="text" name="search" class="curve-input form-control form-control-lg mb-1 <?php echo (!empty($data['search_err'])) ? 'is-invalid' : ''; ?>" placeholder="Enter Hubmate ID..." style="font-size:1em;">
        <div class="input-group-addon pl-3">
          <button type="submit" name="searchBtn" class="btn btn-primary px-3">
              <i class="fa fa-search"></i>
          </button>
        </div>
        <span class="invalid-feedback"><?php echo $data['search_err']; ?></span>
      </div>
    </div>
  </form>
  <?php if(isset($data['user'])) : ?>
    <span class="cabin-font"><?php flash('success_message'); ?></span>
    <div data-aos="zoom-in" class="card card-body mb-3 cabin-font">
      <h5 class="card-title">
        <?php if($data['user']->img) : ?>
          <div class="row">
            <div class="rounded-circle ml-3 border border-<?php echo $data['user']->colour; ?>" style="height:1.2em;width:1.2em;overflow:hidden;border-width:.1em !important;background-image:url(<?php echo $data['user']->img; ?>);background-size:1.9em;background-position:50% 50%;background-repeat:no-repeat;"></div>
            &nbsp; &nbsp; <?php echo $data['user']->name . " " . $data['user']->last_name; ?>
           </div>
        <?php else : ?>
          <i class="fa fa-user-circle text-<?php echo $data['user']->colour; ?>"></i> &nbsp; <?php echo $data['user']->name . " " . $data['user']->last_name; ?>
        <?php endif; ?>
      </h5>
      <p class="card-text"><?php echo $data['user']->about; ?></p>
      <div class="d-flex justify-content-between">
          <div class="col-md-6">
            <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $data['user']->id ?>" class="btn btn-light">Profile</a>
          </div>
        <div class="col-md-6">
          <?php if($data['connect_btn']) : ?>
            <?php if($data['invited']) : ?>
              <form action="<?php echo URLROOT; ?>/users/search" method="post">
                <input type="submit" name="pending" class="btn btn-light pull-right" value="Pending...">
                <input type="text" name="to_id" class="d-none" value="<?php echo $data['user']->id; ?>">
                </a>
              </form>
            <?php else : ?>
              <form action="<?php echo URLROOT; ?>/users/search" method="post">
                <input type="submit" name="invite" class="btn btn-primary pull-right" value="Invite to Hub">
                <input type="text" name="to_id" class="d-none" value="<?php echo $data['user']->id; ?>">
                </a>
              </form>
            <?php endif; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
  <?php endif; ?>
  <?php if($data['mates']) : ?>
    <?php foreach($data['mates'] as $mate) : ?>
      <hr>
      <div class="d-flex justify-content-between mb-3 cabin-font">
        <div class="col-md-6">
            <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $mate->id ?>" class="text-decoration-none">
              <?php if($mate->img) : ?>
                <div class="row">
                  <div class="rounded-circle ml-3 border border-<?php echo $mate->colour; ?>" style="height:1.4em;width:1.4em;overflow:hidden;border-width:.1em !important;background-image:url(<?php echo $mate->img; ?>);background-size:1.9em;background-position:50% 50%;background-repeat:no-repeat;"></div>
                  &nbsp; &nbsp; <p class="text-muted"> &nbsp; <?php echo $mate->name . " " . $mate->last_name; ?>
                  </p>
                 </div>
              <?php else : ?>
                <p class="text-muted">
                  <i class="fa fa-user-circle text-<?php echo $mate->colour; ?>" style="font-size:1.4em;"></i> &nbsp; &nbsp; <?php echo $mate->name . " " . $mate->last_name; ?>
                </p>
              <?php endif; ?>
            </a>
        </div>
        <div class="col-md-6">
          <?php if($mate->id != $_SESSION['user_id']) : ?>
            <?php if($mate->id > $_SESSION['user_id']) : ?>
              <a href="<?php echo URLROOT; ?>/messages/show/<?php echo $_SESSION['user_id']; ?><?php echo $mate->id; ?>" class="btn btn-primary pull-right">
                <i class="fa fa-paper-plane px-1"></i>
              </a>
            <?php else : ?>
              <a href="<?php echo URLROOT; ?>/messages/show/<?php echo $mate->id; ?><?php echo $_SESSION['user_id']; ?>" class="btn btn-primary pull-right">
                <i class="fa fa-paper-plane px-1"></i>
              </a>
            <?php endif; ?>
          <?php endif; ?>
        </div>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <div class="container">
      <h1 class="text-center text-muted m-5 empty-page-icon" style="font-size: 15em;"><i class="fa fa-address-book"></i></h1>
      <h4 class="text-center text-muted m-5">Enter a Hub ID and we'll dive deep into our address book to find the Hubmate you're after</h4>
    </div>
  <?php endif; ?>
<?php require APPROOT . '/views/inc/footer.php'; ?>
