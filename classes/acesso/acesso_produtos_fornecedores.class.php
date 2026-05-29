<?php

class acesso_produtos_fornecedores extends produtos_fornecedores{
       
    public function cadastraDados( $pdo, produtos_fornecedores $objeto){
       try{ 

            $sql    =" INSERT INTO mod_produtos_fornecedores(
                                for_nome
                        ,       for_cnpj
                        ,       for_email   
                        ,       for_telefone
                        ,       for_celular      
                        ,       for_descricao
                        ,       cat_id_fk   
                        ,       emp_id_fk                        
                                            )VALUES(                                                            
                                :nome
                       ,        :cnpj         
                       ,        :email
                       ,        :telefone         
                       ,        :celular
                       ,        :descricao         
                       ,        :categoria    
                       ,        :empresa            )";

            $p_sql  =   $pdo->prepare($sql);
            $p_sql->bindValue(":nome",$objeto->getNome(),PDO::PARAM_STR);
            $p_sql->bindValue(":cnpj",$objeto->getCnpj(),PDO::PARAM_STR);
            $p_sql->bindValue(":email",$objeto->getEmail(),PDO::PARAM_STR);     
            $p_sql->bindValue(":telefone",$objeto->getTelefone(),PDO::PARAM_STR);
            $p_sql->bindValue(":celular",$objeto->getCelular(),PDO::PARAM_STR);
            $p_sql->bindValue(":descricao",$objeto->getDescricao(),PDO::PARAM_STR);             
            $p_sql->bindValue(":categoria",$objeto->getCategoria(),PDO::PARAM_STR);
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
    
    public function atualizaDados( $pdo, produtos_fornecedores $objeto){
           try{  
                $sql    =" UPDATE mod_produtos_fornecedores SET
                                                            for_nome            = :nome
                                                    ,       for_cnpj            = :cnpj    
                                                    ,       for_email           = :email
                                                    ,       for_telefone        = :telefone    
                                                    ,       for_celular         = :celular
                                                    ,       for_descricao       = :descricao    
                                                    ,       for_status          = :status            
                                                    ,       cat_id_fk           = :categoria

                                            WHERE for_id =:id   ";
                $p_sql  =   $pdo->prepare($sql);

                $p_sql->bindValue(":nome",$objeto->getNome(),PDO::PARAM_STR);
                $p_sql->bindValue(":cnpj",$objeto->getCnpj(),PDO::PARAM_STR);
                $p_sql->bindValue(":email",$objeto->getEmail(),PDO::PARAM_STR);
                $p_sql->bindValue(":telefone",$objeto->getTelefone(),PDO::PARAM_STR);
                $p_sql->bindValue(":celular",$objeto->getCelular(),PDO::PARAM_STR);
                $p_sql->bindValue(":descricao",$objeto->getDescricao(),PDO::PARAM_STR);        
                $p_sql->bindValue(":status",$objeto->getStatus(),PDO::PARAM_STR);
                $p_sql->bindValue(":categoria",$objeto->getCategoria(),PDO::PARAM_STR);                  
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
                $sql    =" SELECT * FROM mod_produtos_fornecedores WHERE ";
                
                switch($tipo){
                    
                    case    'id':
                                  $sql  .=  " for_id  = :categoria"; 
                                  $p_sql  =   $pdo->prepare($sql);
                                  $p_sql->bindValue(":categoria", $valor, PDO::PARAM_INT);
                                  break;                            
                }               
                $p_sql->execute();
                $result = $p_sql->fetch(PDO::FETCH_ASSOC);
                if($p_sql->rowCount() > 0){     
                    $objeto =   new Produtos_Fornecedores();
                    $objeto->setId($result["for_id"]);                
                    $objeto->setNome($result["for_nome"]);                
                    $objeto->setCnpj($result["for_cnpj"]);                
                    $objeto->setEmail($result["for_email"]);                
                    $objeto->setTelefone($result["for_telefone"]);                
                    $objeto->setCelular($result["for_celular"]);  
                    $objeto->setDescricao($result["for_descricao"]);                
                    $objeto->setStatus($result["for_status"]);                
                    $objeto->setDtCadastro($result["for_dt_cadastro"]);    
                    $objeto->setCategoria($result["cat_id_fk"]); 
                    $objeto->setEmpresa($result["emp_id_fk"]);                    
                    
                    return $objeto;                
                }
       }catch(Exception $e){
           die("Erro: ".$e->getMessage());           
       }
    }   
     
    public function listarDados($pdo, $tipo='',$valor=''){
        try{
           
           $sql  =      " SELECT for_id FROM mod_produtos_fornecedores "; 
      
           switch ($tipo){
               case 'empresa':
                   $sql     .=      " WHERE for_status<>:excluido AND emp_id_fk=:empresa"; 
                   $p_sql    =      $pdo->prepare($sql);
                   $p_sql->bindValue(":empresa", $valor, PDO::PARAM_STR);
                   break;
           }
                    
           $p_sql->bindValue(":excluido", 'e', PDO::PARAM_STR);
           $p_sql->execute(); 
            $row=0;
            $objeto = Array();
          
                while($result = $p_sql->fetch(PDO::FETCH_ASSOC)){   
                    $objeto[$row]  = $this->retornaDados($pdo, 'id', $result["for_id"]);
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
           
           $sql  =      " UPDATE mod_produtos_fornecedores SET for_status=:status"; 
           $sql .=      " WHERE for_id=:id "; 

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
