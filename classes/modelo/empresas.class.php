<?php

class Empresas{
    
    private $id;
    private $tipoCadastro;
    private $pfNome;
    private $pfCpf;
    private $pfDtNascimento;
    private $pjCnpj;
    private $pjFantansia;
    private $pjRazao;
    private $pjIe;
    private $pjIeIsento;
    private $pjResponsavel;
    private $cep;
    private $rua;
    private $numero;
    private $complemento;
    private $bairro;
    private $cidade;
    private $estado;
    private $telefone;
    private $celular;
    private $facebook;
    private $instagram;
    private $email;
    private $validadeSistema;
    private $dtCadastro;
    private $status;
    private $admin;



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

    public function getPjFantansia() {
        return $this->pjFantansia;
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

    public function getPjResponsavel() {
        return $this->pjResponsavel;
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

    public function getValidadeSistema() {
        return $this->validadeSistema;
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

    public function setPjFantansia($pjFantansia): void {
        $this->pjFantansia = $pjFantansia;
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

    public function setPjResponsavel($pjResponsavel): void {
        $this->pjResponsavel = $pjResponsavel;
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

    public function setValidadeSistema($validadeSistema): void {
        $this->validadeSistema = $validadeSistema;
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

    
}