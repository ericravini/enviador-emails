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
  if (isset($_POST['acao'])) {
    $acao = $_POST['acao'];

    switch ($acao) {
      case 'enviar-todos':
        $mensagemEnviada = $_POST['mensagem'];
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
          $queryAdd->execute([$nome, $email]); // passando os valores por aqui para evitar problemas de sql injection
          alert("Contato Adicionado: $nome | $email");

          // Atualizando a lista de contatos para mostrar depois
          try {
            $queryLista->execute();
            $listaUsers = $queryLista->fetchAll(PDO::FETCH_ASSOC);
          } catch (PDOException $e) {}
        }
        break;

        case 'pesquisar':
          if (!empty($_POST['search'])) {
            $mensagemPesquisa = $_POST['search'];

            try {
              $queryPesquisa = $pdo->prepare('SELECT * FROM contatos WHERE nome LIKE ? OR email LIKE ?');
              $argumentoPesquisa = "%" . $mensagemPesquisa . "%";
              $queryPesquisa->execute($argumentoPesquisa, $argumentoPesquisa); // passando os valores por aqui para evitar problemas de sql injection (novamente)
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