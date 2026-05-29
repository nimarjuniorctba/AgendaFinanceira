<?php 

//require_once 'classes/autoload.class.php';

    class Autoload{
        public function __construct(){
            spl_autoload_extensions('.class.php');
            spl_autoload_register(array($this, 'load'));
        }

        private function load($class){
            $extension = spl_autoload_extensions();
            
            $dirs = array(
                                'classes/'
                            ,   'classes/modelo/'
                            ,   'classes/acesso/'
                            ,   '../classes/'
                            ,   '../classes/modelo/'
                            ,   '../classes/acesso/'
                        );
            
            foreach( $dirs as $dir ) {
                if (file_exists($dir.strtolower($class).'.class.php')) {
                   require_once($dir.strtolower($class).'.class.php');
                }
            }

        }
    }

   $autoload       =   new AutoLoad();


/*
    spl_autoload_register(function($classe) {
        //include 'classes/' . $classe . '.class.php';
        //|| strpos(dirname($_SERVER["SCRIPT_FILENAME"]), "/scripts_background")

            if(file_exists("classes/modelo/{$classe}.class.php")){
                require_once("classes/modelo/{$classe}.class.php");
            }
            if(file_exists("classes/acesso/{$classe}.class.php")){
                require_once("classes/acesso/{$classe}.class.php");
            }
            if(file_exists("classes/{$classe}.class.php")){
                require_once("classes/{$classe}.class.php");
            }

    });*/