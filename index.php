<?php 
$status = file_get_contents("http://localhost/server-status?auto");
$uptime = preg_match('/Uptime: (.+)/', $status, $matches) ? $matches[1] : "N/A";
?>


<!DOCTYPE html>
<html>
    <head> <!-- This is the title of the webpage and also links to the css file for the styling of the site -->
      <!-- <link rel="icon" href="/images/site-favicon.jpg" type="image/x-icon"> -->
      <title>Ladish</title>
      
      
      <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- This is to make the site responsive -->
      <meta content="Callums Site" property="og:title" />
      <meta content="My portfolio containing everything about me there is to know. What am I up to? What have I already been doing?" property="og:description" />
      <meta content="https://ladish.dev" property="og:url" />
      <meta content="#8a46b5" data-react-helmet="true" name="theme-color" />


      <link rel="stylesheet" type="text/css" href="css/global.css"/> <!-- This is the link to the css file -->
      <script src="js/typewriter.js"></script> <!-- This is the link to the typewriter script -->
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
        <!-- This is the header of the webpage for the information above the navbar to show u where u are -->
        <section class="first-container-element">
          <div class="p-picture"> <!-- Adds my pfp into a circle and puts my name under at top of page -->
            <img src="images/index-page/ladish.webp" alt="Profile picture of Ladish">
          </div>
          <div class="text-information">
            <h2 id="typewriter">
              <a href="" class="typewrite" data-period="2000" data-type='["I am a developer", "A tech enthusiast", "A photographer" ]'>
                <span class="wrap"></span>
              </a>
            </h2>
          </div>
        </section>
      </div>

        <section class="second-container-element">
          <section class="projects">
            <h1>Projects</h1>
            <div class="projects-container">
              <article class="project">
                <figure class="project-image">
                  <img src="images/index-page/website-image.webp" alt="Screenshot of my web portfolio">
                </figure>
                <div class="project-text">
                  <h2>Web portfolio</h2>
                  <p>My portfolio website that you are currently on.</p>
                </div>
              </article>
              <article class="project">
                <figure class="project-image">
                  <img src="images/index-page/database-project.webp" alt="Screenshot of Interactive Database System">
                </figure>
                <div class="project-text">
                  <h2>Interactive Database System</h2>
                  <p>A dnd game database system that allows you to store all your characters and their info.</p>
                </div>
              </article>
              <article class="project">
                <figure class="project-image">
                  <img src="images/index-page/discord-bot.webp" alt="Screenshot of Discord Bot project">
                </figure>
                <div class="project-text">
                  <h2>Discord Bot</h2>
                  <p>Currently in proccess of development.</p>
                </div>
              </article>
            </div>
          </section>
        </section>
      </div>
	  
      <footer>
        <p>Author: Callum Baldwin</p>
        <p> | </p>
	      <p>Server Uptime: <?php echo $uptime; ?></p>
      </footer>

    </body>
</html>
