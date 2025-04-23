<?php
// --------- CONEXÃO ----------
include 'conexao.php';

// Sempre comece com array vazio
$tarefas = [];

// --------- INSERÇÃO ----------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tarefa = trim($_POST['tarefa'] ?? '');

    if ($tarefa !== '') {
        $stmt = $conn->prepare('INSERT INTO todolist (tarefa) VALUES (?)');
        $stmt->execute([$tarefa]);
    }
    header('Location: index.php');   // evita reenvio
    exit;
}

// --------- LISTAGEM ----------
$stmt = $conn->query('SELECT * FROM todolist ORDER BY concluida, id');
if ($stmt) {
    $tarefas = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Lembrete de Tarefas</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Ícones -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    :root{
      --bs-body-bg:#f5f7fb;
      --bs-primary:#675cff;
    }
    body{min-height:100vh;display:flex;align-items:center;justify-content:center;}
    .card-shadow{box-shadow:0 0.5rem 1rem rgba(0,0,0,.15);}
    .table td,.table th{vertical-align:middle;}
  </style>
</head>
<body>
  <div class="container-sm">
    <div class="row justify-content-center">
      <div class="col-lg-8">

        <!-- Formulário -->
        <div class="card card-shadow mb-4">
          <div class="card-body">
            <h1 class="h4 text-center mb-4">📝 Lembrete de Tarefas</h1>
            <form method="POST" class="row g-3">
              <div class="col-12 col-md-9">
                <label for="tarefa" class="visually-hidden">Tarefa</label>
                <input type="text" class="form-control form-control-lg"
                       id="tarefa" name="tarefa"
                       placeholder="Descreva a nova tarefa…" maxlength="120" required>
              </div>
              <div class="col-12 col-md-3 d-grid">
                <button type="submit" class="btn btn-primary btn-lg">
                  <i class="bi bi-plus-circle"></i> Adicionar
                </button>
              </div>
            </form>
          </div>
        </div>

        <!-- Lista -->
        <?php if (count($tarefas) > 0): ?>
        <div class="card card-shadow">
          <div class="card-header bg-primary text-white">
            <strong><i class="bi bi-card-checklist me-2"></i>Lista de Tarefas</strong>
          </div>
          <div class="table-responsive">
            <table class="table align-middle mb-0">
              <thead class="table-light">
                <tr>
                  <th>ID</th>
                  <th>Tarefa</th>
                  <th class="text-end">Ações</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($tarefas as $t): ?>
                <tr class="<?= $t['concluida'] ? 'table-success text-decoration-line-through' : '' ?>">
                  <td class="fw-semibold"><?= $t['id']; ?></td>
                  <td><?= htmlspecialchars($t['tarefa']); ?></td>
                  <td class="text-end">
                    <a href="editar.php?id=<?= $t['id']; ?>" class="btn btn-sm btn-outline-secondary me-1">
                      <i class="bi bi-pencil-square"></i>
                    </a>

                    <?php if (!$t['concluida']): ?>
                      <a href="concluir.php?id=<?= $t['id']; ?>"
                         class="btn btn-sm btn-outline-success me-1"
                         onclick="return confirm('Marcar como concluída?');">
                         <i class="bi bi-check2-circle"></i>
                      </a>
                    <?php endif; ?>

                    <a href="excluir.php?id=<?= $t['id']; ?>"
                       class="btn btn-sm btn-outline-danger"
                       onclick="return confirm('Excluir definitivamente?');">
                       <i class="bi bi-trash3"></i>
                    </a>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
        <?php else: ?>
          <div class="alert alert-info text-center card-shadow">
            Você ainda não adicionou nenhuma tarefa.
          </div>
        <?php endif; ?>

      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
