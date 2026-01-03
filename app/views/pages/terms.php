<!-- metadata -->
<?php $pageTitle = "Terms of Service"; ?>
<?php $pageDesc = "Take a look at our Terms of Service"; ?>
<?php $pageRobots = "index"; ?>
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
  <h1 class="mt-3 cabin-font text-hub-dark-purple">Terms of Service</h1>
  <div class="pp-intro mt-5">
    <p>The following Terms of Use (or "Terms") govern your use of TheHub, except where we may explicitly state that separate terms (and not these) apply. When you create a Hub account or use TheHub, you agree to these terms.</p>
  </div>
  <div class="pp-intro mt-5">
    <h4 class="cabin-font">TheHub Service</h4>
    <p>We agree to provide you with TheHub Service. The Service includes all of the TheHub products, features, applications, services, technologies, and software that we provide. The Service is made up of the following aspects:</p>
    <ul>
      <li><strong>Fostering a positive, inclusive, and safe environment: </strong>We develop and use tools and offer resources to our users that help to make their experiences positive and inclusive, including when we think they might need help. We are strongly opposed to abuse and online hate so actively attempt to remain ontop of any negative behaviour on our platform. We also have teams and systems that work to combat abuse and violations of our Terms and policies, as well as harmful and deceptive behavior. We use all the information we have, including your information, to try to keep our platform secure.</li>
      <li><strong>Developing and using technologies that help us consistently serve our growing community: </strong>Organizing and analyzing information for our growing community is central to our Service. A big part of our Service is creating and using cutting-edge technologies that help us personalize, protect, and improve our Service on an incredibly large scale for a broad community. Automated technologies also help us ensure the functionality and integrity of our Service.</li>
      <li><strong>Research and innovation: </strong>We use the information we have to develop, test, and improve our Service and collaborate with others on research to make our Service better and contribute to the well-being of our community. This includes analyzing the data we have about our users and understanding how people use our Services, for example by conducting surveys and testing and troubleshooting new features.</li>
    </ul>
  </div>
  <div class="pp-intro mt-5">
    <h4 class="cabin-font">Your Commitments</h4>
    <p>In return for our commitment to provide the Service, we require you to make the below commitments to us.</p>
    <p><strong>Who Can Use TheHub:</strong> We want our Service to be as open and inclusive as possible, but we also want it to be safe, secure, and in accordance with the law. So, we need you to commit to a few restrictions in order to be part of the TheHub community.</p>
    <ul>
      <li>You must be at least 13 years old.</li>
      <li>We must not have previously disabled your account for violation of law or any of our policies.</li>
      <li>You must not be prohibited from receiving any aspect of our Service under applicable laws or engaging in payments related Services if you are on an applicable denied party listing.</li>
      <li>You must not be a convicted sex offender.</li>
    </ul>
    <p><strong>How You Can't Use TheHub:</strong> Providing a safe and open Service for a broad community requires that we all do our part. Here we have outlined some don'ts for when using TheHub.</p>
    <ul>
      <li>You can't do anything unlawful, misleading, or fraudulent or for an illegal or unauthorized purpose.</li>
      <li>You can't impersonate others or provide inaccurate information.</li>
      <li>You can't violate (or help or encourage others to violate) these Terms or our policies.</li>
      <li>You can't do anything to interfere with or impair the intended operation of the Service.</li>
      <li>You can't attempt to create accounts or access or collect information in unauthorized ways.</li>
      <li>You can’t modify, translate, create derivative works of, or reverse engineer our products or their components.</li>
      <li>You can’t sell, license, or purchase any account or data obtained from us or our Service.</li>
      <li>You can't post someone else’s private or confidential information without permission or do anything that violates someone else's rights, including intellectual property rights (e.g., copyright infringement, trademark infringement, counterfeit, or pirated goods).</li>
      <li>You can't use a domain name or URL in your username without our prior written consent.</li>
    </ul>
    <p><strong>Permissions You Give to Us:</strong> As part of our agreement, you also give us permissions that we need to provide the Service.</p>
    <ul>
      <li><strong>We do not claim ownership of your content, but you grant us a license to use it.</strong> Nothing is changing about your rights in your content. We do not claim ownership of your content that you post on or through the Service and you are free to share your content with anyone else, wherever you want. However, we need certain legal permissions from you (known as a “license”) to provide the Service. When you share, post, or upload content that is covered by intellectual property rights (like photos or videos) on or in connection with our Service, you hereby grant to us a non-exclusive, royalty-free, transferable, sub-licensable, worldwide license to host, use, distribute, modify, run, copy, publicly perform or display, translate, and create derivative works of your content (consistent with your privacy and application settings). This license will end when your content is deleted from our systems. You can delete content individually or all at once by deleting your account.</li>
      <li><strong>You agree that we can download and install updates to the Service on your device.</strong></li>
    </ul>
  </div>
  <div class="pp-intro mt-5">
    <h4 class="cabin-font">Additional Rights We Retain</h4>
    <ul>
      <li>If you use content covered by intellectual property rights that we have and make available in our Service (for example, images, designs, videos, or sounds we provide that you add to content you create or share), we retain all rights to our content (but not yours).</li>
      <li>You can only use our intellectual property and trademarks or similar marks as expressly permitted by our Brand Guidelines or with our prior written permission.</li>
      <li>You must obtain written permission from us or under an open source license to modify, create derivative works of, decompile, or otherwise attempt to extract source code from us.</li>
    </ul>
  </div>
  <div class="pp-intro mt-5">
    <h4 class="cabin-font">Content Removal and Disabling or Terminating Your Account</h4>
    <p>We can remove any content or information you share on the Service if we believe that it violates these Terms of Use, our policies, or we are required to do so by law. We can refuse to provide or stop providing all or part of the Service to you immediately to protect our community or services, or if you create risk or legal exposure for us, violate these Terms of Use or our policies, if you repeatedly infringe other people’s intellectual property rights, or where we are required to do so by law. We can also terminate or change the Service, remove or block content or information shared on our Service, or stop providing all or part of the Service if we determine that doing so is reasonably necessary to avoid or mitigate adverse legal or regulatory impacts on us. In some cases when we remove content, we’ll let you know and explain any options you have to request another review, unless you seriously or repeatedly violate these Terms or if doing so may expose us or others to legal liability; harm our community of users; compromise or interfere with the integrity or operation of any of our services, systems, or products; where we are restricted due to technical limitations; or where we are prohibited from doing so for legal reasons.</p>
    <p>If you delete or we disable your account, these Terms shall terminate as an agreement between you and us, but this section and the section below called "Our Agreement and What Happens if We Disagree" will still apply even after your account is terminated, disabled, or deleted.</p>
  </div>
  <div class="pp-intro mt-5">
    <h4 class="cabin-font">Our Agreement and What Happens if We Disagree</h4>
    <p><strong>Our Agreement.</strong></p>
    <ul>
      <li>If any aspect of this agreement is unenforceable, the rest will remain in effect.</li>
      <li>Any amendment or waiver to our agreement must be in writing and signed by us. If we fail to enforce any aspect of this agreement, it will not be a waiver.</li>
      <li>We reserve all rights not expressly granted to you.</li>
    </ul>
    <p><strong>Who Has Rights Under this Agreement.</strong></p>
    <ul>
      <li>This agreement does not give rights to any third parties.</li>
      <li>You cannot transfer your rights or obligations under this agreement without our consent.</li>
      <li>Our rights and obligations can be assigned to others. For example, this could occur if our ownership changes (as in a merger, acquisition, or sale of assets) or by law.</li>
    </ul>
    <p><strong>Who Is Responsible if Something Happens.</strong></p>
    <ul>
      <li>We will use reasonable skill and care in providing our Service to you and in keeping a safe, secure, and error-free environment, but we cannot guarantee that our Service will always function without disruptions, delays, or imperfections. Provided we have acted with reasonable skill and care, we do not accept responsibility for: losses not caused by our breach of these Terms or otherwise by our acts; losses which are not reasonably foreseeable by you and us at the time of entering into these Terms; any offensive, inappropriate, obscene, unlawful, or otherwise objectionable content posted by others that you may encounter on our Service; and events beyond our reasonable control.</li>
      <li>The above does not exclude or limit our liability for death, personal injury, or fraudulent misrepresentation caused by our negligence. It also does not exclude or limit our liability for any other things where the law does not permit us to do so.</li>
    </ul>
    <p><strong>How We Will Handle Disputes.</strong></p>
    <p>If a claim or dispute arises out of or relates to your use of the Service as a consumer, both you and us agree that you may resolve your individual claim or dispute against us, and we may resolve our claim or dispute against you, in any competent court in the country of your main residence that has jurisdiction over your claim or dispute, and the laws of that country will apply without regard to conflict of law provisions.</p>
    <p><strong>Unsolicited Material.</strong></p>
    <p>We always appreciate feedback or other suggestions, but may use them without any restrictions or obligation to compensate you for them, and are under no obligation to keep them confidential.</p>
  </div>
  <div class="pp-intro mt-5">
    <h4 class="cabin-font">Updating These Terms</h4>
    <p>We may change our Service and policies, and we may need to make changes to these Terms so that they accurately reflect our Service and policies. Unless otherwise required by law, we will notify you (for example, through our Service) at least 30 days before we make changes to these Terms and give you an opportunity to review them before they go into effect. Then, if you continue to use the Service, you will be bound by the updated Terms.</p>
  </div>
  <small class="text-muted cabin-font">Revised: May 18, 2021</small>
<?php require APPROOT . '/views/inc/footer.php'; ?>
