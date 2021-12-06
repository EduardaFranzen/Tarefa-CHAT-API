<?php

class Conexao{
	public static function getConexao(){
		/*String com informações do banco de dados*/
		$str_database="mysql:host=localhost;dbname=chat;port=3307";
		/*Usuário utilizado para conectar no banco de dados*/
		$user="root";
		/*Senha para conexão no banco de dados*/
		$pass="";
		try{
			/*Conexão com o banco de dados*/
			$pdo = new PDO($str_database, $user, $pass);
			return $pdo;
		}catch(PDOException $ex){
			/*Exibe a mensagem de erro retornada na tentativa de conexao*/
			echo "ERRO:".$ex->getMessage();
			return false;
		}
	}
}