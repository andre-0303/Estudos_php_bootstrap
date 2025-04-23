<?php
include 'conexao.php';

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    // deleta o registro
    $stmt = $conn->prepare('DELETE FROM todolist WHERE id = ?');
    $stmt->execute([$id]);
}

header('Location: index.php');   // volta para a lista em qualquer caso
exit;
