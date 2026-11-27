<?php
require __DIR__ . '/config/database.php';
 
$erros     = [];
$titulo    = '';
$descricao = '';
$status    = 'pendente';
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo    = trim($_POST['titulo'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $status    = $_POST['status'] ?? 'pendente';
 
    if ($titulo === '') {
        $erros[] = 'Informe o título da tarefa.';
    }
 
    if (count($erros) === 0) {
        $sql  = 'INSERT INTO tarefas (titulo, descricao, status)
                 VALUES (:titulo, :descricao, :status)';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':titulo'    => $titulo,
            ':descricao' => $descricao,
            ':status'    => $status,
        ]);
 
        header('Location: index.php');
        exit;
    }
}
?>



<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Tarefa</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 500px;
            margin: 40px auto;
            padding: 20px;
        }

        .campo {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input, textarea, select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        button {
            padding: 10px 15px;
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .erro {
            color: red;
        }

        .sucesso {
            color: green;
        }
    </style>
</head>

<body>

    <h2>Nova Tarefa</h2>

    <?php if (isset($_GET['sucesso'])): ?>
        <p class="sucesso">Tarefa cadastrada com sucesso!</p>
    <?php endif; ?>

    <?php foreach ($erros as $erro): ?>
        <p class="erro">
            <?= htmlspecialchars($erro) ?>
        </p>
    <?php endforeach; ?>

    <form action="" method="POST">

        <div class="campo">
            <label for="titulo">Título *</label>
            <input
                type="text"
                id="titulo"
                name="titulo"
                value="<?= htmlspecialchars($titulo) ?>"
                required
            >
        </div>

        <div class="campo">
            <label for="descricao">Descrição</label>
            <textarea
                id="descricao"
                name="descricao"
                rows="4"
            ><?= htmlspecialchars($descricao) ?></textarea>
        </div>

        <div class="campo">
            <label for="status">Status</label>

            <select id="status" name="status">
                <option value="pendente" <?= $status === 'pendente' ? 'selected' : '' ?>>
                    Pendente
                </option>

                <option value="em andamento" <?= $status === 'em andamento' ? 'selected' : '' ?>>
                    Em andamento
                </option>

                <option value="concluida" <?= $status === 'concluida' ? 'selected' : '' ?>>
                    Concluída
                </option>
            </select>
        </div>

        <button type="submit">Salvar</button>

    </form>

</body>
</html>