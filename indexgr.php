<?php
include 'db.php';

$search = $_GET['search'] ?? '';
$sql = "SELECT * FROM users WHERE nome LIKE '%$search%' OR cpf LIKE '%$search%' ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Data Table </title>
    <meta content="" name="description">
    <meta content="Author" name="MJ Maraz">
    <link href="assets/images/favicon.png" rel="icon">
    <link href="assets/images/favicon.png" rel="apple-touch-icon">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/datatables.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
    .button-azul {
        background-color: #2308f2 !important;
        color: #fff !important;
        border: none;
        padding: 6px 18px;
        border-radius: 4px;
        text-decoration: none;
        font-weight: 500;
        transition: background 0.2s;
        margin-right: 6px;
        display: inline-block;
    }
    .button-azul:hover, .button-azul:focus {
        background-color: #1805a7 !important;
        color: #fff !important;
        text-decoration: none;
    }
    </style>
    <script>
      document.addEventListener("contextmenu", function(e){
        e.preventDefault();
      }, false);
    </script>
</head>

<body>
    <header class="header_part">
        <img src="assets/images/logo.png" alt="" class="img-fluid">
        <h4>How to Make - Data Table - Bootstrap 5</h4>
    </header>

    <link rel="stylesheet" href="style.css">

    <div class="container">
      <div class="row mb-3">
        <div class="col-12 d-flex align-items-center">
          <h2 class="me-3 mb-0"></h2>
          <a href="create.php" class="button-azul me-2">Cadastrar</a>
          <a href="files.php" class="button-azul">Listar Arquivos</a>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="data_table">
            <table id="example" class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                      <th>ID</th>
                      <th>Nome</th>
                      <th>CPF</th>
                      <th>Arquivo</th>
                      <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['nome']) ?></td>
                        <td><?= htmlspecialchars($row['cpf']) ?></td>
                        <td>
                            <?php if($row['arquivo']): ?>
                                <a href="uploads/<?= $row['arquivo'] ?>" target="_blank" class="button" title="Visualizar">
                                    Visualizar
                                </a>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="edit.php?id=<?= $row['id'] ?>" class="edit button">Editar</a>
                            <a href="delete.php?id=<?= $row['id'] ?>" class="delete button" onclick="return confirm('Excluir?')">Excluir</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <!-- =======  Data-Table  = End  ===================== -->

    <!-- ============ Java Script Files  ================== -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/datatables.min.js"></script>
    <script src="assets/js/pdfmake.min.js"></script>
    <script src="assets/js/vfs_fonts.js"></script>
    <script src="assets/js/custom.js"></script>
</body>
</html>