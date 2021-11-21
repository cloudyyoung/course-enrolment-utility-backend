<?php

Flight::render('_accounts_header', array(), 'header');
Flight::render('_accounts_footer', array(), 'footer');

?>

<script>
    $.ajax({
        type: "POST",
        url: '/accounts/signout',
        complete: function() {
            window.location.href = "/signin";
        }
    });
</script>