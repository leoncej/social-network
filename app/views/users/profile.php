<!-- metadata -->
<?php $pageTitle = $data['user']->name . " " . $data['user']->last_name; ?>
<?php $pageDesc = "User Profile Description"; ?>
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
<!-- profile image modal -->
<div class="modal fade" id="profileImgModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog cabin-font" role="document">
    <div class="modal-content">
      <button type="button" class="close text-right m-3" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <div class="modal-body">
        <img src="<?php echo $data['user']->img; ?>" style="max-height:30em;width:100%;">
      </div>
    </div>
  </div>
</div>
  <!-- remove modal -->
  <div class="modal fade" id="removeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog cabin-font" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Are you sure?</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>This action will remove <?php echo $data['user']->name . " " . $data['user']->last_name; ?> from <?php echo $_SESSION['user_hub']; ?>Hub.</p>
          <p><?php echo $data['user']->name . " " . $data['user']->last_name; ?> will not know you have removed them from this Hub however all other <?php echo $_SESSION['user_hub']; ?>Hub Hubmates will be notified.</p>
          <br>
          <small>Note: This will not remove <?php echo $data['user']->name . " " . $data['user']->last_name; ?> from any other Hubs they may be in with you.</small>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light cabin-font" data-dismiss="modal">Cancel</button>
          <form action="<?php echo URLROOT; ?>/users/profile/<?php echo $data['user']->id; ?>" method="post">
            <input type="submit" class="btn text-danger cabin-font" name="removeHubmateBtn" value="Remove">
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- stars modal -->
  <?php if($data['posts']) : ?>
    <?php $indexPostsUniqueCounter = 0; ?>
    <?php foreach($data['posts'] as $post) : ?>
      <?php $indexPostsUniqueCounter += 1; ?>
      <div class="modal fade" id="starsIndexModal<?php echo $indexPostsUniqueCounter; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog cabin-font" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Starred By</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div id="withoutNewStar<?php echo $indexPostsUniqueCounter; ?>">
                <?php if(isset($post->starredUser)) : ?>
                  <?php foreach($post->starredUser as $starUser) : ?>
                    <div class='row mb-2'>
                      <?php if($starUser->img) : ?>
                        <a href='<?php echo URLROOT; ?>/users/profile/<?php echo $starUser->id; ?>'>
                          <div class='rounded-circle border ml-3 border-<?php echo $starUser->colour; ?>' style='height:1.8em;width:1.8em;overflow:hidden;border-width:.1em !important;background-image:url(<?php echo $starUser->img; ?>);background-size:2.6em;background-position:50% 50%;background-repeat:no-repeat;'></div>
                        </a>
                      <?php else : ?>
                        <i class='fa fa-user-circle ml-3 text-<?php echo $starUser->colour; ?>' style='font-size:1.8em;'></i>
                      <?php endif; ?>
                      <a href='<?php echo URLROOT; ?>/users/profile/<?php echo $starUser->id; ?>'>
                        <p class='text-decoration-none text-hub-dark-purple ml-2'><?php echo $starUser->name; ?> <?php echo $starUser->last_name; ?></p>
                      </a>
                    </div>
                  <?php endforeach; ?>
                <?php endif; ?>
              </div>
              <div class="d-none" id="withNewStar<?php echo $indexPostsUniqueCounter; ?>">
                <?php if(isset($post->starredUser)) : ?>
                  <?php $userIncluded = 0; ?>
                  <?php foreach($post->starredUser as $starUser) : ?>
                    <?php if($starUser->id == $_SESSION['user_id']) : ?>
                      <?php $userIncluded = 1; ?>
                    <?php endif; ?>
                    <div class='row mb-2'>
                      <?php if($starUser->img) : ?>
                        <a href='<?php echo URLROOT; ?>/users/profile/<?php echo $starUser->id; ?>'>
                          <div class='rounded-circle border ml-3 border-<?php echo $starUser->colour; ?>' style='height:1.8em;width:1.8em;overflow:hidden;border-width:.1em !important;background-image:url(<?php echo $starUser->img; ?>);background-size:2.6em;background-position:50% 50%;background-repeat:no-repeat;'></div>
                        </a>
                      <?php else : ?>
                        <i class='fa fa-user-circle ml-3 text-<?php echo $starUser->colour; ?>' style='font-size:1.8em;'></i>
                      <?php endif; ?>
                      <a href='<?php echo URLROOT; ?>/users/profile/<?php echo $starUser->id; ?>'>
                        <p class='text-decoration-none text-hub-dark-purple ml-2'><?php echo $starUser->name; ?> <?php echo $starUser->last_name; ?></p>
                      </a>
                    </div>
                  <?php endforeach; ?>
                  <?php if(!$userIncluded) : ?>
                    <div class='row mb-2'>
                      <?php if($_SESSION['user_img']) : ?>
                        <a href='<?php echo URLROOT; ?>/users/profile/<?php echo $_SESSION['user_id']; ?>'>
                          <div class='rounded-circle border ml-3 border-<?php echo $_SESSION['user_colour']; ?>' style='height:1.8em;width:1.8em;overflow:hidden;border-width:.1em !important;background-image:url(<?php echo $_SESSION["user_img"]; ?>);background-size:2.6em;background-position:50% 50%;background-repeat:no-repeat;'></div>
                        </a>
                      <?php else : ?>
                        <i class='fa fa-user-circle ml-3 text-<?php echo $_SESSION['user_colour']; ?>' style='font-size:1.8em;'></i>
                      <?php endif; ?>
                      <a href='<?php echo URLROOT; ?>/users/profile/<?php echo $_SESSION['user_id']; ?>'>
                        <p class='text-decoration-none text-hub-dark-purple ml-2'><?php echo $_SESSION['user_name']; ?></p>
                      </a>
                    </div>
                  <?php endif; ?>
                <?php else : ?>
                  <div class='row mb-2'>
                    <?php if($_SESSION['user_img']) : ?>
                      <a href='<?php echo URLROOT; ?>/users/profile/<?php echo $_SESSION['user_id']; ?>'>
                        <div class='rounded-circle border ml-3 border-<?php echo $_SESSION['user_colour']; ?>' style='height:1.8em;width:1.8em;overflow:hidden;border-width:.1em !important;background-image:url(<?php echo $_SESSION["user_img"]; ?>);background-size:2.6em;background-position:50% 50%;background-repeat:no-repeat;'></div>
                      </a>
                    <?php else : ?>
                      <i class='fa fa-user-circle ml-3 text-<?php echo $_SESSION['user_colour']; ?>' style='font-size:1.8em;'></i>
                    <?php endif; ?>
                    <a href='<?php echo URLROOT; ?>/users/profile/<?php echo $_SESSION['user_id']; ?>'>
                      <p class='text-decoration-none text-hub-dark-purple ml-2'><?php echo $_SESSION['user_name']; ?></p>
                    </a>
                  </div>
                <?php endif; ?>
              </div>
              <div class="d-none" id="removeNewStar<?php echo $indexPostsUniqueCounter; ?>">
                <?php if(isset($post->starredUser)) : ?>
                  <?php foreach($post->starredUser as $starUser) : ?>
                    <?php if($starUser->id != $_SESSION['user_id']) : ?>
                      <div class='row mb-2'>
                        <?php if($starUser->img) : ?>
                          <a href='<?php echo URLROOT; ?>/users/profile/<?php echo $starUser->id; ?>'>
                            <div class='rounded-circle border ml-3 border-<?php echo $starUser->colour; ?>' style='height:1.8em;width:1.8em;overflow:hidden;border-width:.1em !important;background-image:url(<?php echo $starUser->img; ?>);background-size:2.6em;background-position:50% 50%;background-repeat:no-repeat;'></div>
                          </a>
                        <?php else : ?>
                          <i class='fa fa-user-circle ml-3 text-<?php echo $starUser->colour; ?>' style='font-size:1.8em;'></i>
                        <?php endif; ?>
                        <a href='<?php echo URLROOT; ?>/users/profile/<?php echo $starUser->id; ?>'>
                          <p class='text-decoration-none text-hub-dark-purple ml-2'><?php echo $starUser->name; ?> <?php echo $starUser->last_name; ?></p>
                        </a>
                      </div>
                    <?php endif; ?>
                  <?php endforeach; ?>
                <?php endif; ?>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-light cabin-font" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
  <!-- edit modal -->
  <div class="modal fade" id="editPostModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog cabin-font" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Shout</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="post-id" value="">
          <div class="d-flex justify-content-start">
            <p class="text-danger mr-1 mt-n3" id="shoutEditImgCancelBtn" style="visibility:hidden;cursor:pointer;"><a onclick="clearShoutEditImg()"><strong><i class="fa fa-times-circle text-danger"></i></strong></a></p>
            <div id="uploadedShoutEditImg" class="mb-2 img-holder"></div>
          </div>
          <input type="text" name="post-title" class="curve-input form-control" value="" form="updatePost" required>
          <label for="uploadPhoto" class="text-secondary pointer m-2" style="cursor:pointer;"><h4><i class="fa fa-camera"></i></h4></label>
          <input type="file" name="shoutEditImg" id="uploadPhoto" style="opacity:0;position:absolute;z-index:-1;">
        </div>
        <div class="modal-footer d-flex justify-content-between">
          <div class="row">
            <form autocomplete="off" id="updatePost" action="<?php echo URLROOT; ?>/users/profile/<?php echo $data['user']->id; ?>" method="post">
              <input type="hidden" name="post-id" value="">
              <textarea name="post-edit-b64-img" class="d-none" id="shoutEditB64Img"></textarea>
              <input type="submit" name="updatePostBtn" value="Update" class="btn btn-success">
            </form>
            <form action="<?php echo URLROOT; ?>/users/profile/<?php echo $data['user']->id; ?>" method="post">
              <input type="hidden" name="post-id" value="">
              <input type="submit" name="deletePostBtn" value="Delete" class="btn text-danger">
            </form>
          </div>
          <button type="button" class="btn btn-light cabin-font" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
  <?php if($data['removed_from_hub']) : ?>
    <a data-toggle="modal" data-target="#removedFromHubModal" data-keyboard="false" data-backdrop="static" id="removedModalToggle"></a>
  <?php endif; ?>
  <span class="cabin-font"><?php flash('success_message'); ?><?php errorFlash('success_message'); ?></span>
  <div class="row mb-3">
    <div class="col-md-6 profile-section">
      <h1 class="mb-0 cabin-font text-hub-dark-purple"><?php echo $data['user']->name . " " . $data['user']->last_name; ?></h1>
      <p class="text-muted cabin-font">
        <?php if($data['user']->status == 'online') : ?>
          <i class="bi bi-house-fill text-success"></i>
        <?php else : ?>
          <i class="bi bi-house-fill text-danger"></i>
        <?php endif; ?>
        &nbsp; Hub ID: <?php echo $data['user']->id; ?>
      </p>
      <?php if($data['user']->img) : ?>
        <a data-toggle="modal" data-target="#profileImgModal" href="#">
          <div class="profile-img-div rounded-circle border border-<?php echo $data['user']->colour; ?>" style="height:10em;width:10em;overflow:hidden;border-width:.3em !important;background-image:url(<?php echo $data['user']->img; ?>);background-size:15em;background-position:50% 50%;background-repeat:no-repeat;"></div>
        </a>
        <?php if($data['user']->stars >= 1000 && $data['user']->stars < 2500) : ?>
          <i class="fa fa-star my-3" style="color:#cd7f32 !important;"></i> &nbsp; <span class="montserrat-font text-bronze">BRONZE ACCOUNT</span>
        <?php elseif($data['user']->stars >= 2500 && $data['user']->stars < 5000) : ?>
          <i class="fa fa-star my-3" style="color:#c0c0c0 !important;"></i> &nbsp; <span class="montserrat-font text-silver">SILVER ACCOUNT</span>
        <?php elseif($data['user']->stars > 5000) : ?>
          <i class="fa fa-star my-3" style="color:#ffd700 !important;"></i> &nbsp; <span class="montserrat-font text-gold">GOLD ACCOUNT</span>
        <?php endif; ?>
      <?php else : ?>
        <div>
          <i class="fa fa-user-circle text-<?php echo $data['user']->colour; ?>" style="font-size: 10em;"></i>
        </div>
        <?php if($data['user']->stars >= 1000 && $data['user']->stars < 2500) : ?>
          <i class="fa fa-star my-3" style="color:#cd7f32 !important;"></i> &nbsp; <span class="montserrat-font text-bronze">BRONZE ACCOUNT</span>
        <?php elseif($data['user']->stars >= 2500 && $data['user']->stars < 5000) : ?>
          <i class="fa fa-star my-3" style="color:#c0c0c0 !important;"></i> &nbsp; <span class="montserrat-font text-silver">SILVER ACCOUNT</span>
        <?php elseif($data['user']->stars > 5000) : ?>
          <i class="fa fa-star my-3" style="color:#ffd700 !important;"></i> &nbsp; <span class="montserrat-font text-gold">GOLD ACCOUNT</span>
        <?php endif; ?>
      <?php endif; ?>
    </div>
    <div class="col-md-6">
      <h3 class="cabin-font text-hub-dark-purple">About</h3>
      <ul class="list-unstyled cabin-font">
        <?php if($data['user']->about) : ?>
          <li>
            <?php echo $data['user']->about; ?>
          </li>
        <?php endif; ?>
        <br>
        <?php if($data['user']->location) : ?>
          <li>
            <?php echo $data['user']->location; ?> &nbsp; <i class="fa fa-map-marker text-muted"></i>
          </li>
        <?php endif; ?>
        <li>
          Been a Hubmate since
          <?php if(date('Ymd', strtotime(date("Ymd", strtotime(date("Ymd"))) . "-1 day")) <= date('Ymd', strtotime($data['user']->created_at))) : ?>
            Today
          <?php else : ?>
            <?php echo date_format(date_create($data['user']->created_at),"d M Y"); ?>
          <?php endif; ?>
          &nbsp; <i class="fa fa-birthday-cake text-muted"></i>
        </li>
        <li>
          <?php if($data['mates_bool'] == true  || $_SESSION['user_id'] == $data['user']->id) : ?>
            <a href="<?php echo URLROOT; ?>/users/search">Hubmates (<?php echo $data['no_of_mates']; ?>)</a>
          <?php endif; ?>
        </li>
      </ul>
      <?php if($data['mates_bool'] == true && $_SESSION['user_id'] != $data['user']->id) : ?>
        <div class="btn-group dropleft pull-right">
          <button type="button" class="btn btn-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-ellipsis-h text-hub-dark-purple"></i>
          </button>
          <div class="dropdown-menu">
            <h6 class="dropdown-header">Hubmate actions</h6>
            <a data-toggle="modal" data-target="#removeModal" class="dropdown-item" href="#">Remove Hubmate</a>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
  <hr>
  <?php if($data['mates_bool'] == true || $_SESSION['user_id'] == $data['user']->id) : ?>
    <div class="row my-4">
      <div class="col-md-6">
        <?php if($_SESSION['user_id'] == $data['user']->id) : ?>
        <!--
          ability to post from profile page
          <a href="echo URLROOT; /posts/add" class="btn btn-primary cabin-font">
            <i class="fa fa-comment"></i> &nbsp; Shout
          </a>
        -->
        <?php elseif($data['invite_received']) : ?>
          <?php foreach($data['invite_received'] as $invite) : ?>
            <?php if($data['hubLimitReached']) : ?>
              <small class="text-muted cabin-font">You cannot accept this Hub invite as your Hub limit has been reached.</small>
              <div class="row">
                <form action="<?php echo URLROOT; ?>/users/profile/<?php echo $data['user']->id; ?>" method="post" class="mx-3 cabin-font">
                  <input type="submit" value="Accept" name="acceptBtn" class="btn btn-success cabin-font acceptBtnLg" disabled>
                  <!-- <input type="submit" value="&#10004;" name="acceptBtn" class="btn btn-success cabin-font acceptBtnSm d-none" disabled> -->
                  <button type="submit" name="acceptBtn" class="btn btn-success acceptBtnSm d-none" disabled>
                    <i class="fa fa-check"></i>
                  </button>
                  <div class="d-none">
                    <input type="text" name="inviteId" value="<?php echo $invite->inviteId; ?>">
                    <input type="text" name="hubId" value="<?php echo $invite->hubId; ?>">
                    <input type="text" name="hubName" value="<?php echo $invite->hubName; ?>">
                  </div>
                </form>
                <form action="<?php echo URLROOT; ?>/users/profile/<?php echo $data['user']->id; ?>" method="post">
                  <input type="submit" value="Reject" name="rejectBtn" class="btn btn-danger cabin-font rejectBtnLg">
                  <!-- <input type="submit" value="&#10539;" name="rejectBtn" class="btn btn-danger cabin-font rejectBtnSm d-none" disabled> -->
                  <button type="submit" name="rejectBtn" class="btn btn-danger rejectBtnSm d-none" disabled>
                    <i class="fa fa-times"></i>
                  </button>
                  <div class="d-none">
                    <input type="text" name="inviteId" value="<?php echo $invite->inviteId; ?>">
                    <input type="text" name="hubId" value="<?php echo $invite->hubId; ?>">
                    <input type="text" name="hubName" value="<?php echo $invite->hubName; ?>">
                  </div>
                </form>
              </div>
            <?php else : ?>
              <small class="text-muted cabin-font"><?php echo $data['user']->name . " " . $data['user']->last_name; ?> has invited you to join <?php echo $invite->hubName; ?>Hub</small>
              <div class="row">
                <form action="<?php echo URLROOT; ?>/users/profile/<?php echo $data['user']->id; ?>" method="post" class="mx-3 cabin-font">
                  <input type="submit" value="Accept" name="acceptBtn" class="btn btn-success cabin-font acceptBtnLg">
                  <!-- <input type="submit" value="&#10004;" name="acceptBtn" class="btn btn-success cabin-font acceptBtnSm d-none"> -->
                  <button type="submit" name="acceptBtn" class="btn btn-success acceptBtnSm d-none">
                    <i class="fa fa-check"></i>
                  </button>
                  <div class="d-none">
                    <input type="text" name="inviteId" value="<?php echo $invite->inviteId; ?>">
                    <input type="text" name="hubId" value="<?php echo $invite->hubId; ?>">
                    <input type="text" name="hubName" value="<?php echo $invite->hubName; ?>">
                  </div>
                </form>
                <form action="<?php echo URLROOT; ?>/users/profile/<?php echo $data['user']->id; ?>" method="post">
                  <input type="submit" value="Reject" name="rejectBtn" class="btn btn-danger cabin-font rejectBtnLg">
                  <!-- <input type="submit" value="&#10539;" name="rejectBtn" class="btn btn-danger cabin-font rejectBtnSm d-none"> -->
                  <button type="submit" name="rejectBtn" class="btn btn-danger rejectBtnSm d-none">
                    <i class="fa fa-times"></i>
                  </button>
                  <div class="d-none">
                    <input type="text" name="inviteId" value="<?php echo $invite->inviteId; ?>">
                    <input type="text" name="hubId" value="<?php echo $invite->hubId; ?>">
                    <input type="text" name="hubName" value="<?php echo $invite->hubName; ?>">
                  </div>
                </form>
              </div>
            <?php endif; ?>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
      <div class="col-md-6">
        <?php if($_SESSION['user_id'] == $data['user']->id) : ?>
          <a href="<?php echo URLROOT; ?>/users/edit/<?php echo $_SESSION['user_id']; ?>" class="btn btn-light pull-right cabin-font">
            <i class="bi bi-pen text-muted"></i> &nbsp; Edit Profile
          </a>
        <?php else : ?>
          <?php if($data['user']->id > $_SESSION['user_id']) : ?>
            <a href="<?php echo URLROOT; ?>/messages/show/<?php echo $_SESSION['user_id']; ?><?php echo $data['user']->id; ?>" class="btn btn-primary pull-right cabin-font">
              <i class="fa fa-paper-plane px-2"></i>
            </a>
          <?php else : ?>
            <a href="<?php echo URLROOT; ?>/messages/show/<?php echo $data['user']->id; ?><?php echo $_SESSION['user_id']; ?>" class="btn btn-primary pull-right cabin-font">
              <i class="fa fa-paper-plane px-2"></i>
            </a>
          <?php endif; ?>
        <?php endif; ?>
      </div>
    </div>
    <div class="container post-container">
      <?php if($data['posts']) : ?>
        <?php $indexPostsUniqueCounter = 0; ?>
        <?php foreach($data['posts'] as $post) : ?>
          <?php $indexPostsUniqueCounter += 1; ?>
          <div data-aos="fade-up" class="card card-body mb-3">
            <?php if($post->edited) : ?>
              <div class="d-flex justify-content-end">
                <small class="text-muted">Edited</small>
              </div>
            <?php endif; ?>
            <?php if(date('Ymd', strtotime(date("Ymd", strtotime(date("Ymd"))) . "-1 day")) <= date('Ymd', strtotime($post->postCreated))) : ?>
              <p class="text-muted cabin-font shout-timestamp-sm"> Today • <?php echo date_format(date_create($post->postCreated),"H:i"); ?></p>
            <?php else : ?>
              <p class="text-muted cabin-font shout-timestamp-sm"><?php echo date_format(date_create($post->postCreated),"d M • H:i"); ?></p>
            <?php endif; ?>
            <div class="d-flex justify-content-between my-2">
              <h4 class="card-title">
                <?php if($data['user']->img) : ?>
                  <div class="row">
                    <div class="rounded-circle border ml-3 border-<?php echo $data['user']->colour; ?>" style="height:1.1em;width:1.1em;overflow:hidden;border-width:.1em !important;background-image:url(<?php echo $data['user']->img; ?>);background-size:1.25em;background-position:50% 50%;background-repeat:no-repeat;"></div>
                    &nbsp; &nbsp; <span class="text-decoration-none cabin-font text-hub-dark-purple"><?php echo $post->name . " " . $post->last_name; ?></span>
                  </div>
                <?php else : ?>
                  <i class="fa fa-user-circle text-<?php echo $data['user']->colour; ?>"></i> &nbsp; <span class="text-decoration-none cabin-font text-hub-dark-purple"><?php echo $post->name . " " . $post->last_name; ?></span>
                <?php endif; ?>
              </h4>
              <?php if(date('Ymd', strtotime(date("Ymd", strtotime(date("Ymd"))) . "-1 day")) <= date('Ymd', strtotime($post->postCreated))) : ?>
                <p class="text-muted cabin-font shout-timestamp"> Today • <?php echo date_format(date_create($post->postCreated),"H:i"); ?></p>
              <?php else : ?>
                <p class="text-muted cabin-font shout-timestamp"><?php echo date_format(date_create($post->postCreated),"d M • H:i"); ?></p>
              <?php endif; ?>
            </div>
            <?php if($post->postImg) : ?>
              <div class="d-flex align-items-center">
                <div class="post-img-div">
                  <img src="<?php echo $post->postImg; ?>" class="post-img">
                </div>
              </div>
            <?php endif; ?>
            <?php if($post->title) : ?>
              <h5 class="my-3"><?php echo $post->title; ?></h5>
            <?php endif; ?>
            <?php foreach($data['comments'] as $comment) : ?>
              <?php if($comment['post_id'] == $post->postId) : ?>
                <div class="d-flex justify-content-between">
                  <div class="d-flex justify-content-start">
                    <h4 class="mt-n1">
                      <form id="starForm">
                        <input type="hidden" id="postStarUserId" value="<?php echo $_SESSION['user_id']; ?>">
                        <input type="hidden" id="postStarUserName" value="<?php echo $_SESSION['user_name']; ?>">
                        <input type="hidden" id="postStarUserColour" value="<?php echo $_SESSION['user_colour']; ?>">
                        <input type="hidden" id="postStarUserImg" value="<?php echo $_SESSION['user_img']; ?>">
                        <input type="hidden" id="postUserId" value="<?php echo $post->user_id; ?>">
                        <button type="button" class="btn p-0" id="postStarBtn" onclick="starPost(<?php echo $post->postId; ?>, <?php echo $post->postStars; ?>, <?php echo $indexPostsUniqueCounter; ?>)">
                          <?php if($post->starred) : ?>
                            <i class="star-icon bi bi-star-fill text-mustard" style="font-size:1.5em;" id="<?php echo strval($indexPostsUniqueCounter) . "Star"; ?>"></i>
                          <?php else : ?>
                            <i class="star-icon bi bi-star text-hub-dark-purple" style="font-size:1.5em;" id="<?php echo strval($indexPostsUniqueCounter) . "Star"; ?>"></i>
                          <?php endif; ?>
                        </button>
                      </form>
                    </h4>
                    <h4 class="ml-4 comments-icon">
                      <a href="<?php echo URLROOT; ?>/posts/show/<?php echo $post->postId; ?>">
                        <i class="bi bi-chat-text text-facebook"></i>
                      </a>
                    </h4>
                  </div>
                  <?php if($post->user_id == $_SESSION['user_id']) : ?>
                    <h4>
                      <a data-toggle="modal" data-target="#editPostModal" data-post-id="<?php echo $post->postId ?>" data-post-img="<?php echo $post->postImg ?>" data-post-title="<?php echo $post->title ?>" href="#">
                        <i class="bi bi-pencil text-emerald"></i>
                      </a>
                    </h4>
                  <?php endif; ?>
                </div>
                <div class="clearfix mb-3 post-btn-panel">
                  <?php if($post->postStars == 1) : ?>
                    <a data-toggle="modal" data-target="#starsIndexModal<?php echo $indexPostsUniqueCounter; ?>" data-users="<?php print_r($post->starredUser) ?>" data-session-user="" class="text-decoration-none cabin-font text-hub-dark-purple original-star-str" id="<?php echo strval($indexPostsUniqueCounter) . "Original"; ?>" href="#">
                      Starred by <strong><?php echo $post->postStars; ?> Hubmate</strong>
                    </a>
                  <?php elseif($post->postStars > 1) : ?>
                    <a data-toggle="modal" data-target="#starsIndexModal<?php echo $indexPostsUniqueCounter; ?>" data-users="<?php print_r($post->starredUser) ?>" data-session-user="" class="text-decoration-none cabin-font text-hub-dark-purple original-star-str" id="<?php echo strval($indexPostsUniqueCounter) . "Original"; ?>" href="#">
                      Starred by <strong><?php echo $post->postStars; ?> Hubmates</strong>
                    </a>
                  <?php endif; ?>
                  <a data-toggle="modal" data-target="#starsIndexModal<?php echo $indexPostsUniqueCounter; ?>" data-users="<?php print_r($post->starredUser) ?>" class="text-decoration-none cabin-font text-hub-dark-purple d-none" href="#" id="<?php echo strval($indexPostsUniqueCounter) . "String"; ?>">
                  </a>
                </div>
                <?php if($comment['count'] > 3) : ?>
                  <a href="<?php echo URLROOT; ?>/posts/show/<?php echo $post->postId; ?>" class="cabin-font text-muted mb-3 ml-1">
                    View all <?php echo $comment['count']; ?> comments
                  </a>
                <?php endif; ?>
                <?php foreach($comment['comments'] as $comment) : ?>
                  <div class="row mx-1">
                    <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $comment->user_id; ?>" class="text-decoration-none">
                      <h6 class="text-hub-dark-purple"><?php echo $comment->user; ?></h6>
                    </a>
                    <p class="shout-comment-p">&nbsp; <?php echo $comment->comment; ?></p>
                  </div>
                <?php endforeach; ?>
              <?php endif; ?>
            <?php endforeach; ?>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="container">
          <h4 class="text-center text-muted m-5 cabin-font py-5">No Shouts here</h4>
        </div>
      <?php endif; ?>
    </div>
  <?php else : ?>
    <div class="row mb-3">
      <div class="col-md-6">
        <?php if($data['invite_received']) : ?>
          <?php foreach($data['invite_received'] as $invite) : ?>
            <?php if($data['hubLimitReached']) : ?>
              <small class="text-muted">You cannot accept this Hub invite as your Hub limit has been reached.</small>
              <div class="row">
                <form action="<?php echo URLROOT; ?>/users/profile/<?php echo $data['user']->id; ?>" method="post" class="mx-3">
                  <input type="submit" value="Accept" name="acceptBtn" class="btn btn-success cabin-font acceptBtnLg" disabled>
                  <!-- <input type="submit" value="&#10004;" name="acceptBtn" class="btn btn-success cabin-font acceptBtnSm d-none"> -->
                  <button type="submit" name="acceptBtn" class="btn btn-success acceptBtnSm d-none" disabled>
                    <i class="fa fa-check"></i>
                  </button>
                  <div class="d-none">
                    <input type="text" name="inviteId" value="<?php echo $invite->inviteId; ?>">
                    <input type="text" name="hubId" value="<?php echo $invite->hubId; ?>">
                    <input type="text" name="hubName" value="<?php echo $invite->hubName; ?>">
                  </div>
                </form>
                <form action="<?php echo URLROOT; ?>/users/profile/<?php echo $data['user']->id; ?>" method="post">
                  <input type="submit" value="Reject" name="rejectBtn" class="btn btn-danger cabin-font rejectBtnLg">
                  <!-- <input type="submit" value="&#10539;" name="rejectBtn" class="btn btn-danger cabin-font rejectBtnSm d-none"> -->
                  <button type="submit" name="rejectBtn" class="btn btn-danger rejectBtnSm d-none">
                    <i class="fa fa-times"></i>
                  </button>
                  <div class="d-none">
                    <input type="text" name="inviteId" value="<?php echo $invite->inviteId; ?>">
                    <input type="text" name="hubId" value="<?php echo $invite->hubId; ?>">
                    <input type="text" name="hubName" value="<?php echo $invite->hubName; ?>">
                  </div>
                </form>
              </div>
            <?php else : ?>
              <small class="text-muted"><?php echo $data['user']->name . " " . $data['user']->last_name; ?> has invited you to join <?php echo $invite->hubName; ?>Hub</small>
              <div class="row">
                <form action="<?php echo URLROOT; ?>/users/profile/<?php echo $data['user']->id; ?>" method="post" class="mx-3">
                  <input type="submit" value="Accept" name="acceptBtn" class="btn btn-success cabin-font acceptBtnLg">
                  <!-- <input type="submit" value="&#10004;" name="acceptBtn" class="btn btn-success cabin-font acceptBtnSm d-none"> -->
                  <button type="submit" name="acceptBtn" class="btn btn-success acceptBtnSm d-none">
                    <i class="fa fa-check"></i>
                  </button>
                  <div class="d-none">
                    <input type="text" name="inviteId" value="<?php echo $invite->inviteId; ?>">
                    <input type="text" name="hubId" value="<?php echo $invite->hubId; ?>">
                    <input type="text" name="hubName" value="<?php echo $invite->hubName; ?>">
                  </div>
                </form>
                <form action="<?php echo URLROOT; ?>/users/profile/<?php echo $data['user']->id; ?>" method="post">
                  <input type="submit" value="Reject" name="rejectBtn" class="btn btn-danger cabin-font rejectBtnLg">
                  <!-- <input type="submit" value="&#10539;" name="rejectBtn" class="btn btn-danger cabin-font rejectBtnSm d-none"> -->
                  <button type="submit" name="rejectBtn" class="btn btn-danger rejectBtnSm d-none">
                    <i class="fa fa-times"></i>
                  </button>
                  <div class="d-none">
                    <input type="text" name="inviteId" value="<?php echo $invite->inviteId; ?>">
                    <input type="text" name="hubId" value="<?php echo $invite->hubId; ?>">
                    <input type="text" name="hubName" value="<?php echo $invite->hubName; ?>">
                  </div>
                </form>
              </div>
            <?php endif; ?>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
      <?php if($data['invite_received']) : ?>
        <div class="col-md-6 inviteMtNeg">
          <?php if($data['invited']) : ?>
            <form action="<?php echo URLROOT; ?>/users/profile/<?php echo $data['user']->id; ?>" method="post">
              <input type="submit" name="pending" class="btn btn-light pull-right cabin-font" value="Pending...">
              <input type="text" name="to_id" class="d-none" value="<?php echo $data['user']->id; ?>">
              </a>
            </form>
          <?php else : ?>
            <form action="<?php echo URLROOT; ?>/users/profile/<?php echo $data['user']->id; ?>" method="post">
              <input type="submit" name="invite" class="btn btn-primary pull-right cabin-font" value="Invite to Hub">
              <a name="to_id" class="d-none" value="<?php echo $data['user']->id; ?>"></a>
              </a>
            </form>
          <?php endif; ?>
        </div>
      <?php else : ?>
        <div class="col-md-6">
          <?php if($data['invited']) : ?>
            <form action="<?php echo URLROOT; ?>/users/profile/<?php echo $data['user']->id; ?>" method="post">
              <input type="submit" name="pending" class="btn btn-light pull-right cabin-font" value="Pending...">
              <input type="text" name="to_id" class="d-none" value="<?php echo $data['user']->id; ?>">
              </a>
            </form>
          <?php else : ?>
            <form action="<?php echo URLROOT; ?>/users/profile/<?php echo $data['user']->id; ?>" method="post">
              <input type="submit" name="invite" class="btn btn-primary pull-right cabin-font" value="Invite to Hub">
              <a name="to_id" class="d-none" value="<?php echo $data['user']->id; ?>"></a>
              </a>
            </form>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    </div>
    <div class="container">
      <h4 class="text-center text-muted m-5 py-5 cabin-font">Sorry it doesn't seem you and <?php echo $data['user']->name; ?> <?php echo $data['user']->last_name; ?> are Hubmates yet</h4>
    </div>
  <?php endif; ?>
<?php require APPROOT . '/views/inc/footer.php'; ?>
