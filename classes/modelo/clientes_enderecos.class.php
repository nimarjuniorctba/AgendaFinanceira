<?php

class Clientes_enderecos{
    
    private $id;
    private $cep;
    private $rua;
    private $numero;
    private $complemento;
    private $bairro;
    private $cidade;
    private $estado;
    private $dtCadastro;
    private $status;
    private $cliente;
    
    
    
    public function getId() {
        return $this->id;
    }

    public function getCep() {
        return $this->cep;
    }

    public function getRua() {
        return $this->rua;
    }

    public function getNumero() {
        return $this->numero;
    }

    public function getComplemento() {
        return $this->complemento;
    }

    public function getBairro() {
        return $this->bairro;
    }

    public function getCidade() {
        return $this->cidade;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function getDtCadastro() {
        return $this->dtCadastro;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getCliente() {
        return $this->cliente;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setCep($cep): void {
        $this->cep = $cep;
    }

    public function setRua($rua): void {
        $this->rua = $rua;
    }

    public function setNumero($numero): void {
        $this->numero = $numero;
    }

    public function setComplemento($complemento): void {
        $this->complemento = $complemento;
    }

    public function setBairro($bairro): void {
        $this->bairro = $bairro;
    }

    public function setCidade($cidade): void {
        $this->cidade = $cidade;
    }

    public function setEstado($estado): void {
        $this->estado = $estado;
    }

    public function setDtCadastro($dtCadastro): void {
        $this->dtCadastro = $dtCadastro;
    }

    public function setStatus($status): void {
        $this->status = $status;
    }

    public function setCliente($cliente): void {
        $this->cliente = $cliente;
    }

   
 
}