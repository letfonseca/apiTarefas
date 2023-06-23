<?php
require_once('conexao.php');
require_once('funcoes.php');

$sql = "SELECT * FROM conta";
 
$stmt = $pdo->prepare($sql);
$stmt->execute();

//$resultado = $stmt ->fetchAll();

while($resultado = $stmt->fetch()){
    echo 'ID: ' . $resultado['id'] . '<br>';
    echo 'NOME: ' . $resultado['nome'] . '<br>';
    echo 'DATA NASCIMENTO: ' . $resultado['data_nasc'] . '<br>';
    echo 'SENHA: ' . $resultado['senha'] . '<br>';
    echo 'EMAIL: ' . $resultado['email'] . '<br>';
    echo 'CPF: ' . $resultado['cpf'] . '<br> <br> <br>';

    //Buscando um único registro no banco de dados

    echo '<hr>';
    echo '<h1>Listando apenas 1 regsitro</h1>';
  
    $id = 5;
    $sql = "SELECT * FROM conta WHERE id = :id";
    $stmt = $pdo ->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    echo 'ID: ' . $resultado['id'] . '<br>';
    echo 'NOME: ' . $resultado['nome'] . '<br>';
    echo 'DATA NASCIMENTO: ' . $resultado['data_nasc'] . '<br>';
    echo 'SENHA: ' . $resultado['senha'] . '<br>';
    echo 'EMAIL: ' . $resultado['email'] . '<br>';
    echo 'CPF: ' . $resultado['cpf'] . '<br> <br> <br>';
}

?>