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
        <link href="./css/dashboardStyling.css" rel="stylesheet" type="text/css" media="screen" />
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
            <div id="progress" class="docks progress">
                progress
            </div>
            <div id="current" class="docks current">the current status
                <div id="currentLevel" class="currentNode currentLevel" >Level</div>
                <div id="currentScore" class="currentNode currentScore" >The Score</div>
            </div>
            <div id="leader" class="docks leader">
                Check out the current standings
                <div id="button" class="button btype3">Leaderboard</div>
            </div>
            <div id="rules" class="docks rules">
                Get a hand into the rules 
                <div id="button" class="button btype2">Proceed to Questions</div>
            </div>
            <div id="likeWrapper" class="docks likeWrapper">
                Like us on Facebook !
                <div class="fb-like-box" data-href="https://www.facebook.com/bitsapogee" data-width="260" data-height="280" data-colorscheme="dark" data-show-faces="true" data-header="true" data-stream="false" data-show-border="true"></div>
            </div>
            <div id="proceed" class="proceed"> 
                <div id="button" class="fwd btype1">Proceed To Questions</div>
            </div>
        </div>
        <div id="botBar" class="botBar">
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

