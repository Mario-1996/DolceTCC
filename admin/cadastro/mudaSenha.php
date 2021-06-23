<?php
  //verificar se não está logado
  if ( !isset ( $_SESSION["dolce"]["id"] ) ){
    exit;
  }

?>

<div class="container">
<div class="card">
    <div class="card-header">
          <h3 class="float-left">Atualizar / Mudar Senha </h3>
		</div>
	<div class="card-body">
	<div class="clearfix"></div>
	
	<form name="formSenha" method="post" action="salvar/mudaSenha" data-parsley-validate>
    <div class="row">
    <div class="col-12 col-md-1">
    <label for="login">ID</label>
		  <input type="text" name="id" id="id" class="form-control" readonly value="<?=$_SESSION["dolce"]["id"];?>">
    </div>
   
      <div class="col-12 col-md-4">
        <label for="senhaatual">Senha Atual</label>
        <input type="password" name="senhaatual" id="senhaatual" class="form-control" required data-parsley-required-message="Preencha a senhaatual" value="<?=$senha;?>">
      </div>
    
    
      <div class="col-6 col-md-3">
        <label for="senhanova">Nova Senha</label>
        <input type="password" name="senhanova" id="senhanova" class="form-control" required data-parsley-required-message="Preencha a nova senha">
      </div>
      <div class="col-6 col-md-3">
        <label for="senhanova2">Confirme a Senha</label>
        <input type="password" id="senhanova2" onblur="verificarSenha()" class="form-control" required data-parsley-required-message="Confirme a senha">
      </div>
    </div>
    </div>
</div>
    <button type="submit" class="btn btn-success margin">
		  <i class="fas fa-check"></i> Salvar
		</button>
   
	</form>
    </div>

<script type="text/javascript">
  function verificarSenha() {
        if ($('#senhanova').val() != $('#senhanova2').val()) {
            $('#senhanova').val('')
            $('#senhanova2').val('')
            $('#senhanova2').removeClass('is-valid')
            $('#senhanova2').addClass('is-invalid')
            return swal('Erro','As senhas devem ser iguais.','error')
        }

        $('#senhanova2').removeClass('is-invalid')
        $('#senhanova2').addClass('is-valid')
    }

</script>