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
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">


  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

  <link rel="stylesheet" type="text/css" href="css/BoardSty.css?<?php echo time(); ?>" />


<body>

  <div id="main" class="mainpg">

    <?php
    $user = new User();
    if (!$user->isLoggedIn()) {
      Redirect::to('../index.php');
    }
    if (isset($_POST['key'])) {
      $user->projectid($_POST["key"]);
      Session::put('project_key', $user->showprojectid());
    } else {
      $user->projectid(Session::get('project_key'));
    }
    $user->getproject('task', 'for_project', $user->showprojectid());
    $task = $user->projectdata();
    $priority = $user->getall('priority');

    echo '<div class="title">  <h3>';


    $exists = $user->show('projects', 'id', $user->showprojectid());
    if ($exists) {
      echo $user->data()->name;
      echo '</h3> </div>';
    }
    ?>
    <div class="new-issue">
      <a href="newIssue.php"> + New Task</a>
    </div>
    <hr />

    <div class="board">

      <div class="board-cols">
        <?php

        $x = 0;
        foreach ($user->getall('status') as $data) {

        ?>
          <div class="board-col" id='<?php echo $user->getall('status')[$x]->id ?>' data-status-id='<?php echo $user->getall('status')[$x]->id ?>'>
            <div class="status" id='<?php echo $user->getall('status')[$x]->id ?>' draggable="false">
              <?php echo $user->getall('status')[$x]->name ?>
            </div>

            <?php
            if (isset($task)) {
              foreach ($task as $tasks => $t) {
                if ($t->status == ($x + 1)) { ?>
                  <div class="tasks" data-task-id="<?= $t->id ?>" data-has-status="<?= $t->status ?>" style="border-left:5px solid <?= $priority[$t->priority - 1]->color  ?>">
                    <?= $t->name ?></br>
                    <?php if (isset($t->duedate)) { ?>
                      <span data-toggle="tooltip" title="Due date" data-placement="top" style="color:#c0392b; font-size:14px"><?= escape(date("d-m-Y", strtotime($t->duedate))) ?></span>
                    <?php } else { ?>
                      <span data-toggle="tooltip" title="Due date" data-placement="top" style="color:#c0392b; font-size:14px">None</span>
                    <?php }
                    ?>
                    <div class="project " id="<?= escape($t->id) ?>" data-status="<?= escape($t->status) ?>">

                      <input type="text" class="percent" id="<?= $t->id ?>" value="<?= escape($t->percent_complete) ?>" readonly />

                      <div class="bar" data-id="<?= escape($t->id) ?>"></div>
                    </div>

                  </div>


              <?php
                }
              }
            } else {
              ?>
              <div class="tasks">
                <?= 'Task ' . $x; ?>
              </div>
            <?php
            }
            ?>


          </div>
        <?php $x++;
        } ?>
      </div>
    </div>

    <?php

    if (!$user->getproject('task', 'for_project', $user->showprojectid())) {
      echo '<br> <div class="alert alert-warning" role="alert">
      You haven\'t created any task. Click on + Add new task to create a task.
    </div>';
    }
    ?>


  </div>

  <script>
    function change_status(ticket_id, to_status_id, old_status) {
      $.ajax({
        type: "POST",
        url: "ajax/change_status.php",
        data: {
          ticketid: ticket_id,
          new_status: to_status_id
        }
      });
    }

    $(function() {
      $('.project').each(function() {


        var $projectBar = $(this).find('.bar');
        var $projectPercent = $(this).find('.percent');
        var $projectRange = $(this).find('.ui-slider-range');
        var $ticket_id = $(this).attr('id');
        var $status = $(this).data('status');

        if ($status != 3) {
          $(this).hide();
        }

        $projectBar.slider({
          range: "min",
          animate: true,
          value: 1,
          min: 0,
          max: 100,
          step: 1,
          slide: function(event, ui) {
            $projectPercent.val(ui.value + "%");
          },
          change: function(event, ui) {
            var $projectRange = $(this).find('.ui-slider-range');
            var percent = ui.value;

            if (percent < 30) {
              $projectPercent.css({
                'color': 'red'
              });
              $projectRange.css({
                'background': '#f20000'
              });
            } else if (percent > 31 && percent < 70) {
              $projectPercent.css({
                'color': 'gold'
              });
              $projectRange.css({
                'background': 'gold'
              });
            } else if (percent > 70) {
              $projectPercent.css({
                'color': 'green'
              });
              $projectRange.css({
                'background': 'green'
              });
            }
            $.ajax({
              type: "POST",
              url: "ajax/change_status.php",
              data: {
                ticketid: $ticket_id,
                percentage: percent
              }
            });
          }
        });
      })
    })

    $(document).ready(function() {


      $(".board-col").droppable({
        activeClass: "droppable-active",
        hoverClass: "droppable-hover",
        drop: function(event, ui) {
          to_status_id = $(this).attr('data-status-id');

        }
      }).sortable({
        items: '>div:not(.status)',
        connectWith: '.board-col',
        start: function(event, ui) {
          stat_status = ui.item.attr('data-has-status');
          ticket_id = ui.item.attr("data-task-id");

          $(this).css({
            "background-color": "#rgba(245, 244, 235, 0.541)"
          });
          ui.item.css({
            "transform": "rotate(7deg)",
            "opacity": "0.5"
          });
        },
        stop: function(event, ui) {

          ui.item.css({
            "transform": "none",
            "opacity": "1"
          });
          $(this).css({
            "background-color": ""
          });
          if (to_status_id != stat_status) {
            var old_status = ui.item.attr("data-has-status");
            ui.item.attr("data-has-status", to_status_id);
            change_status(ticket_id, to_status_id, old_status);

            if (to_status_id != 3) {

              
              ui.item.find('.project').hide();
            } else {
          
              ui.item.find('.project').show();
            }




          } else {
            $(this).sortable('cancel');
          }

        },
        cancel: ".disable-sort-item"

      });

      $('.project').each(function() {
        var per = $(this).find('.percent').val();
        var projectBar = $(this).find('.bar');

        projectBar.slider("option", "value", per);

      });

    });
  </script>

</body>