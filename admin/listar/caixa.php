<?php
date_default_timezone_set('America/Sao_Paulo');
include 'config/conexao.php';

$sql = "SELECT * from caixa where data = current_date and datahora_fechamento is null ";
$consulta = $pdo->prepare($sql);
$consulta->execute();
$dados = $consulta->fetch(PDO::FETCH_OBJ);

$saldo_inicial = $saldo_atual = "";
if (isset($dados->saldo_inicial)) {
    $saldo_atual = number_format ($dados->saldo_atual,2,",","."); 
    $saldo_inicial = number_format ($dados->saldo_inicial,2,",","."); 
} 

?>
<div class="container">
<div class="row">

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-4 col-lg-6 mb-4">
    <div class="card border-left-success shadow">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div>
                        <h3 class="font-weight-bold"> Caixa</h3>
                    </div>
                     <div class="mt-4 text-center">
                                <label for="data_referencia"> <b> Data </b> </label>
                                <input type="text" value="<?= date('d/m/Y') ?>" class="form-control" id="data_referencia" name="data_referencia" disabled>
                            </div>  
                            <div class="mt-4 text-center">
                                <label for="saldo_inicial"> <b> Saldo inicial R$ </b> </label>
                                <input type="text" class="form-control" placeholder="Digite o saldo inicial" id="saldo_inicial" 
                                value="<?= $saldo_inicial?>" 
                                <?php
                                    if ($saldo_inicial > 0) {
                                        echo "disabled";
                                    } else {
                                        echo "";
                                    };
                                    ?>>
                            </div>
                            <div class="mt-4 text-center">
                                <label for="saldo_atual"> <b> Saldo Atual R$ </b> </label>
                                <input type="text" class="form-control" value="<?=$saldo_atual ?>" disabled>
                            </div>
                            <div class="mt-4 text-center small ">
                                <label> &nbsp; </label>
                                <button class="btn btn-outline-success " type="button" title="Abrir Caixa" onclick="abrir()" 
                                <?php
                                if ($saldo_inicial > 0) {
                                    echo "disabled";
                                } else {
                                    echo "";
                                };
                                ?>>
                                    <i class="fa fa-dollar-sign wi"></i>
                                </button>
                                <button class="btn btn-outline-primary" type="button" data-toggle="modal" title="Movimentação" data-target="#movimento">
                                    <i class="fa fa-plus wi"></i>
                                </button>
                                <button class="btn btn-outline-danger" <?php ($_SESSION["dolce"]["idtipousuario"] == 1) ?> type="button" title="fechar caixa" onclick="fechar()">
                                    <i class="fa fa-times-circle wi"></i>          
                                </button>
                                <br>
                            </div>                   
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-8 col-md-6 mb-4">
    <div class="card border-left-primary shadow">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div>
                    <h3 class="font-weight-bold"> Resumo</h3>
                    </div>
                    <div class="table-responsive">
                <table id="table" class="table table-striped">
                    <thead>
                        <tr style="font-weight:bold">
                            <td> Data/Hora </td>
                            <td> Motivo </td>
                            <td> Tipo </td>
                            <td> Usuário </td>
                            <td> Operação </td>
                            <td> Valor </td>
                            
                        </tr>
                    </thead>
                    <tbody>


                        <?php
                        $sql2 = " 
                                select 
                                    mv.idmovimento
                                    ,op.nome as operacao
                                    ,case 
                                        when tipo_movimento = 1 then 'Entrada'
                                        else 'Saida'
                                    end as tipo
                                    ,case
                                        when tipo_movimento = 1 then mv.valor
                                        else mv.valor*-1
                                    end as valor 
                                    ,u.nome as usuario                                                                                                                                      
                                    ,mv.datahora
                                    ,mv.motivo
                                from movimento_caixa mv
                                inner join caixa cx on cx.idcaixa = mv.idcaixa and cx.datahora_fechamento is null
                                left join usuario u on u.id = mv.usuario_id
                                left join operacao op on op.id = mv.idoperacao
                                where date(mv.datahora) = current_date 
                                order by mv.datahora
                        ";
                        $consulta2 = $pdo->prepare($sql2);
                        $consulta2->execute();

                        while ($d = $consulta2->fetch(PDO::FETCH_OBJ)) {
                            $operacao = $d->operacao;
                            $tipo = $d->tipo;
                            $usu = $d->usuario;
                            $dthr = $d->datahora;
                            $val = $d->valor;
                            $motivo = $d->motivo;

                            if ($val > 0) {
                                $cor = "green";
                            } else {
                                $cor = "red";
                            }

                            echo '<tr>
                                    <td> ' . date('d/m/Y H:i:s', strtotime($dthr)) .  ' </td>    
                                    <td> ' . $motivo .  ' </td>
                                    <td> ' . $tipo .  ' </td>
                                    <td> ' . $usu .  ' </td>
                                    <td> ' . $operacao .  ' </td>
                                    <td  style="font-weight:bold;color:' . $cor . '"> R$ ' . number_format($val, 2, ',', '.') .  ' </td>
                            </tr>';
                        }

                        ?>

                    </tbody>
                </table>
            </div>
                    
                </div>
            </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    <script>

        function abrir() {

            var saldo_inicial = document.getElementById('saldo_inicial').value;
            var usuario_id = <?php echo $_SESSION["dolce"]["id"] ?>;
            var data = document.getElementById('data_referencia').value;
            var dataNova = data.split('/');
            var data = `${dataNova[0]}-${dataNova[1]}-${dataNova[2]}`
        
            if (saldo_inicial > 0) {
                swal({
                        title: "Atenção.",
                        text: "Deseja abrir o caixa com: R$ " + saldo_inicial + " reais ?",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {

                            $.ajax({
                                url: 'config/caixa.php?acao=abrir&usuario_id=' + usuario_id + '&data=' + data + '&saldo_inicial=' + saldo_inicial,
                                async: true,
                                success: function(result) {
                                    swal("Sucesso.", 'Caixa aberto com sucesso!', 'success');
                                    setTimeout(function() {
                                        window.location.href = "listar/caixa";
                                    }, 1000);
                                }
                            });
                        }
                    });
            } else {
                swal('Atenção.', 'Favor digite um valor válido.', 'error');
            }


        }


        function fechar() {

            var usuario_id = <?php echo $_SESSION["dolce"]["id"] ?>;
            var data = document.getElementById('data_referencia').value;

            swal({
                    title: "Atenção.",
                    text: "Deseja fechar o caixa ?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {

                        $.ajax({
                            url: 'config/caixa.php?acao=fechar&usuario_id=' + usuario_id + '&data=' + data,
                            async: true,
                            success: function(result) {
                                console.log(result);

                                if (parseInt(result) == 1) {
                                    swal("Sucesso.", 'Caixa fechado com sucesso!', 'success');
                                    setTimeout(function() {
                                        window.location.href = "listar/caixa";
                                    }, 1000);
                                } else {
                                    swal('Atenção', 'Somente o usuário que abriu poderá fechar o caixa.', 'error');
                                }

                            }
                        });
                    }
                });
        }
    </script>



    <div class="modal fade" id="movimento" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Movimentação Caixa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label> Tipo de movimento </label>
                            <select class="form-control" id="tipo_mov">
                                <option value="1"> Entrada </option>
                                <option value="2"> Saida </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label> Valor </label>
                            <input type="text" class="form-control" id="valor_mov">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label> Motivo </label>
                            <textarea class="form-control" id="motivo" rows="2"></textarea>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-outline-primary" onclick="movimento()">Gravar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function movimento() {
            var tipo = $('#tipo_mov').val();
            var valor = $('#valor_mov').val();
            var usuario_id = <?php echo $_SESSION["dolce"]["id"] ?>;
            var motivo = $('#motivo').val();

            if (valor !== "" && motivo !== "") {
                $.ajax({
                    url: 'config/caixa.php?acao=movimento',
                    async: true,
                    type: 'POST',
                    data: {
                        'tipo': tipo,
                        'valor': valor,
                        'usuario_id': usuario_id,
                        'motivo': motivo
                    },
                    success: function(result) {
                        console.log(result);
                        swal("Sucesso","Movimento realizado com sucesso","success");
                        $('#tipo_mov').val("");
                        $('#valor_mov').val("");
                        var usuario_id = "";
                        $('#motivo').val("");
                        setTimeout(function() {
                            window.location.href = "listar/caixa";
                        },1000);
                    }
                })
            } else {
                alert('Valor inválido');
            }

        }
    </script>
   