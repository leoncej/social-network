<?php require APPROOT . '/views/inc/header.php'; ?>
  <div class="jumbotron jumbotron-fluid mt-5">
    <div class="container">
      <h1 class="display-3"><sup>The</sup>Hub</h1>
      <p class="lead"><?php echo $data['description']; ?></p>
      <div class="row mt-5">
        <div class="col">
          <a href="<?php echo URLROOT; ?>/users/login" class="btn btn-success btn-block">Login</a>
        </div>
        <div class="col">
          <a href="<?php echo URLROOT; ?>/users/register" class="btn btn-light btn-block">No account? Sign up</a>
        </div>
      </div>
    </div>
  </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
