<?php
// ROUTER - Controla as rotas e conecta tudo
require_once __DIR__ . '/config/conexaoBD.php';
require_once __DIR__ . '/controllers/UsuarioController.php';
require_once __DIR__ . '/controllers/ProdutoController.php';
require_once __DIR__ . '/controllers/CompraController.php';
require_once __DIR__ . '/views/UsuarioView.php';
require_once __DIR__ . '/views/ProdutoView.php';
require_once __DIR__ . '/views/CompraView.php';

// Inicializar controladores e views
$usuarioController = new UsuarioController($conn);
$produtoController = new ProdutoController($conn);
$compraController = new CompraController($conn);
$usuarioView = new UsuarioView();
$produtoView = new ProdutoView();
$compraView = new CompraView();

// Pegar a ação da URL
$acao = isset($_GET['acao']) ? $_GET['acao'] : 'home';

// Roteamento baseado na ação
switch ($acao) {
    
    // ===== PÁGINA INICIAL =====
    case 'home':
        include __DIR__ . '/header.php';
        ?>
        <div class="container mt-5">
            <div class="jumbotron text-center">
                <h1 class="display-4">Bem-vindo ao Sistema!</h1>
                <p class="lead">Sistema de gerenciamento de produtos e usuários</p>
                <hr class="my-4">
                <p>Faça login para acessar o sistema ou cadastre-se.</p>
                <a class="btn btn-primary btn-lg" href="index.php?acao=login" role="button">Login</a>
                <a class="btn btn-success btn-lg" href="index.php?acao=cadastro" role="button">Cadastrar</a>
            </div>
        </div>
        <?php
        include __DIR__ . '/footer.php';
        break;
    
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
        header('Location: index.php?acao=home');
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
        // Listar produtos
        $resultado = $produtoController->listar();
        $produtoView->exibirListaProdutos($resultado['produtos']);
        break;
        
    case 'listarProdutosTabela':
        // Listar produtos em tabela
        $resultado = $produtoController->listar();
        $produtoView->exibirListaTabela($resultado['produtos']);
        break;
        
    case 'visualizarProduto':
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
        
    // ===== ROTAS DE COMPRA =====
    case 'efetuarCompra':
        // Verificar se está logado
        session_start();
        if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
            header('Location: index.php?acao=login&erro=Usuário não logado!');
            exit();
        }
        
        // Verificar se é cliente
        if ($_SESSION['tipoUsuario'] !== 'cliente') {
            header('Location: index.php?acao=areaRestrita&erro=Apenas clientes podem efetuar compras!');
            exit();
        }
        
        // Efetuar compra
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $dadosCompra = [
                'idUsuario' => $_SESSION['idUsuario'],
                'idProduto' => intval($_POST['idProduto']),
                'valorCompra' => floatval($_POST['valorProduto'])
            ];
            
            $resultado = $compraController->efetuarCompra($dadosCompra);
            $compraView->exibirResultadoCompra($resultado);
        } else {
            header('Location: index.php?acao=listarProdutos');
            exit();
        }
        break;
        
    case 'minhasCompras':
        // Verificar se está logado
        session_start();
        if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
            header('Location: index.php?acao=login&erro=Usuário não logado!');
            exit();
        }
        
        // Listar compras do usuário
        $resultado = $compraController->listarComprasUsuario($_SESSION['idUsuario']);
        $compraView->exibirMinhasCompras($resultado['compras']);
        break;
        
    case 'todasCompras':
        // Verificar se está logado e é admin
        session_start();
        if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || $_SESSION['tipoUsuario'] !== 'administrador') {
            header('Location: index.php?acao=login&erro=Acesso negado!');
            exit();
        }
        
        // Listar todas as compras
        $resultado = $compraController->listarTodasCompras();
        $compraView->exibirTodasCompras($resultado['compras']);
        break;
        
    case 'estatisticasCompras':
        // Verificar se está logado e é admin
        session_start();
        if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || $_SESSION['tipoUsuario'] !== 'administrador') {
            header('Location: index.php?acao=login&erro=Acesso negado!');
            exit();
        }
        
        // Exibir estatísticas
        $resultado = $compraController->obterEstatisticas();
        $compraView->exibirEstatisticas($resultado['estatisticas']);
        break;
        
    // ===== ÁREA RESTRITA =====
    case 'areaRestrita':
        // Área restrita (dashboard)
        session_start();
        if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
            header('Location: index.php?acao=login&erro=Usuário não logado!');
            exit();
        }
        
        include __DIR__ . '/header.php';
        ?>
        <div class="container mt-3">
            <div class="alert alert-success">
                <h4>Bem-vindo, <?php echo $_SESSION['nomeUsuario']; ?>!</h4>
                <p>Você está na área restrita do sistema.</p>
            </div>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Gerenciar Usuários</h5>
                            <p class="card-text">Cadastrar e gerenciar usuários do sistema.</p>
                            <a href="index.php?acao=cadastro" class="btn btn-primary">Cadastrar Usuário</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Gerenciar Produtos</h5>
                            <p class="card-text">Cadastrar e gerenciar produtos do sistema.</p>
                            <a href="index.php?acao=listarProdutos" class="btn btn-success">Ver Produtos</a>
                            <a href="index.php?acao=cadastroProduto" class="btn btn-warning">Novo Produto</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Compras</h5>
                            <p class="card-text">Gerenciar compras do sistema.</p>
                            <?php if ($_SESSION['tipoUsuario'] == 'cliente'): ?>
                                <a href="index.php?acao=minhasCompras" class="btn btn-info">Minhas Compras</a>
                            <?php else: ?>
                                <a href="index.php?acao=todasCompras" class="btn btn-info">Todas as Compras</a>
                                <a href="index.php?acao=estatisticasCompras" class="btn btn-secondary">Estatísticas</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-3">
                <a href="index.php?acao=logout" class="btn btn-danger">Sair</a>
            </div>
        </div>
        <?php
        include __DIR__ . '/footer.php';
        break;
        
    default:
        // Página padrão (home)
        header('Location: index.php?acao=home');
        exit();
        break;
}
?> 