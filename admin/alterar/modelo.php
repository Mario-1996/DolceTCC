<?php
 
  //--> Verificar se o id esta vazio
  if ( empty ( $id ) ) {
  	echo "<script>alert('Não foi possível inativar o registro');history.back();</script>";
  	exit;
  }

  $sqlStatus = "select status from modelo where id = $id";
  $consulta = $pdo->prepare($sqlStatus);
  $consulta->execute();
  $dados = $consulta->fetch(PDO::FETCH_OBJ);

  echo $dados->status;
  if($dados->status == 'A') {

  $sql = "update modelo set status = 'I' where id = ? limit 1";
  $consulta = $pdo->prepare($sql);
  $consulta->bindParam(1, $id);
  } else if($dados->status == 'I') {

  $sql = "update modelo set status = 'A' where id = ? limit 1";
  $consulta = $pdo->prepare($sql);
  $consulta->bindParam(1, $id);
  }

  if ( !$consulta->execute() ) {

    echo $consulta->errorInfo()[2];

    echo "<script>alert('Erro ao mudar status');javascript:history.back();</script>";
    exit;
  }

  echo "<script>location.href='listar/modelo';</script>";
