<?php

    // Load the model and view
    class Controller {
        public function model($model)
        {
            // require mode file
            require_once '../app/Models/'. $model .'.php';
            // Instantiate model
            return new $model();
        }

        // Loads the view 
        public function view($view, $data = [])
        {
            if(file_exists('../app/Views/'. $view .'.php'))
            {
                require_once '../app/Views/'. $view .'.php';
            }else
            {
                die('View does not exist.');
            }
        }

    }