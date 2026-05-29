<?php

class Produtos{
    
    private $id;
    private $titulo;
    private $descricao;
    private $codigoBarras;
    private $valorCusto;
    private $valorVenda;    
    private $quantidade;
    private $status; 
    private $dtCadastro;
    private $fornecedor;     
    private $categoria;    
    private $empresa; 
   
    public function getId() {
        return $this->id;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function getCodigoBarras() {
        return $this->codigoBarras;
    }

    public function getValorCusto() {
        return $this->valorCusto;
    }

    public function getValorVenda() {
        return $this->valorVenda;
    }

    public function getQuantidade() {
        return $this->quantidade;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getDtCadastro() {
        return $this->dtCadastro;
    }

    public function getFornecedor() {
        return $this->fornecedor;
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

    public function setTitulo($titulo): void {
        $this->titulo = $titulo;
    }

    public function setDescricao($descricao): void {
        $this->descricao = $descricao;
    }

    public function setCodigoBarras($codigoBarras): void {
        $this->codigoBarras = $codigoBarras;
    }

    public function setValorCusto($valorCusto): void {
        $this->valorCusto = $valorCusto;
    }

    public function setValorVenda($valorVenda): void {
        $this->valorVenda = $valorVenda;
    }

    public function setQuantidade($quantidade): void {
        $this->quantidade = $quantidade;
    }

    public function setStatus($status): void {
        $this->status = $status;
    }

    public function setDtCadastro($dtCadastro): void {
        $this->dtCadastro = $dtCadastro;
    }

    public function setFornecedor($fornecedor): void {
        $this->fornecedor = $fornecedor;
    }

    public function setCategoria($categoria): void {
        $this->categoria = $categoria;
    }

    public function setEmpresa($empresa): void {
        $this->empresa = $empresa;
    }


}