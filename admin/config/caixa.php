<?php
include 'conexao.php';

if (isset($_GET['acao']) && $_GET['acao'] == "abrir") {

    $data = $_GET['data'];
    $usuario_id = $_GET['usuario_id'];
    $saldo_inicial = $_GET['saldo_inicial'];

    //echo $saldo_inicial;

    $sql = "INSERT INTO caixa VALUES (null,CURDATE(),$usuario_id,$saldo_inicial,$saldo_inicial,null)";

    $grava = $pdo->prepare($sql);

    if ($grava->execute()) {
        echo "deu certo";
        var_dump($sql);
    } else {
        echo "deu erro";
        var_dump($sql);
    }
}

if (isset($_GET['acao']) && $_GET['acao'] == "fechar") {

    $data = $_GET['data'];
    $usuario_id = $_GET['usuario_id'];

    $sql_caixa = "SELECT * from caixa order by idcaixa desc limit 1";
    $consulta = $pdo->prepare($sql_caixa);
    $consulta->execute();
    $dados_caixa = $consulta->fetchAll();
    $usuario = $dados_caixa[0]['usuario_id'];

    //var_dump($usuario,$usuario_id,intval($usuario) != intval($usuario_id)); exit;

    if (intval($usuario) != intval($usuario_id)) {
        echo 0;
    } else {
        $sql = "UPDATE caixa SET datahora_fechamento = current_timestamp WHERE data = CURDATE()  and usuario_id = $usuario_id  ";

        $grava = $pdo->prepare($sql);
    
        if ($grava->execute()) {
            //var_dump( $grava->fetch(PDO::FETCH_OBJ)); exit ;
            echo 1;
        } else {
            echo 0;
        }
    }
}


if (isset($_GET['acao']) && $_GET['acao'] == "movimento") {

    $tipo = (int)$_POST['tipo'];
    $valor_mov = str_replace(",",".",$_POST['valor']);
    $usuario_id = $_POST['usuario_id'];
    $motivo = $_POST['motivo'];

    $sql = "SELECT idcaixa,saldo_atual from caixa where data = current_date and datahora_fechamento is null ";
    $consulta = $pdo->prepare($sql);
    $consulta->execute();
    $dados = $consulta->fetch(PDO::FETCH_OBJ);
    $idcaixa = $dados->idcaixa;
    $saldo = $dados->saldo_atual;

    if ($tipo == 1) {
        $valor = $saldo += $valor_mov;
        $operacao = 2;
    } else {
        $valor = $saldo - $valor_mov;
        $operacao = 3;
    }

    $sql2 = "UPDATE caixa SET saldo_atual = '$valor' WHERE idcaixa = $idcaixa ";
    $grava = $pdo->prepare($sql2);

    if ($grava->execute()) {
        $sql3 = "INSERT INTO movimento_caixa VALUES (null, $idcaixa, '$valor_mov',current_timestamp, $usuario_id, $tipo, $operacao,'$motivo') ";
        $grava2 = $pdo->prepare($sql3);
        if ($grava2->execute()) {
            echo 1;
        } else {
            echo 0;
        }
    } else {
        echo 0;
    }
}
