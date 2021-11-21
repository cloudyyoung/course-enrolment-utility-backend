<?php

Flight::render('_accounts_header', array(), 'header');
Flight::render('_accounts_footer', array(), 'footer');

$uid = $user->id;
$devices = Flight::sql("SELECT * FROM `users_device` WHERE `uid`='$uid'  ", true);

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
            <a href="devices" i18n="profile.devices">Devices</a>
        </li>
    </ul>
</div>


<div class="container">
    <div class="hero bg-gray">
        <div class="hero-body">
            <h1 i18n="profile.devices">Devices</h1>
            <p i18n="profile.devices.description"></p>
        </div>
    </div>
</div>



<div class="container">
    <div class="columns">
        <div class="column col-12 col-sm-12">
            <h3>All devices</h3>
        </div>

        <!--One device-->
        <div class="column col-4 col-sm-12 col-md-6">
            <div class="tile tile-centered" id="current-device">
                <div class="tile-content">
                    <div class="tile-title device-name">Device name</div>
                    <small class="tile-subtitle text-gray device-ip">Unknown IP</small>
                    <small class="tile-subtitle text-gray device-location">Unknown location</small>
                    <small class="tile-subtitle text-gray">(This device)</small>
                </div>
                <div class="tile-action hidden">
                    <button class="btn btn-link btn-action tooltip delete-device" data-tooltip="Delete"><i class="icon icon-cross"></i></button>
                </div>
            </div>
        </div>


        <?php foreach ($devices as $device) : ?>
            <div class="column col-4 col-sm-12 col-md-6">
                <div class="tile tile-centered">
                    <div class="tile-content">
                        <div class="tile-title device-name"><?php echo $device->device_name ?></div>
                        <small class="tile-subtitle text-gray device-ip"><?php echo $device->device_ip ?></small>
                        <small class="tile-subtitle text-gray device-location"><?php echo $device->city ?> <?php echo $device->region ?> <?php echo $device->country ?></small>
                    </div>
                    <div class="tile-action">
                        <button class="btn btn-link btn-action tooltip delete-device" data-tooltip="Delete"><i class="icon icon-cross"></i></button>
                    </div>
                </div>
            </div>
        <?php endforeach ?>

    </div>
</div>

<div class="modal modal-sm" id="modal-delete-device-confirm">
    <a class="modal-overlay close" aria-label="Close"></a>
    <div class="modal-container" role="document">
        <div class="modal-header">
            <a class="btn btn-clear float-right close" aria-label="Close"></a>
            <div class="modal-title h5">Are you sure to delete this device?</div>
        </div>
        <div class="modal-body">
            <div class="content">
                <dl>
                    <dt class="device-name"></dt>
                    <dt class="device-ip"></dt>
                    <dt class="device-location"></dt>
                </dl>
                <p>Your account will be signed out on this device.</p>
            </div>
        </div>
        <div class="modal-footer">
            <a class="btn btn-link close" i18n="dismiss">Dismiss</a>
            <button class="btn btn-primary" i18n="confirm">Confirm</button>
        </div>
    </div>
</div>

<script>
    var e = $.device();
    $('#current-device .device-name').text(e.os.name + ' ' + e.os.version + ' ' + e.browser.name + ' ' + e.browser.version);
    $.ajax({
        type: "POST",
        url: 'http://ip-api.com/json/',
        success: function(ret, statusText, xhr) {
            $('#current-device .device-ip').text(ret.query);
            $('#current-device .device-location').text(ret.city + ' ' + ret.regionName + ' ' + ret.country);
        },
        error: function(result, textStatus, errorThrown) {

        },
        complete: function() {
            $('#current-device .device-ip').removeClass("loading");
        }
    });

    $('.modal .close').click(function() {
        $(this).parents().find('.modal').removeClass('active');
    });

    $('.delete-device').click(function() {
        $('#modal-delete-device-confirm').find('.device-name').text($(this).parent().parent().children('.tile-content').children('.device-name').text());
        $('#modal-delete-device-confirm').find('.device-ip').text($(this).parent().parent().children('.tile-content').children('.device-ip').text());
        $('#modal-delete-device-confirm').find('.device-location').text($(this).parent().parent().children('.tile-content').children('.device-location').text());
        $('#modal-delete-device-confirm').addClass('active');
    });
</script>