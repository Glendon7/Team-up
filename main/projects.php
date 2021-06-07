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


    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>


<body>
    <div id="main" class="mainpg">

        <?php
        $user = new User();
        if (!$user->isLoggedIn()) {
            Redirect::to('../index.php');
        }


        if (!$user->getproject('projects', 'for_account', $user->showid())) { // used to check if the user has created any projects

        ?>
            <div class="container h-100">
                <div class="row align-items-center h-100">
                    <div class="col-6 mx-auto">
                        <div class="jumbotron">
                            <p>Hello <?php echo escape($user->data()->username); ?> </p>
                            <p>You haven't created any projects yet</p>
                            <p><a href="createProject.php">Click Here</a> to create a new project</p>
                        </div>
                    </div>
                </div>
            </div>


        <?php

        } else {

        ?><div class="all_projects">
                <h3> My Projects</h3>
                <hr />
                <form action="" method="post" id="form">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Key</th>
                                <th>Created on</th>
                                <th> Delete</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $x = 0;
                            $proj_id = null;
                            foreach ($user->projectdata() as $data => $project) {

                            ?>
                                <tr>
                                    <td class="redir" data-id="<?= $project->id ?>" id="<?= $project->id ?>"> <a> <?= $project->name ?> </a> </td>
                                    <td><?= $project->project_key ?></td>
                                    <td><?= date("d-m-Y", strtotime($project->time)) ?></td>
                                    <td>
                                        <button type='button' class="delete" id="<?= $project->id ?>" data-id="<?= $project->id ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                            </svg>
                                        </button>

                                    </td>
                                    <td>
                                        <button type="button" class="edit" id="<?=$project->id?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                                        </svg>
                                        </button>
                                    </td>
                                </tr>


                        <?php
                                $x++;
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                    <input type="hidden" id="key" name="key" value="">
                </form>
            </div>
    </div>

    <script>
        $(document).ready(function() {

            $('.redir').click(function() {
                $("#form").attr('action','board.php');
                var id = $(this).attr('id');
                $("input:hidden").val(id);
                $("#form").submit();
                

            });

            $('.edit').click(function() {
                $("#form").attr('action','editProject.php');
                var id = $(this).attr('id');
                $("input:hidden").val(id);

                $("#form").submit();
               

            });

            $('.delete').click(function() {
                var el = this;
                var deleteid = $(this).data('id');

                if (confirm("Are you sure you want to delete this project? \nThe project along with its board and all the task will be deleted.\nThis process cannot be undone ")) {

                    $.ajax({
                        url: 'ajax/delete_project.php',
                        type: 'POST',
                        data: {
                            project_id: deleteid
                        },
                        success: function(response) {


                            if (response == 1) {
                                $(el).closest('tr').css('background', 'tomato');
                                $(el).closest('tr').fadeOut(800, function() {
                                    $(this).remove();

                                });
                            } else {
                                alert('Record not deleted.');
                            }

                        }
                    });


                }

            });
        });
    </script>

</body>