// prevent resubmit form browser popup
if(window.history.replaceState){
  window.history.replaceState(null, null, window.location.href);
}

// remove confetti img on Privacy Policy and About pages
var sPath = window.location.pathname;
var sPage = sPath.substring(sPath.lastIndexOf('/') + 1);
var pathArr = window.location.pathname.split("/");
var sView = pathArr[2];
if(sPage == "privacy" || sPage == "help" || sPage == "about" || sPage == "terms"){
  var x = document.getElementsByTagName("BODY")[0];
  x.style.backgroundImage = "";
  document.getElementById("bodyTag").classList.remove("confetti-bg");

  // scroll top btn
  $(document).ready(function(){
  	$(window).scroll(function(){
  			if($(this).scrollTop() > 100){
  				$('#back-to-top').fadeIn();
  			} else {
  				$('#back-to-top').fadeOut();
  			}
  		});
  		// scroll body to 0px on click
  		$('#back-to-top').click(function(){
  			$('body,html').animate({
  				scrollTop: 0
  			}, 400);
  			return false;
  		});
  });
} else if(sView == 'posts'){
    if(sPage == 'index'){
    // scroll top hub btn effect
    $('#back-to-top-hub-btn').click(function(){
      $('body,html').animate({
        scrollTop: 0
      }, 400);
      return false;
    });
  }
}

