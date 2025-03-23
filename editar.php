<?php
    include 'conexao.php';
    $tarefas = [];

    // Verifica se um ID foi passado na URL
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $stmt = $conn->prepare("SELECT * FROM todolist WHERE id = ?");
        $stmt->execute([$id]);
        $tarefa = $stmt->fetch();
        
        // Se não encontrar a tarefa, redireciona
        if (!$tarefa) {
            header("location: index.php");
            exit;
        }
    }

    // Verifica se o formulário foi enviado
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tarefa'])) {
        $tarefaAtualizada = $_POST['tarefa']; // Nome diferente para a variável

        // Atualiza a tarefa no banco de dados
        $stmt = $conn->prepare("UPDATE todolist SET tarefa = ? WHERE id = ?");
        $stmt->execute([$tarefaAtualizada, $id]);

        // Redireciona para a página principal
        header("location: index.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>todoList</title>
    <link rel="stylesheet" href="editar.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body class="d-flex align-items-center py-4 bg-body-tertiary">
    <main class="w-100 m-auto form-container" id="main">
    <h1 class="h1 mb-3 fw-normal">Editor de tarefas</h1>
    <form method="POST" action="" id="form">
        <div class="form-floating">
        <input type="text" placeholder="Edite sua tarefa" id="tarefa" name="tarefa" value="<?php echo htmlspecialchars($tarefa['tarefa']); ?>" required class="form-control m-3">
        <label for="tarefa">Tarefa</label>
        <button type="submit" class="btn btn-primary w100 py-2 mt-3">Editar tarefa</button>
        </div>
    </form>
    <?php if(count($tarefas) > 0) : ?>
        <h2>Lista de tarefas</h2>
        <table border = "1">
            <thead>
                <td>
                    <tr>ID</tr>
                    <tr>TAREFA</tr>
                    <tr>AÇÃO</tr>
                </td>
            </thead>
        <?php endif ; ?>
        </main>
</body>
</html>