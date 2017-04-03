@extends('layouts.app')

@section('content')

<!-- Facebook login status and GRAPH API calls handling -->
<script>
  function loginChecker() {
    FB.api('/me', function(response) {
      document.getElementById('status').innerHTML =
        'Thanks for logging in, ' + response.name + '!';
    });
  };

  function statusChangeCallback(response) {
    var photos = document.getElementById('fb_photos');
    var posts = document.getElementById('fb_posts');

    if (response.status === 'connected') {
      loginChecker();

      // Getting data from Graph Api
      FB.api('/me','GET',
        {"fields":"id,name,photos,posts.limit(3){permalink_url,story},albums.limit(3){cover_photo,picture}"},
        function(response) {
          response.albums.data.forEach(function (value) {
            var image = document.createElement('img');
            image.src = value.picture.data.url;
            image.style.height="200px";
            image.style.width="200px";
            image.style.margin = "10px";
            photos.appendChild(image);
          });

          response.posts.data.forEach(function (value) {
            var post = document.createElement('div');
            post.classList.add("fb-post");
            post.dataset.href=value.permalink_url;
            post.dataset.width="700";
            post.dataset.showText="true";
            post.style.margin = "10px";
            posts.appendChild(post);
          });
          FB.XFBML.parse();
        }
      )
    } else {
      document.getElementById('status').innerHTML = 'Please log into this app.';
      while (photos.hasChildNodes()) {
        photos.removeChild(photos.firstChild);
      };
      while (posts.hasChildNodes()) {
        posts.removeChild(posts.firstChild);
      };
    };
  };
  window.fbAsyncInit = function() {
    var fbInitEnv={{env('FACEBOOK_APP_ID')}};
    FB.init({
      appId      : `{${fbInitEnv}}`,
      cookie     : true,
      xfbml      : true,
      version    : 'v2.8'
    });

    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  };
</script>

<div class="container">
  <div class="row">

    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading">Dashboard</div>
        <div class="panel-body">
            You are logged in!
        </div>
      </div>

      <div class="panel panel-default">
        <div class="panel-heading">Your Facebook</div>
        <div class="panel-body text-center">

          <a class="fb-login-button" data-max-rows="1" data-size="large" data-show-faces="false" data-auto-logout-link="true" data-scope="user_photos,user_posts" onlogin=fbAsyncInit></a>

          <div id="status"></div>

          <h4>Your photos</h4>
          <div id="fb_photos"></div>

          <h4>Your last posts</h4>
          <div id="fb_posts"></div>
        </div>
      </div>
      
    </div>
  </div>
</div>
@endsection
