<?php
$arquivo = 'lembretes.json';
$lembretes = file_exists($arquivo) ? json_decode(file_get_contents($arquivo), true) : [];

// Verifica se os parâmetros 'data' e 'id' foram passados na URL
if (isset($_GET['data']) && isset($_GET['id'])) {
    $data = $_GET['data'];
    $id = $_GET['id'];

    // Verifica se existe uma lista de lembretes para a data fornecida e se o lembrete com o índice fornecido existe
    if (isset($lembretes[$data]) && isset($lembretes[$data][$id])) {
        // Remove o lembrete específico com base no índice
        unset($lembretes[$data][$id]);

        // Reindexar o array para garantir que os índices sejam sequenciais
        $lembretes[$data] = array_values($lembretes[$data]);

        // Se não houver mais lembretes para a data, remover a data
        if (empty($lembretes[$data])) {
            unset($lembretes[$data]);
        }

        // Salva o arquivo JSON com os lembretes atualizados
        file_put_contents($arquivo, json_encode($lembretes));
    }
}

// Redireciona de volta para a página principal
header('Location: index.php');
exit;
?>