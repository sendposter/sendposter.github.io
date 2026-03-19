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
    <meta content="Author" name="">
    <link href="assets/images/favicon.png" rel="icon">
    <link href="assets/images/favicon.png" rel="apple-touch-icon">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/datatables.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
    .button, .edit.button, .delete.button, .button-azul, .visualizar-btn {
        padding: 6px 18px;
        font-size: 1rem;
        border-radius: 4px;
        border: none;
        min-height: 28px;
        box-sizing: border-box;
        display: inline-block;
        line-height: 1.2;
        font-weight: 500;
        text-decoration: none;
        transition: background 0.2s;
    }
    .button-azul {
        background-color: #2308f2 !important;
        color: #fff !important;
        margin-right: 6px;
    }
    .button-azul:hover, .button-azul:focus {
        background-color: #1805a7 !important;
        color: #fff !important;
        text-decoration: none;
    }
    .visualizar-btn {
        background-color: #03f538 !important;
        color: #000 !important;
        margin-right: 6px;
    }
    .visualizar-btn:hover, .visualizar-btn:focus {
        background-color: #02c42c !important;
        color: #000 !important;
        text-decoration: none;
    }
    #example th, #example td {
        text-align: center;
        vertical-align: middle;
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
        <img src="assets/images/" alt="" class="img-fluid">
        <h4>DATABASE</h4>
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
            <table id="example" class="table table-striped table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                      <th>ID</th>
                      <th>Nome</th>
                      <th>CPF</th>
                      <th>CNPJ</th>
                      <th>Pais</th>
        <th>Estado</th>
        <th>Cidade</th>
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
                        <td><?= htmlspecialchars($row['cnpj']) ?></td>
                        <td><?= htmlspecialchars($row['pais']) ?></td>
                        <td><?= htmlspecialchars($row['estado']) ?></td>
                        <td><?= htmlspecialchars($row['cidade']) ?></td>
                        <td>
                            <?php if($row['arquivo']): ?>
                                <button type="button" class="button visualizar-btn" title="Visualizar"
                                    onclick="openFileModal('uploads/<?= $row['arquivo'] ?>')">
                                    Visualizar
                                </button>
                                <a href="uploads/<?= $row['arquivo'] ?>" class="button button-azul" download>
                                    Baixar
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

    <!-- Modal para Visualizar Arquivo -->
    <div class="modal fade" id="fileModal" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="fileModalLabel">Visualizar Arquivo</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
          </div>
          <div class="modal-body" id="fileModalBody" style="min-height: 500px; text-align: center;">
            <!-- O conteúdo do arquivo será carregado aqui -->
          </div>
        </div>
      </div>
    </div>

    <!-- ============ Java Script Files  ================== -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/datatables.min.js"></script>
    <script src="assets/js/pdfmake.min.js"></script>
    <script src="assets/js/vfs_fonts.js"></script>
    <script src="assets/js/custom.js"></script>
    <script>
    function openFileModal(fileUrl) {
        const ext = fileUrl.split('.').pop().toLowerCase();
        let content = '';
        if(['jpg', 'jpeg', 'png', 'avif', 'webp', 'gif', 'bmp'].includes(ext)) {
            content = `<img src="${fileUrl}" alt="Arquivo" style="max-width:100%; max-height:70vh;">`;
        } else if(['mp4', 'webm', 'ogg'].includes(ext)) {
            content = `
                <video controls style="max-width:100%; max-height:70vh;">
                    <source src="${fileUrl}" type="video/${ext}">
                    Seu navegador não suporta a visualização de vídeo.
                </video>
            `;
        } else if(ext === 'pdf') {
            content = `<iframe src="${fileUrl}" style="width:100%; height:70vh;" frameborder="0"></iframe>`;
        } else {
            content = `<a href="${fileUrl}" target="_blank">Baixar arquivo</a>`;
        }
        document.getElementById('fileModalBody').innerHTML = content;
        var myModal = new bootstrap.Modal(document.getElementById('fileModal'));
        myModal.show();
    }
    </script>
</body>
</html>