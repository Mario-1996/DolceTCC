<?php
 
  //--> Verificar se o id esta vazio
  if ( empty ( $id ) ) {
  	echo "<script>alert('Não foi possível inativar o registro');history.back();</script>";
  	exit;
  }

  $sqlStatus = "select status from produto where id = $id";
  $consulta = $pdo->prepare($sqlStatus);
  $consulta->execute();
  $dados = $consulta->fetch(PDO::FETCH_OBJ);
 
  echo $dados->status;
  if($dados->status == 'A') {

  $sql = "update produto set status = 'I' where id = ? limit 1";
  $consulta = $pdo->prepare($sql);
  $consulta->bindParam(1, $id);
  } else if($dados->status == 'I') {

  $sql = "update produto set status = 'A' where id = ? limit 1";
  $consulta = $pdo->prepare($sql);
  $consulta->bindParam(1, $id);
  }
  
  //--> Verificar se não executou
  if ( !$consulta->execute() ) {

    //--> Capturar os erros e mostra a mensagem na tela
    echo $consulta->errorInfo()[2];

    echo "<script>alert('Erro ao mudar status');javascript:history.back();</script>";
    exit;
  }

  echo "<script>location.href='listar/produto';</script>";
