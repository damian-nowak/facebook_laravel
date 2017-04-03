@extends('layouts.app')

@section('content')
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
                  </div>
            </div>
        </div>
    </div>
</div>
@endsection
