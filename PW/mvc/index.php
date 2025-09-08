<?php
// ROUTER - Controla as rotas e conecta tudo
require_once 'conexaoBD.php';
require_once 'controllers/UsuarioController.php';
require_once 'controllers/ProdutoController.php';
require_once 'views/UsuarioView.php';
require_once 'views/ProdutoView.php';

// Inicializar controladores e views
$usuarioController = new UsuarioController($conn);
$produtoController = new ProdutoController($conn);
$usuarioView = new UsuarioView();
$produtoView = new ProdutoView();

// Pegar a ação da URL
$acao = isset($_GET['acao']) ? $_GET['acao'] : 'login';

// Roteamento baseado na ação
switch ($acao) {
    
    // ===== ROTAS DE USUÁRIO =====
    case 'cadastro':
        // Exibir formulário de cadastro
        $usuarioView->exibirFormularioCadastro();
        break;
        
    case 'cadastrar':
        // Processar cadastro
        $resultado = $usuarioController->cadastrar();
        $usuarioView->exibirResultadoCadastro($resultado);
        break;
        
    case 'login':
        // Exibir formulário de login
        $erro = isset($_GET['erro']) ? $_GET['erro'] : null;
        $usuarioView->exibirFormularioLogin($erro);
        break;
        
    case 'fazerLogin':
        // Processar login
        $resultado = $usuarioController->fazerLogin();
        
        if ($resultado['sucesso']) {
            // Redirecionar para área restrita
            header('Location: index.php?acao=areaRestrita');
            exit();
        } else {
            // Voltar para login com erro
            header('Location: index.php?acao=login&erro=' . urlencode($resultado['mensagem']));
            exit();
        }
        break;
        
    case 'logout':
        // Fazer logout
        session_start();
        session_destroy();
        header('Location: index.php?acao=login');
        exit();
        break;
        
    // ===== ROTAS DE PRODUTO =====
    case 'cadastroProduto':
        // Verificar se está logado
        session_start();
        if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
            header('Location: index.php?acao=login&erro=Usuário não logado!');
            exit();
        }
        
        // Exibir formulário de cadastro de produto
        $produtoView->exibirFormularioCadastro();
        break;
        
    case 'cadastrarProduto':
        // Verificar se está logado
        session_start();
        if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
            header('Location: index.php?acao=login&erro=Usuário não logado!');
            exit();
        }
        
        // Processar cadastro de produto
        $resultado = $produtoController->cadastrar();
        $produtoView->exibirResultado($resultado);
        break;
        
    case 'listarProdutos':
        // Verificar se está logado
        session_start();
        if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
            header('Location: index.php?acao=login&erro=Usuário não logado!');
            exit();
        }
        
        // Listar produtos
        $resultado = $produtoController->listar();
        $produtoView->exibirListaProdutos($resultado['produtos']);
        break;
        
    case 'visualizarProduto':
        // Verificar se está logado
        session_start();
        if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
            header('Location: index.php?acao=login&erro=Usuário não logado!');
            exit();
        }
        
        // Visualizar produto específico
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $resultado = $produtoController->buscarPorId($id);
        
        if ($resultado['sucesso']) {
            $produtoView->exibirDetalhesProduto($resultado['produto']);
        } else {
            header('Location: index.php?acao=listarProdutos&erro=' . urlencode($resultado['mensagem']));
            exit();
        }
        break;
        
    case 'editarProduto':
        // Verificar se está logado
        session_start();
        if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
            header('Location: index.php?acao=login&erro=Usuário não logado!');
            exit();
        }
        
        // Exibir formulário de edição
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $resultado = $produtoController->buscarPorId($id);
        
        if ($resultado['sucesso']) {
            $produtoView->exibirFormularioEdicao($resultado['produto']);
        } else {
            header('Location: index.php?acao=listarProdutos&erro=' . urlencode($resultado['mensagem']));
            exit();
        }
        break;
        
    case 'atualizarProduto':
        // Verificar se está logado
        session_start();
        if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
            header('Location: index.php?acao=login&erro=Usuário não logado!');
            exit();
        }
        
        // Atualizar produto
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $resultado = $produtoController->atualizar($id);
        
        if ($resultado['sucesso']) {
            header('Location: index.php?acao=listarProdutos&sucesso=' . urlencode($resultado['mensagem']));
        } else {
            header('Location: index.php?acao=editarProduto&id=' . $id . '&erro=' . urlencode($resultado['mensagem']));
        }
        exit();
        break;
        
    case 'excluirProduto':
        // Verificar se está logado
        session_start();
        if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
            header('Location: index.php?acao=login&erro=Usuário não logado!');
            exit();
        }
        
        // Excluir produto
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $resultado = $produtoController->excluir($id);
        
        header('Location: index.php?acao=listarProdutos&' . ($resultado['sucesso'] ? 'sucesso' : 'erro') . '=' . urlencode($resultado['mensagem']));
        exit();
        break;
        
    // ===== ÁREA RESTRITA =====
    case 'areaRestrita':
        // Área restrita (exemplo simples)
        session_start();
        if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
            header('Location: index.php?acao=login&erro=Usuário não logado!');
            exit();
        }
        
        include 'header.php';
        ?>
        <div class="container mt-3">
            <div class="alert alert-success">
                <h4>Bem-vindo, <?php echo $_SESSION['nomeUsuario']; ?>!</h4>
                <p>Você está na área restrita do sistema.</p>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Gerenciar Usuários</h5>
                            <p class="card-text">Cadastrar e gerenciar usuários do sistema.</p>
                            <a href="index.php?acao=cadastro" class="btn btn-primary">Cadastrar Usuário</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Gerenciar Produtos</h5>
                            <p class="card-text">Cadastrar e gerenciar produtos do sistema.</p>
                            <a href="index.php?acao=listarProdutos" class="btn btn-success">Ver Produtos</a>
                            <a href="index.php?acao=cadastroProduto" class="btn btn-warning">Novo Produto</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-3">
                <a href="index.php?acao=logout" class="btn btn-danger">Sair</a>
            </div>
        </div>
        <?php
        include 'footer.php';
        break;
        
    default:
        // Página padrão (login)
        $usuarioView->exibirFormularioLogin();
        break;
}
?> 