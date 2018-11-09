<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class MY_Loader extends CI_Loader {
    public function __construct(){
        parent::__construct();
    }
    public function controller($file_name,$data='',$method='index'){
        $CI = & get_instance();
     
        $file_path = APPPATH.'controllers/'.$file_name.'.php';
        $object_name = $file_name;
        $class_name = ucfirst($file_name);
     
	
        if(file_exists($file_path)){
            require $file_path;
			
            $CI->$object_name = new $class_name(true);
			
			if(is_array($data)){ 
				foreach($data as $name => $value){ 
					$CI->$object_name->$name = $value;
				}
			}
			
			$CI->$object_name->$method();
        }
        else{
            show_error("Unable to load the requested controller class: ".$class_name);
        }
    }
}
?>