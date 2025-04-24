<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/vnd.apple.mpegurl');

$url = 'http://cdns.jp-primehome.com:8000/zhongying/live/playlist.m3u8?cid=gd05&isp=4';
$headers = [
    'Referer: https://www.fujitv.co.jp/',
    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36'
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($http_code === 200 && $response) {
    // Log contents for analysis (in production, save to a file or database)
    file_put_contents('m3u8_contents.txt', $response);
    echo $response;
} else {
    http_response_code(500);
    echo "#EXTM3U\n#EXT-X-ERROR: Failed to fetch playlist";
}
?>