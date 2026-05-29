<?php

class Sessions{
    
    public function __construct(){
      session_start();  
    }
    
    public function getValor($campo){
        if(isset($_SESSION[$campo])){
            return $_SESSION[$campo];
        }else{
            return  false;
        }       
    }
    
    public function setValor($campo,$valor){
       $_SESSION[$campo] = $valor;
    }
    
    public function unsetValor($campo=''){
        
        if(strlen($campo)>0){
            unset($_SESSION[$campo]);
        }else{
            foreach ($_SESSION as $key=>$value)
            {
                if (isset($_SESSION[$key]))
                    unset($_SESSION[$key]);
            }
        }    
            
    }
    
}