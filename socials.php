<?php
$status = file_get_contents("http://localhost/server-status?auto");
$uptime = preg_match('/Uptime: (.+)/', $status, $matches) ? $matches[1] : "N/A";
?>

<!DOCTYPE html>
<html>
    <head>
        <!-- <link rel="icon" href="/images/site-favicon.jpg" type="image/x-icon"> -->
        <title>Ladish</title>
        <link rel="stylesheet" type="text/css" href="css/global.css"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- <link rel="stylesheet" type="text/css" href="CSS/global.css" /> -->
    </head>
    <body>
        <div class="navbar">
            <div class="nav-logo">
                <img src="images/logo.svg" alt="Callum.B Logo">
            </div>
            <div class="nav-links">
                <a href="index.php" <?php if ($_SERVER['REQUEST_URI'] === '/index.php') echo 'class="active-page"'; ?>>Home</a>
                <a href="socials.php" <?php if ($_SERVER['REQUEST_URI'] === '/socials.php') echo 'class="active-page"'; ?>>Socials</a>
            </div>
        </div>

        <div class="container">
            <div class="header">
                <h1>Socials</h1>
            </div>
            <div class="social-container">
                <div class="row">
                    <div class="columns-home-main">
                        <a href="https://www.instagram.com/callumb.photography" target="_blank">
                            <h1>Photography</h1>
                            <div class="social">
                                <img src="images/socials-page/instagram.png" alt="Instagram Logo">
                            </div>
                            <h4>@callumb.photography</h4>
                            <p>
                                <br>
                                I have a photography instagram where I post Photos I have taken. <br>
                                Its a side hobby of mine that I enjoy doing. Every now and then I will upload a picture to instagram.
                                <br><br>
                                Click this box to go to my instagram page.
                            </p>
                        </a>
                    </div>
                    <div class="columns-home-main">
                        <a href="https://www.github.com/ladishdev" target="_blank">
                            <h1>Github</h1>
                            <div class="social">
                                <img src="images/socials-page/github.png" alt="Github Logo">
                            </div>
                            <h4>@ladishdev</h4>
                            <p>
                                <br>
                                I have a Github page when I create and upload my code for some projects I do time to time. <br>
                                I really enjoy coding and once I can come up with a project to do I get stuck into it and try to make it the best I can.
                                <br><br>
                                Click this box to go to my Github page.
                            </p>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <footer>
        	<p>Author: Ladish</p>
		    <p>Server Uptime: <?php echo $uptime; ?></p>
        </footer>
    </body>
</html>
