<!-- metadata -->
<?php $pageTitle = "Privacy Policy"; ?>
<?php $pageDesc = "Privacy Policy Description"; ?>
<?php $pageRobots = "noindex"; ?>
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
  <h1 class="mt-3 cabin-font text-hub-dark-purple">Privacy Policy</h1>
  <small class="text-muted cabin-font">Effective: May 18, 2021</small>
  <div class="pp-intro mt-5">
    <p>TheHub is a social network company. Our product and service is to provide a fun, safe and effective way to communicate with those that are close to you, around the world. We have written this Privacy Policy as when you use our services, you'll share some information with us and we want to be transparent and open with you as to how we use the information we collect, whom this may be shared with as well as to make you aware of the controls we give you to access, update and delete your information.</p>
    <p>Yes this is a legal document, however we've written this in such a way that it keeps all the legal jargon to a minimum, and is as readable as possible.</p>
  </div>
  <div class="pp-info-we-collect my-5">
    <h4 class="cabin-font">Information We Collect</h4>
    <p>The information we collect is best split into two sections:</p>
    <strong>
      <ul class="list-unstyled">
        <li>The information you provide</li>
        <li>The information we get when you use our services</li>
      </ul>
    </strong>
    <strong><p>The information you provide</p></strong>
    <p>When using our services, we collect information you provide when you sign up. When setting up a Hub account, you will provide your name, an email address, a password and a Hubname. You may also provide us with a brief Bio for yourself in the About section of your profile details as well as your location.</p>
    <p>Whilst using our services you will also provide us with any information you send through our service such as Shouts, Comments, Whispers or Invites. It is best to remind you that any Hub users that you interact with may save or copy content outside of the Hub. It is because of this that we advise the same common sense applied when using any web app, to be applied whilst using TheHub alo; refrain from sending anything or sharing any content you wouldn't wish someone to save or share further.</p>
    <p>Should you contact us for support or for any query, we may collcet further information that you volunteer should it be required to assist you in finding a solution to your question.</p>
    <strong><p>The information we get when you use our services</p></strong>
    <p>Currently, we do not collect any information other than what you volunteer i.e. Shouts, Whispers, Invites etc as covered above.</p>
  </div>
  <div class="pp-how-we-use my-5">
    <h4 class="cabin-font">How We Use Information</h4>
    <p>The most pertinent question here is what do we do with the information we collect? The answer is simple, we use it to provide you with a customised experience, tailored to your taste. The information we collect is to enable you to have an account, interact with others and be a functional member of TheHub.</p>
    <p>Personal details such as your name, and volunteered information like an About or Location section are to personalise your account, and allow you to express yourself to your Hubmates. Your email address is used to not only setup your Hub account but also for us to send you communications. We may contact you via email to notify you of Hub Activity, software updates or even any changes made here to our Privacy Policy.</p>
    <p>Your password is immediately hashed for your safety, and this also means that we never have access to your provided password neither.</p>
  </div>
  <div class="pp-how-we-share my-5">
    <h4 class="cabin-font">How We Share Information</h4>
    <p>How we share information collected about you can be categorised in the following ways:</p>
    <strong>
      <ul class="list-unstyled">
        <li>With your Hubmates</li>
        <li>With all Hub users</li>
      </ul>
    </strong>
    <strong><p>With your Hubmates</p></strong>
    <p>We may share information with your Hubmates in the following ways:</p>
    <ul>
      <li>Information about you such as your Hub ID and your name. Also should you have provided any About or Location information then this will also be made visible to your other Hubmates on your profile.</li>
      <li>Additional information about your activity, such as when you joined or left a Hub. Hubmates who are members of a Hub you either have joined or have left will be able to see the dates in which this happened.</li>
      <li>Information you share such as Shouts, Whispers or Invites. Shouts will be shared with all members of the Hub you posted the Shout whereas Whispers and Invites will only be visible to the recipient.</li>
    </ul>
    <strong><p>With all Hub users</p></strong>
    <p>We may share information with all Hub users in the following way(s):</p>
    <ul>
      <li>Similar to the first bullet point in the above section, information about you will be visible by any Hub user should they search for your account by ID. This will allow them to view your Hub ID, name and About or Location should you provide those details.</li>
    </ul>
  </div>
  <div class="pp-how-long-we-store my-5">
    <h4 class="cabin-font">How Long We Keep Information</h4>
    <p>All the information we store from you is treated in a very similar fashion; we store until you tell us to no longer do so. This is everything from account information to your Hub Activity such as Shouts with the only exception being Invites. Once a Hub Invite has either been accepted or declined, it will be deleted on our end as the information is no longer required. Other Hub Activities differ to this as Shouts, Whispers and Account information such as your name are all required for other Hubmates to interact with. All the information stored can be deleted at any point.</p>
    <p>Should you delete your account, all of your information will be removed also; every Shout, every Comment, every Whisper as well as all of your account information (i.e. email address, name, password etc.)</p>
  </div>
  <div class="pp-control-over-your-info my-5">
    <h4 class="cabin-font">Control Over Your Information</h4>
    <p>We believe you should be in control of your information so we provide you with the following tools:</p>
    <ul class="list-unstyled">
      <li>
        <p><strong>Access to view and edit</strong></p>
        <p>All of your account information is accessible through the Settings page. Here you can view and change your email address, password as well as being able to edit any Hub details. You can also edit your name, About and Location sections from the edit profile page.</p>
      </li>
      <li>
        <p><strong>Ability to delete</strong></p>
        <p>You can delete Shouts, About section, Location as well as remove your profile picture. This will permanently delete this information our end also. You can also delete your account and should you do so, this will delete all your account information, including any Shouts, Comments, Whispers, or pending Invites you may have.</p>
      </li>
    </ul>
  </div>
  <div class="pp-basis-for-using-your-info my-5">
    <h4 class="cabin-font">Basis For Using Your Information</h4>
    <p>Legally we are only allowed to use your information when certain conditions apply and typically we will rely on one of the following four.</p>
    <p><strong>Contract: </strong>One reason we might use your information is because you may enter into an agreement with us. An example of this would be if you were to purchase, and accept the accompanying terms, of an additional service of ours. This may require further personal details, such as payment information, to be provided for the service.</p>
    <p><strong>Legitimate interest: </strong>Another reason we might use your information is because we have a legitimate interest in doing so. As we need to use your information to provide and improve our tailored services, including protecting your account, your information allows us to create an environment that you have setup without any external influences (i.e. other users imposing on, or gaining access to, your Hub/profile.) We do wish to stress that our interests don't outwiegh your right to privacy and we'll never attempt to blur or cross those lines. To do so, we only use your information where we believe it to not impose on your privacy in any such way you would not be expecting, or there is a compelling reason to do so.</p>
    <p><strong>Consent: </strong>There may be some cases where we'll ask for your consent before proceeding with an update or alteration. This may be to inform you of a pending update that may change the way in which we use your information for a specific purpose and only should you consent to the proposed changes (which will be detailed in the permission request) will they be applied.</p>
    <p><strong> Legal obligation: </strong>We may be required to use your personal information to comply with the law, for example, we may need to respond to valid legal processes or need to take action to protect you, as our user. Our policy is to contact our Hub users as and when we receive any legal processes seeking your account information.</p>
  </div>
  <div class="pp-chilren my-5">
    <h4 class="cabin-font">Children</h4>
    <p>Our services are not intended for, and we do not direct them to, any persons under the age of 13. Upon sign up we have a mandatory field whereby any user who wishes to register has to confirm their age to be above 13. Further than that, we do not gather any age information from our users so do not knowingly collect any personal information from any persons under the age of 13.</p>
  </div>
  <div class="pp-revisions my-5">
    <h4 class="cabin-font">Revisions To The Privacy Policy</h4>
    <p>We may make alterations to this Privacy Policy from time to time. When we do we'll be sure to notify you accordingly. Should it be a change on a smaller scale we may just alter the date at the top of this page, any larger scale changes we'll be sure to email you to notify you of the changes. There may be instances where we provide a statement on our homepage to inform our users of any changes.</p>
  </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
