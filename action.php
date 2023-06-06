<?php
include 'session.php';

if (isset($_POST['submit'])) {
    $contentData = $_POST['content'];
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
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_POST,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
    $result = curl_exec($ch);
    curl_error($ch);
    curl_close($ch);

    if($result){
        $_SESSION['successMsg'] = "Post Sucessfully..";
        header('location:posttext.php');
    }
}

if(isset($_POST['submitArticle'])){
    $blogTitle = $_POST['blogTitle'];
    $blogContent = $_POST['blogContent'];
    $blogUrl = $_POST['blogUrl'];
    $tags = $_POST['tags'];
    $tags = $tags . "#" .$tags;
    echo $tags;
}
