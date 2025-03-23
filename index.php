<?php
    include 'conexao.php';

    $tarefas = [];

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $tarefa = $_POST["tarefa"];

        $stmt = $conn->prepare("INSERT INTO todolist (tarefa) values(?)");
        $stmt->execute([$tarefa]);
        header("location: index.php");
        exit;
    }
    $stmt = $conn->query("SELECT * FROM todolist");
    $tarefas = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>todoList</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body class="d-flex align-items-center py-4 bg-body-tertiary">
    <main class="w-100 m-auto form-container">
    <form method="POST" action="index.php">
    <h1 class="h1 mb-3 fw-normal">Lembrete de tarefas</h1>
    <div class="form-floating">
        <div class="form-floating"></div>    
        <input type="text" id="tarefa" name="tarefa" required class="form-control">
        <label for="tarefa">Tarefa</label>
        </div>
        <button type="submit" class="btn btn-primary w100 py-2">Listar tarefa</button>
    </form>
    </div>
    <?php if(count($tarefas) > 0) : ?>
        <h2>Lista de tarefas</h2>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col">ID</th>
                    <th scope="col">TAFERA</th>
                    <th scope = "col">AÇÕES</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <?php foreach($tarefas as $tarefa) : ?>
                    <tr>
                        <th scope="row">
                        <td><?php echo $tarefa['id']; ?></td>
                        <td><?php echo $tarefa['tarefa']; ?></td>
                        <td>
                        <a href="editar.php?id=<?php echo $tarefa['id']; ?>" id="editar" class="btn btn-danger">Editar</a>
                        <a href="excluir.php?id=<?php echo $tarefa['id']; ?>" id="excluir" class="btn btn-warning">Concluir</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
            <p>Não possui tarefas cadastradas</p>
        <?php endif; ?>
        </main>
</body>
</html>