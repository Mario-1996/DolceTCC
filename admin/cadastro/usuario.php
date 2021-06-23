<?php
//verificar se não está logado
if (!isset($_SESSION["dolce"]["id"])) {
    exit;
}
if ($_SESSION["dolce"]["idtipousuario"] == 2) {
	echo "<script>swal('Atenção','Acesso Negado','warning',{
		button : false ,
		});setTimeout(() => { 
		history.back();
	}, 1000);</script>";
	exit; 
}

// iniciando as variaveis da tabela
if (!isset($id)) $id = "";
$nome = $login = $email = $senha = $status = $idtipousuario = $celular = "";

if (!empty($id)) {
    $sql = "SELECT * FROM usuario 
    WHERE id = ? LIMIT 1";

    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(1, $id); 
    $consulta->execute();
    $dados = $consulta->fetch(PDO::FETCH_OBJ);
    if( empty($dados) || is_null($dados)) { 
        echo"<script>swal('Atenção','Não existe esse Usuário','warning',{
            button : false ,
            });setTimeout(() => { 
            history.back();
        }, 1000);</script>";
        exit; 
         
    }
    $nome           = $dados->nome;
    $login          = $dados->login;
    $status         = $dados->status;
    $email          = $dados->email;
    $senha          = $dados->senha;
    $celular        = $dados->celular;
    $idtipousuario  = $dados->idtipousuario;
    
}
?>

<div class="container">
<div class="card">
    <div class="card-header">
          <h3 class="float-left">Cadastro de Usuário</h3>
          <div class="float-right">
            <a href="cadastro/usuario" class="btn btn-success">Novo Usuário</a>
            <a href="listar/usuario" class="btn btn-secondary">Listar Usuários</a>
          </div>
		</div>
	<div class="card-body">
    
    <div class="clearfix"></div>

    <form name="formCadastro" method="post" action="salvar/usuario" data-parsley-validate enctype="multipart/form-data">
        <div class="row">

            <div class="col-12 col-md-2">
                <label for="id">ID:</label>
                <input type="text" name="id" id="id" class="form-control" readonly value="<?= $id; ?>">
            </div>

            <div class="col-12 col-md-6">
                <label for="nome">Nome:</label>
                <input type="text" name="nome" id="nome" class="form-control" 
                required data-parsley-required-message="Preencha o nome" value="<?= $nome; ?>" placeholder="Digite o seu nome completo">
            </div>

            <div class='form-group col-12 col-md-4'>
                <label for='login'>Login:</label>
                <input type='text' name='login' id='login' class='form-control' id='validalogin'
                required data-parsley-required-message="Preencha o Login"
                placeholder='Digite o Login' maxlenght='15' value="<?= $login; ?>"  onblur="verificaLogin(this.value)" 
                <?php if (!empty($login)) ;?>>
            </div>  

            <div class='col-12 col-md-4'>
                <label for='senha'>Senha:</label>
                <input type='password' name='senha' id='senha' class='form-control' id='validalogin' 
                required data-parsley-required-message="Preencha a senha"  maxlenght='15' value="<?=$login;?>"
                onblur="verificaLogin(this.value)" <?php if (!empty($login)) echo 'disabled';?>>
            </div>
            

            <div class='col-10 col-md-4'>
                <label for='senha2'>Redigite a Senha:</label>
                <input type="password" id="senha2" onblur="verificarSenha()" class="form-control"  value="<?=$login;?>"
                <?php if (!empty($login)) echo 'disabled';?>>
               
            </div>

            <div class="col-6 col-md-4">
                <label for="email">E-mail:</label>
                <input type="email" name="email" id="email" class="form-control" required data-parsley-required-message="Digite um email válido" value="<?= $email ?>" placeholder="Digite o e-mail">
            </div>

            <div class="col-12 col-md-4">
                <label for="celular">Celular:</label>
                <input type="text" name="celular" id="celular" class="form-control" 
                placeholder="Celular com DDD" value="<?= $celular ?>" required data-parsley-required-message="Preencha o celular">
            </div>  
        
            <div class="col-10 col-md-4">
            <label for="idtipousuario">Tipo de Usuário </label>
		        <select name="idtipousuario" id="idtipousuario" class="form-control"
		        required data-parsley-required-message="Selecione uma opção" value="<?= $idtipousuario; ?>">
			<option value=""><b>Selecione</b></option>
            <?php
                $consulta = $pdo->prepare("SELECT idtipousuario,nome FROM tipo_usuario ORDER BY nome");
                $consulta->execute();
                while ($a = $consulta->fetch(PDO::FETCH_OBJ)) {

                    echo "<option value='$a->idtipousuario'>$a->nome</option>";
                }
            ?>
            </select>
            </div>

            <div class="form-group col-md-4">
            <label for="status">Status</label>
            <select id="status" name="status" class="form-control" required data-parsley-required-message="Selecione uma opção"
                    value="<?=$status;?>">
                <option value="">Selecione</option>
                <option value="Ativo">Ativo</option>
                <option value="Inativo ">Inativo</option>
            </select>
            </div>

        </div>
        </div>
</div>

        <a href="paginas/home" class="btn btn-outline-danger margin"><i class="fa fa-chevron-left"></i> Voltar</a>

        <button type="submit" class="btn btn-outline-success margin">
            <i class="fas fa-check"></i> Salvar
        </button>
    </form>
</div>


<script>
 $(document).ready(function() {
        $('#celular').inputmask("(99) 9 9999-9999")
    })

    function verificarSenha() {
        if ($('#senha').val() != $('#senha2').val()) {
            $('#senha').val('')
            $('#senha2').val('')
            $('#senha2').removeClass('is-valid')
            $('#senha2').addClass('is-invalid')
            return swal('Erro','As senhas não são iguais','error')
        }

        $('#senha2').removeClass('is-invalid')
        $('#senha2').addClass('is-valid')
    }
</script>
