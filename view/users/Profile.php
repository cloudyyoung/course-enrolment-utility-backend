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
            <a href="profile" i18n="profile">Profile</a>
        </li>
    </ul>
</div>


<div class="container">
    <div class="hero bg-gray">
        <div class="hero-body">
            <h1 i18n="profile">Profile</h1>
            <p i18n="profile.description"></p>
        </div>
    </div>
</div>


<div class="container">
    <div class="columns">

        <div class="column col-4 col-sm-4 col-xs-6" id="subscription">

            <h3 i18n="profile.subscription" i18n="profile.subscription"></h3>
            <a class="btn btn-primary" href="profile/subscription" i18n="manage"></a>

        </div>

        <div class="column col-4 col-sm-4 col-xs-6" id="devices">

            <h3>Devices</h3>
            <a class="btn btn-primary" i18n="manage" href="profile/devices"></a>

        </div>

        <div class="column col-4 col-sm-4 col-xs-6" id="quota">

            <h3>Quota</h3>
            <button class="btn btn-primary" i18n="manage"></button>

        </div>

    </div>


    <div class="columns">

        <div class="column col-12 col-sm-12" id="profile">

            <h3 i18n="profile"></h3>
            <div class="form-horizontal">
                <div class="form-group">
                    <div class="col-3 col-sm-12">
                        <label class="form-label" for="input-example-1" i18n="profile.nickname"></label>
                    </div>
                    <div class="col-9 col-sm-12">
                        <input class="form-input" type="text" id="input-example-1" placeholder="<?php echo $user->nickname ?>" value="<?php echo $user->nickname ?>">
                        <p class="form-input-hint" i18n="profile.nickname.description"></p>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-3 col-sm-12">
                        <label class="form-label" for="input-example-1" i18n="profile.qq"></label>
                    </div>
                    <div class="col-9 col-sm-12">
                        <input class="form-input" type="text" id="input-example-1" placeholder="<?php echo $user->qq ?>" value="<?php echo $user->qq ?>">
                        <p class="form-input-hint" i18n="profile.qq.description"></p>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-3 col-sm-12">
                        <label class="form-label" for="input-example-1" i18n="profile.email"></label>
                    </div>
                    <div class="col-9 col-sm-12">
                        <input class="form-input" type="text" id="input-example-1" placeholder="<?php echo $user->email ?>" value="<?php echo $user->email ?>">
                        <p class="form-input-hint" i18n="profile.email.description"></p>
                    </div>
                </div>
            </div>

            <button class="btn btn-lg btn-primary" id="apply-all-changes" i18n="profile.apply-all-changes"></button>


        </div>

    </div>
</div>