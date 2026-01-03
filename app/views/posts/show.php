<!-- metadata -->
<?php $pageTitle = $data['user']->name . "'s Shout"; ?>
<?php $pageDesc = "Shouts Show Description"; ?>
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
  <span class="cabin-font"><?php flash('success_message'); ?></span>
  <!-- stars modal -->
  <div class="modal fade" id="starsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog cabin-font" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Starred By</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <?php if($data['star_list']) : ?>
            <?php foreach($data['star_list'] as $star) : ?>
              <?php if($star->img) : ?>
                <div class="row mb-2">
                  <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $star->user_id; ?>">
                    <div class="rounded-circle border ml-3 border-<?php echo $star->colour; ?>" style="height:1.8em;width:1.8em;overflow:hidden;border-width:.1em !important;background-image:url(<?php echo $star->img; ?>);background-size:2.6em;background-position:50% 50%;background-repeat:no-repeat;"></div>
                  </a>
                  <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $star->user_id; ?>">
                    <p class="text-decoration-none text-hub-dark-purple ml-2"><?php echo $star->user_name; ?></p>
                  </a>
                </div>
              <?php else : ?>
                <div class="row mb-2">
                  <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $data['user']->id; ?>">
                    <i class="fa fa-user-circle ml-3 text-<?php echo $star->colour; ?>" style="font-size:1.8em;"></i>
                  </a>
                  <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $star->user_id; ?>">
                    <p class="text-decoration-none text-hub-dark-purple ml-2"><?php echo $star->user_name; ?></p>
                  </a>
                </div>
              <?php endif; ?>
            <?php endforeach; ?>
          <?php else : ?>
            <p class="text-muted">No one has starred this Shout yet</p>
          <?php endif; ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light cabin-font" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <?php if($data['removed_from_hub']) : ?>
    <a data-toggle="modal" data-target="#removedFromHubModal" data-keyboard="false" data-backdrop="static" id="removedModalToggle"></a>
  <?php endif; ?>
  <?php if($data['post']->edited) : ?>
    <div class="d-flex justify-content-end">
      <small class="text-muted">Edited</small>
    </div>
  <?php endif; ?>
  <div class="d-flex m-2">
    <div class="align-itmes-start">
      <h1>
        <?php if($data['user']->img) : ?>
          <div class="row mb-2">
            <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $data['user']->id; ?>">
              <div class="rounded-circle border ml-3 border-<?php echo $data['user']->colour; ?>" style="height:1.8em;width:1.8em;overflow:hidden;border-width:.1em !important;background-image:url(<?php echo $data['user']->img; ?>);background-size:2.6em;background-position:50% 50%;background-repeat:no-repeat;"></div>
            </a>
          </div>
        <?php else : ?>
          <div class="row mb-2">
            <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $data['user']->id; ?>">
              <i class="fa fa-user-circle text-<?php echo $data['user']->colour; ?>" style="font-size:2em;"></i>
            </a>
          </div>
        <?php endif; ?>
      </h1>
    </div>
    <div class="col ml-4">
      <h1>
        <?php echo $data['post']->title; ?>
      </h1>
      <small class="cabin-font text-muted"><?php echo $data['user']->name . " " . $data['user']->last_name; ?> &nbsp; - &nbsp;
        <?php if(date('Ymd', strtotime(date("Ymd", strtotime(date("Ymd"))) . "-1 day")) <= date('Ymd', strtotime($data['post']->created_at))) : ?>
          Today • <?php echo date_format(date_create($data['post']->created_at),"H:i"); ?>
        <?php else : ?>
          <?php echo date_format(date_create($data['post']->created_at),"d M Y • H:i"); ?>
        <?php endif; ?>
      </small>
    </div>
  </div>
  <?php if($data['post']->img) : ?>
    <h1>
      <div class="mt-2" style="height:10em;max-width:12em;margin:auto;overflow:hidden;background-image:url(<?php echo $data['post']->img; ?>);background-size:12.5em;background-position:50% 50%;background-repeat:no-repeat;"></div>
    </h1>
  <?php endif; ?>
  <?php if($data['no_of_stars'] == 1) : ?>
    <div class="d-flex mt-1">
      <form action="<?php echo URLROOT; ?>/posts/show/<?php echo $data['post']->id; ?>" method="post">
        <button type="submit" name="starPostBtn" class="btn ml-n2">
          <?php if($data['starred']) : ?>
            <i class="bi bi-star-fill text-mustard" style="font-size:1.5em;"></i>
          <?php else : ?>
            <i class="bi bi-star text-hub-dark-purple" style="font-size:1.5em;"></i>
          <?php endif; ?>
        </button>
      </form>
    </div>
    <a data-toggle="modal" data-target="#starsModal" href="#" class="text-decoration-none cabin-font first-post-btn text-hub-dark-purple ml-2">
       Starred by <strong><?php echo $data['no_of_stars']; ?> Hubmate</strong>
    </a>
  <?php else : ?>
    <div class="d-flex mt-1">
      <form action="<?php echo URLROOT; ?>/posts/show/<?php echo $data['post']->id; ?>" method="post">
        <button type="submit" name="starPostBtn" class="btn ml-n2">
          <?php if($data['starred']) : ?>
            <i class="bi bi-star-fill text-mustard" style="font-size:1.5em;"></i>
          <?php else : ?>
            <i class="bi bi-star text-hub-dark-purple" style="font-size:1.5em;"></i>
          <?php endif; ?>
        </button>
      </form>
    </div>
    <a data-toggle="modal" data-target="#starsModal" href="#" class="text-decoration-none cabin-font first-post-btn text-hub-dark-purple ml-2">
       Starred by <strong><?php echo $data['no_of_stars']; ?> Hubmates</strong>
    </a>
  <?php endif; ?>
  <?php if($data['comments']) : ?>
    <hr>
    <?php foreach($data['comments'] as $comment) : ?>
      <div class="d-flex m-2">
        <div class="align-itmes-start">
          <h5>
            <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $comment->from_id; ?>">
              <?php if($comment->img) : ?>
                <div class="rounded-circle border border-<?php echo $comment->colour; ?>" style="height:2.6em;width:2.6em;overflow:hidden;border-width:.1em !important;background-image:url(<?php echo $comment->img; ?>);background-size:3.6em;background-position:50% 50%;background-repeat:no-repeat;"></div>
              <?php else : ?>
                <p><i class="fa fa-user-circle text-<?php echo $comment->colour; ?>" style="font-size:2.6em;"></i>
              <?php endif; ?>
            </a>
          </h5>
        </div>
        <div class="col ml-2">
          <h5>
            <a href="<?php echo URLROOT; ?>/users/profile/<?php echo $comment->from_id; ?>" class="text-decoration-none text-hub-dark-purple"><?php echo $comment->from_name; ?></a>
          </h5>
          <p><?php echo $comment->comment; ?></p>
        </div>
      </div>
      <div class="mb-5 mr-2 text-right">
        <small class="text-muted cabin-font"><?php echo $comment->commentCreated; ?></small>
      </div>
    <?php endforeach; ?>
  <?php else : ?>
    <div class="container py-5">
      <h4 class="text-center cabin-font text-muted py-5">Be the first to comment</h4>
    </div>
  <?php endif; ?>
  <form autocomplete="off" action="<?php echo URLROOT; ?>/posts/show/<?php echo $data['post']->id; ?>" method="post" class="mb-3 mt-5">
    <div class="form-group">
      <span class="cabin-font"><?php flash('success_message'); ?></span>
      <div class="input-group">
        <input type="text" name="comment" class="curve-input form-control form-control-lg mb-1 <?php echo (!empty($data['comment_err'])) ? 'is-invalid' : ''; ?>" placeholder="Comment..." style="font-size:1em;">
        <div class="input-group-addon pl-3">
          <button type="submit" name="commentBtn" class="btn btn-success px-3 mb-1">
              <i class="fa fa-paper-plane"></i>
          </button>
        </div>
        <span class="invalid-feedback"><?php echo $data['comment_err']; ?></span>
      </div>
    </div>
  </form>
<?php require APPROOT . '/views/inc/footer.php'; ?>
