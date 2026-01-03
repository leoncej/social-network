<!-- metadata -->
<?php $pageTitle = "Hub Activity"; ?>
<?php $pageDesc = "Hub Activity Description"; ?>
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
  <h1 class="my-3 cabin-font text-hub-dark-purple">Hub Activity</h1>
  <?php if($data['activities']) : ?>
    <?php $dayCounter = 0; ?>
    <?php $weekCounter = 0; ?>
    <?php $monthCounter = 0; ?>
    <?php $olderCounter = 0; ?>
    <?php foreach($data['activities'] as $activity) : ?>
      <?php if($activity->pointer == 'COMMENT') : ?>
        <?php if($activity->from_id != $_SESSION['user_id']) : ?>
          <?php if(date('Ymd', strtotime($activity->commentCreated)) >= date('Ymd', strtotime($data['joined']))) : ?>
            <?php if(date('Ymd', strtotime(date("Ymd", strtotime(date("Ymd"))) . "-1 day")) <= date('Ymd', strtotime($activity->commentCreated))) : ?>
              <?php if($dayCounter == 0) : ?>
                <h3 class="text-muted text-right mb-4 cabin-font">Today</h3>
              <?php endif; ?>
              <?php $dayCounter += 1; ?>
              <div class="d-flex justify-content-between cabin-font">
                <?php if($activity->img) : ?>
                  <div class="row">
                    <div class="rounded-circle ml-3 border border-<?php echo $activity->colour; ?>" style="height:1.4em;width:1.4em;overflow:hidden;border-width:.1em !important;background-image:url(<?php echo $activity->img; ?>);background-size:2em;background-position:50% 50%;background-repeat:no-repeat;"></div>
                    <?php if($activity->postUserId == $_SESSION['user_id']) : ?>
                      <p class="cabin-font"> &nbsp; &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->userId; ?>"><?php echo $activity->from_name; ?></a> commented "<?php echo $activity->comment; ?>" on your shout</p>
                    <?php elseif($activity->userId == $activity->postUserId) : ?>
                      <p class="cabin-font"> &nbsp; &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->userId; ?>"><?php echo $activity->from_name; ?></a> commented "<?php echo $activity->comment; ?>" on their own shout</p>
                    <?php else : ?>
                      <p class="cabin-font"> &nbsp; &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->userId; ?>"><?php echo $activity->from_name; ?></a> commented "<?php echo $activity->comment; ?>" on <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->postUserId; ?>"><?php echo $activity->postUser; ?>'s</a> shout</p>
                    <?php endif; ?>
                   </div>
                <?php else : ?>
                  <?php if($activity->postUserId == $_SESSION['user_id']) : ?>
                    <p class="cabin-font"><i class="fa fa-user-circle text-<?php echo $activity->colour; ?>" style="font-size:1.4em;"></i> &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->userId; ?>"><?php echo $activity->from_name; ?></a> commented "<?php echo $activity->comment; ?>" on your shout</p>
                  <?php elseif($activity->userId == $activity->postUserId) : ?>
                    <p class="cabin-font"><i class="fa fa-user-circle text-<?php echo $activity->colour; ?>" style="font-size:1.4em;"></i> &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->userId; ?>"><?php echo $activity->from_name; ?></a> commented "<?php echo $activity->comment; ?>" on their own shout</p>
                  <?php else : ?>
                    <p class="cabin-font"><i class="fa fa-user-circle text-<?php echo $activity->colour; ?>" style="font-size:1.4em;"></i> &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->userId; ?>"><?php echo $activity->from_name; ?></a> commented "<?php echo $activity->comment; ?>" on <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->postUserId; ?>"><?php echo $activity->postUser; ?>'s</a> shout</p>
                  <?php endif; ?>
                <?php endif; ?>
                <a href="<?php echo URLROOT; ?>/posts/show/<?php echo $activity->postId; ?>" class="btn btn-light pull-right cabin-font">
                  View
                </a>
              </div>
              <div class="mt-n3 mb-5">
                <small class="cabin-font text-muted">Today • <?php echo date_format(date_create($activity->commentCreated),"H:i"); ?></small>
              </div>
            <?php endif; ?>
            <?php if(date("Ymd", strtotime(date("Ymd", strtotime(date("Ymd"))) . "-1 week")) <= date('Ymd', strtotime($activity->commentCreated)) && date('Ymd') > date('Ymd', strtotime($activity->commentCreated))) : ?>
              <?php if($weekCounter == 0) : ?>
                <h3 class="text-muted text-right mb-4 cabin-font">In the past week</h3>
              <?php endif; ?>
              <?php $weekCounter += 1; ?>
              <div class="d-flex justify-content-between cabin-font">
                <?php if($activity->img) : ?>
                  <div class="row">
                    <div class="rounded-circle ml-3 border border-<?php echo $activity->colour; ?>" style="height:1.4em;width:1.4em;overflow:hidden;border-width:.1em !important;background-image:url(<?php echo $activity->img; ?>);background-size:2em;background-position:50% 50%;background-repeat:no-repeat;"></div>
                    <?php if($activity->postUserId == $_SESSION['user_id']) : ?>
                      <p class="cabin-font"> &nbsp; &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->userId; ?>"><?php echo $activity->from_name; ?></a> commented "<?php echo $activity->comment; ?>" on your shout</p>
                    <?php elseif($activity->userId == $activity->postUserId) : ?>
                      <p class="cabin-font"> &nbsp; &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->userId; ?>"><?php echo $activity->from_name; ?></a> commented "<?php echo $activity->comment; ?>" on their own shout</p>
                    <?php else : ?>
                      <p class="cabin-font"> &nbsp; &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->userId; ?>"><?php echo $activity->from_name; ?></a> commented "<?php echo $activity->comment; ?>" on <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->postUserId; ?>"><?php echo $activity->postUser; ?>'s</a> shout</p>
                    <?php endif; ?>
                   </div>
                <?php else : ?>
                  <?php if($activity->postUserId == $_SESSION['user_id']) : ?>
                    <p class="cabin-font"><i class="fa fa-user-circle text-<?php echo $activity->colour; ?>" style="font-size:1.4em;"></i> &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->userId; ?>"><?php echo $activity->from_name; ?></a> commented "<?php echo $activity->comment; ?>" on your shout</p>
                  <?php elseif($activity->userId == $activity->postUserId) : ?>
                    <p class="cabin-font"><i class="fa fa-user-circle text-<?php echo $activity->colour; ?>" style="font-size:1.4em;"></i> &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->userId; ?>"><?php echo $activity->from_name; ?></a> commented "<?php echo $activity->comment; ?>" on their own shout</p>
                  <?php else : ?>
                    <p class="cabin-font"><i class="fa fa-user-circle text-<?php echo $activity->colour; ?>" style="font-size:1.4em;"></i> &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->userId; ?>"><?php echo $activity->from_name; ?></a> commented "<?php echo $activity->comment; ?>" on <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->postUserId; ?>"><?php echo $activity->postUser; ?>'s</a> shout</p>
                  <?php endif; ?>
                <?php endif; ?>
                <a href="<?php echo URLROOT; ?>/posts/show/<?php echo $activity->postId; ?>" class="btn btn-light pull-right cabin-font">
                  View
                </a>
              </div>
              <div class="mt-n3 mb-5">
                <small class="cabin-font text-muted"><?php echo date_format(date_create($activity->commentCreated),"d M Y • H:i"); ?></small>
              </div>
            <?php endif; ?>
            <?php if(date("Ymd", strtotime(date("Ymd", strtotime(date("Ymd"))) . "-1 month")) <= date('Ymd', strtotime($activity->commentCreated)) && date("Ymd", strtotime(date("Ymd", strtotime(date("Ymd"))) . "-1 week")) > date('Ymd', strtotime($activity->commentCreated))) : ?>
              <?php if($monthCounter == 0) : ?>
                <h3 class="text-muted text-right mb-4 cabin-font">Past month</h3>
              <?php endif; ?>
              <?php $monthCounter += 1; ?>
              <div class="d-flex justify-content-between cabin-font">
                <?php if($activity->img) : ?>
                  <div class="row">
                    <div class="rounded-circle ml-3 border border-<?php echo $activity->colour; ?>" style="height:1.4em;width:1.4em;overflow:hidden;border-width:.1em !important;background-image:url(<?php echo $activity->img; ?>);background-size:2em;background-position:50% 50%;background-repeat:no-repeat;"></div>
                    <?php if($activity->postUserId == $_SESSION['user_id']) : ?>
                      <p class="cabin-font"> &nbsp; &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->userId; ?>"><?php echo $activity->from_name; ?></a> commented "<?php echo $activity->comment; ?>" on your shout</p>
                    <?php elseif($activity->userId == $activity->postUserId) : ?>
                      <p class="cabin-font"> &nbsp; &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->userId; ?>"><?php echo $activity->from_name; ?></a> commented "<?php echo $activity->comment; ?>" on their own shout</p>
                    <?php else : ?>
                      <p class="cabin-font"> &nbsp; &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->userId; ?>"><?php echo $activity->from_name; ?></a> commented "<?php echo $activity->comment; ?>" on <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->postUserId; ?>"><?php echo $activity->postUser; ?>'s</a> shout</p>
                    <?php endif; ?>
                   </div>
                <?php else : ?>
                  <?php if($activity->postUserId == $_SESSION['user_id']) : ?>
                    <p class="cabin-font"><i class="fa fa-user-circle text-<?php echo $activity->colour; ?>" style="font-size:1.4em;"></i> &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->userId; ?>"><?php echo $activity->from_name; ?></a> commented "<?php echo $activity->comment; ?>" on your shout</p>
                  <?php elseif($activity->userId == $activity->postUserId) : ?>
                    <p class="cabin-font"><i class="fa fa-user-circle text-<?php echo $activity->colour; ?>" style="font-size:1.4em;"></i> &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->userId; ?>"><?php echo $activity->from_name; ?></a> commented "<?php echo $activity->comment; ?>" on their own shout</p>
                  <?php else : ?>
                    <p class="cabin-font"><i class="fa fa-user-circle text-<?php echo $activity->colour; ?>" style="font-size:1.4em;"></i> &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->userId; ?>"><?php echo $activity->from_name; ?></a> commented "<?php echo $activity->comment; ?>" on <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->postUserId; ?>"><?php echo $activity->postUser; ?>'s</a> shout</p>
                  <?php endif; ?>
                <?php endif; ?>
                <a href="<?php echo URLROOT; ?>/posts/show/<?php echo $activity->postId; ?>" class="btn btn-light pull-right cabin-font">
                  View
                </a>
              </div>
              <div class="mt-n3 mb-5">
                <small class="cabin-font text-muted"><?php echo date_format(date_create($activity->commentCreated),"d M Y • H:i"); ?></small>
              </div>
            <?php endif; ?>
            <?php if(date("Ymd", strtotime(date("Ymd", strtotime(date("Ymd"))) . "-1 month")) > date('Ymd', strtotime($activity->commentCreated))) : ?>
              <?php if($olderCounter == 0) : ?>
                <h3 class="text-muted text-right mb-4 cabin-font">Older</h3>
              <?php endif; ?>
              <?php $olderCounter += 1; ?>
              <div class="d-flex justify-content-between cabin-font">
                <?php if($activity->img) : ?>
                  <div class="row">
                    <div class="rounded-circle ml-3 border border-<?php echo $activity->colour; ?>" style="height:1.4em;width:1.4em;overflow:hidden;border-width:.1em !important;background-image:url(<?php echo $activity->img; ?>);background-size:2em;background-position:50% 50%;background-repeat:no-repeat;"></div>
                    <?php if($activity->postUserId == $_SESSION['user_id']) : ?>
                      <p class="cabin-font"> &nbsp; &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->userId; ?>"><?php echo $activity->from_name; ?></a> commented "<?php echo $activity->comment; ?>" on your shout</p>
                    <?php elseif($activity->userId == $activity->postUserId) : ?>
                      <p class="cabin-font"> &nbsp; &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->userId; ?>"><?php echo $activity->from_name; ?></a> commented "<?php echo $activity->comment; ?>" on their own shout</p>
                    <?php else : ?>
                      <p class="cabin-font"> &nbsp; &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->userId; ?>"><?php echo $activity->from_name; ?></a> commented "<?php echo $activity->comment; ?>" on <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->postUserId; ?>"><?php echo $activity->postUser; ?>'s</a> shout</p>
                    <?php endif; ?>
                   </div>
                <?php else : ?>
                  <?php if($activity->postUserId == $_SESSION['user_id']) : ?>
                    <p class="cabin-font"><i class="fa fa-user-circle text-<?php echo $activity->colour; ?>" style="font-size:1.4em;"></i> &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->userId; ?>"><?php echo $activity->from_name; ?></a> commented "<?php echo $activity->comment; ?>" on your shout</p>
                  <?php elseif($activity->userId == $activity->postUserId) : ?>
                    <p class="cabin-font"><i class="fa fa-user-circle text-<?php echo $activity->colour; ?>" style="font-size:1.4em;"></i> &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->userId; ?>"><?php echo $activity->from_name; ?></a> commented "<?php echo $activity->comment; ?>" on their own shout</p>
                  <?php else : ?>
                    <p class="cabin-font"><i class="fa fa-user-circle text-<?php echo $activity->colour; ?>" style="font-size:1.4em;"></i> &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->userId; ?>"><?php echo $activity->from_name; ?></a> commented "<?php echo $activity->comment; ?>" on <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->postUserId; ?>"><?php echo $activity->postUser; ?>'s</a> shout</p>
                  <?php endif; ?>
                <?php endif; ?>
                <a href="<?php echo URLROOT; ?>/posts/show/<?php echo $activity->postId; ?>" class="btn btn-light pull-right cabin-font">
                  View
                </a>
              </div>
              <div class="mt-n3 mb-5">
                <small class="cabin-font text-muted"><?php echo date_format(date_create($activity->commentCreated),"d M Y • H:i"); ?></small>
              </div>
            <?php endif; ?>
          <?php endif; ?>
        <?php endif; ?>
      <?php elseif($activity->pointer == 'POST') : ?>
        <?php if($activity->user_id != $_SESSION['user_id']) : ?>
          <?php if(date('Ymd', strtotime($activity->postCreated)) >= date('Ymd', strtotime($data['joined']))) : ?>
            <?php if(date('Ymd', strtotime(date("Ymd", strtotime(date("Ymd"))) . "-1 day")) <= date('Ymd', strtotime($activity->postCreated))) : ?>
              <?php if($dayCounter == 0) : ?>
                <h3 class="text-muted text-right mb-4 cabin-font">Today</h3>
              <?php endif; ?>
              <?php $dayCounter += 1; ?>
              <div class="d-flex justify-content-between cabin-font">
                <?php if($activity->img) : ?>
                  <div class="row">
                    <div class="rounded-circle ml-3 border border-<?php echo $activity->colour; ?>" style="height:1.4em;width:1.4em;overflow:hidden;border-width:.1em !important;background-image:url(<?php echo $activity->img; ?>);background-size:2em;background-position:50% 50%;background-repeat:no-repeat;"></div>
                    <?php if($activity->postImg) : ?>
                      <p class="cabin-font"> &nbsp; &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->name . " " . $activity->last_name; ?></a> shared an image</p>
                    <?php else: ?>
                      <p class="cabin-font"> &nbsp; &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->name . " " . $activity->last_name; ?></a> shouted "<?php echo $activity->title; ?>"</p>
                    <?php endif; ?>
                   </div>
                <?php else : ?>
                  <?php if($activity->postImg) : ?>
                    <p class="cabin-font"><i class="fa fa-user-circle text-<?php echo $activity->colour; ?>" style="font-size:1.4em;"></i> &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->name . " " . $activity->last_name; ?></a> shared an image</p>
                  <?php else : ?>
                    <p class="cabin-font"><i class="fa fa-user-circle text-<?php echo $activity->colour; ?>" style="font-size:1.4em;"></i> &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->name . " " . $activity->last_name; ?></a> shouted "<?php echo $activity->title; ?>"</p>
                  <?php endif; ?>
                <?php endif; ?>
                <a href="<?php echo URLROOT; ?>/posts/show/<?php echo $activity->postId; ?>" class="btn btn-light pull-right cabin-font">
                  View
                </a>
              </div>
              <div class="mt-n3 mb-5">
                <small class="cabin-font text-muted">Today • <?php echo date_format(date_create($activity->postCreated),"H:i"); ?></small>
              </div>
            <?php endif; ?>
            <?php if(date("Ymd", strtotime(date("Ymd", strtotime(date("Ymd"))) . "-1 week")) <= date('Ymd', strtotime($activity->postCreated)) && date('Ymd') > date('Ymd', strtotime($activity->postCreated))) : ?>
              <?php if($weekCounter == 0) : ?>
                <h3 class="text-muted text-right mb-4 cabin-font">In the past week</h3>
              <?php endif; ?>
              <?php $weekCounter += 1; ?>
              <div class="d-flex justify-content-between cabin-font">
                <?php if($activity->img) : ?>
                  <div class="row">
                    <div class="rounded-circle ml-3 border border-<?php echo $activity->colour; ?>" style="height:1.4em;width:1.4em;overflow:hidden;border-width:.1em !important;background-image:url(<?php echo $activity->img; ?>);background-size:2em;background-position:50% 50%;background-repeat:no-repeat;"></div>
                    <?php if($activity->postImg) : ?>
                      <p class="cabin-font"> &nbsp; &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->name . " " . $activity->last_name; ?></a> shared an image</p>
                    <?php else: ?>
                      <p class="cabin-font"> &nbsp; &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->name . " " . $activity->last_name; ?></a> shouted "<?php echo $activity->title; ?>"</p>
                    <?php endif; ?>
                   </div>
                <?php else : ?>
                  <?php if($activity->postImg) : ?>
                    <p class="cabin-font"><i class="fa fa-user-circle text-<?php echo $activity->colour; ?>" style="font-size:1.4em;"></i> &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->name . " " . $activity->last_name; ?></a> shared an image</p>
                  <?php else : ?>
                    <p class="cabin-font"><i class="fa fa-user-circle text-<?php echo $activity->colour; ?>" style="font-size:1.4em;"></i> &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->name . " " . $activity->last_name; ?></a> shouted "<?php echo $activity->title; ?>"</p>
                  <?php endif; ?>
                <?php endif; ?>
                <a href="<?php echo URLROOT; ?>/posts/show/<?php echo $activity->postId; ?>" class="btn btn-light pull-right cabin-font">
                  View
                </a>
              </div>
              <div class="mt-n3 mb-5">
                <small class="cabin-font text-muted"><?php echo date_format(date_create($activity->postCreated),"d M Y • H:i"); ?></small>
              </div>
            <?php endif; ?>
            <?php if(date("Ymd", strtotime(date("Ymd", strtotime(date("Ymd"))) . "-1 month")) <= date('Ymd', strtotime($activity->postCreated)) && date("Ymd", strtotime(date("Ymd", strtotime(date("Ymd"))) . "-1 week")) > date('Ymd', strtotime($activity->postCreated))) : ?>
              <?php if($monthCounter == 0) : ?>
                <h3 class="text-muted text-right mb-4 cabin-font">Past month</h3>
              <?php endif; ?>
              <?php $monthCounter += 1; ?>
              <div class="d-flex justify-content-between cabin-font">
                <?php if($activity->img) : ?>
                  <div class="row">
                    <div class="rounded-circle ml-3 border border-<?php echo $activity->colour; ?>" style="height:1.4em;width:1.4em;overflow:hidden;border-width:.1em !important;background-image:url(<?php echo $activity->img; ?>);background-size:2em;background-position:50% 50%;background-repeat:no-repeat;"></div>
                    <?php if($activity->postImg) : ?>
                      <p class="cabin-font"> &nbsp; &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->name . " " . $activity->last_name; ?></a> shared an image</p>
                    <?php else: ?>
                      <p class="cabin-font"> &nbsp; &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->name . " " . $activity->last_name; ?></a> shouted "<?php echo $activity->title; ?>"</p>
                    <?php endif; ?>
                   </div>
                <?php else : ?>
                  <?php if($activity->postImg) : ?>
                    <p class="cabin-font"><i class="fa fa-user-circle text-<?php echo $activity->colour; ?>" style="font-size:1.4em;"></i> &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->name . " " . $activity->last_name; ?></a> shared an image</p>
                  <?php else : ?>
                    <p class="cabin-font"><i class="fa fa-user-circle text-<?php echo $activity->colour; ?>" style="font-size:1.4em;"></i> &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->name . " " . $activity->last_name; ?></a> shouted "<?php echo $activity->title; ?>"</p>
                  <?php endif; ?>
                <?php endif; ?>
                <a href="<?php echo URLROOT; ?>/posts/show/<?php echo $activity->postId; ?>" class="btn btn-light pull-right cabin-font">
                  View
                </a>
              </div>
              <div class="mt-n3 mb-5">
                <small class="cabin-font text-muted"><?php echo date_format(date_create($activity->postCreated),"d M Y • H:i"); ?></small>
              </div>
            <?php endif; ?>
            <?php if(date("Ymd", strtotime(date("Ymd", strtotime(date("Ymd"))) . "-1 month")) > date('Ymd', strtotime($activity->postCreated))) : ?>
              <?php if($olderCounter == 0) : ?>
                <h3 class="text-muted text-right mb-4 cabin-font">Older</h3>
              <?php endif; ?>
              <?php $olderCounter += 1; ?>
              <div class="d-flex justify-content-between cabin-font">
                <?php if($activity->img) : ?>
                  <div class="row">
                    <div class="rounded-circle ml-3 border border-<?php echo $activity->colour; ?>" style="height:1.4em;width:1.4em;overflow:hidden;border-width:.1em !important;background-image:url(<?php echo $activity->img; ?>);background-size:2em;background-position:50% 50%;background-repeat:no-repeat;"></div>
                    <?php if($activity->postImg) : ?>
                      <p class="cabin-font"> &nbsp; &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->name . " " . $activity->last_name; ?></a> shared an image</p>
                    <?php else: ?>
                      <p class="cabin-font"> &nbsp; &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->name . " " . $activity->last_name; ?></a> shouted "<?php echo $activity->title; ?>"</p>
                    <?php endif; ?>
                   </div>
                <?php else : ?>
                  <?php if($activity->postImg) : ?>
                    <p class="cabin-font"><i class="fa fa-user-circle text-<?php echo $activity->colour; ?>" style="font-size:1.4em;"></i> &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->name . " " . $activity->last_name; ?></a> shared an image</p>
                  <?php else : ?>
                    <p class="cabin-font"><i class="fa fa-user-circle text-<?php echo $activity->colour; ?>" style="font-size:1.4em;"></i> &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->name . " " . $activity->last_name; ?></a> shouted "<?php echo $activity->title; ?>"</p>
                  <?php endif; ?>
                <?php endif; ?>
                <a href="<?php echo URLROOT; ?>/posts/show/<?php echo $activity->postId; ?>" class="btn btn-light pull-right cabin-font">
                  View
                </a>
              </div>
              <div class="mt-n3 mb-5">
                <small class="cabin-font text-muted"><?php echo date_format(date_create($activity->postCreated),"d M Y • H:i"); ?></small>
              </div>
            <?php endif; ?>
          <?php endif; ?>
        <?php endif; ?>
      <?php elseif($activity->pointer == 'ACTIVITY') : ?>
        <?php if($activity->user_id != $_SESSION['user_id']) : ?>
          <?php if(date('Ymd', strtotime($activity->activityCreated)) >= date('Ymd', strtotime($data['joined']))) : ?>
            <?php if(date('Ymd') == date('Ymd', strtotime($activity->activityCreated))) : ?>
              <?php if($dayCounter == 0) : ?>
                <h3 class="text-muted text-right mb-4 cabin-font">Today</h3>
              <?php endif; ?>
              <?php $dayCounter += 1; ?>
              <div class="container cabin-font">
                <?php if($activity->type == 'Join') : ?>
                  <?php if($activity->deletedAccount) : ?>
                    <p class="text-center text-muted m-5 cabin-font"><i class="fa fa-home"></i> &nbsp; <?php echo $activity->user; ?> joined <?php echo $_SESSION['user_hub']; ?>Hub today at <?php echo date_format(date_create($activity->activityCreated),"H:i"); ?></p>
                  <?php else : ?>
                    <p class="text-center text-muted m-5 cabin-font"><i class="fa fa-home"></i> &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->user; ?></a> joined <?php echo $_SESSION['user_hub']; ?>Hub today at <?php echo date_format(date_create($activity->activityCreated),"H:i"); ?></p>
                  <?php endif; ?>
                <?php elseif($activity->type == 'Leave') : ?>
                  <?php if($activity->deletedAccount) : ?>
                    <p class="text-center text-muted m-5 cabin-font"><i class="fa fa-home"></i> &nbsp; <?php echo $activity->user; ?> left <?php echo $_SESSION['user_hub']; ?>Hub today at <?php echo date_format(date_create($activity->activityCreated),"H:i"); ?></p>
                  <?php else : ?>
                    <p class="text-center text-muted m-5 cabin-font"><i class="fa fa-home"></i> &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->user; ?></a> left <?php echo $_SESSION['user_hub']; ?>Hub today at <?php echo date_format(date_create($activity->activityCreated),"H:i"); ?></p>
                  <?php endif; ?>
                <?php endif; ?>
              </div>
            <?php endif; ?>
            <?php if(date("Ymd", strtotime(date("Ymd", strtotime(date("Ymd"))) . "-1 week")) <= date('Ymd', strtotime($activity->activityCreated)) && date('Ymd') > date('Ymd', strtotime($activity->activityCreated))) : ?>
              <?php if($weekCounter == 0) : ?>
                <h3 class="text-muted text-right mb-4 cabin-font">In the past week</h3>
              <?php endif; ?>
              <?php $weekCounter += 1; ?>
              <div class="container cabin-font">
                <?php if($activity->type == 'Join') : ?>
                  <?php if($activity->deletedAccount) : ?>
                    <p class="text-center text-muted m-5 cabin-font"><i class="fa fa-home"></i> &nbsp; <?php echo $activity->user; ?> joined <?php echo $_SESSION['user_hub']; ?>Hub on <?php echo date_format(date_create($activity->activityCreated),"d M Y"); ?></p>
                  <?php else : ?>
                    <p class="text-center text-muted m-5 cabin-font"><i class="fa fa-home"></i> &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->user; ?></a> joined <?php echo $_SESSION['user_hub']; ?>Hub on <?php echo date_format(date_create($activity->activityCreated),"d M Y"); ?></p>
                  <?php endif; ?>
                <?php elseif($activity->type == 'Leave') : ?>
                  <?php if($activity->deletedAccount) : ?>
                    <p class="text-center text-muted m-5 cabin-font"><i class="fa fa-home"></i> &nbsp; <?php echo $activity->user; ?> left <?php echo $_SESSION['user_hub']; ?>Hub on <?php echo date_format(date_create($activity->activityCreated),"d M Y"); ?></p>
                  <?php else : ?>
                    <p class="text-center text-muted m-5 cabin-font"><i class="fa fa-home"></i> &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->user; ?></a> left <?php echo $_SESSION['user_hub']; ?>Hub on <?php echo date_format(date_create($activity->activityCreated),"d M Y"); ?></p>
                  <?php endif; ?>
                <?php endif; ?>
              </div>
            <?php endif; ?>
            <?php if(date("Ymd", strtotime(date("Ymd", strtotime(date("Ymd"))) . "-1 month")) <= date('Ymd', strtotime($activity->activityCreated)) && date("Ymd", strtotime(date("Ymd", strtotime(date("Ymd"))) . "-1 week")) > date('Ymd', strtotime($activity->activityCreated))) : ?>
              <?php if($monthCounter == 0) : ?>
                <h3 class="text-muted text-right mb-4 cabin-font">Past month</h3>
              <?php endif; ?>
              <?php $monthCounter += 1; ?>
              <div class="container cabin-font">
                <?php if($activity->type == 'Join') : ?>
                  <?php if($activity->deletedAccount) : ?>
                    <p class="text-center text-muted m-5 cabin-font"><i class="fa fa-home"></i> &nbsp; <?php echo $activity->user; ?> joined <?php echo $_SESSION['user_hub']; ?>Hub on <?php echo date_format(date_create($activity->activityCreated),"d M Y"); ?></p>
                  <?php else : ?>
                    <p class="text-center text-muted m-5 cabin-font"><i class="fa fa-home"></i> &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->user; ?></a> joined <?php echo $_SESSION['user_hub']; ?>Hub on <?php echo date_format(date_create($activity->activityCreated),"d M Y"); ?></p>
                  <?php endif; ?>
                <?php elseif($activity->type == 'Leave') : ?>
                  <?php if($activity->deletedAccount) : ?>
                    <p class="text-center text-muted m-5 cabin-font"><i class="fa fa-home"></i> &nbsp; <?php echo $activity->user; ?> left <?php echo $_SESSION['user_hub']; ?>Hub on <?php echo date_format(date_create($activity->activityCreated),"d M Y"); ?></p>
                  <?php else : ?>
                    <p class="text-center text-muted m-5 cabin-font"><i class="fa fa-home"></i> &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->user; ?></a> left <?php echo $_SESSION['user_hub']; ?>Hub on <?php echo date_format(date_create($activity->activityCreated),"d M Y"); ?></p>
                  <?php endif; ?>
                <?php endif; ?>
              </div>
            <?php endif; ?>
            <?php if(date("Ymd", strtotime(date("Ymd", strtotime(date("Ymd"))) . "-1 month")) > date('Ymd', strtotime($activity->activityCreated))) : ?>
              <?php if($olderCounter == 0) : ?>
                <h3 class="text-muted text-right mb-4 cabin-font">Older</h3>
              <?php endif; ?>
              <?php $olderCounter += 1; ?>
              <div class="container cabin-fon">
                <?php if($activity->type == 'Join') : ?>
                  <?php if($activity->deletedAccount) : ?>
                    <p class="text-center text-muted m-5 cabin-font"><i class="fa fa-home"></i> &nbsp; <?php echo $activity->user; ?> joined <?php echo $_SESSION['user_hub']; ?>Hub on <?php echo date_format(date_create($activity->activityCreated),"d M Y"); ?></p>
                  <?php else : ?>
                    <p class="text-center text-muted m-5 cabin-font"><i class="fa fa-home"></i> &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->user; ?></a> joined <?php echo $_SESSION['user_hub']; ?>Hub on <?php echo date_format(date_create($activity->activityCreated),"d M Y"); ?></p>
                  <?php endif; ?>
                <?php elseif($activity->type == 'Leave') : ?>
                  <?php if($activity->deletedAccount) : ?>
                    <p class="text-center text-muted m-5 cabin-font"><i class="fa fa-home"></i> &nbsp; <?php echo $activity->user; ?> left <?php echo $_SESSION['user_hub']; ?>Hub on <?php echo date_format(date_create($activity->activityCreated),"d M Y"); ?></p>
                  <?php else : ?>
                    <p class="text-center text-muted m-5 cabin-font"><i class="fa fa-home"></i> &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->user; ?></a> left <?php echo $_SESSION['user_hub']; ?>Hub on <?php echo date_format(date_create($activity->activityCreated),"d M Y"); ?></p>
                  <?php endif; ?>
                <?php endif; ?>
              </div>
            <?php endif; ?>
          <?php endif; ?>
        <?php endif; ?>
      <?php elseif($activity->pointer == 'NAME') : ?>
        <?php if(date('Ymd', strtotime($activity->activityCreated)) >= date('Ymd', strtotime($data['joined']))) : ?>
          <?php if(date('Ymd') == date('Ymd', strtotime($activity->activityCreated))) : ?>
            <?php if($dayCounter == 0) : ?>
              <h3 class="text-muted text-right mb-4 cabin-font">Today</h3>
            <?php endif; ?>
            <?php $dayCounter += 1; ?>
            <div class="container cabin-font">
              <?php if($activity->deletedAccount) : ?>
                <p class="text-center text-muted m-5 cabin-font"><i class="fa fa-home"></i> &nbsp; <?php echo $activity->user; ?> renamed this Hub to <?php echo $activity->hub; ?>Hub</p>
              <?php elseif($activity->user_id == $_SESSION['user_id']) : ?>
                <p class="text-center text-muted m-5 cabin-font">You renamed this Hub to <?php echo $activity->hub; ?>Hub</p>
              <?php else : ?>
                <?php if($activity->img) : ?>
                  <div class="d-flex justify-content-center m-5">
                    <div class="rounded-circle border border-<?php echo $activity->colour; ?>" style="height:1.4em;width:1.4em;overflow:hidden;border-width:.1em !important;background-image:url(<?php echo $activity->img; ?>);background-size:2em;background-position:50% 50%;background-repeat:no-repeat;"></div>
                    <p class="text-muted cabin-font"> &nbsp; &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->user; ?></a> renamed this Hub to <?php echo $activity->hub; ?>Hub</p>
                  </div>
                <?php else : ?>
                  <p class="text-center text-muted m-5 cabin-font"><i class="fa fa-user-circle text-<?php echo $activity->colour; ?>" style="font-size:1.4em;"></i> &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->user; ?></a> renamed this Hub to <?php echo $activity->hub; ?>Hub</p>
                <?php endif; ?>
              <?php endif; ?>
            </div>
          <?php endif; ?>
          <?php if(date("Ymd", strtotime(date("Ymd", strtotime(date("Ymd"))) . "-1 week")) <= date('Ymd', strtotime($activity->activityCreated)) && date('Ymd') > date('Ymd', strtotime($activity->activityCreated))) : ?>
            <?php if($weekCounter == 0) : ?>
              <h3 class="text-muted text-right mb-4 cabin-font">In the past week</h3>
            <?php endif; ?>
            <?php $weekCounter += 1; ?>
            <div class="container cabin-font">
              <?php if($activity->deletedAccount) : ?>
                <p class="text-center text-muted m-5 cabin-font"><i class="fa fa-home"></i> &nbsp; <?php echo $activity->user; ?> renamed this Hub to <?php echo $activity->hub; ?>Hub</p>
              <?php elseif($activity->user_id == $_SESSION['user_id']) : ?>
                <p class="text-center text-muted m-5 cabin-font">You renamed this Hub to <?php echo $activity->hub; ?>Hub</p>
              <?php else : ?>
                <?php if($activity->img) : ?>
                  <div class="d-flex justify-content-center m-5">
                    <div class="rounded-circle border border-<?php echo $activity->colour; ?>" style="height:1.4em;width:1.4em;overflow:hidden;border-width:.1em !important;background-image:url(<?php echo $activity->img; ?>);background-size:2em;background-position:50% 50%;background-repeat:no-repeat;"></div>
                    <p class="text-muted cabin-font"> &nbsp; &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->user; ?></a> renamed this Hub to <?php echo $activity->hub; ?>Hub</p>
                  </div>
                <?php else : ?>
                  <p class="text-center text-muted m-5 cabin-font"><i class="fa fa-user-circle text-<?php echo $activity->colour; ?>" style="font-size:1.4em;"></i> &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->user; ?></a> renamed this Hub to <?php echo $activity->hub; ?>Hub</p>
                <?php endif; ?>
              <?php endif; ?>
            </div>
          <?php endif; ?>
          <?php if(date("Ymd", strtotime(date("Ymd", strtotime(date("Ymd"))) . "-1 month")) <= date('Ymd', strtotime($activity->activityCreated)) && date("Ymd", strtotime(date("Ymd", strtotime(date("Ymd"))) . "-1 week")) > date('Ymd', strtotime($activity->activityCreated))) : ?>
            <?php if($monthCounter == 0) : ?>
              <h3 class="text-muted text-right mb-4 cabin-font">Past month</h3>
            <?php endif; ?>
            <?php $monthCounter += 1; ?>
            <div class="container cabin-font">
              <?php if($activity->deletedAccount) : ?>
                <p class="text-center text-muted m-5 cabin-font"><i class="fa fa-home"></i> &nbsp; <?php echo $activity->user; ?> renamed this Hub to <?php echo $activity->hub; ?>Hub</p>
              <?php elseif($activity->user_id == $_SESSION['user_id']) : ?>
                <p class="text-center text-muted m-5 cabin-font">You renamed this Hub to <?php echo $activity->hub; ?>Hub</p>
              <?php else : ?>
                <?php if($activity->img) : ?>
                  <div class="d-flex justify-content-center m-5">
                    <div class="rounded-circle border border-<?php echo $activity->colour; ?>" style="height:1.4em;width:1.4em;overflow:hidden;border-width:.1em !important;background-image:url(<?php echo $activity->img; ?>);background-size:2em;background-position:50% 50%;background-repeat:no-repeat;"></div>
                    <p class="text-muted cabin-font"> &nbsp; &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->user; ?></a> renamed this Hub to <?php echo $activity->hub; ?>Hub</p>
                  </div>
                <?php else : ?>
                  <p class="text-center text-muted m-5 cabin-font"><i class="fa fa-user-circle text-<?php echo $activity->colour; ?>" style="font-size:1.4em;"></i> &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->user; ?></a> renamed this Hub to <?php echo $activity->hub; ?>Hub</p>
                <?php endif; ?>
              <?php endif; ?>
            </div>
          <?php endif; ?>
          <?php if(date("Ymd", strtotime(date("Ymd", strtotime(date("Ymd"))) . "-1 month")) > date('Ymd', strtotime($activity->activityCreated))) : ?>
            <?php if($olderCounter == 0) : ?>
              <h3 class="text-muted text-right mb-4 cabin-font">Older</h3>
            <?php endif; ?>
            <?php $olderCounter += 1; ?>
            <div class="container cabin-font">
              <?php if($activity->deletedAccount) : ?>
                <p class="text-center text-muted m-5 cabin-font"><i class="fa fa-home"></i> &nbsp; <?php echo $activity->user; ?> renamed this Hub to <?php echo $activity->hub; ?>Hub</p>
              <?php elseif($activity->user_id == $_SESSION['user_id']) : ?>
                <p class="text-center text-muted m-5 cabin-font">You renamed this Hub to <?php echo $activity->hub; ?>Hub</p>
              <?php else : ?>
                <?php if($activity->img) : ?>
                  <div class="d-flex justify-content-center m-5">
                    <div class="rounded-circle border border-<?php echo $activity->colour; ?>" style="height:1.4em;width:1.4em;overflow:hidden;border-width:.1em !important;background-image:url(<?php echo $activity->img; ?>);background-size:2em;background-position:50% 50%;background-repeat:no-repeat;"></div>
                    <p class="text-muted cabin-font"> &nbsp; &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->user; ?></a> renamed this Hub to <?php echo $activity->hub; ?>Hub</p>
                  </div>
                <?php else : ?>
                  <p class="text-center text-muted m-5 cabin-font"><i class="fa fa-user-circle text-<?php echo $activity->colour; ?>" style="font-size:1.4em;"></i> &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->user; ?></a> renamed this Hub to <?php echo $activity->hub; ?>Hub</p>
                <?php endif; ?>
              <?php endif; ?>
            </div>
          <?php endif; ?>
        <?php endif; ?>
      <?php elseif($activity->pointer == 'STAR') : ?>
        <?php if(date('Ymd', strtotime($activity->activityCreated)) >= date('Ymd', strtotime($data['joined']))) : ?>
          <?php if(date('Ymd') == date('Ymd', strtotime($activity->activityCreated))) : ?>
            <?php if($dayCounter == 0) : ?>
              <h3 class="text-muted text-right mb-4 cabin-font">Today</h3>
            <?php endif; ?>
            <?php $dayCounter += 1; ?>
            <div class="d-flex justify-content-between cabin-font">
              <?php if($activity->deletedAccount) : ?>
                <p class="text-centerd cabin-font"><i class="fa fa-user-circle text-muted" style="font-size:1.4em;"></i> &nbsp; <?php echo $activity->user; ?> starred <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->postUserId; ?>"><?php echo $activity->postUserName; ?>'s</a> Shout</p>
              <?php elseif($activity->user_id == $_SESSION['user_id'] && $activity->postUserId == $_SESSION['user_id']) : ?>
                <p class="text-center cabin-font">You starred your own Shout</p>
              <?php elseif($activity->user_id == $_SESSION['user_id']) : ?>
                <p class="text-center cabin-font">You starred <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->postUserId; ?>"><?php echo $activity->postUserName; ?>'s</a> Shout</p>
              <?php elseif($activity->postUserId == $_SESSION['user_id']) : ?>
                <p class="text-center cabin-font"><a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->user; ?></a> starred your Shout</p>
              <?php else : ?>
                <?php if($activity->img) : ?>
                  <div class="row">
                    <div class="rounded-circle border border-<?php echo $activity->colour; ?>" style="height:1.4em;width:1.4em;overflow:hidden;border-width:.1em !important;background-image:url(<?php echo $activity->img; ?>);background-size:2em;background-position:50% 50%;background-repeat:no-repeat;"></div>
                    <p class="cabin-font"> &nbsp; &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->user; ?></a> starred <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->postUserId; ?>"><?php echo $activity->postUserName; ?>'s</a> Shout</p>
                  </div>
                <?php else : ?>
                  <p class="text-center cabin-font"><i class="fa fa-user-circle text-<?php echo $activity->colour; ?>" style="font-size:1.4em;"></i> &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->user; ?></a> starred <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->postUserId; ?>"><?php echo $activity->postUserName; ?>'s</a> Shout</p>
                <?php endif; ?>
              <?php endif; ?>
              <a href="<?php echo URLROOT; ?>/posts/show/<?php echo $activity->post_id; ?>" class="btn btn-light pull-right cabin-font">
                View
              </a>
            </div>
            <div class="mt-n3 mb-5">
              <small class="cabin-font text-muted">Today • <?php echo date_format(date_create($activity->activityCreated),"H:i"); ?></small>
            </div>
          <?php endif; ?>
          <?php if(date("Ymd", strtotime(date("Ymd", strtotime(date("Ymd"))) . "-1 week")) <= date('Ymd', strtotime($activity->activityCreated)) && date('Ymd') > date('Ymd', strtotime($activity->activityCreated))) : ?>
            <?php if($weekCounter == 0) : ?>
              <h3 class="text-muted text-right mb-4 cabin-font">In the past week</h3>
            <?php endif; ?>
            <?php $weekCounter += 1; ?>
            <div class="d-flex justify-content-between cabin-font">
              <?php if($activity->deletedAccount) : ?>
                <p class="text-center cabin-font"><i class="fa fa-user-circle text-muted" style="font-size:1.4em;"></i> &nbsp; <?php echo $activity->user; ?> starred <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->postUserId; ?>"><?php echo $activity->postUserName; ?>'s</a> Shout</p>
              <?php elseif($activity->user_id == $_SESSION['user_id'] && $activity->postUserId == $_SESSION['user_id']) : ?>
                <p class="text-center cabin-font">You starred your own Shout</p>
              <?php elseif($activity->user_id == $_SESSION['user_id']) : ?>
                <p class="text-center cabin-font">You starred <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->postUserId; ?>"><?php echo $activity->postUserName; ?>'s</a> Shout</p>
              <?php elseif($activity->postUserId == $_SESSION['user_id']) : ?>
                <p class="text-center cabin-font"><a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->user; ?></a> starred your Shout</p>
              <?php else : ?>
                <?php if($activity->img) : ?>
                  <div class="row">
                    <div class="rounded-circle border border-<?php echo $activity->colour; ?>" style="height:1.4em;width:1.4em;overflow:hidden;border-width:.1em !important;background-image:url(<?php echo $activity->img; ?>);background-size:2em;background-position:50% 50%;background-repeat:no-repeat;"></div>
                    <p class="cabin-font"> &nbsp; &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->user; ?></a> starred <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->postUserId; ?>"><?php echo $activity->postUserName; ?>'s</a> Shout</p>
                  </div>
                <?php else : ?>
                  <p class="text-center cabin-font"><i class="fa fa-user-circle text-<?php echo $activity->colour; ?>" style="font-size:1.4em;"></i> &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->user; ?></a> starred <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->postUserId; ?>"><?php echo $activity->postUserName; ?>'s</a> Shout</p>
                <?php endif; ?>
              <?php endif; ?>
              <a href="<?php echo URLROOT; ?>/posts/show/<?php echo $activity->post_id; ?>" class="btn btn-light pull-right cabin-font">
                View
              </a>
            </div>
            <div class="mt-n3 mb-5">
              <small class="cabin-font text-muted"><?php echo date_format(date_create($activity->activityCreated),"d M Y • H:i"); ?></small>
            </div>
          <?php endif; ?>
          <?php if(date("Ymd", strtotime(date("Ymd", strtotime(date("Ymd"))) . "-1 month")) <= date('Ymd', strtotime($activity->activityCreated)) && date("Ymd", strtotime(date("Ymd", strtotime(date("Ymd"))) . "-1 week")) > date('Ymd', strtotime($activity->activityCreated))) : ?>
            <?php if($monthCounter == 0) : ?>
              <h3 class="text-muted text-right mb-4 cabin-font">Past month</h3>
            <?php endif; ?>
            <?php $monthCounter += 1; ?>
            <div class="d-flex justify-content-between cabin-font">
              <?php if($activity->deletedAccount) : ?>
                <p class="text-center cabin-font"><i class="fa fa-user-circle text-muted" style="font-size:1.4em;"></i> &nbsp; <?php echo $activity->user; ?> starred <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->postUserId; ?>"><?php echo $activity->postUserName; ?>'s</a> Shout</p>
              <?php elseif($activity->user_id == $_SESSION['user_id'] && $activity->postUserId == $_SESSION['user_id']) : ?>
                <p class="text-center cabin-font">You starred your own Shout</p>
              <?php elseif($activity->user_id == $_SESSION['user_id']) : ?>
                <p class="text-center cabin-font">You starred <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->postUserId; ?>"><?php echo $activity->postUserName; ?>'s</a> Shout</p>
              <?php elseif($activity->postUserId == $_SESSION['user_id']) : ?>
                <p class="text-center cabin-font"><a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->user; ?></a> starred your Shout</p>
              <?php else : ?>
                <?php if($activity->img) : ?>
                  <div class="row">
                    <div class="rounded-circle border border-<?php echo $activity->colour; ?>" style="height:1.4em;width:1.4em;overflow:hidden;border-width:.1em !important;background-image:url(<?php echo $activity->img; ?>);background-size:2em;background-position:50% 50%;background-repeat:no-repeat;"></div>
                    <p class=" cabin-font"> &nbsp; &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->user; ?></a> starred <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->postUserId; ?>"><?php echo $activity->postUserName; ?>'s</a> Shout</p>
                  </div>
                <?php else : ?>
                  <p class="text-center cabin-font"><i class="fa fa-user-circle text-<?php echo $activity->colour; ?>" style="font-size:1.4em;"></i> &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->user; ?></a> starred <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->postUserId; ?>"><?php echo $activity->postUserName; ?>'s</a> Shout</p>
                <?php endif; ?>
              <?php endif; ?>
              <a href="<?php echo URLROOT; ?>/posts/show/<?php echo $activity->post_id; ?>" class="btn btn-light pull-right cabin-font">
                View
              </a>
            </div>
            <div class="mt-n3 mb-5">
              <small class="cabin-font text-muted"><?php echo date_format(date_create($activity->activityCreated),"d M Y • H:i"); ?></small>
            </div>
          <?php endif; ?>
          <?php if(date("Ymd", strtotime(date("Ymd", strtotime(date("Ymd"))) . "-1 month")) > date('Ymd', strtotime($activity->activityCreated))) : ?>
            <?php if($olderCounter == 0) : ?>
              <h3 class="text-muted text-right mb-4 cabin-font">Older</h3>
            <?php endif; ?>
            <?php $olderCounter += 1; ?>
            <div class="d-flex justify-content-between cabin-font">
              <?php if($activity->deletedAccount) : ?>
                <p class="text-center cabin-font"><i class="fa fa-user-circle text-muted" style="font-size:1.4em;"></i> &nbsp; <?php echo $activity->user; ?> starred <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->postUserId; ?>"><?php echo $activity->postUserName; ?>'s</a> Shout</p>
              <?php elseif($activity->user_id == $_SESSION['user_id'] && $activity->postUserId == $_SESSION['user_id']) : ?>
                <p class="text-center cabin-font">You starred your own Shout</p>
              <?php elseif($activity->user_id == $_SESSION['user_id']) : ?>
                <p class="text-center cabin-font">You starred <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->postUserId; ?>"><?php echo $activity->postUserName; ?>'s</a> Shout</p>
              <?php elseif($activity->postUserId == $_SESSION['user_id']) : ?>
                <p class="text-center cabin-font"><a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->user; ?></a> starred your Shout</p>
              <?php else : ?>
                <?php if($activity->img) : ?>
                  <div class="row">
                    <div class="rounded-circle border border-<?php echo $activity->colour; ?>" style="height:1.4em;width:1.4em;overflow:hidden;border-width:.1em !important;background-image:url(<?php echo $activity->img; ?>);background-size:2em;background-position:50% 50%;background-repeat:no-repeat;"></div>
                    <p class="cabin-font"> &nbsp; &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->user; ?></a> starred <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->postUserId; ?>"><?php echo $activity->postUserName; ?>'s</a> Shout</p>
                  </div>
                <?php else : ?>
                  <p class="text-center cabin-font"><i class="fa fa-user-circle text-<?php echo $activity->colour; ?>" style="font-size:1.4em;"></i> &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->user; ?></a> starred <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->postUserId; ?>"><?php echo $activity->postUserName; ?>'s</a> Shout</p>
                <?php endif; ?>
              <?php endif; ?>
              <a href="<?php echo URLROOT; ?>/posts/show/<?php echo $activity->post_id; ?>" class="btn btn-light pull-right cabin-font">
                View
              </a>
            </div>
            <div class="mt-n3 mb-5">
              <small class="cabin-font text-muted"><?php echo date_format(date_create($activity->activityCreated),"d M Y • H:i"); ?></small>
            </div>
          <?php endif; ?>
        <?php endif; ?>
      <?php elseif($activity->pointer == 'REMOVE') : ?>
        <?php if($activity->notify_user) : ?>
          <?php if(date('Ymd', strtotime($activity->activityCreated)) >= date('Ymd', strtotime($data['joined']))) : ?>
            <?php if(date('Ymd') == date('Ymd', strtotime($activity->activityCreated))) : ?>
              <?php if($dayCounter == 0) : ?>
                <h3 class="text-muted text-right mb-4 cabin-font">Today</h3>
              <?php endif; ?>
              <?php $dayCounter += 1; ?>
              <div class="container cabin-font">
                <?php if($activity->user_id != $_SESSION['user_id']) : ?>
                  <?php if($activity->deletedAccount && $activity->deletedRemoverAccount) : ?>
                    <p class="text-center text-muted m-5 cabin-font"><i class="fa fa-user-circle text-muted" style="font-size:1.4em;"></i> &nbsp; <?php echo $activity->remover_name; ?> removed <?php echo $activity->user; ?> from <?php echo $activity->hub; ?>Hub</p>
                  <?php elseif($activity->deletedAccount) : ?>
                    <?php if($activity->removerImg) : ?>
                      <div class="d-flex justify-content-center m-5">
                        <div class="rounded-circle border border-<?php echo $activity->removerColour; ?>" style="height:1.4em;width:1.4em;overflow:hidden;border-width:.1em !important;background-image:url(<?php echo $activity->removerImg; ?>);background-size:2em;background-position:50% 50%;background-repeat:no-repeat;"></div>
                        <p class="text-muted cabin-font"> &nbsp; &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->remover_id; ?>"><?php echo $activity->remover_name; ?></a> removed <?php echo $activity->user; ?> from <?php echo $activity->hub; ?>Hub</p>
                      </div>
                    <?php else : ?>
                      <p class="text-center text-muted m-5 cabin-font"><i class="fa fa-user-circle text-<?php echo $activity->removerColour; ?>" style="font-size:1.4em;"></i> &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->remover_id; ?>"><?php echo $activity->remover_name; ?></a> removed <?php echo $activity->user; ?> from <?php echo $activity->hub; ?>Hub</p>
                    <?php endif; ?>
                  <?php elseif($activity->deletedRemoverAccount) : ?>
                    <p class="text-center text-muted m-5 cabin-font"><i class="fa fa-user-circle text-muted" style="font-size:1.4em;"></i> &nbsp; <?php echo $activity->remover_name; ?> removed <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->user; ?></a> from <?php echo $activity->hub; ?>Hub</p>
                  <?php elseif($activity->remover_id == $_SESSION['user_id']) : ?>
                    <p class="text-center text-muted m-5 cabin-font">You removed <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->user; ?></a> from <?php echo $activity->hub; ?>Hub</p>
                  <?php else : ?>
                    <?php if($activity->removerImg) : ?>
                      <div class="d-flex justify-content-center m-5">
                        <div class="rounded-circle border border-<?php echo $activity->removerColour; ?>" style="height:1.4em;width:1.4em;overflow:hidden;border-width:.1em !important;background-image:url(<?php echo $activity->removerImg; ?>);background-size:2em;background-position:50% 50%;background-repeat:no-repeat;"></div>
                        <p class="text-muted cabin-font"> &nbsp; &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->remover_id; ?>"><?php echo $activity->remover_name; ?></a> removed <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->user; ?></a> from <?php echo $activity->hub; ?>Hub</p>
                      </div>
                    <?php else : ?>
                      <p class="text-center text-muted m-5 cabin-font"><i class="fa fa-user-circle text-<?php echo $activity->removerColour; ?>" style="font-size:1.4em;"></i> &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->remover_id; ?>"><?php echo $activity->remover_name; ?></a> removed <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->user; ?></a> from <?php echo $activity->hub; ?>Hub</p>
                    <?php endif; ?>
                  <?php endif; ?>
                <?php endif; ?>
              </div>
            <?php endif; ?>
            <?php if(date("Ymd", strtotime(date("Ymd", strtotime(date("Ymd"))) . "-1 week")) <= date('Ymd', strtotime($activity->activityCreated)) && date('Ymd') > date('Ymd', strtotime($activity->activityCreated))) : ?>
              <?php if($weekCounter == 0) : ?>
                <h3 class="text-muted text-right mb-4 cabin-font">In the past week</h3>
              <?php endif; ?>
              <?php $weekCounter += 1; ?>
              <div class="container cabin-font">
                <?php if($activity->user_id != $_SESSION['user_id']) : ?>
                  <?php if($activity->deletedAccount && $activity->deletedRemoverAccount) : ?>
                    <p class="text-center text-muted m-5 cabin-font"><i class="fa fa-user-circle text-muted" style="font-size:1.4em;"></i> &nbsp; <?php echo $activity->remover_name; ?> removed <?php echo $activity->user; ?> from <?php echo $activity->hub; ?>Hub</p>
                  <?php elseif($activity->deletedAccount) : ?>
                    <?php if($activity->removerImg) : ?>
                      <div class="d-flex justify-content-center m-5">
                        <div class="rounded-circle border border-<?php echo $activity->removerColour; ?>" style="height:1.4em;width:1.4em;overflow:hidden;border-width:.1em !important;background-image:url(<?php echo $activity->removerImg; ?>);background-size:2em;background-position:50% 50%;background-repeat:no-repeat;"></div>
                        <p class="text-muted cabin-font"> &nbsp; &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->remover_id; ?>"><?php echo $activity->remover_name; ?></a> removed <?php echo $activity->user; ?> from <?php echo $activity->hub; ?>Hub</p>
                      </div>
                    <?php else : ?>
                      <p class="text-center text-muted m-5 cabin-font"><i class="fa fa-user-circle text-<?php echo $activity->removerColour; ?>" style="font-size:1.4em;"></i> &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->remover_id; ?>"><?php echo $activity->remover_name; ?></a> removed <?php echo $activity->user; ?> from <?php echo $activity->hub; ?>Hub</p>
                    <?php endif; ?>
                  <?php elseif($activity->deletedRemoverAccount) : ?>
                    <p class="text-center text-muted m-5 cabin-font"><i class="fa fa-user-circle text-muted" style="font-size:1.4em;"></i> &nbsp; <?php echo $activity->remover_name; ?> removed <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->user; ?></a> from <?php echo $activity->hub; ?>Hub</p>
                  <?php elseif($activity->remover_id == $_SESSION['user_id']) : ?>
                    <p class="text-center text-muted m-5 cabin-font">You removed <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->user; ?></a> from <?php echo $activity->hub; ?>Hub</p>
                  <?php else : ?>
                    <?php if($activity->removerImg) : ?>
                      <div class="d-flex justify-content-center m-5">
                        <div class="rounded-circle border border-<?php echo $activity->removerColour; ?>" style="height:1.4em;width:1.4em;overflow:hidden;border-width:.1em !important;background-image:url(<?php echo $activity->removerImg; ?>);background-size:2em;background-position:50% 50%;background-repeat:no-repeat;"></div>
                        <p class="text-muted cabin-font"> &nbsp; &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->remover_id; ?>"><?php echo $activity->remover_name; ?></a> removed <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->user; ?></a> from <?php echo $activity->hub; ?>Hub</p>
                      </div>
                    <?php else : ?>
                      <p class="text-center text-muted m-5 cabin-font"><i class="fa fa-user-circle text-<?php echo $activity->removerColour; ?>" style="font-size:1.4em;"></i> &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->remover_id; ?>"><?php echo $activity->remover_name; ?></a> removed <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->user; ?></a> from <?php echo $activity->hub; ?>Hub</p>
                    <?php endif; ?>
                  <?php endif; ?>
                <?php endif; ?>
              </div>
            <?php endif; ?>
            <?php if(date("Ymd", strtotime(date("Ymd", strtotime(date("Ymd"))) . "-1 month")) <= date('Ymd', strtotime($activity->activityCreated)) && date("Ymd", strtotime(date("Ymd", strtotime(date("Ymd"))) . "-1 week")) > date('Ymd', strtotime($activity->activityCreated))) : ?>
              <?php if($monthCounter == 0) : ?>
                <h3 class="text-muted text-right mb-4 cabin-font">Past month</h3>
              <?php endif; ?>
              <?php $monthCounter += 1; ?>
              <div class="container cabin-font">
                <?php if($activity->user_id != $_SESSION['user_id']) : ?>
                  <?php if($activity->deletedAccount && $activity->deletedRemoverAccount) : ?>
                    <p class="text-center text-muted m-5 cabin-font"><i class="fa fa-user-circle text-muted" style="font-size:1.4em;"></i> &nbsp; <?php echo $activity->remover_name; ?> removed <?php echo $activity->user; ?> from <?php echo $activity->hub; ?>Hub</p>
                  <?php elseif($activity->deletedAccount) : ?>
                    <?php if($activity->removerImg) : ?>
                      <div class="d-flex justify-content-center m-5">
                        <div class="rounded-circle border border-<?php echo $activity->removerColour; ?>" style="height:1.4em;width:1.4em;overflow:hidden;border-width:.1em !important;background-image:url(<?php echo $activity->removerImg; ?>);background-size:2em;background-position:50% 50%;background-repeat:no-repeat;"></div>
                        <p class="text-muted cabin-font"> &nbsp; &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->remover_id; ?>"><?php echo $activity->remover_name; ?></a> removed <?php echo $activity->user; ?> from <?php echo $activity->hub; ?>Hub</p>
                      </div>
                    <?php else : ?>
                      <p class="text-center text-muted m-5 cabin-font"><i class="fa fa-user-circle text-<?php echo $activity->removerColour; ?>" style="font-size:1.4em;"></i> &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->remover_id; ?>"><?php echo $activity->remover_name; ?></a> removed <?php echo $activity->user; ?> from <?php echo $activity->hub; ?>Hub</p>
                    <?php endif; ?>
                  <?php elseif($activity->deletedRemoverAccount) : ?>
                    <p class="text-center text-muted m-5 cabin-font"><i class="fa fa-user-circle text-muted" style="font-size:1.4em;"></i> &nbsp; <?php echo $activity->remover_name; ?> removed <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->user; ?></a> from <?php echo $activity->hub; ?>Hub</p>
                  <?php elseif($activity->remover_id == $_SESSION['user_id']) : ?>
                    <p class="text-center text-muted m-5 cabin-font">You removed <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->user; ?></a> from <?php echo $activity->hub; ?>Hub</p>
                  <?php else : ?>
                    <?php if($activity->removerImg) : ?>
                      <div class="d-flex justify-content-center m-5">
                        <div class="rounded-circle border border-<?php echo $activity->removerColour; ?>" style="height:1.4em;width:1.4em;overflow:hidden;border-width:.1em !important;background-image:url(<?php echo $activity->removerImg; ?>);background-size:2em;background-position:50% 50%;background-repeat:no-repeat;"></div>
                        <p class="text-muted cabin-font"> &nbsp; &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->remover_id; ?>"><?php echo $activity->remover_name; ?></a> removed <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->user; ?></a> from <?php echo $activity->hub; ?>Hub</p>
                      </div>
                    <?php else : ?>
                      <p class="text-center text-muted m-5 cabin-font"><i class="fa fa-user-circle text-<?php echo $activity->removerColour; ?>" style="font-size:1.4em;"></i> &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->remover_id; ?>"><?php echo $activity->remover_name; ?></a> removed <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->user; ?></a> from <?php echo $activity->hub; ?>Hub</p>
                    <?php endif; ?>
                  <?php endif; ?>
                <?php endif; ?>
              </div>
            <?php endif; ?>
            <?php if(date("Ymd", strtotime(date("Ymd", strtotime(date("Ymd"))) . "-1 month")) > date('Ymd', strtotime($activity->activityCreated))) : ?>
              <?php if($olderCounter == 0) : ?>
                <h3 class="text-muted text-right mb-4 cabin-font">Older</h3>
              <?php endif; ?>
              <?php $olderCounter += 1; ?>
              <div class="container cabin-font">
                <?php if($activity->user_id != $_SESSION['user_id']) : ?>
                  <?php if($activity->deletedAccount && $activity->deletedRemoverAccount) : ?>
                    <p class="text-center text-muted m-5 cabin-font"><i class="fa fa-user-circle text-muted" style="font-size:1.4em;"></i> &nbsp; <?php echo $activity->remover_name; ?> removed <?php echo $activity->user; ?> from <?php echo $activity->hub; ?>Hub</p>
                  <?php elseif($activity->deletedAccount) : ?>
                    <?php if($activity->removerImg) : ?>
                      <div class="d-flex justify-content-center m-5">
                        <div class="rounded-circle border border-<?php echo $activity->removerColour; ?>" style="height:1.4em;width:1.4em;overflow:hidden;border-width:.1em !important;background-image:url(<?php echo $activity->removerImg; ?>);background-size:2em;background-position:50% 50%;background-repeat:no-repeat;"></div>
                        <p class="text-muted cabin-font"> &nbsp; &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->remover_id; ?>"><?php echo $activity->remover_name; ?></a> removed <?php echo $activity->user; ?> from <?php echo $activity->hub; ?>Hub</p>
                      </div>
                    <?php else : ?>
                      <p class="text-center text-muted m-5 cabin-font"><i class="fa fa-user-circle text-<?php echo $activity->removerColour; ?>" style="font-size:1.4em;"></i> &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->remover_id; ?>"><?php echo $activity->remover_name; ?></a> removed <?php echo $activity->user; ?> from <?php echo $activity->hub; ?>Hub</p>
                    <?php endif; ?>
                  <?php elseif($activity->deletedRemoverAccount) : ?>
                    <p class="text-center text-muted m-5 cabin-font"><i class="fa fa-user-circle text-muted" style="font-size:1.4em;"></i> &nbsp; <?php echo $activity->remover_name; ?> removed <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->user; ?></a> from <?php echo $activity->hub; ?>Hub</p>
                  <?php elseif($activity->remover_id == $_SESSION['user_id']) : ?>
                    <p class="text-center text-muted m-5 cabin-font">You removed <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->user; ?></a> from <?php echo $activity->hub; ?>Hub</p>
                  <?php else : ?>
                    <?php if($activity->removerImg) : ?>
                      <div class="d-flex justify-content-center m-5">
                        <div class="rounded-circle border border-<?php echo $activity->removerColour; ?>" style="height:1.4em;width:1.4em;overflow:hidden;border-width:.1em !important;background-image:url(<?php echo $activity->removerImg; ?>);background-size:2em;background-position:50% 50%;background-repeat:no-repeat;"></div>
                        <p class="text-muted cabin-font"> &nbsp; &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->remover_id; ?>"><?php echo $activity->remover_name; ?></a> removed <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->user; ?></a> from <?php echo $activity->hub; ?>Hub</p>
                      </div>
                    <?php else : ?>
                      <p class="text-center text-muted m-5 cabin-font"><i class="fa fa-user-circle text-<?php echo $activity->removerColour; ?>" style="font-size:1.4em;"></i> &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->remover_id; ?>"><?php echo $activity->remover_name; ?></a> removed <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $activity->user_id; ?>"><?php echo $activity->user; ?></a> from <?php echo $activity->hub; ?>Hub</p>
                    <?php endif; ?>
                  <?php endif; ?>
                <?php endif; ?>
              </div>
            <?php endif; ?>
          <?php endif; ?>
        <?php endif; ?>
      <?php endif; ?>
    <?php endforeach; ?>
  <?php endif; ?>
  <div class="container">
    <p class="text-center text-muted m-5 cabin-font"><i class="fa fa-home"></i> &nbsp; You joined <?php echo $_SESSION['user_hub']; ?>Hub on <?php echo date_format(date_create($data['joined']),"d M Y"); ?></p>
  </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
