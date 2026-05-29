<?php

class MySQL_PDO
{
    protected static $db;
    
    private function __construct()
    {

        $db_host = "localhost";
        $db_nome = "agenda";
        $db_usuario = "root";
        $db_senha = "";
        $db_driver = "mysql";
        define("CHAVE_AES_BANCO", "nimar");
/*
        $db_host    = "localhost";
        $db_nome    = "quadafac_portaldenoticias";
        $db_usuario = "quadafac_sistema";
        $db_senha   = "+bomdia123";
        $db_driver  = "mysql";
        define("CHAVE_AES_BANCO", "+Bomdia123");*/

        try
        {

            self::$db = new PDO("$db_driver:dbname=$db_nome;host=$db_host", $db_usuario, $db_senha);
            # Garante que o PDO lance exceções durante erros.
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            # Garante que os dados sejam armazenados com codificação UFT-8.
            self::$db->exec('SET NAMES utf8');
            # Define o horario de Sao Paulo como padrão
            date_default_timezone_set('America/Sao_Paulo');
            
        }
        catch (PDOException $e)
        {
            die("Connection Error: " . $e->getMessage());
        }
    }
    public static function conexao()
    {
        # Garante uma única instância. Se não existe uma conexão, criamos uma nova.
        if (!self::$db)
        {
            new MySQL_PDO();
        }
        return self::$db;
    }

}