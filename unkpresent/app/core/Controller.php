<?php
	// Create a class
	class Controller{
		// PHP Constructor
		public function __construct(){
			echo "Object is created.";
		}

		// display method and send any data
		public function display($view, $data=[]){

			require_once "../app/view/".$view.".php";
			
		}
	}
?>