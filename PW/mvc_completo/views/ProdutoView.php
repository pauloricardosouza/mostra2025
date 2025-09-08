<?php
// VIEW - Responsável pela interface do produto
class ProdutoView {
    
    // Método para exibir formulário de cadastro de produto
    public function exibirFormularioCadastro() {
        include __DIR__ . '/../header.php';
        ?>
        <div class="container text-center mb-3 mt-3">
            <h2>Cadastrar Produto:</h2>
            <div class="d-flex justify-content-center mb-3">
                <div class="row">
                    <div class="col-12">
                        <form action="index.php?acao=cadastrarProduto" method="POST" class="was-validated" enctype="multipart/form-data">
                            <div class="form-floating mb-3 mt-3">
                                <input type="file" class="form-control" id="fotoProduto" name="fotoProduto" required>
                                <label for="fotoProduto">Foto</label>
                            </div>
                            
                            <div class="form-floating mb-3 mt-3">
                                <input type="text" class="form-control" id="nomeProduto" placeholder="Nome" name="nomeProduto" required>
                                <label for="nomeProduto">Nome do Produto</label>
                            </div>
                            
                            <div class="form-floating mb-3 mt-3">
                                <textarea class="form-control" id="descricaoProduto" placeholder="Informe uma breve descrição sobre o Produto" name="descricaoProduto" required></textarea>
                                <label for="descricaoProduto">Descrição do Produto</label>
                            </div>
                            
                            <div class="form-floating mt-3 mb-3">
                                <input type="number" step="0.01" class="form-control" id="valorProduto" placeholder="Valor do Produto" name="valorProduto" required>
                                <label for="valorProduto">Valor do Produto (R$):</label>
                            </div>
                            
                            <button type="submit" class="btn btn-success">Cadastrar Produto</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
        include __DIR__ . '/../footer.php';
    }
    
    // Método para exibir lista de produtos
    public function exibirListaProdutos($produtos) {
        include __DIR__ . '/../header.php';
        ?>
        <div class="container mt-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>Lista de Produtos</h2>
                <a href="index.php?acao=cadastroProduto" class="btn btn-success">Novo Produto</a>
            </div>
            
            <?php if (empty($produtos)): ?>
                <div class="alert alert-info text-center">Nenhum produto cadastrado.</div>
            <?php else: ?>
                <div class="row">
                    <?php foreach ($produtos as $produto): ?>
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <img src="<?php echo $produto['fotoProduto']; ?>" class="card-img-top" alt="<?php echo $produto['nomeProduto']; ?>" style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $produto['nomeProduto']; ?></h5>
                                    <p class="card-text"><?php echo $produto['descricaoProduto']; ?></p>
                                    <p class="card-text"><strong>R$ <?php echo number_format($produto['valorProduto'], 2, ',', '.'); ?></strong></p>
                                    <p class="card-text"><small class="text-muted">Status: <?php echo $produto['statusProduto']; ?></small></p>
                                    
                                    <div class="btn-group" role="group">
                                        <a href="index.php?acao=visualizarProduto&id=<?php echo $produto['idProduto']; ?>" class="btn btn-primary btn-sm">Ver</a>
                                        <a href="index.php?acao=editarProduto&id=<?php echo $produto['idProduto']; ?>" class="btn btn-warning btn-sm">Editar</a>
                                        <a href="index.php?acao=excluirProduto&id=<?php echo $produto['idProduto']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este produto?')">Excluir</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <div class="text-center mt-3">
                <a href="index.php?acao=areaRestrita" class="btn btn-secondary">Voltar</a>
            </div>
        </div>
        <?php
        include __DIR__ . '/../footer.php';
    }
    
