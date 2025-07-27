# Portal de Cursos

Um sistema completo de venda de cursos online desenvolvido com Laravel e Bootstrap CSS.

## 🚀 Funcionalidades

### Frontend (Web)
- **Página Inicial**: Hero section, estatísticas, cursos populares e seções informativas
- **Catálogo de Cursos**: Listagem completa com filtros por preço e status
- **Detalhes do Curso**: Página completa com informações, currículo, avaliações e instrutor
- **Sobre Nós**: História da empresa, missão, visão, valores e equipe
- **Contato**: Formulário de contato, informações e FAQ
- **Design Responsivo**: Interface moderna e responsiva com Bootstrap 5

### Backend (API)
- **API RESTful** para gerenciamento de:
  - Cursos
  - Estudantes
  - Matrículas
  - Usuários
  - Pagamentos

## 🛠️ Tecnologias Utilizadas

- **Backend**: Laravel 11
- **Frontend**: Blade Templates + Bootstrap 5.3
- **Banco de Dados**: MySQL/SQLite
- **Icons**: Bootstrap Icons
- **Estilização**: CSS customizado com gradientes e animações

## 📋 Pré-requisitos

- PHP >= 8.2
- Composer
- Node.js e NPM
- MySQL ou SQLite

## 🔧 Instalação

1. **Clone o repositório**
   ```bash
   git clone <url-do-repositorio>
   cd courses-portal
   ```

2. **Instale as dependências do PHP**
   ```bash
   composer install
   ```

3. **Instale as dependências do Node.js**
   ```bash
   npm install
   ```

4. **Configure o ambiente**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure o banco de dados**
   - Edite o arquivo `.env` com suas configurações de banco
   - Execute as migrações:
   ```bash
   php artisan migrate
   ```

6. **Popule o banco com dados de exemplo**
   ```bash
   php artisan db:seed
   ```

7. **Compile os assets**
   ```bash
   npm run dev
   ```

8. **Inicie o servidor**
   ```bash
   php artisan serve
   ```

## 📁 Estrutura do Projeto

```
courses-portal/
├── app/
│   ├── Http/Controllers/
│   │   ├── API/          # Controllers da API
│   │   └── Web/          # Controllers do frontend
│   ├── Models/           # Models Eloquent
│   └── ...
├── database/
│   ├── migrations/       # Migrações do banco
│   └── seeders/         # Seeders para popular dados
├── resources/
│   └── views/
│       └── web/         # Views do frontend
│           ├── pages/   # Páginas principais
│           └── _theme.blade.php  # Template base
├── routes/
│   ├── api.php          # Rotas da API
│   └── web.php          # Rotas do frontend
└── ...
```

## 🎨 Páginas Disponíveis

### Frontend
- `/` - Página inicial
- `/cursos` - Catálogo de cursos
- `/curso/{id}` - Detalhes do curso
- `/sobre` - Sobre a empresa
- `/contato` - Página de contato

### API Endpoints
- `GET /api/courses` - Listar cursos
- `POST /api/courses` - Criar curso
- `GET /api/courses/{id}` - Detalhes do curso
- `PUT /api/courses/{id}` - Atualizar curso
- `DELETE /api/courses/{id}` - Excluir curso
- `GET /api/students` - Listar estudantes
- `POST /api/students` - Criar estudante
- `GET /api/enrollments` - Listar matrículas

## 🎯 Funcionalidades Principais

### Sistema de Cursos
- Cadastro completo de cursos
- Controle de vagas disponíveis
- Período de inscrições
- Status (disponível/indisponível)
- Preços e informações detalhadas

### Interface do Usuário
- Design moderno e responsivo
- Filtros e busca de cursos
- Visualização em grid e lista
- Modais para inscrições
- Formulários de contato

### Recursos Visuais
- Gradientes e animações CSS
- Ícones Bootstrap
- Cards com hover effects
- Layout responsivo
- Tipografia moderna

## 🔒 Segurança

- Validação de formulários
- Proteção CSRF
- Sanitização de dados
- Validação de entrada

## 📱 Responsividade

O sistema é totalmente responsivo e funciona perfeitamente em:
- Desktop
- Tablets
- Smartphones

## 🤝 Contribuição

1. Faça um fork do projeto
2. Crie uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

## 📄 Licença

Este projeto está sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

## 👥 Equipe

- **Desenvolvimento**: Equipe Portal de Cursos
- **Design**: Bootstrap + Customizações
- **Backend**: Laravel Framework

## 📞 Suporte

Para suporte, envie um email para contato@portaldecursos.com ou abra uma issue no GitHub.

---

**Portal de Cursos** - Transformando vidas através da educação online! 🎓
