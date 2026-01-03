<!-- metadata -->
<?php $pageTitle = "Whispers"; ?>
<?php $pageDesc = "Whispers Description"; ?>
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
  <!-- new whisper list -->
  <div class="modal fade" id="newWhisperModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog cabin-font" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Send New Whisper</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <?php if(count($data['mates']) > 1) : ?>
            <p>Please select a Hubmate you wish to send a Whisper to</p>
            <?php foreach($data['mates'] as $mate) : ?>
              <?php if($mate->id != $_SESSION['user_id']) : ?>
                <div class="d-flex justify-content-between card border-white">
                  <div class="row">
                    <h6>
                      <?php if($mate->img) : ?>
                        <div class="rounded-circle border ml-3 border-<?php echo $mate->colour; ?>" style="height:2.6em;width:2.6em;overflow:hidden;border-width:.1em !important;background-image:url(<?php echo $mate->img; ?>);background-size:3.8em;background-position:50% 50%;background-repeat:no-repeat;"></div>
                      <?php else : ?>
                        <i class="fa fa-user-circle ml-3 text-<?php echo $mate->colour; ?>" style="font-size:2.6em;"></i>
                      <?php endif; ?>
                    </h6>
                    &nbsp; &nbsp; <p><?php echo $mate->name; ?> <?php echo $mate->last_name; ?></p>
                  </div>
                  <?php if($mate->id > $_SESSION['user_id']) : ?>
                    <a href="<?php echo URLROOT; ?>/messages/show/<?php echo $_SESSION['user_id']; ?><?php echo $mate->id ?>" class="stretched-link"><i class="fa fa-plus text-info pull-right"></i></a>
                  <?php else : ?>
                    <a href="<?php echo URLROOT; ?>/messages/show/<?php echo $mate->id ?><?php echo $_SESSION['user_id']; ?>" class="stretched-link"><i class="fa fa-plus text-info pull-right"></i></a>
                  <?php endif; ?>
                </div>
                <hr>
              <?php endif; ?>
            <?php endforeach; ?>
          <?php else : ?>
            <p class="text-muted">Your Hubmates will appear here</p>
          <?php endif; ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light cabin-font" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
  <?php if($data['removed_from_hub']) : ?>
    <a data-toggle="modal" data-target="#removedFromHubModal" data-keyboard="false" data-backdrop="static" id="removedModalToggle"></a>
  <?php endif; ?>
  <div class="row mb-3">
    <div class="col-md-6">
      <h1 class="cabin-font text-hub-dark-purple">Whispers</h1>
    </div>
    <div class="col-md-6">
      <a class="btn pull-right cabin-font" data-toggle="modal" data-target="#newWhisperModal">
        <h4><i class="fa fa-plus-square text-linkedin"></i></h4>
      </a>
    </div>
  </div>
  <span class="cabin-font"><?php flash('success_message'); ?></span>
  <?php if($data['messages']) : ?>
    <?php foreach($data['messages'] as $message) : ?>
      <?php if($message->to_id == $_SESSION['user_id'] && $message->seen == 0) : ?>
        <div data-aos="fade-up" class="card card-body mb-3 cabin-font border-info" >
      <?php else : ?>
        <div data-aos="fade-up" class="card card-body mb-3 cabin-font">
      <?php endif; ?>
        <?php if($message->to_id == $_SESSION['user_id']) : ?>
          <div class="d-flex">
            <div class="align-itmes-start">
              <h5 class="card-title">
                <?php if($message->profileImg) : ?>
                  <div class="rounded-circle border ml-3 border-<?php echo $message->colour; ?>" style="height:2.6em;width:2.6em;overflow:hidden;border-width:.1em !important;background-image:url(<?php echo $message->profileImg; ?>);background-size:3.6em;background-position:50% 50%;background-repeat:no-repeat;"></div>
                <?php else : ?>
                  <i class="fa fa-user-circle ml-3 text-<?php echo $message->colour; ?>" style="font-size:2.6em;"></i>
                <?php endif; ?>
              </h5>
            </div>
            <div class="col">
              <div class="d-flex justify-content-between">
                <h5 class="card-title">
                  <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $message->from_id; ?>" class="text-decoration-none text-hub-dark-purple"><?php echo $message->from_name; ?></a>
                </h5>
                <?php if($message->seen == 0) : ?>
                  <i class="fa fa-circle text-info pull-right"></i>
                <?php endif; ?>
              </div>
              <?php if($message->img) : ?>
                <p class="card-text"><i class="fa fa-image text-muted"></i> &nbsp; Image attached</p>
              <?php else : ?>
                <?php if($message->message == "PSST!!") : ?>
                  <p class="card-text"><strong><?php echo $message->from_name; ?> is trying to get your attention!</strong></p>
                <?php else : ?>
                  <p class="card-text"><?php echo $message->message; ?></p>
                <?php endif; ?>
              <?php endif; ?>
            </div>
          </div>
        <?php else : ?>
          <div class="d-flex">
            <div class="align-itmes-start">
              <h5 class="card-title">
                <?php if($message->profileImg) : ?>
                  <div class="rounded-circle border ml-3 border-<?php echo $message->colour; ?>" style="height:2.6em;width:2.6em;overflow:hidden;border-width:.1em !important;background-image:url(<?php echo $message->profileImg; ?>);background-size:3.6em;background-position:50% 50%;background-repeat:no-repeat;"></div>
                <?php else : ?>
                  <i class="fa fa-user-circle ml-3 text-<?php echo $message->colour; ?>" style="font-size:2.6em;"></i>
                <?php endif; ?>
              </h5>
            </div>
            <div class="col">
              <div class="d-flex justify-content-between">
                <h5 class="card-title">
                  <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $message->to_id; ?>" class="text-decoration-none text-hub-dark-purple"><?php echo $message->to_name; ?></a>
                </h5>
              </div>
              <?php if($message->img) : ?>
                <p class="card-text"><i class="fa fa-reply text-muted"></i> &nbsp; <i class="fa fa-image text-muted"></i> &nbsp; Image attached</p>
              <?php else : ?>
                <?php if($message->message == "PSST!!") : ?>
                  <p class="card-text"><i class="fa fa-reply text-muted"></i> &nbsp; <strong><?php echo $message->message; ?></strong></p>
                <?php else : ?>
                  <p class="card-text"><i class="fa fa-reply text-muted"></i> &nbsp; <?php echo $message->message; ?></p>
                <?php endif; ?>
              <?php endif; ?>
            </div>
          </div>
        <?php endif; ?>
        <div class="p-2 mb-2 text-right">
          <small class="text-muted">
            <?php echo $message->from_name; ?> &nbsp; - &nbsp;
            <?php if(date('Ymd', strtotime(date("Ymd", strtotime(date("Ymd"))) . "-1 day")) <= date('Ymd', strtotime($message->messageCreated))) : ?>
              Today • <?php echo date_format(date_create($message->messageCreated),"H:i"); ?>
            <?php else : ?>
              <?php echo date_format(date_create($message->messageCreated),"d M • H:i"); ?>
            <?php endif; ?>
          </small>
        </div>
        <?php if($message->from_id == $_SESSION['user_id']) : ?>
          <a href="<?php echo URLROOT; ?>/messages/show/<?php echo $message->chat_id ?>" class="stretched-link"><i class="fa fa-plus text-info pull-right"></i></a>
        <?php else : ?>
          <a href="<?php echo URLROOT; ?>/messages/show/<?php echo $message->chat_id ?>" class="stretched-link"><i class="fa fa-plus text-info pull-right"></i></a>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <div class="container">
      <h1 class="text-center text-muted m-5 cabin-font empty-page-icon" style="font-size: 15em;"><i class="fa fa-inbox"></i></h1>
      <h4 class="text-center text-muted m-5 cabin-font">It's quiet in here, none of your Hubmates have whispered to you yet</h4>
    </div>
  <?php endif; ?>
<?php require APPROOT . '/views/inc/footer.php'; ?>
