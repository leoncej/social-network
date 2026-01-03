<?php require APPROOT . '/views/inc/header.php'; ?>
  <div class="row mb-3">
    <div class="col-md-6">
      <h1>Hubmates</h1>
    </div>
    <div class="col-md-6">
      <a href="<?php echo URLROOT; ?>/users/search" class="btn btn-primary pull-right">
        <i class="fa fa-search"></i> Search Hubmate
      </a>
    </div>
  </div>
  <?php if($data['hub_mates']) : ?>
    <?php foreach($data['hub_mates'] as $mate) : ?>
      <hr>
        <div class="row mb-3">
          <div class="col-md-6">
            <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $mate->id ?>" class="text-decoration-none">
              <?php if($mate->img) : ?>
                <div class="row">
                  <div class="rounded-circle ml-3 border border-<?php echo $mate->colour; ?>" style="height:1.2em;width:1.2em;overflow:hidden;border-width:.2em !important;">
                    <img src="<?php echo $mate->img; ?>" style="max-height:1.4em;">
                  </div>
                  <p class="text-muted"> &nbsp; <?php echo $mate->name . " " . $mate->last_name; ?>
                    <?php if($mate->status == 'online') : ?>
                      &nbsp; <i class="fa fa-home text-success"></i>
                    <?php else : ?>
                      &nbsp; <i class="fa fa-home text-danger"></i>
                    <?php endif; ?>
                  </p>
                 </div>
              <?php else : ?>
                <p class="text-muted">
                  <i class="fa fa-user-circle text-<?php echo $mate->colour; ?>"></i> &nbsp; <?php echo $mate->name . " " . $mate->last_name; ?>
                  <?php if($mate->status == 'online') : ?>
                    &nbsp; <i class="fa fa-home text-success"></i>
                  <?php else : ?>
                    &nbsp; <i class="fa fa-home text-danger"></i>
                  <?php endif; ?>
                </p>
              <?php endif; ?>
            </a>
          </div>
          <div class="col-md-6">
            <?php if($mate->id != $_SESSION['user_id']) : ?>
              <a href="<?php echo URLROOT; ?>/messages/compose/<?php echo $mate->id ?>" class="btn btn-primary pull-right">
                <i class="fa fa-pencil"></i> Send Whisper
              </a>
            <?php endif; ?>
          </div>
        </div>
    <?php endforeach; ?>
  <?php else: ?>
    <div class="container">
      <h1 class="text-center text-muted m-5" style="font-size: 15em;"><i class="fa fa-users"></i></h1>
      <h4 class="text-center text-muted m-5">No Hubmates yet. <a href="<?php echo URLROOT; ?>/users/search">Do you want to search for a Hubmate by their ID?</a></h4>
    </div>
  <?php endif; ?>
<?php require APPROOT . '/views/inc/footer.php'; ?>
