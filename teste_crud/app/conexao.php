<?php
//     Abrindo a conexao com o banco de dados SQLITE
     try {
          $pdo = new PDO('sqlite:db/db_teste.sqlite3'); 
          $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
     } catch (PDOException $error) {
        echo $error->getMessage();
        exit;

     }
     //  criando tabela no banco de dados
     $sql = "CREATE TABLE IF NOT EXISTS conta (
          id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
          nome TEXT NOT NULL,
          data_nasc TEXT NOT NULL, 
          senha TEXT NOT NULL,
          email TEXT NOT NULL,
          cpf TEXT NOT NULL)";
          $pdo->exec($sql);
     
     
?>