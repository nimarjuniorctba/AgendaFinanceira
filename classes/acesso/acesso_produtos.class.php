<?php

class acesso_produtos extends produtos{
       
    public function cadastraDados( $pdo, produtos $objeto){
       try{ 

            $sql    =" INSERT INTO mod_produtos(
                                pro_titulo
                        ,       pro_descricao
                        ,       pro_codigobarras   
                        ,       pro_valor_custo
                        ,       pro_valor_venda      
                        ,       pro_quantidade
                        ,       cat_id_fk 
                        ,       for_id_fk
                        ,       emp_id_fk                        
                                            )VALUES(                                                            
                                :titulo
                       ,        :descricao         
                       ,        :codigobarras
                       ,        :valorcusto         
                       ,        :valorvenda
                       ,        :quantidade         
                       ,        :categoria    
                       ,        :fornecedor
                       ,        :empresa                       )";

            $p_sql  =   $pdo->prepare($sql);
            $p_sql->bindValue(":titulo",$objeto->getTitulo(),PDO::PARAM_STR);
            $p_sql->bindValue(":descricao",$objeto->getDescricao(),PDO::PARAM_STR);
            $p_sql->bindValue(":codigobarras",$objeto->getCodigoBarras(),PDO::PARAM_STR);     
            $p_sql->bindValue(":valorcusto",$objeto->getValorCusto(),PDO::PARAM_STR);
            $p_sql->bindValue(":valorvenda",$objeto->getValorVenda(),PDO::PARAM_STR);
            $p_sql->bindValue(":quantidade",$objeto->getQuantidade(),PDO::PARAM_STR);             
            $p_sql->bindValue(":categoria",$objeto->getCategoria(),PDO::PARAM_STR);
            $p_sql->bindValue(":fornecedor",$objeto->getFornecedor(),PDO::PARAM_STR);
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
    
    public function atualizaDados( $pdo, produtos $objeto){
           try{  
                $sql    =" UPDATE mod_produtos SET
                                                            pro_titulo              =   :titulos
                                                    ,       pro_descricao           =   :descricao    
                                                    ,       pro_codigobarras        =   :codigobarras
                                                    ,       pro_valor_custo         =   :valorcusto    
                                                    ,       pro_valor_venda         =   :valorvenda
                                                    ,       pro_quantidade          =   :quantidade    
                                                    ,       pro_status              =   :status            
                                                    ,       cat_id_fk               =   :categoria
                                                    ,       for_id_fk               =   :fornecedor
                                                    ,       emp_id_fk               =   :empresa
                                                    
                                            WHERE pro_id =:id   ";
                $p_sql  =   $pdo->prepare($sql);

                $p_sql->bindValue(":titulos",$objeto->getTitulo(),PDO::PARAM_STR);
                $p_sql->bindValue(":descricao",$objeto->getDescricao(),PDO::PARAM_STR);
                $p_sql->bindValue(":codigobarras",$objeto->getCodigoBarras(),PDO::PARAM_STR);
                $p_sql->bindValue(":valorcusto",$objeto->getValorCusto(),PDO::PARAM_STR);
                $p_sql->bindValue(":valorvenda",$objeto->getValorVenda(),PDO::PARAM_STR);
                $p_sql->bindValue(":quantidade",$objeto->getQuantidade(),PDO::PARAM_STR);        
                $p_sql->bindValue(":status",$objeto->getStatus(),PDO::PARAM_STR);
                $p_sql->bindValue(":categoria",$objeto->getCategoria(),PDO::PARAM_STR);        
                $p_sql->bindValue(":fornecedor",$objeto->getFornecedor(),PDO::PARAM_STR);
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
    
    public function retornaDados( $pdo, $tipo='', $valor=''){
       try{ 
                $sql    =" SELECT * FROM mod_produtos WHERE ";
                
                switch($tipo){
                    
                    case    'id':
                                  $sql  .=  " pro_id  = :produto"; 
                                  $p_sql  =   $pdo->prepare($sql);
                                  $p_sql->bindValue(":produto", $valor, PDO::PARAM_INT);
                                  break;                            
                }               
                $p_sql->execute();
                $result = $p_sql->fetch(PDO::FETCH_ASSOC);
                if($p_sql->rowCount() > 0){     
                    $objeto =   new Produtos();
                    $objeto->setId($result["pro_id"]);                
                    $objeto->setTitulo($result["pro_titulo"]);                
                    $objeto->setDescricao($result["pro_descricao"]);                
                    $objeto->setCodigoBarras($result["pro_codigobarras"]);                
                    $objeto->setValorCusto($result["pro_valor_custo"]);                
                    $objeto->setValorVenda($result["pro_valor_venda"]);  
                    $objeto->setQuantidade($result["pro_quantidade"]);                
                    $objeto->setStatus($result["pro_status"]); 
                    $objeto->setDtCadastro($result["pro_dt_cadastro"]);                     
                    $objeto->setCategoria($result["cat_id_fk"]);    
                    $objeto->setFornecedor($result["for_id_fk"]); 
                    $objeto->setEmpresa($result["emp_id_fk"]);                    
                    
                    return $objeto;                
                }
       }catch(Exception $e){
           die("Erro: ".$e->getMessage());           
       }
    }   
     
    public function listarDados($pdo, $tipo='',$valor=''){
        try{
           
           $sql  =      " SELECT pro_id FROM mod_produtos "; 
      
           switch ($tipo){
               case 'empresa':
                   $sql     .=      " WHERE pro_status<>:excluido AND emp_id_fk=:empresa"; 
                   $p_sql    =      $pdo->prepare($sql);
                   $p_sql->bindValue(":empresa", $valor, PDO::PARAM_STR);
                   break;
           }
                    
           $p_sql->bindValue(":excluido", 'e', PDO::PARAM_STR);
           $p_sql->execute(); 
            $row=0;
            $objeto = Array();
          
                while($result = $p_sql->fetch(PDO::FETCH_ASSOC)){   
                    $objeto[$row]  = $this->retornaDados($pdo, 'id', $result["pro_id"]);
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
           
           $sql  =      " UPDATE mod_produtos SET pro_status=:status"; 
           $sql .=      " WHERE pro_id=:id "; 

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
