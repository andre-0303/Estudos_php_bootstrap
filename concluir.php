<?php
include 'conexao.php';

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    // seta a flag concluída
    $stmt = $conn->prepare('UPDATE todolist SET concluida = 1 WHERE id = ?');
    $stmt->execute([$id]);
}

header('Location: index.php');
exit;
