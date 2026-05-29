<?php

class acesso_clientes extends clientes{
       
    public function cadastraDados( $pdo, clientes $objeto){
       try{ 
            if($objeto->getTipoCadastro()=='f'){
                $verifica = $this->verificaDados($pdo, 'cpf', $objeto->getPfCpf());
            }else{
                $verifica = $this->verificaDados($pdo, 'cnpj', $objeto->getPjCnpj());
            }     
            if ($verifica == false) {
                
                        $sql    =" INSERT INTO mod_clientes(
                                            cli_tipo_cad
                                    ,       cli_pf_nome
                                    ,       cli_pf_cpf
                                    ,       cli_pf_dt_nascimento
                                    ,       cli_pj_cnpj
                                    ,       cli_pj_fantasia
                                    ,       cli_pj_razao
                                    ,       cli_pj_ie
                                    ,       cli_pj_ie_isento
                                    ,       cli_pj_responsavel
                                    ,       cli_telefone
                                    ,       cli_celular
                                    ,       cli_facebook
                                    ,       cli_instagram
                                    ,       cli_email
                                    ,       cli_admin
                                    ,       emp_id_fk
							)VALUES(                                                            
                                            :tipo_cadastro
                                   ,        :pf_nome
                                   ,        :pf_cpf
                                   ,        :pf_dt_nascimento
                                   ,        :pj_cnpj
                                   ,        :pj_fantasia
                                   ,        :pj_razao
                                   ,        :pj_ie
                                   ,        :pj_ie_isento
                                   ,        :pj_responsavel
                                   ,        :telefone
                                   ,        :celular
                                   ,        :facebook
                                   ,        :instagram
                                   ,        :email
                                   ,        :admin
                                   ,        :empresa
                                )";
                        $p_sql  =   $pdo->prepare($sql);
                        $p_sql->bindValue(":tipo_cadastro",$objeto->getTipoCadastro(),PDO::PARAM_STR);
                        $p_sql->bindValue(":pf_nome",$objeto->getPfNome(),PDO::PARAM_STR);
                        $p_sql->bindValue(":pf_cpf",$objeto->getPfCpf(),PDO::PARAM_STR);
                        $p_sql->bindValue(":pf_dt_nascimento",$objeto->getPfDtNascimento(),PDO::PARAM_STR);
                        $p_sql->bindValue(":pj_cnpj",$objeto->getPjCnpj(),PDO::PARAM_STR);
                        $p_sql->bindValue(":pj_fantasia",$objeto->getPjFantasia(),PDO::PARAM_STR);
                        $p_sql->bindValue(":pj_razao",$objeto->getPjRazao(),PDO::PARAM_STR);
                        $p_sql->bindValue(":pj_ie",$objeto->getPjIe(),PDO::PARAM_STR);
                        $p_sql->bindValue(":pj_ie_isento",$objeto->getPjIeIsento(),PDO::PARAM_STR);
                        $p_sql->bindValue(":pj_responsavel",$objeto->getResponsavel(),PDO::PARAM_STR);
                        $p_sql->bindValue(":telefone",$objeto->getTelefone(),PDO::PARAM_STR);
                        $p_sql->bindValue(":celular",$objeto->getCelular(),PDO::PARAM_STR);
                        $p_sql->bindValue(":facebook",$objeto->getFacebook(),PDO::PARAM_STR);
                        $p_sql->bindValue(":instagram",$objeto->getInstagram(),PDO::PARAM_STR);
                        $p_sql->bindValue(":email",$objeto->getEmail(),PDO::PARAM_STR);
                        $p_sql->bindValue(":admin",$objeto->getAdmin(),PDO::PARAM_STR);
                        $p_sql->bindValue(":empresa",$objeto->getEmpresa(),PDO::PARAM_STR);
                        $p_sql->execute();
                            if($p_sql->rowCount()>0){
                                return $pdo->lastInsertId();                              
                            }else{
                                return false;
                            }
            }else {
                return false;
            }         
       }catch(Exception $e){
           die("Erro: ".$e->getMessage());           
       }
    }
