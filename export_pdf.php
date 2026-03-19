<?php
require_once __DIR__ . '/mpdf/autoload.php'; // Caminho para o autoload manual do mPDF
include 'db.php';

$result = $conn->query("SELECT * FROM users");
$html = '<h2>Usuários</h2><table border="1"><tr><th>ID</th><th>Nome</th><th>Email</th></tr>';
while($row = $result->fetch_assoc()) {
    $html .= "<tr><td>{$row['id']}</td><td>{$row['nome']}</td><td>{$row['email']}</td></tr>";
}
$html .= '</table>';

$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($html);
$mpdf->Output('usuarios.pdf', 'D');
?>