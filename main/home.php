<?php

require "main_header.php";
require_once __DIR__ . "/../core/init.php";


?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/homeSty.css?<?php echo time(); ?>" />

    <script>
        $(document).ready(function() {


            $('.card').click(function() {
                var id = $(this).attr('id');
                $("input:hidden").val(id);
                $("#form").submit();

            });

        });
    </script>


    <title></title>
</head>

<body>
    <div id="main" class="mainpg">

        <?php
        $user = new User();
        if (!$user->isLoggedIn()) {
            Redirect::to('../index.php');
        }


        if (!$user->getproject('projects','for_account',$user->showid())) { // used to check if the user has created any projects

        ?>
            <div class="container h-100">
                <div class="row align-items-center h-100">
                    <div class="col-6 mx-auto">
                        <div class="jumbotron">
                            <p>Hello <?php echo escape($user->data()->username); ?> </p>
                            <p>Welcome to Teamup</p>
                            <p> Let us begin by creating a new Project</p>
                            <p><a href="createProject.php">Click Here</a> to create a new project</p>
                        </div>
                    </div>
                </div>
            </div>


        <?php

        } else {

        ?><div class="projects">
                <h3> My Projects</h3>
                <hr />
                <form action="board.php" method="post" id="form">
                    <?php
                    $x = 0;
                   
                    foreach ($user->projectdata() as $data) {
                        
                    ?>

                        <div class="card" id=" <?php echo $user->projectdata()[$x]->id; ?>">

                            <div class="card-header">Project name:</div>
                            <div class="card-body">
                                <h4 class="card-title"><?php echo $user->projectdata()[$x]->name; ?></h4>
                                <hr>
                                <p class="card-text">Key: <?php echo $user->projectdata()[$x]->project_key; ?></p>
                                <input type="hidden" id="key" name="key" value="">
                            </div>

                        </div>


                <?php
                        $x++;
                    }
                   
                    
                }
                ?>
                </form>
            </div>
    </div>
</body>