<?php
include '../session.php';

$accessToken = array (
    'Authorization: Bearer '. $_SESSION['accessToken']
);
$url = "https://api.linkedin.com/v2/me";

$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_POST,false);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch,CURLOPT_HTTPHEADER,$accessToken);
$result = curl_exec($ch);
curl_close($ch);
curl_error($ch);

$result = json_decode($result,true);
$_SESSION['personId'] = $result["id"];
echo "<pre>";
print_r($result);

// echo $_SESSION['personId'];
?>