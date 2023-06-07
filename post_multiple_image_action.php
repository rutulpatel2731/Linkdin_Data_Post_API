<?php
include 'session.php';
function postImgsResponse($msg, $status)
{
    $_SESSION['imgsMessage'] = $msg;
    $_SESSION['imgPostsStatus'] = $status;
    header('location:postmultipleimage.php');
}
if (isset($_POST['submit'])) {
    $content = $_POST['content'];
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
    $mediaAsset = [];
    $ch = curl_init();
 
    for ($i = 0; $i < count($_FILES['image']["tmp_name"]); $i++) {
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        $result = curl_exec($ch);
        // for get the upload url and assest
        $result = json_decode($result, true);

        array_push($mediaAsset, array(
            "status" => "READY",
            "description" => array(
                "text" => "Center stage!"
            ),
            "media" => $result["value"]["asset"],
            "title" => array(
                "text" => "LinkedIn Talent Connect 2021"
            )
        ));
         {
            $header = array(
                "Content-Type: multipart/form-data",
                "X-Restli-Protocol-Version: 2.0.0",
                "Authorization: Bearer " . $_SESSION['accessToken']
            );
            $image = $_FILES['image']['tmp_name'][$i];
            $cf['file'] = new CURLFile($image);
            curl_setopt($ch, CURLOPT_URL, $result["value"]["uploadMechanism"]["com.linkedin.digitalmedia.uploading.MediaUploadHttpRequest"]["uploadUrl"]);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $cf);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            $result = curl_exec($ch);
        }

        
    }

    $data = '{
            "author": "urn:li:person:' . $_SESSION['personId'] . '",
            "lifecycleState": "PUBLISHED",
            "specificContent": {
                "com.linkedin.ugc.ShareContent": {
                    "shareCommentary": {
                        "text": "' . $content . '"
                    },
                    "shareMediaCategory": "IMAGE",
                    "media": 
                      ' . json_encode($mediaAsset) . '
                }
            },
            "visibility": {
                "com.linkedin.ugc.MemberNetworkVisibility": "PUBLIC"
            }
        }';
        echo $data;
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
        postImgsResponse("Your Post Uploaded Successfully", true);
    } else {
        print_r($result);
        postImgsResponse("Something went wrong", false);
    }
    if (curl_errno($ch)) {
        curl_error($ch);
    }
}
