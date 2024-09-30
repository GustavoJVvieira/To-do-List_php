<?php
$arquivo = 'lembretes.json';
$lembretes = file_exists($arquivo) ? json_decode(file_get_contents($arquivo), true) : [];

// Verifica se os parâmetros 'data' e 'id' foram passados na URL e se existem no array de lembretes
if (!isset($_GET['data']) || !isset($_GET['id']) || !isset($lembretes[$_GET['data']][$_GET['id']])) {
    header('Location: index.php');
    exit;
}

$data = $_GET['data'];
$id = $_GET['id'];

// Editar lembrete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['lembrete_editado']) && !empty($_POST['data_lembrete'])) {
    $novaData = $_POST['data_lembrete'];
    $novoTexto = $_POST['lembrete_editado'];

    // Se a data foi alterada, mover o lembrete para a nova data
    if ($data !== $novaData) {
        // Adiciona o lembrete na nova data
        if (!isset($lembretes[$novaData])) {
            $lembretes[$novaData] = [];
        }
        $lembretes[$novaData][] = $novoTexto;

        // Remove o lembrete da data antiga
        unset($lembretes[$data][$id]);

        // Se não houver mais lembretes na data antiga, removê-la
        if (empty($lembretes[$data])) {
            unset($lembretes[$data]);
        }
    } else {
        // Apenas atualizar o lembrete na mesma data
        $lembretes[$data][$id] = $novoTexto;
    }

    // Salva o arquivo JSON com os lembretes atualizados
    file_put_contents($arquivo, json_encode($lembretes));
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Lembrete</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Editar Lembrete</h1>

        <form method="post" action="">
            <input type="text" name="lembrete_editado" value="<?php echo htmlspecialchars($lembretes[$data][$id]); ?>" required>
            <input type="date" name="data_lembrete" value="<?php echo htmlspecialchars($data); ?>" required>
            <button type="submit">Salvar</button>
        </form>

        <a href="index.php" class="back-btn">Voltar</a>
    </div>
</body>
</html>