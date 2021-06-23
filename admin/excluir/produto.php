<?php
  //verificar se não está logado
  if ( !isset ( $_SESSION["dolce"]["id"] ) ){
    exit;
  }

  //verificar se o id esta vazio
  if ( empty ( $id ) ) {
  	echo "<script>alert('Não foi possível excluir o registro');history.back();</script>";
  	exit;
  }

  $sql = "delete from produto where id = ? limit 1";
  $consulta = $pdo->prepare($sql);
  $consulta->bindParam(1, $id);
  //verificar se não executou
  if ( !$consulta->execute() ) {

  	//capturar os erros e mostra a mensagem na tela
  	echo $consulta->errorInfo()[2];

  	echo "<script>alert('Erro ao excluir');history.back();</script>";
  	exit;
  }

  echo "<script>
  swal('Sucesso!','Registro Excluído com sucesso!','success',{
          button : false ,
          });		
  setTimeout(() => { 
    location.href='listar/produto';
  }, 1000);
   </script>";
