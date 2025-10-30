<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <link rel="shortcut icon" href="https://assets-prd.ignimgs.com/2024/08/27/nintendoswitch-yakuza-kiwami-keyart-square-1724775946350.png?crop=1%3A1%2Csmart&width=348&height=348&format=jpg&auto=webp&quality=80">
  <title>Quiz de Yakuza</title>
</head>
<body>
  
</body>
</html>
<?php


// Inicia a sessão. Isso permite que dados possam ser armazenados entre as requisições (ex: usuário logado, pontuação, etc).
session_start();

// Ontém o parâmetro 'route' da URL (caso exista). Se não existir, define 'start' como o valor padrão.
// Esse parâmetro define a "rota" ou página que será carregada no sistema (ex: página inicial, jogo, etc.).

$route = $_GET['route'] ?? 'start';

// A variável $script vai armazenar o nome do script que será carregado com base na rota.
$script = null;

// Utiliza uma estrutura de controle switch para definir qual script carregar com base no valor de $route.
switch ($route) {
    // Se a rota for 'start', carega o script para a pagina inicial do jogo.
  case 'start':
    $script = 'start'; //Define que o script 'start.php' será carregado.
    break;
    
    //Se a rota for 'game', carrega o script do jogo em si.
    case 'game':
        $script = 'game'; //Define que o script 'game.php' será carregado.
        break;

        // Se a rota for 'gameover', carrega o script 'gameover.php' será carregado.
        break;

        // Se a rota não for nenhuma das anteriores, carrega um script para a página 404 (página não encontrada).
        default:
        $script = '404'; // Define que o script '404.php' será carregado.
        break;
}

// Carrega o arquivo de dado das capitais, que contém uma lista ou array com os países e suas capitais.
// Esse arquivo é um arquivo PHP que retorna dados.
$capitals = require __DIR__ .'/data/capitals.php';

// Carrega o cabeçalho da página (um arquivo HTML/PHP com a estrutura inicial do site, como a barra de navegação).
require_once __DIR__ . "/scripts/header.php";

// Carrega o script correspondente á rota definida anteriormente. O nome do script foi definido na variavel $script.
// Exemplo: se a rota for 'game', o arquivo 'game.php' será caregado. 
require_once __DIR__ . "/scripts/$script.php";

// Carrega o rodapé da página (um arquivo HTML/PHP com a estrutura final do siote, como as informações de copyright).
require_once __DIR__ . "/scripts/footer.php";