<?php
$status = file_get_contents("http://localhost/server-status?auto");
$uptime = preg_match('/Uptime: (.+)/', $status, $matches) ? $matches[1] : "N/A";

if ($uptime != "N/A") {
  // Check if the uptime contains "day" or "days"
  if (strpos($uptime, 'day') !== false) {
    // Extract only the days from the uptime string
    preg_match('/(\d+)\s+day/', $uptime, $dayMatches);
    $uptime = $dayMatches[1] . ' days';
  } else {
    // Extract only the hours from the uptime string
    preg_match('/(\d+)\s+hours/', $uptime, $hourMatches);
    $uptime = $hourMatches[1] . ' hour(s)';
  }
}
?>


<!DOCTYPE html>
<html lang="en">
    <head> <!-- This is the title of the webpage and also links to the css file for the styling of the site -->
      <link rel="icon" href="/images/site-favicon.png" type="image/x-icon">
      <title>Ladish</title>
      
      
      <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- This is to make the site responsive -->
      <meta content="My Portfolio" property="og:title" />
      <meta content="My portfolio containing everything about me there is to know. What am I up to? What have I already been doing?" property="og:description" />
      <meta content="https://ladish.dev" property="og:url" />
      <meta content="#8a46b5" data-react-helmet="true" name="theme-color" />


      <link rel="stylesheet" type="text/css" href="css/global.css"/> <!-- This is the link to the css file -->
      <script src="js/age-caculate.js"></script> <!-- This is the link to the age script -->
      <script src="js/typewriter.js"></script> <!-- This is the link to the typewriter script -->
    </head>
    <body>
      <div class="navbar">
        <div class="nav-logo">
          <img src="images/logo.svg" alt="Callum.B Logo">
        </div>
        <div class="nav-links">
          <a href="index.php">Home</a>
        </div>
      </div>
    
      <div class="container">
        <!-- This is the header of the webpage for the information above the navbar to show u where u are -->
        <section class="section-containers">
          <section class="aboutme-container">
            <div class="p-picture">
              <img src="images/index-page/ladish.webp" alt="Profile picture of Ladish">
            </div>
            <div class="text-information">
              <h2 id="typewriter">
                <a href="" class="typewrite" data-period="2000" data-type='["I am a developer", "A tech enthusiast", "A photographer" ]'>
                <span class="wrap"></span></a>
              </h2>
              <p>
                My name is Callum, I am <span id="myAgeResult"></span> years old and I am from the UK.
                I am currently studying Cyber Security at University and I am looking to go into the Cyber Security industry.
                I also have a passion for developing things and am currently working on a few projects.
                Also, on the side I am a photographer and I love to take photos of nature and landscapes.
              </p>
            </div>
          </section>
        </section>

<!-- Commented out as I currently dont have any experience to put in here but will be adding it in the future
        <section class="section-containers">
          <section class="experiences">
            <h1>Experience</h1>
            <div class="experience-container">
              <article class="experience">
                <h2>Company Name<h2>
                <h3>Job Title</h3>
                <div class="experience-text">
                  <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla euismod, nisl eget ultricies ultrices, nunc nisl ultricies nunc, 
                    quis ultricies nisl nisl eget nunc. Donec euismod, nisl eget ultricies ultrices, nunc nisl ultricies nunc, quis ultricies nisl nisl eget nunc. 
                    Donec euismod, nisl eget ultricies ultrices, nunc nisl ultricies nunc, quis ultricies nisl nisl eget nunc.
                  </p>
                </div>
              </article>
              <article class="experience">
                <h2>Company Name<h2>
                <h3>Job Title</h3>
                <div class="experience-text">
                  <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla euismod, nisl eget ultricies ultrices, nunc nisl ultricies nunc, 
                    quis ultricies nisl nisl eget nunc. Donec euismod, nisl eget ultricies ultrices, nunc nisl ultricies nunc, quis ultricies nisl nisl eget nunc. 
                    Donec euismod, nisl eget ultricies ultrices, nunc nisl ultricies nunc, quis ultricies nisl nisl eget nunc.
                  </p>
                </div>
              </article>
              <article class="experience">
                <h2>Company Name<h2>
                <h3>Job Title</h3>
                <div class="exerience-text">
                  <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla euismod, nisl eget ultricies ultrices, nunc nisl ultricies nunc, 
                    quis ultricies nisl nisl eget nunc. Donec euismod, nisl eget ultricies ultrices, nunc nisl ultricies nunc, quis ultricies nisl nisl eget nunc. 
                    Donec euismod, nisl eget ultricies ultrices, nunc nisl ultricies nunc, quis ultricies nisl nisl eget nunc.
                  </p>
                </div>
              </article>
            </div>
          </section>
        </section>
