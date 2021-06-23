<?php
 
  //--> Verificar se o id esta vazio
  if ( empty ( $id ) ) {
  	echo "<script>alert('Não foi possível inativar o registro');history.back();</script>";
  	exit;
  }

  $sqlStatus = "select status from usuario where id = $id";
  $consulta = $pdo->prepare($sqlStatus);
  $consulta->execute();
  $dados = $consulta->fetch(PDO::FETCH_OBJ);
  //Se a mesa estiver inativa == 2 ela ativa.
  echo $dados->status;
  if($dados->status == 'A') {
  //--> SQL Ativação da mesa
  $sql = "update usuario set status = 'I' where id = ? limit 1";
  $consulta = $pdo->prepare($sql);
  $consulta->bindParam(1, $id);
  } else if($dados->status == 'I') {
  //--> SQL Inativação da mesa
  $sql = "update usuario set status = 'A' where id = ? limit 1";
  $consulta = $pdo->prepare($sql);
  $consulta->bindParam(1, $id);
  }


  // //--> SQL de Exlusão da mesa
  // $sql = "update mesa set situacao = 2 where id = ? limit 1";
  // $consulta = $pdo->prepare($sql);
  // $consulta->bindParam(1, $id);
  
  //--> Verificar se não executou
  if ( !$consulta->execute() ) {

    //--> Capturar os erros e mostra a mensagem na tela
    echo $consulta->errorInfo()[2];

    echo "<script>alert('Erro ao mudar status');javascript:history.back();</script>";
    exit;
  }

  //--> Redirecionar para o cadastro e listagem das Mesas
  echo "<script>location.href='listar/usuario';</script>";
