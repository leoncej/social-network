<!-- metadata -->
<?php $pageTitle = "FAQs"; ?>
<?php $pageDesc = "Have any questions? They may already have been answered here."; ?>
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
  <h1 class="mt-3 cabin-font text-hub-dark-purple">Frequently Asked Questions</h1>
  <div class="pp-intro mt-5">
    <h4 class="cabin-font">What is <span class="poppins-font text-hub-grape">The<span class="text-lilac">Hub</span></span>?</h4>
    <p>Think social network and group chat combined. TheHub is a service for friends & family to communicate and stay in touch, centered around privacy and safety. With users only being identifiable by a unique ID, as well as Hubs only being entered on invite, TheHub provides you with the perfect platform to be yourself.</p>
  </div>
  <div class="pp-intro mt-5">
    <h4 class="cabin-font">How do I start?</h4>
    <?php if(isset($_SESSION['user_id'])) : ?>
      <p>To begin, all you need is an internet connection. You can visit our registration page and once in, you can then begin to invite Hubmates to your Hub, accept invites to other Hubs, interact and really begin to build your own Hub world</p>
    <?php else: ?>
      <p>To begin, all you need is an internet connection. You can register <a href="<?php echo URLROOT; ?>/users/register">here</a> and once in, you can then begin to invite Hubmates to your Hub, accept invites to other Hubs, interact and really begin to build your own Hub world</p>
    <?php endif; ?>
  </div>
  <div class="pp-intro mt-5">
    <h4 class="cabin-font">What are Hubs?</h4>
    <p>Hubs are exclusive spaces for Hubmates to interact. Only other users within your Hub will be able to view and interact with you (including sending Whispers.) You can create/enter up to 5 Hubs and each will be independant from the other - any Whispers, Shouts or Hub Activity will be visible only for the Hub they were posted or sent in</p>
  </div>
  <div class="pp-intro mt-5">
    <h4 class="cabin-font">Can I easily switch between Hubs?</h4>
    <p>Yes! Once logged in, the Hub you are in will be displayed on the navbar at the top of the page. If you click on this, it will list all available Hubs you are in and it is here that you can easily switch from one to another</p>
  </div>
  <div class="pp-intro mt-5">
    <h4 class="cabin-font">What is a Hubmate?</h4>
    <p>A Hubmate is someone that is in the same Hub as you. In the Hub you and your Hubmate are in, you both will be able to fully interact with one another</p>
  </div>
  <div class="pp-intro mt-5">
    <h4 class="cabin-font">How do I invite my friends to my Hub?</h4>
    <p>To invite someone you know to your Hub you will first have to know their Hub ID. Once you know this, you make sure you are in the Hub you wish to invite them to, go to your 'Hubmates' page and here you will see a search bar to search for Hub ID's</p>
  </div>
  <div class="pp-intro mt-5">
    <h4 class="cabin-font">What does it mean to invite someone to my Hub?</h4>
    <p>Inviting someone to your Hub will allow them to view all of the Hubs Shouts and enable access for them to fully interact with all Hubmates once accepted. An invite is only for the Hub you are in when sending so should you be in multiple Hubs and your new Hubmate accepts the invite, this will only enter them into the one Hub and not any of your others</p>
  </div>
  <div class="pp-intro mt-5">
    <h4 class="cabin-font">What can people see of my profile?</h4>
    <p>Users will only be able to see your name, picture (or Hub icon) and About section of your profile should they not yet be your Hubmate. Any Hubmate will be able to see all of your Shouts and Hub Activity (for that Hub) as well as being able to view, and send, Whispers. Users who are not yet your Hubmate cannot interact with you in any way other than sending you an invite to their Hub</p>
  </div>
  <div class="pp-intro mt-5">
    <h4 class="cabin-font">What is a Shout?</h4>
    <p>You shout when you want to be heard, so Shouts can be seen by everyone in your Hub. Shouts are posts that only your Hubmates can interact with. You can upload an image with your Shout or just post some text. Your Hubmates can Star your Shouts to show their appreciation</p>
  </div>
  <div class="pp-intro mt-5">
    <h4 class="cabin-font">What are Stars?</h4>
    <p>Each Shout can be Starred and they are a way of showing your appreciation for something one of your Hubmates, or yourself, have posted</p>
  </div>
  <div class="pp-intro mt-5">
    <h4 class="cabin-font">What is a Whisper?</h4>
    <p>Whispers are messages between yourself and one other Hubmate. Whispers cannot be seen by any Hubmates other than the receipient and the sender in that Hub. Should you enter another Hub, it will only display Whispers that were sent in this Hub</p>
  </div>
  <div class="pp-intro mt-5">
    <h4 class="cabin-font">What are Bronze, Silver and Gold profiles?</h4>
    <p>When Shouts are Starred, they are counted up so for each Star you get for any of your Shouts (in any Hub), they will be totalled. Should you get 1000 Stars, your account will become a Bronze account, 2500 Stars and your account will be a Silver one and over 5000 Stars and you will have a Gold account</p>
  </div>
  <div class="pp-intro mt-5">
    <h4 class="cabin-font">What happens if I remove someone from one of my Hubs?</h4>
    <p>This person will be removed from your Hub, meaning they will no longer be able to view any Hub Activities such as Shouts or comments as well as them no longer being able to interact with you or any other Hubmates. The Hubmate you remove will not know who has done so but will be notified of their removal, however this action will be displayed in the Hubs Activity for your remaining Hubmates to view and here will show you as the one who has removed the Hubmate</p>
  </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
