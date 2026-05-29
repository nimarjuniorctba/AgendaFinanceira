<?php

class administradores{
    
    private $id;
    private $nome;
    private $email;
    private $senha;
    private $status;
    private $dtCadastro;
    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getDtCadastro() {
        return $this->dtCadastro;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setNome($nome): void {
        $this->nome = $nome;
    }

    public function setEmail($email): void {
        $this->email = $email;
    }

    public function setSenha($senha): void {
        $this->senha = $senha;
    }

    public function setStatus($status): void {
        $this->status = $status;
    }

    public function setDtCadastro($dtCadastro): void {
        $this->dtCadastro = $dtCadastro;
    }


 
    
}