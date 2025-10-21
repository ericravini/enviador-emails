<?php 
  include('configs/config.ini.php');
  include('configs/conexao.php');
  include('configs/utils.php');
  
  $queryLista = $pdo->prepare('SELECT * FROM contatos ORDER BY email');

  try {
    $queryLista->execute();

    $listaUsers = []; /* pra caso a query nao executar por algum motivo */
    $listaUsers = $queryLista->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    die('Erro ao listar contatos: ' . $e->getMessage());
  }
  
  // AÇÕES
  if (isset($_POST['acao']) || isset($_GET['acao'])) {
    if (isset($_POST['acao'])) {
      $acao = $_POST['acao'];
    } elseif (isset($_GET['acao'])) {
      // As vezes, a ação pode ser inserida no GET.
      $acao = $_GET['acao'];
    }

    switch ($acao) {
      case 'enviar-todos':
        $mensagemEnviada = $_POST['mensagem'];
        $assuntoEnviado = $_POST['assunto'];
        break;

      case 'add-contato':
        $nome = $_POST['nome'];
        $email = strtolower($_POST['email']);
        $adicionar = true;

        foreach ($listaUsers as $user) {
          if ($user['email'] == $email) {
            $adicionar = false;
            alert("Já existe um contato com esse e-mail: ". $user['nome'] ." | $email");
            break;
          }
        }

        if ($adicionar == true) {
          $queryAdd = $pdo->prepare('INSERT INTO contatos (nome, email) VALUES (?, ?)');
          $queryAdd->execute([$nome, $email]);
          alert("Contato adicionado: $nome | $email");

          // Atualizando a lista de contatos para mostrar depois
          try {
            $queryLista->execute();
            $listaUsers = $queryLista->fetchAll(PDO::FETCH_ASSOC);
          } catch (PDOException $e) {}
        }
        break;

        case 'editar':
          $nome = $_POST['nome'];
          $email = $_POST['email'];
          $id = $_POST['id'];

          $queryUpdate = $pdo->prepare('UPDATE contatos SET nome = ?, email = ? WHERE id = ?');
          $queryUpdate->execute([$nome, $email, $id]);

          alert("Contato atualizado: $nome | $email");
          
          // Atualizando a lista de contatos para mostrar depois
          try {
            $queryLista->execute();
            $listaUsers = $queryLista->fetchAll(PDO::FETCH_ASSOC);
          } catch (PDOException $e) {}
        break;

        case 'deletar':
          $id = $_GET['contato'];

          try {
            $queryContato = $pdo->prepare('SELECT * FROM contatos WHERE id = ?');
            $queryContato->execute([$id]);
            $contato = $queryContato->fetchAll(PDO::FETCH_ASSOC);
            if ($contato) {
              $nome = $contato[0]['nome'];
              $email = $contato[0]['email'];
            } else {
              alert("Não existe um contato com esse ID!");
              break;
            }

            $queryDelete = $pdo->prepare('DELETE FROM contatos WHERE id = ?');
            $queryDelete->execute([$id]);
          } catch (PDOException $e) {
            echo 'Erro na query: ' . $e->getMessage();
          }

          alert("Contato deletado: $nome | $email");

          // Atualizando a lista de contatos para mostrar depois
          try {
            $queryLista->execute();
            $listaUsers = $queryLista->fetchAll(PDO::FETCH_ASSOC);
          } catch (PDOException $e) {}
        break;

        case 'pesquisar':
          if (!empty($_POST['search'])) {
            $mensagemPesquisa = $_POST['search'];

            try {
              $queryPesquisa = $pdo->prepare('SELECT * FROM contatos WHERE nome LIKE ? OR email LIKE ? OR id LIKE ?');
              $argumentoPesquisa = "%" . $mensagemPesquisa . "%";
              $queryPesquisa->execute([$argumentoPesquisa, $argumentoPesquisa, $argumentoPesquisa]);
              $listaUsers = $queryPesquisa->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
              die('Erro ao listar contatos: ' . $e->getMessage());
            }
          }
        break;

      default:
        break;
    }
  }

  // VARIÁVEIS
  if (isset($listaUsers)) {
    $smarty->assign('listaUsers', $listaUsers);
  }
  if (isset($mensagemEnviada)) {
    $smarty->assign('assuntoEnviado', $assuntoEnviado);
    $smarty->assign('mensagemEnviada', $mensagemEnviada);
  }
  if (isset($mensagemPesquisa)) {
    $smarty->assign('mensagemPesquisa', $mensagemPesquisa);
  }
  // Ícones (config.ini.php)
  $smarty->assign('editIcon', $edit_svg_icon);
  $smarty->assign('deleteIcon', $delete_svg_icon);
  $smarty->assign('results', count($listaUsers));

  // Display final
  $smarty->display('index.html');