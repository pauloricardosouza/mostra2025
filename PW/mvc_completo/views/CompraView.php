<?php
// VIEW - Responsável pela interface das compras
class CompraView {
    
    // Método para exibir resultado da compra
    public function exibirResultadoCompra($resultado) {
        include __DIR__ . '/../header.php';
        ?>
        <div class="container mt-3 mb-3">
            <?php if ($resultado['sucesso']): ?>
                <div class="alert alert-success text-center">
                    <?php echo $resultado['mensagem']; ?> <i class="bi bi-emoji-smile"></i>
                </div>
                
                <?php if (isset($resultado['dados'])): ?>
                    <div class="container mt-3">
                        <div class="mt-3 text-center">
                            <img src="<?php echo $resultado['dados']['fotoProduto']; ?>" style="width:300px" title="Foto de <?php echo $resultado['dados']['nomeProduto']; ?>">
                        </div>
                        <div class="text-center mt-3">
                            <h4><?php echo $resultado['dados']['nomeProduto']; ?></h4>
                            <p class="lead">Valor: R$ <?php echo number_format($resultado['dados']['valorProduto'], 2, ',', '.'); ?></p>
                        </div>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="alert alert-danger text-center">
                    <?php echo $resultado['mensagem']; ?> <i class="bi bi-emoji-frown"></i>
                </div>
            <?php endif; ?>
            
            <div class="text-center mt-3">
                <a href="index.php?acao=listarProdutos" class="btn btn-primary">Ver Produtos</a>
                <a href="index.php?acao=minhasCompras" class="btn btn-success">Minhas Compras</a>
                <a href="index.php?acao=areaRestrita" class="btn btn-secondary">Voltar</a>
            </div>
        </div>
        <?php
        include __DIR__ . '/../footer.php';
    }
    
    // Método para exibir lista de compras do usuário
    public function exibirMinhasCompras($compras) {
        include __DIR__ . '/../header.php';
        ?>
        <div class="container mt-3">
            <h2 class="text-center mb-4">Minhas Compras</h2>
            
            <?php if (empty($compras)): ?>
                <div class="alert alert-info text-center">
                    Você ainda não possui compras registradas!
                </div>
            <?php else: ?>
                <div class="alert alert-info text-center">
                    Você possui <strong><?php echo count($compras); ?></strong> compra(s) registrada(s)!
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>FOTO</th>
                                <th>NOME</th>
                                <th>DATA</th>
                                <th>HORA</th>
                                <th>VALOR</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($compras as $compra): ?>
                                <tr>
                                    <td><?php echo $compra['idCompra']; ?></td>
                                    <td>
                                        <img src="<?php echo $compra['fotoProduto']; ?>" 
                                             title="Foto de <?php echo $compra['nomeProduto']; ?>" 
                                             style="width:50px; height:50px; object-fit:cover;">
                                    </td>
                                    <td><?php echo $compra['nomeProduto']; ?></td>
                                    <td>
                                        <?php 
                                            $data = $compra['dataCompra'];
                                            echo substr($data, 8, 2) . '/' . substr($data, 5, 2) . '/' . substr($data, 0, 4);
                                        ?>
                                    </td>
                                    <td><?php echo $compra['horaCompra']; ?></td>
                                    <td>R$ <?php echo number_format($compra['valorCompra'], 2, ',', '.'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
            
            <div class="text-center mt-3">
                <a href="index.php?acao=listarProdutos" class="btn btn-primary">Ver Produtos</a>
                <a href="index.php?acao=areaRestrita" class="btn btn-secondary">Voltar</a>
            </div>
        </div>
        <?php
        include __DIR__ . '/../footer.php';
    }
    
    // Método para exibir todas as compras (admin)
    public function exibirTodasCompras($compras) {
        include __DIR__ . '/../header.php';
        ?>
        <div class="container mt-3">
            <h2 class="text-center mb-4">Todas as Compras</h2>
            
            <?php if (empty($compras)): ?>
                <div class="alert alert-info text-center">
                    Nenhuma compra registrada no sistema!
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>USUÁRIO</th>
                                <th>PRODUTO</th>
                                <th>FOTO</th>
                                <th>DATA</th>
                                <th>HORA</th>
                                <th>VALOR</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($compras as $compra): ?>
                                <tr>
                                    <td><?php echo $compra['idCompra']; ?></td>
                                    <td><?php echo $compra['nomeUsuario']; ?></td>
                                    <td><?php echo $compra['nomeProduto']; ?></td>
                                    <td>
                                        <img src="<?php echo $compra['fotoProduto']; ?>" 
                                             title="Foto de <?php echo $compra['nomeProduto']; ?>" 
                                             style="width:50px; height:50px; object-fit:cover;">
                                    </td>
                                    <td>
                                        <?php 
                                            $data = $compra['dataCompra'];
                                            echo substr($data, 8, 2) . '/' . substr($data, 5, 2) . '/' . substr($data, 0, 4);
                                        ?>
                                    </td>
                                    <td><?php echo $compra['horaCompra']; ?></td>
                                    <td>R$ <?php echo number_format($compra['valorCompra'], 2, ',', '.'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
            
            <div class="text-center mt-3">
                <a href="index.php?acao=areaRestrita" class="btn btn-secondary">Voltar</a>
            </div>
        </div>
        <?php
        include __DIR__ . '/../footer.php';
    }
    
    // Método para exibir estatísticas de compras
    public function exibirEstatisticas($estatisticas) {
        include __DIR__ . '/../header.php';
        ?>
        <div class="container mt-3">
            <h2 class="text-center mb-4">Estatísticas de Compras</h2>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Total de Compras</h5>
                            <h2 class="text-primary"><?php echo $estatisticas['total_compras']; ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Valor Total</h5>
                            <h2 class="text-success">R$ <?php echo number_format($estatisticas['valor_total'], 2, ',', '.'); ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Valor Médio</h5>
                            <h2 class="text-info">R$ <?php echo number_format($estatisticas['valor_medio'], 2, ',', '.'); ?></h2>
                        </div>
                    </div>
                </div>
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