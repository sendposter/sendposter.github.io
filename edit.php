<?php
include 'db.php';

$id = $_GET['id'];
$sql = "SELECT * FROM users WHERE id=$id";
$row = $conn->query($sql)->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf']; // Corrigido aqui
    $arquivo = $row['arquivo'];

    if (!empty($_FILES['arquivo']['name'])) {
        $arquivo = uniqid() . '_' . $_FILES['arquivo']['name'];
        move_uploaded_file($_FILES['arquivo']['tmp_name'], 'uploads/' . $arquivo);
    }

    $stmt = $conn->prepare("UPDATE users SET nome=?, cpf=?, arquivo=? WHERE id=?");
    $stmt->bind_param("sssi", $nome, $cpf, $arquivo, $id);
    $stmt->execute();
    header('Location: index.php');
    exit;
}
?>

<link rel="stylesheet" href="style.css">
<style>
.form-editar {
    max-width: 400px;
    margin: 40px auto;
    padding: 24px 32px;
    background: #f8f9fa;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    font-family: Arial, sans-serif;
}
.form-editar label {
    font-weight: bold;
    margin-bottom: 6px;
    display: block;
}
.form-editar input[type="text"],
.form-editar input[type="file"] {
    width: 100%;
    padding: 8px;
    margin-bottom: 18px;
    border: 1px solid #ccc;
    border-radius: 4px;
}
.form-editar input[type="submit"] {
    background: #007bff;
    color: #fff;
    border: none;
    padding: 10px 24px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}
.form-editar input[type="submit"]:hover {
    background: #0056b3;
}
.form-editar .arquivo-atual {
    margin-bottom: 18px;
}
</style>

<h2 style="text-align:center;">Editar Usuário</h2>
<form class="form-editar" method="post" enctype="multipart/form-data">
    <label>Nome:</label>
    <input type="text" name="nome" value="<?= htmlspecialchars($row['nome']) ?>" required>

    <label>CPF:</label>
    <input type="text" name="cpf" value="<?= htmlspecialchars($row['cpf']) ?>" required>

    <label>Arquivo:</label>
    <input type="file" name="arquivo">
    <?php if($row['arquivo']): ?>
        <div class="arquivo-atual">
            <p>Arquivo atual: <a href="uploads/<?= htmlspecialchars($row['arquivo']) ?>" target="_blank">Ver</a></p>
        </div>
    <?php endif; ?>
    <input type="submit" value="Salvar">
</form>

<!-- jQuery e jQuery Mask Plugin para máscara de CPF -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>
$(document).ready(function(){
  $('input[name="cpf"]').mask('000.000.000-00');
});
</script>