<?php

if (!isset($_SESSION['dolce']['id'])) {
    exit;
}

if ($_POST) {
    include "functions.php";
    include "config/conexao.php";
    

    // Inicializar as variáveis
    $id = $nome = $cpf = $satus = $datanascimento = $email = $endereco = $complemento = $cidade = $numero = $uf = $telefone = $celular = $bairro = $cep = '';

    foreach ($_POST as $key => $value) {
        $$key = trim($value);
    }

    // Verificar informações pessoias
    if ((empty($nome)) || (empty($cpf)) || (empty($status)) ||(empty($email)) || (empty($datanascimento)) || (empty($celular))) {
        echo "<script>alert('Não deixe informações do Cliente em branco');history.back();</script>";
        exit;
    }

    // Verificar informações de endereço
    if ((empty($cep)) || (empty($cidade)) || (empty($uf)) ||(empty($bairro)) || (empty($endereco)) || (empty($numero)) || (empty($complemento))) {
        echo "<script>alert('Não deixe informações de endereço em branco');history.back();</script>";
        exit;
    } 


    // Iniciar uma transação
    $pdo->beginTransaction();

    $datanascimento = formatar($datanascimento);


    // Concatenar a hora atual com o nome do cliente e com o id do usuário
    $arquivo = time() . "-" . $_SESSION["dolce"]["id"];


    if (empty($id)) {
        // Inserir um novo cliente
        $sql = "INSERT INTO cliente
                    (nome, cpf, status, datanascimento, email, cep, endereco, complemento, bairro, cidade, uf, numero, telefone, celular) VALUES
                    (:nome, :cpf, :status, :datanascimento, :email, :cep, :endereco, :complemento, :bairro, :cidade, :uf, :numero, :telefone, :celular)";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":nome", $nome);
        $consulta->bindParam(":cpf", $cpf);
        $consulta->bindParam(":status", $status);
        $consulta->bindParam(":datanascimento", $datanascimento);
        $consulta->bindParam(":email", $email);
        $consulta->bindParam(":cep", $cep);
        $consulta->bindParam(":endereco", $endereco);
        $consulta->bindParam(":complemento", $complemento);
        $consulta->bindParam(":bairro", $bairro);
        $consulta->bindParam(":cidade", $cidade);
        $consulta->bindParam(":uf", $uf);
        $consulta->bindParam(":numero", $numero);
        $consulta->bindParam(":telefone", $telefone);
        $consulta->bindParam(":celular", $celular);
    } else {
        //atualizar a tabela cliente
        $sql = "UPDATE cliente SET 
                    nome           = :nome,
                    cpf            = :cpf,
                    status         = :status,
                    datanascimento = :datanascimento,
                    email          = :email,
                    cep            = :cep,
                    endereco       = :endereco,
                    complemento    = :complemento,
                    bairro         = :bairro,
                    cidade         = :cidade,
                    uf             = :uf,
                    numero         = :numero,
                    telefone       = :telefone,
                    celular        = :celular
                WHERE
                    id = :id LIMIT 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":nome", $nome);
        $consulta->bindParam(":cpf", $cpf);
        $consulta->bindParam(":status", $status);
        $consulta->bindParam(":datanascimento", $datanascimento);
        $consulta->bindParam(":email", $email);
        $consulta->bindParam(":cep", $cep);
        $consulta->bindParam(":endereco", $endereco);
        $consulta->bindParam(":complemento", $complemento);
        $consulta->bindParam(":bairro", $bairro);
        $consulta->bindParam(":uf", $uf);
        $consulta->bindParam(":cidade", $cidade);
        $consulta->bindParam(":numero", $numero);
        $consulta->bindParam(":telefone", $telefone);
        $consulta->bindParam(":celular", $celular);
        $consulta->bindParam(":id", $id);
    }

}
    if ($consulta->execute()) {
        $pdo->commit();
        echo"<script>
        swal('Sucesso!','Registro salvo com sucesso!','success',{
            button : false ,
            });

        setTimeout(() => { 
            location.href='listar/cliente';
        }, 1000);
     </script>";		
        exit;
      
    }

    echo "<script>alert('Erro ao salvar');history.back();</script>";
    exit;

    print_r($_POST);
    exit;


echo "<p class='alert alert-danger'>Requisição inválida</p>";