function starPost(postId, postStars, postIndexId){
  var userId = document.getElementById('postStarUserId').value;
  userId = parseInt(userId);
  var postUserId = document.getElementById('postUserId').value;
  postUserId = parseInt(postUserId);
  var userName = document.getElementById('postStarUserName').value;
  var userColour = document.getElementById('postStarUserColour').value;
  var userImg = document.getElementById('postStarUserImg').value;
  var postIndexString = postIndexId + "String";
  var postIndexStar = postIndexId + "Star";
  var postIndexOriginal = postIndexId + "Original";
  var targetModalOriginalDiv = "withoutNewStar" + postIndexId;
  var targetModalNewDiv = "withNewStar" + postIndexId;
  var targetModalRemoveDiv = "removeNewStar" + postIndexId;

  if(document.getElementById(postIndexStar).classList.contains('bi-star-fill')){
    var starred = 1;
  } else {
    var starred = 0;
  }

  var data = {
    'post_id': postId,
    'starred': starred,
    'user_id': userId,
    'post_user_id': postUserId,
    'user_name': userName,
    'user_colour': userColour,
    'user_img': userImg
  }

  $.ajax({
    type: 'POST',
    url: '/thehub/public/star_posts.php',
    data: data,
    success: function(response){
      // alert(response);
      if(starred){
        if(document.getElementById(postIndexOriginal)){
          document.getElementById(postIndexOriginal).className += " d-none";
        }
        // update star string
        if(postStars <= 1){
          if(document.getElementById(postIndexString).classList.contains('d-none')){
            // use modified div to correctly display/hide session user in modal
            document.getElementById(targetModalOriginalDiv).className += " d-none";
            document.getElementById(targetModalNewDiv).className += " d-none";
            document.getElementById(targetModalRemoveDiv).classList.remove("d-none");
          } else {
            document.getElementById(postIndexString).className += " d-none";
          }
        } else if(postStars == 2){
          if(document.getElementById(postIndexString).classList.contains('d-none')){
            document.getElementById(postIndexString).classList.remove("d-none");
            document.getElementById(postIndexString).innerHTML = "Starred by <strong>1 Hubmate</strong>";
            // use modified div to correctly display/hide session user in modal
            document.getElementById(targetModalOriginalDiv).className += " d-none";
            document.getElementById(targetModalNewDiv).className += " d-none";
            document.getElementById(targetModalRemoveDiv).classList.remove("d-none");
          } else {
            document.getElementById(postIndexString).classList.remove("d-none");
            var str = document.getElementById(postIndexString).innerHTML;
            var starNum = str.replace(/\D/g, "");
            starNum = parseInt(starNum);
            starNum -= 1;
            document.getElementById(postIndexString).innerHTML = "Starred by <strong>" + starNum + " Hubmates</strong>";
            // use modified div to correctly display/hide session user in modal
            document.getElementById(targetModalOriginalDiv).className += " d-none";
            document.getElementById(targetModalNewDiv).className += " d-none";
            document.getElementById(targetModalRemoveDiv).classList.remove("d-none");
          }
        } else {
          if(document.getElementById(postIndexString).classList.contains('d-none')){
            postStars -= 1;
            document.getElementById(postIndexString).classList.remove("d-none");
            document.getElementById(postIndexString).innerHTML = "Starred by <strong>" + postStars + " Hubmates</strong>";
            // use modified div to correctly display/hide session user in modal
            document.getElementById(targetModalOriginalDiv).className += " d-none";
            document.getElementById(targetModalNewDiv).className += " d-none";
            document.getElementById(targetModalRemoveDiv).classList.remove("d-none");
          } else {
            document.getElementById(postIndexString).classList.remove("d-none");
            var str = document.getElementById(postIndexString).innerHTML;
            var starNum = str.replace(/\D/g, "");
            starNum = parseInt(starNum);
            starNum -= 1;
            document.getElementById(postIndexString).innerHTML = "Starred by <strong>" + starNum + " Hubmates</strong>";
            // use modified div to correctly display/hide session user in modal
            document.getElementById(targetModalOriginalDiv).className += " d-none";
            document.getElementById(targetModalNewDiv).className += " d-none";
            document.getElementById(targetModalRemoveDiv).classList.remove("d-none");
          }
        }

        // update star icon
        document.getElementById(postIndexStar).classList.remove("bi-star-fill");
        document.getElementById(postIndexStar).classList.remove("text-mustard");
        document.getElementById(postIndexStar).className += " bi-star";
        document.getElementById(postIndexStar).className += " text-hub-dark-purple";
      } else {
        // update star string
        if(postStars == 0){
          document.getElementById(postIndexString).classList.remove("d-none");
          document.getElementById(postIndexString).innerHTML = "Starred by <strong>1 Hubmate</strong>";
          // use modified div to correctly display/hide session user in modal
          document.getElementById(targetModalOriginalDiv).className += " d-none";
          document.getElementById(targetModalRemoveDiv).className += " d-none";
          document.getElementById(targetModalNewDiv).classList.remove("d-none");
        } else {
          if(document.getElementById(postIndexString).classList.contains('d-none')){
            document.getElementById(postIndexString).classList.remove("d-none");
            var str = document.getElementById(postIndexOriginal).innerHTML;
            var starNum = str.replace(/\D/g, "");
            starNum = parseInt(starNum);
            // starNum += 1;
            document.getElementById(postIndexString).innerHTML = "Starred by <strong>" + starNum + " Hubmates</strong>";
          } else {
            document.getElementById(postIndexString).classList.remove("d-none");
            var str = document.getElementById(postIndexString).innerHTML;
            var starNum = str.replace(/\D/g, "");
            starNum = parseInt(starNum);
            starNum += 1;
            document.getElementById(postIndexString).innerHTML = "Starred by <strong>" + starNum + " Hubmates</strong>";
          }

          if(starNum == 1){
            document.getElementById(postIndexString).innerHTML = "Starred by <strong>" + starNum + " Hubmate</strong>";
          } else {
            document.getElementById(postIndexString).innerHTML = "Starred by <strong>" + starNum + " Hubmates</strong>";
          }

          document.getElementById(postIndexOriginal).className += " d-none";
          // use modified div to correctly display/hide session user in modal
          document.getElementById(targetModalOriginalDiv).className += " d-none";
          document.getElementById(targetModalRemoveDiv).className += " d-none";
          document.getElementById(targetModalNewDiv).classList.remove("d-none");
        }

        // update star icon
        document.getElementById(postIndexStar).classList.remove("bi-star");
        document.getElementById(postIndexStar).classList.remove("text-hub-dark-purple");
        document.getElementById(postIndexStar).className += " bi-star-fill";
        document.getElementById(postIndexStar).className += " text-mustard";
      }
    },
    processData: true
  });
}

