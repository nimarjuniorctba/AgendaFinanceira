<?php

class acesso_empresas extends empresas {

    public function cadastraDados($pdo, empresas $objeto) {
        try {
//            var_dump($objeto);exit;            
            if($objeto->getTipoCadastro()=='f'){
                $verifica = $this->verificaDados($pdo, 'cpf', $objeto->getPfCpf());
            }else{
                $verifica = $this->verificaDados($pdo, 'cnpj', $objeto->getPjCnpj());
            }            
            if ($verifica == false) {
                $sql = " INSERT INTO mod_empresas(
                                                        emp_pf_cpf  
                                        ,               emp_tipo_cad                                                                        
                                        ,               emp_pf_nome
                                        ,               emp_pf_dt_nascimento
                                        ,               emp_pj_cnpj 
                                        ,               emp_pj_fantasia 
                                        ,               emp_pj_razao    
                                        ,               emp_pj_ie       
                                        ,               emp_pj_ie_isento
                                        ,               emp_pj_responsavel   
                                        ,               emp_end_cep        
                                        ,               emp_end_rua        
                                        ,               emp_end_numero     
                                        ,               emp_end_complemento
                                        ,               emp_end_bairro     
                                        ,               emp_end_cidade     
                                        ,               emp_end_estado     
                                        ,               emp_telefone       
                                        ,               emp_celular        
                                        ,               emp_facebook       
                                        ,               emp_instagram      
                                        ,               emp_email          
                                        ) VALUES(                                                                                                
                                                        :pf_cpf
                                        ,               :tipo_cadastro                                                        
                                        ,               :pf_nome 
                                        ,               :pf_dt_nascimento
                                        ,               :pj_cnpj
                                        ,               :pj_fantasia
                                        ,               :pj_razao
                                        ,               :pj_ie 
                                        ,               :pj_ie_isento
                                        ,               :pj_responsavel
                                        ,               :cep
                                        ,               :rua
                                        ,               :numero
                                        ,               :complemento
                                        ,               :bairro
                                        ,               :cidade
                                        ,               :estado
                                        ,               :telefone
                                        ,               :celular
                                        ,               :facebook
                                        ,               :instagram 
                                        ,               :email             
                                        )";
                $p_sql = $pdo->prepare($sql);
                $p_sql->bindValue(":pf_cpf", $objeto->getPfCpf(), PDO::PARAM_STR);  
                $p_sql->bindValue(":tipo_cadastro", $objeto->getTipoCadastro(), PDO::PARAM_STR);                 
                $p_sql->bindValue(":pf_nome", $objeto->getPfNome(), PDO::PARAM_STR);            
                $p_sql->bindValue(":pf_dt_nascimento", $objeto->getPfDtNascimento(), PDO::PARAM_STR);                      
                $p_sql->bindValue(":pj_cnpj", $objeto->getPjCnpj(), PDO::PARAM_STR);            
                $p_sql->bindValue(":pj_fantasia", $objeto->getPjFantansia(), PDO::PARAM_STR);            
                $p_sql->bindValue(":pj_razao", $objeto->getPjRazao(), PDO::PARAM_STR);            
                $p_sql->bindValue(":pj_ie", $objeto->getPjIe(), PDO::PARAM_STR);            
                $p_sql->bindValue(":pj_ie_isento", $objeto->getPjIeIsento(), PDO::PARAM_STR);            
                $p_sql->bindValue(":pj_responsavel", $objeto->getPjResponsavel(), PDO::PARAM_STR);            
                $p_sql->bindValue(":cep", $objeto->getCep(), PDO::PARAM_STR);            
                $p_sql->bindValue(":rua", $objeto->getRua(), PDO::PARAM_STR);            
                $p_sql->bindValue(":numero", $objeto->getNumero(), PDO::PARAM_STR);            
                $p_sql->bindValue(":complemento", $objeto->getComplemento(), PDO::PARAM_STR);            
                $p_sql->bindValue(":bairro", $objeto->getBairro(), PDO::PARAM_STR);            
                $p_sql->bindValue(":cidade", $objeto->getCidade(), PDO::PARAM_STR);            
                $p_sql->bindValue(":estado", $objeto->getEstado(), PDO::PARAM_STR);            
                $p_sql->bindValue(":telefone", $objeto->getTelefone(), PDO::PARAM_STR);            
                $p_sql->bindValue(":celular", $objeto->getCelular(), PDO::PARAM_STR);            
                $p_sql->bindValue(":facebook", $objeto->getFacebook(), PDO::PARAM_STR);            
                $p_sql->bindValue(":instagram", $objeto->getInstagram(), PDO::PARAM_STR);            
                $p_sql->bindValue(":email", $objeto->getEmail(), PDO::PARAM_STR);            
                $p_sql->execute();
                if ($p_sql->rowCount() > 0) {
                    return $pdo->lastInsertId();
                } else {
                    return false;
                }
            }else {
                return false;
            }
        } catch (Exception $e) {
            die("Erro: " . $e->getMessage());
        }
    }

    public function atualizaDados($pdo, empresas $objeto) {
        try {
            $sql = " UPDATE mod_empresas SET
                                                    emp_pf_nome             =   :pf_nome 
                                    ,               emp_pf_dt_nascimento    =   :pf_dt_nascimento
                                    ,               emp_pj_fantasia         =   :pj_fantasia                                    
                                    ,               emp_pj_razao            =   :pj_razao
                                    ,               emp_pj_ie               =   :pj_ie 
                                    ,               emp_pj_ie_isento        =   :pj_ie_isento
                                    ,               emp_pj_responsavel      =   :pj_responsavel
                                    ,               emp_end_cep             =   :cep
                                    ,               emp_end_rua             =   :rua
                                    ,               emp_end_numero          =   :numero
                                    ,               emp_end_complemento     =   :complemento
                                    ,               emp_end_bairro          =   :bairro
                                    ,               emp_end_cidade          =   :cidade
                                    ,               emp_end_estado          =   :estado
                                    ,               emp_telefone            =   :telefone
                                    ,               emp_celular             =   :celular
                                    ,               emp_facebook            =   :facebook
                                    ,               emp_instagram           =   :instagram 
                                    ,               emp_email               =   :email 
                                    ,               emp_validade_sistema    =   :validade_sistema          ";
            if($objeto->getTipoCadastro()!=null){
                    $sql .= "       ,               emp_tipo_cad            =   :tipo_cadastro ";
            }   
            if($objeto->getPfCpf()!=null){
                    $sql .= "       ,               emp_pf_cpf            =   :documento ";
            }   
            if($objeto->getPjCnpj()!=null){
                    $sql .= "       ,               emp_pj_cnpj            =   :documento ";
            }   
                    $sql .= "         WHERE emp_id=:id ";
            $p_sql = $pdo->prepare($sql);
            $p_sql->bindValue(":pf_nome", $objeto->getPfNome(), PDO::PARAM_STR);            
            $p_sql->bindValue(":pf_dt_nascimento", $objeto->getPfDtNascimento(), PDO::PARAM_STR);                      
            $p_sql->bindValue(":pj_fantasia", $objeto->getPjFantansia(), PDO::PARAM_STR);              
            $p_sql->bindValue(":pj_razao", $objeto->getPjRazao(), PDO::PARAM_STR);            
            $p_sql->bindValue(":pj_ie", $objeto->getPjIe(), PDO::PARAM_STR);            
            $p_sql->bindValue(":pj_ie_isento", $objeto->getPjIeIsento(), PDO::PARAM_STR);            
            $p_sql->bindValue(":pj_responsavel", $objeto->getPjResponsavel(), PDO::PARAM_STR);            
            $p_sql->bindValue(":cep", $objeto->getCep(), PDO::PARAM_STR);            
            $p_sql->bindValue(":rua", $objeto->getRua(), PDO::PARAM_STR);            
            $p_sql->bindValue(":numero", $objeto->getNumero(), PDO::PARAM_STR);            
            $p_sql->bindValue(":complemento", $objeto->getComplemento(), PDO::PARAM_STR);            
            $p_sql->bindValue(":bairro", $objeto->getBairro(), PDO::PARAM_STR);            
            $p_sql->bindValue(":cidade", $objeto->getCidade(), PDO::PARAM_STR);            
            $p_sql->bindValue(":estado", $objeto->getEstado(), PDO::PARAM_STR);            
            $p_sql->bindValue(":telefone", $objeto->getTelefone(), PDO::PARAM_STR);            
            $p_sql->bindValue(":celular", $objeto->getCelular(), PDO::PARAM_STR);            
            $p_sql->bindValue(":facebook", $objeto->getFacebook(), PDO::PARAM_STR);            
            $p_sql->bindValue(":instagram", $objeto->getInstagram(), PDO::PARAM_STR);            
            $p_sql->bindValue(":email", $objeto->getEmail(), PDO::PARAM_STR);            
            $p_sql->bindValue(":validade_sistema", $objeto->getValidadeSistema(), PDO::PARAM_STR);            
            $p_sql->bindValue(":id", $objeto->getId(), PDO::PARAM_STR); 
            
            if($objeto->getTipoCadastro()!=null){
                
                $p_sql->bindValue(":tipo_cadastro", $objeto->getTipoCadastro(), PDO::PARAM_STR);                 
            }              
            if($objeto->getPfCpf()!=null){
                $p_sql->bindValue(":documento", $objeto->getPfCpf(), PDO::PARAM_STR); 
            }   
            if($objeto->getPjCnpj()!=null){
                $p_sql->bindValue(":documento", $objeto->getPjCnpj(), PDO::PARAM_STR); 
            }
            
            $p_sql->execute();
            if ($p_sql->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            die("Erro: " . $e->getMessage());
        }
    }

    public function retornaDados($pdo, $tipo = '', $valor = '') {
        try {
                $sql = " SELECT * FROM mod_empresas WHERE ";

                switch ($tipo) {

                    case 'id':
                        $sql .= " emp_id = :id AND emp_status <> :excluido ";
                        $p_sql = $pdo->prepare($sql);
                        $p_sql->bindValue(":id", $valor, PDO::PARAM_INT);
                        $p_sql->bindValue(":excluido", 'e', PDO::PARAM_STR);
                        break;
                }
                $p_sql->execute();
                $result = $p_sql->fetch(PDO::FETCH_ASSOC);
                if ($p_sql->rowCount() > 0) {
                    $objeto = new empresas();
                    $objeto->setId($result["emp_id"]);
                    $objeto->setTipoCadastro($result["emp_tipo_cad"]);
                    $objeto->setPfNome($result["emp_pf_nome"]);
                    $objeto->setPfCpf($result["emp_pf_cpf"]);
                    $objeto->setPfDtNascimento($result["emp_pf_dt_nascimento"]);
                    $objeto->setPjCnpj($result["emp_pj_cnpj"]);
                    $objeto->setPjFantansia($result["emp_pj_fantasia"]);
                    $objeto->setPjRazao($result["emp_pj_razao"]);
                    $objeto->setPjIe($result["emp_pj_ie"]);
                    $objeto->setPjIeIsento($result["emp_pj_ie_isento"]);
                    $objeto->setPjResponsavel($result["emp_pj_responsavel"]);
                    $objeto->setCep($result["emp_end_cep"]);
                    $objeto->setRua($result["emp_end_rua"]);
                    $objeto->setNumero($result["emp_end_numero"]);
                    $objeto->setComplemento($result["emp_end_complemento"]);
                    $objeto->setBairro($result["emp_end_bairro"]);
                    $objeto->setCidade($result["emp_end_cidade"]);
                    $objeto->setEstado($result["emp_end_estado"]);
                    $objeto->setTelefone($result["emp_telefone"]);
                    $objeto->setCelular($result["emp_celular"]);
                    $objeto->setFacebook($result["emp_facebook"]);
                    $objeto->setInstagram($result["emp_instagram"]);
                    $objeto->setEmail($result["emp_email"]);
                    $objeto->setValidadeSistema($result["emp_validade_sistema"]);
                    $objeto->setDtCadastro($result["emp_dt_cadastro"]);
                    $objeto->setStatus($result["emp_status"]);
                    $objeto->setAdmin($result["emp_admin"]);
                    return $objeto;
                }
        } catch (Exception $e) {
            die("Erro: " . $e->getMessage());
        }
    }

    public function listarDados($pdo, $tipo = '') {
        try {

            $sql = " SELECT emp_id FROM mod_empresas ";

            switch ($tipo) {
                case 'todos':
                    $sql .= " WHERE emp_status<>:excluido ORDER BY emp_id DESC";
                    $p_sql = $pdo->prepare($sql);
                    break;
            }

            $p_sql->bindValue(":excluido", 'e', PDO::PARAM_STR);
            $p_sql->execute();
            $row = 0;
            $objeto = Array();

            while ($result = $p_sql->fetch(PDO::FETCH_ASSOC)) {
                $objeto[$row] = $this->retornaDados($pdo, 'id', $result["emp_id"]);
                $row++;
            }
            return $objeto;
        } catch (Exception $e) {
            die("Erro: " . $e->getMessage());
        }
    }

    public function verificaDados($pdo, $tipo = '', $valor = '') {
        try {
//echo $tipo;exit;
            $sql = " SELECT emp_id FROM mod_empresas ";
            $sql .= " WHERE ";

            switch ($tipo) {
                case 'cpf':
                    $sql .= " emp_status=:ativo AND emp_pf_cpf=:cpf ";
                    $p_sql = $pdo->prepare($sql);
                    $p_sql->bindValue(":cpf", $valor, PDO::PARAM_STR);
                    break;
                case 'cnpj':
                    $sql .= " emp_status=:ativo AND emp_pj_cnpj=:cnpj ";
                    $p_sql = $pdo->prepare($sql);
                    $p_sql->bindValue(":cnpj", $valor, PDO::PARAM_STR);
                    break;
            }

            $p_sql->bindValue(":ativo", 'a', PDO::PARAM_STR);
            $p_sql->execute();
            $resultado = false;
            while ($result = $p_sql->fetch(PDO::FETCH_ASSOC)) {
                $resultado = $result['emp_id'];
            }
            return $resultado;
        } catch (Exception $e) {
            die("Erro: " . $e->getMessage());
        }
    }

    public function Deletar($pdo, $valor = '') {
        try {

            $sql = " UPDATE mod_empresa SET emp_status=:status";
            $sql .= " WHERE emp_id=:id ";

            $p_sql = $pdo->prepare($sql);
            $p_sql->bindValue(":status", 'e', PDO::PARAM_STR);
            $p_sql->bindValue(":id", $valor, PDO::PARAM_STR);
            $p_sql->execute();
            if ($p_sql->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            die("Erro: " . $e->getMessage());
        }
    }

}
