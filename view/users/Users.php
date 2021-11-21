<?php

Flight::render('_accounts_header', array(), 'header');
Flight::render('_accounts_footer', array(), 'footer');

$uid = $user->id;

$devices = Flight::sql("SELECT * FROM `users_device` WHERE `uid`='$uid'  ");
$devices_count = count(((Array)$devices));

$subscription = Flight::sql("SELECT * FROM `users_subscription` WHERE `uid`='$uid'  ");

?>

<div class="container">
    <div class="hero bg-gray">
        <div class="hero-body">
            <h1 i18n="account.overview.title"></h1>
            <p><span id="greeting"></span>, <?php echo $user->nickname ?>.</p>
        </div>
    </div>
</div>

<div class="container">
    <div class="columns">
        <div class="column col-4 col-sm-12">
            <div class="card">
                <div class="card-image"><img class="img-responsive" src="/img/pink.jfif" alt="Subscription"></div>
                <div class="card-header">
                    <a class="btn btn-primary float-right" href="/accounts/profile/subscription" id="sub-btn"></a>
                    <div class="card-title h5" i18n="profile.subscription">Subscription</div>
                    <div class="card-subtitle text-gray" i18n="profile.subscription.description">Your supreme pass to all services</div>
                </div>
                <div class="card-body">
                    <span id="sub-ends">Your subscription will end on 2019-12-15.</span>
                </div>
            </div>
        </div>
        <div class="column col-4 col-sm-12">
            <div class="card">
                <div class="card-image"><img class="img-responsive" src="/img/devices.png" alt="Subscription"></div>
                <div class="card-header">
                    <a class="btn btn-primary float-right" i18n="manage" href="/accounts/profile/devices">Manage</a>
                    <div class="card-title h5">Devices</div>
                    <div class="card-subtitle text-gray">All devices of your account</div>
                </div>
                <div class="card-body" id="device-count">You currently have 1 device.</div>
            </div>
        </div>
        <div class="column col-4 col-sm-12">
            <div class="card">
                <div class="card-image"><img class="img-responsive" src="/img/quota.jfif" alt="Subscription"></div>
                <div class="card-header">
                    <button class="btn btn-primary float-right" i18n="manage">Manage</button>
                    <div class="card-title h5">Quota</div>
                    <div class="card-subtitle text-gray">Quota balance for each service.</div>
                </div>
                <div class="card-body">Your current quota is 12,394.</div>
            </div>
        </div>
    </div>
</div>

<script>
    now = new Date(), hour = now.getHours()
    if (hour < 6) {
        $('#greeting').text($.i18n.prop("greeting.good-morning"));
    } else if (hour < 9) {
        $('#greeting').text($.i18n.prop("greeting.good-morning"));
    } else if (hour < 12) {
        $('#greeting').text($.i18n.prop("greeting.good-morning"));
    } else if (hour < 14) {
        $('#greeting').text($.i18n.prop("greeting.good-noon"));
    } else if (hour < 17) {
        $('#greeting').text($.i18n.prop("greeting.good-afternoon"));
    } else if (hour < 19) {
        $('#greeting').text($.i18n.prop("greeting.good-afternoon"));
    } else if (hour < 22) {
        $('#greeting').text($.i18n.prop("greeting.good-evening"));
    } else {
        $('#greeting').text($.i18n.prop("greeting.good-evening"));
    }
</script>

<script>
    var sub_ends = "<?php echo $subscription->subscription_ends ?>";
    var sub_ends_timestamp = (new Date(sub_ends).getTime()/1000);
    var now_timestamp = (new Date().getTime()/1000);

    var device_count = "<?php echo $devices_count ?>";

    if(sub_ends_timestamp - now_timestamp > 0){
        $('#sub-ends').text($.i18n.prop('profile.subscription.your-subscription-ends').dTR({"sub-ends": sub_ends}));
        $('#sub-btn').text($.i18n.prop('renew'));
    }else{
        $('#sub-ends').text($.i18n.prop('profile.subscription.have-no-subscription'));
        $('#sub-btn').text($.i18n.prop('activate'));
    }

</script>