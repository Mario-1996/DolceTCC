<?php
  //verificar se não está logado
  if ( !isset ( $_SESSION["dolce"]["id"] ) ){
    exit;
  }

  if ( $_POST ) {

  	$login = $senha = $senhanova = $senhaatual = "";
    $id = $_SESSION["dolce"]["id"];
  	foreach ($_POST as $key => $value) {
  		$$key = trim ( $value );
  	}

    $sql = "SELECT * from usuario 
      where id = $id limit 1";

      $consulta = $pdo->prepare($sql);
      $consulta->bindParam(1, $login);
      $consulta->bindParam(2, $senha);
      $consulta->bindParam(3, $id);
  
      $consulta->execute();
     
      $dados = $consulta->fetch(PDO::FETCH_OBJ);
      $login = $dados->login;
      $senha = $dados->senha;

      if (!password_verify($senhaatual, $senha ) ) {
        echo '<script> swal("Erro","Senha atual está incorreta!","error",,{
        button : false ,
        });setTimeout(() => { 
          history.back();
    }, 1000);</script>';
     } 
     else { 
      $sql = "update usuario set senha = ? where id = ? limit 1"; 
      $senhanova = password_hash($senhanova, PASSWORD_BCRYPT);
     $consulta = $pdo->prepare($sql);
     $consulta->bindParam(1, $senhanova);
     $consulta->bindParam(2, $id);

    }
    if (  $consulta->execute() ) {
  		echo '<script> swal("Sucesso","Senha atualizada com Sucesso !","success",{
        button : false ,
        });setTimeout(() => { 
          location.href="paginas/home";
    }, 1000);</script>';
  	} else {
              echo '<script> swal("Erro","Senha não pode ser atualizada!","error",,{
        button : false ,
        });setTimeout(() => { 
          history.back();
    }, 1000);</script>';
  		exit;
  	}

  } else {
  	echo '<script>alert("Erro ao realizar requisição");history.back();</script>';
  }