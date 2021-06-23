<?php
//verificar se não está logado
if (!isset($_SESSION["dolce"]["id"])) {
    exit;
}

include "functions.php";

// iniciando as variaveis
if (!isset($id)) $id = "";
$nome = $cpf = $datanascimento = $email = $cep = $endereco = $complemento = $bairro = 
$cidade = $uf = $telefone = $celular = $numero = "";

if (!empty($id)) {
    $sql = "SELECT *, date_format(datanascimento, '%d/%m/%Y') datanascimento
        FROM cliente 
        WHERE id = :id
        LIMIT 1";

    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(":id", $id);
    $consulta->execute();
    $dados = $consulta->fetch(PDO::FETCH_OBJ);
    if( empty($dados) || is_null($dados)) { 
        echo"<script>swal('Atenção','Não existe esse Cliente','warning',{
            button : false ,
            });setTimeout(() => { 
            history.back();
        }, 1000);</script>";
        exit; 
         
    }
    $nome           = $dados->nome;
    $cpf            = $dados->cpf;
    $datanascimento = $dados->datanascimento;
    $email          = $dados->email;
    $telefone       = $dados->telefone;
    $celular        = $dados->celular;
    $cep            = $dados->cep;
    $cidade         = $dados->cidade;
    $uf             = $dados->uf;
    $numero         = $dados->numero;
    $endereco       = $dados->endereco;
    $bairro         = $dados->bairro;
    $complemento    = $dados->complemento;
    $id             = $dados->id;

}
?>

<div class="container">
<div class="card">
    <div class="card-header">
          <h3 class="float-left">Cadastro de Cliente</h3>
          <div class="float-right">
            <a href="cadastro/cliente" class="btn btn-success">Novo Cliente</a>
            <a href="listar/cliente" class="btn btn-secondary">Listar Cliente</a>
          </div>  
		</div>
	<div class="card-body">
    
    <div class="clearfix"></div>

    <form name="formCadastro" method="post" action="salvar/cliente" data-parsley-validate enctype="multipart/form-data">
        <div class="row">
            <div class="col-12 col-md-2">
                <label for="id">ID:</label>
                <input type="text" name="id" id="id" class="form-control" readonly value="<?= $id; ?>">
            </div>

             <div class="form-group col-md-2">
            <label for="status">Status</label>
            <select id="status" name="status" class="form-control " required data-parsley-required-message= "Selecione uma opção" 
                    value="<?=$status;?>">
                <option value="">Selecione</option> 
                <option value="A">Ativo</option>
                <option value="I">Inativo</option>
            </select>
        </div>
            <div class="col-12 col-md-4">
                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome" class="form-control" required data-parsley-required-message="Preencha o nome" 
                value="<?= $nome; ?>" placeholder="Digite o Nome Completo">
            </div>

            <div class="col-12 col-md-2">
                <label for="cpf">CPF</label>
                <input type="text" name="cpf" id="cpf" onblur="verificarCpf(this.value)" class="form-control" required data-parsley-required-message="Preencha o cpf"
                 value="<?= $cpf; ?>" placeholder="Digite o CPF" >
            </div>
            <div class="col-12 col-md-2">
                <label for="datanascimento">Data de Nascimento</label>
                <input type="text" value="<?= $datanascimento; ?>" name="datanascimento" id="datanascimento" class="form-control" 
                required data-parsley-required-message="Preencha o datanascimento"  >
            </div>

            <div class="col-12 col-md-4">
                <label for="telefone">Telefone</label>
                <input type="text" name="telefone" id="telefone" class="form-control"
                 placeholder="Telefone com DDD" value="<?= $telefone ?>">
            </div>
              
            <div class="col-12 col-md-4">
                <label for="celular">Celular</label>
                <input type="text" name="celular" id="celular" class="form-control" 
                placeholder="Celular com DDD" value="<?= $celular ?>" required data-parsley-required-message="Preencha o celular">
            </div>

            <div class="col-12 col-md-4">
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" class="form-control" 
                required data-parsley-required-message="Digite um email válido" value="<?= $email ?>" placeholder="Digite seu E-mail">
            </div>
            </div><hr>

            <div class="row">

            <div class="col-12 col-md-3">
                <label for="cep">CEP</label>
                <input type="text" name="cep" id="cep" class="form-control" required 
                data-parsley-required-message="Preencha o CEP" value="<?= $cep; ?>"placeholder="Digite o CEP">
            </div>

            <div class="col-12 col-md-3">
                <label for="cidade">Nome da Cidade</label>
                <input type="text" name="cidade" id="cidade" class="form-control" value="<?= $cidade ?>"placeholder="Digite sua Cidade">
            </div>

            <div class="col-12 col-md-1">
                <label for="uf">Estado</label>
                <input type="text" name="uf" id="uf" class="form-control" value="<?= $uf ?>"placeholder="UF">
            </div>

            <div class="col-12 col-md-3">
                <label for="endereco">Endereço</label>
                <input type="text" name="endereco" id="endereco" class="form-control" value="<?= $endereco ?>"placeholder="Digite o Endereço">
            </div>

            <div class="col-12 col-md-2">
                <label for="endereco">Número</label>
                <input type="text" name="numero" id="numero" class="form-control" value="<?= $numero ?>"placeholder="Digite o Número">
            </div>

            <div class="col-12 col-md-3">
                <label for="bairro">Bairro</label>
                <input type="text" name="bairro" id="bairro" class="form-control" value="<?= $bairro ?>"placeholder="Digite o seu Bairro">
            </div>

            <div class="col-12 col-md-3">
                <label for="complemento">Complemento</label>
                <input type="text" name="complemento" id="complemento" class="form-control" value="<?= $complemento ?>"placeholder="Complemento">
            </div>
        </div><hr>
        </div>
    </div>
        <a href="paginas/home" class="btn btn-outline-danger margin"><i class="fa fa-chevron-left"></i> Voltar</a>

        <button type="submit" class="btn btn-outline-success margin">
            <i class="fas fa-check"></i> Salvar
        </button>
    </form>
</div>

<?php
if (empty($id)) $id = 0
?>

<script>
    $(document).ready(function() {
        $('#datanascimento').inputmask("99/99/9999")
        $('#cpf').inputmask("999.999.999-99")
        $('#telefone').inputmask("(99) 9999-9999")
        $('#celular').inputmask("(99) 9 9999-9999")
        $('#numero').inputmask("9999")
    })


    function verificarCpf(cpf) {
        // Função Ajax para verificar o CPF
        $.get("verificarCpf.php", {
                cpf: cpf,
                id: <?= $id ?>
            },
            function(dados) {
                if (dados != '') {
                    // Mostrar o erro retornado
                    alert(dados)

                    // Zerar o CPF
                    $('#cpf').val('')
                }

            }
        )
    }

   

    $('#cep').blur(function() {
        // Pegar o CEP
        let cep = $('#cep').val()

        // Remover espaços e qualquer caractere que não seja dígito
        cep = cep.replace(/\D/g, '')

        // Verificar se está em branco
        if (cep == '') {
            alert('Preencha o CEP')
        } else {
            // Consultar o WEB SERVICE viacep.com.br
            $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function(dados) {
                // Desestruturar objeto
                const {
                    localidade,
                    uf,
                    logradouro,
                    bairro
                } = dados

                $('#cidade').val(localidade)
                $('#uf').val(uf)
                $('#endereco').val(logradouro)
                $('#bairro').val(bairro)
            })
        }
    })

</script>
