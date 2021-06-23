<?php
if (!isset($_SESSION["dolce"]["id"])) {
  exit;
}
include "config/conexao.php";
?>

<div class="container" id="formulario">
    <div class="card">
      <div class="card-header">
          <h3 class="float-left">Gerar Pedido</h3>
      </div>
    <div class="card-body">
  <div class="form-row">

    <div class="form-group col-md-4">
      <label for="cliente_id"><b>Cliente</b></label>
      <select class="form-control" name="cliente_id" id="cliente_id" required data-parsley-required-message="Selecione uma Cliente">
        <option value="">Selecione um Cliente</option>
        <?php
        $sql = "SELECT * FROM cliente WHERE status = 'A' ";
        $dados_cliente = $pdo->prepare($sql);
        $dados_cliente->execute();
        while ($dados = $dados_cliente->fetch(PDO::FETCH_OBJ)) {
          $cliente_id = $dados->id;
          $nome = $dados->nome;
          echo "<option value='$cliente_id'> $nome </option> ";
        }
        ?>
      </select>
    </div>

    <div class="form-group col-md-4">
      <label for="produto_id"><b>Produto</b></label>
      <select class="form-control" name="produto_id" id="produto_id" required onchange="buscaValor(this.value)">
        <option value="">Selecione</option>
        <?php
        $sql = "SELECT * FROM produto WHERE status = 'A' ";
        $dados_produto = $pdo->prepare($sql);
        $dados_produto->execute();
        while ($dados = $dados_produto->fetch(PDO::FETCH_OBJ)) {
          $produto_id     = $dados->id;
          $titulo = $dados->titulo;
          echo "<option value='$produto_id'> $titulo </option> ";
        }
        ?>
      </select>
    </div>


    <script>
      // buscar valor do produto
      function buscaValor(produto_id) {

        // ajax que busca o valor do produto no banco
        $.ajax({
          url: 'config/funcoes.php?acao=buscaValor&produto_id=' + produto_id,
          async: true,
          success: function(result) {
            document.getElementById('valor').value = result; // joga o valor do produto no campo valor
          },
          error: function(result) {
            console.log(result); // se der erro vai mostrar no CONSOLE do f12
          }

        })

      }
    </script>
    
    <div class="form-group col-md-2">
      <label for="valor"><b>Valor</b></label>
      <input type="hidden" class="form-control" id="idtipousuario" value="<? echo $_SESSION['dolce']['id'];?>">
      <input type="number" class="form-control" id="valor">
    </div>



    <div class="form-group col-md-2">
      <label for="qtd"><b>Quantidade</b></label>
      <input type="number" class="form-control" id="qtd">
    </div>
  </div>
  </div>

  <script>
    $(document).ready(function() {
      $('#conteudoCarrinho').load('config/sessionCarrinho.php');
    });

    function addCarrinho() {
      // grava nas variaveis os dados (produto | valor | quantidade) 
      var produto_id = parseInt($('#produto_id').val());
      var valor = parseFloat($('#valor').val());
      var qtd = parseInt($('#qtd').val());

      if (produto_id > 0 && valor > 0 && qtd > 0) {
        $.ajax({
          url: 'config/sessionCarrinho.php?acao=add&produto_id=' + produto_id + "&valor=" + valor + "&qtd=" + qtd,
          async: true,
          success: function(result) {
            $('#conteudoCarrinho').load('config/sessionCarrinho.php');
            $('#produto_id').val("");
            $('#valor').val("");
            $('#qtd').val("");
          },
          error: function(result) {
            console.log(result); // se der erro vai mostrar no CONSOLE do f12
          }

        });
      } else {
        swal('Erro','selecione todos os campos','error');
      }

    }

    function remover(produto_id) {
      $.ajax({
        url: 'config/sessionCarrinho.php?acao=remover&produto_id=' + produto_id,
        async: true,
        success: function(result) {
          $('#conteudoCarrinho').load('config/sessionCarrinho.php');
        },
        error: function(result) {
          console.log(result); // se der erro vai mostrar no CONSOLE do f12
        }

      });
    }

    function removerTudo() {
      var x;
      var r = confirm("Tem certeza que deseja apagar carrinho?");
      if (r == true) {
        $.ajax({
          url: 'config/sessionCarrinho.php?acao=removerTudo',
          async: true,
          success: function(result) {
            $('#conteudoCarrinho').load('config/sessionCarrinho.php');
          },
          error: function(result) {
            console.log(result); // se der erro vai mostrar no CONSOLE do f12
          }

        });
      }
    }
  </script>
  </div>

  <div class="row">
    <div class="col-sm-12 col-md-12 col-xl-12">
      <button class="btn btn-outline-danger text-right" type="button" onclick="removerTudo()">
        <i class="fa fa-trash"></i>
        Limpar
      </button>
      <button type="button" class="btn btn-outline-success text-left" onclick="addCarrinho()">
        <i class="fa fa-shopping-cart"></i>
        Adicionar
      </button>
    </div>
  </div>

  <br>

  <div id="pedido">
    <table class="table-bordered col-md-12 text-center" id="dados">
      <thead>
        <tr>
          <td><b>ID do Produto</b></th>
          <td><b>Produto</b></th>
          <td><b>Preço Unitário</b></th>
          <td><b>Quantidade</b></th>
          <td><b>SubTotal</b></th>
          <td><b>Opções</b></th>
        </tr>
      </thead>

      <tbody id="conteudoCarrinho">
      </tbody>

    </table>
  </div><br>

  <a href="paginas/home" class="btn btn-outline-danger"><i class="fa fa-chevron-left"></i> Voltar</a>

  <button type="button" class="btn btn-outline-success" onclick="gravarPedido()">
    <i class="fa fa-check"></i>
    Salvar
  </button>
  <a href="listar/pedido" class="btn btn-outline-primary" id="bot"><i class="fa fa-search"></i> Exibir Pedidos</a>
  <br><br>

  </div>
<script>
  function gravarPedido() {

    var cliente_id = document.getElementById('cliente_id').value;
    var total_liquido = document.getElementById('total').value;
    var total_bruto = document.getElementById('total').value;


    $.ajax({
      url:"salvar/pedido.php?cliente_id=" + cliente_id + "&liquido=" + total_liquido + "&bruto=" + total_bruto,
      async: true,
      success: function(result) {
        swal('Sucesso','O pedido foi salvo com sucesso.','success');
        $.ajax({
          url: 'config/sessionCarrinho.php?acao=removerTudo',
          async: true,
          success: function(result) {
            $('#conteudoCarrinho').load('config/sessionCarrinho.php');
          },
          error: function(result) {
            console.log(result); // se der erro vai mostrar no CONSOLE do f12
          }

        });
        
      },
      error: function(result) {
        swal('Erro','Selecione os Campos','error');
      }
    });

  }
</script>