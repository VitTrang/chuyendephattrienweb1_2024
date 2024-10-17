<?php
$url_host = $_SERVER['HTTP_HOST'];

$pattern_document_root = addcslashes(realpath($_SERVER['DOCUMENT_ROOT']), '\\');

$pattern_uri = '/' . $pattern_document_root . '(.*)$/';

preg_match_all($pattern_uri, __DIR__, $matches);

$url_path = $url_host . $matches[1][0];

$url_path = str_replace('\\', '/', $url_path);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3042-conten.php</title>
</head>

<body>
<section class="repair-section">
    <div class="container">
        <div class="row">
            
            <div class="text-content col-md-6">
                <div class="divider">
                    <div class="logo">
                        <hr>
                        <div class="icon">
                            <img src="images/maintenance(1).png" alt="icon" style="height: 40px;">
                        </div>
                        <hr>
                    </div>
                    <h1>We Use Genuine Parts to Fix Your Device</h1>
                    <hr>
                    <h3>Low Pricing & Faster Repair Services</h3>
                    <p>
                        Dolor sit amet consectetur elit eiusmod tempor dunt aliqua uts veniam tempore quis sed ipsum knostrud ipsum lorem amet consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliquat rem ipsum dolor sit amet, consectetur adipisicing.
                    </p>
                    <div class="info-boxes">
                        <div class="info-box">
                            <h2>30min</h2>
                            <p>Avg. Time Of Repair</p>
                        </div>
                        <div class="info-box">
                            <h2>170+</h2>
                            <p>Locations Count</p>
                        </div>
                        <div class="info-box">
                            <h2>450+</h2>
                            <p>Devices Fixed Monthly</p>
                        </div>
                    </div>
                </div>
            </div>
            
           
            <div class="image-content col-md-6">
                <img src="images/1.png" alt="1">
                <img src="images/2.png" alt="2">
                <img src="images/3.png" alt="3">
                <img src="images/4.png" alt="4">
                <img src="images/5.png" alt="5">
                <img src="images/6.png" alt="6">
                <img src="images/7.png" alt="7">
                <img src="images/8.png" alt="8">
                <img src="images/9.png" alt="9">
                <img src="images/10.png" alt="10">
                <img src="images/11.png" alt="11">
                <img src="images/12.png" alt="12">
                <img src="images/13.png" alt="13">
                <img src="images/14.png" alt="14">
            </div>
        </div>
    </div>
</section>

    <script src="js/jquery-2.1.4.min.js"></script>
</body>
</html>