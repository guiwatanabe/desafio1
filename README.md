# Desafio1

Aplicação para processar arquivos comprimidos (.zip), extrair os arquivos XML e processar os registros, salvando no banco de dados e publicando em um tópico AMQP.

### Ambiente Local
`composer run dev`

### Build - Docker
`docker compose up --build`.

---

### Endpoints - API

- Upload dos arquivos comprimidos (.zip).
>POST /api/files

---

- Listagem dos registros de metadados.
>GET /api/publications

---

### Testes

`composer run tests`

`composer run phpstan`