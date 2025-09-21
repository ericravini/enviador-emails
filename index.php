<?php 
  include('configs/config.ini.php');
  include('configs/conexao.php');

  // LISTA
  try {
    $queryLista = $pdo->prepare('SELECT * FROM contatos');
    $queryLista->execute();
    $listaUsers = $queryLista->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    die('Erro ao listar contatos: ' . $e->getMessage());
  }

  echo (@$listaUsers[0]["email"]);

  // AÇÕES
  @$acao = $_GET['acao'];
  if (isset($acao)) {

  }

  $smarty->assign('listaContatos', $listaUsers);
  // Ícones (config.ini.php)
  $smarty->assign('editIcon', $edit_svg_icon);
  $smarty->assign('deleteIcon', $delete_svg_icon);
  $smarty->assign('results', count($listaUsers));
  // Display final
  $smarty->display('index.html');