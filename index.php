<?php

// Admin password
$password = "yourPassword";

// Bandwagon VPS config
// You can get your API key from https://kiwivm.64clouds.com/main.php
$bwh_veid = "123456";
$bwh_apikey = "private_XXXXXXXXXXXXXXXX";
?>

<!-- Config finished -->

<?
$bwh_request = "https://api.64clouds.com/v1/getLiveServiceInfo?veid=".$bwh_veid."&api_key=".$bwh_apikey;
$bwh_info = (Array) json_decode (file_get_contents ($bwh_request));

$bwh_disk_usage = $bwh_info['ve_used_disk_space_b']/$bwh_info['plan_disk']*100;
$bwh_ram_usage = ($bwh_info['plan_ram']/1024-$bwh_info['mem_available_kb'])/($bwh_info['plan_ram']/1024)*100;
$bwh_swap_usage = ($bwh_info['swap_total_kb']-$bwh_info['swap_available_kb'])/$bwh_info['swap_total_kb']*100;
?>

<!-- Header start-->

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Status</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
        <script src="https://cdn.staticfile.org/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdn.staticfile.org/popper.js/1.15.0/umd/popper.min.js"></script>
        <script src="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
        
        <script src="https://cdn.staticfile.org/jquery/3.4.1/jquery.min.js"></script>
        
        <link rel="stylesheet" href="./style.css">
    </head>
    
    <body>
        <nav class="navbar navbar-expand-sm bg-light navbar-light">
            <div class="container">
                <a class="navbar-brand">Status</a>
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="/">Home</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

<!-- Body start -->

<div class="container" style="padding-top: 20px;min-height: 78vh;">
    <div class="card">
        <div class="card-header">bwh <? echo $bwh_info['ip_addresses']['0'] ?></div>
        <div class="card-body">
            <? if ($bwh_info['error'] == false){?>
                Status: <? echo (($bwh_info['ve_status']=="running")?'<span style="color:green">':'<span style="color:red">').$bwh_info['ve_status']."</span>" ?> <br>
                IP: <? echo $bwh_info['ip_addresses']['0'] ?> <br>
                Location: <? echo $bwh_info['node_location'] ?> <br>
                OS: <? echo $bwh_info['os'] ?> <br>
                Disk: 
                <div class="progress">
                    <div class="progress-bar" style="width:<? echo $bwh_disk_usage ?>%">
                        <? echo round($bwh_info['ve_used_disk_space_b']/1024/1024,2).' MB / '.round($bwh_info['plan_disk']/1024/1024,2).'MB' ?>
                    </div>
                </div>
                RAM:
                <div class="progress">
                    <div class="progress-bar" style="width:<? echo $bwh_ram_usage ?>%">
                        <? echo round(($bwh_info['plan_ram']/1024-$bwh_info['mem_available_kb'])/1024,2).'MB / '.round($bwh_info['plan_ram']/1024/1024,2).'MB' ?>
                    </div>
                </div>
                SWAP:
                <div class="progress">
                    <div class="progress-bar" style="width:<? echo $bwh_swap_usage ?>%">
                        <? echo round(($bwh_info['swap_total_kb']-$bwh_info['swap_available_kb'])/1024,2).'MB / '.round($bwh_info['swap_total_kb']/1024,2).'MB' ?>
                    </div>
                </div>
            <? } else {?>
                <div class="alert alert-danger">
                    Faild to request from <a href="https://https://kiwivm.64clouds.com/" class="alert-link">64clouds.com</a>. Please check your veid and apikey.
                </div>
            <? } ?>
        </div> 
        <div class="card-footer">
            <button id="admin" type="button" class="btn btn-primary">admin</button>
        </div>
    </div>
</div>

<!-- Footer start-->

        <hr>
        <footer>
            <div class="container">
                By <a href="https://skywt.cn/">SkyWT</a>
            </div>
        </footer>
    </body>
</html>
