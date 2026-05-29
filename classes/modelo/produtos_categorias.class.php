<?php

class Produtos_Categorias{
    
    private $id;
    private $nome;
    private $descricao;
    private $status;
    private $dtCadastro;
    private $empresa;    
 
    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
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

    public function getEmpresa() {
        return $this->empresa;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setNome($nome): void {
        $this->nome = $nome;
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

    public function setEmpresa($empresa): void {
        $this->empresa = $empresa;
    }


   
}