<?php
/**
 * Base Controller
 * Loads the models and views
 */

class Controller{
    // Load model
    public function model($model)
    {
        // Require model file
        require_once '../app/models/' . $model . '.php';

        // Instatiate model
        return new $model(); // new Post
    }

    //Load view
    public function view($view, $data = [])
    {
        $fileView = '../app/views/' . $view . '.php';
        //Check for view file
        if(file_exists($fileView)){
            require_once $fileView;
        } else {
            // View does not exist
            die('View does not exist');
        }
    }
}