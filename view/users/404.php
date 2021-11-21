<?php

Flight::render('_accounts_header', array(), 'header');
Flight::render('_accounts_footer', array(), 'footer');

?>


<div class="container">
    <div class="columns">
        <div class="column col-12">
            <div class="empty signout">
                <div class="empty-icon"><i class="icon icon-3x icon-cross"></i></div>
                <p class="empty-title h5">404</p>
                <p class="empty-subtitle" i18n="page.404.description"></p>
                <div class="empty-action">
                    <button class="btn btn-primary" id="return" i18n="back"></button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#return').click(function() {
        history.back();
    });
</script>