-->

        <section class="section-containers">
          <section class="projects">
            <h1>Projects</h1>
            <div class="projects-container">
              <article class="project">
                <img src="images/index-page/website-image.webp" alt="Screenshot of my web portfolio">
                <div class="project-text">
                  <h2>Web portfolio</h2>
                  <p>
                    I've created this web portfolio page to showcase my various projects and involvements. Being here enables me to consolidate all my work in one central location, 
                    providing a comprehensive overview of my professional journey.
                  </p>
                  <button class="button" data-url="https://gitlab.com/LadishDev/personal-website">View Project</button>
                </div>
              </article>
              <article class="project">
                <img src="images/index-page/database-project.webp" alt="Screenshot of Interactive Database System">
                <div class="project-text">
                  <h2>Interactive Database System</h2>
                  <p>
                    This project was created for my A-Level Computer Science coursework. It is a database system that allows the user to add, edit and delete records from the database 
                    and was built for a game like dnd. Futhermore, I have also created another database system recently for my university coursework. This database system is for calculating
                    the 2019 General Election results and storing them in a database. Then pulling them again to display them on a website.
                  </p>
                  <button class="button" data-url="https://github.com/LadishDev/Assessment-Cariryn-Enterprise">View Game Database</button>
                  <button class="button" data-url="https://github.com/LadishDev/Electoral-System">View Election Database</button>
                </div>
              </article>
              <article class="project">
                <img src="images/index-page/discord-bot.webp" alt="Screenshot of Discord Bot project">
                <div class="project-text">
                  <h2>Discord Bot</h2>
                  <p>
                    This project is currently in development as since my previous bot was no longer working due to the API being updated. I am currently working on a new bot in my free time to replace the old one.
                    This bot will be able to do moderation things such as kick, ban, mute, etc. It also will have a few fun commands that I will be adding to in the future after the main functionality is complete.
                  </p>
                  <button class="button" data-url="https://gitlab.com/LadishDev/discord-bot">Currently In Progress</button>
                </div>
              </article>
            </div>
          </section>
        </section>

        <section class="section-containers">
          <h1>Repository's</h1>
          <section class="repositorys">
            <article class="repo-text">
              <p>
                I currently maintain accounts on both GitHub and GitLab to host my repositories. While I initially began my coding journey on GitHub and still rely on it for some University projects, 
                I find myself increasingly drawn to GitLab. The user interface and feature set of GitLab appeal to me, prompting me to migrate my projects from GitHub to GitLab. Additionally, the fact 
                that GitLab is open source aligns with my preferences, further solidifying my preference for it over GitHub.
              </p>
            </article>
            <article class="repo-container">
              <article class="social">
                <img src="images/socials/github.svg" alt="GitHub Logo">
                <h2>GitHub</h2>
                <div class="social-text">
                  <button class="button" data-url="https://github.com/LadishDev">View GitHub</button>
                </div>
              </article>
              <article class="social">
                <img src="images/socials/gitlab.svg" alt="GitLab Logo">
                <h2>GitLab</h2>
                <div class="social-text">
                  <button class="button" data-url="https://gitlab.com/LadishDev">View GitLab</button>
                </div>
              </article>
            </article>
          </section>


        <section class="section-containers">
          <h1>Contact Me</h1>
          <div class="social-container">
            <article class="social">
              <img src="images/socials/instagram.svg" alt="Instagram Logo">
              <h2>Instagram</h2>
              <div class="social-text">
                <p>
                  As I mentioned above in my free time I love to take photos of nature and landscapes. Here you can find my photography Instagram page where I post my photos.
                  I dont post as often as I would like to but when I do get some time and take some photos I will post them here.
                </p>
                <button class="button" data-url="https://www.instagram.com/callumb.photography">View Instagram</button>
              </div>
            </article>
            <article class="social">
              <img src="images/socials/linkedin.svg" alt="Linkedin Logo">
              <h2>Linkedin</h2>
              <div class="social-text">
                <p>
                  I also have a Linkedin page where I have a few Certificates on that I have completed. You can also find my work experience on there as well as my education. If you would like to connect with me on Linkedin
                  then feel free to do so.
                </p>
                <button class="button" data-url="https://www.linkedin.com/in/callumbdev">View Linkedin</button>
              </div>
            </article>
            <article class="social">
              <img src="images/socials/email.svg" alt="Email Logo">
              <h2>Email</h2>
              <div class="social-text">
                <p>
                  If you would like to get in contact with me for any reason then feel free to send me an email. I will try to get back to you as soon as possible but please be aware that I may not be able to reply straight away.
                  My email is <a href="mailto:developer@ladish.dev" target="_blank">developer@ladish.dev</a>
                </p>
                <button class="button" data-url="mailto:developer@ladish.dev">Send Email</button>
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
      <script>
        document.querySelectorAll('.button').forEach(function(button) {
          button.addEventListener('click', function() {
            window.open(this.getAttribute('data-url'), '_blank');
          });
        });
      </script>
    </body>
</html>