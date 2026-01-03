<?php
  /*
  App Core Class:
  Creates URL & loads core controller
  (URL format - /controller/method/params)
  */
  class Core {
    // defaults
    protected $currentController = 'Users';
    protected $currentMethod = 'login';
    protected $params = [];

    public function __construct(){
      $url = $this->getUrl();

      // look in controllers for first value of url array
      if($url == ''){
        // error handling as the url var is being treated as an empty string initially, causing an error to be thrown. Potentially something to do with the most recent update to PHP and prior versions are unaffected. Will leave as is until I find a better solution
      } elseif(file_exists('../app/controllers/' . ucwords($url[0]). '.php')){
        // set the current page to be of the first value in the url array since the page exists
        $this->currentController = ucwords($url[0]);
        // unset 0 index
        unset($url[0]);
      }

      // require the controller
      require_once '../app/controllers/' . $this->currentController . '.php';

      //instantiate controller class i.e. Pages = new Pages
      $this->currentController = new $this->currentController;

      // check for second part of url
      if(isset($url[1])){
        // check to see if method exists in controller
        if(method_exists($this->currentController, $url[1])){
          $this->currentMethod = $url[1];
          // unset 1 index
          unset($url[1]);
        }
      }

      // get params
      $this->params = $url ? array_values($url) : [];

      // call a callback with array of params
      call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    public function getUrl(){
      if(isset($_GET['url'])){
        // convert to array using '/' as the delimeter between values i.e. /posts/edit/1 = ['posts', 'edit', '1']
        $url = rtrim($_GET['url'], '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = explode('/', $url);
        return $url;
      }
    }
  }
?>
