<?php

if (!isset($_SESSION['dolce']['id'])) {
    exit;
}
$pedido_id = intval(explode("/",$_GET["parametro"])[2]);


$sqlProduto = "DELETE FROM produto_pedido WHERE pedido_id = ? LIMIT 1";

$consulta = $pdo->prepare($sqlProduto);

$consulta->bindParam(1, $pedido_id);

// Verificar se não executou
if (!$consulta->execute()) {
    echo "<script>alert('Erro ao excluir');history.back();</script>";
    exit;
}

// Verificar se o id está vazio
if (empty($pedido_id)) {
    echo "<script>alert('Não foi possível excluir o registro!');</script>";
    exit;
}

// Excluir Pedido
$sql = "DELETE FROM pedido WHERE pedido_id = ? LIMIT 1";

$consulta = $pdo->prepare($sql);

$consulta->bindParam(1, $pedido_id);

// Verificar se não executou
if (!$consulta->execute()) {
    echo "<script>alert('Erro ao excluir');history.back();</script>";
    exit;
}

echo "<script>
		swal('Sucesso!','Registro Excluído com sucesso!','success',{
            button : false ,
            });		
		setTimeout(() => { 
			location.href='listar/pedido';
		}, 1000);
     </script>";
            