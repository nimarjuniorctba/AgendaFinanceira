<?php

class Clientes{
    
    private $id;
    private $tipoCadastro;
    private $pfNome;
    private $pfCpf;
    private $pfDtNascimento;
    private $pjCnpj;
    private $pjFantasia;
    private $pjRazao;
    private $pjIe;
    private $pjIeIsento;
    private $responsavel;
    private $telefone;
    private $celular;
    private $facebook;
    private $instagram;
    private $email;
    private $dtCadastro;
    private $status;
    private $admin;
    private $empresa;
    
    public function getId() {
        return $this->id;
    }

    public function getTipoCadastro() {
        return $this->tipoCadastro;
    }

    public function getPfNome() {
        return $this->pfNome;
    }

    public function getPfCpf() {
        return $this->pfCpf;
    }

    public function getPfDtNascimento() {
        return $this->pfDtNascimento;
    }

    public function getPjCnpj() {
        return $this->pjCnpj;
    }

    public function getPjFantasia() {
        return $this->pjFantasia;
    }

    public function getPjRazao() {
        return $this->pjRazao;
    }

    public function getPjIe() {
        return $this->pjIe;
    }

    public function getPjIeIsento() {
        return $this->pjIeIsento;
    }

    public function getResponsavel() {
        return $this->responsavel;
    }

    public function getTelefone() {
        return $this->telefone;
    }

    public function getCelular() {
        return $this->celular;
    }

    public function getFacebook() {
        return $this->facebook;
    }

    public function getInstagram() {
        return $this->instagram;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getDtCadastro() {
        return $this->dtCadastro;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getAdmin() {
        return $this->admin;
    }

    public function getEmpresa() {
        return $this->empresa;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setTipoCadastro($tipoCadastro): void {
        $this->tipoCadastro = $tipoCadastro;
    }

    public function setPfNome($pfNome): void {
        $this->pfNome = $pfNome;
    }

    public function setPfCpf($pfCpf): void {
        $this->pfCpf = $pfCpf;
    }

    public function setPfDtNascimento($pfDtNascimento): void {
        $this->pfDtNascimento = $pfDtNascimento;
    }

    public function setPjCnpj($pjCnpj): void {
        $this->pjCnpj = $pjCnpj;
    }

    public function setPjFantasia($pjFantasia): void {
        $this->pjFantasia = $pjFantasia;
    }

    public function setPjRazao($pjRazao): void {
        $this->pjRazao = $pjRazao;
    }

    public function setPjIe($pjIe): void {
        $this->pjIe = $pjIe;
    }

    public function setPjIeIsento($pjIeIsento): void {
        $this->pjIeIsento = $pjIeIsento;
    }

    public function setResponsavel($responsavel): void {
        $this->responsavel = $responsavel;
    }

    public function setTelefone($telefone): void {
        $this->telefone = $telefone;
    }

    public function setCelular($celular): void {
        $this->celular = $celular;
    }

    public function setFacebook($facebook): void {
        $this->facebook = $facebook;
    }

    public function setInstagram($instagram): void {
        $this->instagram = $instagram;
    }

    public function setEmail($email): void {
        $this->email = $email;
    }

    public function setDtCadastro($dtCadastro): void {
        $this->dtCadastro = $dtCadastro;
    }

    public function setStatus($status): void {
        $this->status = $status;
    }

    public function setAdmin($admin): void {
        $this->admin = $admin;
    }

    public function setEmpresa($empresa): void {
        $this->empresa = $empresa;
    }


   
}