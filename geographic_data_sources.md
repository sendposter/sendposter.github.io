# Arquivos de Dados Geográficos para Download

## Fontes de Dados Atualizadas

### 1. REST Countries API (Recomendado)
- **URL**: https://restcountries.com/v3.1/all
- **Formato**: JSON
- **Conteúdo**: 250+ países com traduções em português
- **Atualização**: Constantemente atualizada
- **Uso**: API gratuita, sem necessidade de download

### 2. GitHub Database (Completo)
- **URL Base**: https://github.com/dr5hn/countries-states-cities-database
- **Arquivos**:
  - countries.json: https://raw.githubusercontent.com/dr5hn/countries-states-cities-database/master/json/countries.json
  - states.json: https://raw.githubusercontent.com/dr5hn/countries-states-cities-database/master/json/states.json  
  - cities.json: https://raw.githubusercontent.com/dr5hn/countries-states-cities-database/master/json/cities.json
- **Formato**: JSON
- **Conteúdo**: 5000+ cidades, 5000+ estados/províncias
- **Tamanho**: ~50MB total

### 3. GeoNames Database (Avançado)
- **URL**: http://download.geonames.org/export/dump/
- **Arquivos Principais**:
  - countryInfo.txt: Informações básicas dos países
  - admin1CodesASCII.txt: Estados/províncias
  - cities15000.zip: Cidades com +15.000 habitantes
- **Formato**: TXT/ZIP
- **Conteúdo**: Dados geográficos completos
- **Tamanho**: 500MB+ (completo)

### 4. Nominatim/OpenStreetMap
- **URL**: https://nominatim.openstreetmap.org/
- **API**: https://nominatim.openstreetmap.org/search?format=json&q=
- **Formato**: JSON
- **Conteúdo**: Dados geográficos em tempo real
- **Uso**: API gratuita com rate limiting

## Implementação Recomendada

### Opção 1: API REST Countries (Mais Simples)
```javascript
// Carregar países via API
fetch('https://restcountries.com/v3.1/all')
  .then(response => response.json())
  .then(data => {
    const countries = data.map(country => ({
      id: country.cca2,
      name: country.translations?.por?.common || country.name.common
    }));
    // Popular dropdown
  });
```

### Opção 2: GitHub Database (Completo)
```javascript
// Carregar dados completos
Promise.all([
  fetch('countries.json'),
  fetch('states.json'), 
  fetch('cities.json')
]).then(([countriesRes, statesRes, citiesRes]) => {
  // Processar dados
});
```

### Opção 3: Dados Locais (Offline)
- Download dos arquivos JSON
- Armazenamento local
- Atualização mensal

## Comparação das Fontes

| Fonte | Países | Estados | Cidades | Tamanho | Atualização |
|-------|--------|---------|---------|---------|-------------|
| REST Countries | 250+ | ❌ | ❌ | 1MB | ✅ Tempo real |
| GitHub Database | 250+ | 5000+ | 150000+ | 50MB | ✅ Frequente |
| GeoNames | 250+ | 4000+ | 200000+ | 500MB | ✅ Mensal |
| OpenStreetMap | 250+ | 10000+ | 500000+ | API | ✅ Tempo real |

## Sugestão de Implementação

1. **Para produção**: Use REST Countries API + GitHub Database
2. **Para desenvolvimento**: Download dos arquivos JSON do GitHub
3. **Para dados completos**: GeoNames (se precisar de todas as cidades)
4. **Para simplicidade**: Apenas REST Countries API

## Links Diretos para Download

### GitHub Database (Recomendado)
```bash
# Download dos arquivos principais
wget https://raw.githubusercontent.com/dr5hn/countries-states-cities-database/master/json/countries.json
wget https://raw.githubusercontent.com/dr5hn/countries-states-cities-database/master/json/states.json
wget https://raw.githubusercontent.com/dr5hn/countries-states-cities-database/master/json/cities.json
```

### GeoNames (Completo)
```bash
# Download dos dados básicos
wget http://download.geonames.org/export/dump/countryInfo.txt
wget http://download.geonames.org/export/dump/admin1CodesASCII.txt
wget http://download.geonames.org/export/dump/cities15000.zip
```

## Formato dos Dados

### Countries JSON
```json
{
  "id": "BR",
  "name": "Brazil", 
  "native": "Brasil",
  "iso2": "BR",
  "iso3": "BRA",
  "phone_code": "55"
}
```

### States JSON  
```json
{
  "id": 1,
  "name": "São Paulo",
  "country_id": "BR",
  "state_code": "SP"
}
```

### Cities JSON
```json
{
  "id": 1,
  "name": "São Paulo", 
  "country_id": "BR",
  "state_id": 1,
  "latitude": -23.5505,
  "longitude": -46.6333
}
```

## Licenciamento

- **REST Countries**: MIT License
- **GitHub Database**: MIT License  
- **GeoNames**: Creative Commons Attribution 4.0
- **OpenStreetMap**: ODbL 1.0

Todos são gratuitos para uso comercial e não comercial.
