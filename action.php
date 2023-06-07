<?php
include 'session.php';

function response($msg, $status)
{
    $_SESSION['message'] = $msg;
    $_SESSION['postStatus'] = $status;
    header('location:posttext.php');
}
function articleResponse($msg, $status)
{
    $_SESSION['articleMsg'] = $msg;
    $_SESSION['articleStatus'] = $status;
    header('location:postartical.php');
}
echo isset($_POST['submit']);
echo isset($_POST['submitArticle']);
if (isset($_POST['submit'])) {
    $contentData = $_POST['content'];
    $contentData = str_replace("\r\n","\\n",$contentData);
    $url = "https://api.linkedin.com/v2/ugcPosts";
    $header = array(
        "Content-Type: application/json",
        "X-Restli-Protocol-Version: 2.0.0",
        "Authorization: Bearer " . $_SESSION['accessToken']
    );
    $data = '
    {
        "author": "urn:li:person:' . $_SESSION['personId'] . '",
        "lifecycleState": "PUBLISHED",
        "specificContent": {
            "com.linkedin.ugc.ShareContent": {
                "shareCommentary": {
                    "text": "' . $contentData . '"
                },
                "shareMediaCategory": "NONE"
            }
        },
        "visibility": {
            "com.linkedin.ugc.MemberNetworkVisibility": "PUBLIC"
        }
    }';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    $result = curl_exec($ch);
    $result = json_decode($result);
    if (property_exists($result, "id")) {
        response("Post Successfully..", true);
    } else {
        response("Something Went Wrong.", false);
    }
    if (curl_errno($ch)) {
        curl_error($ch);
    }
    curl_close($ch);
} else if (isset($_POST['submitArticle'])) {
    $blogTitle = $_POST['blogTitle'];
    $blogContent = trim($_POST['blogContent']);
    $blogContent = str_replace("\r\n","\\n",$blogContent);
    $blogUrl = $_POST['blogUrl'];
    $tags = $_POST['tags'];
    $tags = json_decode($tags, true);
    $values = array();
    for ($i = 0; $i < count($tags); $i++) {
        $strVal = str_replace("#", "", $tags[$i]["value"]);
        $strVal = " #" . $strVal;
        $values[] = $strVal;
    }
    $strTag = implode("", $values);
    $blogTitle = $blogTitle . "\\n\\n" . $strTag;
    $header = array(
        "Content-Type: application/json",
        "X-Restli-Protocol-Version: 2.0.0",
        "Authorization: Bearer " . $_SESSION['accessToken']
    );
    $url = "https://api.linkedin.com/v2/ugcPosts";
    $data = '
    {
        "author": "urn:li:person:' . $_SESSION['personId'] . '",
        "lifecycleState": "PUBLISHED",
        "specificContent": {
            "com.linkedin.ugc.ShareContent": {
                "shareCommentary": {
                    "text": "' . $blogTitle . '"
                },
                "shareMediaCategory": "ARTICLE",
                "media": [
                    {
                        "status": "READY",
                        "description": {
                            "text": "' . $blogContent . '"
                        },
                        "originalUrl": "' . $blogUrl . '",
                        "title": {
                            "text": "Official LinkedIn Blog"
                        }
                    }
                ]
            }
        },
        "visibility": {
            "com.linkedin.ugc.MemberNetworkVisibility": "PUBLIC"
        }
    }';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    $result = curl_exec($ch);
    $result = json_decode($result);
    if (property_exists($result, "id")) {
        articleResponse("Your Article Post Successfully", true);
    } else {
        articleResponse("Something Went Wrong.", false);
    }
    if (curl_errno($ch)) {
        curl_error($ch);
    }
    curl_close($ch);
}
