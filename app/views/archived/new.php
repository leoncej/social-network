<?php require APPROOT . '/views/inc/header.php'; ?>
  <div class="card card-body bg-light mt-5">
    <h2 class="cabin-font text-hub-dark-purple">Whisper</h2>
    <form action="<?php echo URLROOT; ?>/messages/new" method="post">
      <div class="form-group">
        <label for="to_name" class="cabin-font">To: <sup>*</sup></label>
        <div class="dropdown cabin-font">
          <input name="to" value="Choose Hubmate" class="btn btn-secondary dropdown-toggle <?php echo (!empty($data['to_name_err'])) ? 'is-invalid' : ''; ?>" type="button" id="newMessageBtn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <?php if(count($data['mates']) > 1) : ?>
              <?php foreach($data['mates'] as $mate) : ?>
                <?php if($mate->id != $_SESSION['user_id']) : ?>
                  <a class="dropdown-item" href="#"><?php echo $mate->name . " " . $mate->last_name; ?> &nbsp; <span class="text-muted">(<?php echo $mate->id; ?>)</span></a>
                <?php endif; ?>
              <?php endforeach; ?>
            <?php else : ?>
              <a class="dropdown-item disabled" aria-disabled="true">Hubmates will appear here</a>
            <?php endif; ?>
          </div>
        </div>
        <span class="invalid-feedback"><?php echo $data['to_name_err']; ?></span>
      </div>
      <div class="mt-4 d-flex justify-content-start">
        <p class="text-danger mr-1 mt-n3" id="whisperImgCancelBtn" style="visibility:hidden;cursor:pointer;"><a onclick="clearWhisperImg()"><strong><i class="fa fa-times-circle text-danger"></i></strong></a></p>
        <div id="uploadedWhisperImg" class="mb-5 img-holder"></div>
      </div>
      <div class="form-group">
        <label for="message" class="cabin-font">Message:</label>
        <textarea name="message" class="form-control form-control-lg <?php echo (!empty($data['message_err'])) ? 'is-invalid' : ''; ?>" style="font-size:1em;"><?php echo $data['message']; ?></textarea>
        <span class="invalid-feedback"><?php echo $data['message_err']; ?></span>
        <textarea name="message_two" class="d-none" id="toName"></textarea>
      </div>
      <div class="row mb-3">
        <div class="col-md-6">
          <div class="row ml-3">
            <label for="uploadPhoto" class="text-secondary" style="cursor:pointer;"><h3><i class="fa fa-camera"></i></h3></label>
          </div>
          <input type="file" name="whisperImg" id="uploadPhoto" style="opacity:0;position:absolute;z-index:-1;">
          <textarea name="whisper_b64_img" class="d-none" id="whisperB64Img"></textarea>
        </div>
        <div class="col-md-6">
          <input type="submit" class="btn btn-success pull-right" value="Send">
        </div>
      </div>
    </form>
  </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
