<?php
// * DATABASE LOCAL DE EMAILS * //
  $host = '127.0.0.1';
  $dbname = 'emails';
  $username = 'root';
  $password = '';

  try {
    $pdo = new PDO('mysql:host='.$host.';dbname='.$dbname.';charset=utf8', $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Criando table caso não exista.
    $table_cmd = "CREATE TABLE IF NOT EXISTS usuarios (
      id INT PRIMARY KEY AUTO_INCREMENT NOT NULL, 
      nome VARCHAR(40), 
      email VARCHAR(320) 
    )";
    $query = $pdo->prepare($table_cmd);
    $query->execute();

  } catch (PDOException $e) {
    echo "Erro na conexão da database: " . $e->getMessage(); //o getmessage aqui pega a mensagem do erro, obviamente
  }