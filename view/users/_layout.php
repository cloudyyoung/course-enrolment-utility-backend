<!DOCTYPE html>
<html lang="en">

<head>
    <?php echo $header ?>
</head>

<body>



    <header class="navbar">
        <section class="navbar-section">
            <a href="/accounts" class="navbar-brand mr-2 text-primary" i18n="ichi-account"></a>
            <a href="/accounts/profile" class="btn btn-link" i18n="profile"></a>
            <a href="/accounts/security" class="btn btn-link" i18n="security"></a>
        </section>
        <section class="navbar-center"></section>
        <section class="navbar-section">
            <a id="avatar-button">
                <figure class="avatar avatar-lg hide-md">
                    <img src="https://q.qlogo.cn/g?b=qq&nk=<?php echo $user->qq ?>&s=5" alt="<?php echo $user->nickname ?>" data-initial="<?php echo $user->nickname ?>">
                </figure>
                <figure class="avatar avatar-md show-md hide-xs">
                    <img src="https://q.qlogo.cn/g?b=qq&nk=<?php echo $user->qq ?>&s=5" alt="<?php echo $user->nickname ?>" data-initial="<?php echo $user->nickname ?>">
                </figure>
                <figure class="avatar avatar-sm show-xs">
                    <img src="https://q.qlogo.cn/g?b=qq&nk=<?php echo $user->qq ?>&s=5" alt="<?php echo $user->nickname ?>" data-initial="<?php echo $user->nickname ?>">
                </figure>
            </a>
        </section>
    </header>

    <script>
        $('body').click(function(e) {
            var target = $(e.target);
            if (!target.is('.avatar-box *') && !target.is('#avatar-button *')) {
                $('.avatar-box').hide();
            }
        });

        $('#avatar-button').click(function() {
            $('.avatar-box').show();
        });
    </script>


    <div class="avatar-box">
        <ul class="menu">
            <li class="menu-item">
                <div class="tile tile-centered">
                    <div class="tile-icon"><img class="avatar" src="https://q.qlogo.cn/g?b=qq&nk=<?php echo $user->qq ?>&s=5" alt="<?php echo $user->nickname ?>"></div>
                    <div class="tile-content"><?php echo $user->nickname ?></div>
                </div>
            </li>
            <li class="divider" data-content="PROFILE"></li>
            <li class="menu-item">
                <div class="tile tile-centered">
                    <div class="tile-content"><?php echo $user->qq ?></div>
                </div>
                <div class="tile tile-centered">
                    <div class="tile-content"><?php echo $user->email ?></div>
                </div>
            </li>
            <li class="divider" data-content="OPERATION"></li>
            <li class="menu-item"><a href="/accounts" i18n="my-ichi-account">My Ichi Account</a></li>
            <li class="menu-item"><a href="/accounts/signswitch" i18n="sign-switch">Switch</a></li>
            <li class="menu-item"><a href="/accounts/signout" i18n="sign-out">Sign out</a></li>
        </ul>
    </div>

    <?php echo $body ?>

    <footer class="footer">
        <a class="btn btn-link text-dark" href="/terms/TermsAndConditions" target="_blank" i18n="terms.terms-and-conditions"></a>
        <a class="btn btn-link text-dark" href="/terms/PrivacyPolicy" target="_blank" i18n="terms.privacy-policy"></a>
        <a class="btn btn-link text-dark" href="/terms/CookiePolicy" target="_blank" i18n="terms.cookie-policy"></a>
        <a class="btn btn-link text-dark" href="/terms/Disclaimer" target="_blank" i18n="terms.disclaimer"></a>
        <p class="text-dark">Copyright © <?php echo date('Y') ?> Ichi. All Rights Reserved.</p>
    </footer>

    <?php echo $footer ?>
</body>

</html>