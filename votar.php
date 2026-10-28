<?php
declare(strict_types=1);

function e(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.html#votacao');
    exit;
}

$sabor = trim((string)($_POST['sabor'] ?? ''));
$saboresValidos = ['Pistache', 'Doce de leite', 'Maracujá'];

if (!in_array($sabor, $saboresValidos, true)) {
    http_response_code(400);
    $titulo = 'Escolha um sabor';
    $mensagem = 'Volte à página e selecione uma opção antes de enviar seu voto.';
    $icone = '🍨';
} else {
    $arquivo = __DIR__ . '/dados/votos.csv';
    $handle = fopen($arquivo, 'ab');
    if ($handle !== false) {
        if (flock($handle, LOCK_EX)) {
            if (filesize($arquivo) === 0) {
                fputcsv($handle, ['data', 'sabor']);
            }
            fputcsv($handle, [date('c'), $sabor]);
            flock($handle, LOCK_UN);
        }
        fclose($handle);
        $titulo = 'Voto enviado!';
        $mensagem = 'Você votou em ' . $sabor . '. Obrigado por ajudar a escolher os próximos sabores do Clube do Sorvete!';
        $icone = '💗';
    } else {
        http_response_code(500);
        $titulo = 'Votação indisponível';
        $mensagem = 'Não foi possível registrar seu voto agora. Tente novamente mais tarde.';
        $icone = '🍦';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($titulo) ?> | Clube do Sorvete</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="result-page">
  <main class="result-card">
    <div class="result-icon"><?= e($icone) ?></div>
    <h1><?= e($titulo) ?></h1>
    <p><?= e($mensagem) ?></p>
    <a class="button" href="index.html#votacao">Voltar à votação</a>
  </main>
</body>
</html>