// about icons
function aboutHubs(){
  if (document.getElementById("aboutHubmatesDiv").classList.contains('bg-purple-fade')){
    // remove current colour and display class
    document.getElementById("aboutHubmatesDiv").classList.remove("bg-purple-fade");
    document.getElementById("hubmatesAboutImg").className += " d-none";
    document.getElementById("hubmatesAboutHeader").className += " d-none";
    document.getElementById("hubmatesAboutDesc").className += " d-none";
    // add own colour and display class
    document.getElementById("aboutHubsDiv").className += " bg-orange-fade";
    document.getElementById("hubsAboutImg").classList.remove("d-none");
    document.getElementById("hubsAboutHeader").classList.remove("d-none");
    document.getElementById("hubsAboutDesc").classList.remove("d-none");
  } else if(document.getElementById("aboutShoutsDiv").classList.contains('bg-green-fade')){
    // remove current colour and display class
    document.getElementById("aboutShoutsDiv").classList.remove("bg-green-fade");
    document.getElementById("shoutsAboutImg").className += " d-none";
    document.getElementById("shoutsAboutHeader").className += " d-none";
    document.getElementById("shoutsAboutDesc").className += " d-none";
    // add own colour and display class
    document.getElementById("aboutHubsDiv").className += " bg-orange-fade";
    document.getElementById("hubsAboutImg").classList.remove("d-none");
    document.getElementById("hubsAboutHeader").classList.remove("d-none");
    document.getElementById("hubsAboutDesc").classList.remove("d-none");
  } else if(document.getElementById("aboutStarsDiv").classList.contains('bg-yellow-fade')){
    // remove current colour and display class
    document.getElementById("aboutStarsDiv").classList.remove("bg-yellow-fade");
    document.getElementById("starsAboutImg").className += " d-none";
    document.getElementById("starsAboutHeader").className += " d-none";
    document.getElementById("starsAboutDesc").className += " d-none";
    // add own colour and display class
    document.getElementById("aboutHubsDiv").className += " bg-orange-fade";
    document.getElementById("hubsAboutImg").classList.remove("d-none");
    document.getElementById("hubsAboutHeader").classList.remove("d-none");
    document.getElementById("hubsAboutDesc").classList.remove("d-none");
  } else if(document.getElementById("aboutWhispersDiv").classList.contains('bg-blue-fade')){
    // remove current colour and display class
    document.getElementById("aboutWhispersDiv").classList.remove("bg-blue-fade");
    document.getElementById("whispersAboutImg").className += " d-none";
    document.getElementById("whispersAboutHeader").className += " d-none";
    document.getElementById("whispersAboutDesc").className += " d-none";
    // add own colour and display class
    document.getElementById("aboutHubsDiv").className += " bg-orange-fade";
    document.getElementById("hubsAboutImg").classList.remove("d-none");
    document.getElementById("hubsAboutHeader").classList.remove("d-none");
    document.getElementById("hubsAboutDesc").classList.remove("d-none");
  }
}

function aboutHubmates(){
  if (document.getElementById("aboutHubsDiv").classList.contains('bg-orange-fade')){
    // remove current colour and display class
    document.getElementById("aboutHubsDiv").classList.remove("bg-orange-fade");
    document.getElementById("hubsAboutImg").className += " d-none";
    document.getElementById("hubsAboutHeader").className += " d-none";
    document.getElementById("hubsAboutDesc").className += " d-none";
    // add own colour and display class
    document.getElementById("aboutHubmatesDiv").className += " bg-purple-fade";
    document.getElementById("hubmatesAboutImg").classList.remove("d-none");
    document.getElementById("hubmatesAboutHeader").classList.remove("d-none");
    document.getElementById("hubmatesAboutDesc").classList.remove("d-none");
  } else if(document.getElementById("aboutShoutsDiv").classList.contains('bg-green-fade')){
    // remove current colour and display class
    document.getElementById("aboutShoutsDiv").classList.remove("bg-green-fade");
    document.getElementById("shoutsAboutImg").className += " d-none";
    document.getElementById("shoutsAboutHeader").className += " d-none";
    document.getElementById("shoutsAboutDesc").className += " d-none";
    // add own colour and display class
    document.getElementById("aboutHubmatesDiv").className += " bg-purple-fade";
    document.getElementById("hubmatesAboutImg").classList.remove("d-none");
    document.getElementById("hubmatesAboutHeader").classList.remove("d-none");
    document.getElementById("hubmatesAboutDesc").classList.remove("d-none");
  } else if(document.getElementById("aboutStarsDiv").classList.contains('bg-yellow-fade')){
    // remove current colour and display class
    document.getElementById("aboutStarsDiv").classList.remove("bg-yellow-fade");
    document.getElementById("starsAboutImg").className += " d-none";
    document.getElementById("starsAboutHeader").className += " d-none";
    document.getElementById("starsAboutDesc").className += " d-none";
    // add own colour and display class
    document.getElementById("aboutHubmatesDiv").className += " bg-purple-fade";
    document.getElementById("hubmatesAboutImg").classList.remove("d-none");
    document.getElementById("hubmatesAboutHeader").classList.remove("d-none");
    document.getElementById("hubmatesAboutDesc").classList.remove("d-none");
  } else if(document.getElementById("aboutWhispersDiv").classList.contains('bg-blue-fade')){
    // remove current colour and display class
    document.getElementById("aboutWhispersDiv").classList.remove("bg-blue-fade");
    document.getElementById("whispersAboutImg").className += " d-none";
    document.getElementById("whispersAboutHeader").className += " d-none";
    document.getElementById("whispersAboutDesc").className += " d-none";
    // add own colour and display class
    document.getElementById("aboutHubmatesDiv").className += " bg-purple-fade";
    document.getElementById("hubmatesAboutImg").classList.remove("d-none");
    document.getElementById("hubmatesAboutHeader").classList.remove("d-none");
    document.getElementById("hubmatesAboutDesc").classList.remove("d-none");
  }
}

