<?php
	// Create a class
	class App{
		// Global variables
		public $controller = "";
		public $method = "";
		public $parameter = "";

		// PHP Constructor
		public function __construct(){
			// Assign to default controller
			$this->initDefaultController("Home", "index", "");

			// Display structured information (type and value)
			$url = $this->parseURL();
			//var_dump($url);

			// Handle controller
			if(!empty($url)){
				if(file_exists('../app/controller/'.$url[0].'.php')){
					// Change controller name
					$this->controller = $url[0];
					// Delete element index 0
					unset($url[0]); 
				}
			}
			
			// Require class controller
			require_once '../app/controller/'.$this->controller.'.php';
			$this->controller = new $this->controller; // Instansiasi Object

			// Handle Method
			if(isset($url[1])){
				$name_method = $url[1]; // move method name
				// Check underscore prefix
				if(!$this->starts_with($name_method, "_")){
					// Check if amethod exists
					if(method_exists($this->controller, $name_method)){
						// Change method name
						$this->method = $name_method;
						// Delete element index 1 in array
						unset($url[1]); 	
					}
				}else{
					// Delete element index 1 in array
					unset($url[1]); 
				}
			}

			// Handle Input Parameters
			if(!empty($url)){
				// Reset array start from index 0
				$this->parameter = array_values($url);
				
				// Display array
				//var_dump($this->parameter);
			}else{
				// Initialize empty array
				$this->parameter = array();
			}

			// Run controller and method with some parameters
			call_user_func_array([$this->controller, $this->method], $this->parameter);
		}

		// Check if a string starts with underscore
		private function starts_with($str, $prefix){
		    // returns a bool
		    return strpos($str, $prefix) === 0;
		}

		// Initialize default global variable
		private function initDefaultController($controller, $method, $param){
			$this->controller = $controller;
			$this->method = $method;
			$this->parameter = $param;
		}

		// Method to Parsing URL Request
		public function parseURL(){
			if(isset($_GET['url'])){
				// Remove end slash
				$url = rtrim($_GET['url'], '/');

				// Remove/filter special character
				$url = filter_var($url, FILTER_SANITIZE_URL);

				// Convert to array
				$url = explode('/',  $url);

				return $url;
			}
		}
	}
?>
