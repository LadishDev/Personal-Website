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
                <a href="index.php" <?php if (basename($_SERVER['REQUEST_URI']) === 'index.php') echo 'class="active-page"'; ?>>Home</a>
                <a href="socials.php" <?php if (basename($_SERVER['REQUEST_URI']) === 'socials.php') echo 'class="active-page"'; ?>>Socials</a>
            </div>
        </div>

        <div class="container">
            <section class="socials">
                <h1>Socials</h1>
                <div class="social-container">
                    <article class="social">
                        <a href=" https://www.instagram.com/callumb.photography" target="_blank">
                            <img src="images/socials-page/instagram.svg" alt="Instagram Logo">
                            <h2>Instagram</h2>
                        </a>
                        <div class="social-text">
                            <p>My Instagram account where I post my photography.</p>
                        </div>
                    </article>
                    <article class="social">
                        <a href="https://www.linkedin.com/in/callumbdev" target="_blank">
                            <img src="images/socials-page/linkedin.svg" alt="Linkedin Logo">
                            <h2>Linkedin</h2>
                        </a>
                        <div class="social-text">
                            <p>TEXT HERE</p>
                        </div>
                    </article>
                    <article class="social">
                        <a href="mailto:developer@ladish.dev" target="_blank">
                            <img src="images/socials-page/email.svg" alt="Email Logo">
                            <h2>Email</h2>
                        </a>
                        <div class="social-text">
                            <p>TEXT HERE</p>
                        </div>
                    </article>
                    <article class="social">
                        <a href="https://github.com/LadishDev" target="_blank">
                            <img src="images/socials-page/github.svg" alt="GitHub Logo">
                            <h2>GitHub</h2>
                        </a>
                        <div class="social-text">
                            <p>TEXT HERE</p>
                        </div>
                    </article>
                    <article class="social">
                        <a href="https://gitlab.com/LadishDev" target="_blank">
                            <img src="images/socials-page/gitlab.svg" alt="GitLab Logo">
                            <h2>GitLab</h2>
                        </a>
                        <div class="social-text">
                            <p>TEXT HERE</p>
                        </div>
                    </article>
                </div>
            </section>
        </div>
        <footer>
            <p>Author: Callum Baldwin</p>
            <p> | </p>
	        <p>Server Uptime: <?php echo $uptime; ?></p>
        </footer>
    </body>
</html>
