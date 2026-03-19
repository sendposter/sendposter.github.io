<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $arquivo = '';

    if (!empty($_FILES['arquivo']['name'])) {
        $arquivo = uniqid() . '_' . $_FILES['arquivo']['name'];
        move_uploaded_file($_FILES['arquivo']['tmp_name'], 'uploads/' . $arquivo);
    }

    $stmt = $conn->prepare("INSERT INTO users (nome, email, arquivo) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nome, $email, $arquivo);
    $stmt->execute();
    header('Location: index.php');
}
?>

<link rel="stylesheet" href="style.css">
<h2>Cadastrar Usuário</h2>
<form method="post" enctype="multipart/form-data">
    <label>Nome:</label>
    <input type="text" name="nome" required>
    <label>Email:</label>
    <input type="email" name="email" required>
    <label>Arquivo:</label>
    <input type="file" name="arquivo">


    <input type="submit" value="Salvar">
</form>