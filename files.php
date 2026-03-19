<?php
include 'db.php';
$result = $conn->query("SELECT * FROM users WHERE arquivo IS NOT NULL AND arquivo != ''");
?>

<link rel="stylesheet" href="style.css">
<h2>Arquivos Enviados</h2>
<a href="index.php" class="button">Voltar</a>
<table>
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Arquivo</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['nome']) ?></td>
        <td><a href="uploads/<?= $row['arquivo'] ?>" target="_blank"><?= $row['arquivo'] ?></a></td>
    </tr>
    <?php endwhile; ?>
</table>