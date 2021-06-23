<?php
//arquivo para criar uma conexão com o banco de dados mysql

$servidor = "localhost";

//usuario de acesso ao banco
$usuario = "root";
//senha de acesso ao banco
$senha = "";

//nome do banco de dados
$banco = "dolce";

try {
	//criar uma conexao com banco de dados em PDO
	$pdo = new PDO(
		"mysql:host=$servidor;
			dbname=$banco;
			charset=utf8",
		$usuario,
		$senha
	);
} catch (PDOException $erro) {

	//mensagem de erro
	$msg = $erro->getMessage();

	echo "<p>Erro ao conectar no banco de dados: $msg </p>";
	exit;
}

$acao = (isset($_GET['acao'])) ? $_GET['acao'] : '';
$parametro = (isset($_GET['parametro'])) ? $_GET['parametro'] : '';
