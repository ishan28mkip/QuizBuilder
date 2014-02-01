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

if ($user_id) {
    try {
        $link = mysql_connect('localhost', 'root', '') or die(mysql_error());
        $db_selected = mysql_select_db('quizApp', $link) or die(mysql_error());

        $query = mysql_query("SELECT * FROM registrationDetails WHERE userID='" . $user_id . "'");
        $row = mysql_fetch_array($query);
        if ($row)
            ;
        else {
            header('Location: ./checkpoint.php');
            exit;
        }
    } catch (FacebookApiException $e) {
        echo('<META HTTP-EQUIV="Refresh" Content="0; URL=login.html">');
    }
} else {
    echo('<META HTTP-EQUIV="Refresh" Content="0; URL=login.html">');
}
?>
<html>
    <head>
        <title></title>
        <meta charset="windows-1252">
        <meta name="viewport" content="width=device-width">
        <link href="./css/coreStyling.css" rel="stylesheet" type="text/css" media="screen" />
        <link href="./css/hitsStyling.css" rel="stylesheet" type="text/css" media="screen" />
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,600,300,700,800|Raleway:200extrlight' rel='stylesheet' type='text/css'>
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    </head>
    <body>
        <div id="topBar" class="topBar">
            <div id="head" class="head">RoboQZ</div>
            <div id="topContainer1" class="topContainer1">
                <a onclick="facebookLogout();
                        return false"><img id="powerButton" class="powerButton" src="./image/pw.png" /></a>
            </div>
            <div id="topContainer2" class="topContainer2">
                <img id="userPic" class="userPic" src="<?php echo $row['linkToDisplayPic']; ?>">
                <div id="userName" class="userName" ><span class="fn"><?php echo $row['firstName'] . ' ' . $row['lastName']; ?></span><br><span class="ln"><?php echo $row['email']; ?></span></div>
            </div>
        </div>
        <div id="workspace" class="workspace">
            <div id="progress" class="progress docks ">Question for LEVEL 17</div>
            <div id="current" class="current docks">the current status
                <div id="currentLevel" class="currentNode currentLevel" >Level</div>
                <div id="currentScore" class="currentNode currentScore" >The Score</div>
            </div>
            <div id="answerWrapper" class="docks answerWrapper">
                Submit an Answer
                <div id="answerCover" class="answerCover">
                    <input type="text" class="answerBox" id="answerBox">
                </div>
                <input type="submit" class="answerSubmit" id="answerSubmit">
            </div>
        </div>
        <div id="botBar" class="botBar">
            <div id="fb-likeWrapper" class="fb-likeWrapper">
                <div class="fb-like" data-href="https://www.facebook.com/bitsapogee" data-layout="standard" data-width="600" data-action="like" data-show-faces="false" data-share="true"></div>
            </div>
            <div id="linkWrapper" class="linkWrapper">
                <a style="text-decoration: none;color:black;" href="http://www.bits-apogee.org">APOGEE 2014</a> | <a style="color:black;text-decoration: none;" href="http://www.bits-pilani.ac.in/Pilani/index.aspx">BITS Pilani<a/>
            </div>
        </div>
        <div id="fb-root"></div>


        <script>(function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id))
                    return;
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=570243296401349";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>
        <script>
            window.fbAsyncInit = function() {
                FB.init({
                    appId: '570243296401349',
                    status: true,
                    cookie: true,
                    xfbml: true
                });
            };

            (function(d) {
                var js;
                var id = 'facebook-jssdk';
                var ref = d.getElementsByTagName('script')[0];
                if (d.getElementById(id)) {
                    return;
                }
                js = d.createElement('script');
                js.id = id;
                js.async = true;
                js.src = "//connect.facebook.net/en_US/all.js";
                ref.parentNode.insertBefore(js, ref);
            }(document));

            function facebookLogout() {
                FB.logout(function(response) {
                    window.location.href = "./login.html";
                });
            }


        </script>

    </body>
</html>