    // Método para exibir detalhes de um produto (com carrossel)
    public function exibirDetalhesProduto($produto) {
        include __DIR__ . '/../header.php';
        ?>
        <div class="container text-center mt-5 mb-5">
            <div class="row text-center">
                <div class="d-flex justify-content-center mb-3">
                    <div class="card" style="width:30%; border-style:none;">
                        
                        <!-- Carousel -->
                        <div id="Produto" class="carousel slide" data-bs-ride="carousel">
                            
                            <!-- Indicators/dots -->
                            <div class="carousel-indicators">
                                <button type="button" data-bs-target="#Produto" data-bs-slide-to="0" class="active"></button>
                                <button type="button" data-bs-target="#Produto" data-bs-slide-to="1"></button>
                                <button type="button" data-bs-target="#Produto" data-bs-slide-to="2"></button>
                            </div>

                            <?php if($produto['statusProduto'] == 'esgotado'): ?>
                                <h1>Produto esgotado!</h1>
                            <?php endif; ?>

                            <!-- The slideshow/carousel -->
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="<?php echo $produto['fotoProduto']; ?>" alt="Nome do Produto" class="d-block" 
                                         <?php if($produto['statusProduto'] == 'esgotado') {echo "style='width: 100%; filter:grayscale(100%)'";} else {echo "style='width:100%'";}?> >
                                </div>
                                <div class="carousel-item">
                                    <img src="<?php echo $produto['fotoProduto']; ?>" alt="Nome do Produto" class="d-block" 
                                         <?php if($produto['statusProduto'] == 'esgotado') {echo "style='width: 100%; filter:grayscale(100%)'";} else {echo "style='width:100%'";}?> >
                                </div>
                                <div class="carousel-item">
                                    <img src="<?php echo $produto['fotoProduto']; ?>" alt="Nome do Produto" class="d-block" 
                                         <?php if($produto['statusProduto'] == 'esgotado') {echo "style='width: 100%; filter:grayscale(100%)'";} else {echo "style='width:100%'";}?> >
                                </div>
                            </div>

                            <!-- Left and right controls/icons -->
                            <button class="carousel-control-prev" type="button" data-bs-target="#Produto" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#Produto" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                        </div>
                        
                        <div class="card-body">
                            <h4 class="card-title"><b><?php echo $produto['nomeProduto']; ?></b></h4>
                            <p class="card-text"><?php echo $produto['descricaoProduto']; ?></p>
                            <p class="card-text">Valor: <b>R$ <?php echo number_format($produto['valorProduto'], 2, ',', '.'); ?></b></p>
                            <div class="card bg-light">
                                <div class="card-body">
                                    <?php
                                        if(isset($_SESSION['logado']) && $_SESSION['logado'] === true){
                                            if($_SESSION['tipoUsuario'] == 'cliente'){
                                                if($produto['statusProduto'] == 'disponivel'){
                                                    echo "
                                                        <form action='index.php?acao=efetuarCompra' method='POST'>
                                                            <input type='hidden' name='idProduto' value='{$produto['idProduto']}'>
                                                            <input type='hidden' name='fotoProduto' value='{$produto['fotoProduto']}'>
                                                            <input type='hidden' name='nomeProduto' value='{$produto['nomeProduto']}'>
                                                            <input type='hidden' name='valorProduto' value='{$produto['valorProduto']}'>
                                                            <button type='submit' class='btn btn-outline-success'>
                                                                <i class='bi bi-bag-plus' style='font-size:16pt;'></i>
                                                                Efetuar Compra
                                                            </button>
                                                        </form>
                                                    ";
                                                } else {
                                                    echo "
                                                        <div class='alert alert-secondary'>
                                                            Produto esgotado!  <i class='bi bi-emoji-frown'></i>
                                                        </div>
                                                    ";
                                                }
                                            } else {
                                                echo "
                                                    <a href='index.php?acao=editarProduto&id={$produto['idProduto']}' class='btn btn-outline-primary'>
                                                        <i class='bi bi-pencil-square' style='font-size:16pt;'></i>
                                                        Editar Produto
                                                    </a>
                                                ";
                                            }
                                        } else {
                                            echo "
                                                <div class='alert alert-info'>
                                                    <a href='index.php?acao=login' class='alert-link'>
                                                        <i class='bi bi-person' style='font-size:16pt;'></i> 
                                                        <strong>Acesse o sistema</strong>
                                                    </a> para comprar!
                                                </div>
                                            ";
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        include __DIR__ . '/../footer.php';
    }
    
    // Método para exibir formulário de edição
    public function exibirFormularioEdicao($produto) {
        include __DIR__ . '/../header.php';
        ?>
        <div class="container text-center mb-3 mt-3">
            <h2>Editar Produto:</h2>
            <div class="d-flex justify-content-center mb-3">
                <div class="row">
                    <div class="col-12">
                        <form action="index.php?acao=atualizarProduto&id=<?php echo $produto['idProduto']; ?>" method="POST" class="was-validated" enctype="multipart/form-data">
                            <div class="form-floating mb-3 mt-3">
                                <input type="text" class="form-control" name="idProduto" value="<?php echo $produto['idProduto']; ?>" readonly>
                                <label for="idProduto" class="form-label">*ID:</label>
                            </div>
                            
                            <div class="form-group mb-3">
                                <img src="<?php echo $produto['fotoProduto']; ?>" width="100" class="mb-2">
                                <input type="hidden" name="fotoAtual" value="<?php echo $produto['fotoProduto']; ?>">
                                <input type="file" class="btn btn-link" name="fotoProduto">
                            </div>
                            
                            <div class="form-floating mb-3 mt-3">
                                <input type="text" class="form-control" id="nomeProduto" placeholder="Nome" name="nomeProduto" value="<?php echo $produto['nomeProduto']; ?>" required>
                                <label for="nomeProduto">Nome do Produto</label>
                            </div>
                            
                            <div class="form-floating mb-3 mt-3">
                                <textarea class="form-control" id="descricaoProduto" placeholder="Informe uma breve descrição sobre o Produto" name="descricaoProduto" required><?php echo $produto['descricaoProduto']; ?></textarea>
                                <label for="descricaoProduto">Descrição do Produto</label>
                            </div>
                            
                            <div class="form-floating mt-3 mb-3">
                                <input type="number" step="0.01" class="form-control" id="valorProduto" placeholder="Valor do Produto" name="valorProduto" value="<?php echo $produto['valorProduto']; ?>" required>
                                <label for="valorProduto">Valor do Produto (R$):</label>
                            </div>
                            
                            <button type="submit" class="btn btn-warning">Atualizar Produto</button>
                            <a href="index.php?acao=listarProdutos" class="btn btn-secondary">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
        include __DIR__ . '/../footer.php';
    }
    
    // Método para exibir resultado de operações
    public function exibirResultado($resultado) {
        include __DIR__ . '/../header.php';
        ?>
        <div class="container mt-3 mb-3">
            <?php if ($resultado['sucesso']): ?>
                <div class="alert alert-success text-center"><?php echo $resultado['mensagem']; ?></div>
                
                <?php if (isset($resultado['dados'])): ?>
                    <div class="container mt-3">
                        <div class="mt-3 text-center">
                            <img src="<?php echo $resultado['dados']['fotoProduto']; ?>" style="width:150px" title="Foto de <?php echo $resultado['dados']['nomeProduto']; ?>">
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <tr><th>NOME</th><td><?php echo $resultado['dados']['nomeProduto']; ?></td></tr>
                                <tr><th>DESCRIÇÃO</th><td><?php echo $resultado['dados']['descricaoProduto']; ?></td></tr>
                                <tr><th>VALOR</th><td>R$ <?php echo number_format($resultado['dados']['valorProduto'], 2, ',', '.'); ?></td></tr>
                            </table>
                        </div>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="alert alert-danger text-center"><?php echo $resultado['mensagem']; ?></div>
            <?php endif; ?>
            
            <div class="text-center mt-3">
                <a href="index.php?acao=cadastroProduto" class="btn btn-primary">Novo Produto</a>
                <a href="index.php?acao=listarProdutos" class="btn btn-secondary">Listar Produtos</a>
                <a href="index.php?acao=areaRestrita" class="btn btn-info">Área Restrita</a>
            </div>
        </div>
        <?php
        include __DIR__ . '/../footer.php';
    }
    
    // Método para exibir lista de produtos em tabela
    public function exibirListaTabela($produtos) {
        include __DIR__ . '/../header.php';
        ?>
        <div class="container mt-3 mb-3">
            <h3 class="text-center">Listar registros em uma tabela:</h3>
            
            <div class="alert alert-info text-center">
                Há <strong><?php echo count($produtos); ?></strong> produtos cadastrados no sistema!
            </div>
            
            <div class="table-responsive">
                <table class="table">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>FOTO</th>
                            <th>NOME</th>
                            <th>DESCRIÇÃO</th>
                            <th>VALOR</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($produtos as $produto): ?>
                            <tr>
                                <td><?php echo $produto['idProduto']; ?></td>
                                <td><img src="<?php echo $produto['fotoProduto']; ?>" title="Foto de <?php echo $produto['nomeProduto']; ?>" style="width:50px;"></td>
                                <td><?php echo $produto['nomeProduto']; ?></td>
                                <td><?php echo $produto['descricaoProduto']; ?></td>
                                <td>R$ <?php echo number_format($produto['valorProduto'], 2, ',', '.'); ?></td>
                                <td><?php echo $produto['statusProduto']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="text-center mt-3">
                <a href="index.php?acao=areaRestrita" class="btn btn-secondary">Voltar</a>
            </div>
        </div>
        <?php
        include __DIR__ . '/../footer.php';
    }
}
?> 