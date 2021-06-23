<?php

if (!isset($_SESSION['dolce']['id'])) {
    exit;
}

// Verificar se o id está vazio
if (empty($id)) {
    echo "<script>alert('Não foi possível excluir o registro!');history.back();</script>";
    exit;
}

// Excluir cliente
$sql = "DELETE FROM cliente WHERE id = ? LIMIT 1";

$consulta = $pdo->prepare($sql);

$consulta->bindParam(1, $id);

// Verificar se não executou
if (!$consulta->execute()) {
    echo "<script>alert('Erro ao excluir');history.back();</script>";
    exit;
}

/*echo "<script>alert('Cliente deletado com sucesso!');history.back();</script>";*/
echo "<script>
		swal('Sucesso!','Registro Excluído com sucesso!','success',{
            button : false ,
            });		
		setTimeout(() => { 
			location.href='listar/cliente';
		}, 1000);
     </script>";
            