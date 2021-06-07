<?php
require "main_header.php";
require_once __DIR__ . "/../core/init.php";
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title></title>
</head>
<style>
    
    body {
    background: #30281e;
}

    .container {

        width: 37vw;
        height: 84vh;
        padding: 25px 25px;
        top: 52%;
        left: 50%;
        position: absolute;
        background: #ffeaa7;
        transform: translate(-50%, -50%);
        box-sizing: border-box;
        box-shadow: 1px 1px 10px 1px;
        overflow: scroll;
        border: 1px solid black;
    }

    .newIssueHeader {
        text-align: center;
        padding-bottom: 10px;
        margin-bottom: 10px
    }

    h2 {
        font-size: 24px;
        font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;

    }


    .container input[type=text],
    select {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: block;
        border: 1px solid #ccc;
        border-radius: 8px;
        box-sizing: border-box;
        font-size: 15px;
    }

    .container input[type=submit] {
        width: 20%;
        background-color: #feca57;
        color: black;
        padding: 10px 16px;
        margin: 8px 0;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 15px;
        font-weight: 500;
    }

    .container input[type=submit]:hover {
        background-color: #f39c12;
    }

    label {
        font-size: 16px;
    }

    .describe {
        width: 100%;
        max-width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: block;
        border: 1px solid #ccc;
        border-radius: 8px;
        box-sizing: border-box;
        font-size: 15px;
        resize: none;

    }

    .container button {
        width: 20%;
        padding: 10px 16px;
        margin: 8px 0;
        background: transparent;
        border: none;
        cursor: pointer;
        font-size: 15px;
        font-weight: 500;
        border-radius: 4px;
    }

    button:hover {
        background: #f6e58d;
    }

    ::-webkit-scrollbar {
        width: 4px;

    }


    ::-webkit-scrollbar-thumb {
        border-radius: 12px;
        background: #f39c12;
        max-height: 10px;
        margin-bottom: 50px;
    }

    .date {
        margin: 25px 0;

    }
    .design{
  margin-bottom:15px ;
}

    .errors {
        
        margin-top: -22px;
        color: red;
    }
</style>

<body>

    <?php
    $user = new User();
    $user->projectid(Session::get('project_key'));

    $status = $user->getall('status');
    $priority = $user->getall('priority');
    if (!$user->isLoggedIn()) {
        Redirect::to('index.php');
    }

    if (Input::exists()) {
        if (Token::check(Input::get('token'))) {

            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'subject' => array(
                    'required' => true,
                    'max' => 200
                ),
                'status' => array(
                    'required' => true
                ),
                'priority' => array(
                    'required' => true
                ),
                'startdate'=>array(
                    'incorrect_date'=>'2019-01-01'
                ),
                'duedate' => array(
                    'before' => 'startdate'

                )
                
            ));
            echo Input::get('startdate');

           
            if ($validation->passed()) {
                try {
                    $user->create('task', array(
                        'for_account' => $user->showid(),
                        'for_project' => $user->showprojectid(),
                        'name' => Input::get('subject'),
                        'description' => Input::get('description'),
                        'status' => Input::get('status'),
                        'priority' => Input::get('priority'),
                        'duedate' => Input::get('duedate')? Input::get('duedate'):null,
                        'created_by' => $user->showid(),
                        'start_date'=>Input::get('startdate')?Input::get('startdate'):null

                    ));
                    echo '<script> alert("Created");</script>';
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                foreach ($validation->errors() as $error) {
                    $error_msg[] = $error;
                }
            }
        }
    }
    ?>
    <div class="container">
        <div class="newIssueHeader">
            <h2> New Issue</h2>
        </div>
        <form action="" method="POST">


            <label for="subject"> Subject</label>
            <input type="text" id="subject" name="subject" placeholder="Enter a subject of issue" required value="<?= escape(Input::get('subject')); ?>">

            <div class="lab_desc"><label for="description">Description</label></div>

            <textarea id="description" name="description" rows="12" class="describe" > <?= escape(Input::get('description')); ?> </textarea>

            <!-- <div class="assign">
            <label for="assign">Assign to </label>
            <select>
                <option></option>
                <option>Account 1</option>
                <option>Account 2</option>
            </select>
        </div> -->
            <div class="priority">
                <label for="priority">Priority </label>
                <select name="priority" required>
                    <option ></option>
                    <?php foreach ($priority as $priorities => $pri) {
                    ?>
                        <option value="<?= $pri->id ?>" style="color:  <?= $pri->color  ?>"> <?= $pri->priority ?></option>
                    <?php }
                    ?>
                </select>
            </div>
            <div class="Status">
                <label for="assign">Status </label>
                <select name="status" required>
                    <option ></option>
                    <?php foreach ($status as $statuses => $sta) {
                    ?>
                        <option value="<?= $sta->id ?>"> <?= $sta->name ?></option>
                    <?php }
                    ?>
                </select>
            </div>

            <div class="date">
                <label for="startdate">Start Date :</label>
                <input type="date" name="startdate">
            </div>

            <div class="date">
                <label for="duedate">Due Date :</label>
                <input type="date" name="duedate">
            </div>

        <div class="design">
            <input type="submit" value="Submit">
            <a href="board.php"><button type="button">Close</button></a>
        </div>


            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>"><br>

            <div class="errors">
                <?php
                if (isset($error_msg)) {
                    foreach ($error_msg as $nerror) {
                        echo $nerror, "<br>";
                    }
                }
                ?>
            </div>
        </form>
    </div>

</body>