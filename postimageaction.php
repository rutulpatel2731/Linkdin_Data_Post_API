<?php
include 'session.php';
function postImgResponse($msg, $status)
{
    $_SESSION['imgMessage'] = $msg;
    $_SESSION['imgPostStatus'] = $status;
    header('location:postimage.php');
}
if (isset($_POST['submit'])) {
    $content = $_POST['content'];
    $image = $_FILES['image']['name'];
    $allowType = ['image/jpeg', 'image/jpg', 'image/png'];
    if (empty($content) && empty($_FILES['image']['name']) &&(!in_array($_FILES['image']['type'], $allowType))) {
        $_SESSION['content_err'] = "Please Enter Content";
        $_SESSION['image_err'] = "Please Select JPG , PNG , JPEG format..";
        header('location:postimage.php');
    } else {
        $content = str_replace("\r\n", "\\n", $content);
        $header = array(
            "Content-Type: application/json",
            "X-Restli-Protocol-Version: 2.0.0",
            "Authorization: Bearer " . $_SESSION['accessToken']
        );
        $url = "https://api.linkedin.com/v2/assets?action=registerUpload";
        $data = '
    {
        "registerUploadRequest": {
            "recipes": [
                "urn:li:digitalmediaRecipe:feedshare-image"
            ],
            "owner": "urn:li:person:' . $_SESSION['personId'] . '",
            "serviceRelationships": [
                {
                    "relationshipType": "OWNER",
                    "identifier": "urn:li:userGeneratedContent"
                }
            ]
        }
    }';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        $result = curl_exec($ch);
        curl_close($ch);
        // for get the upload url and assest
        $result = json_decode($result, true);
        // print_r($result);
        $_SESSION['uploadUrl'] = $result["value"]["uploadMechanism"]["com.linkedin.digitalmedia.uploading.MediaUploadHttpRequest"]["uploadUrl"];
        $_SESSION['asset'] = $result["value"]["asset"];



        if (isset($_SESSION['uploadUrl']) && isset($_SESSION['asset'])) {
            $header = array(
                "Content-Type: multipart/form-data",
                "X-Restli-Protocol-Version: 2.0.0",
                "Authorization: Bearer " . $_SESSION['accessToken']
            );
            $image = $_FILES['image']['tmp_name'];
            $cf['file'] = new CURLFile($image);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $_SESSION['uploadUrl']);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $cf);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            $result = curl_exec($ch);
            curl_close($ch);



            $data = '{
                "author": "urn:li:person:' . $_SESSION['personId'] . '",
                "lifecycleState": "PUBLISHED",
                "specificContent": {
                    "com.linkedin.ugc.ShareContent": {
                        "shareCommentary": {
                            "text": "' . $content . '"
                        },
                        "shareMediaCategory": "IMAGE",
                        "media": [
                            {
                                "status": "READY",
                                "description": {
                                    "text": "Center stage!"
                                },
                                "media": "' . $_SESSION['asset'] . '",
                                "title": {
                                    "text": "LinkedIn Talent Connect 2021"
                                }
                            }
                        ]
                    }
                },
                "visibility": {
                    "com.linkedin.ugc.MemberNetworkVisibility": "PUBLIC"
                }
            }';
            $header = array(
                "Content-Type: application/json",
                "X-Restli-Protocol-Version: 2.0.0",
                "Authorization: Bearer " . $_SESSION['accessToken']
            );
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://api.linkedin.com/v2/ugcPosts");
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            $result = curl_exec($ch);
            curl_close($ch);
            $result = json_decode($result);
            if (property_exists($result, "id")) {
                postImgResponse("Your Article Post Successfully", true);
            } else {
                postImgResponse("Something Went Wrong", false);
            }
            if (curl_errno($ch)) {
                curl_error($ch);
            }
            curl_close($ch);
        }
    }
}
