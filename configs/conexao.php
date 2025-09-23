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
    $table_cmd = "CREATE TABLE IF NOT EXISTS contatos (
      id INT AUTO_INCREMENT PRIMARY KEY,
      nome VARCHAR(100) NOT NULL,
      email VARCHAR(150) NOT NULL,
      criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );";
    $query = $pdo->prepare($table_cmd);
    $query->execute();

  } catch (PDOException $e) {
    die ('Erro na conexão da database: ' . $e->getMessage()); //o getmessage aqui pega a mensagem do erro, obviamente
  }