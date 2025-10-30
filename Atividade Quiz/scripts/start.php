<?php
session_start(); // Inicia a sessão

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Obtém o número total de questões, garantindo que seja um inteiro válido
    $total_questions = isset($_POST['text_total_questions']) ? intval($_POST['text_total_questions']) : 10;

    // Prepara o jogo com o número de questões definido
    prepare_game($total_questions);

    // Redireciona para o jogo
    header('Location: index.php?route=game');
    exit;
}

// Função que monta as perguntas do quiz
function prepare_game($total_questions)
{
    global $capitals; // Usa o array global de países e capitais

    $ids = [];
    // Seleciona IDs aleatórios únicos até alcançar o total de questões
    while (count($ids) < $total_questions) {
        $id = rand(0, count($capitals) - 1);
        if (!in_array($id, $ids)) {
            $ids[] = $id;
        }
    }

    $questions = [];

    // Monta as perguntas
    foreach ($ids as $id) {
        $answers = [$id]; // Primeira resposta é a correta

        // Adiciona duas respostas erradas aleatórias
        while (count($answers) < 3) {
            $tmp = rand(0, count($capitals) - 1);
            if (!in_array($tmp, $answers)) {
                $answers[] = $tmp;
            }
        }

        shuffle($answers); // Embaralha as alternativas

        // Adiciona a pergunta formatada
        $questions[] = [
            'country' => $capitals[$id][0],   // Nome do país
            'correct_answer' => $id,          // ID da resposta correta
            'answers' => $answers             // IDs das 3 respostas possíveis
        ];
    }

    // Salva os dados do jogo na sessão
    $_SESSION['questions'] = $questions;
    $_SESSION['game'] = [
        'total_questions' => $total_questions,
        'current_question' => 0,
        'correct_answers' => 0,
        'incorrect_answers' => 0,
    ];
}
?>

<!-- HTML -->
<div class="container">
    <h1>Quiz de Yakuza 🐉</h1>
    <hr>

    <form action="index.php?route=start" method="post">
        <h3>
            <label for="text_total_questions" class="form-label">Número de questões:</label>
            <input type="number" class="form-control" id="text_total_questions" name="text_total_questions"
                   value="10" min="1" max="20" required>
        </h3>

        <div>
            <button type="submit" class="btn">Iniciar</button>
        </div>
    </form>
</div>
