 <?php
 
    require "header.php";
    require_once 'core/init.php';
    $user=new User();
    if($user->isLoggedIn()){
        Redirect::to('main/home.php');
    }
    if(Session::exists('registered')){
       ?> 
       <div class="alert">
       
       <?php
       echo Session::flash('registered');  // Flash message after sign up
       ?> 
       </div>
       <?php
       }
    if(Input::exists()){
        if(Token::check(Input::get('token'))){
            $validate= new Validate();
            $validation=$validate->check($_POST,array(
                'username'=>array(
                    'required'=>true
                ),
                'password'=>array(
                    'required'=>true
                )
                ));

                if($validation->passed()){
                    $user=new User();
                    $remember=(Input::get('remember')==='on')?true:false;
                    $login=$user->login(rtrim(Input::get('username')),Input::get('password'),$remember);

                    if($login==1){
                      
                        Redirect::to('main/home.php');
                    }else if($login==2){
                        $message= '<p> Incorrect username or password </p> ';
                    }
                    else{
                        $message= '<p> Username doesnt exist! <a href="signup.php">Sign-up</a> to create an account</p>';
                    }
                }else{
                    foreach($validation->errors()as $error){
                        $nerrors[]= $error;
                        
                    }
                }
        }
    }
    ?> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/login_Style.css?<?php echo time(); ?>" />
    
    <title></title>
</head>
<main class="login">
    <h2 class="Htext">Login to your account</h2>
    <form action="" method="POST">
    <input type="text" name="username" placeholder="username">
    <input type="password" name="password" placeholder="Password">
    <label for="remember" class="remember">
        <input type="checkbox" name="remember" id="remember">Remember me
    </label>

    <input type="hidden" name="token" value="<?php echo Token::generate();?>">
    <input type="submit" name="login" value="Login"> 
    <a href="#">Forgot Password?</a>

    <div class="errors">
    <?php
    if(isset($message)){
    echo $message;}

    if(isset($nerrors)){
         foreach($nerrors as $neerror){
             echo $neerror, "<br>";
         }}
        ?>
    </div>
    
    
    </form>

</main>