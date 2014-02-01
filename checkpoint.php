<?php
require_once("facebook.php");

$config = array(
    'appId' => '570243296401349',
    'secret' => 'f981bcc10659a3b0d311d8457c888559',
    'fileUpload' => false, // optional
    'allowSignedRequest' => false, // optional, but should be set to false for non-canvas apps
);

$facebook = new Facebook($config);
$user_id = $facebook->getUser();
?>
<html>
    <head></head>
    <body>
        <img src="loading.gif" />
        <?php
        if ($user_id) {
            try {
                $link = mysql_connect('localhost', 'root', '') or die(mysql_error());
                $db_selected = mysql_select_db('quizApp', $link) or die(mysql_error());

                $query = mysql_query("SELECT * FROM registrationDetails WHERE userID='" . $user_id . "'");
                $row = mysql_fetch_array($query);
                if ($row)
                    echo ('success');
                else {
                    $user_profile = $facebook->api('/me', 'GET');
                    $firstName = $user_profile['first_name'];
                    $lastName = $user_profile['last_name'];
                    $email = $user_profile['email'];
                    $user_pic = $facebook->api('/me/picture', 'GET', array('redirect' => false, 'width' => '200', 'height' => '200'));
                    $url = $user_pic['data']['url'];
                    $time = time();
                    mysql_query("INSERT INTO registrationDetails (userID,firstName,lastName,email,initialTimestamp,linkToDisplayPic) VALUES ('$user_id','$firstName','$lastName','$email','$time','$url')");
                    mysql_query("INSERT INTO userupdate (userID,level,score,lastTimestamp) VALUES ('$user_id','0','0','$time')");
                }
                echo('<META HTTP-EQUIV="Refresh" Content="0; URL=dashboard.php">');
            } catch (FacebookApiException $e) {
                echo('<META HTTP-EQUIV="Refresh" Content="0; URL=login.html">');
            }
        } else {
            echo('<META HTTP-EQUIV="Refresh" Content="0; URL=login.html">');
        }
        ?>

    </body>
</html>

