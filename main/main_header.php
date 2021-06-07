<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/m_headersty.css?<?php echo time(); ?>" />
    
    <title></title>
    
</head>
<body>
    <header>
        <nav class="nav" >
            <?php require "menu.php";
            require_once __DIR__."/../core/init.php";
      ?>
            
            <a class="logo" href="../index.php">
                <img src="../Img/l.png" class="logo" alt="Teamup Logo">
            </a>
            <ul class="nav-links">
                <li><a href="home.php">Home</a></li>
                <li><a href="#">Inbox</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact us</a></li>
            </ul>
        
            <div class="regis">
            <a href="../logout.php">
                            <button type="button" >Logout</button></a>
                    
                </form>
            </div>
        </nav>
    </header>
    
</body>
</html>