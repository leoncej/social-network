<!-- metadata -->
<?php $pageTitle = "Whispers with " . $data['to_name']; ?>
<?php $pageDesc = "Whisper Chain Description"; ?>
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
  <?php if($data['empty'] == true) : ?>
      <?php if($data['img']) : ?>
        <div class="d-flex justify-content-between cabin-font text-hub-dark-purple mb-2">
          <h1>
            <div class="d-flex justify-content-start">
              <div class="rounded-circle border ml-3 border-<?php echo $data['colour']; ?>" style="height:1.6em;width:1.6em;overflow:hidden;border-width:.1em !important;background-image:url(<?php echo $data['img'] ?>);background-size:2.2em;background-position:50% 50%;background-repeat:no-repeat;"></div>
              &nbsp; &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $data['to_id']; ?>" class="text-decoration-none cabin-font text-hub-dark-purple"><?php echo $data['to_name']; ?></a>
            </div>
          </h1>
          <?php if($data['status'] == 'online') : ?>
            &nbsp; &nbsp; <h4><i class="bi bi-house-fill text-success"></i></h4>
          <?php else : ?>
            &nbsp; &nbsp; <h4><i class="bi bi-house-fill text-danger"></i></h4>
          <?php endif; ?>
        </div>
      <?php else : ?>
        <div class="d-flex justify-content-between cabin-font text-hub-dark-purple mb-2">
          <h1>
            <div class="d-flex justify-content-start">
              <i class="fa fa-user-circle text-<?php echo $data['colour'] ?>"></i> &nbsp; &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $data['to_id']; ?>" class="text-decoration-none cabin-font text-hub-dark-purple"><?php echo $data['to_name']; ?></a>
            </div>
          </h1>
          <?php if($data['status'] == 'online') : ?>
            &nbsp; &nbsp; <h4><i class="bi bi-house-fill text-success"></i></h4>
          <?php else : ?>
            &nbsp; &nbsp; <h4><i class="bi bi-house-fill text-danger"></i></h4>
          <?php endif; ?>
        </div>
      <?php endif; ?>
      <div class="card p-1" style="height:50vh;overflow:hidden;">
      </div>
      <form action="<?php echo URLROOT; ?>/messages/show/<?php echo $data['chat_id']; ?>" method="post" class="mb-3 mt-5">
        <div class="form-group">
          <input type="text" name="to_id" value="<?php echo $data['to_id']; ?>" style="display: none;">
          <input type="text" name="to_name" value="<?php echo $data['to_name']; ?>" style="display: none;">
          <div class="mt-4 d-flex justify-content-start">
            <p class="text-danger mr-1 mt-n3" id="whisperImgCancelBtn" style="visibility:hidden;cursor:pointer;"><a onclick="clearWhisperImg()"><strong><i class="fa fa-times-circle text-danger"></i></strong></a></p>
            <div id="uploadedWhisperImg" class="mb-5 img-holder"></div>
          </div>
          <div class="input-group">
            <input type="text" name="message" class="mt-2 mb-1 curve-input form-control form-control-lg <?php echo (!empty($data['message_err'])) ? 'is-invalid' : ''; ?>" placeholder="Whisper..." style="font-size:1em;">
            <div class="input-group-addon pl-3">
              <button type="submit" name="whisperBtn" class="btn btn-primary px-3 mt-2">
                  <i class="fa fa-paper-plane"></i>
              </button>
            </div>
            <span class="invalid-feedback"><?php echo $data['message_err']; ?></span>
          </div>
          <div class="d-flex justify-content-start px-3 mt-3">
            <label for="uploadPhoto" class="text-secondary" style="cursor:pointer;"><h3><i class="bi bi-camera"></i></h3></label>
            <input type="file" name="whisperImg" id="uploadPhoto" style="opacity:0;position:absolute;z-index:-1;">
            <textarea name="whisper_b64_img" class="d-none" id="whisperB64Img"></textarea>
            <div class="mt-n2">
              <form action="<?php echo URLROOT; ?>/messages/show/<?php echo reset($data['messages'])->chat_id; ?>" method="post">
                <button type="submit" name="pingBtn" class="btn" data-toggle="tooltip" data-placement="bottom" title="Get <?php echo $data['to_name']; ?>'s attention">
                  <h3><i class="bi bi-exclamation-octagon text-secondary px-3" style="font-size:.9em;"></i></h3>
                </button>
              </form>
            </div>
          </div>
        </div>
      </form>
  <?php else : ?>
    <?php if(reset($data['messages'])->to_name == $_SESSION['user_name']) : ?>
      <?php if($data['img']) : ?>
        <div class="d-flex justify-content-between cabin-font text-hub-dark-purple mb-2">
          <h1>
            <div class="d-flex justify-content-start">
              <div class="rounded-circle border ml-3 border-<?php echo $data['colour']; ?>" style="height:1.6em;width:1.6em;overflow:hidden;border-width:.1em !important;background-image:url(<?php echo $data['img'] ?>);background-size:2.2em;background-position:50% 50%;background-repeat:no-repeat;"></div>
              &nbsp; &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo reset($data['messages'])->from_id; ?>" class="text-decoration-none cabin-font text-hub-dark-purple"><?php echo reset($data['messages'])->from_name; ?></a>
            </div>
          </h1>
          <?php if($data['status'] == 'online') : ?>
            &nbsp; &nbsp; <h4><i class="bi bi-house-fill text-success"></i></h4>
          <?php else : ?>
            &nbsp; &nbsp; <h4><i class="bi bi-house-fill text-danger"></i></h4>
          <?php endif; ?>
        </div>
      <?php else : ?>
        <div class="d-flex justify-content-between cabin-font text-hub-dark-purple mb-2">
          <h1>
            <div class="d-flex justify-content-start">
              <i class="fa fa-user-circle text-<?php echo $data['colour'] ?>"></i> &nbsp; &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo reset($data['messages'])->from_id; ?>" class="text-decoration-none cabin-font text-hub-dark-purple"><?php echo reset($data['messages'])->from_name; ?></a>
            </div>
          </h1>
          <?php if($data['status'] == 'online') : ?>
            &nbsp; &nbsp; <h4><i class="bi bi-house-fill text-success"></i></h4>
          <?php else : ?>
            &nbsp; &nbsp; <h4><i class="bi bi-house-fill text-danger"></i></h4>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    <?php else : ?>
      <?php if($data['img']) : ?>
        <div class="d-flex justify-content-between cabin-font text-hub-dark-purple mb-2">
          <h1>
            <div class="d-flex justify-content-start">
              <div class="rounded-circle border ml-3 border-<?php echo $data['colour']; ?>" style="height:1.6em;width:1.6em;overflow:hidden;border-width:.1em !important;background-image:url(<?php echo $data['img'] ?>);background-size:2.2em;background-position:50% 50%;background-repeat:no-repeat;"></div>
              &nbsp; &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo reset($data['messages'])->to_id; ?>" class="text-decoration-none cabin-font text-hub-dark-purple"><?php echo reset($data['messages'])->to_name; ?></a>
            </div>
          </h1>
          <?php if($data['status'] == 'online') : ?>
            &nbsp; &nbsp; <h4><i class="bi bi-house-fill text-success"></i></h4>
          <?php else : ?>
            &nbsp; &nbsp; <h4><i class="bi bi-house-fill text-danger"></i></h4>
          <?php endif; ?>
        </div>
      <?php else : ?>
        <div class="d-flex justify-content-between cabin-font text-hub-dark-purple mb-2">
          <h1>
            <div class="d-flex justify-content-start">
              <i class="fa fa-user-circle text-<?php echo $data['colour'] ?>"></i> &nbsp; &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo reset($data['messages'])->to_id; ?>" class="text-decoration-none cabin-font text-hub-dark-purple"><?php echo reset($data['messages'])->to_name; ?></a>
            </div>
          </h1>
          <?php if($data['status'] == 'online') : ?>
            &nbsp; &nbsp; <h4><i class="bi bi-house-fill text-success"></i></h4>
          <?php else : ?>
            &nbsp; &nbsp; <h4><i class="bi bi-house-fill text-danger"></i></h4>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    <?php endif; ?>
    <div id="messageContainer" class="card p-1" style="height:55vh;overflow-y:auto;overflow-x:hidden;">
      <?php foreach($data['messages'] as $message) : ?>
        <?php if($message->from_id == $_SESSION['user_id']) : ?>
          <div class="row mb-4">
            <div class="col-md-6">
              <!-- placeholder for layout -->
            </div>
            <div class="col-md-6">
              <?php if($message->img) : ?>
                <div class="mb-1" style="max-height:12em;max-width:12em;">
                  <img src="<?php echo $message->img; ?>" style="max-height:12em;border-radius:.25rem;">
                </div>
              <?php endif; ?>
              <?php if($message->message) : ?>
                <?php if($message->message == "PSST!!") : ?>
                  <div class="text-center shake">
                    <h4 class="py-2 px-4 mb-1"><?php echo $message->message; ?></h4>
                  </div>
                <?php else : ?>
                  <div class="bg-light" style="border-radius: 2em;">
                    <p class="py-2 px-4 mb-1"><?php echo $message->message; ?></p>
                  </div>
                <?php endif; ?>
              <?php endif; ?>
              <?php if($message->latest) : ?>
                <div class="pull-right mx-3">
                  <?php if($message->seen) : ?>
                    <i class="bi bi-check-all text-primary"></i> &nbsp;
                    <small class="text-muted cabin-font">
                      Seen on
                      <?php if(date('Ymd', strtotime(date("Ymd", strtotime(date("Ymd"))) . "-1 day")) <= date('Ymd', strtotime($message->messageSeen))) : ?>
                        Today • <?php echo date_format(date_create($message->messageSeen),"H:i"); ?>
                      <?php else : ?>
                        <?php echo date_format(date_create($message->messageSeen),"d M • H:i"); ?>
                      <?php endif; ?>
                    </small>
                  <?php else : ?>
                    <i class="bi bi-check text-muted"></i> &nbsp;
                    <small class="text-muted cabin-font mb-n5">
                      Delivered on
                      <?php if(date('Ymd', strtotime(date("Ymd", strtotime(date("Ymd"))) . "-1 day")) <= date('Ymd', strtotime($message->messageCreated))) : ?>
                        Today • <?php echo date_format(date_create($message->messageCreated),"H:i"); ?>
                      <?php else : ?>
                        <?php echo date_format(date_create($message->messageCreated),"d M • H:i"); ?>
                      <?php endif; ?>
                    </small>
                  <?php endif; ?>
                </div>
              <?php endif; ?>
            </div>
          </div>
        <?php else : ?>
          <div class="row mb-4">
            <div class="col-md-6">
              <?php if($message->img) : ?>
                <div class="mb-1" style="max-height:12em;max-width:12em;">
                  <img src="<?php echo $message->img; ?>" style="max-height:12em;border-radius:.25rem;">
                </div>
              <?php endif; ?>
              <?php if($message->message) : ?>
                <?php if($message->message == "PSST!!") : ?>
                  <div class="text-center shake">
                    <h4 class="py-2 px-4 mb-1"><?php echo $message->message; ?></h4>
                  </div>
                <?php else : ?>
                  <div class="bg-info" style="border-radius: 2em;">
                    <p class="text-white py-2 px-4 mb-1"><?php echo $message->message; ?></p>
                  </div>
                <?php endif; ?>
              <?php endif; ?>
              <div class="pull-right mb-3">
                <small class="text-muted cabin-font">
                  <?php echo $message->from_name; ?> -
                  <?php if(date('Ymd', strtotime(date("Ymd", strtotime(date("Ymd"))) . "-1 day")) <= date('Ymd', strtotime($message->messageCreated))) : ?>
                    Today • <?php echo date_format(date_create($message->messageCreated),"H:i"); ?>
                  <?php else : ?>
                    <?php echo date_format(date_create($message->messageCreated),"d M • H:i"); ?>
                  <?php endif; ?>
                </small>
              </div>
            </div>
            <div class="col-md-6">
              <!-- placeholder for layout -->
            </div>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
    <form autocomplete="off" action="<?php echo URLROOT; ?>/messages/show/<?php echo reset($data['messages'])->chat_id; ?>" method="post" class="mb-3">
      <div class="form-group">
        <?php if(reset($data['messages'])->from_id == $_SESSION['user_id']) : ?>
          <input type="text" name="to_id" value="<?php echo reset($data['messages'])->to_id; ?>" style="display: none;">
          <input type="text" name="to_name" value="<?php echo reset($data['messages'])->to_name; ?>" style="display: none;">
        <?php else : ?>
          <input type="text" name="to_id" value="<?php echo reset($data['messages'])->from_id; ?>" style="display: none;">
          <input type="text" name="to_name" value="<?php echo reset($data['messages'])->from_name; ?>" style="display: none;">
        <?php endif; ?>
        <div class="mt-3 d-flex justify-content-start">
          <p class="text-danger mr-1 mt-n3" id="whisperImgCancelBtn" style="visibility:hidden;cursor:pointer;"><a onclick="clearWhisperImg()"><strong><i class="fa fa-times-circle text-danger"></i></strong></a></p>
          <div id="uploadedWhisperImg" class="mb-5 img-holder"></div>
        </div>
        <div class="input-group">
          <input type="text" name="message" class="mt-2 mb-1 curve-input form-control form-control-lg <?php echo (!empty($data['message_err'])) ? 'is-invalid' : ''; ?>" placeholder="Whisper..." style="font-size:1em;">
          <div class="input-group-addon pl-3">
            <button type="submit" name="whisperBtn" class="btn btn-primary px-3 mt-2">
                <i class="fa fa-paper-plane"></i>
            </button>
          </div>
          <span class="invalid-feedback"><?php echo $data['message_err']; ?></span>
        </div>
        <div class="d-flex justify-content-start px-3 mt-3">
          <label for="uploadPhoto" class="text-secondary" style="cursor:pointer;"><h3><i class="bi bi-camera"></i></h3></label>
          <input type="file" name="whisperImg" id="uploadPhoto" style="opacity:0;position:absolute;z-index:-1;">
          <textarea name="whisper_b64_img" class="d-none" id="whisperB64Img"></textarea>
          <div class="mt-n2">
            <form action="<?php echo URLROOT; ?>/messages/show/<?php echo reset($data['messages'])->chat_id; ?>" method="post">
              <?php if(reset($data['messages'])->from_id == $_SESSION['user_id']) : ?>
                <button type="submit" name="pingBtn" class="btn" data-toggle="tooltip" data-placement="bottom" title="Get <?php echo reset($data['messages'])->to_name; ?>'s attention">
              <?php else : ?>
                <button type="submit" name="pingBtn" class="btn" data-toggle="tooltip" data-placement="bottom" title="Get <?php echo reset($data['messages'])->from_name; ?>'s attention">
              <?php endif; ?>
                <h3><i class="bi bi-exclamation-octagon text-secondary px-3" style="font-size:.9em;"></i></h3>
              </button>
            </form>
          </div>
        </div>
      </div>
    </form>
  <?php endif; ?>
<?php require APPROOT . '/views/inc/footer.php'; ?>
