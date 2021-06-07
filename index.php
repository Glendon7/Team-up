 <?php
    
    require "header.php";
    require_once 'core/init.php';

?>
<link rel="stylesheet" type="text/css" href="css/indexstyle.css?<?php echo time(); ?>" />
    
<main class="mainpg"> 
<div class="up">
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 319"><path fill="#fff" fill-opacity="1" d="M0,224L60,234.7C120,245,240,267,360,240C480,213,600,139,720,133.3C840,128,960,192,1080,192C1200,192,1320,128,1380,96L1440,64L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z"></path></svg>
</div>

 <div class="intro">
 <h1>Welcome to Teamup!</h1><br>
 <h3><a href="login.php">Login</a> or <a href="signup.php">Signup</a> to continue</h3>

<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 319"><path fill="#ffd280" fill-opacity="1" d="M0,224L60,234.7C120,245,240,267,360,240C480,213,600,139,720,133.3C840,128,960,192,1080,192C1200,192,1320,128,1380,96L1440,64L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z"></path></svg>

 </div>
    
    
</main>

<?php
#    require "footer.php";
?> 
<?php


$user=new User();
if($user->isLoggedIn()){
   Redirect::to('main/home.php');
   ?>
   
   <?php
}
