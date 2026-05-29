<?php

class acesso_produtos_categorias extends produtos_categorias{
       
    public function cadastraDados( $pdo, produtos_categorias $objeto){
       try{ 

            $sql    =" INSERT INTO mod_produtos_categoria(
                                cat_nome
                        ,       cat_descricao
                        ,       emp_id_fk                                    
                                            )VALUES(                                                            
                                :nome
                       ,        :descricao         
                       ,        :empresa           )";

            $p_sql  =   $pdo->prepare($sql);
            $p_sql->bindValue(":nome",$objeto->getNome(),PDO::PARAM_STR);
            $p_sql->bindValue(":descricao",$objeto->getDescricao(),PDO::PARAM_STR);
            $p_sql->bindValue(":empresa",$objeto->getEmpresa(),PDO::PARAM_STR);                        
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
    
    public function atualizaDados( $pdo, produtos_categorias $objeto){
           try{  
                $sql    =" UPDATE mod_produtos_categoria SET
                                                            cat_nome            = :nome
                                                    ,       cat_descricao       = :descricao    
                                                    ,       cat_status          = :status

                                            WHERE cat_id =:id   ";
                $p_sql  =   $pdo->prepare($sql);

                $p_sql->bindValue(":nome",$objeto->getNome(),PDO::PARAM_STR);
                $p_sql->bindValue(":descricao",$objeto->getDescricao(),PDO::PARAM_STR);
                $p_sql->bindValue(":status",$objeto->getStatus(),PDO::PARAM_STR);
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
                $sql    =" SELECT * FROM mod_produtos_categoria WHERE ";
                
                switch($tipo){
                    
                    case    'id':
                                  $sql  .=  " cat_id  = :categoria"; 
                                  $p_sql  =   $pdo->prepare($sql);
                                  $p_sql->bindValue(":categoria", $valor, PDO::PARAM_INT);
                                  break;                            
                }               
                $p_sql->execute();
                $result = $p_sql->fetch(PDO::FETCH_ASSOC);
                if($p_sql->rowCount() > 0){     
                    $objeto =   new Produtos_Categorias();
                    $objeto->setId($result["cat_id"]);                
                    $objeto->setNome($result["cat_nome"]);                
                    $objeto->setDescricao($result["cat_descricao"]);                
                    $objeto->setStatus($result["cat_status"]);                
                    $objeto->setDtCadastro($result["cat_dt_cadastro"]);                
                    $objeto->setEmpresa($result["emp_id_fk"]);   
                    
                    return $objeto;                
                }
       }catch(Exception $e){
           die("Erro: ".$e->getMessage());           
       }
    }   
     
    public function listarDados($pdo, $tipo='',$valor=''){
        try{
           
           $sql  =      " SELECT cat_id FROM mod_produtos_categoria "; 
      
           switch ($tipo){
               case 'empresa':
                   $sql     .=      " WHERE cat_status<>:excluido AND emp_id_fk=:empresa"; 
                   $p_sql    =      $pdo->prepare($sql);
                   $p_sql->bindValue(":empresa", $valor, PDO::PARAM_STR);
                   break;
           }
                    
           $p_sql->bindValue(":excluido", 'e', PDO::PARAM_STR);
           $p_sql->execute(); 
            $row=0;
            $objeto = Array();
          
                while($result = $p_sql->fetch(PDO::FETCH_ASSOC)){   
                    $objeto[$row]  = $this->retornaDados($pdo, 'id', $result["cat_id"]);
                    $row++;
                }
               return $objeto;
            
        } catch (Exception $e) {
            die("Erro: ".$e->getMessage()); 
        }
    }
    

    public function verificaDados($pdo, $tipo = '', $valor = '') {

    }   
    
    public function Deletar($pdo, $valor=''){
        try{
           
           $sql  =      " UPDATE mod_produtos_categoria SET cat_status=:status"; 
           $sql .=      " WHERE cat_id=:id "; 

           $p_sql  =   $pdo->prepare($sql);
           $p_sql->bindValue(":status", 'e', PDO::PARAM_STR);
           $p_sql->bindValue(":id", $valor, PDO::PARAM_INT);

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
