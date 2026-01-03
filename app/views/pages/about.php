<!-- metadata -->
<?php $pageTitle = "About"; ?>
<?php $pageDesc = "The New. The Fun. TheHub. A whole social network just for you and your Group Chats."; ?>
<?php $pageRobots = "index"; ?>
<?php require APPROOT . '/views/inc/header.php'; ?>
  <a id="back-to-top" href="#" class="btn back-to-top" role="button"><h2><i class="bi bi-arrow-up-circle"></i></h2></a>
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
  <div class="d-flex justify-content-between mb-5">
    <div class="m-5 p-2">
      <h1 class="text-neon text-center neonbines-font about-sm-hello">hello</h1>
      <h1 class="text-neon text-center neonbines-font about-hello">a hello, from us</h1>
    </div>
    <div class="ml-5 pl-5 about-the-header">
      <h2 class="cabin-font text-hub-dark-purple">
        <span class="poppins-font text-hub-grape">
          The New.<br>
          The Fun.<br>
          The<span class="text-lilac">Hub</span>.
        </span>
      </h2>
      <h2 style="font-weight:100 !important;">Let's take you through how it works</h2>
    </div>
  </div>
  <br>
  <div class="my-5">
    <p class="cabin-font"><?php echo $data['intro']; ?></p>
  </div>
  <div class="d-flex my-5 p-5 bg-lilac about-sub-intro">
    <div class="container">
      <p class="cabin-font text-white"><?php echo $data['subIntro']; ?></p>
    </div>
  </div>
  <div class="about-placeholder-div" style="height:20em;"></div>
  <br>
  <div class="d-flex justify-content-between my-5 about-icons-section">
    <div class="d-flex justify-content-start mr-2 about-icons-section-one">
      <div data-aos="fade-right" class="d-flex flex-column justify-content-between">
        <div class="text-center rounded-circle bg-orange-fade about-icon-bg p-1" id="aboutHubsDiv">
          <a class="text-hub-dark-purple about-hubs-icon-hover selected" onclick="aboutHubs()"><h3><i class="bi bi-house"></i></h3></a>
        </div>
        <div class="text-center rounded-circle about-icon-bg p-1" id="aboutHubmatesDiv">
          <a class="text-hub-dark-purple about-hubmates-icon-hover" onclick="aboutHubmates()"><h3><i class="bi bi-people"></i></h3></a>
        </div>
        <div class="text-center rounded-circle about-icon-bg p-1" id="aboutShoutsDiv">
          <a class="text-hub-dark-purple about-shouts-icon-hover" onclick="aboutShouts()"><h3><i class="bi bi-megaphone"></i></h3></a>
        </div>
        <div class="text-center rounded-circle about-icon-bg p-1" id="aboutStarsDiv">
          <a class="text-hub-dark-purple about-stars-icon-hover" onclick="aboutStars()"><h3><i class="bi bi-star"></i></h3></a>
        </div>
        <div class="text-center rounded-circle about-icon-bg p-1" id="aboutWhispersDiv">
          <a class="text-hub-dark-purple about-whispers-icon-hover" onclick="aboutWhispers()"><h3><i class="bi bi-chat-text"></i></h3></a>
        </div>
      </div>
      <div data-aos="fade-up" class="d-flex flex-column">
        <div class="d-flex justify-content-end mr-3 mb-n5" style="z-index: 999;">
          <h5><i class="bi bi-wifi text-white mx-1"></i></h5>
          <h5><i class="bi bi-battery-full text-white mx-1"></i></h5>
        </div>
        <div class="about-imgs ml-3" id="hubsAboutImg" style="display:inline-block;height:30em;width:17em;overflow:hidden;border-radius:1em;background-image:url('<?php echo URLROOT; ?>/public/img/about_hubs.jpg');background-size:32em;background-position:50% 50%;background-repeat:no-repeat;">
        </div>
        <div class="about-imgs ml-3 d-none" id="hubmatesAboutImg" style="display:inline-block;height:30em;width:17em;overflow:hidden;border-radius:1em;background-image:url('<?php echo URLROOT; ?>/public/img/about_hubmates.jpg');background-size:32em;background-position:50% 50%;background-repeat:no-repeat;">
        </div>
        <div class="about-imgs ml-3 d-none" id="shoutsAboutImg" style="display:inline-block;height:30em;width:17em;overflow:hidden;border-radius:1em;background-image:url('<?php echo URLROOT; ?>/public/img/about_shouts.jpg');background-size:32em;background-position:50% 50%;background-repeat:no-repeat;">
        </div>
        <div class="about-imgs ml-3 d-none" id="starsAboutImg" style="display:inline-block;height:30em;width:17em;overflow:hidden;border-radius:1em;background-image:url('<?php echo URLROOT; ?>/public/img/about_stars.jpg');background-size:32em;background-position:50% 50%;background-repeat:no-repeat;">
        </div>
        <div class="about-imgs ml-3 d-none" id="whispersAboutImg" style="display:inline-block;height:30em;width:17em;overflow:hidden;border-radius:1em;background-image:url('<?php echo URLROOT; ?>/public/img/about_whispers.jpg');background-size:32em;background-position:50% 50%;background-repeat:no-repeat;">
        </div>
        <div class="ml-3 mt-n4 align-self-center" style="background-color:#fff;height:.3em;width:8em;border-radius:1em;z-index:999 !important;">
        </div>
      </div>
    </div>
    <div data-aos="fade-up" class="ml-5 mt-5 about-icons-section-two">
      <p class="cabin-font text-hub-dark-purple" id="hubsAboutHeader"><strong><em><?php echo $data['heading1']; ?></em></strong></p>
      <p class="cabin-font" id="hubsAboutDesc"><?php echo $data['description1']; ?></p>
      <p class="cabin-font text-hub-dark-purple d-none" id="hubmatesAboutHeader"><strong><em><?php echo $data['heading2']; ?></em></strong></p>
      <p class="cabin-font d-none" id="hubmatesAboutDesc"><?php echo $data['description2']; ?></p>
      <p class="cabin-font text-hub-dark-purple d-none" id="shoutsAboutHeader"><strong><em><?php echo $data['heading3']; ?></em></strong></p>
      <p class="cabin-font d-none" id="shoutsAboutDesc"><?php echo $data['description3']; ?></p>
      <p class="cabin-font text-hub-dark-purple d-none" id="starsAboutHeader"><strong><em><?php echo $data['heading4']; ?></em></strong></p>
      <p class="cabin-font d-none" id="starsAboutDesc"><?php echo $data['description4']; ?></p>
      <p class="cabin-font text-hub-dark-purple d-none" id="whispersAboutHeader"><strong><em><?php echo $data['heading5']; ?></em></strong></p>
      <p class="cabin-font d-none" id="whispersAboutDesc"><?php echo $data['description5']; ?></p>
    </div>
  </div>
  <br>
  <br>
  <div data-aos="fade-up" class="carousel slide mb-5" id="carouselExampleIndicators" data-interval="10000" data-ride="carousel">
    <ol class="carousel-indicators mb-n5">
      <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <blockquote class="blockquote text-center my-3">
          <p class="mb-0"><em>"TheHub has given me a completely new perspective on social networking sites."</em></p>
          <footer class="blockquote-footer">
            <cite title="Source Title">
              <div class="rounded-circle border ml-1 mt-2 mb-n2 border-success" style="display:inline-block;height:2em;width:2em;overflow:hidden;border-width:.1em !important;background-image:url('<?php echo URLROOT; ?>/public/img/stock_user.jpg');background-size:3em;background-position:50% 50%;background-repeat:no-repeat;"></div> &nbsp;
              User, UK
            </cite>
          </footer>
        </blockquote>
      </div>
      <div class="carousel-item">
        <blockquote class="blockquote text-center my-3">
          <p class="mb-0"><em>"Our group chat was dying out until TheHub came along. It's really brought it back to life and we now communicate with each other here all the time!"</em></p>
          <footer class="blockquote-footer">
            <cite title="Source Title">
              <div class="rounded-circle border ml-1 mt-2 mb-n2 border-warning" style="display:inline-block;height:2em;width:2em;overflow:hidden;border-width:.1em !important;background-image:url('<?php echo URLROOT; ?>/public/img/stock_user_three.jpg');background-size:3em;background-position:50% 50%;background-repeat:no-repeat;"></div> &nbsp;
              User, The Netherlands
            </cite>
          </footer>
        </blockquote>
      </div>
      <div class="carousel-item">
        <blockquote class="blockquote text-center my-3">
          <p class="mb-0"><em>"I have Hubs for each of my friendship groups, a family Hub, and one for my work colleagues, and with them being seperate I really feel able to be myself in each."</em></p>
          <footer class="blockquote-footer">
            <cite title="Source Title">
              <div class="rounded-circle border ml-1 mt-2 mb-n2 border-info" style="display:inline-block;height:2em;width:2em;overflow:hidden;border-width:.1em !important;background-image:url('<?php echo URLROOT; ?>/public/img/stock_user_two.jpg');background-size:3em;background-position:50% 50%;background-repeat:no-repeat;"></div> &nbsp;
              User, Spain
            </cite>
          </footer>
        </blockquote>
      </div>
    </div>
  </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
