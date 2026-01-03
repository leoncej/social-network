<?php require APPROOT . '/views/inc/header.php'; ?>
  <div class="card card-body bg-light mt-5">
    <h2>Edit Post</h2>
    <form action="<?php echo URLROOT; ?>/posts/edit/<?php echo $data['id']; ?>" method="post">
      <?php if($data['img']) : ?>
        <div class="d-flex justify-content-center">
          <div id="uploadedShoutImg" class="my-5" style="max-height:12em;max-width:12em;">
            <img src="<?php echo $data['img']; ?>" style="max-height:12em;">
          </div>
        </div>
      <?php else : ?>
        <div class="d-flex justify-content-center">
          <div id="uploadedShoutImg" class="my-5" style="display:none;max-height:12em;max-width:12em;"></div>
        </div>
      <?php endif; ?>
      <div class="form-group">
        <label for="title">Title:</label>
        <input type="text" name="title" class="form-control form-control-lg <?php echo (!empty($data['title_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['title']; ?>">
        <span class="invalid-feedback"><?php echo $data['title_err']; ?></span>
      </div>
      <div class="form-group">
        <label for="body">Body:</label>
        <textarea name="body" class="form-control form-control-lg <?php echo (!empty($data['body_err'])) ? 'is-invalid' : ''; ?>"><?php echo $data['body']; ?></textarea>
        <span class="invalid-feedback"><?php echo $data['body_err']; ?></span>
      </div>
      <div class="row mb-3">
        <div class="col-md-6">
          <div class="row ml-3">
            <label for="uploadPhoto" class="text-secondary" style="cursor:pointer;"><h3><i class="fa fa-image"></i></h3></label>
            <?php if($data['img']) : ?>
              <p class="ml-3 pt-1 text-danger" id="shoutImgCancelBtn" style="cursor:pointer;"><a onclick="clearShoutImg()"><strong>Remove</strong></a></p>
            <?php else : ?>
              <p class="ml-3 pt-1 text-danger" id="shoutImgCancelBtn" style="visibility:hidden;cursor:pointer;"><a onclick="clearShoutImg()"><strong>Remove</strong></a></p>
            <?php endif; ?>
          </div>
          <input type="file" name="shoutImg" id="uploadPhoto" style="opacity:0;position:absolute;z-index:-1;">
          <textarea name="shout_b64_img" class="d-none" id="shoutB64Img"><?php echo $data['img']; ?></textarea>
        </div>
        <div class="col-md-6">
          <input type="submit" class="btn btn-success pull-right" value="Update">
        </div>
      </div>
    </form>
  </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
