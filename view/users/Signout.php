<?php

Flight::render('_accounts_header', array(), 'header');
Flight::render('_accounts_footer', array(), 'footer');

?>


<div class="container">
    <div class="columns">
        <div class="column col-12" id="sign-out-success">
            <div class="empty signout">
                <div class="empty-icon"><i class="icon icon-3x icon-check"></i></div>
                <p class="empty-title h5" i18n="sign-out-success"></p>
                <p class="empty-subtitle" i18n="sign-out-success.description"></p>
                <div class="empty-action">
                    <button class="btn btn-primary" id="sign-in-another-account" i18n="sign-in-another-account"></button>
                </div>
            </div>
        </div>
        <div class="column col-12" id="sign-out-success">
            <div class="empty signout">
                <div class="empty-icon"><i class="icon icon-3x icon-cross"></i></div>
                <p class="empty-title h5" i18n="sign-out-fail"></p>
                <p class="empty-subtitle" i18n="sign-out-fail.description"></p>
                <div class="empty-action">
                    <button class="btn btn-primary" id="return" i18n="back"></button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('.col-12').hide();

    $.ajax({
        type: "POST",
        url: '/accounts/signout',
        success: function() {
            $('#sign-out-success').show();
            $('#avatar-button').hide();
            $('.avatar-box').remove();
        },
        error: function() {

        }
    });

    $('#sign-in-another-account').click(function() {
        window.location.href = "/signin";
    });

    $('#return').click(function() {
        history.back();
    });
</script>