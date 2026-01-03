<!-- metadata -->
<?php $pageTitle = "Shouts"; ?>
<?php $pageDesc = "Shouts Description"; ?>
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
          <label for="uploadEditPhoto" class="text-secondary pointer m-2" style="cursor:pointer;"><h4><i class="bi bi-camera"></i></h4></label>
          <input type="file" name="shoutEditImg" id="uploadEditPhoto" style="opacity:0;position:absolute;z-index:-1;">
        </div>
        <div class="modal-footer d-flex justify-content-between">
          <div class="row">
            <form autocomplete="off" id="updatePost" action="<?php echo URLROOT; ?>/posts/index" method="post">
              <input type="hidden" name="post-id" value="">
              <textarea name="post-edit-b64-img" class="d-none" id="shoutEditB64Img"></textarea>
              <input type="submit" name="updatePostBtn" value="Update" class="btn btn-success">
            </form>
            <form action="<?php echo URLROOT; ?>/posts/index" method="post">
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
  <h1 class="mt-3 poppins-font text-hub-grape"><?php echo $_SESSION['user_hub']; ?><wbr><span class="text-lilac">Hub</span></h1>
  <form autocomplete="off" action="<?php echo URLROOT; ?>/posts/index" method="post">
    <div class="mt-4 d-flex justify-content-start">
      <p class="text-danger mr-1 mt-n3" id="shoutImgCancelBtn" style="visibility:hidden;cursor:pointer;"><a onclick="clearShoutImg()"><strong><i class="fa fa-times-circle text-danger"></i></strong></a></p>
      <div id="uploadedShoutImg" class="mb-5 img-holder"></div>
    </div>
    <div class="form-group">
      <div class="input-group">
        <input type="text" name="title" class="mt-2 curve-input form-control form-control-lg <?php echo (!empty($data['title_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['title']; ?>" placeholder="Shout about it..." style="font-size:1em;">
        <div class="input-group-addon pl-3">
          <button type="submit" name="shoutBtn" class="btn btn-success px-3 mt-2">
              <i class="fa fa-paper-plane"></i>
          </button>
        </div>
        <span class="invalid-feedback"><?php echo $data['title_err']; ?></span>
      </div>
    </div>
    <div class="d-flex justify-content-between mb-3">
      <div class="row ml-3">
        <label for="uploadPhoto" class="text-secondary pointer" style="cursor:pointer;"><h4><i class="bi bi-camera"></i></h4></label>
      </div>
      <input type="file" name="shoutImg" id="uploadPhoto" style="opacity:0;position:absolute;z-index:-1;">
      <textarea name="shout_b64_img" class="d-none" id="shoutB64Img"></textarea>
    </div>
  </form>
  <span class="cabin-font"><?php flash('success_message'); ?></span>
  <?php if($data['posts']) : ?>
    <div class="row mb-3">
      <div class="col-md-6">
        <h2 class="cabin-font text-hub-dark-purple">Shouts</h2>
      </div>
      <div class="col-md-6">
        <!-- placeholder -->
      </div>
    </div>
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
            <?php if($post->profileImg) : ?>
              <div class="row">
                <div class="rounded-circle profile-img-sm border ml-3 border-<?php echo $post->colour; ?>" style="height:1.1em;width:1.1em;overflow:hidden;border-width:.1em !important;background-image:url(<?php echo $post->profileImg; ?>);background-size:1.5em;background-position:50% 50%;background-repeat:no-repeat;"></div>
                &nbsp; &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $post->user_id; ?>" class="text-decoration-none cabin-font text-hub-dark-purple"><?php echo $post->name . " " . $post->last_name; ?></a>
              </div>
            <?php else : ?>
              <i class="fa fa-user-circle text-<?php echo $post->colour; ?>"></i> &nbsp; <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $post->user_id; ?>" class="text-decoration-none cabin-font text-hub-dark-purple"><?php echo $post->name . " " . $post->last_name; ?></a>
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
    <div class="container py-5">
      <h4 class="text-center cabin-font text-muted py-5">It's quiet in here, no ones shouted in <?php echo $_SESSION['user_hub']; ?>Hub yet</h4>
    </div>
  <?php endif; ?>
<?php require APPROOT . '/views/inc/footer.php'; ?>
