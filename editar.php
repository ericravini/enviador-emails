<?php 
  include('configs/config.ini.php');
  include('configs/conexao.php');
  include('configs/utils.php');

  $id = @$_GET['contato'];

  $queryContato = $pdo->prepare('SELECT * FROM contatos WHERE id = ?');
  $queryContato->execute([$id]);
  $contato = $queryContato->fetchAll(PDO::FETCH_OBJ);

  $smarty->assign('nome', $contato[0]->nome);
  $smarty->assign('email', $contato[0]->email);
  $smarty->assign('id', $contato[0]->id);
  
  $smarty->display('editar.html');
  if (!isset($_GET['contato'])) {
    echo '<script>location.href = "index.php"</script>';
  }