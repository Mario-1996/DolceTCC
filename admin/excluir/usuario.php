<?php

if (!isset($_SESSION['dolce']['id'])) {
    exit;
}

$sql = "DELETE FROM usuario WHERE id = ? LIMIT 1";

$consulta = $pdo->prepare($sql);

$consulta->bindParam(1, $id);

// Verificar se não executou
if (!$consulta->execute()) {

    echo "<script>alert('Erro ao excluir');history.back();</script>";
    exit;
}

echo "<script>
		swal('Sucesso!','Registro Excluído com sucesso!','success',{
            button: false,
            });		
		setTimeout(() => { 
			location.href='listar/usuario';
		}, 1000);
     </script>";