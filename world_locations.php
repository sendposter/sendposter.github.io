<?php
// Comprehensive world locations database
function getWorldLocations() {
    return [
        'Brasil' => [
            'Acre' => ['Rio Branco', 'Cruzeiro do Sul'],
            'Alagoas' => ['Maceió', 'Arapiraca'],
            'Amapá' => ['Macapá', 'Santana'],
            'Amazonas' => ['Manaus', 'Parintins'],
            'Bahia' => ['Salvador', 'Feira de Santana', 'Vitória da Conquista'],
            'Ceará' => ['Fortaleza', 'Caucaia', 'Juazeiro do Norte'],
            'Distrito Federal' => ['Brasília'],
            'Espírito Santo' => ['Vitória', 'Vila Velha', 'Cariacica'],
            'Goiás' => ['Goiânia', 'Aparecida de Goiânia', 'Anápolis'],
            'Maranhão' => ['São Luís', 'Imperatriz', 'Timon'],
            'Mato Grosso' => ['Cuiabá', 'Várzea Grande', 'Rondonópolis'],
            'Mato Grosso do Sul' => ['Campo Grande', 'Dourados', 'Três Lagoas'],
            'Minas Gerais' => ['Belo Horizonte', 'Uberlândia', 'Contagem'],
            'Pará' => ['Belém', 'Ananindeua', 'Santarém'],
            'Paraíba' => ['João Pessoa', 'Campina Grande', 'Santa Rita'],
            'Paraná' => ['Curitiba', 'Londrina', 'Maringá'],
            'Pernambuco' => ['Recife', 'Jaboatão dos Guararapes', 'Olinda'],
            'Piauí' => ['Teresina', 'Parnaíba', 'Picos'],
            'Rio de Janeiro' => ['Rio de Janeiro', 'São Gonçalo', 'Duque de Caxias'],
            'Rio Grande do Norte' => ['Natal', 'Mossoró', 'Parnamirim'],
            'Rio Grande do Sul' => ['Porto Alegre', 'Caxias do Sul', 'Pelotas'],
            'Rondônia' => ['Porto Velho', 'Ji-Paraná', 'Ariquemes'],
            'Roraima' => ['Boa Vista', 'Rorainópolis'],
            'Santa Catarina' => ['Florianópolis', 'Joinville', 'Blumenau'],
            'São Paulo' => ['São Paulo', 'Guarulhos', 'Campinas'],
            'Sergipe' => ['Aracaju', 'Nossa Senhora do Socorro'],
            'Tocantins' => ['Palmas', 'Araguaína', 'Gurupi']
        ],
        'Argentina' => [
            'Buenos Aires' => ['Buenos Aires', 'La Plata', 'Mar del Plata'],
            'Córdoba' => ['Córdoba', 'Río Cuarto', 'Villa María'],
            'Santa Fe' => ['Santa Fe', 'Rosario', 'Rafaela'],
            'Mendoza' => ['Mendoza', 'San Rafael', 'Godoy Cruz']
        ],
        'Estados Unidos' => [
            'California' => ['Los Angeles', 'San Francisco', 'San Diego'],
            'Texas' => ['Houston', 'San Antonio', 'Dallas'],
            'New York' => ['New York City', 'Buffalo', 'Rochester'],
            'Florida' => ['Miami', 'Tampa', 'Orlando']
        ],
        'Canadá' => [
            'Ontario' => ['Toronto', 'Ottawa', 'Mississauga'],
            'Quebec' => ['Montreal', 'Quebec City', 'Laval'],
            'British Columbia' => ['Vancouver', 'Victoria', 'Surrey'],
            'Alberta' => ['Calgary', 'Edmonton', 'Red Deer']
        ],
        'México' => [
            'Jalisco' => ['Guadalajara', 'Zapopan', 'Tlaquepaque'],
            'Nuevo León' => ['Monterrey', 'Guadalupe', 'San Nicolás'],
            'Quintana Roo' => ['Cancún', 'Chetumal', 'Playa del Carmen'],
            'Yucatán' => ['Mérida', 'Kanasín', 'Umán']
        ],
        'França' => [
            'Île-de-France' => ['Paris', 'Boulogne-Billancourt', 'Saint-Denis'],
            'Provence-Alpes-Côte d\'Azur' => ['Marseille', 'Nice', 'Toulon'],
            'Auvergne-Rhône-Alpes' => ['Lyon', 'Grenoble', 'Saint-Étienne'],
            'Occitanie' => ['Toulouse', 'Montpellier', 'Nîmes']
        ],
        'Alemanha' => [
            'Nordrhein-Westfalen' => ['Köln', 'Düsseldorf', 'Dortmund'],
            'Bayern' => ['München', 'Nürnberg', 'Augsburg'],
            'Baden-Württemberg' => ['Stuttgart', 'Mannheim', 'Karlsruhe'],
            'Niedersachsen' => ['Hannover', 'Braunschweig', 'Oldenburg']
        ],
        'Reino Unido' => [
            'England' => ['London', 'Birmingham', 'Manchester'],
            'Scotland' => ['Edinburgh', 'Glasgow', 'Aberdeen'],
            'Wales' => ['Cardiff', 'Swansea', 'Newport'],
            'Northern Ireland' => ['Belfast', 'Derry', 'Lisburn']
        ],
        'Itália' => [
            'Lombardia' => ['Milano', 'Brescia', 'Bergamo'],
            'Lazio' => ['Roma', 'Latina', 'Frosinone'],
            'Campania' => ['Napoli', 'Salerno', 'Caserta'],
            'Sicilia' => ['Palermo', 'Catania', 'Messina']
        ],
        'Espanha' => [
            'Andalucía' => ['Sevilla', 'Málaga', 'Córdoba'],
            'Cataluña' => ['Barcelona', 'Hospitalet de Llobregat', 'Badalona'],
            'Madrid' => ['Madrid', 'Móstoles', 'Alcalá de Henares'],
            'Comunidad Valenciana' => ['Valencia', 'Alicante', 'Castellón']
        ],
        'China' => [
            'Guangdong' => ['Guangzhou', 'Shenzhen', 'Dongguan'],
            'Jiangsu' => ['Nanjing', 'Suzhou', 'Wuxi'],
            'Shandong' => ['Jinan', 'Qingdao', 'Zibo'],
            'Zhejiang' => ['Hangzhou', 'Ningbo', 'Wenzhou']
        ],
        'Japão' => [
            'Tokyo' => ['Tokyo', 'Shibuya', 'Shinjuku'],
            'Osaka' => ['Osaka', 'Sakai', 'Higashiosaka'],
            'Kanagawa' => ['Yokohama', 'Kawasaki', 'Sagamihara'],
            'Aichi' => ['Nagoya', 'Toyota', 'Okazaki']
        ],
        'Índia' => [
            'Maharashtra' => ['Mumbai', 'Pune', 'Nagpur'],
            'Delhi' => ['New Delhi', 'Delhi'],
            'Karnataka' => ['Bangalore', 'Mysore', 'Hubli'],
            'Tamil Nadu' => ['Chennai', 'Coimbatore', 'Madurai']
        ],
        'Austrália' => [
            'New South Wales' => ['Sydney', 'Newcastle', 'Wollongong'],
            'Victoria' => ['Melbourne', 'Geelong', 'Ballarat'],
            'Queensland' => ['Brisbane', 'Gold Coast', 'Townsville'],
            'Western Australia' => ['Perth', 'Fremantle', 'Bunbury']
        ],
        'Rússia' => [
            'Moscow Oblast' => ['Moscow', 'Balashikha', 'Khimki'],
            'Saint Petersburg' => ['Saint Petersburg', 'Kronstadt'],
            'Novosibirsk Oblast' => ['Novosibirsk', 'Berdsk'],
            'Sverdlovsk Oblast' => ['Yekaterinburg', 'Nizhny Tagil']
        ]
    ];
}
?>
