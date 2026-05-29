<?php

class acesso_empresa_admin extends empresa_admin{
   
    
    public function cadastraDados( $pdo, empresa_admin $objeto){
       try{ 
           $verifica    =   $this->verificaDados($pdo, 'email', $objeto->getEmail());
 //          var_dump($objeto);exit;
            if($verifica==false){
                $sql    =" INSERT INTO mod_empresa_admin(
                                    ema_nome
                            ,       ema_email
                            ,       ema_senha
                            ,       ema_status
                            ,       emp_id_fk
                            )VALUES(                
                                    :nome
                           ,        :email
                           ,        :senha
                           ,        :status
                           ,        :empresa

                                        )";
                $p_sql  =   $pdo->prepare($sql);

                $p_sql->bindValue(":nome",$objeto->getNome(),PDO::PARAM_STR);
                $p_sql->bindValue(":email",$objeto->getEmail(),PDO::PARAM_STR);
                $p_sql->bindValue(":senha",$objeto->getSenha(),PDO::PARAM_STR);
                $p_sql->bindValue(":status",'a',PDO::PARAM_STR);
                $p_sql->bindValue(":empresa",$objeto->getEmpresa(),PDO::PARAM_STR);
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
    public function atualizaDados( $pdo, empresa_admin $objeto){
       try{ 
            $sql    =" UPDATE mod_empresa_admin SET
                                                    ema_nome                    =   :nome
                                    ,               ema_email                   =   :email
                                    ,               emp_id_fk                   =   :empresa
                                        WHERE ema_id=:id   ";
            $p_sql  =   $pdo->prepare($sql);

            $p_sql->bindValue(":nome",$objeto->getNome(),PDO::PARAM_STR);
            $p_sql->bindValue(":email",$objeto->getEmail(),PDO::PARAM_STR);
            $p_sql->bindValue(":empresa",$objeto->getEmpresa(),PDO::PARAM_STR);
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
    public function atualizaSenha( $pdo, empresa_admin $objeto){
       try{ 
            $sql    =" UPDATE mod_empresa_admin SET
                                                    ema_senha                    =   :senha
                                        WHERE ema_id =:id   ";
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
                $sql    =   " SELECT  * FROM mod_empresa_admin WHERE ";
                
                switch($tipo){
                    
                    case    'id':
                                  $sql  .=  " ema_id = :admin"; 
                                  $p_sql  =   $pdo->prepare($sql);
                                  $p_sql->bindValue(":admin", $valor, PDO::PARAM_INT);
                                  break;                            
                }        
                $p_sql->execute();   
                $result = $p_sql->fetch(PDO::FETCH_ASSOC);
                if($p_sql->rowCount() > 0){     
                    $objeto =   new empresa_admin();
                    $objeto->setId($result["ema_id"]);                
                    $objeto->setNome($result["ema_nome"]);                
                    $objeto->setEmail($result["ema_email"]);                                           
                    $objeto->setEmpresa($result["emp_id_fk"]);                                           
                    $objeto->setStatus($result["ema_status"]);                                           
                    $objeto->setDtCadastro($result["ema_dt_cadastro"]);                
                    return $objeto;                
                }
                
       }catch(Exception $e){
           die("Erro: ".$e->getMessage());           
       }
    }   
     
    public function listarDados($pdo, $tipo='',$valor=''){
        try{
           
           $sql  =      " SELECT ema_id FROM mod_empresa_admin "; 
      
           switch ($tipo){

               case 'empresa':
                   $sql     .=      " WHERE emp_id_fk=:empresa AND ema_status<>:excluido ORDER BY ema_id DESC"; 
                   $p_sql    =   $pdo->prepare($sql);
                   $p_sql->bindValue(":empresa", $valor, PDO::PARAM_STR);
                   break;
               case 'todos':
                   $sql     .=      " WHERE ema_status<>:excluido ORDER BY ema_id DESC"; 
                   $p_sql    =   $pdo->prepare($sql);
                   break;
           }
                    
           $p_sql->bindValue(":excluido", 'e', PDO::PARAM_STR);
           $p_sql->execute(); 
            $row=0;
            $objeto = Array();
          
                while($result = $p_sql->fetch(PDO::FETCH_ASSOC)){   
                    $objeto[$row]  = $this->retornaDados($pdo, 'id', $result["ema_id"]);
                    $row++;
                }
               return $objeto;
            
        } catch (Exception $e) {
            die("Erro: ".$e->getMessage()); 
        }
    }
    public function verificaDados($pdo, $tipo='', $valor=''){
        try{
           
           $sql  =      " SELECT ema_id FROM mod_empresa_admin "; 
           $sql .=      " WHERE "; 
      
           switch ($tipo){
               case 'email':
                   $sql .=      " ema_email=:email "; 
                   $p_sql  =   $pdo->prepare($sql);
                   $p_sql->bindValue(":email", $valor, PDO::PARAM_STR);
                   break;
           }
                    
           $p_sql->execute(); 
            $resultado    =   false;         
                while($result = $p_sql->fetch(PDO::FETCH_ASSOC)){   
                        $resultado    =   $result['ema_id'];
                }
               return $resultado;
            
        } catch (Exception $e) {
            die("Erro: ".$e->getMessage()); 
        }
    }
    
    public function FazerLogin($pdo, $email='', $senha=''){
        try{

           $sql  =      " SELECT ema_id FROM mod_empresa_admin  
                            WHERE  ema_email=:email AND ema_senha=:senha AND ema_status=:ativo"; 
           
           $p_sql  =   $pdo->prepare($sql);
           $p_sql->bindValue(":email", $email);
           $p_sql->bindValue(":senha", $senha);
           $p_sql->bindValue(":ativo", 'a', PDO::PARAM_STR);
                    
            $p_sql->execute();
            $result = $p_sql->fetch(PDO::FETCH_ASSOC);
            $objeto=false;
            if($p_sql->rowCount() > 0){  
                $objeto =   $this->retornaDados($pdo, 'id', $result["ema_id"]);
            }  
                return $objeto;                
            
        } catch (Exception $e) {
            die("Erro: ".$e->getMessage()); 
        }
    }
    
    public function Deletar($pdo,  $valor=''){
        try{
           
           $sql  =      " UPDATE mod_empresa_admin SET ema_status=:status"; 
           $sql .=      " WHERE ema_id=:id "; 

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
