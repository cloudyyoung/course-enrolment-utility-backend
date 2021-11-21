<?php

Flight::render('_accounts_header', array(), 'header');
Flight::render('_accounts_footer', array(), 'footer');

$uid = $user->id;
$subscription = Flight::sql("SELECT * FROM `users_subscription` WHERE `uid`='$uid'  ");
$subscription_history = Flight::sql("SELECT * FROM `users_subscription_history` WHERE `uid`='$uid' ORDER BY `id` DESC LIMIT 20  ", true);

?>

<div class="container">
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/" i18n="account">Account</a>
        </li>
        <li class="breadcrumb-item">
            <a href="../profile" i18n="profile">Profile</a>
        </li>
        <li class="breadcrumb-item">
            <a href="subscription" i18n="profile.subscription">Subscription</a>
        </li>
    </ul>
</div>


<div class="container">
    <div class="hero bg-gray">
        <div class="hero-body">
            <h1 i18n="profile.subscription">Subscription</h1>
            <p i18n="profile.subscription.description"></p>
        </div>
    </div>
</div>


<div class="container">
    <div class="columns">

        <div class="column col-12 col-sm-12" id="subscription">

            <h3 i18n="profile.subscription.current-status">Current status</h3>

            <div class="empty hidden">
                <div class="empty-icon">
                    <i class="icon icon-cross"></i>
                </div>
                <p class="empty-title h5" i18n="profile.subscription.have-no-subscription">You have no subscription</p>
                <p class="empty-subtitle" i18n="profile.subscription.description"></p>
                <div class="empty-action">
                    <button class="btn btn-primary" i18n="profile.subscription.activate-subscription" id="sub-activate">Activate subscription</button>
                </div>
            </div>


            <div class="have hidden">
                <p>
                    <span id="sub-ends">Your subscription will end on yyyy-mm-dd.</span>
                    <span id="sub-days-left">There are xx days left.</span>
                    <progress class="progress" id="sub-progress" value="25" max="100"></progress>
                </p>
                <button class="btn btn-primary" i18n="profile.subscription.renew-your-subscription" id="sub-renew">Renew your subscription</button>
            </div>

        </div>

    </div>
</div>


<script>
    var sub_starts = "<?php echo $subscription->subscription_starts ?>";
    var sub_ends = "<?php echo $subscription->subscription_ends ?>";
    var sub_starts_timestamp = (new Date(sub_starts).getTime() / 1000);
    var sub_ends_timestamp = (new Date(sub_ends).getTime() / 1000);
    var days_left = (sub_ends_timestamp - sub_starts_timestamp) / 24 / 60 / 60;
    var now_timestamp = (new Date().getTime() / 1000);

    if (days_left > 0) {
        $('#subscription .have').show();
        $('#subscription .empty').hide();
        $('#sub-ends').text($.i18n.prop('profile.subscription.your-subscription-ends').dTR({
            "sub-ends": sub_ends
        }));
        $('#sub-progress').attr('value', now_timestamp - sub_starts_timestamp);
        $('#sub-progress').attr('max', sub_ends_timestamp - sub_starts_timestamp);
        $('#sub-days-left').text($.i18n.prop('profile.subscription.days-left').dTR({
            "days-left": days_left
        }));
    } else {
        $('#subscription .have').hide();
        $('#subscription .empty').show();
    }
</script>



<div class="container">
    <div class="columns">

        <div class="column col-12 col-sm-12" id="history">

            <h3 i18n="profile.subscription.payment-history">Payment history</h3>

            <div class="empty hidden">
                <div class="empty-icon">
                    <i class="icon icon-cross"></i>
                </div>
                <p class="empty-title h5" i18n="profile.subscription-history.have-no-history">You have no subscription history</p>
            </div>

            <div class="have hidden">
                <?php foreach ($subscription_history as $history) : ?>
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-left"><a class="timeline-icon icon-lg"><i class="icon icon-time"></i></a></div>
                            <div class="timeline-content">
                                <div class="tile">
                                    <div class="tile-content">
                                        <p class="tile-subtitle"><?php echo date('M d, Y', strtotime($history->time)) ?></p>
                                        <p class="tile-title"><span class="text-primary" i18n="profile.subscription.activate">Activate</span> <?php echo $history->sub_days ?> days subscription</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>

        </div>
    </div>
</div>

<script>
    var history_empty = "<?php echo empty($subscription_history) ?>";
    if (history_empty) {
        $('#history .have').hide();
        $('#history .empty').show();
    } else {
        $('#history .have').show();
        $('#history .empty').hide();
    }
</script>

