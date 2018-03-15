<?php
    class bd{
        // Propriedades do BD. Não trabalha com criptografia
        private $hostBD = 'localhost';
        private $usuarioBD = 'root';
        private $senhaBD = '123456';
        private $nomeBD = 'editora';

        // Função para configurar parametros de conexao com o Banco de Dados, padrão UTF8
        public function connect(){
            $mysql_atributos = "mysql:host=$this->hostBD;dbname=$this->nomeBD; charset=utf8";
            
            //Configura parametros para conexão com o banco de dados (Orientação a objetos com PHP)
            $conexaoBD = new PDO($mysql_atributos, $this->usuarioBD, $this->senhaBD,
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
        
            //Reportar erro, caso houver
            $conexaoBD->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conexaoBD;
        }
    }