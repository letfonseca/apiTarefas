<?php
  //Primeira coisa a se fazer
  //Chamar a conexao com o banco de dados

  require_once('conexao.php');

    $dados_para_insercao = array(
        'nome'      => 'neymar não',
        'data_nasc' => '05/02/2001',
        'senha'     => 'abc123',
        'email'     => 'neymar@gmail.com',
        'cpf'       =>  '000111222-33'
    );
   
    //SQL que será usado para inserir no banco (INSERT)
   $sql = "INSERT INTO conta ( nome, data_nasc, senha, email, cpf) VALUES (
    :nome, :data_nasc, :senha, :email, :cpf)";
    $stmt = $pdo ->prepare($sql);
    $stmt->bindParam(':nome', $dados_para_insercao['nome']);
    $stmt->bindParam(':data_nasc', $dados_para_insercao['data_nasc']);
    $stmt->bindParam(':senha', $dados_para_insercao['senha']);
    $stmt->bindParam(':email', $dados_para_insercao['email']);
    $stmt->bindParam(':cpf', $dados_para_insercao['cpf']);
    

    $stmt->execute();

    echo('foi inserido ' . $stmt->rowCount() .
   ' registro no banco de dados');
   echo'<br>';
   echo('Último Id inserido no banco: ' . $pdo->lastInsertId());




    //id nome data_nasc senha email cpf


?>