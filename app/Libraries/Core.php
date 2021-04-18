<?php
    // Core App Class
    class Core {
        protected $currentController = 'Pages';
        protected $currentMethod = 'index';
        protected $params = [];

        public function __construct()
        {
            $url = $this->getUrl();

            // Looks for controller in Controllers Folder using the first value from the url. 
            // ucwords will capitalize every word
            if(@file_exists('../app/Controllers/'. ucwords($url[0]) .'.php'))
            {
                // We set the new to be the first value from the url.
                $this->currentController = ucwords($url[0]);
                unset($url[0]);
            }

            // Require the controller
            require_once '../app/Controllers/'. $this->currentController .'.php';
            $this->currentController = new $this->currentController;
            // check for the second value of the url array
            if(isset($url[1]))
            {
                // check if method exists
               if(method_exists($this->currentController, $url[1]))
               {
                   // Set new method to be the currentMethod
                   $this->currentMethod = $url[1];
                   unset($url[1]);
               }
            }

            // Get Parameters
            $this->params = $url ? array_values($url) : [];
            // Call a callback with array of  params

            call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
        }


        
        public function getUrl()
        {
            if(isset($_GET['url'])){
                // Removes the / on the url
                $url = rtrim($_GET['url'], '/');
                // Filter url as string/number
                $url = filter_var($url, FILTER_SANITIZE_URL);
                // Brearking url into an array
                $url = explode('/', $url);

                return $url;
            }
        }
    }