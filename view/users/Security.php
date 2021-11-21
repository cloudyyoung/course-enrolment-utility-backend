<?php

Flight::render('_accounts_header', array(), 'header');
Flight::render('_accounts_footer', array(), 'footer');

?>

<div class="container">
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/" i18n="account">Account</a>
        </li>
        <li class="breadcrumb-item">
            <a href="security" i18n="security">Security</a>
        </li>
    </ul>
</div>

<div class="container">
    <div class="hero bg-gray">
        <div class="hero-body">
            <h1 i18n="security"></h1>
            <p i18n="security.description"></p>
        </div>
    </div>
</div>

<div class="container">
    <div class="columns">

        <div class="column col-12 col-sm-12" id="password">

            <h3 i18n="security.password">Password</h3>
            <div class="form-horizontal">
                <div class="form-group">
                    <div class="col-3 col-sm-12">
                        <label class="form-label" for="input-example-1" i18n="security.new-pwd">New password</label>
                    </div>
                    <div class="col-9 col-sm-12">
                        <input class="form-input" id="input-example-1" type="password" placeholder="**********">
                        <p class="form-input-hint" i18n="security.new-pwd.description"></p>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-3 col-sm-12">
                        <label class="form-label" for="input-example-1" i18n="security.renew-pwd">Re-enter new password</label>
                    </div>
                    <div class="col-9 col-sm-12">
                        <input class="form-input" id="input-example-1" type="password" placeholder="**********">
                        <p class="form-input-hint" i18n="security.renew-pwd.description"></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="column col-12 col-sm-12">
            <button class="btn btn-lg btn-primary" id="change-my-password" i18n="security.change-my-password">Change my password</button>
        </div>

    </div>
</div>


<div class="modal modal-lg" id="modal-identity-verification">
    <a class="modal-overlay" aria-label="Close"></a>
    <div class="modal-container" role="document">
        <div class="modal-header"><a class="btn btn-clear float-right close" aria-label="Close"></a>
            <div class="modal-title h5" i18n="security.identity-verification">Indentity Verification</div>
        </div>
        <div class="modal-body">
            <div class="content">
                <p i18n="security.identity-verification.description"></p>
                <div class="form-group">
                    <div class="col-12 col-sm-12">
                        <label class="form-label" for="modal-identity-verification-password" i18n="security.current-pwd">Current password</label>
                    </div>
                    <div class="col-12 col-sm-12">
                        <input class="form-input" id="modal-identity-verification-password" type="password" placeholder="">
                        <p class="form-input-hint" i18n="security.current-pwd">Enter your current password.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a class="btn btn-link close" i18n="cancel">Cancel</a>
            <button class="btn btn-primary" i18n="submit">Submit</button>
        </div>
    </div>
</div>


<script>
    $('#change-my-password').click(function() {
        $('#modal-identity-verification').addClass('active');
        $('#modal-identity-verification-password').val("");
    });

    $('.modal .close').click(function() {
        $(this).parents().find('.modal').removeClass('active');
    });
</script>