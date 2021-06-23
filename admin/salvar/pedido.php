<?php

include '../config/conexao.php';
session_start();

if ((int) $_GET['cliente_id'] > 0) {
	$cliente_id = $_GET['cliente_id'];
} 

$liquido = $_GET['liquido'];
$bruto = $_GET['liquido'];
if (empty($liquido) || empty($bruto)) {
	header("HTTP/1.0 404 Not Found");
}
$usuario_id = (int) $_SESSION['dolce']['id'];

//echo "Cliente: $cliente_id , Usuario: $usuario_id , Valor: $liquido ";

$sql = "insert into pedido 
					(pedido_id,cliente_id,usuario_id,pagamento_id,data_hora,datahora_baixa,status,total_liquido,total_bruto)
					values (null,$cliente_id,$usuario_id,NULL, current_timestamp ,NULL,'F','$liquido','$bruto')";

$grava = $pdo->prepare($sql);


if ($grava->execute()) {

	// buscar o ultimo pedido
	$sql_ultid = "SELECT max(pedido_id) as pedido_id FROM pedido";

	$consulta_id = $pdo->prepare($sql_ultid);
	$consulta_id->execute();
	$pedido_id = $consulta_id->fetchAll();
	$pedido_id = $pedido_id[0]['pedido_id'];

	foreach ($_SESSION['carrinho'] as $c) {
		$produto_id = (int) $c['produto_id'];
		$qtde = (int) $c['qtd'];

		$sqlValor = "SELECT valor FROM produto WHERE id = $produto_id limit 1";
		$val = $pdo->prepare($sqlValor);
		$valor =  $val->execute();
		$valor = $val->fetchAll();

		$valorUnitario = $valor[0]['valor'];
		$valorTotal = $c['qtd'] * $valor[0]['valor'];

		$sqlProduto = " insert into produto_pedido (item_id,produto_id,pedido_id,qtde,valor_unitario,valor_total) 
						values (null,$produto_id,$pedido_id,$qtde,'$valorUnitario','$valorTotal') ";
		
		$gravaProduto = $pdo->prepare($sqlProduto);

		if ($gravaProduto->execute()) {
			$_SESSION['carrinho'] = array();
			echo "Gravou!!";

		} else {
			echo 'Deu Ruim.';
		}
	}
	

}