function aboutShouts(){
  if (document.getElementById("aboutHubsDiv").classList.contains('bg-orange-fade')){
    // remove current colour and display class
    document.getElementById("aboutHubsDiv").classList.remove("bg-orange-fade");
    document.getElementById("hubsAboutImg").className += " d-none";
    document.getElementById("hubsAboutHeader").className += " d-none";
    document.getElementById("hubsAboutDesc").className += " d-none";
    // add own colour and display class
    document.getElementById("aboutShoutsDiv").className += " bg-green-fade";
    document.getElementById("shoutsAboutImg").classList.remove("d-none");
    document.getElementById("shoutsAboutHeader").classList.remove("d-none");
    document.getElementById("shoutsAboutDesc").classList.remove("d-none");
  } else if(document.getElementById("aboutHubmatesDiv").classList.contains('bg-purple-fade')){
    // remove current colour and display class
    document.getElementById("aboutHubmatesDiv").classList.remove("bg-purple-fade");
    document.getElementById("hubmatesAboutImg").className += " d-none";
    document.getElementById("hubmatesAboutHeader").className += " d-none";
    document.getElementById("hubmatesAboutDesc").className += " d-none";
    // add own colour and display class
    document.getElementById("aboutShoutsDiv").className += " bg-green-fade";
    document.getElementById("shoutsAboutImg").classList.remove("d-none");
    document.getElementById("shoutsAboutHeader").classList.remove("d-none");
    document.getElementById("shoutsAboutDesc").classList.remove("d-none");
  } else if(document.getElementById("aboutStarsDiv").classList.contains('bg-yellow-fade')){
    // remove current colour and display class
    document.getElementById("aboutStarsDiv").classList.remove("bg-yellow-fade");
    document.getElementById("starsAboutImg").className += " d-none";
    document.getElementById("starsAboutHeader").className += " d-none";
    document.getElementById("starsAboutDesc").className += " d-none";
    // add own colour and display class
    document.getElementById("aboutShoutsDiv").className += " bg-green-fade";
    document.getElementById("shoutsAboutImg").classList.remove("d-none");
    document.getElementById("shoutsAboutHeader").classList.remove("d-none");
    document.getElementById("shoutsAboutDesc").classList.remove("d-none");
  } else if(document.getElementById("aboutWhispersDiv").classList.contains('bg-blue-fade')){
    // remove current colour and display class
    document.getElementById("aboutWhispersDiv").classList.remove("bg-blue-fade");
    document.getElementById("whispersAboutImg").className += " d-none";
    document.getElementById("whispersAboutHeader").className += " d-none";
    document.getElementById("whispersAboutDesc").className += " d-none";
    // add own colour and display class
    document.getElementById("aboutShoutsDiv").className += " bg-green-fade";
    document.getElementById("shoutsAboutImg").classList.remove("d-none");
    document.getElementById("shoutsAboutHeader").classList.remove("d-none");
    document.getElementById("shoutsAboutDesc").classList.remove("d-none");
  }
}

