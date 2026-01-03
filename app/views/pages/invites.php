<!-- metadata -->
<?php $pageTitle = "Invites"; ?>
<?php $pageDesc = "Invites Description"; ?>
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
  <h1 class="my-3 cabin-font text-hub-dark-purple">Invites</h1>
  <?php if($data['invites']) : ?>
    <?php if($data['hubLimitReached']) : ?>
      <small class="cabin-font">You are unable to accept any Hub invites as you already are in 5 (which is the limit.) To join another Hub, you will have to leave one of the Hubs you are in. You can do this, as well as manage your Hubs, in your <a href="<?php echo URLROOT; ?>/pages/settings" class="text-decoration-none">Settings</a></small>
      <?php foreach($data['invites'] as $invite) : ?>
        <div class="d-flex justify-content-between my-3">
          <?php if($invite->deletedAccount) : ?>
            <p><i class="fa fa-user-circle text-muted" style="font-size:1.4em;"></i> &nbsp; <?php echo $invite->fromName; ?> invited you to join <?php echo $invite->hubName; ?>Hub</p>
          <?php else : ?>
            <?php if($invite->img) : ?>
              <div class="row">
                <div class="rounded-circle ml-3 border border-<?php echo $invite->colour; ?>" style="height:1.4em;width:1.4em;overflow:hidden;border-width:.1em !important;background-image:url(<?php echo $invite->img; ?>);background-size:2em;background-position:50% 50%;background-repeat:no-repeat;"></div>
                <p> &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $invite->fromId; ?>"><?php echo $invite->fromName; ?></a> invited you to join <?php echo $invite->hubName; ?>Hub</p>
               </div>
            <?php else : ?>
              <p><i class="fa fa-user-circle text-<?php echo $invite->colour; ?>"></i> &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $invite->fromId; ?>"><?php echo $invite->fromName; ?></a> invited you to join <?php echo $invite->hubName; ?>Hub</p>
            <?php endif; ?>
          <?php endif; ?>
          <div class="row">
            <form action="<?php echo URLROOT; ?>/pages/invites" method="post" class="mx-4">
              <input type="submit" value="Accept" name="acceptBtn" class="btn btn-success" disabled>
              <div class="d-none">
                <input type="text" name="inviteId" value="<?php echo $invite->inviteId; ?>">
                <input type="text" name="hubId" value="<?php echo $invite->hubId; ?>">
                <input type="text" name="hubName" value="<?php echo $invite->hubName; ?>">
              </div>
            </form>
            <form action="<?php echo URLROOT; ?>/pages/invites" method="post">
              <input type="submit" value="Reject" name="rejectBtn" class="btn btn-danger">
              <div class="d-none">
                <input type="text" name="inviteId" value="<?php echo $invite->inviteId; ?>">
                <input type="text" name="hubId" value="<?php echo $invite->hubId; ?>">
                <input type="text" name="hubName" value="<?php echo $invite->hubName; ?>">
              </div>
            </form>
          </div>
        </div>
        <div class="bg-light p-2 mb-5 text-right">
          <small>
            <?php if(date('Ymd', strtotime(date("Ymd", strtotime(date("Ymd"))) . "-1 day")) <= date('Ymd', strtotime($invite->inviteCreated))) : ?>
              Today • <?php echo date_format(date_create($invite->inviteCreated),"H:i"); ?>
            <?php else : ?>
              <?php echo date_format(date_create($invite->inviteCreated),"d M Y • H:i"); ?>
            <?php endif; ?>
          </small>
        </div>
      <?php endforeach; ?>
    <?php else : ?>
      <?php foreach($data['invites'] as $invite) : ?>
        <div class="d-flex justify-content-between my-3 cabin-font">
          <?php if($invite->deletedAccount) : ?>
            <p><i class="fa fa-user-circle text-muted" style="font-size:1.4em;"></i> &nbsp; <?php echo $invite->fromName; ?> invited you to join <?php echo $invite->hubName; ?>Hub</p>
          <?php else : ?>
            <?php if($invite->img) : ?>
              <div class="row">
                <div class="rounded-circle ml-3 border border-<?php echo $invite->colour; ?>" style="height:1.4em;width:1.4em;overflow:hidden;border-width:.1em !important;background-image:url(<?php echo $invite->img; ?>);background-size:2em;background-position:50% 50%;background-repeat:no-repeat;"></div>
                <p> &nbsp; &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $invite->fromId; ?>"><?php echo $invite->fromName; ?></a> invited you to join <?php echo $invite->hubName; ?>Hub</p>
               </div>
            <?php else : ?>
              <p><i class="fa fa-user-circle text-<?php echo $invite->colour; ?>" style="font-size:1.4em;"></i> &nbsp; &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $invite->fromId; ?>"><?php echo $invite->fromName; ?></a> invited you to join <?php echo $invite->hubName; ?>Hub</p>
            <?php endif; ?>
          <?php endif; ?>
          <div class="d-flex justify-content-between">
            <form action="<?php echo URLROOT; ?>/pages/invites" method="post" class="mx-4">
              <input type="submit" value="Accept" name="acceptBtn" class="btn btn-success acceptBtnLg">
              <!-- <input type="submit" value="&#10004;" name="acceptBtn" class="btn btn-success acceptBtnSm d-none"> -->
              <button type="submit" name="acceptBtn" class="btn btn-success acceptBtnSm d-none">
                <i class="fa fa-check"></i>
              </button>
              <div class="d-none">
                <input type="text" name="inviteId" value="<?php echo $invite->inviteId; ?>">
                <input type="text" name="hubId" value="<?php echo $invite->hubId; ?>">
                <input type="text" name="hubName" value="<?php echo $invite->hubName; ?>">
              </div>
            </form>
            <form action="<?php echo URLROOT; ?>/pages/invites" method="post">
              <input type="submit" value="Reject" name="rejectBtn" class="btn btn-danger rejectBtnLg">
              <!-- <input type="submit" value="&#10539;" name="rejectBtn" class="btn btn-danger rejectBtnSm d-none"> -->
              <button type="submit" name="rejectBtn" class="btn btn-danger rejectBtnSm d-none">
                <i class="fa fa-times"></i>
              </button>
              <div class="d-none">
                <input type="text" name="inviteId" value="<?php echo $invite->inviteId; ?>">
                <input type="text" name="hubId" value="<?php echo $invite->hubId; ?>">
                <input type="text" name="hubName" value="<?php echo $invite->hubName; ?>">
              </div>
            </form>
          </div>
        </div>
        <div class="bg-light p-2 mb-5 text-right cabin-font">
          <small>
            <?php if(date('Ymd', strtotime(date("Ymd", strtotime(date("Ymd"))) . "-1 day")) <= date('Ymd', strtotime($invite->inviteCreated))) : ?>
              Today • <?php echo date_format(date_create($invite->inviteCreated),"H:i"); ?>
            <?php else : ?>
              <?php echo date_format(date_create($invite->inviteCreated),"d M Y • H:i"); ?>
            <?php endif; ?>
          </small>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  <?php else : ?>
    <div class="container">
      <h1 class="text-center text-muted m-5 cabin-font empty-page-icon" style="font-size: 15em;"><i class="fa fa-angellist"></i></h1>
      <h4 class="text-center text-muted m-5 cabin-font">No new invites to make you aware of <?php echo $_SESSION['user_name']; ?></h4>
    </div>
  <?php endif; ?>
<?php require APPROOT . '/views/inc/footer.php'; ?>
