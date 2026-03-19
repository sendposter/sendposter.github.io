<?php
include 'db.php';

$search = $_GET['search'] ?? '';
$sql = "SELECT * FROM users WHERE nome LIKE '%$search%' OR email LIKE '%$search%' ORDER BY id DESC";
$result = $conn->query($sql);
?>

<link rel="stylesheet" href="style.css">
<h2>Listar Usuários</h2>
<a href="create.php" class="button">Cadastrar</a>
<a href="files.php" class="button">Listar Arquivos</a>
<a href="export_pdf.php" class="button">Exportar PDF</a>
<a href="export_excel.php" class="button">Exportar Excel</a></br></br>



<form method="get" class="search-bar">
    <input type="text" name="search" placeholder="Pesquisar..." value="<?= htmlspecialchars($search) ?>">
</br></br>
    <input type="submit" value="Buscar">
</form>



<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/2.3.2/css/dataTables.dataTables.min.css">

<link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.3.2/b-3.2.3/b-html5-3.2.3/b-print-3.2.3/datatables.min.css" rel="stylesheet">



<table style="width:100%">

<table id="myTable">
<thead>
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>E-mail</th>
        <th>Arquivo</th>
        <th>Ações</th>
    </tr>
</thead>






    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['nome']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td>
            <?php if($row['arquivo']): ?>
                <a href="uploads/<?= $row['arquivo'] ?>" target="_blank">Ver Arquivo</a>
            <?php endif; ?>
        </td>
        <td>
            <a href="edit.php?id=<?= $row['id'] ?>" class="edit button">Editar</a>
            <a href="delete.php?id=<?= $row['id'] ?>" class="delete button" onclick="return confirm('Excluir?')">Excluir</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>


<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="//cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js" integrity="sha384-VFQrHzqBh5qiJIU0uGU5CIW3+OWpdGGJM9LBnGbuIH2mkICcFZ7lPd/AAtI7SNf7" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js" integrity="sha384-/RlQG9uf0M2vcTw3CX7fbqgbj/h8wKxw7C3zu9/GxcBPRKOEcESxaxufwRXqzq6n" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.3.2/b-3.2.3/b-html5-3.2.3/b-print-3.2.3/datatables.min.js"></script>



<script>


$(document).ready(function(){
    
    $('#myTable').DataTable({

      dom: 'Bfrtip',
        
        buttons:['copy', 'csv', 'excel', 'pdf', 'print']
        
    });
    
   });



</script>