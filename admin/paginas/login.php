<?php
  //verificar se não está logado
  if ( !isset ( $pagina ) ){
    exit;
  }

  //echo password_hash('123456', PASSWORD_BCRYPT);

  //verificar se foi dado um POST
  if ( $_POST ) {
    //iniciar as variaveis
    $login = $senha = "";
    //recuperar o login e a senha digitados
    if ( isset ( $_POST["login"] ) )
      $login = trim ( $_POST["login"] );
    
    if ( isset ( $_POST["senha"] ) )
      $senha = trim ( $_POST["senha"] );

    //verificar se os campos estao em branco
    if ( empty ( $login ) )
      echo "<script>swal('Erro','Preencha o campo Login!','error');</script>";
    else if ( empty ( $senha ) ) 
      echo "<script>swal('Erro','Preencha o campo Senha!','error');</script>";
    else {
      //verificar se o login existe
      $sql = "SELECT * from usuario where login = ? limit 1";
      //apontar a conexao com o banco
      //preparar o sql para execução
      $consulta = $pdo->prepare($sql);
      //passar o parametro para o sql
      $consulta->bindParam(1, $login);
      //executar o sql
      $consulta->execute();
      //puxar os dados do resultado
      $dados = $consulta->fetch(PDO::FETCH_OBJ);

      //verificar se existe usuario
      if ( empty ( $dados->id ) ) 
        echo "<script>swal('Erro','Usuário ou Senha estão incorretos!','error');</script>";
      //verificar se a senha esta correta
    
      else if ( !password_verify($senha, $dados->senha) )
        echo "<script>swal('Erro','Usuário ou Senha estão incorretos!','error');</script>";

        //verificar se o Usuario esta ativo ou Inativo
        else if ($dados->status != "A") 
        echo "<script>swal('Erro','Este Usuário não está Ativo','error');</script>";
      //se deu tudo certo
      
      else {
        //registrar este usuário na sessao
        $_SESSION["dolce"] = 
          array("id"  => $dados->id,
                "idtipousuario" => $dados->idtipousuario,
                "nome"=> $dados->nome
               );
        //redirecionar para o home
        //javascript para redirecionar
        echo "<script>
        swal('Sucesso!','Login Efetuado com Sucesso!','success',{
          button : false ,
          });

        setTimeout(() => { 
            location.href='paginas/home';
        }, 1000);
        </script>";		
      
        exit;

      }


    }
  }
?>
<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="images/img-01.png" alt="IMG">
				</div>

				<form class="login100-form validate-form user" name="login" method="post" data-parsley-validate>
					<span class="login100-form-title">
          <img src="images/logoNome.png" width="auto" height="55"alt=""><br><br>
						<h5>Login de Usuário</h5>
					</span>
         
					<div class="wrap-input100 validate-input">
						<input class="input100" id="login" type="text" name="login" placeholder="Digite o seu login" >
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input">
						<input class="input100 "  id="senha" type="password" name="senha" placeholder=" Digite sua senha">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>

					<div class="container-login100-form-btn">
						<button type="submit" class="login100-form-btn">
							Login
						</button>
					</div>
		
					<div class="text-center p-t-100">
          <a class="txt2" href="#">
							Esqueceu sua Senha ?
						</a>
					<hr>
					</div>
				</form>
			</div>
		</div>
	</div>
