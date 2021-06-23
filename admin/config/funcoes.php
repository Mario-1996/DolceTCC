<?php

include 'conexao.php';

// finaliza pedido
if (isset($_GET['acao']) && $_GET['acao'] == 'finalizaPedido') {

    $pedido_id = $_GET['pedido_id'];
    $pagamento_id = $_GET['pagamento_id'];

    $sql_pedido = "SELECT total_liquido, usuario_id FROM pedido WHERE pedido_id = $pedido_id LIMIT 1";
    $consulta_pedido = $pdo->prepare($sql_pedido);
    $consulta_pedido->execute();
    $pedido = $consulta_pedido->fetchAll();
    $liquido = $pedido[0]['total_liquido'];
    $usuario_id = $pedido[0]['usuario_id'];

    $sql = "UPDATE pedido 
            SET datahora_baixa = CURRENT_TIMESTAMP,
                status = 'B',
                pagamento_id = $pagamento_id
            WHERE pedido_id = $pedido_id";

    $grava = $pdo->prepare($sql);

    $sql_caixa = "SELECT idcaixa FROM caixa WHERE idcaixa in (select max(idcaixa) from caixa) and datahora_fechamento is null";
    $consulta = $pdo->prepare($sql_caixa);
    $consulta->execute();
    $dados_caixa = $consulta->fetchAll();
    $idcaixa = $dados_caixa[0]['idcaixa'];

    $sql_caixa = "insert into movimento_caixa
                        (idmovimento,idcaixa,valor,usuario_id,tipo_movimento,idoperacao)
                        values (null,$idcaixa,'$liquido',$usuario_id,1,1)";

    $grava_caixa = $pdo->prepare($sql_caixa);

    $sql_valor = "SELECT idcaixa, saldo_atual FROM caixa WHERE idcaixa in (select max(idcaixa) from caixa) and datahora_fechamento is null";
    $consulta = $pdo->prepare($sql_valor);
    $consulta->execute();
    $dados_valor = $consulta->fetchAll();
    $idcaixa = $dados_valor[0]['idcaixa'];
    $total = $dados_valor[0]['saldo_atual'];
    $atual = $total + $liquido;

    $sql_valor = "UPDATE caixa 
    set saldo_atual = $atual
    WHERE idcaixa = $idcaixa ";

    $grava_valor = $pdo->prepare($sql_valor);

    
    if ($grava->execute() && $grava_caixa->execute() &&  $grava_valor->execute()) {
        echo 1;
    } else {
        echo 0;
    }
}

// buscar o valor do produto
if (isset($_GET['acao']) && $_GET['acao'] == 'buscaValor') {

    $produto_id = $_GET['produto_id'];

    $sql = "SELECT valor FROM produto WHERE id = $produto_id LIMIT 1 ";

    $dados = $pdo->prepare($sql);
    $dados->execute();

    $val = $dados->fetchAll();

    echo $val[0]['valor'];
}