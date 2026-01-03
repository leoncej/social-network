<?php require APPROOT . '/views/inc/header.php'; ?>
  <div class="card card-body bg-light mt-5">
    <h2>Whisper</h2>
    <form action="<?php echo URLROOT; ?>/messages/compose/<?php echo $data['to_id']; ?>" method="post">
      <div class="form-group">
        <label for="to_name">To: <sup>*</sup></label>
        <input type="text" name="to_name" class="form-control form-control-lg test-muted <?php echo (!empty($data['to_name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['to_name']; ?>" readonly>
        <span class="invalid-feedback"><?php echo $data['to_name_err']; ?></span>
      </div>
      <div class="d-flex justify-content-center">
        <div id="uploadedWhisperImg" class="my-5" style="display:none;max-height:12em;max-width:12em;"></div>
      </div>
      <div class="form-group">
        <label for="message">Message:</label>
        <textarea name="message" class="form-control form-control-lg <?php echo (!empty($data['message_err'])) ? 'is-invalid' : ''; ?>"><?php echo $data['message']; ?></textarea>
        <span class="invalid-feedback"><?php echo $data['message_err']; ?></span>
      </div>
      <div class="row mb-3">
        <div class="col-md-6">
          <div class="row ml-3">
            <label for="uploadPhoto" class="text-secondary" style="cursor:pointer;"><h3><i class="fa fa-image"></i></h3></label>
            <p class="ml-3 pt-1 text-danger" id="whisperImgCancelBtn" style="visibility:hidden;cursor:pointer;"><a onclick="clearWhisperImg()"><strong>Remove</strong></a></p>
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
