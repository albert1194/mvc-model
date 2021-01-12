<?php 
//core app class
class Core {
  protected $currentController = 'Pages';//if there are no other controllers in our controller file this page will be loaded automatically
  protected $currentMethod = 'index';
  protected $params = [];

  public function __construct()
  {
  $url = $this->getUrl();
   //look in controllers for first value and ucwords will capitalize the first letters 
   if (file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
       //will set new controller
       $this->currentController = ucwords($url[0]);
       unset($url[0]);

       //require the controller
       require_once '../app/controllers/' . $this->currentController . '.php';
       $this->currentController = new $this->currentController;

       //check for the second part of the url
       if (isset($url[1])) {
           if (method_exists($this->currentController, $url[1])) {
             $this->currentMethod = $url[1];
             unset($url[1]);
           }
       }
       //get parameters
       $this->params = $url ? array_values($url) : [];//check if there is any params and if its not keep it empty 

       //call a callback with array of params
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
   }
  }
  public function getUrl () {
    if (isset($_GET['url'])) {
        $url = rtrim($_GET['url'], '/'); //this will strip '/' from the url
        // allows you to filter variables as string/number
        $url = filter_var($url, FILTER_SANITIZE_URL);//this remove certain characters from the url
        //breaking it into an array
        $url = explode('/', $url);
        return $url;
    }
  }

}