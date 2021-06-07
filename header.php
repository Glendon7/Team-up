<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/hstyle.css?<?php echo time(); ?>" />
    
    <title></title>
</head>
<body>
    <header>
        <nav class="nav" >
            <a class="logo" href="index.php">
                <img src="Img/l.png" class="logo" alt="Teamup Logo">
            </a>
            <ul class="nav-links">
                <li><a href="main/home.php">Home</a></li>
                <li><a href="#">Inbox</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact us</a></li>
            </ul>
        
            <div class="regis">
                <a href="login.php"><button type="button" class="btn">  Login</button> </a>
                
                <a href="signup.php"><button type="button"  class="btn">Signup </button> </a>
                <form action="includes/logout.inc.php" method="post" class="nav-links">
                   
                   
                    
                </form>
            </div>
        </nav>
    </header>
    
</body>
</html>