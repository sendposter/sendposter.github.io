<!DOCTYPE html>
<html>
  <head>
    <title>Registration Page</title>
    <link rel="stylesheet" type="text/css" href="file/bootstrap.css" />
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  </head>
  <body>
    <div class="container">
      <div class="row col-md-6 col-md-offset-3">
        <div class="panel panel-primary">
          <div class="panel-heading text-center">
            <h1>Formul&aacute;rio de Inscri&ccedil;&atilde;o</h1>
          </div>
          <div class="panel-body">
            <form method="post" enctype="multipart/form-data">
              <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" name="nome" required />
              </div>
              <div class="form-group">
                <label for="cpf">CPF</label>
                <input type="text" class="form-control" name="cpf" id="cpf" required maxlength="14" />
              </div>
              <div class="form-group">
                <label for="arquivo">Arquivo:</label>
                <input type="file" class="form-control" name="arquivo" />
              </div>
              <input type="submit" class="btn btn-primary" value="Enviar" />
            </form>
          </div>
          <div class="panel-footer text-right">
            <small>&copy; Contact Form</small>
          </div>
        </div>
      </div>
    </div>

    <script>
    // Máscara de CPF
    document.getElementById('cpf').addEventListener('input', function (e) {
      let value = e.target.value.replace(/\D/g, '');
      value = value.replace(/(\d{3})(\d)/, '$1.$2');
      value = value.replace(/(\d{3})(\d)/, '$1.$2');
      value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
      e.target.value = value;
    });
    </script>

<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $arquivo = '';

    if (!empty($_FILES['arquivo']['name'])) {
        if (!is_dir('uploads')) {
            mkdir('uploads', 0777, true);
        }
        $arquivo = uniqid() . '_' . basename($_FILES['arquivo']['name']);
        move_uploaded_file($_FILES['arquivo']['tmp_name'], 'uploads/' . $arquivo);
    }

    $stmt = $conn->prepare("INSERT INTO users (nome, cpf, arquivo) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nome, $cpf, $arquivo);
    $stmt->execute();

    // SweetAlert2 animado e redirecionamento após 3 segundos
    echo "<script>
    Swal.fire({
      title: 'Formulário enviado com sucesso!',
      icon: 'success',
      showClass: {
        popup: 'animate__animated animate__fadeInDown'
      },
      hideClass: {
        popup: 'animate__animated animate__fadeOutUp'
      },
      timer: 3000,
      showConfirmButton: false
    }).then(function() {
      window.location = 'create.php';
    });
    </script>";
}
?>
  </body>
</html>