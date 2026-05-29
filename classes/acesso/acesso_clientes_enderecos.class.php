<?php

class acesso_clientes_enderecos extends clientes_enderecos{
        
    
    public function cadastraDados( $pdo, clientes_enderecos $objeto){
       try{ 
            $sql    =" INSERT INTO mod_clientes_enderecos(
                                cle_cep
                        ,       cle_rua
                        ,       cle_numero
                        ,       cle_complemento
                        ,       cle_bairro
                        ,       cle_cidade
                        ,       cle_estado
                        ,       cli_id_fk
                                            )VALUES(                
                                :cep
                       ,        :rua
                       ,        :numero
                       ,        :complemento
                       ,        :bairro
                       ,        :cidade
                       ,        :estado
                       ,        :cliente
                    )";
            $p_sql  =   $pdo->prepare($sql);
            $p_sql->bindValue(":cep",$objeto->getCep(),PDO::PARAM_STR);
            $p_sql->bindValue(":rua",$objeto->getRua(),PDO::PARAM_STR);
            $p_sql->bindValue(":numero",$objeto->getNumero(),PDO::PARAM_STR);
            $p_sql->bindValue(":complemento",$objeto->getComplemento(),PDO::PARAM_STR);
            $p_sql->bindValue(":bairro",$objeto->getBairro(),PDO::PARAM_STR);
            $p_sql->bindValue(":cidade",$objeto->getCidade(),PDO::PARAM_STR);
            $p_sql->bindValue(":estado",$objeto->getEstado(),PDO::PARAM_STR);
            $p_sql->bindValue(":cliente",$objeto->getCliente(),PDO::PARAM_INT);

            $p_sql->execute();
                if($p_sql->rowCount()>0){
                    return $pdo->lastInsertId();                              
                }else{
                    return false;
                }         
       }catch(Exception $e){
           die("Erro: ".$e->getMessage());           
       }
    }
public function atualizaDados( $pdo, clientes_enderecos $objeto){
       try{ 
            $sql    =" UPDATE mod_clientes_enderecos SET
                                                cle_cep                     =   :cep
                                ,               cle_rua                     =   :rua
                                ,               cle_numero                  =   :numero
                                ,               cle_complemento             =   :complemento
                                ,               cle_bairro                  =   :bairro
                                ,               cle_cidade                  =   :cidade
                                ,               cle_estado                  =   :estado
                                    WHERE cle_id =:id   ";
            $p_sql  =   $pdo->prepare($sql);
            $p_sql->bindValue(":cep",$objeto->getCep(),PDO::PARAM_STR);
            $p_sql->bindValue(":rua",$objeto->getRua(),PDO::PARAM_STR);
            $p_sql->bindValue(":numero",$objeto->getNumero(),PDO::PARAM_STR);
            $p_sql->bindValue(":complemento",$objeto->getComplemento(),PDO::PARAM_STR);
            $p_sql->bindValue(":bairro",$objeto->getBairro(),PDO::PARAM_STR);
            $p_sql->bindValue(":cidade",$objeto->getCidade(),PDO::PARAM_STR);
            $p_sql->bindValue(":estado",$objeto->getEstado(),PDO::PARAM_STR);
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
                $sql    =" SELECT * FROM mod_clientes_enderecos   WHERE ";
                
                switch($tipo){
                    
                    case    'id':
                                  $sql  .=  " cle_id =  :id"; 
                                  $p_sql  =   $pdo->prepare($sql);
                                  $p_sql->bindValue(":id", $valor, PDO::PARAM_INT);
                                  break;                            
                }               
                $p_sql->execute();
                $result = $p_sql->fetch(PDO::FETCH_ASSOC);
                if($p_sql->rowCount() > 0){     
                    $objeto =   new clientes_enderecos();
                    $objeto->setId($result["cle_id"]);                
                    $objeto->setCep($result["cle_cep"]);                
                    $objeto->setRua($result["cle_rua"]);                                           
                    $objeto->setNumero($result["cle_numero"]); 
                    $objeto->setComplemento($result["cle_complemento"]);                
                    $objeto->setBairro($result["cle_bairro"]);                
                    $objeto->setCidade($result["cle_cidade"]);                
                    $objeto->setEstado($result["cle_estado"]);                
                    $objeto->setDtCadastro($result["cle_dt_cadastro"]);                                           
                    $objeto->getStatus($result["cle_status"]); 
                    $objeto->setCliente($result["cli_id_fk"]); 
                    return $objeto;                
                }
                
       }catch(Exception $e){
           die("Erro: ".$e->getMessage());           
       }
    }   
     
    public function listarDados($pdo, $tipo='',$valor=''){
        try{
           
           $sql  =      " SELECT cle_id  FROM mod_clientes_enderecos "; 
      
           switch ($tipo){
               case 'cliente':
                   $sql .=      " WHERE cle_status<>:excluido AND cli_id_fk=:cliente ORDER BY cle_id DESC "; 
                   $p_sql  =   $pdo->prepare($sql);
                   $p_sql->bindValue(":cliente", $valor, PDO::PARAM_STR);
                   $p_sql->bindValue(":excluido", 'e', PDO::PARAM_STR);
                   break;
               case 'todos':
           }
                    
           $p_sql->execute(); 
            $row=0;
            $objeto = Array();
          
                while($result = $p_sql->fetch(PDO::FETCH_ASSOC)){   
                    $objeto[$row]  = $this->retornaDados($pdo, 'id', $result["cle_id"]);
                    $row++;
                }
               return $objeto;
            
        } catch (Exception $e) {
            die("Erro: ".$e->getMessage()); 
        }
    }
 
    public function Deletar($pdo,$valor=''){
        try{
           
           $sql  =      " UPDATE mod_clientes_enderecos SET cle_status=:status"; 
           $sql .=      " WHERE cle_id =:id "; 
      
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
