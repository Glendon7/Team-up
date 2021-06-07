<?php
    require "main_header.php";
    require_once __DIR__."/../core/init.php";
    ?>

<head>
   
 
    <title>Teamup</title>
</head>
<style>
    
    body {
    background: #30281e;
}
.container{
   
    width: 440px;
    height: 360px;
    padding: 25px 25px;
    top: 50%;
    left: 50%;
    position: absolute;
    background: #ffeaa7;
    transform: translate(-50%, -50%);
    box-sizing: border-box;
    box-shadow: 1px 1px 15px 2px;
    overflow: scroll;
    
    
}

::-webkit-scrollbar{
    width: 4px;
    
}


::-webkit-scrollbar-thumb{
    border-radius: 12px;
    background: #f39c12;
    max-height: 10px;
    margin-bottom: 50px;
}

h2{
  margin:5px 0;
  
  font-size:20px ;
}

.container .design [type=text], select {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: block;
  border: 1px solid #ccc;
  border-radius: 8px;
  box-sizing: border-box;
  font-size: 15px;
}
.container .design input[type=submit] {
  width: 20%;
  background-color: #feca57;
  color: black;
  padding: 10px 10px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 15px;
  font-weight: 500;
}

.container .design input[type=submit]:hover {
  background-color: #f39c12;
}
label{
    font-size: 16px;
}

.container .design button{
    width: 20%;
  padding: 10px 16px;
  margin: 8px 0;
  background: transparent;
  border:none;
  cursor: pointer;
  font-size: 15px;
  font-weight: 500;
  border-radius: 4px;
}
.container .design 
button:hover{
background:#f6e58d ;
cursor: pointer;
}

button:hover{
background:#f6e58d ;
cursor: pointer;
}
.errors{
  margin-top: -30px;
  color:red;
}
.design{
  margin-bottom:15px ;
}
</style>
<body>
  <?php
    $user=new User();
if(!$user->isLoggedIn()){
  Redirect::to('index.php');
}

if(Input::exists()){
  if(Token::check(Input::get('token'))){
    $validate=new Validate();
    $validation=$validate->check($_POST,array(
      'name'=>array(
        'required'=>true,
        'min'=>3,
        'max'=>100,
        
      ),
      'project_key'=>array(
        'required'=>true,
        'min'=>1,
        'max'=>5,
        'unique'=>'projects'
      )
      ));

      if($validation->passed()){

        try{
          $user->create('projects',array(
            'for_account'=>$user->showid(),
            'name'=>Input::get('name'),
            'project_key'=>Input::get('project_key')
          ));
          $projects=$user->data()->projects;  
          $user->getproject('projects','for_account',$user->showid());
          foreach($user->projectdata() as $data => $project){
            if($project->project_key==Input::get('project_key')&& $project->name==Input::get('name')){
              if( $projects == NULL){
                $projects=$project->id;
              }else{
              $projects.=','.$project->id;
              }
              $user->update('accounts',$user->showid(),array('projects' => $projects));
            }
          }
          
          //echo $projects.=;
          
        echo '<script> alert("Created");</script>';

        }catch(Exception $e){
         die($e->getMessage());

        }
      }
      else{
        foreach($validation->errors() as $error){
          $error_msg[] = $error;
        }
      }
  }
}
  
  
  ?>
    <div class="container">
    <form action="" method="post">
        <h2> Create project</h2><br>
       <div class="design">
       <label for="name"> Name</label>
        <input type="text" id="name" name="name" placeholder="Enter project name" required>
       </div>
        <div class="design">
        <label for="project_key">Key</label>
        <input type="text" id="project_key" name="project_key" size="5" maxlength="5" placeholder="e.g. 'TEST ">
        </div>
        <div class="design">
        <input type="submit" value="Submit">
        <a href="home.php"><button type="button">Cancel</button></a>
        </div>
        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>"><br>
        
        <div class="errors">
        <?php
          if(isset($error_msg)){
            foreach($error_msg as $nerror){
                echo $nerror, "<br>";
            }}
        ?>
        </div>
    </form>
    </div>
</body>