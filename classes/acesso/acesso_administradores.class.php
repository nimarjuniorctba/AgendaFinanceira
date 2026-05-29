<?php

class acesso_administradores extends administradores{
   
    
    public function cadastraDados( $pdo, administradores $objeto){
       try{ 
           $verifica    =   $this->verificaDados($pdo, 'email', $objeto->getEmail());
            if($verifica==false){
                $sql    =" INSERT INTO mod_administradores(
                                    adm_nome
                            ,       adm_email
                            ,       adm_senha
                            ,       adm_status
                            )VALUES(                
                                    :nome
                           ,        :email
                           ,        :senha
                           ,        :status 
                                        )";
                $p_sql  =   $pdo->prepare($sql);

                $p_sql->bindValue(":nome",$objeto->getNome(),PDO::PARAM_STR);
                $p_sql->bindValue(":email",$objeto->getEmail(),PDO::PARAM_STR);
                $p_sql->bindValue(":senha",$objeto->getSenha(),PDO::PARAM_STR);
                $p_sql->bindValue(":status",'a',PDO::PARAM_STR);
                $p_sql->execute();
                    if($p_sql->rowCount()>0){
                        return $pdo->lastInsertId();                              
                    }else{
                        return false;
                    }
            }else{
                return false;
            }         
       }catch(Exception $e){
           die("Erro: ".$e->getMessage());           
       }
    }
    public function atualizaDados( $pdo, administradores $objeto){
       try{ 
            $sql    =" UPDATE mod_administradores SET
                                                    adm_nome                    =   :nome
                                    ,               adm_email                   =   :email
                                        WHERE adm_id=:id   ";
            $p_sql  =   $pdo->prepare($sql);

            $p_sql->bindValue(":nome",$objeto->getNome(),PDO::PARAM_STR);
            $p_sql->bindValue(":email",$objeto->getEmail(),PDO::PARAM_STR);
            $p_sql->bindValue(":id",$objeto->getId(),PDO::PARAM_INT);
            $p_sql->execute();
                if($p_sql->rowCount()>0){
                    return true;
                }else{
                    return false;
                }        
       }catch(Exception $e){
           die("Erro: ".$e->getMessage());           
       }
    } 
    public function atualizaSenha( $pdo, administradores $objeto){
       try{ 
            $sql    =" UPDATE mod_administradores SET
                                                    adm_senha                    =   :senha
                                        WHERE adm_id =:id   ";
            $p_sql  =   $pdo->prepare($sql);

            $p_sql->bindValue(":senha",$objeto->getSenha(),PDO::PARAM_STR);
            $p_sql->bindValue(":id",$objeto->getId(),PDO::PARAM_INT);
            $p_sql->execute();
                if($p_sql->rowCount()>0){
                    return true;
                }else{
                    return false;
                }        
       }catch(Exception $e){
           die("Erro: ".$e->getMessage());           
       }
    } 
    public function retornaDados( $pdo, $tipo='', $valor=''){
       try{ 
                $sql    =   " SELECT  * FROM mod_administradores WHERE ";
                
                switch($tipo){                    
                    case    'id':
                                  $sql  .=  " adm_id = :admin"; 
                                  $p_sql  =   $pdo->prepare($sql);
                                  $p_sql->bindValue(":admin", $valor, PDO::PARAM_INT);
                                  break;                            
                }        
                $p_sql->execute();   
                $result = $p_sql->fetch(PDO::FETCH_ASSOC);
                if($p_sql->rowCount() > 0){     
                    $objeto =   new administradores();
                    $objeto->setId($result["adm_id"]);                
                    $objeto->setNome($result["adm_nome"]);                
                    $objeto->setEmail($result["adm_email"]);                                                                                     
                    $objeto->setStatus($result["adm_status"]);                                           
                    $objeto->setDtCadastro($result["adm_dt_cadastro"]);                
                    return $objeto;                
                }
                
       }catch(Exception $e){
           die("Erro: ".$e->getMessage());           
       }
    }   
     
    public function listarDados($pdo, $tipo=''){
        try{
           
           $sql  =      " SELECT adm_id FROM mod_administradores "; 
      
           switch ($tipo){
               case 'todos':
                   $sql     .=      " WHERE adm_status<>:excluido ORDER BY adm_id DESC"; 
                   $p_sql    =   $pdo->prepare($sql);
                   break;
           }
                    
           $p_sql->bindValue(":excluido", 'e', PDO::PARAM_STR);
           $p_sql->execute(); 
            $row=0;
            $objeto = Array();
          
                while($result = $p_sql->fetch(PDO::FETCH_ASSOC)){   
                    $objeto[$row]  = $this->retornaDados($pdo, 'id', $result["adm_id"]);
                    $row++;
                }
               return $objeto;
            
        } catch (Exception $e) {
            die("Erro: ".$e->getMessage()); 
        }
    }
    public function verificaDados($pdo, $tipo='', $valor=''){
        try{
           
           $sql  =      " SELECT adm_id FROM mod_administradores "; 
           $sql .=      " WHERE "; 
      
           switch ($tipo){
               case 'email':
                   $sql .=      " adm_email=:email "; 
                   $p_sql  =   $pdo->prepare($sql);
                   $p_sql->bindValue(":email", $valor, PDO::PARAM_STR);
                   break;
           }
                    
           $p_sql->execute(); 
            $resultado    =   false;         
                while($result = $p_sql->fetch(PDO::FETCH_ASSOC)){   
                        $resultado    =   $result['adm_id'];
                }
               return $resultado;
            
        } catch (Exception $e) {
            die("Erro: ".$e->getMessage()); 
        }
    }
    
    public function FazerLogin($pdo, $email='', $senha=''){
        try{

           $sql  =      " SELECT adm_id FROM mod_administradores  
                            WHERE  adm_email=:email AND adm_senha=:senha AND adm_status=:ativo"; 
           
           $p_sql  =   $pdo->prepare($sql);
           $p_sql->bindValue(":email", $email);
           $p_sql->bindValue(":senha", $senha);
           $p_sql->bindValue(":ativo", 'a', PDO::PARAM_STR);
                    
            $p_sql->execute();
            $result = $p_sql->fetch(PDO::FETCH_ASSOC);
            $objeto=false;
            if($p_sql->rowCount() > 0){  
                $objeto =   $this->retornaDados($pdo, 'id', $result["adm_id"]);
            }  
                return $objeto;                
            
        } catch (Exception $e) {
            die("Erro: ".$e->getMessage()); 
        }
    }
    
    public function Deletar($pdo,  $valor=''){
        try{
           
           $sql  =      " UPDATE mod_administradores SET adm_status=:status"; 
           $sql .=      " WHERE adm_id=:id "; 

           $p_sql  =   $pdo->prepare($sql);
           $p_sql->bindValue(":status", 'e', PDO::PARAM_STR);
           $p_sql->bindValue(":id", $valor, PDO::PARAM_STR);
       
           $p_sql->execute(); 
           if($p_sql->rowCount()>0){
              return true; 
           }else{
            return false;
           } 
        } catch (Exception $e) {
            die("Erro: ".$e->getMessage()); 
        }
    } 

   
    
}
