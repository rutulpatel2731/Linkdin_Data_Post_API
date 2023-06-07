<?php
include '../session.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <a href="https://www.linkedin.com/oauth/v2/authorization?response_type=code&client_id=78gcdp6x5wfpyb&redirect_uri=http://php/Linkdin/GetToken/index.php&scope=r_liteprofile%20r_emailaddress%20w_member_social">Click Here</a>
</body>

</html>
<?php
if (isset($_GET['code'])) {
    $getCode = $_GET['code'];
    $url = "https://www.linkedin.com/oauth/v2/accessToken?code=$getCode&grant_type=authorization_code&client_id=78gcdp6x5wfpyb&client_secret=o8K0L1R39ny2gLlY&redirect_uri=http://php/Linkdin/GetToken/index.php";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($result, true);
    $_SESSION['accessToken'] = $result["access_token"];
}
if (isset($_SESSION['accessToken'])) {
    $accessToken = array(
        'Authorization: Bearer ' . $_SESSION['accessToken']
    );
    $url = "https://api.linkedin.com/v2/me";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $accessToken);
    $result = curl_exec($ch);
    curl_close($ch);
    curl_error($ch);

    $result = json_decode($result, true);
    $_SESSION['personId'] = $result["id"];
    echo "<pre>";
    print_r($result);
}
?>