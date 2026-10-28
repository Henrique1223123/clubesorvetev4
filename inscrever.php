<?php
declare(strict_types=1);

function e(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.html#assinar');
    exit;
}

$nome = trim((string)($_POST['nome'] ?? ''));
$contato = trim((string)($_POST['contato'] ?? ''));
$preferencia = trim((string)($_POST['preferencia'] ?? ''));
$preferenciasValidas = ['Chocolate', 'Frutas', 'Cremosos', 'Sabores diferentes'];

if ($nome === '' || mb_strlen($nome) > 80 || $contato === '' || mb_strlen($contato) > 120 || !in_array($preferencia, $preferenciasValidas, true)) {
    http_response_code(400);
    $titulo = 'Confira os dados';
    $mensagem = 'Não foi possível registrar seu interesse. Volte e confira os campos do formulário.';
    $icone = '📝';
} else {
    $arquivo = __DIR__ . '/dados/interessados.csv';
    $handle = fopen($arquivo, 'ab');
    if ($handle !== false) {
        if (flock($handle, LOCK_EX)) {
            if (filesize($arquivo) === 0) {
                fputcsv($handle, ['data', 'nome', 'contato', 'preferencia']);
            }
            fputcsv($handle, [date('c'), $nome, $contato, $preferencia]);
            flock($handle, LOCK_UN);
        }
        fclose($handle);
        $titulo = 'Interesse registrado!';
        $mensagem = 'Obrigado, ' . $nome . '! Seu interesse foi registrado neste protótipo. Nenhuma cobrança ou assinatura real foi criada.';
        $icone = '🍦';
    } else {
        http_response_code(500);
        $titulo = 'Cadastro indisponível';
        $mensagem = 'Não foi possível salvar os dados agora. Tente novamente mais tarde.';
        $icone = '💛';
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
    <a class="button" href="index.html">Voltar para a página inicial</a>
  </main>
</body>
</html>
