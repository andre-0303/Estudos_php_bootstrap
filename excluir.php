<?php
    include 'conexao.php';
    

    if(isset($_GET['id'])){
        $id = $_GET['id'];

        $stmt = $conn->prepare("DELETE from todolist where id = ?");
        $stmt->execute([$id]);
        header("location: index.php");
        exit;
    }else{
        //header("location: index.php");
        exit;
    }


?>