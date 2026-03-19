<?php
header('Content-Type: text/html; charset=utf-8');
header('Access-Control-Allow-Origin: *');

try {
    // Validate input
    if (!isset($_POST['pais_id']) || !is_numeric($_POST['pais_id'])) {
        echo '<option value="">Erro: ID do país inválido</option>';
        exit;
    }
    
    $paisId = (int)$_POST['pais_id'];
    
    // Database connection
    require_once 'config.php';
    $pdo = getDbConnection();
    
    // Fetch states for the selected country
    $stmt = $pdo->prepare("SELECT id, nome, uf FROM estados WHERE pais_id = ? ORDER BY nome");
    $stmt->execute([$paisId]);
    $estados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Return HTML options
    echo '<option value="">Selecione um estado</option>';
    foreach ($estados as $estado) {
        echo '<option value="' . $estado['id'] . '">' . htmlspecialchars($estado['nome']) . ' (' . $estado['uf'] . ')</option>';
    }
    
} catch (PDOException $e) {
    echo '<option value="">Erro no banco de dados</option>';
} catch (Exception $e) {
    echo '<option value="">Erro no servidor</option>';
}
?> 