function aboutStars(){
  if (document.getElementById("aboutHubsDiv").classList.contains('bg-orange-fade')){
    // remove current colour and display class
    document.getElementById("aboutHubsDiv").classList.remove("bg-orange-fade");
    document.getElementById("hubsAboutImg").className += " d-none";
    document.getElementById("hubsAboutHeader").className += " d-none";
    document.getElementById("hubsAboutDesc").className += " d-none";
    // add own colour and display class
    document.getElementById("aboutStarsDiv").className += " bg-yellow-fade";
    document.getElementById("starsAboutImg").classList.remove("d-none");
    document.getElementById("starsAboutHeader").classList.remove("d-none");
    document.getElementById("starsAboutDesc").classList.remove("d-none");
  } else if(document.getElementById("aboutHubmatesDiv").classList.contains('bg-purple-fade')){
    // remove current colour and display class
    document.getElementById("aboutHubmatesDiv").classList.remove("bg-purple-fade");
    document.getElementById("hubmatesAboutImg").className += " d-none";
    document.getElementById("hubmatesAboutHeader").className += " d-none";
    document.getElementById("hubmatesAboutDesc").className += " d-none";
    // add own colour and display class
    document.getElementById("aboutStarsDiv").className += " bg-yellow-fade";
    document.getElementById("starsAboutImg").classList.remove("d-none");
    document.getElementById("starsAboutHeader").classList.remove("d-none");
    document.getElementById("starsAboutDesc").classList.remove("d-none");
  } else if(document.getElementById("aboutShoutsDiv").classList.contains('bg-green-fade')){
    // remove current colour and display class
    document.getElementById("aboutShoutsDiv").classList.remove("bg-green-fade");
    document.getElementById("shoutsAboutImg").className += " d-none";
    document.getElementById("shoutsAboutHeader").className += " d-none";
    document.getElementById("shoutsAboutDesc").className += " d-none";
    // add own colour and display class
    document.getElementById("aboutStarsDiv").className += " bg-yellow-fade";
    document.getElementById("starsAboutImg").classList.remove("d-none");
    document.getElementById("starsAboutHeader").classList.remove("d-none");
    document.getElementById("starsAboutDesc").classList.remove("d-none");
  } else if(document.getElementById("aboutWhispersDiv").classList.contains('bg-blue-fade')){
    // remove current colour and display class
    document.getElementById("aboutWhispersDiv").classList.remove("bg-blue-fade");
    document.getElementById("whispersAboutImg").className += " d-none";
    document.getElementById("whispersAboutHeader").className += " d-none";
    document.getElementById("whispersAboutDesc").className += " d-none";
    // add own colour and display class
    document.getElementById("aboutStarsDiv").className += " bg-yellow-fade";
    document.getElementById("starsAboutImg").classList.remove("d-none");
    document.getElementById("starsAboutHeader").classList.remove("d-none");
    document.getElementById("starsAboutDesc").classList.remove("d-none");
  }
}

function aboutWhispers(){
  if (document.getElementById("aboutHubsDiv").classList.contains('bg-orange-fade')){
    // remove current colour and display class
    document.getElementById("aboutHubsDiv").classList.remove("bg-orange-fade");
    document.getElementById("hubsAboutImg").className += " d-none";
    document.getElementById("hubsAboutHeader").className += " d-none";
    document.getElementById("hubsAboutDesc").className += " d-none";
    // add own colour and display class
    document.getElementById("aboutWhispersDiv").className += " bg-blue-fade";
    document.getElementById("whispersAboutImg").classList.remove("d-none");
    document.getElementById("whispersAboutHeader").classList.remove("d-none");
    document.getElementById("whispersAboutDesc").classList.remove("d-none");
  } else if(document.getElementById("aboutHubmatesDiv").classList.contains('bg-purple-fade')){
    // remove current colour and display class
    document.getElementById("aboutHubmatesDiv").classList.remove("bg-purple-fade");
    document.getElementById("hubmatesAboutImg").className += " d-none";
    document.getElementById("hubmatesAboutHeader").className += " d-none";
    document.getElementById("hubmatesAboutDesc").className += " d-none";
    // add own colour and display class
    document.getElementById("aboutWhispersDiv").className += " bg-blue-fade";
    document.getElementById("whispersAboutImg").classList.remove("d-none");
    document.getElementById("whispersAboutHeader").classList.remove("d-none");
    document.getElementById("whispersAboutDesc").classList.remove("d-none");
  } else if(document.getElementById("aboutShoutsDiv").classList.contains('bg-green-fade')){
    // remove current colour and display class
    document.getElementById("aboutShoutsDiv").classList.remove("bg-green-fade");
    document.getElementById("shoutsAboutImg").className += " d-none";
    document.getElementById("shoutsAboutHeader").className += " d-none";
    document.getElementById("shoutsAboutDesc").className += " d-none";
    // add own colour and display class
    document.getElementById("aboutWhispersDiv").className += " bg-blue-fade";
    document.getElementById("whispersAboutImg").classList.remove("d-none");
    document.getElementById("whispersAboutHeader").classList.remove("d-none");
    document.getElementById("whispersAboutDesc").classList.remove("d-none");
  } else if(document.getElementById("aboutStarsDiv").classList.contains('bg-yellow-fade')){
    // remove current colour and display class
    document.getElementById("aboutStarsDiv").classList.remove("bg-yellow-fade");
    document.getElementById("starsAboutImg").className += " d-none";
    document.getElementById("starsAboutHeader").className += " d-none";
    document.getElementById("starsAboutDesc").className += " d-none";
    // add own colour and display class
    document.getElementById("aboutWhispersDiv").className += " bg-blue-fade";
    document.getElementById("whispersAboutImg").classList.remove("d-none");
    document.getElementById("whispersAboutHeader").classList.remove("d-none");
    document.getElementById("whispersAboutDesc").classList.remove("d-none");
  }
}

