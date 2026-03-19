<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once 'world_locations.php';

// API endpoint to get states and cities from world locations database
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    
    switch ($action) {
        case 'estados':
            if (isset($_GET['pais'])) {
                getEstados($_GET['pais']);
            }
            break;
        case 'cidades':
            if (isset($_GET['pais']) && isset($_GET['estado'])) {
                getCidades($_GET['pais'], $_GET['estado']);
            }
            break;
        default:
            echo json_encode(['error' => 'Ação inválida']);
    }
}

function getEstados($pais) {
    if ($pais === 'Brasil') {
        // Use IBGE API for Brazil to get all states
        $url = 'https://servicodados.ibge.gov.br/api/v1/localidades/estados';
        $response = file_get_contents($url);
        
        if ($response === FALSE) {
            echo json_encode(['error' => 'Erro ao buscar estados']);
            return;
        }
        
        $estados = json_decode($response, true);
        
        // Sort by name
        usort($estados, function($a, $b) {
            return strcmp($a['nome'], $b['nome']);
        });
        
        echo json_encode($estados);
    } else {
        // Use static data for other countries
        $locations = getWorldLocations();
        
        if (!isset($locations[$pais])) {
            echo json_encode(['error' => 'País não encontrado']);
            return;
        }
        
        $estados = [];
        foreach ($locations[$pais] as $estado => $cidades) {
            $estados[] = ['id' => $estado, 'nome' => $estado];
        }
        
        // Sort by name
        usort($estados, function($a, $b) {
            return strcmp($a['nome'], $b['nome']);
        });
        
        echo json_encode($estados);
    }
}

function getCidades($pais, $estado) {
    if ($pais === 'Brasil') {
        // Use IBGE API for Brazil to get all cities
        $url = "https://servicodados.ibge.gov.br/api/v1/localidades/estados/{$estado}/municipios";
        $response = file_get_contents($url);
        
        if ($response === FALSE) {
            echo json_encode(['error' => 'Erro ao buscar cidades']);
            return;
        }
        
        $cidades = json_decode($response, true);
        
        // Sort by name
        usort($cidades, function($a, $b) {
            return strcmp($a['nome'], $b['nome']);
        });
        
        echo json_encode($cidades);
    } else {
        // Use static data for other countries
        $locations = getWorldLocations();
        
        if (!isset($locations[$pais][$estado])) {
            echo json_encode(['error' => 'Estado não encontrado']);
            return;
        }
        
        $cidades = [];
        foreach ($locations[$pais][$estado] as $cidade) {
            $cidades[] = ['nome' => $cidade];
        }
        
        // Sort by name
        usort($cidades, function($a, $b) {
            return strcmp($a['nome'], $b['nome']);
        });
        
        echo json_encode($cidades);
    }
}
?>
