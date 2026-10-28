# Clube do Sorvete — MVP escolar

## Arquivos
- `index.html`: landing page e apresentação da proposta.
- `css/style.css`: identidade visual e layout responsivo.
- `inscrever.php`: recebe o formulário de interesse e salva os dados em `dados/interessados.csv`.
- `votar.php`: recebe a votação de sabores e salva os votos em `dados/votos.csv`.
- `dados/`: pasta para os dados locais (CSV).

## Como executar
PHP precisa estar instalado. No terminal, dentro desta pasta, execute:

```bash
php -S localhost:8000
```

Depois abra `http://localhost:8000` no navegador.

Não abra apenas o arquivo HTML com duplo clique se quiser testar os formulários PHP; é necessário usar um servidor com PHP.

## Observações
- É um protótipo escolar: não realiza pagamento, entrega ou assinatura real.
- Os formulários guardam os dados localmente em CSV quando executados num servidor PHP com permissão de escrita na pasta `dados`.
- Antes de publicar na internet, configure proteção adequada para os dados coletados e revise a política de privacidade.
- As imagens de sabores são emojis/ilustrações simples, para evitar depender de imagens externas.
