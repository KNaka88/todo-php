<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__.'/../src/Task.php';

    session_start();
    if (empty($_SESSION['list_of_tasks'])){
        $_SESSION['list_of_tasks'] = array();
    }

    $app = new Silex\Application();
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
      'twig.path' => __DIR__."/../views"
    ));

    $app->get("/", function() use ($app) {
      // $output = "";
      // $all_tasks = Task::getAll();

      // foreach (Task::getAll() as $task) {
      //   $output .= "<p>" . $task->getDescription() . "</p>";
      // }

        // $output .= "
        //     <form action='/tasks' method='post'>
        //       <label for='description'>Task Description</label>
        //       <input id='description' name='description' type='text'>
        //       <button type='submit'>Add task</button>
        //     </form>
        // ";
        //
        // $output .= "
        //     <form action='/delete_tasks' method= 'post'>
        //       <button type='submit'> Delete </button>
        //     </form>
        // ";
        return $app['twig']->render('tasks.html.twig', array('tasks' => Task::getAll()));
    });

    $app->post('/tasks', function() use ($app){
        $task= new Task($_POST['description']);
        $task->save();
        return $app['twig']->render('create_task.html.twig', array('newtask'=> $task));
          //
          // <h1> You created a task</h1>
          // <p>" . $task->getDescription() . "</p>
          // <p><a href='/'> View your list of things to do. </a></p>
          // ";
    });
    $app->post('/delete_tasks', function() use ($app){

        Task::deleteAll();
        return $app['twig']->render('delete_tasks.html.twig');
        // // return "
        //   <h1>List Cleared</h1>
        //   <p><a href='/'>Home</a></p>
        //   ";
    });


    return $app;
?>
