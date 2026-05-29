<?php

class Produtos_Fornecedores{
    
    private $id;
    private $nome;
    private $cnpj;
    private $email;
    private $telefone;
    private $celular;    
    private $descricao;
    private $status; 
    private $dtCadastro;
    private $categoria;    
    private $empresa; 
    
    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getCnpj() {
        return $this->cnpj;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getTelefone() {
        return $this->telefone;
    }

    public function getCelular() {
        return $this->celular;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getDtCadastro() {
        return $this->dtCadastro;
    }

    public function getCategoria() {
        return $this->categoria;
    }

    public function getEmpresa() {
        return $this->empresa;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setNome($nome): void {
        $this->nome = $nome;
    }

    public function setCnpj($cnpj): void {
        $this->cnpj = $cnpj;
    }

    public function setEmail($email): void {
        $this->email = $email;
    }

    public function setTelefone($telefone): void {
        $this->telefone = $telefone;
    }

    public function setCelular($celular): void {
        $this->celular = $celular;
    }

    public function setDescricao($descricao): void {
        $this->descricao = $descricao;
    }

    public function setStatus($status): void {
        $this->status = $status;
    }

    public function setDtCadastro($dtCadastro): void {
        $this->dtCadastro = $dtCadastro;
    }

    public function setCategoria($categoria): void {
        $this->categoria = $categoria;
    }

    public function setEmpresa($empresa): void {
        $this->empresa = $empresa;
    }

    
 
}