<?php 
  include('configs/config.ini.php');
  include('configs/conexao.php');

  $queryLista = $pdo->prepare('SELECT * FROM usuarios');
  $queryLista->execute();
  $listaUsers = $queryLista->fetchAll();

  $acao = $_GET['acao'];

  $smarty->assign('listaUser', $listaUsers);
  $smarty->display('index.html');