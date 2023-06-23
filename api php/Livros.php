<?php
//Livros.php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
//GET recebe/pega informações 
//POST envia informações
//PUT edita informações "update"
//DELETE deleta informações
//OPTIONS é a relação de methodos disponiveis para uso
header('Access-Control-Allow-Headers: Content-Type');

//Se o REQUEST_METHOD estiver dentro de OPTIONS(GET,POST,PUT,DELETE), ele vai retornar exit, se nao retornar, ele manda a mensagem echo.
if($_SERVER['REQUEST_METHOD'] === 'OPTIONS'){
    exit;
}

    // else{
//     echo"erro de requisição";
// }

//Querendo receber dentro da conexao.php as informações.
include 'conexao.php';

//Rota para obter TODOS os livros
if($_SERVER['REQUEST_METHOD'] === 'GET'){
    //aqui eu crio o comando de SELECT para consultar o banco
    $stmt = $conn->prepare("SELECT * FROM livros");
    //aqui eu executo o SELECT
    $stmt->execute();
    //aqui eu recebo os dados do banco por meio do PDO
    $livros = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //transformo os dados da variavel $livros em um JSON valido
    echo json_encode($livros);
}

//Rota para inserir dados
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $ano_publicacao = $_POST['ano_publicacao'];
    //inserir outros campos caso necessario ....

    $stmt = $conn->prepare("INSERT INTO Livros (titulo, autor, ano_publicacao) VALUES(:titulo, :autor, :ano_publicacao)");
    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':autor', $autor);
    $stmt->bindParam(':ano_publicacao', $ano_publicacao);
    //Outros bindParams ....

    if($stmt->execute()){
        echo "Livro criado com sucesso!!!";
    } else {
        echo"Erro ao criar Livro!!!";
    }
}


//rota para exibir um livro
if($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset ($_GET['id'])){
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM livros WHERE id = :id");
    $stmt->bindParam(':id', $id);

    if($stmt->execute()){
        echo "Livro exluido com sucesso!!";
    }else {
        echo "Erro ao excluir Livro";
    }
}

//Rota para atualizar um livro existente
if($_SERVER['REQUEST_METHOD'] === 'PUT' && isset($_GET['id'])){
    parse_str(file_get_contents("php://input"), $_PUT);

    $id = $_GET['id'];
    $novoTitulo = $_PUT['titulo'];
    $novoAutor = $_PUT['autor'];
    $novoAno = $_PUT['ano_publicacao'];
    $stmt = $conn->prepare("UPDATE livros SET titulo = :titulo, autor = :autor, ano_publicacao = :ano_publicacao WHERE id = :id");
    $stmt->bindParam(':titulo', $novoTitulo);
    $stmt->bindParam(':autor', $novoAutor);
    $stmt->bindParam(':ano_publicacao', $novoAno);
    $stmt->bindParam(':id', $id);
//add novos campos caso necessario
    if($stmt->execute()){
        echo "Livro atualizado";
    }else {
        echo "erro ao add livro";
    }
}