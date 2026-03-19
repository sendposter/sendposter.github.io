<?php
include 'db.php';

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=usuarios.xls");

echo "ID\tNome\tEmail\n";
$result = $conn->query("SELECT * FROM users");
while($row = $result->fetch_assoc()) {
    echo "{$row['id']}\t{$row['nome']}\t{$row['email']}\n";
}
?>