<?php
session_start();

// Database configuration
$host = "localhost";
$user = "root";
$password = "";
$database = "model";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $cnpj = $_POST['cnpj'];
    $pais = $_POST['pais'];
    $estado = $_POST['estado'];
    $cidade = $_POST['cidade'];
    $arquivo = '';

    // Verifica se há arquivo e se está dentro do limite
    if (!empty($_FILES['arquivo']['name'])) {
        if ($_FILES['arquivo']['size'] > 100 * 1024 * 1024) { // 100 MB
            echo "<script>
            Swal.fire({
              title: 'Arquivo muito grande!',
              text: 'O limite máximo de upload é 100 MB.',
              icon: 'error',
              showClass: {
                popup: 'animate__animated animate__shakeX'
              }
            });
            </script>";
        } else {
            if (!is_dir('uploads')) {
                mkdir('uploads', 0777, true);
            }
            $arquivo = uniqid() . '_' . basename($_FILES['arquivo']['name']);
            move_uploaded_file($_FILES['arquivo']['tmp_name'], 'uploads/' . $arquivo);
        }
    }
   
    // Insere no banco apenas se não houve erro
    if (empty($_FILES['arquivo']['name']) || $_FILES['arquivo']['size'] <= 100 * 1024 * 1024) {
        $stmt = $conn->prepare("INSERT INTO users (nome, cpf, cnpj, pais, estado, cidade, arquivo) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $nome, $cpf, $cnpj, $pais, $estado, $cidade, $arquivo);
        $stmt->execute();
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
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Inscrição</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }
        .header-custom {
            background: #2308f2 !important;
            color: #fff !important;
            padding: 24px 0 16px 0;
            border-radius: 8px 8px 0 0;
            margin-bottom: 0;
        }
        .header-custom h1 {
            color: #fff !important;
            margin: 0;
        }
        .btn-custom {
            background-color: #2308f2 !important;
            color: #fff !important;
            border: none;
            font-weight: 500;
            transition: background 0.2s;
            padding: 12px 30px;
        }
        .btn-custom:hover, .btn-custom:focus {
            background-color: #1805a7 !important;
            color: #fff !important;
        }
        .form-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            margin-top: 30px;
            overflow: hidden;
        }
        .panel-body {
            padding: 30px;
        }
        .panel-footer {
            background-color: #f8f9fa;
            padding: 15px 30px;
            border-top: 1px solid #dee2e6;
        }
        .btn-custom:disabled {
            background-color: #6c757d !important;
            cursor: not-allowed;
        }
        .file-blocked {
            border: 2px solid #dc3545 !important;
            background-color: #f8d7da !important;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="form-container">
                    <div class="header-custom text-center">
                        <h1>Formulário de Inscrição</h1>
                    </div>
                    
                    <div class="panel-body">
                        <form method="POST" enctype="multipart/form-data" id="formInscricao">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nome" class="form-label">Nome *</label>
                                    <input type="text" class="form-control" name="nome" id="nome" 
                                           value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>" required>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="cpf" class="form-label">CPF *</label>
                                    <input type="text" class="form-control" id="cpf" name="cpf" 
                                           placeholder="000.000.000-00" maxlength="14" 
                                           value="<?= htmlspecialchars($_POST['cpf'] ?? '') ?>" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="cnpj" class="form-label">CNPJ</label>
                                    <input type="text" class="form-control" id="cnpj" name="cnpj" 
                                           placeholder="00.000.000/0000-00" maxlength="18"
                                           value="<?= htmlspecialchars($_POST['cnpj'] ?? '') ?>">
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="arquivo" class="form-label">Arquivo</label>
                                    <input type="file" class="form-control" name="arquivo" id="arquivo">
                                    <div class="form-text">Máximo 100MB. Tipos permitidos: jpg, jpeg, png, gif, pdf, doc, docx, mp4, webm, ogg, txt, csv</div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="pais" class="form-label">País *</label>
                                    <select class="form-select" id="pais" name="pais" required>
                                        <option value="">Carregando países...</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label for="estado" class="form-label">Estado *</label>
                                    <select class="form-select" id="estado" name="estado" required disabled>
                                        <option value="">Primeiro selecione o país</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label for="cidade" class="form-label">Cidade *</label>
                                    <select class="form-select" id="cidade" name="cidade" required disabled>
                                        <option value="">Primeiro selecione o estado</option>
                                    </select>
                                </div>
                            </div>
                            
                          
                          
                          
                          
                           <div class="text-center mt-4">
                                <button type="submit" class="btn btn-custom" id="submitBtn">Enviar Formulário</button>
                            </div>
                        </form>
                    </div>
                    
                    <div class="panel-footer text-end">
                        <small>&copy; Contact Form</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
                          
                          
                          
                          
                          
                          

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        let countriesData = {};
        let statesData = {};
        let citiesData = {};
        

        document.addEventListener('DOMContentLoaded', function() {
            // Check if required elements exist
            const paisSelect = document.getElementById('pais');
            const estadoSelect = document.getElementById('estado');
            const cidadeSelect = document.getElementById('cidade');
            
            if (!paisSelect || !estadoSelect || !cidadeSelect) {
                console.error('Required select elements not found');
                return;
            }

            // Máscaras CPF e CNPJ
            const cpfInput = document.getElementById('cpf');
            if (cpfInput) {
                cpfInput.addEventListener('input', function(e) {
                    let v = e.target.value.replace(/\D/g, '').substring(0, 11);
                    v = v.replace(/(\d{3})(\d)/, '$1.$2');
                    v = v.replace(/(\d{3})(\d)/, '$1.$2');
                    v = v.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
                    e.target.value = v;
                });
            }

            const cnpjInput = document.getElementById('cnpj');
            if (cnpjInput) {
                cnpjInput.addEventListener('input', function(e) {
                    let v = e.target.value.replace(/\D/g, '').substring(0, 14);
                    v = v.replace(/(\d{2})(\d)/, '$1.$2');
                    v = v.replace(/(\d{3})(\d)/, '$1.$2');
                    v = v.replace(/(\d{3})(\d)/, '$1/$2');
                    v = v.replace(/(\d{4})(\d{1,2})$/, '$1-$2');
                    e.target.value = v;
                });
            }

            loadAllLocationData();
        });

        async function loadAllLocationData() {
            try {
                // Show loading state
                const paisSelect = document.getElementById('pais');
                const estadoSelect = document.getElementById('estado');
                const cidadeSelect = document.getElementById('cidade');
                
                paisSelect.innerHTML = '<option value="">Carregando países...</option>';
                estadoSelect.innerHTML = '<option value="">Aguarde...</option>';
                cidadeSelect.innerHTML = '<option value="">Aguarde...</option>';
                
                let countries, states, cities;
                
                // Try multiple reliable data sources
                try {
                    // Source 1: REST Countries API for comprehensive country data
                    const countriesResponse = await fetch('https://restcountries.com/v3.1/all');
                    if (countriesResponse.ok) {
                        const countriesData = await countriesResponse.json();
                        countries = countriesData.map(country => ({
                            id: country.cca2 || country.cca3,
                            name: country.translations?.por?.common || country.name.common || country.name,
                            subdivisions: country.subdivisions || []
                        }));
                        console.log('Loaded countries from REST Countries API:', countries.length);
                    } else {
                        throw new Error('REST Countries API failed');
                    }
                } catch (restError) {
                    console.warn('REST Countries API failed, trying alternative:', restError);
                    
                    // Source 2: GitHub countries-states-cities-database
                    try {
                        const [countriesRes, statesRes, citiesRes] = await Promise.all([
                            fetch('https://raw.githubusercontent.com/dr5hn/countries-states-cities-database/master/json/countries.json'),
                            fetch('https://raw.githubusercontent.com/dr5hn/countries-states-cities-database/master/json/states.json'),
                            fetch('https://raw.githubusercontent.com/dr5hn/countries-states-cities-database/master/json/cities.json')
                        ]);

                        if (!countriesRes.ok || !statesRes.ok || !citiesRes.ok) {
                            throw new Error('GitHub API failed');
                        }

                        [countries, states, cities] = await Promise.all([
                            countriesRes.json(),
                            statesRes.json(),
                            citiesRes.json()
                        ]);
                        
                        console.log('Loaded from GitHub database:', countries.length, 'countries');
                    } catch (githubError) {
                        console.warn('GitHub API failed, trying CDN:', githubError);
                        
                        // Source 3: CDN fallback
                        try {
                            const response = await fetch('https://cdn.jsdelivr.net/npm/@dr5hn/countries-states-cities-database@1.0.0/json/countries.json');
                            if (!response.ok) throw new Error('CDN failed');
                            countries = await response.json();
                            
                            // Try to get states and cities separately
                            try {
                                const [statesRes, citiesRes] = await Promise.all([
                                    fetch('https://cdn.jsdelivr.net/npm/@dr5hn/countries-states-cities-database@1.0.0/json/states.json'),
                                    fetch('https://cdn.jsdelivr.net/npm/@dr5hn/countries-states-cities-database@1.0.0/json/cities.json')
                                ]);
                                
                                if (statesRes.ok && citiesRes.ok) {
                                    [states, cities] = await Promise.all([
                                        statesRes.json(),
                                        citiesRes.json()
                                    ]);
                                }
                            } catch (stateCityError) {
                                console.warn('Could not load states/cities from CDN:', stateCityError);
                                states = [];
                                cities = [];
                            }
                            
                            console.log('Loaded from CDN:', countries.length, 'countries');
                        } catch (cdnError) {
                            throw new Error('All data sources failed');
                        }
                    }
                }

                // Process and index the data
                if (countries && countries.length > 0) {
                    // Index countries
                    countries.forEach(c => {
                        if (c.id && c.name) {
                            countriesData[c.id] = c;
                        }
                    });
                    
                    // Index states if available
                    if (states && states.length > 0) {
                        states.forEach(s => {
                            if (s.country_id && s.id && s.name) {
                                if (!statesData[s.country_id]) statesData[s.country_id] = [];
                                statesData[s.country_id].push(s);
                            }
                        });
                        console.log('Indexed states for', Object.keys(statesData).length, 'countries');
                    }
                    
                    // Index cities if available
                    if (cities && cities.length > 0) {
                        cities.forEach(c => {
                            if (c.state_id && c.id && c.name) {
                                if (!citiesData[c.state_id]) citiesData[c.state_id] = [];
                                citiesData[c.state_id].push(c);
                            }
                        });
                        console.log('Indexed cities for', Object.keys(citiesData).length, 'states');
                    }
                    
                    populateCountries();
                } else {
                    throw new Error('No country data loaded');
                }
                
            } catch (error) {
                console.error('Error loading location data:', error);
                // Comprehensive fallback with all countries
                loadComprehensiveFallbackCountries();
            }
        }

        function loadComprehensiveFallbackCountries() {
            const comprehensiveCountries = [
                { id: 'AF', name: 'Afeganistão' },
                { id: 'AL', name: 'Albânia' },
                { id: 'DE', name: 'Alemanha' },
                { id: 'AD', name: 'Andorra' },
                { id: 'AO', name: 'Angola' },
                { id: 'AI', name: 'Anguila' },
                { id: 'AQ', name: 'Antártida' },
                { id: 'AG', name: 'Antígua e Barbuda' },
                { id: 'SA', name: 'Arábia Saudita' },
                { id: 'DZ', name: 'Argélia' },
                { id: 'AR', name: 'Argentina' },
                { id: 'AM', name: 'Armênia' },
                { id: 'AW', name: 'Aruba' },
                { id: 'AU', name: 'Austrália' },
                { id: 'AT', name: 'Áustria' },
                { id: 'AZ', name: 'Azerbaijão' },
                { id: 'BS', name: 'Bahamas' },
                { id: 'BD', name: 'Bangladesh' },
                { id: 'BB', name: 'Barbados' },
                { id: 'BH', name: 'Barein' },
                { id: 'BE', name: 'Bélgica' },
                { id: 'BZ', name: 'Belize' },
                { id: 'BJ', name: 'Benin' },
                { id: 'BM', name: 'Bermudas' },
                { id: 'BY', name: 'Bielorrússia' },
                { id: 'BO', name: 'Bolívia' },
                { id: 'BA', name: 'Bósnia e Herzegovina' },
                { id: 'BW', name: 'Botsuana' },
                { id: 'BR', name: 'Brasil' },
                { id: 'BN', name: 'Brunei' },
                { id: 'BG', name: 'Bulgária' },
                { id: 'BF', name: 'Burkina Faso' },
                { id: 'BI', name: 'Burundi' },
                { id: 'BT', name: 'Butão' },
                { id: 'CV', name: 'Cabo Verde' },
                { id: 'KH', name: 'Camboja' },
                { id: 'CA', name: 'Canadá' },
                { id: 'CW', name: 'Curaçao' },
                { id: 'QA', name: 'Catar' },
                { id: 'KZ', name: 'Cazaquistão' },
                { id: 'TD', name: 'Chade' },
                { id: 'CL', name: 'Chile' },
                { id: 'CN', name: 'China' },
                { id: 'CY', name: 'Chipre' },
                { id: 'CO', name: 'Colômbia' },
                { id: 'KM', name: 'Comores' },
                { id: 'CG', name: 'Congo - Brazzaville' },
                { id: 'CD', name: 'Congo - Kinshasa' },
                { id: 'KP', name: 'Coreia do Norte' },
                { id: 'KR', name: 'Coreia do Sul' },
                { id: 'CI', name: 'Costa do Marfim' },
                { id: 'CR', name: 'Costa Rica' },
                { id: 'HR', name: 'Croácia' },
                { id: 'CU', name: 'Cuba' },
                { id: 'DK', name: 'Dinamarca' },
                { id: 'DJ', name: 'Djibouti' },
                { id: 'DM', name: 'Dominica' },
                { id: 'EG', name: 'Egito' },
                { id: 'SV', name: 'El Salvador' },
                { id: 'AE', name: 'Emirados Árabes Unidos' },
                { id: 'EC', name: 'Equador' },
                { id: 'ER', name: 'Eritreia' },
                { id: 'SK', name: 'Eslováquia' },
                { id: 'SI', name: 'Eslovênia' },
                { id: 'ES', name: 'Espanha' },
                { id: 'US', name: 'Estados Unidos' },
                { id: 'EE', name: 'Estônia' },
                { id: 'ET', name: 'Etiópia' },
                { id: 'FJ', name: 'Fiji' },
                { id: 'PH', name: 'Filipinas' },
                { id: 'FI', name: 'Finlândia' },
                { id: 'FR', name: 'França' },
                { id: 'GA', name: 'Gabão' },
                { id: 'GM', name: 'Gâmbia' },
                { id: 'GH', name: 'Gana' },
                { id: 'GE', name: 'Geórgia' },
                { id: 'GI', name: 'Gibraltar' },
                { id: 'GD', name: 'Granada' },
                { id: 'GR', name: 'Grécia' },
                { id: 'GL', name: 'Groenlândia' },
                { id: 'GP', name: 'Guadalupe' },
                { id: 'GU', name: 'Guam' },
                { id: 'GT', name: 'Guatemala' },
                { id: 'GG', name: 'Guernsey' },
                { id: 'GY', name: 'Guiana' },
                { id: 'GF', name: 'Guiana Francesa' },
                { id: 'GW', name: 'Guiné-Bissau' },
                { id: 'GQ', name: 'Guiné Equatorial' },
                { id: 'HT', name: 'Haiti' },
                { id: 'HN', name: 'Honduras' },
                { id: 'HK', name: 'Hong Kong' },
                { id: 'HU', name: 'Hungria' },
                { id: 'YE', name: 'Iêmen' },
                { id: 'IM', name: 'Ilha de Man' },
                { id: 'NF', name: 'Ilha Norfolk' },
                { id: 'CX', name: 'Ilha Christmas' },
                { id: 'KY', name: 'Ilhas Cayman' },
                { id: 'CC', name: 'Ilhas Cocos' },
                { id: 'CK', name: 'Ilhas Cook' },
                { id: 'FK', name: 'Ilhas Malvinas' },
                { id: 'MP', name: 'Ilhas Marianas do Norte' },
                { id: 'MH', name: 'Ilhas Marshall' },
                { id: 'SB', name: 'Ilhas Salomão' },
                { id: 'TC', name: 'Ilhas Turks e Caicos' },
                { id: 'VI', name: 'Ilhas Virgens Americanas' },
                { id: 'VG', name: 'Ilhas Virgens Britânicas' },
                { id: 'IN', name: 'Índia' },
                { id: 'ID', name: 'Indonésia' },
                { id: 'IR', name: 'Irã' },
                { id: 'IQ', name: 'Iraque' },
                { id: 'IE', name: 'Irlanda' },
                { id: 'IS', name: 'Islândia' },
                { id: 'IL', name: 'Israel' },
                { id: 'IT', name: 'Itália' },
                { id: 'JM', name: 'Jamaica' },
                { id: 'JP', name: 'Japão' },
                { id: 'JE', name: 'Jersey' },
                { id: 'JO', name: 'Jordânia' },
                { id: 'KW', name: 'Kuwait' },
                { id: 'LA', name: 'Laos' },
                { id: 'LS', name: 'Lesoto' },
                { id: 'LV', name: 'Letônia' },
                { id: 'LB', name: 'Líbano' },
                { id: 'LR', name: 'Libéria' },
                { id: 'LY', name: 'Líbia' },
                { id: 'LI', name: 'Liechtenstein' },
                { id: 'LT', name: 'Lituânia' },
                { id: 'LU', name: 'Luxemburgo' },
                { id: 'MO', name: 'Macau' },
                { id: 'MK', name: 'Macedônia do Norte' },
                { id: 'MG', name: 'Madagascar' },
                { id: 'MY', name: 'Malásia' },
                { id: 'MW', name: 'Malaui' },
                { id: 'MV', name: 'Maldivas' },
                { id: 'ML', name: 'Mali' },
                { id: 'MT', name: 'Malta' },
                { id: 'MA', name: 'Marrocos' },
                { id: 'MQ', name: 'Martinica' },
                { id: 'MU', name: 'Maurício' },
                { id: 'MR', name: 'Mauritânia' },
                { id: 'YT', name: 'Mayotte' },
                { id: 'MX', name: 'México' },
                { id: 'MM', name: 'Mianmar' },
                { id: 'FM', name: 'Micronésia' },
                { id: 'MZ', name: 'Moçambique' },
                { id: 'MD', name: 'Moldávia' },
                { id: 'MC', name: 'Mônaco' },
                { id: 'MN', name: 'Mongólia' },
                { id: 'ME', name: 'Montenegro' },
                { id: 'MS', name: 'Montserrat' },
                { id: 'NA', name: 'Namíbia' },
                { id: 'NR', name: 'Nauru' },
                { id: 'NP', name: 'Nepal' },
                { id: 'NI', name: 'Nicarágua' },
                { id: 'NE', name: 'Níger' },
                { id: 'NG', name: 'Nigéria' },
                { id: 'NU', name: 'Niue' },
                { id: 'NO', name: 'Noruega' },
                { id: 'NC', name: 'Nova Caledônia' },
                { id: 'NZ', name: 'Nova Zelândia' },
                { id: 'OM', name: 'Omã' },
                { id: 'NL', name: 'Países Baixos' },
                { id: 'PW', name: 'Palau' },
                { id: 'PA', name: 'Panamá' },
                { id: 'PG', name: 'Papua Nova Guiné' },
                { id: 'PK', name: 'Paquistão' },
                { id: 'PY', name: 'Paraguai' },
                { id: 'PE', name: 'Peru' },
                { id: 'PF', name: 'Polinésia Francesa' },
                { id: 'PL', name: 'Polônia' },
                { id: 'PR', name: 'Porto Rico' },
                { id: 'PT', name: 'Portugal' },
                { id: 'KE', name: 'Quênia' },
                { id: 'KG', name: 'Quirguistão' },
                { id: 'GB', name: 'Reino Unido' },
                { id: 'CF', name: 'República Centro-Africana' },
                { id: 'CZ', name: 'República Tcheca' },
                { id: 'DO', name: 'República Dominicana' },
                { id: 'RE', name: 'Reunião' },
                { id: 'RO', name: 'Romênia' },
                { id: 'RW', name: 'Ruanda' },
                { id: 'RU', name: 'Rússia' },
                { id: 'WS', name: 'Samoa' },
                { id: 'AS', name: 'Samoa Americana' },
                { id: 'SM', name: 'San Marino' },
                { id: 'ST', name: 'São Tomé e Príncipe' },
                { id: 'SN', name: 'Senegal' },
                { id: 'RS', name: 'Sérvia' },
                { id: 'SC', name: 'Seicheles' },
                { id: 'SL', name: 'Serra Leoa' },
                { id: 'SG', name: 'Singapura' },
                { id: 'SX', name: 'Sint Maarten' },
                { id: 'SY', name: 'Síria' },
                { id: 'SO', name: 'Somália' },
                { id: 'LK', name: 'Sri Lanka' },
                { id: 'SZ', name: 'Suazilândia' },
                { id: 'SD', name: 'Sudão' },
                { id: 'SS', name: 'Sudão do Sul' },
                { id: 'SE', name: 'Suécia' },
                { id: 'CH', name: 'Suíça' },
                { id: 'SR', name: 'Suriname' },
                { id: 'SJ', name: 'Svalbard e Jan Mayen' },
                { id: 'TH', name: 'Tailândia' },
                { id: 'TW', name: 'Taiwan' },
                { id: 'TJ', name: 'Tajiquistão' },
                { id: 'TZ', name: 'Tanzânia' },
                { id: 'TL', name: 'Timor-Leste' },
                { id: 'TG', name: 'Togo' },
                { id: 'TK', name: 'Tokelau' },
                { id: 'TO', name: 'Tonga' },
                { id: 'TT', name: 'Trinidad e Tobago' },
                { id: 'TN', name: 'Tunísia' },
                { id: 'TM', name: 'Turcomenistão' },
                { id: 'TR', name: 'Turquia' },
                { id: 'TV', name: 'Tuvalu' },
                { id: 'UA', name: 'Ucrânia' },
                { id: 'UG', name: 'Uganda' },
                { id: 'UY', name: 'Uruguai' },
                { id: 'UZ', name: 'Uzbequistão' },
                { id: 'VU', name: 'Vanuatu' },
                { id: 'VA', name: 'Vaticano' },
                { id: 'VE', name: 'Venezuela' },
                { id: 'VN', name: 'Vietnã' },
                { id: 'WF', name: 'Wallis e Futuna' },
                { id: 'ZM', name: 'Zâmbia' },
                { id: 'ZW', name: 'Zimbábue' },
                { id: 'BQ', name: 'Bonaire, Santo Eustáquio, Saba' },
                { id: 'SX', name: 'São Martinho (Países Baixos)' },
                { id: 'XK', name: 'Kosovo' }
            ];

            const paisSelect = document.getElementById('pais');
            if (!paisSelect) {
                console.error('Elemento pais não encontrado');
                return;
            }
            
            paisSelect.innerHTML = '<option value="">Selecione o país</option>';
            
            comprehensiveCountries.forEach(country => {
                const option = document.createElement('option');
                option.value = country.name;
                option.textContent = country.name;
                option.dataset.countryId = country.id;
                paisSelect.appendChild(option);
            });

            // Enable estado and cidade with fallback behavior
            const estadoSelect = document.getElementById('estado');
            const cidadeSelect = document.getElementById('cidade');
            
            if (estadoSelect) {
                estadoSelect.disabled = false;
                estadoSelect.innerHTML = '<option value="">Selecione o estado/província</option>';
            }
            
            if (cidadeSelect) {
                cidadeSelect.disabled = false;
                cidadeSelect.innerHTML = '<option value="">Selecione a cidade</option>';
            }

            // Add change event listener for pais
            paisSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const countryId = selectedOption.dataset.countryId;
                populateFallbackStates(countryId);
            });
        }

        async function loadCountrySubdivisions(countryCode) {
            try {
                // Try to get subdivisions from GeoNames API
                const geoNamesResponse = await fetch(`http://api.geonames.org/childrenJSON?geonameId=${getCountryGeoNameId(countryCode)}&username=demo`);
                if (geoNamesResponse.ok) {
                    const data = await geoNamesResponse.json();
                    return data.geonames.map(geo => ({
                        id: geo.geonameId.toString(),
                        name: geo.name,
                        country_id: countryCode
                    }));
                }
            } catch (error) {
                console.warn('GeoNames API failed for', countryCode, error);
            }
            
            // Fallback to hardcoded subdivisions for major countries
            return getHardcodedSubdivisions(countryCode);
        }

        function getCountryGeoNameId(countryCode) {
            const geoNameIds = {
                'BR': '3469034',
                'US': '6252001',
                'CA': '6251999',
                'MX': '3996063',
                'AR': '3865483',
                'AU': '2077456',
                'DE': '2921044',
                'FR': '3017382',
                'IT': '3175395',
                'ES': '2510769',
                'GB': '2635167',
                'CN': '1814991',
                'IN': '1269750',
                'JP': '1861060',
                'RU': '2017370',
                'BR': '3469034',
                'CW': '7626846'
            };
            return geoNameIds[countryCode] || '';
        }

        function getHardcodedSubdivisions(countryCode) {
            const subdivisions = {
                'BR': [
                    { id: 'AC', name: 'Acre', country_id: 'BR' },
                    { id: 'AL', name: 'Alagoas', country_id: 'BR' },
                    { id: 'AP', name: 'Amapá', country_id: 'BR' },
                    { id: 'AM', name: 'Amazonas', country_id: 'BR' },
                    { id: 'BA', name: 'Bahia', country_id: 'BR' },
                    { id: 'CE', name: 'Ceará', country_id: 'BR' },
                    { id: 'DF', name: 'Distrito Federal', country_id: 'BR' },
                    { id: 'ES', name: 'Espírito Santo', country_id: 'BR' },
                    { id: 'GO', name: 'Goiás', country_id: 'BR' },
                    { id: 'MA', name: 'Maranhão', country_id: 'BR' },
                    { id: 'MT', name: 'Mato Grosso', country_id: 'BR' },
                    { id: 'MS', name: 'Mato Grosso do Sul', country_id: 'BR' },
                    { id: 'MG', name: 'Minas Gerais', country_id: 'BR' },
                    { id: 'PA', name: 'Pará', country_id: 'BR' },
                    { id: 'PB', name: 'Paraíba', country_id: 'BR' },
                    { id: 'PR', name: 'Paraná', country_id: 'BR' },
                    { id: 'PE', name: 'Pernambuco', country_id: 'BR' },
                    { id: 'PI', name: 'Piauí', country_id: 'BR' },
                    { id: 'RJ', name: 'Rio de Janeiro', country_id: 'BR' },
                    { id: 'RN', name: 'Rio Grande do Norte', country_id: 'BR' },
                    { id: 'RS', name: 'Rio Grande do Sul', country_id: 'BR' },
                    { id: 'RO', name: 'Rondônia', country_id: 'BR' },
                    { id: 'RR', name: 'Roraima', country_id: 'BR' },
                    { id: 'SC', name: 'Santa Catarina', country_id: 'BR' },
                    { id: 'SP', name: 'São Paulo', country_id: 'BR' },
                    { id: 'SE', name: 'Sergipe', country_id: 'BR' },
                    { id: 'TO', name: 'Tocantins', country_id: 'BR' }
                ],
                'US': [
                    { id: 'AL', name: 'Alabama', country_id: 'US' },
                    { id: 'AK', name: 'Alaska', country_id: 'US' },
                    { id: 'AZ', name: 'Arizona', country_id: 'US' },
                    { id: 'AR', name: 'Arkansas', country_id: 'US' },
                    { id: 'CA', name: 'California', country_id: 'US' },
                    { id: 'CO', name: 'Colorado', country_id: 'US' },
                    { id: 'CT', name: 'Connecticut', country_id: 'US' },
                    { id: 'DE', name: 'Delaware', country_id: 'US' },
                    { id: 'FL', name: 'Florida', country_id: 'US' },
                    { id: 'GA', name: 'Georgia', country_id: 'US' },
                    { id: 'HI', name: 'Hawaii', country_id: 'US' },
                    { id: 'ID', name: 'Idaho', country_id: 'US' },
                    { id: 'IL', name: 'Illinois', country_id: 'US' },
                    { id: 'IN', name: 'Indiana', country_id: 'US' },
                    { id: 'IA', name: 'Iowa', country_id: 'US' },
                    { id: 'KS', name: 'Kansas', country_id: 'US' },
                    { id: 'KY', name: 'Kentucky', country_id: 'US' },
                    { id: 'LA', name: 'Louisiana', country_id: 'US' },
                    { id: 'ME', name: 'Maine', country_id: 'US' },
                    { id: 'MD', name: 'Maryland', country_id: 'US' },
                    { id: 'MA', name: 'Massachusetts', country_id: 'US' },
                    { id: 'MI', name: 'Michigan', country_id: 'US' },
                    { id: 'MN', name: 'Minnesota', country_id: 'US' },
                    { id: 'MS', name: 'Mississippi', country_id: 'US' },
                    { id: 'MO', name: 'Missouri', country_id: 'US' },
                    { id: 'MT', name: 'Montana', country_id: 'US' },
                    { id: 'NE', name: 'Nebraska', country_id: 'US' },
                    { id: 'NV', name: 'Nevada', country_id: 'US' },
                    { id: 'NH', name: 'New Hampshire', country_id: 'US' },
                    { id: 'NJ', name: 'New Jersey', country_id: 'US' },
                    { id: 'NM', name: 'New Mexico', country_id: 'US' },
                    { id: 'NY', name: 'New York', country_id: 'US' },
                    { id: 'NC', name: 'North Carolina', country_id: 'US' },
                    { id: 'ND', name: 'North Dakota', country_id: 'US' },
                    { id: 'OH', name: 'Ohio', country_id: 'US' },
                    { id: 'OK', name: 'Oklahoma', country_id: 'US' },
                    { id: 'OR', name: 'Oregon', country_id: 'US' },
                    { id: 'PA', name: 'Pennsylvania', country_id: 'US' },
                    { id: 'RI', name: 'Rhode Island', country_id: 'US' },
                    { id: 'SC', name: 'South Carolina', country_id: 'US' },
                    { id: 'SD', name: 'South Dakota', country_id: 'US' },
                    { id: 'TN', name: 'Tennessee', country_id: 'US' },
                    { id: 'TX', name: 'Texas', country_id: 'US' },
                    { id: 'UT', name: 'Utah', country_id: 'US' },
                    { id: 'VT', name: 'Vermont', country_id: 'US' },
                    { id: 'VA', name: 'Virginia', country_id: 'US' },
                    { id: 'WA', name: 'Washington', country_id: 'US' },
                    { id: 'WV', name: 'West Virginia', country_id: 'US' },
                    { id: 'WI', name: 'Wisconsin', country_id: 'US' },
                    { id: 'WY', name: 'Wyoming', country_id: 'US' }
                ],
                'CA': [
                    { id: 'AB', name: 'Alberta', country_id: 'CA' },
                    { id: 'BC', name: 'British Columbia', country_id: 'CA' },
                    { id: 'MB', name: 'Manitoba', country_id: 'CA' },
                    { id: 'NB', name: 'New Brunswick', country_id: 'CA' },
                    { id: 'NL', name: 'Newfoundland and Labrador', country_id: 'CA' },
                    { id: 'NS', name: 'Nova Scotia', country_id: 'CA' },
                    { id: 'ON', name: 'Ontario', country_id: 'CA' },
                    { id: 'PE', name: 'Prince Edward Island', country_id: 'CA' },
                    { id: 'QC', name: 'Quebec', country_id: 'CA' },
                    { id: 'SK', name: 'Saskatchewan', country_id: 'CA' }
                ],
                'MX': [
                    { id: 'AG', name: 'Aguascalientes', country_id: 'MX' },
                    { id: 'BC', name: 'Baja California', country_id: 'MX' },
                    { id: 'BS', name: 'Baja California Sur', country_id: 'MX' },
                    { id: 'CM', name: 'Campeche', country_id: 'MX' },
                    { id: 'CO', name: 'Coahuila', country_id: 'MX' },
                    { id: 'CL', name: 'Colima', country_id: 'MX' },
                    { id: 'CS', name: 'Chiapas', country_id: 'MX' },
                    { id: 'CH', name: 'Chihuahua', country_id: 'MX' },
                    { id: 'DF', name: 'Ciudad de México', country_id: 'MX' },
                    { id: 'DG', name: 'Durango', country_id: 'MX' },
                    { id: 'GT', name: 'Guanajuato', country_id: 'MX' },
                    { id: 'GR', name: 'Guerrero', country_id: 'MX' },
                    { id: 'HG', name: 'Hidalgo', country_id: 'MX' },
                    { id: 'JA', name: 'Jalisco', country_id: 'MX' },
                    { id: 'EM', name: 'Estado de México', country_id: 'MX' },
                    { id: 'MI', name: 'Michoacán', country_id: 'MX' },
                    { id: 'MO', name: 'Morelos', country_id: 'MX' },
                    { id: 'NA', name: 'Nayarit', country_id: 'MX' },
                    { id: 'NL', name: 'Nuevo León', country_id: 'MX' },
                    { id: 'OA', name: 'Oaxaca', country_id: 'MX' },
                    { id: 'PU', name: 'Puebla', country_id: 'MX' },
                    { id: 'QT', name: 'Querétaro', country_id: 'MX' },
                    { id: 'QR', name: 'Quintana Roo', country_id: 'MX' },
                    { id: 'SL', name: 'San Luis Potosí', country_id: 'MX' },
                    { id: 'SI', name: 'Sinaloa', country_id: 'MX' },
                    { id: 'SO', name: 'Sonora', country_id: 'MX' },
                    { id: 'TB', name: 'Tabasco', country_id: 'MX' },
                    { id: 'TM', name: 'Tamaulipas', country_id: 'MX' },
                    { id: 'TL', name: 'Tlaxcala', country_id: 'MX' },
                    { id: 'VE', name: 'Veracruz', country_id: 'MX' },
                    { id: 'YU', name: 'Yucatán', country_id: 'MX' },
                    { id: 'ZA', name: 'Zacatecas', country_id: 'MX' }
                ],
                'CW': [
                    { id: 'CU', name: 'Curaçao', country_id: 'CW' }
                ],
                'AR': [
                    { id: 'BA', name: 'Buenos Aires', country_id: 'AR' },
                    { id: 'CT', name: 'Catamarca', country_id: 'AR' },
                    { id: 'CC', name: 'Chaco', country_id: 'AR' },
                    { id: 'CH', name: 'Chubut', country_id: 'AR' },
                    { id: 'CB', name: 'Córdoba', country_id: 'AR' },
                    { id: 'CR', name: 'Corrientes', country_id: 'AR' },
                    { id: 'ER', name: 'Entre Ríos', country_id: 'AR' },
                    { id: 'FO', name: 'Formosa', country_id: 'AR' },
                    { id: 'JY', name: 'Jujuy', country_id: 'AR' },
                    { id: 'LP', name: 'La Pampa', country_id: 'AR' },
                    { id: 'LR', name: 'La Rioja', country_id: 'AR' },
                    { id: 'MZ', name: 'Mendoza', country_id: 'AR' },
                    { id: 'MI', name: 'Misiones', country_id: 'AR' },
                    { id: 'NQ', name: 'Neuquén', country_id: 'AR' },
                    { id: 'RN', name: 'Río Negro', country_id: 'AR' },
                    { id: 'SA', name: 'Salta', country_id: 'AR' },
                    { id: 'SJ', name: 'San Juan', country_id: 'AR' },
                    { id: 'SL', name: 'San Luis', country_id: 'AR' },
                    { id: 'SC', name: 'Santa Cruz', country_id: 'AR' },
                    { id: 'SF', name: 'Santa Fe', country_id: 'AR' },
                    { id: 'SE', name: 'Santiago del Estero', country_id: 'AR' },
                    { id: 'TF', name: 'Tierra del Fuego', country_id: 'AR' },
                    { id: 'TU', name: 'Tucumán', country_id: 'AR' }
                ]
            };
            
            return subdivisions[countryCode] || [];
        }
            const estadoSelect = document.getElementById('estado');
            const cidadeSelect = document.getElementById('cidade');
            
            if (!estadoSelect || !cidadeSelect) {
                console.error('Elementos estado ou cidade não encontrados');
                return;
            }

            // Define states for major countries
            const statesByCountry = {
                'BR': [
                    { id: 'AC', name: 'Acre' },
                    { id: 'AL', name: 'Alagoas' },
                    { id: 'AP', name: 'Amapá' },
                    { id: 'AM', name: 'Amazonas' },
                    { id: 'BA', name: 'Bahia' },
                    { id: 'CE', name: 'Ceará' },
                    { id: 'DF', name: 'Distrito Federal' },
                    { id: 'ES', name: 'Espírito Santo' },
                    { id: 'GO', name: 'Goiás' },
                    { id: 'MA', name: 'Maranhão' },
                    { id: 'MT', name: 'Mato Grosso' },
                    { id: 'MS', name: 'Mato Grosso do Sul' },
                    { id: 'MG', name: 'Minas Gerais' },
                    { id: 'PA', name: 'Pará' },
                    { id: 'PB', name: 'Paraíba' },
                    { id: 'PR', name: 'Paraná' },
                    { id: 'PE', name: 'Pernambuco' },
                    { id: 'PI', name: 'Piauí' },
                    { id: 'RJ', name: 'Rio de Janeiro' },
                    { id: 'RN', name: 'Rio Grande do Norte' },
                    { id: 'RS', name: 'Rio Grande do Sul' },
                    { id: 'RO', name: 'Rondônia' },
                    { id: 'RR', name: 'Roraima' },
                    { id: 'SC', name: 'Santa Catarina' },
                    { id: 'SP', name: 'São Paulo' },
                    { id: 'SE', name: 'Sergipe' },
                    { id: 'TO', name: 'Tocantins' }
                ],
                'US': [
                    { id: 'AL', name: 'Alabama' },
                    { id: 'AK', name: 'Alaska' },
                    { id: 'AZ', name: 'Arizona' },
                    { id: 'AR', name: 'Arkansas' },
                    { id: 'CA', name: 'California' },
                    { id: 'CO', name: 'Colorado' },
                    { id: 'CT', name: 'Connecticut' },
                    { id: 'DE', name: 'Delaware' },
                    { id: 'FL', name: 'Florida' },
                    { id: 'GA', name: 'Georgia' },
                    { id: 'HI', name: 'Hawaii' },
                    { id: 'ID', name: 'Idaho' },
                    { id: 'IL', name: 'Illinois' },
                    { id: 'IN', name: 'Indiana' },
                    { id: 'IA', name: 'Iowa' },
                    { id: 'KS', name: 'Kansas' },
                    { id: 'KY', name: 'Kentucky' },
                    { id: 'LA', name: 'Louisiana' },
                    { id: 'ME', name: 'Maine' },
                    { id: 'MD', name: 'Maryland' },
                    { id: 'MA', name: 'Massachusetts' },
                    { id: 'MI', name: 'Michigan' },
                    { id: 'MN', name: 'Minnesota' },
                    { id: 'MS', name: 'Mississippi' },
                    { id: 'MO', name: 'Missouri' },
                    { id: 'MT', name: 'Montana' },
                    { id: 'NE', name: 'Nebraska' },
                    { id: 'NV', name: 'Nevada' },
                    { id: 'NH', name: 'New Hampshire' },
                    { id: 'NJ', name: 'New Jersey' },
                    { id: 'NM', name: 'New Mexico' },
                    { id: 'NY', name: 'New York' },
                    { id: 'NC', name: 'North Carolina' },
                    { id: 'ND', name: 'North Dakota' },
                    { id: 'OH', name: 'Ohio' },
                    { id: 'OK', name: 'Oklahoma' },
                    { id: 'OR', name: 'Oregon' },
                    { id: 'PA', name: 'Pennsylvania' },
                    { id: 'RI', name: 'Rhode Island' },
                    { id: 'SC', name: 'South Carolina' },
                    { id: 'SD', name: 'South Dakota' },
                    { id: 'TN', name: 'Tennessee' },
                    { id: 'TX', name: 'Texas' },
                    { id: 'UT', name: 'Utah' },
                    { id: 'VT', name: 'Vermont' },
                    { id: 'VA', name: 'Virginia' },
                    { id: 'WA', name: 'Washington' },
                    { id: 'WV', name: 'West Virginia' },
                    { id: 'WI', name: 'Wisconsin' },
                    { id: 'WY', name: 'Wyoming' }
                ],
                'CA': [
                    { id: 'AB', name: 'Alberta' },
                    { id: 'BC', name: 'British Columbia' },
                    { id: 'MB', name: 'Manitoba' },
                    { id: 'NB', name: 'New Brunswick' },
                    { id: 'NL', name: 'Newfoundland and Labrador' },
                    { id: 'NS', name: 'Nova Scotia' },
                    { id: 'ON', name: 'Ontario' },
                    { id: 'PE', name: 'Prince Edward Island' },
                    { id: 'QC', name: 'Quebec' },
                    { id: 'SK', name: 'Saskatchewan' }
                ],
                'MX': [
                    { id: 'AG', name: 'Aguascalientes' },
                    { id: 'BC', name: 'Baja California' },
                    { id: 'BS', name: 'Baja California Sur' },
                    { id: 'CM', name: 'Campeche' },
                    { id: 'CO', name: 'Coahuila' },
                    { id: 'CL', name: 'Colima' },
                    { id: 'CS', name: 'Chiapas' },
                    { id: 'CH', name: 'Chihuahua' },
                    { id: 'DF', name: 'Ciudad de México' },
                    { id: 'DG', name: 'Durango' },
                    { id: 'GT', name: 'Guanajuato' },
                    { id: 'GR', name: 'Guerrero' },
                    { id: 'HG', name: 'Hidalgo' },
                    { id: 'JA', name: 'Jalisco' },
                    { id: 'EM', name: 'Estado de México' },
                    { id: 'MI', name: 'Michoacán' },
                    { id: 'MO', name: 'Morelos' },
                    { id: 'NA', name: 'Nayarit' },
                    { id: 'NL', name: 'Nuevo León' },
                    { id: 'OA', name: 'Oaxaca' },
                    { id: 'PU', name: 'Puebla' },
                    { id: 'QT', name: 'Querétaro' },
                    { id: 'QR', name: 'Quintana Roo' },
                    { id: 'SL', name: 'San Luis Potosí' },
                    { id: 'SI', name: 'Sinaloa' },
                    { id: 'SO', name: 'Sonora' },
                    { id: 'TB', name: 'Tabasco' },
                    { id: 'TM', name: 'Tamaulipas' },
                    { id: 'TL', name: 'Tlaxcala' },
                    { id: 'VE', name: 'Veracruz' },
                    { id: 'YU', name: 'Yucatán' },
                    { id: 'ZA', name: 'Zacatecas' }
                ],
                'AR': [
                    { id: 'BA', name: 'Buenos Aires' },
                    { id: 'CT', name: 'Catamarca' },
                    { id: 'CC', name: 'Chaco' },
                    { id: 'CH', name: 'Chubut' },
                    { id: 'CB', name: 'Córdoba' },
                    { id: 'CR', name: 'Corrientes' },
                    { id: 'ER', name: 'Entre Ríos' },
                    { id: 'FO', name: 'Formosa' },
                    { id: 'JY', name: 'Jujuy' },
                    { id: 'LP', name: 'La Pampa' },
                    { id: 'LR', name: 'La Rioja' },
                    { id: 'MZ', name: 'Mendoza' },
                    { id: 'MI', name: 'Misiones' },
                    { id: 'NQ', name: 'Neuquén' },
                    { id: 'RN', name: 'Río Negro' },
                    { id: 'SA', name: 'Salta' },
                    { id: 'SJ', name: 'San Juan' },
                    { id: 'SL', name: 'San Luis' },
                    { id: 'SC', name: 'Santa Cruz' },
                    { id: 'SF', name: 'Santa Fe' },
                    { id: 'SE', name: 'Santiago del Estero' },
                    { id: 'TF', name: 'Tierra del Fuego' },
                    { id: 'TU', name: 'Tucumán' }
                ],
                'CW': [
                    { id: 'CU', name: 'Curaçao' }
                ]
            };

            const states = statesByCountry[countryId] || [];
            
            estadoSelect.innerHTML = '<option value="">Selecione o estado/província</option>';
            cidadeSelect.innerHTML = '<option value="">Selecione a cidade</option>';
            
            if (states.length === 0) {
                estadoSelect.innerHTML = '<option value="Não se aplica">Não se aplica</option>';
                cidadeSelect.innerHTML = '<option value="Não se aplica">Não se aplica</option>';
                cidadeSelect.disabled = false;
            } else {
                states.sort((a, b) => a.name.localeCompare(b.name))
                    .forEach(state => {
                        const option = document.createElement('option');
                        option.value = state.name;
                        option.textContent = state.name;
                        option.dataset.stateId = state.id;
                        estadoSelect.appendChild(option);
                    });
                
                cidadeSelect.disabled = true;
            }

            // Add change event listener for estado
            estadoSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const stateId = selectedOption.dataset.stateId;
                populateFallbackCities(stateId);
            });
        }

        function populateFallbackCities(stateId) {
            const cidadeSelect = document.getElementById('cidade');
            
            if (!cidadeSelect) {
                console.error('Elemento cidade não encontrado');
                return;
            }

            // Define some major cities for demonstration
            const citiesByState = {
                'SP': ['São Paulo', 'Campinas', 'Santos', 'Guarulhos', 'Osasco'],
                'RJ': ['Rio de Janeiro', 'Niterói', 'Petrópolis', 'Teresópolis', 'Nova Iguaçu'],
                'MG': ['Belo Horizonte', 'Uberlândia', 'Contagem', 'Juiz de Fora', 'Betim'],
                'BA': ['Salvador', 'Feira de Santana', 'Vitória da Conquista', 'Camaçari', 'Itabuna'],
                'RS': ['Porto Alegre', 'Caxias do Sul', 'Gravataí', 'Canoas', 'Bagé'],
                'PR': ['Curitiba', 'Londrina', 'Maringá', 'Ponta Grossa', 'Cascavel'],
                'PE': ['Recife', 'Jaboatão dos Guararapes', 'Olinda', 'Caruaru', 'Petrolina'],
                'CE': ['Fortaleza', 'Caucaia', 'Juazeiro do Norte', 'Sobral', 'Maracanaú'],
                'PA': ['Belém', 'Ananindeua', 'Santarém', 'Marabá', 'Parauapebas'],
                'SC': ['Florianópolis', 'Joinville', 'Blumenau', 'São José', 'Chapecó'],
                'GO': ['Goiânia', 'Aparecida de Goiânia', 'Anápolis', 'Rio Verde', 'Luziânia'],
                'MA': ['São Luís', 'Imperatriz', 'São José de Ribamar', 'Timon', 'Caxias'],
                'RN': ['Natal', 'Mossoró', 'Parnamirim', 'São Gonçalo do Amarante', 'Macaíba'],
                'AL': ['Maceió', 'Arapiraca', 'Palmeira dos Índios', 'Rio Largo', 'Coruripe'],
                'PB': ['João Pessoa', 'Campina Grande', 'Santa Rita', 'Patos', 'Bayeux'],
                'SE': ['Aracaju', 'Nossa Senhora do Socorro', 'Lagarto', 'Itabaiana', 'São Cristóvão'],
                'PI': ['Teresina', 'Parnaíba', 'Picos', 'Floriano', 'Barras'],
                'RO': ['Porto Velho', 'Ji-Paraná', 'Ariquemes', 'Vilhena', 'Cacoal'],
                'AM': ['Manaus', 'Parintins', 'Itacoatiara', 'Manacapuru', 'Coari'],
                'RR': ['Boa Vista', 'Rorainópolis', 'Caracaraí', 'Normandia', 'Bonfim'],
                'AP': ['Macapá', 'Santana', 'Laranjal do Jari', 'Oiapoque', 'Porto Grande'],
                'TO': ['Palmas', 'Araguaína', 'Gurupi', 'Porto Nacional', 'Miracema do Tocantins'],
                'MT': ['Cuiabá', 'Várzea Grande', 'Rondonópolis', 'Sinop', 'Tangará da Serra'],
                'MS': ['Campo Grande', 'Dourados', 'Três Lagoas', 'Corumbá', 'Aquidauana'],
                'DF': ['Brasília', 'Ceilândia', 'Taguatinga', 'Planaltina', 'Samambaia'],
                'ES': ['Vitória', 'Vila Velha', 'Serra', 'Cariacica', 'Cachoeiro de Itapemirim'],
                'RJ': ['Rio de Janeiro', 'Niterói', 'Petrópolis', 'Teresópolis', 'Nova Iguaçu'],
                'CU': ['Willemstad', 'Barber', 'Soto', 'Brievengat', 'Boca Samí']
            };

            const cities = citiesByState[stateId] || [];
            
            cidadeSelect.innerHTML = '<option value="">Selecione a cidade</option>';
            
            if (cities.length === 0) {
                cidadeSelect.innerHTML = '<option value="Cidade Principal">Cidade Principal</option>';
            } else {
                cities.sort((a, b) => a.localeCompare(b))
                    .forEach(city => {
                        const option = document.createElement('option');
                        option.value = city;
                        option.textContent = city;
                        cidadeSelect.appendChild(option);
                    });
            }

            cidadeSelect.disabled = false;
        }

        function populateCountries() {
            const paisSelect = document.getElementById('pais');
            paisSelect.innerHTML = '<option value="">Selecione o país</option>';
            
            Object.values(countriesData)
                .sort((a, b) => a.name.localeCompare(b.name))
                .forEach(country => {
                    const option = document.createElement('option');
                    option.value = country.name;
                    option.textContent = country.name;
                    option.dataset.countryId = country.id;
                    paisSelect.appendChild(option);
                });

            paisSelect.addEventListener('change', function() {
                const countryId = this.options[this.selectedIndex].dataset.countryId;
                populateStates(countryId);
            });
        }

        function populateStates(countryId) {
            const estadoSelect = document.getElementById('estado');
            const cidadeSelect = document.getElementById('cidade');
            
            if (!countryId) {
                estadoSelect.innerHTML = '<option value="">Primeiro selecione o país</option>';
                estadoSelect.disabled = true;
                cidadeSelect.innerHTML = '<option value="">Primeiro selecione o estado</option>';
                cidadeSelect.disabled = true;
                return;
            }

            const countryStates = statesData[countryId] || [];
            
            if (countryStates.length === 0) {
                estadoSelect.innerHTML = '<option value="Não se aplica">Não se aplica</option>';
                estadoSelect.disabled = false;
                cidadeSelect.innerHTML = '<option value="Não se aplica">Não se aplica</option>';
                cidadeSelect.disabled = false;
                return;
            }

            estadoSelect.innerHTML = '<option value="">Selecione o estado</option>';
            countryStates.sort((a, b) => a.name.localeCompare(b.name))
                .forEach(state => {
                    const option = document.createElement('option');
                    option.value = state.name;
                    option.textContent = state.name;
                    option.dataset.stateId = state.id;
                    estadoSelect.appendChild(option);
                });

            estadoSelect.disabled = false;
            cidadeSelect.innerHTML = '<option value="">Primeiro selecione o estado</option>';
            cidadeSelect.disabled = true;

            estadoSelect.addEventListener('change', function() {
                const stateId = this.options[this.selectedIndex].dataset.stateId;
                populateCities(stateId);
            });
        }

        function populateCities(stateId) {
            const cidadeSelect = document.getElementById('cidade');
            
            if (!stateId) {
                cidadeSelect.innerHTML = '<option value="">Primeiro selecione o estado</option>';
                cidadeSelect.disabled = true;
                return;
            }

            const stateCities = citiesData[stateId] || [];
            
            if (stateCities.length === 0) {
                cidadeSelect.innerHTML = '<option value="Cidade Principal">Cidade Principal</option>';
                cidadeSelect.disabled = false;
                return;
            }

            cidadeSelect.innerHTML = '<option value="">Selecione a cidade</option>';
            stateCities.sort((a, b) => a.name.localeCompare(b.name))
                .forEach(city => {
                    const option = document.createElement('option');
                    option.value = city.name;
                    option.textContent = city.name;
                    cidadeSelect.appendChild(option);
                });

            cidadeSelect.disabled = false;
        }
    </script>
    
    
   

    <!-- Limite de upload de 100MB -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const arquivoInput = document.getElementById('arquivo');
        if (arquivoInput) {
            arquivoInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file && file.size > 100 * 1024 * 1024) { // 100 MB
                    Swal.fire({
                        title: 'Arquivo muito grande!',
                        text: 'O limite máximo de upload é 100 MB.',
                        icon: 'error',
                        showClass: {
                            popup: 'animate__animated animate__shakeX'
                        }
                    });
                    e.target.value = ''; // Limpa o campo
                }
            });
        }
    });
    </script>

  </body>
</html>