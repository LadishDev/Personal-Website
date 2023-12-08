<?php 
$status = file_get_contents("http://localhost/server-status?auto");
$uptime = preg_match('/Uptime: (.+)/', $status, $matches) ? $matches[1] : "N/A";
?>


<!DOCTYPE html>
<html>
    <head> <!-- This is the title of the webpage and also links to the css file for the styling of the site -->
      <!-- <link rel="icon" href="/images/site-favicon.jpg" type="image/x-icon"> -->
      <title>Ladish</title>
      <link rel="stylesheet" type="text/css" href="css/global.css"/>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <script src="js/typewriter.js"></script>
    </head>
    <body>

      <div class="navbar">
        <div class="nav-logo">
          <img src="images/logo.svg" alt="Ladish Logo">
        </div>
        <div class="nav-links">
          <a href="index.php" <?php if ($_SERVER['REQUEST_URI'] === '/index.php') echo 'class="active-page"'; ?>>Home</a>
          <a href="socials.php" <?php if ($_SERVER['REQUEST_URI'] === '/socials.php') echo 'class="active-page"'; ?>>Socials</a>
        </div>
      </div>
    
      <div class="container">
        <!-- This is the header of the webpage for the information above the navbar to show u where u are -->
        <div class="first-container-element">
          <div class="p-picture"> <!-- Adds my pfp into a circle and puts my name under at top of page -->
            <img src="images/index-page/ladish.webp" alt="Picture of Ladish pfp"></a>
          </div>
          <div class="text-information">
            <h2 id="typewriter">
              <a href="" class="typewrite" data-period="2000" data-type='["I am a developer", "A tech enthusiast", "A photographer" ]'>
                <span class="wrap"></span>
              </a>
            </h2>
          </div>
        </div>
      </div>
	  
      <footer>
        <p>Author: Callum Baldwin</p>
        <p> | </p>
	      <p>Server Uptime: <?php echo $uptime; ?></p>
      </footer>

    </body>
</html>
