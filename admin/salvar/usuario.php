<?php

// Verificar se não está logado
if (!isset($_SESSION['dolce']['id'])) {
    exit;
}

if ($_POST) {
    include "functions.php";
    include "config/conexao.php";

    // Inicializar as variáveis
    $id = $nome = $login = $idtipousuario = $email = $celular = $senha = $status = '';

    foreach ($_POST as $key => $value) {
        $$key = trim($value);
    }

    // Verificar informações pessoias
    if ((empty($nome)) ||  (empty($email)) || (empty($login)) ||(empty($status)) || (empty($celular))) {
        echo "<script>swal('Atenção','Não deixar informações em Branco','warning',{
            button : false ,
            });setTimeout(() => { 
            history.back();
        }, 1000);</script>";
        exit;
    } 
    if ((empty($senha)) and (empty($id))) { 
        echo "<script>swal('Atenção','Não deixar informações em Branco','warning',{
            button : false ,
            });setTimeout(() => { 
            history.back();
        }, 1000);</script>";
        exit;
    } 


    // Iniciar uma transação
    $pdo->beginTransaction();


    // Concatenar a hora atual com o nome do cliente e com o id do usuário
    $arquivo = time() . "-" . $_SESSION["dolce"]["id"];

    if (empty($id)) {
        // Inserir
        $sql = "INSERT INTO usuario
                    (nome, idtipousuario, status, login, email, senha, celular) VALUES
                    (:nome, :idtipousuario, :status, :login, :email, :senha, :celular)";
                    $senha = password_hash($senha, PASSWORD_BCRYPT);
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":nome", $nome);
		$consulta->bindParam(":login", $login);
		$consulta->bindParam(":status", $status);
        $consulta->bindParam(":idtipousuario", $idtipousuario);
        $consulta->bindParam(":email", $email);
        $consulta->bindParam(":senha", $senha);
        $consulta->bindParam(":celular", $celular);
    } else {

        $sql = "UPDATE usuario SET 
                    nome           = :nome,
                    login          = :login,
                    idtipousuario  = :idtipousuario,
                    email          = :email,
                    status         = :status,
                    celular        = :celular
                WHERE
                    id = :id LIMIT 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":nome", $nome);
        $consulta->bindParam(":login", $login);
		$consulta->bindParam(":status", $status);	
        $consulta->bindParam(":idtipousuario", $idtipousuario);
        $consulta->bindParam(":email", $email);
		$consulta->bindParam(":celular", $celular);
        $consulta->bindParam(":id", $id);
    }
	if ($consulta->execute()) {
        $pdo->commit();
        echo"<script>
        swal('Sucesso!','Registro salvo com sucesso!','success',{
            button : false ,
            });

        setTimeout(() => { 
            location.href='listar/usuario';
        }, 1000);
     </script>";		
        exit;
      
    }

    echo "<script>swal('Erro','Não foi Possivel Salvar!','error');</script>";
    exit;

    print_r($_POST);
    //exit; 	
}

echo "<p class='alert alert-danger'>Requisição inválida</p>";