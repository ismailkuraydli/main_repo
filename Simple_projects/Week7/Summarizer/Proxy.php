<?php
function get_data($url) {
    $ch = curl_init();
    $timeout = 5;
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_AUTOREFERER,true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION,true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_CONNECTIONTIMEOUT,10);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}
$url = $_POST['url'];
echo get_data($url);
