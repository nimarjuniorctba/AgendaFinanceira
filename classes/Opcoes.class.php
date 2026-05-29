<?php

class Opcoes{
 
    
    function ServidorLocal(){
        if(isset($_SERVER['HTTP_HOST'])){
            if($_SERVER['HTTP_HOST'] == '127.0.0.1'){
                return true;
            }else{
                return false;
            }     
        }
    }
    
    function SalvaLogin($email,$senha){
        
        $sql1 	= "INSERT INTO multi (nome, email) VALUES ('$nome','$email')";
	$conexao->query($sql1);											
    }
    
    function removeAcento($string){
        
     $nova_string = preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$string);											
     
     return $nova_string;
     
    }
    
    function inverteDateTime($datatime){
        return implode('/',array_reverse(explode('-', substr($datatime, 0, 10)))).' às '.substr($datatime, 11, 8);
    }    
    
    function codificaDados($urle) {
         for($xe = 0 ; $xe <= 3 ; $xe++)
         {
               $urle = base64_encode($urle);
         }
         return $urle;
   }

   function decodificaDados($urld){
         for($xd = 0 ; $xd <= 3 ; $xd++)
         {
               $urld = base64_decode($urld);
         }
         return $urld;
   }   

   function verificaExtensao($valor){
       
    $extensoesImagem = array("jpg", "jpeg", "png", "gif", "webp", "bmp", "svg", "peg", "ebp"); 

    if (in_array($valor, $extensoesImagem)) { 
        return "imagem";
    } else {
        return "documento";
    }
} 
    
    
    
}