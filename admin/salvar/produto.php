<?php
//verificar se não está logado
if (!isset($_SESSION["dolce"]["id"])) {
    exit;
}

if ($_POST) {
    include "functions.php";
    include "config/conexao.php";

    // iniciando as variaveis para evitar erros
    $id = $titulo = $data = $quantidade = $foto = $valor = $descricao = $tipo_id = $modelo_id = "";

    foreach ($_POST as $key => $value) {
        $$key = trim($value);
    }

    //ver se ter erros
    //print_r ($_FILES); //print_r($_POST);

    if ((empty($titulo)) || (empty($data)) || (empty($quantidade)) || (empty($valor)) || (empty($descricao))) {
        echo "<script>alert('Não deixe nenhuma informação em Branco');</script>";
        exit;
    } else if ((empty($tipo_id))|| (empty($modelo_id))){
        echo "<script>alert('Selecione o Tipo e Modelo de Produto');history.back();</script>";
        exit;
    }

    // iniciar uma transação
    $pdo->beginTransaction();

    $data = formatar($data);
    $valor = formatarValor($valor);

    $arquivo = time() . "-" . $_SESSION["dolce"]["id"];

    if (empty($id)) {
        // inserir
        $sql = "INSERT INTO produto (titulo, quantidade, data, foto, descricao, valor, tipo_id, modelo_id) 
                VALUES (:titulo, :quantidade, :data, :foto, :descricao, :valor, :tipo_id, :modelo_id)";

        $consulta = $pdo->prepare($sql);

        $consulta->bindParam(":titulo", $titulo);
        $consulta->bindParam(":quantidade", $quantidade);
        $consulta->bindParam(":data", $data);
        $consulta->bindParam(":foto", $arquivo);
        $consulta->bindParam(":descricao", $descricao);
        $consulta->bindParam(":valor", $valor);
        $consulta->bindParam(":tipo_id", $tipo_id);
        $consulta->bindParam(":modelo_id", $modelo_id);
    } else {
         //update
                if ( !empty ( $_FILES["foto"]["name"] ) ) 
                $foto = $arquivo;

             $sql = "update produto set titulo = :titulo, quantidade = :quantidade, valor = :valor,
             descricao = :descricao, foto = :foto, tipo_id = :tipo_id, modelo_id = :modelo_id, data = :data 
             where id = :id limit 1";
             
             $consulta = $pdo->prepare($sql);
             $consulta->bindParam(":titulo",$titulo);
             $consulta->bindParam(":quantidade",$quantidade);
             $consulta->bindParam(":valor",$valor);
             $consulta->bindParam(":descricao",$descricao);
             $consulta->bindParam(":foto",$foto);
             $consulta->bindParam(":tipo_id",$tipo_id);
             $consulta->bindParam(":modelo_id",$modelo_id);
             $consulta->bindParam(":data",$data);
             $consulta->bindParam(":id",$id);

        }


    

    // executar o sql
    if ($consulta->execute()) {

        //verificar se o arquivo não esta sendo enviado
        if ( ( empty ( $_FILES["foto"]["type"] ) ) && ( !empty ( $id ) ) ) {
            //gravar no banco
            $pdo->commit();
            echo "<script>alert('Registro salvo');location.href='listar/produto';</script>";
            exit;
        }

        // verificar se tipo da imagem é jpg
        if ($_FILES["foto"]["type"] != "image/jpeg") {
            echo "<script>alert('Selecione uma imagem no formato JPG');history.back();</script>";
            exit;
        }

        // copiar a imagem para o servidor
        // file, destination
        if (move_uploaded_file($_FILES["foto"]["tmp_name"], "fotos/" . $_FILES["foto"]["name"])) {

            // redimensionar imagens
            $pastaFotos = "fotos/";
            $imagem = $_FILES["foto"]["name"];
            $nome = $arquivo;

            redimensionarImagem($pastaFotos, $imagem, $nome);

            // gravar no banco - se tudo deu certo
            $pdo->commit();

            echo"<script>
            swal('Sucesso!','Registro salvo com sucesso!','success',{
                button : false ,
                });
    
            setTimeout(() => { 
                location.href='listar/produto';
            }, 1000);
         </script>";		
            exit;
        }

        // erro ao gravar
        echo "<script>alert('Erro ao salvar !!');history.back();</script>";
        exit;
    }

    exit;
}

echo "<p class='alert alert-danger'>Requisição inválida</p>";
