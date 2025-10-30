<?php

// Verifica se foi enviado uma resposta via GET
if(isset($_GET['answer'])) {

    // Obtém a questão atual do jogo armazenada na sessão
    $current_question = $_SESSION['game']['currect_question'];

    // Pega a resposta selecionada pelo usuário
    $answer = $_GET['answers'];
    
    // Obtém a resposta dada pela sessão usando o índice da questão e a resposta selecionada
    $answer_given = $_SESSION['questions'][$current_question]['answers'][$answer];

    // Verifica se a resposta dada está correta
    if($answer_given == $_SESSION['questions'][$_SESSION['game']['currect_question']]['correct_answer']) {
        // Se a resposta estiver correta, incrementa o contador de respostas corretas
        $_SESSION['game']['correct_answers']++;
    } else {
        // Se a resposta estiver incorreta, incrementa o contador de respostas incorretas
        $_SESSION['game']['incorrect_answers']++;
    }

    // Verifica se todas as questões foram respondidas, ou seja, se o jogo acabou
    if($_SESSION['game']['current_question'] == $_SESSION['game']['total_questions'] - 1) {
        // Se o jogo acabou, redireciona para a página de fim de jogo
        header('Location: index.php?route=gameover');
        exit; // Encerra o script após o redirecionamento
    }

    // Se o jogo não acabou, incrementa a variável que controla a questão atual
    $_SESSION['game']['current_question']++;

    // Redireciona para a próxima questão
    header('Location: index.php?route=game');
    exit; // Encerra o script após o redirecionamento
}

// Inicializa as variáveis com os dados da sessão para exibir a questão atual
$current_question = $_SESSION['game']['current_question'];
$total_questions = $_SESSION['game']['total_questions'];

// Pega a quantidade de respostas corretas e incorretas até o momento
$correct_answers = $_SESSION['game']['correct_answers'];
$incorrect_answers = $_SESSION['game']['incorrect_answers'];

// Pega o país atual da pergunta
$country = $_SESSION['questions'][$current_question]['question'];
// Pega as respostas possíveis para a questão atual
$answers = $_SESSION['questions'][$current_question]['answers'];

?>

<!-- HTML para exibição da questão e informações do jogo -->
<div class="container">
    <h1>Quiz de Yakuza 🐉</h1>

    <!-- Exibe o número da questão atual e o total de questões -->
    <h5>Questão n.º <strong><?= $current_question + 1 . ' / ' . $total_questions ?></strong></h5>

    <div>
        <!-- Exibe a quantidade de respostas corretas e incorretas -->
        <h4>Corretas: <strong><?= $correct_answers ?></strong>
        Erradas: <strong><?= $incorrect_answers ?></strong></h4>
    </div>

    <hr>
    <!-- Exibe a pergunta, que é o nome do país, para o qual o usuário deve escolher a capital -->
    <h4>Qual é a seguinte resposta: <strong><?= $country ?></strong></h4>
    <hr>

    <div>
        <!-- Exibe as opções de respostas, que são capital de diferentes países -->
        <h3 style="cursor: pointer" id="answer_0"><?= $capitals[$answers[0]][1] ?? '' ?></h3>
        <h3 style="cursor: pointer" id="answer_1"><?= $capitals[$answers[1]][1] ?? '' ?></h3>
        <h3 style="cursor: pointer" id="answer_2"><?= $capitals[$answers[2]][1] ?? '' ?></h3>


    </div>

    <div>
        <!-- Link para desistir do jogo e voltar para a tela inicial -->
        <a href="index.php?route=start">Desistir</a>
    </div>
</div>

<!-- Script JavaScript para capturar a resposta clicada e redirecionar -->
<script>
    // Seleciona todos os elementos que têm id começando com "answer_"
    document.querySelectorAll("[id^='answer_']").forEach(element => {
        // Adiciona um evento de clique para cada um desses elementos
        element.addEventListener('click', () => {
            // Obtém o id do elemento clicado, separando o número da resposta
            let id = element.id.split('_')[1];
            // Redireciona para a URL do jogo, passando a resposta como parâmetro na URL
            window.location.href = `index.php?route=game&answer=${id}`;
        });
    });
</script>
