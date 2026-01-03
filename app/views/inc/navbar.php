<header>
  <div class="collapse bg-hub-grape" id="navbarHeader">
    <div class="container">
      <div class="row">
        <div class="col-sm-8 col-md-7 py-4">
          <h4 class="text-white">A hello, from us</h4>
          <p class="text-muted">Welcome to a social hub built for you and only your closest friends & family to share a space to communicate and keep in touch. TheHub welcomes you and always remember to keep the place tidy!</p>
        </div>
        <div class="col-sm-4 offset-md-1 py-4">
          <h4 class="text-white">Go to</h4>
          <ul class="list-unstyled">
            <li><a href="<?php echo URLROOT; ?>" class="text-white text-decoration-none">Home</a></li>
            <li><a href="<?php echo URLROOT; ?>/pages/about" class="text-white text-decoration-none">About</a></li>
            <li><a href="<?php echo URLROOT; ?>/pages/help" class="text-white text-decoration-none">How it works</a></li>
            <li><a href="<?php echo URLROOT; ?>" class="text-white text-decoration-none">Login</a></li>
            <li><a href="<?php echo URLROOT; ?>/users/register" class="text-white text-decoration-none">Register</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <?php if(isset($_SESSION['user_id'])) : ?>
    <div class="navbar fixed-top navbar-dark bg-hub-grape shadow-sm mb-3">
  <?php else : ?>
    <div class="navbar navbar-dark bg-hub-grape shadow-sm mb-3">
  <?php endif; ?>
    <div class="container d-flex justify-content-between">
      <?php if(isset($_SESSION['user_id'])) : ?>
        <div class="row">
          <a href="<?php echo URLROOT; ?>/posts/index" class="navbar-brand d-flex align-items-center" id="back-to-top-hub-btn">
            <img src="<?php echo URLROOT; ?>/public/img/hub_logo.png" style="height:1.7em;">
          </a>
          <form action="<?php echo URLROOT; ?>/inc/navbar" method="post">
            <div class="dropdown">
              <button class="btn text-white cabin-font p-2 mt-1 mx-3 truncate" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['user_hub']; ?>Hub <small class="d-none">(<?php echo $_SESSION['user_hub_id']; ?>)</small></button>
              <div class="dropdown-menu hub-picker" aria-labelledby="dropdownMenuButton">
                <?php if($_SESSION['user_hub_1_id'] != $_SESSION['user_hub_id'] && $_SESSION['user_hub_1_id'] != 0) : ?>
                  <div class="d-flex justify-content-between">
                    <input type="submit" name="requested_hub" class="btn cabin-font text-hub-dark-purple dropdown-item pr-5" value="<?php echo $_SESSION['user_hub_1'] . "Hub"; ?>" onclick="populateHub(<?php echo $_SESSION['user_hub_1_id']; ?>)">
                    <p class="m-0 p-1 ml-4 navbar-notification-icon" style="width:2em;"><i class="fa fa-inbox text-info"></i></p>
                    <p class="m-0 p-1 mr-2 cabin-font text-hub-dark-purple navbar-notification-icon" style="width:2em;"><?php echo $_SESSION['user_hub_1_whispers']; ?></p>
                    <p class="m-0 p-1 navbar-notification-icon" style="width:2em;"><i class="fa fa-bell text-danger"></i></p>
                    <p class="m-0 p-1 cabin-font text-hub-dark-purple navbar-notification-icon" style="width:2em;"><?php echo $_SESSION['user_hub_1_notifications']; ?></p>
                    &nbsp;
                  </div>
                <?php endif; ?>
                <?php if($_SESSION['user_hub_2_id'] != $_SESSION['user_hub_id'] && $_SESSION['user_hub_2_id'] != 0) : ?>
                  <div class="d-flex justify-content-between">
                    <input type="submit" name="requested_hub" class="btn cabin-font text-hub-dark-purple dropdown-item pr-5" value="<?php echo $_SESSION['user_hub_2'] . "Hub"; ?>" onclick="populateHub(<?php echo $_SESSION['user_hub_2_id']; ?>)">
                    <p class="m-0 p-1 ml-4 navbar-notification-icon" style="width:2em;"><i class="fa fa-inbox text-info"></i></p>
                    <p class="m-0 p-1 mr-2 cabin-font text-hub-dark-purple navbar-notification-icon" style="width:2em;"><?php echo $_SESSION['user_hub_2_whispers']; ?></p>
                    <p class="m-0 p-1 navbar-notification-icon" style="width:2em;"><i class="fa fa-bell text-danger"></i></p>
                    <p class="m-0 p-1 cabin-font text-hub-dark-purple navbar-notification-icon" style="width:2em;"><?php echo $_SESSION['user_hub_2_notifications']; ?></p>
                    &nbsp;
                  </div>
                <?php endif; ?>
                <?php if($_SESSION['user_hub_3_id'] != $_SESSION['user_hub_id'] && $_SESSION['user_hub_3_id'] != 0) : ?>
                  <div class="d-flex justify-content-between">
                    <input type="submit" name="requested_hub" class="btn cabin-font text-hub-dark-purple dropdown-item pr-5" value="<?php echo $_SESSION['user_hub_3'] . "Hub"; ?>" onclick="populateHub(<?php echo $_SESSION['user_hub_3_id']; ?>)">
                    <p class="m-0 p-1 ml-4 navbar-notification-icon" style="width:2em;"><i class="fa fa-inbox text-info"></i></p>
                    <p class="m-0 p-1 mr-2 cabin-font text-hub-dark-purple navbar-notification-icon" style="width:2em;"><?php echo $_SESSION['user_hub_3_whispers']; ?></p>
                    <p class="m-0 p-1 navbar-notification-icon" style="width:2em;"><i class="fa fa-bell text-danger"></i></p>
                    <p class="m-0 p-1 cabin-font text-hub-dark-purple navbar-notification-icon" style="width:2em;"><?php echo $_SESSION['user_hub_3_notifications']; ?></p>
                    &nbsp;
                  </div>
                <?php endif; ?>
                <?php if($_SESSION['user_hub_4_id'] != $_SESSION['user_hub_id'] && $_SESSION['user_hub_4_id'] != 0) : ?>
                  <div class="d-flex justify-content-between">
                    <input type="submit" name="requested_hub" class="btn cabin-font text-hub-dark-purple dropdown-item pr-5" value="<?php echo $_SESSION['user_hub_4'] . "Hub"; ?>" onclick="populateHub(<?php echo $_SESSION['user_hub_4_id']; ?>)">
                    <p class="m-0 p-1 ml-4 navbar-notification-icon" style="width:2em;"><i class="fa fa-inbox text-info"></i></p>
                    <p class="m-0 p-1 mr-2 cabin-font text-hub-dark-purple navbar-notification-icon" style="width:2em;"><?php echo $_SESSION['user_hub_4_whispers']; ?></p>
                    <p class="m-0 p-1 navbar-notification-icon" style="width:2em;"><i class="fa fa-bell text-danger"></i></p>
                    <p class="m-0 p-1 cabin-font text-hub-dark-purple navbar-notification-icon" style="width:2em;"><?php echo $_SESSION['user_hub_4_notifications']; ?></p>
                    &nbsp;
                  </div>
                <?php endif; ?>
                <?php if($_SESSION['user_hub_5_id'] != $_SESSION['user_hub_id'] && $_SESSION['user_hub_5_id'] != 0) : ?>
                  <div class="d-flex justify-content-between">
                    <input type="submit" name="requested_hub" class="btn cabin-font text-hub-dark-purple dropdown-item pr-5" value="<?php echo $_SESSION['user_hub_5'] . "Hub"; ?>" onclick="populateHub(<?php echo $_SESSION['user_hub_5_id']; ?>)">
                    <p class="m-0 p-1 ml-4 navbar-notification-icon" style="width:2em;"><i class="fa fa-inbox text-info"></i></p>
                    <p class="m-0 p-1 mr-2 cabin-font text-hub-dark-purple navbar-notification-icon" style="width:2em;"><?php echo $_SESSION['user_hub_5_whispers']; ?></p>
                    <p class="m-0 p-1 navbar-notification-icon" style="width:2em;"><i class="fa fa-bell text-danger"></i></p>
                    <p class="m-0 p-1 cabin-font text-hub-dark-purple navbar-notification-icon" style="width:2em;"><?php echo $_SESSION['user_hub_5_notifications']; ?></p>
                    &nbsp;
                  </div>
                <?php endif; ?>
                <textarea name="requested_hub_id" class="d-none" id="requestedHubId"></textarea>
                <?php if($_SESSION['user_hub_2_id'] == 0 && $_SESSION['user_hub_3_id'] == 0 && $_SESSION['user_hub_4_id'] == 0 && $_SESSION['user_hub_5_id'] == 0) : ?>
                  <a class="dropdown-item disabled cabin-font">Your other Hub's will appear here</a>
                <?php elseif($_SESSION['user_hub_1_id'] == 0 && $_SESSION['user_hub_3_id'] == 0 && $_SESSION['user_hub_4_id'] == 0 && $_SESSION['user_hub_5_id'] == 0) : ?>
                  <a class="dropdown-item disabled cabin-font">Your other Hub's will appear here</a>
                <?php elseif($_SESSION['user_hub_1_id'] == 0 && $_SESSION['user_hub_2_id'] == 0 && $_SESSION['user_hub_4_id'] == 0 && $_SESSION['user_hub_5_id'] == 0) : ?>
                  <a class="dropdown-item disabled cabin-font">Your other Hub's will appear here</a>
                <?php elseif($_SESSION['user_hub_1_id'] == 0 && $_SESSION['user_hub_2_id'] == 0 && $_SESSION['user_hub_3_id'] == 0 && $_SESSION['user_hub_5_id'] == 0) : ?>
                  <a class="dropdown-item disabled cabin-font">Your other Hub's will appear here</a>
                <?php elseif($_SESSION['user_hub_1_id'] == 0 && $_SESSION['user_hub_2_id'] == 0 && $_SESSION['user_hub_3_id'] == 0 && $_SESSION['user_hub_4_id'] == 0) : ?>
                  <a class="dropdown-item disabled cabin-font">Your other Hub's will appear here</a>
                <?php endif; ?>
              </div>
            </div>
          </form>
        </div>
        <div class="dropdown">
          <button class="btn dropdown-toggle text-white cabin-font p-2" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="navbar-user-name"><?php echo $_SESSION['user_name']; ?></span> &nbsp;
            <?php if(($_SESSION['user_hub_id'] == $_SESSION['user_hub_1_id']) && $_SESSION['user_hub_1_notifications'] > 0 || $_SESSION['user_invites'] > 0) : ?>
              <i class="fa fa-circle text-danger"></i> &nbsp;
            <?php elseif(($_SESSION['user_hub_id'] == $_SESSION['user_hub_2_id']) && $_SESSION['user_hub_2_notifications'] > 0 || $_SESSION['user_invites'] > 0) : ?>
              <i class="fa fa-circle text-danger"></i> &nbsp;
            <?php elseif(($_SESSION['user_hub_id'] == $_SESSION['user_hub_3_id']) && $_SESSION['user_hub_3_notifications'] > 0 || $_SESSION['user_invites'] > 0) : ?>
              <i class="fa fa-circle text-danger"></i> &nbsp;
            <?php elseif(($_SESSION['user_hub_id'] == $_SESSION['user_hub_4_id']) && $_SESSION['user_hub_4_notifications'] > 0 || $_SESSION['user_invites'] > 0) : ?>
              <i class="fa fa-circle text-danger"></i> &nbsp;
            <?php elseif(($_SESSION['user_hub_id'] == $_SESSION['user_hub_5_id']) && $_SESSION['user_hub_5_notifications'] > 0 || $_SESSION['user_invites'] > 0) : ?>
              <i class="fa fa-circle text-danger"></i> &nbsp;
            <?php endif; ?>
            <?php if($_SESSION['user_hub_1_id'] == $_SESSION['user_hub_id'] && $_SESSION['user_hub_1_whispers'] > 0) : ?>
              <i class="fa fa-circle text-info"></i> &nbsp;
            <?php elseif($_SESSION['user_hub_2_id'] == $_SESSION['user_hub_id'] && $_SESSION['user_hub_2_whispers'] > 0) : ?>
              <i class="fa fa-circle text-info"></i> &nbsp;
            <?php elseif($_SESSION['user_hub_3_id'] == $_SESSION['user_hub_id'] && $_SESSION['user_hub_3_whispers'] > 0) : ?>
              <i class="fa fa-circle text-info"></i> &nbsp;
            <?php elseif($_SESSION['user_hub_4_id'] == $_SESSION['user_hub_id'] && $_SESSION['user_hub_4_whispers'] > 0) : ?>
              <i class="fa fa-circle text-info"></i> &nbsp;
            <?php elseif($_SESSION['user_hub_5_id'] == $_SESSION['user_hub_id'] && $_SESSION['user_hub_5_whispers'] > 0) : ?>
              <i class="fa fa-circle text-info"></i> &nbsp;
            <?php endif; ?>
            <?php if(($_SESSION['user_hub_id'] == $_SESSION['user_hub_1_id']) && $_SESSION['user_hub_1_notifications'] == 0 && $_SESSION['user_hub_1_whispers'] == 0 && $_SESSION['user_invites'] == 0) : ?>
              <?php if($_SESSION['user_img']) : ?>
                <div class="rounded-circle border ml-1 mt-2 mb-n1 border-<?php echo $_SESSION['user_colour']; ?>" style="display:inline-block;height:1.4em;width:1.4em;overflow:hidden;border-width:.1em !important;background-image:url(<?php echo $_SESSION['user_img']; ?>);background-size:1.6em;background-position:50% 50%;background-repeat:no-repeat;"></div> &nbsp;
              <?php else : ?>
                <i class="fa fa-user-circle"></i> &nbsp;
              <?php endif; ?>
            <?php elseif(($_SESSION['user_hub_id'] == $_SESSION['user_hub_2_id']) && $_SESSION['user_hub_2_notifications'] == 0 && $_SESSION['user_hub_2_whispers'] == 0 && $_SESSION['user_invites'] == 0) : ?>
              <?php if($_SESSION['user_img']) : ?>
                <div class="rounded-circle border ml-1 mt-2 mb-n1 border-<?php echo $_SESSION['user_colour']; ?>" style="display:inline-block;height:1.4em;width:1.4em;overflow:hidden;border-width:.1em !important;background-image:url(<?php echo $_SESSION['user_img']; ?>);background-size:1.6em;background-position:50% 50%;background-repeat:no-repeat;"></div> &nbsp;
              <?php else : ?>
                <i class="fa fa-user-circle"></i> &nbsp;
              <?php endif; ?>
            <?php elseif(($_SESSION['user_hub_id'] == $_SESSION['user_hub_3_id']) && $_SESSION['user_hub_3_notifications'] == 0 && $_SESSION['user_hub_3_whispers'] == 0 && $_SESSION['user_invites'] == 0) : ?>
              <?php if($_SESSION['user_img']) : ?>
                <div class="rounded-circle border ml-1 mt-2 mb-n1 border-<?php echo $_SESSION['user_colour']; ?>" style="display:inline-block;height:1.4em;width:1.4em;overflow:hidden;border-width:.1em !important;background-image:url(<?php echo $_SESSION['user_img']; ?>);background-size:1.6em;background-position:50% 50%;background-repeat:no-repeat;"></div> &nbsp;
              <?php else : ?>
                <i class="fa fa-user-circle"></i> &nbsp;
              <?php endif; ?>
            <?php elseif(($_SESSION['user_hub_id'] == $_SESSION['user_hub_4_id']) && $_SESSION['user_hub_4_notifications'] == 0 && $_SESSION['user_hub_4_whispers'] == 0 && $_SESSION['user_invites'] == 0) : ?>
              <?php if($_SESSION['user_img']) : ?>
                <div class="rounded-circle border ml-1 mt-2 mb-n1 border-<?php echo $_SESSION['user_colour']; ?>" style="display:inline-block;height:1.4em;width:1.4em;overflow:hidden;border-width:.1em !important;background-image:url(<?php echo $_SESSION['user_img']; ?>);background-size:1.6em;background-position:50% 50%;background-repeat:no-repeat;"></div> &nbsp;
              <?php else : ?>
                <i class="fa fa-user-circle"></i> &nbsp;
              <?php endif; ?>
            <?php elseif(($_SESSION['user_hub_id'] == $_SESSION['user_hub_5_id']) && $_SESSION['user_hub_5_notifications'] == 0 && $_SESSION['user_hub_5_whispers'] == 0 && $_SESSION['user_invites'] == 0) : ?>
              <?php if($_SESSION['user_img']) : ?>
                <div class="rounded-circle border ml-1 mt-2 mb-n1 border-<?php echo $_SESSION['user_colour']; ?>" style="display:inline-block;height:1.4em;width:1.4em;overflow:hidden;border-width:.1em !important;background-image:url(<?php echo $_SESSION['user_img']; ?>);background-size:1.6em;background-position:50% 50%;background-repeat:no-repeat;"></div> &nbsp;
              <?php else : ?>
                <i class="fa fa-user-circle"></i> &nbsp;
              <?php endif; ?>
            <?php endif; ?>
          </button>
          <div class="dropdown-menu dropdown-menu-right px-1" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item px-2" href="<?php echo URLROOT; ?>/users/profile/<?php echo $_SESSION['user_id']; ?>">
              <div class="d-flex justify-content-between cabin-font text-hub-dark-purple">
                My Profile
              </div>
            </a>
            <a class="dropdown-item px-2" href="<?php echo URLROOT; ?>/messages/index">
              <div class="d-flex justify-content-between cabin-font text-hub-dark-purple">
                Whispers
                <?php if($_SESSION['user_hub_1_id'] == $_SESSION['user_hub_id']) : ?>
                  <?php if($_SESSION['user_hub_1_whispers'] > 0) : ?>
                    &nbsp;
                    <div class="row pr-2">
                      <p class="m-0 px-1"><i class="fa fa-inbox text-info"></i></p>
                      <p class="m-0 px-1 cabin-font text-hub-dark-purple"><?php echo $_SESSION['user_hub_1_whispers']; ?></p>
                    </div>
                  <?php endif; ?>
                <?php elseif($_SESSION['user_hub_2_id'] == $_SESSION['user_hub_id']) : ?>
                  <?php if($_SESSION['user_hub_2_whispers'] > 0) : ?>
                    &nbsp;
                    <div class="row pr-2">
                      <p class="m-0 px-1"><i class="fa fa-inbox text-info"></i></p>
                      <p class="m-0 px-1 cabin-font text-hub-dark-purple"><?php echo $_SESSION['user_hub_2_whispers']; ?></p>
                    </div>
                  <?php endif; ?>
                <?php elseif($_SESSION['user_hub_3_id'] == $_SESSION['user_hub_id']) : ?>
                  <?php if($_SESSION['user_hub_3_whispers'] > 0) : ?>
                    &nbsp;
                    <div class="row pr-2">
                      <p class="m-0 px-1"><i class="fa fa-inbox text-info"></i></p>
                      <p class="m-0 px-1 cabin-font text-hub-dark-purple"><?php echo $_SESSION['user_hub_3_whispers']; ?></p>
                    </div>
                  <?php endif; ?>
                <?php elseif($_SESSION['user_hub_4_id'] == $_SESSION['user_hub_id']) : ?>
                  <?php if($_SESSION['user_hub_4_whispers'] > 0) : ?>
                    &nbsp;
                    <div class="row pr-2">
                      <p class="m-0 px-1"><i class="fa fa-inbox text-info"></i></p>
                      <p class="m-0 px-1 cabin-font text-hub-dark-purple"><?php echo $_SESSION['user_hub_4_whispers']; ?></p>
                    </div>
                  <?php endif; ?>
                <?php elseif($_SESSION['user_hub_5_id'] == $_SESSION['user_hub_id']) : ?>
                  <?php if($_SESSION['user_hub_5_whispers'] > 0) : ?>
                    &nbsp;
                    <div class="row pr-2">
                      <p class="m-0 px-1"><i class="fa fa-inbox text-info"></i></p>
                      <p class="m-0 px-1 cabin-font text-hub-dark-purple"><?php echo $_SESSION['user_hub_5_whispers']; ?></p>
                    </div>
                  <?php endif; ?>
                <?php endif; ?>
              </div>
            </a>
            <a class="dropdown-item px-2" href="<?php echo URLROOT; ?>/pages/notifications">
              <div class="d-flex justify-content-between cabin-font text-hub-dark-purple">
                Hub Activity
                <?php if($_SESSION['user_hub_1_id'] == $_SESSION['user_hub_id']) : ?>
                  <?php if($_SESSION['user_hub_1_notifications'] > 0) : ?>
                    &nbsp;
                    <div class="row pr-2">
                      <p class="m-0 px-1"><i class="fa fa-bell text-danger"></i></p>
                      <p class="m-0 px-1 cabin-font text-hub-dark-purple"><?php echo $_SESSION['user_hub_1_notifications']; ?></p>
                    </div>
                  <?php endif; ?>
                <?php elseif($_SESSION['user_hub_2_id'] == $_SESSION['user_hub_id']) : ?>
                  <?php if($_SESSION['user_hub_2_notifications'] > 0) : ?>
                    &nbsp;
                    <div class="row pr-2">
                      <p class="m-0 px-1"><i class="fa fa-bell text-danger"></i></p>
                      <p class="m-0 px-1 cabin-font text-hub-dark-purple"><?php echo $_SESSION['user_hub_2_notifications']; ?></p>
                    </div>
                  <?php endif; ?>
                <?php elseif($_SESSION['user_hub_3_id'] == $_SESSION['user_hub_id']) : ?>
                  <?php if($_SESSION['user_hub_3_notifications'] > 0) : ?>
                    &nbsp;
                    <div class="row pr-2">
                      <p class="m-0 px-1"><i class="fa fa-bell text-danger"></i></p>
                      <p class="m-0 px-1 cabin-font text-hub-dark-purple"><?php echo $_SESSION['user_hub_3_notifications']; ?></p>
                    </div>
                  <?php endif; ?>
                <?php elseif($_SESSION['user_hub_4_id'] == $_SESSION['user_hub_id']) : ?>
                  <?php if($_SESSION['user_hub_4_notifications'] > 0) : ?>
                    &nbsp;
                    <div class="row pr-2">
                      <p class="m-0 px-1"><i class="fa fa-bell text-danger"></i></p>
                      <p class="m-0 px-1 cabin-font text-hub-dark-purple"><?php echo $_SESSION['user_hub_4_notifications']; ?></p>
                    </div>
                  <?php endif; ?>
                <?php elseif($_SESSION['user_hub_5_id'] == $_SESSION['user_hub_id']) : ?>
                  <?php if($_SESSION['user_hub_5_notifications'] > 0) : ?>
                    &nbsp;
                    <div class="row pr-2">
                      <p class="m-0 px-1"><i class="fa fa-bell text-danger"></i></p>
                      <p class="m-0 px-1 cabin-font text-hub-dark-purple"><?php echo $_SESSION['user_hub_5_notifications']; ?></p>
                    </div>
                  <?php endif; ?>
                <?php endif; ?>
              </div>
            </a>
            <a class="dropdown-item px-2" href="<?php echo URLROOT; ?>/users/search">
              <div class="d-flex justify-content-between cabin-font text-hub-dark-purple">
                Hubmates
              </div>
            </a>
            <a class="dropdown-item px-2" href="<?php echo URLROOT; ?>/pages/invites">
              <div class="d-flex justify-content-between cabin-font text-hub-dark-purple">
                Invites
                <?php if($_SESSION['user_invites'] > 0) : ?>
                  &nbsp;
                  <div class="row pr-2">
                    <p class="m-0 px-1"><i class="fa fa-envelope text-danger"></i></p>
                    <p class="m-0 px-1 cabin-font text-hub-dark-purple"><?php echo $_SESSION['user_invites']; ?></p>
                  </div>
                <?php endif; ?>
              </div>
            </a>
            <a class="dropdown-item px-2" href="<?php echo URLROOT; ?>/pages/about">
              <div class="d-flex justify-content-between cabin-font text-hub-dark-purple">
                About
              </div>
            </a>
            <a class="dropdown-item px-2" href="<?php echo URLROOT; ?>/pages/help">
              <div class="d-flex justify-content-between cabin-font text-hub-dark-purple">
                Help
              </div>
            </a>
            <a class="dropdown-item px-2" href="<?php echo URLROOT; ?>/users/logout">
              <div class="d-flex justify-content-between cabin-font text-hub-dark-purple">
                Logout
              </div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item disabled cabin-font" tabindex="-1" aria-disabled="true">Hub ID: <?php echo $_SESSION['user_id'] ?></a>
          </div>
        </div>
      <?php else : ?>
        <a>
          <!-- placeholder -->
        </a>
        <a href="<?php echo URLROOT; ?>" class="mb-n5">
          <img src="<?php echo URLROOT; ?>/public/img/hub_logo.png" style="height:3em;">
        </a>
      <?php endif; ?>
    </div>
  </div>
</header>
