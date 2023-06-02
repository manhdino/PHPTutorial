<?php

function HttpGet($url, $file = null)
{
    $userAgent = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36';
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

    if (!empty($file)) {

        curl_setopt($ch, CURLOPT_FILE, $file);
    }

    $result = curl_exec($ch);

    curl_close($ch);

    if (!empty($file)) {
        fclose($file);
    }

    return $result;
}

function DownloadImg($url, $folder)
{
    $filename = basename($url);
    $image = fopen($folder . '/' . $filename, 'a+');
    return HttpGet($url, $image);
}