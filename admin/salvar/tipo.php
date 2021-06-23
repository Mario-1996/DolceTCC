<?php
  //verificar se não está logado
  if ( !isset ( $_SESSION["dolce"]["id"] ) ){
    exit;
  }

  //verificar se existem dados no POST
  if ( $_POST ) {

  	//recuperar os dados do formulario
  	$id = $tipo = $status = "";

  	foreach ($_POST as $key => $value) {
  		//guardar as variaveis
  		$$key = trim ( $value );
  		//$id
  	}

  	//validar os campos - em branco
  	if ( empty ( $tipo ) ) {
  		echo '<script>alert("Preencha o tipo");history.back();</script>';
  		exit;
	  }
	  if ( empty ( $status ) ) {
		echo '<script>alert("Preencha o status");history.back();</script>';
		exit;
	}


  	//verificar se existe um cadastro com este tipo
  	$sql = "SELECT id FROM tipo 
  		WHERE tipo = ? AND id <> ? LIMIT 1";
  	//usar o pdo / prepare para executar o sql
  	$consulta = $pdo->prepare($sql);
  	//passando o parametro
	$consulta->bindParam(1, $tipo);
  	$consulta->bindParam(2, $id);
  	//executar o sql
  	$consulta->execute();
  	//puxar os dados (id)
  	$dados = $consulta->fetch(PDO::FETCH_OBJ);

  	//verificar se esta vazio, se tem algo é pq existe um registro com o mesmo nome
  	if ( !empty ( $dados->id ) ) {
  		echo '<script>alert("Já existe um tipo de Produto com este nome registrado");history.back();</script>';
  		exit;
  	}

  	//se o id estiver em branco - insert
  	//se o id estiver preenchido - update
  	if ( empty ( $id ) ) {
  		//inserir os dados no banco
		  $sql = "INSERT INTO tipo
		  (tipo, status ) VALUES
		  (:tipo, :status)";
		  $senha = password_hash($senha, PASSWORD_BCRYPT);
			$consulta = $pdo->prepare($sql);
			$consulta->bindParam(":tipo", $tipo);
			$consulta->bindParam(":status", $status);


  	} else {
  		//atualizar os dados  	
  		$sql = "update tipo set tipo = ?, status = ? where id = ? limit 1";	
  		$consulta = $pdo->prepare($sql);
		$consulta->bindParam(1, $tipo);
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
            location.href='listar/tipo';
        }, 1000);
     </script>";		
  	} else {
  		echo '<script>alert("Erro ao salvar");</script>';
  		exit;
  	}

  } else {
  	echo '<script>alert("Erro ao realizar requisição");history.back();</script>';
  }