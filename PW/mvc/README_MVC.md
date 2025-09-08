# Padrão MVC - Exemplo Didático Completo

## O que é MVC?

MVC é um padrão de arquitetura que separa uma aplicação em três componentes principais:

### 🗂️ **MODEL (Modelo)**
- **Responsabilidade**: Dados e regras de negócio
- **O que faz**: Acessa banco de dados, valida dados, processa informações
- **Arquivos**: `models/Usuario.php`, `models/Produto.php`
- **Exemplo**: Cadastrar usuário, listar produtos, fazer login

### 🎮 **CONTROLLER (Controlador)**
- **Responsabilidade**: Lógica de negócio e coordenação
- **O que faz**: Recebe requisições, processa dados, decide o que fazer
- **Arquivos**: `controllers/UsuarioController.php`, `controllers/ProdutoController.php`
- **Exemplo**: Validar formulário, processar upload, criar sessão

### 👁️ **VIEW (Visualização)**
- **Responsabilidade**: Interface do usuário
- **O que faz**: Exibe formulários, mostra resultados, apresenta dados
- **Arquivos**: `views/UsuarioView.php`, `views/ProdutoView.php`
- **Exemplo**: Formulário de cadastro, lista de produtos, tela de login

## Como funciona?

```
Usuário → VIEW → CONTROLLER → MODEL → Banco de Dados
         ↑                                    ↓
         ←─────────── Dados ←───────────────←
```

### Fluxo de exemplo (Cadastro de Produto):

1. **Usuário** acessa: `index.php?acao=cadastroProduto`
2. **Router** chama: `$produtoView->exibirFormularioCadastro()`
3. **VIEW** exibe o formulário
4. **Usuário** preenche e envia
5. **Router** chama: `$produtoController->cadastrar()`
6. **CONTROLLER** valida e chama: `$produtoModel->cadastrar()`
7. **MODEL** salva no banco
8. **VIEW** exibe o resultado

## Vantagens do MVC:

✅ **Organização**: Código bem estruturado e organizado
✅ **Manutenção**: Fácil de modificar e corrigir
✅ **Reutilização**: Componentes podem ser reutilizados
✅ **Teste**: Cada parte pode ser testada separadamente
✅ **Equipe**: Diferentes pessoas podem trabalhar em partes diferentes
✅ **Escalabilidade**: Fácil adicionar novas funcionalidades

## Estrutura de arquivos:

```
mvc/
├── models/
│   ├── Usuario.php          # Dados de usuários
│   └── Produto.php          # Dados de produtos
├── controllers/
│   ├── UsuarioController.php # Lógica de usuários
│   └── ProdutoController.php # Lógica de produtos
├── views/
│   ├── UsuarioView.php      # Interface de usuários
│   └── ProdutoView.php      # Interface de produtos
├── index.php                # Router principal
├── conexaoBD.php            # Conexão com banco
├── header.php               # Cabeçalho
├── footer.php               # Rodapé
└── README_MVC.md           # Este arquivo
```

## URLs de exemplo:

### Usuários:
- `index.php?acao=login` - Tela de login
- `index.php?acao=cadastro` - Formulário de cadastro
- `index.php?acao=areaRestrita` - Área restrita

### Produtos:
- `index.php?acao=listarProdutos` - Lista todos os produtos
- `index.php?acao=cadastroProduto` - Formulário de cadastro de produto
- `index.php?acao=visualizarProduto&id=1` - Ver produto específico
- `index.php?acao=editarProduto&id=1` - Editar produto
- `index.php?acao=excluirProduto&id=1` - Excluir produto

### Sistema:
- `index.php?acao=logout` - Fazer logout

## Funcionalidades implementadas:

### 🔐 **Sistema de Autenticação**
- Login/logout
- Controle de sessão
- Área restrita
- Validação de acesso

### 👥 **Gestão de Usuários**
- Cadastro de usuários
- Upload de foto
- Validações de dados
- Criptografia de senha

### 📦 **Gestão de Produtos**
- Cadastro de produtos
- Listagem com cards
- Visualização detalhada
- Edição de produtos
- Exclusão de produtos
- Upload de imagens

## Conceitos importantes demonstrados:

1. **Separação de responsabilidades**: Cada arquivo tem uma função específica
2. **Roteamento centralizado**: Um arquivo controla todas as páginas
3. **Reutilização**: Models e Views podem ser usados por diferentes Controllers
4. **Manutenibilidade**: Mudanças em uma parte não afetam as outras
5. **Segurança**: Validações, sanitização e controle de acesso
6. **Interface responsiva**: Bootstrap para design moderno

## Como expandir o sistema:

1. **Adicionar nova entidade**: Criar Model, Controller e View
2. **Novas funcionalidades**: Adicionar métodos nos Controllers
3. **Melhorar interface**: Modificar as Views
4. **Validações**: Adicionar regras nos Controllers
5. **Relacionamentos**: Conectar diferentes Models

Este é um exemplo completo para fins didáticos. Em projetos reais, o MVC pode ser mais complexo com frameworks como Laravel, CodeIgniter, etc. 