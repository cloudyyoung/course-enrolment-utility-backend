<?php

Flight::render('_signin_header', array(), 'header');
Flight::render('_signin_footer', array(), 'footer');

?>


<div class="signin-bg"></div>
<div class="signin-bg-cover"></div>

<div class="signin-field">

  <div class="columns">
    <div class="col-12">
      <h5 class="brand-title">Ichi</h5>
    </div>
  </div>

  <div class="columns col-oneline">
    <div class="signin-step col-12" id="username">

      <div class="col-12">
        <h4 i18n="sign-in">Sign in</h4>
      </div>

      <div class="col-12 has-icon-left">
        <input class="form-input input-lg" type="text" id="username-input" i18n="signin.username.placeholder">
        <i class="form-icon icon icon-people"></i>
      </div>

      <div class="col-12">
        <button class="btn btn-link" i18n="signin.forgot-my-username">Forget my username</button>
      </div>

      <div class="col-12 right">
        <button class="btn btn-primary" id="username-next" i18n="next">Next</button>
      </div>
    </div>

    <div class="signin-step col-12" id="password">

      <div class="col-12 back">
        <button class="btn btn-sm btn-link" id="back"><i class="icon icon-arrow-left"></i>
          <span id="password-nickname"></span></button>
      </div>

      <div class="col-12">
        <h4 i18n="signin.enter-password">Enter password</h4>
      </div>

      <div class="col-12 has-icon-left">
        <input class="form-input input-lg" type="password" id="password-input" i18n="password">
        <i class="form-icon icon icon-arrow-right"></i>
      </div>

      <div class="col-12">
        <button class="btn btn-link" i18n="signin.forgot-password">Forgot password</button>
      </div>

      <div class="col-12 right">
        <button class="btn btn-primary" i18n="sign-in" id="password-signin">Sign in</button>
      </div>
    </div>

  </div>
</div>

<script>
  document.title = $.i18n.prop("sign-in") + " - Ichi";

  $('.signin-step').hide();
  $('#username').fadeInRight().addClass('active');


  $('#username-next').click(function() {

    if ($(this).hasClass('loading')) {
      return;
    }

    var This = this;
    $(This).addClass("loading");

    $.ajax({
      type: "POST",
      url: '/accounts/exist',
      data: {
        'username': $('#username-input').val()
      },
      success: function(ret, statusText, xhr) {
        $('#password-nickname').text(ret.nickname);
        $.next($('#username'), $('#password'));
        $('#password-input').val("");
      },
      error: function(result, textStatus, errorThrown) {
        Snackbar.show({
          text: $.i18n.prop('signin.' + result.status),
          actionText: $.i18n.prop("dismiss")
        });
      },
      complete: function() {
        $(This).removeClass("loading");
      }
    });
  });


  $('#password-signin').click(function() {

    if ($(this).hasClass('loading')) {
      return;
    }

    var This = this;
    $(This).addClass("loading");

    $.ajax({
      type: "POST",
      url: '/accounts/signin',
      data: {
        'username': $('#username-input').val(),
        'password': $('#password-input').val()
      },
      success: function(ret, statusText, xhr) {
        window.location.href = "/accounts";
      },
      error: function(result, textStatus, errorThrown) {
        Snackbar.show({
          text: $.i18n.prop('signin.' + result.status),
          actionText: $.i18n.prop("dismiss")
        });
      },
      complete: function() {
        $(This).removeClass("loading");
      }
    });
  });

  $('.active input').on('keypress', function(e) {
    if (e.which == 13) {
      $('.active .btn-primary').click();
    }
  });


  $('#back').click(function() {
    $.back($('#password'), $('#username'));
  });
</script>