<?php
  
  //Tarefas.php



  if($_SERVER['REQUEST_METHOD'] === 'OPTIONS'){
    exit;
  }

  include 'conexao.php';

  //Rota para obter todas as tarefas
  if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $stmt = $conn->prepare("SELECT * FROM tarefas");
    $stmt->execute();
    $tarefas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //transforma os dados da variavel $tarefas em um JSON valido
    echo json_encode($tarefas);
  }

  
  //Rota para inserir dados
  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nome = $_POST ['nome'];
    $descricao = $_POST['descricao'];
    $data_de_vencimento = $_POST['data_de_vencimento'];


    $stmt = $conn->prepare("INSERT INTO Tarefas (nome, descricao, data_de_vencimento) VALUES (:nome, :descricao, :data_de_vencimento)");
    $stmt->bindParam(':nome', $novoNome);
    $stmt->bindParam(':descricao', $novoDescricao);
    $stmt->bindParam(':data_de_vencimento', $novoData);
  

    if($stmt->execute()){
        echo "Tarefa criada com sucesso";
    } else {
        echo "Erro ao criar a Tarefa";
    }

}


//rota para exibir uma tarefa
if($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset ($_GET['id'])){
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM tarefas WHERE id = :id");
    $stmt->bindParam(':id', $id);

    if($stmt->execute()){
        echo "Tarefa exluida com sucesso!!";
    }else {
        echo "Erro ao excluir a Tarefa";
    }
}





//Rota para atualizar uma tarefa existente

if($_SERVER['REQUEST_METHOD'] === 'PUT' && isset($_GET['id'])){
    parse_str(file_get_contents("php://inout"), $_PUT);

    $id = $_GET['id'];
    $novoNome = $_POST['nome'];
    $novoDescricao = $_POST['descricao'];
    $novoData = $_POST['data_de_vencimento'];
    

    $stmt = $conn->prepare("UPDATE tarefas SET nome = :nome, descricao = :descricao, data_de_vencimento = :data_de_vencimento WHERE id = :id");
    $stmt->bindParam(':nome', $novoNome);
    $stmt->bindParam(':descricao', $novoDescricao);
    $stmt->bindParam(':data_de_vencimento', $novoData);
    $stmt->bindParam(':id', $id);

    if($stmt->execute()){
        echo "Tarefa atualizada";
    } else {
        echo "Erro ao atualizar a Tarefa";
    }
}



?>