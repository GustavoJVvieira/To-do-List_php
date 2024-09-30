<?php
$arquivo = 'lembretes.json';
$lembretes = file_exists($arquivo) ? json_decode(file_get_contents($arquivo), true) : [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['novo_lembrete']) && !empty($_POST['data_lembrete'])) {
    $data = $_POST['data_lembrete'];
    $novoLembrete = $_POST['novo_lembrete'];

    if (isset($lembretes[$data])) {
        $lembretes[$data][] = $novoLembrete;
    } else {
        $lembretes[$data] = [$novoLembrete];
    }

    file_put_contents($arquivo, json_encode($lembretes));
    header('Location: index.php');
    exit;
}

// Data atual
$dataAtual = date('Y-m-d');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lembretes</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Adicionar Lembretes</h1>

        <form method="post" action="">
            <input type="text" name="novo_lembrete" placeholder="Adicionar lembrete" required>
            <input type="date" name="data_lembrete" min="2024-09-29" required>
            <button type="submit">Criar</button>
        </form>

        <div class="lembretes-containers">
            <!-- Contêiner para Lembretes Atrasados -->
            <div class="lembretes-atrasados">
                <h2>Lembretes Atrasados</h2>
                <ul class="lembretes-list">
                    <?php foreach ($lembretes as $data => $lembretesDoDia): ?>
                        <?php if ($data < $dataAtual): ?>
                            <li class="lembrete-item">
                                <h3><?php echo date('d/m/Y', strtotime($data)); ?></h3>
                                <ul>
                                    <?php foreach ($lembretesDoDia as $index => $lembrete): ?>
                                        <li>
                                            <span><?php echo htmlspecialchars($lembrete); ?></span>
                                            <div class="actions">
                                                <a class="edit" href="edit.php?data=<?php echo $data; ?>&id=<?php echo $index; ?>">Editar</a>
                                                <a class="delete" href="delete.php?data=<?php echo $data; ?>&id=<?php echo $index; ?>">Excluir</a>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Contêiner para Lembretes de Hoje -->
            <div class="lembretes-hoje">
                <h2>Lembretes de Hoje</h2>
                <ul class="lembretes-list">
                    <?php foreach ($lembretes as $data => $lembretesDoDia): ?>
                        <?php if ($data === $dataAtual): ?>
                            <li class="lembrete-item">
                                <h3><?php echo date('d/m/Y', strtotime($data)); ?></h3>
                                <ul>
                                    <?php foreach ($lembretesDoDia as $index => $lembrete): ?>
                                        <li>
                                            <span><?php echo htmlspecialchars($lembrete); ?></span>
                                            <div class="actions">
                                                <a class="edit" href="edit.php?data=<?php echo $data; ?>&id=<?php echo $index; ?>">Editar</a>
                                                <a class="delete" href="delete.php?data=<?php echo $data; ?>&id=<?php echo $index; ?>">Excluir</a>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Contêiner para Lembretes Futuros -->
            <div class="lembretes-futuro">
                <h2>Lembretes Futuros</h2>
                <ul class="lembretes-list">
                    <?php foreach ($lembretes as $data => $lembretesDoDia): ?>
                        <?php if ($data > $dataAtual): ?>
                            <li class="lembrete-item">
                                <h3><?php echo date('d/m/Y', strtotime($data)); ?></h3>
                                <ul>
                                    <?php foreach ($lembretesDoDia as $index => $lembrete): ?>
                                        <li>
                                            <span><?php echo htmlspecialchars($lembrete); ?></span>
                                            <div class="actions">
                                                <a class="edit" href="edit.php?data=<?php echo $data; ?>&id=<?php echo $index; ?>">Editar</a>
                                                <a class="delete" href="delete.php?data=<?php echo $data; ?>&id=<?php echo $index; ?>">Excluir</a>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
