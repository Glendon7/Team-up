<?php
    
    require "header.php";
    require_once 'core/init.php';
    $user=new User();
    if($user->isLoggedIn()){
        Redirect::to('main/home.php');
    }
    $errors= array();
    if(Input::exists()){
        if(Token::check(Input::get('token'))){
            
  $validate= new Validate();
  $validation=$validate->check($_POST,array(
      'username'=>array(
          'required'=>true,
          'min'=>3,
          'max'=>20,
          'unique'=>'accounts'
      ),
      'password'=>array(
          'required'=>true,
          'min'=>7
          
      ),
      'confirm_password'=>array(
        'required'=>true,
        'matches'=>'password',
        'contains'=>'#@'
        
      ),
      'full_name'=>array(
        'required'=>true,
        'min'=>3,
        'max'=>40
        
      ),
      'email'=>array(
          'required'=>true,
          'unique'=>'accounts'
      )

  ));
  
}
}
?>
<link rel="stylesheet" type="text/css" href="css/signupsty.css?<?php echo time(); ?>" />

<main class="login">  
<h1 class="Htext">Signup</h1>
    <form action="" method="post" >
        <input type="text" name="full_name" id="full_name" value="<?php echo escape(Input::get('full_name'));?>"  placeholder="First name"><br>

        <input type="email" name="email" id="email" value="<?php echo escape(Input::get('email'));?>"placeholder="Email id">

        <input type="text" name="username" id="username" value="<?php echo escape(Input::get('username'));?>" placeholder="Username">

        <input type="password" name="password" id="password"  placeholder="Password">

        <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password">
        <label class="project_manager" for="is_project_manager">Project Manager
        <input type="checkbox" name="is_project_manager" id="is_project_manager"> 
        </label>


        <input type="hidden" name="token" value="<?php echo Token::generate();?>">

        <input type="submit" name="signup-submit" value="Signup">

        <div class=errors>
        <?php  
        // if($errors){
        // echo "<h4>Error</h4> ";
        // foreach($errors as $show){
        //     echo $show,"<br>";
        // }}
        if(isset($validation)){
            if ($validation->passed()){
                // then register the user
               $user=new User();
               $projectmanager=(Input::get('is_project_manager')==='on')?1:0;

              $salt= Hash::salt(18);
                
              
               try{
                   
                   $user->create('accounts',array(
                       'fullname'=>Input::get('full_name'),
                       'username'=>Input::get('username'),
                       'password'=>Hash::make(Input::get('password'),$salt),
                       'salt'=>$salt,
                       'email'=>Input::get('email'),
                       'is_project_manager'=>$projectmanager,
                       'projects'=>'none'
                        
                   ));

                   Session::flash('registered','Registered successfully! Login to continue.');
                   echo Redirect::to('login.php');

               }catch(Exception $e){
                   die($e->getMessage());

               }
              
          
            }
            else{
                echo "<h4>Error</h4> ";
                foreach($validation->errors() as $error){
                    echo $error, "<br>";
                }
            }
        }
        ?>
        </div>
    </form>
    
</main>

<?php
    require "footer.php";
?>