// navbar hub picker
function populateHub(hubId){
  document.getElementById('requestedHubId').value = hubId;
}

// toast message(s)
$(document).ready(function(){
  $(".toast").toast('show');
  $("#showHidePassword a").on('click', function(event){
    event.preventDefault();
    if($('#showHidePassword input').attr("type") == "text"){
      $('#showHidePassword input').attr('type', 'password');
      $('#showHidePassword i').addClass( "bi-eye-slash" );
      $('#showHidePassword i').removeClass( "bi-eye" );
    } else if($('#showHidePassword input').attr("type") == "password"){
      $('#showHidePassword input').attr('type', 'text');
      $('#showHidePassword i').removeClass( "bi-eye-slash" );
      $('#showHidePassword i').addClass( "bi-eye" );
    }
  });
});

// fade effect
AOS.init({
  duration: 1000,
})

// cancel btn on edit profile page
function clearImg(){
  // need to clear uploadedWhisperImg so the same img can be uploaded
  document.getElementById('uploadedProfileImg').style.display = 'none';
  document.getElementById('imgCancelBtn').style.visibility = 'hidden';
  document.getElementById('placeholderPicture').style.display = 'block';
  document.getElementById("profileB64Img").value = '';
}

// profile image
$("input[name=img]").change(function(){
  if (this.files && this.files[0]){
    var reader = new FileReader();

    reader.onload = function(e){
      var img = $('<img>').attr('src', e.target.result).css({
        'max-height' : '12em'
      });
      document.getElementById('uploadedProfileImg').style.display = 'block';
      // document.getElementById('uploadedProfileImg').style.backgroundImage = 'url('e.target.result')';
      document.getElementById('imgCancelBtn').style.visibility = 'visible';
      document.getElementById('placeholderPicture').style.display = 'none';
      document.getElementById('uploadedProfileImg').style.backgroundImage = "url(" + e.target.result + ")";

      // will print base64 of img to hidden textbox
      document.getElementById("profileB64Img").value = e.target.result;
    };
    reader.readAsDataURL(this.files[0]);
    $("input[name=img]").val(null);
  }
});

// cancel btn on whisper pages
function clearWhisperImg(){
  // need to clear uploadedWhisperImg so the same img can be uploaded
  document.getElementById('uploadedWhisperImg').style.display = 'none';
  document.getElementById('whisperImgCancelBtn').style.visibility = 'hidden';
  document.getElementById("whisperB64Img").value = '';
}

// whisper image
$("input[name=whisperImg]").change(function(){
  if (this.files && this.files[0]){
    var reader = new FileReader();

    reader.onload = function(e){
      var img = $('<img>').attr('src', e.target.result).css({
        'max-height' : '15em'
      });
      document.getElementById('uploadedWhisperImg').style.display = 'block';
      document.getElementById('whisperImgCancelBtn').style.visibility = 'visible';
      $('#uploadedWhisperImg').html(img);

      // will print base64 of img to hidden textbox
      document.getElementById("whisperB64Img").value = e.target.result;
    };
    reader.readAsDataURL(this.files[0]);
    $("input[name=whisperImg]").val(null);
  }
});

