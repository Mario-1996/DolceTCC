<?php
  //verificar se não está logado
  if ( !isset ( $_SESSION["dolce"]["id"] ) ){
    exit;
  }

  //verificar se existem dados no POST
  if ( $_POST ) {

  	//recuperar os dados do formulario
  	$id = $modelo = $status = "";

  	foreach ($_POST as $key => $value) {
  		//guardar as variaveis
  		$$key = trim ( $value );
  		//$id
  	}

  	//validar os campos - em branco
  	if ( empty ( $modelo )) {
  		echo '<script>alert( " Preencha o Modelo! " );history.back();</script>';
  		exit;
  	}


  	//verificar se existe um cadastro com este tipo
  	$sql = "SELECT id FROM modelo 
  		WHERE modelo = ? AND id <> ? LIMIT 1";
  	//usar o pdo / prepare para executar o sql
  	$consulta = $pdo->prepare($sql);
  	//passando o parametro
	  $consulta->bindParam(1, $modelo);
  	$consulta->bindParam(2, $id);
  	//executar o sql
  	$consulta->execute();
  	//puxar os dados (id)
  	$dados = $consulta->fetch(PDO::FETCH_OBJ);

  	//verificar se esta vazio, se tem algo é pq existe um registro com o mesmo nome
  	if ( !empty ( $dados->id ) ) {
  		echo '<script>alert("Já existe um Modelo de Produto com este nome registrado");history.back();</script>';
  		exit;
  	}

  	//se o id estiver em branco - insert
  	//se o id estiver preenchido - update
  	if ( empty ( $id ) ) {
  		//inserir os dados no banco
		  $sql = "INSERT INTO modelo
		  (modelo, status ) VALUES
		  (:modelo, :status)";
		  $senha = password_hash($senha, PASSWORD_BCRYPT);
			$consulta = $pdo->prepare($sql);
			$consulta->bindParam(":modelo", $modelo);
			$consulta->bindParam(":status", $status);

  	} else {
  		//atualizar os dados  	
  		$sql = "update modelo set modelo = ? , status = ? where id = ? limit 1";	
  		$consulta = $pdo->prepare($sql);
		  $consulta->bindParam(1, $modelo);
		  $consulta->bindParam(2, $status);
  		$consulta->bindParam(3, $id);
  	}
  	//executar e verificar se deu certo
  	if ( $consulta->execute() ) {
		echo"<script>
        swal('Sucesso!','Registro salvo com sucesso!','success',{
			button : false ,
			});

        setTimeout(() => { 
			location.href='listar/modelo';
        }, 1000);
     </script>";		
  	} else {
  		echo '<script>alert("Erro ao salvar");history.back();</script>';
  		exit;
  	}

  } else {
  	echo '<script>alert("Erro ao realizar requisição");history.back();</script>';
  }