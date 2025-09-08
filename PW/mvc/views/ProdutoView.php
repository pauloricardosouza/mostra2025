<?php
// VIEW - Responsável pela interface do produto
class ProdutoView {
    
    // Método para exibir formulário de cadastro de produto
    public function exibirFormularioCadastro() {
        include 'header.php';
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
        include 'footer.php';
    }
    
    // Método para exibir lista de produtos
    public function exibirListaProdutos($produtos) {
        include 'header.php';
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
        include 'footer.php';
    }
    
    // Método para exibir detalhes de um produto
    public function exibirDetalhesProduto($produto) {
        include 'header.php';
        ?>
        <div class="container mt-3">
            <div class="row">
                <div class="col-md-6">
                    <img src="<?php echo $produto['fotoProduto']; ?>" class="img-fluid" alt="<?php echo $produto['nomeProduto']; ?>">
                </div>
                <div class="col-md-6">
                    <h2><?php echo $produto['nomeProduto']; ?></h2>
                    <p class="lead"><?php echo $produto['descricaoProduto']; ?></p>
                    <h3 class="text-success">R$ <?php echo number_format($produto['valorProduto'], 2, ',', '.'); ?></h3>
                    <p><strong>Status:</strong> <?php echo $produto['statusProduto']; ?></p>
                    
                    <div class="btn-group" role="group">
                        <a href="index.php?acao=editarProduto&id=<?php echo $produto['idProduto']; ?>" class="btn btn-warning">Editar</a>
                        <a href="index.php?acao=listarProdutos" class="btn btn-secondary">Voltar à Lista</a>
                    </div>
                </div>
            </div>
        </div>
        <?php
        include 'footer.php';
    }
    
    // Método para exibir formulário de edição
    public function exibirFormularioEdicao($produto) {
        include 'header.php';
        ?>
        <div class="container text-center mb-3 mt-3">
            <h2>Editar Produto:</h2>
            <div class="d-flex justify-content-center mb-3">
                <div class="row">
                    <div class="col-12">
                        <form action="index.php?acao=atualizarProduto&id=<?php echo $produto['idProduto']; ?>" method="POST" class="was-validated">
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
        include 'footer.php';
    }
    
    // Método para exibir resultado de operações
    public function exibirResultado($resultado) {
        include 'header.php';
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
        include 'footer.php';
    }
}
?> 