public function atualizaDados( $pdo, clientes $objeto){
       try{  
            $sql    =" UPDATE mod_clientes SET
                                                        cli_tipo_cad            = :tipo_cadastro
                                                ,       cli_pf_nome             = :pf_nome    
                                                ,       cli_pf_cpf              = :pf_cpf
                                                ,       cli_pf_dt_nascimento    = :pf_dt_nascimento
                                                ,       cli_pj_cnpj             = :pj_cnpj
                                                ,       cli_pj_fantasia         = :pj_fantasia
                                                ,       cli_pj_razao            = :pj_razao
                                                ,       cli_pj_ie               = :pj_ie
                                                ,       cli_pj_ie_isento        = :pj_ie_isento
                                                ,       cli_pj_responsavel      = :pj_responsavel
                                                ,       cli_telefone            = :telefone
                                                ,       cli_celular             = :celular
                                                ,       cli_facebook            = :facebook
                                                ,       cli_instagram           = :instagram
                                                ,       cli_email               = :email
                                        WHERE cli_id=:id   ";
            $p_sql  =   $pdo->prepare($sql);

            $p_sql->bindValue(":tipo_cadastro",$objeto->getTipoCadastro(),PDO::PARAM_STR);
            $p_sql->bindValue(":pf_nome",$objeto->getPfNome(),PDO::PARAM_STR);
            $p_sql->bindValue(":pf_cpf",$objeto->getPfCpf(),PDO::PARAM_STR);
            $p_sql->bindValue(":pf_dt_nascimento",$objeto->getPfDtNascimento(),PDO::PARAM_STR);
            $p_sql->bindValue(":pj_cnpj",$objeto->getPjCnpj(),PDO::PARAM_STR);
            $p_sql->bindValue(":pj_fantasia",$objeto->getPjFantasia(),PDO::PARAM_STR);
            $p_sql->bindValue(":pj_razao",$objeto->getPjRazao(),PDO::PARAM_STR);
            $p_sql->bindValue(":pj_ie",$objeto->getPjIe(),PDO::PARAM_STR);
            $p_sql->bindValue(":pj_ie_isento",$objeto->getPjIeIsento(),PDO::PARAM_STR);
            $p_sql->bindValue(":pj_responsavel",$objeto->getResponsavel(),PDO::PARAM_STR);
            $p_sql->bindValue(":telefone",$objeto->getTelefone(),PDO::PARAM_STR);
            $p_sql->bindValue(":celular",$objeto->getCelular(),PDO::PARAM_STR);
            $p_sql->bindValue(":facebook",$objeto->getFacebook(),PDO::PARAM_STR);
            $p_sql->bindValue(":instagram",$objeto->getInstagram(),PDO::PARAM_STR);
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
    public function retornaDados( $pdo, $tipo='', $valor=''){
       try{ 
                $sql    =" SELECT * FROM mod_clientes WHERE ";
                
                switch($tipo){
                    
                    case    'id':
                                  $sql  .=  " cli_id = :cliente"; 
                                  $p_sql  =   $pdo->prepare($sql);
                                  $p_sql->bindValue(":cliente", $valor, PDO::PARAM_INT);
                                  break;                            
                }               
                $p_sql->execute();
                $result = $p_sql->fetch(PDO::FETCH_ASSOC);
                if($p_sql->rowCount() > 0){     
                    $objeto =   new clientes();
                    $objeto->setId($result["cli_id"]);                
                    $objeto->setTipoCadastro($result["cli_tipo_cad"]);                
                    $objeto->setPfNome($result["cli_pf_nome"]);                
                    $objeto->setPfCpf($result["cli_pf_cpf"]);                
                    $objeto->setPfDtNascimento($result["cli_pf_dt_nascimento"]);                
                    $objeto->setPjCnpj($result["cli_pj_cnpj"]);                
                    $objeto->setPjFantasia($result["cli_pj_fantasia"]);                
                    $objeto->setPjRazao($result["cli_pj_razao"]);                
                    $objeto->setPjIe($result["cli_pj_ie"]);                
                    $objeto->setPjIeIsento($result["cli_pj_ie_isento"]);                
                    $objeto->setResponsavel($result["cli_pj_responsavel"]);                
                    $objeto->setTelefone($result["cli_telefone"]);                
                    $objeto->setCelular($result["cli_celular"]);                
                    $objeto->setFacebook($result["cli_facebook"]);                
                    $objeto->setInstagram($result["cli_instagram"]);                
                    $objeto->setEmail($result["cli_email"]);                
                    $objeto->setDtCadastro($result["cli_dt_cadastro"]);                
                    $objeto->setStatus($result["cli_status"]);                
                    $objeto->setAdmin($result["cli_admin"]);                
                    $objeto->setEmpresa($result["emp_id_fk"]);                                                                        
                    return $objeto;                
                }
       }catch(Exception $e){
           die("Erro: ".$e->getMessage());           
       }
    }   
     
    public function listarDados($pdo, $tipo='',$valor=''){
        try{
           
           $sql  =      " SELECT cli_id FROM mod_clientes "; 
      
           switch ($tipo){
               case 'empresa':
                   $sql     .=      " WHERE cli_status<>:excluido AND emp_id_fk=:empresa"; 
                   $p_sql    =      $pdo->prepare($sql);
                   $p_sql->bindValue(":empresa", $valor, PDO::PARAM_STR);
                   break;
           }
                    
           $p_sql->bindValue(":excluido", 'e', PDO::PARAM_STR);
           $p_sql->execute(); 
            $row=0;
            $objeto = Array();
          
                while($result = $p_sql->fetch(PDO::FETCH_ASSOC)){   
                    $objeto[$row]  = $this->retornaDados($pdo, 'id', $result["cli_id"]);
                    $row++;
                }
               return $objeto;
            
        } catch (Exception $e) {
            die("Erro: ".$e->getMessage()); 
        }
    }
    

    public function verificaDados($pdo, $tipo = '', $valor = '') {
        try {
            $sql = " SELECT cli_id FROM mod_clientes ";
            $sql .= " WHERE ";

            switch ($tipo) {
                case 'cpf':
                    $sql .= " cli_status=:ativo AND cli_pf_cpf=:cpf ";
                    $p_sql = $pdo->prepare($sql);
                    $p_sql->bindValue(":cpf", $valor, PDO::PARAM_STR);
                    break;
                case 'cnpj':
                    $sql .= " cli_status=:ativo AND cli_pj_cnpj=:cnpj ";
                    $p_sql = $pdo->prepare($sql);
                    $p_sql->bindValue(":cnpj", $valor, PDO::PARAM_STR);
                    break;
            }

            $p_sql->bindValue(":ativo", 'a', PDO::PARAM_STR);
            $p_sql->execute();
            $resultado = false;
            while ($result = $p_sql->fetch(PDO::FETCH_ASSOC)) {
                $resultado = $result['cli_id'];
            }
            return $resultado;
        } catch (Exception $e) {
            die("Erro: " . $e->getMessage());
        }
    }   
    
    public function Deletar($pdo, $valor=''){
        try{
           
           $sql  =      " UPDATE mod_clientes SET cli_status=:status"; 
           $sql .=      " WHERE cli_id=:id "; 

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
