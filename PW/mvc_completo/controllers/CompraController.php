<?php
// CONTROLLER - Responsável pela lógica de negócio
require_once __DIR__ . '/../models/Compra.php';
require_once __DIR__ . '/../models/Produto.php';

class CompraController {
    private $compraModel;
    private $produtoModel;
    
    public function __construct($conexao) {
        $this->compraModel = new Compra($conexao);
        $this->produtoModel = new Produto($conexao);
    }
    
    // Método para efetuar compra
    public function efetuarCompra($dadosCompra) {
        // Verificar se o produto está disponível
        if (!$this->produtoModel->verificarDisponibilidade($dadosCompra['idProduto'])) {
            return ['sucesso' => false, 'mensagem' => 'Produto não está disponível para compra!'];
        }
        
        // Preparar dados da compra
        $dados = [
            'idUsuario' => $dadosCompra['idUsuario'],
            'idProduto' => $dadosCompra['idProduto'],
            'dataCompra' => date('Y-m-d'),
            'horaCompra' => date('H:i:s'),
            'valorCompra' => $dadosCompra['valorCompra']
        ];
        
        // Efetuar compra
        if ($this->compraModel->efetuarCompra($dados)) {
            return [
                'sucesso' => true, 
                'mensagem' => 'Compra realizada com sucesso!',
                'dados' => $dadosCompra
            ];
        } else {
            return ['sucesso' => false, 'mensagem' => 'Erro ao realizar compra!'];
        }
    }
    
    // Método para listar compras do usuário
    public function listarComprasUsuario($idUsuario) {
        $compras = $this->compraModel->listarComprasUsuario($idUsuario);
        return ['sucesso' => true, 'compras' => $compras];
    }
    
    // Método para listar todas as compras (admin)
    public function listarTodasCompras() {
        $compras = $this->compraModel->listarTodasCompras();
        return ['sucesso' => true, 'compras' => $compras];
    }
    
    // Método para buscar compra por ID
    public function buscarPorId($idCompra) {
        $compra = $this->compraModel->buscarPorId($idCompra);
        
        if ($compra) {
            return ['sucesso' => true, 'compra' => $compra];
        } else {
            return ['sucesso' => false, 'mensagem' => 'Compra não encontrada!'];
        }
    }
    
    // Método para obter estatísticas
    public function obterEstatisticas() {
        $estatisticas = $this->compraModel->obterEstatisticas();
        return ['sucesso' => true, 'estatisticas' => $estatisticas];
    }
    
    // Método para validar dados da compra
    private function validarDadosCompra($dados) {
        $erros = [];
        
        if (empty($dados['idUsuario'])) {
            $erros[] = 'ID do usuário é obrigatório';
        }
        
        if (empty($dados['idProduto'])) {
            $erros[] = 'ID do produto é obrigatório';
        }
        
        if (empty($dados['valorCompra']) || !is_numeric($dados['valorCompra'])) {
            $erros[] = 'Valor da compra deve ser um número válido';
        }
        
        return $erros;
    }
}
?> 