// cancel btn on shout pages
function clearShoutImg(){
  // need to clear uploadedWhisperImg so the same img can be uploaded
  document.getElementById('uploadedShoutImg').style.display = 'none';
  document.getElementById('shoutImgCancelBtn').style.visibility = 'hidden';
  document.getElementById("shoutB64Img").value = '';
}

// shout image
$("input[name=shoutImg]").change(function(){
  if (this.files && this.files[0]){
    var reader = new FileReader();

    reader.onload = function(e){
      var img = $('<img>').attr('src', e.target.result).css({
        'max-height' : '15em'
      });
      document.getElementById('uploadedShoutImg').style.display = 'block';
      document.getElementById('shoutImgCancelBtn').style.visibility = 'visible';
      $('#uploadedShoutImg').html(img);

      // will print base64 of img to hidden textbox
      document.getElementById("shoutB64Img").value = e.target.result;
    };
    reader.readAsDataURL(this.files[0]);
    $("input[name=shoutImg]").val(null);
  }
});

// update colour picker
$(function(){
  $(".colour-picker a").click(function(event){
    event.preventDefault();
    var rawHtml = $(this).html();
    var colour = rawHtml.substring(
      rawHtml.lastIndexOf("-") + 1,
      rawHtml.lastIndexOf("#")
    );
    var colourPicked = colour.trim();
    // update placeholder picture
    if (document.getElementById("placeholderPicture").classList.contains('text-primary')){
      // remove current colour class
      document.getElementById("placeholderPicture").classList.remove("text-primary");
      // update text colour class
      document.getElementById("placeholderPicture").className += " text-" + colourPicked;
    } else if (document.getElementById("placeholderPicture").classList.contains('text-secondary')){
      // remove current colour class
      document.getElementById("placeholderPicture").classList.remove("text-secondary");
      // update text colour class
      document.getElementById("placeholderPicture").className += " text-" + colourPicked;
    } else if (document.getElementById("placeholderPicture").classList.contains('text-success')){
      // remove current colour class
      document.getElementById("placeholderPicture").classList.remove("text-success");
      // update text colour class
      document.getElementById("placeholderPicture").className += " text-" + colourPicked;
    } else if (document.getElementById("placeholderPicture").classList.contains('text-danger')){
      // remove current colour class
      document.getElementById("placeholderPicture").classList.remove("text-danger");
      // update text colour class
      document.getElementById("placeholderPicture").className += " text-" + colourPicked;
    } else if (document.getElementById("placeholderPicture").classList.contains('text-warning')){
      // remove current colour class
      document.getElementById("placeholderPicture").classList.remove("text-warning");
      // update text colour class
      document.getElementById("placeholderPicture").className += " text-" + colourPicked;
    } else if (document.getElementById("placeholderPicture").classList.contains('text-info')){
      // remove current colour class
      document.getElementById("placeholderPicture").classList.remove("text-info");
      // update text colour class
      document.getElementById("placeholderPicture").className += " text-" + colourPicked;
    } else if (document.getElementById("placeholderPicture").classList.contains('text-dark')){
      // remove current colour class
      document.getElementById("placeholderPicture").classList.remove("text-dark");
      // update text colour class
      document.getElementById("placeholderPicture").className += " text-" + colourPicked;
    }

    // update profile image border
    if (document.getElementById("uploadedProfileImg").classList.contains('border-primary')){
      // remove current colour class
      document.getElementById("uploadedProfileImg").classList.remove("border-primary");
      // update border colour class
      document.getElementById("uploadedProfileImg").className += " border-" + colourPicked;
    } else if (document.getElementById("uploadedProfileImg").classList.contains('border-secondary')){
      // remove current colour class
      document.getElementById("uploadedProfileImg").classList.remove("border-secondary");
      // update border colour class
      document.getElementById("uploadedProfileImg").className += " border-" + colourPicked;
    } else if (document.getElementById("uploadedProfileImg").classList.contains('border-success')){
      // remove current colour class
      document.getElementById("uploadedProfileImg").classList.remove("border-success");
      // update border colour class
      document.getElementById("uploadedProfileImg").className += " border-" + colourPicked;
    } else if (document.getElementById("uploadedProfileImg").classList.contains('border-danger')){
      // remove current colour class
      document.getElementById("uploadedProfileImg").classList.remove("border-danger");
      // update border colour class
      document.getElementById("uploadedProfileImg").className += " border-" + colourPicked;
    } else if (document.getElementById("uploadedProfileImg").classList.contains('border-warning')){
      // remove current colour class
      document.getElementById("uploadedProfileImg").classList.remove("border-warning");
      // update border colour class
      document.getElementById("uploadedProfileImg").className += " border-" + colourPicked;
    } else if (document.getElementById("uploadedProfileImg").classList.contains('border-info')){
      // remove current colour class
      document.getElementById("uploadedProfileImg").classList.remove("border-info");
      // update border colour class
      document.getElementById("uploadedProfileImg").className += " border-" + colourPicked;
    } else if (document.getElementById("uploadedProfileImg").classList.contains('border-dark')){
      // remove current colour class
      document.getElementById("uploadedProfileImg").classList.remove("border-dark");
      // update border colour class
      document.getElementById("uploadedProfileImg").className += " border-" + colourPicked;
    }

    // update colour picker palette
    if (colourPicked == 'primary'){
      // remove border-0 class from selected
      document.getElementById("bg-primary").classList.remove("border-light");
      // hide border for remaining colours
      document.getElementById("bg-secondary").className += " border-light";
      document.getElementById("bg-success").className += " border-light";
      document.getElementById("bg-danger").className += " border-light";
      document.getElementById("bg-warning").className += " border-light";
      document.getElementById("bg-info").className += " border-light";
      document.getElementById("bg-dark").className += " border-light";
    } else if (colourPicked == 'secondary'){
      // remove border-0 class from selected
      document.getElementById("bg-secondary").classList.remove("border-light");
      // hide border for remaining colours
      document.getElementById("bg-primary").className += " border-light";
      document.getElementById("bg-success").className += " border-light";
      document.getElementById("bg-danger").className += " border-light";
      document.getElementById("bg-warning").className += " border-light";
      document.getElementById("bg-info").className += " border-light";
      document.getElementById("bg-dark").className += " border-light";
    } else if (colourPicked == 'success'){
      // remove border-0 class from selected
      document.getElementById("bg-success").classList.remove("border-light");
      // hide border for remaining colours
      document.getElementById("bg-primary").className += " border-light";
      document.getElementById("bg-secondary").className += " border-light";
      document.getElementById("bg-danger").className += " border-light";
      document.getElementById("bg-warning").className += " border-light";
      document.getElementById("bg-info").className += " border-light";
      document.getElementById("bg-dark").className += " border-light";
    } else if (colourPicked == 'danger'){
      // remove border-0 class from selected
      document.getElementById("bg-danger").classList.remove("border-light");
      // hide border for remaining colours
      document.getElementById("bg-primary").className += " border-light";
      document.getElementById("bg-secondary").className += " border-light";
      document.getElementById("bg-success").className += " border-light";
      document.getElementById("bg-warning").className += " border-light";
      document.getElementById("bg-info").className += " border-light";
      document.getElementById("bg-dark").className += " border-light";
    } else if (colourPicked == 'warning'){
      // remove border-0 class from selected
      document.getElementById("bg-warning").classList.remove("border-light");
      // hide border for remaining colours
      document.getElementById("bg-primary").className += " border-light";
      document.getElementById("bg-secondary").className += " border-light";
      document.getElementById("bg-success").className += " border-light";
      document.getElementById("bg-danger").className += " border-light";
      document.getElementById("bg-info").className += " border-light";
      document.getElementById("bg-dark").className += " border-light";
    } else if (colourPicked == 'info'){
      // remove border-0 class from selected
      document.getElementById("bg-info").classList.remove("border-light");
      // hide border for remaining colours
      document.getElementById("bg-primary").className += " border-light";
      document.getElementById("bg-secondary").className += " border-light";
      document.getElementById("bg-success").className += " border-light";
      document.getElementById("bg-danger").className += " border-light";
      document.getElementById("bg-warning").className += " border-light";
      document.getElementById("bg-dark").className += " border-light";
    } else if (colourPicked == 'dark'){
      // remove border-0 class from selected
      document.getElementById("bg-dark").classList.remove("border-light");
      // hide border for remaining colours
      document.getElementById("bg-primary").className += " border-light";
      document.getElementById("bg-secondary").className += " border-light";
      document.getElementById("bg-success").className += " border-light";
      document.getElementById("bg-danger").className += " border-light";
      document.getElementById("bg-warning").className += " border-light";
      document.getElementById("bg-info").className += " border-light";
    }
    // update textarea to be sent to database
    $("#colourPicker").text(colourPicked);
   });
});
