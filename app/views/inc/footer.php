  </div>
  <?php if(isset($_SESSION['user_id'])) : ?>
    <div class="footer-box-container mt-5">
      <div class="footer-box"></div>
      <div class="footer-box"></div>
      <div class="footer-box"></div>
      <div class="footer-box"></div>
      <div class="footer-box"></div>
      <div class="footer-box"></div>
      <div class="footer-box"></div>
      <div class="footer-box"></div>
      <div class="footer-box"></div>
      <div class="footer-box"></div>
    </div>
  <?php endif; ?>
  <footer class="bg-light absolute-bottom" style="z-index:9999;">
    <div class="container cabin-font text-hub-dark-purple">
      <div class="row">
        <div class="col-sm-8 col-md-7 py-4">
          <p class="mb-0 footer-text"><strong>Looking for something else?</strong></p>
          <ul class="list-unstyled">
            <?php if(isset($_SESSION['user_id'])) : ?>
              <li><a href="<?php echo URLROOT; ?>/pages/settings" class="text-dark footer-text">Settings</a></li>
            <?php else : ?>
              <li><a href="<?php echo URLROOT; ?>/pages/about" class="text-dark footer-text">More about us</a></li>
              <li><a href="<?php echo URLROOT; ?>/pages/help" class="text-dark footer-text">FAQs</a></li>
            <?php endif; ?>
            <li><a href="<?php echo URLROOT; ?>/pages/privacy" class="text-dark footer-text">Privacy Policy</a></li>
            <li><a href="<?php echo URLROOT; ?>/pages/terms" class="text-dark footer-text">Terms of Service</a></li>
          </ul>
        </div>
        <div class="col-sm-4 offset-md-1 py-4">
          <div class="d-flex justify-content-end">
            <p class="mb-1 footer-text">Fancy a chat? Get in touch</p>
          </div class="d-flex justify-content-end">
          <div class="d-flex justify-content-end socials">
            <a href="https://www.facebook.com/" target="_blank" class="text-facebook text-decoration-none fa fa-facebook"></a>
            <a href="https://www.instagram.com/" target="_blank" class="text-instagram text-decoration-none fa fa-instagram pl-3"></a>
            <!-- <a href="https://www.linkedin.com/" target="_blank" class="text-linkedin text-decoration-none fa fa-linkedin pl-3"></a> -->
            <a href="https://www.twitter.com/" target="_blank" class="text-twitter text-decoration-none fa fa-twitter pl-3"></a>
          </div>
          <div class="d-flex justify-content-end mt-5">
            <small>Copyright &copy; <?php echo SITENAME; ?></small>
          </div>
          <div class="d-flex justify-content-end">
            <small>Version: <strong><?php echo APPVERSION; ?> <sup>BETA</sup></strong></small>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  <script src="https://unpkg.com/aos@2.3.0/dist/aos.js"></script>
  <script src="<?php echo URLROOT; ?>/public/js/main.js"></script>
  <script>
    AOS.init();

    // preloader
    const loader = document.querySelector(".loader-container");
    const wrapper = document.querySelector(".wrapper");

    function init() {
      if(loader){
        document.body.style.overflowY = 'hidden';
      }
      setTimeout(() => {
        if(loader){
          loader.style.display = "none";
          loader.style.opacity = 0;
          loader.style.zIndex = -99999;
          document.body.style.overflowY = 'auto';
        }
        if(wrapper){
          setTimeout(() => (wrapper.style.opacity = 1), 50);
        }
      }, 4000);
    }

    init();

    // check for removed modal toggle
    var elementExists = document.getElementById("removedModalToggle");
    if(elementExists){
      document.getElementById('removedModalToggle').click();
    }

    $('#editPostModal').on('hidden.bs.modal', function () {
      document.getElementById('uploadedShoutEditImg').style.display = 'none';
      document.getElementById('shoutEditImgCancelBtn').style.visibility = 'hidden';
    });

    // triggered when modal is about to be shown
    $('#editPostModal').on('show.bs.modal', function(e){
      //get data-id attribute of the clicked element
      var postId = $(e.relatedTarget).data('post-id');
      var postImg = $(e.relatedTarget).data('post-img');
      var postTitle = $(e.relatedTarget).data('post-title');

      // populate modal
      $(e.currentTarget).find('input[name="post-id"]').val(postId);
      $(e.currentTarget).find('textarea[name="post-edit-b64-img"]').val(postImg);
      $(e.currentTarget).find('input[name="post-title"]').val(postTitle);

      if(postImg){
        var img = $('<img>').attr('src', postImg).css({
          'max-height' : '12em'
        });
        document.getElementById('uploadedShoutEditImg').style.display = 'block';
        document.getElementById('shoutEditImgCancelBtn').style.visibility = 'visible';
        $('#uploadedShoutEditImg').html(img);
      }
    });

    // shout edit image
    $("input[name=shoutEditImg]").change(function(){
      if (this.files && this.files[0]){
        var reader = new FileReader();

        reader.onload = function(e){
          var img = $('<img>').attr('src', e.target.result).css({
            'max-height' : '12em'
          });
          document.getElementById('uploadedShoutEditImg').style.display = 'block';
          document.getElementById('uploadedShoutEditImg').innerHTML = '';
          document.getElementById('shoutEditImgCancelBtn').style.visibility = 'visible';
          $('#uploadedShoutEditImg').html(img);

          // will print base64 of img to hidden textbox
          document.getElementById("shoutEditB64Img").value = e.target.result;
        };
        reader.readAsDataURL(this.files[0]);
        $("input[name=shoutEditImg]").val(null);
      }
    });

    function clearShoutEditImg(){
      // need to clear uploadedWhisperImg so the same img can be uploaded
      document.getElementById('uploadedShoutEditImg').style.display = 'none';
      document.getElementById('shoutEditImgCancelBtn').style.visibility = 'hidden';
      document.getElementById("shoutEditB64Img").value = '';
    }

    // scroll to the bottom of the message chain div
    if($('#messageContainer').length > 0){
      $('#messageContainer').scrollTop($('#messageContainer')[0].scrollHeight);
    }
  </script>
</body>
</html>
