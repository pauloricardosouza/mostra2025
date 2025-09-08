<?php
// CONTROLLER - Responsável pela lógica de negócio
require_once __DIR__ . '/../models/Produto.php';

class ProdutoController {
    private $produtoModel;
    
    public function __construct($conexao) {
        $this->produtoModel = new Produto($conexao);
    }
    
    // Método para processar cadastro de produto
    public function cadastrar() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            // Validações
            $erros = $this->validarDados($_POST);
            
            if (empty($erros)) {
                // Processar upload da foto
                $fotoProduto = $this->processarUpload();
                
                if ($fotoProduto) {
                    // Preparar dados para cadastro
                    $dados = [
                        'fotoProduto' => $fotoProduto,
                        'nomeProduto' => $this->sanitizar($_POST['nomeProduto']),
                        'descricaoProduto' => $this->sanitizar($_POST['descricaoProduto']),
                        'valorProduto' => floatval($_POST['valorProduto'])
                    ];
                    
                    // Tentar cadastrar
                    if ($this->produtoModel->cadastrar($dados)) {
                        return ['sucesso' => true, 'mensagem' => 'Produto cadastrado com sucesso!', 'dados' => $dados];
                    } else {
                        return ['sucesso' => false, 'mensagem' => 'Erro ao cadastrar produto!'];
                    }
                } else {
                    return ['sucesso' => false, 'mensagem' => 'Erro no upload da foto!'];
                }
            } else {
                return ['sucesso' => false, 'mensagem' => 'Dados inválidos!', 'erros' => $erros];
            }
        }
        
        return ['sucesso' => false, 'mensagem' => 'Método inválido!'];
    }
    
    // Método para listar produtos
    public function listar() {
        $produtos = $this->produtoModel->listarTodos();
        return ['sucesso' => true, 'produtos' => $produtos];
    }
    
    // Método para listar produtos disponíveis
    public function listarDisponiveis() {
        $produtos = $this->produtoModel->listarDisponiveis();
        return ['sucesso' => true, 'produtos' => $produtos];
    }
    
    // Método para buscar produto por ID
    public function buscarPorId($id) {
        $produto = $this->produtoModel->buscarPorId($id);
        
        if ($produto) {
            return ['sucesso' => true, 'produto' => $produto];
        } else {
            return ['sucesso' => false, 'mensagem' => 'Produto não encontrado!'];
        }
    }
    
    // Método para atualizar produto
    public function atualizar($id) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            // Validações
            $erros = $this->validarDados($_POST);
            
            if (empty($erros)) {
                // Verificar se há nova foto
                $novaFoto = $this->processarUpload();
                
                if ($novaFoto) {
                    // Atualizar com nova foto
                    $dados = [
                        'fotoProduto' => $novaFoto,
                        'nomeProduto' => $this->sanitizar($_POST['nomeProduto']),
                        'descricaoProduto' => $this->sanitizar($_POST['descricaoProduto']),
                        'valorProduto' => floatval($_POST['valorProduto'])
                    ];
                    
                    $sucesso = $this->produtoModel->atualizarComFoto($id, $dados);
                } else {
                    // Atualizar sem nova foto
                    $dados = [
                        'nomeProduto' => $this->sanitizar($_POST['nomeProduto']),
                        'descricaoProduto' => $this->sanitizar($_POST['descricaoProduto']),
                        'valorProduto' => floatval($_POST['valorProduto'])
                    ];
                    
                    $sucesso = $this->produtoModel->atualizar($id, $dados);
                }
                
                if ($sucesso) {
                    return ['sucesso' => true, 'mensagem' => 'Produto atualizado com sucesso!'];
                } else {
                    return ['sucesso' => false, 'mensagem' => 'Erro ao atualizar produto!'];
                }
            } else {
                return ['sucesso' => false, 'mensagem' => 'Dados inválidos!', 'erros' => $erros];
            }
        }
        
        return ['sucesso' => false, 'mensagem' => 'Método inválido!'];
    }
    
    // Método para excluir produto
    public function excluir($id) {
        if ($this->produtoModel->excluir($id)) {
            return ['sucesso' => true, 'mensagem' => 'Produto excluído com sucesso!'];
        } else {
            return ['sucesso' => false, 'mensagem' => 'Erro ao excluir produto!'];
        }
    }
    
    // Método para buscar produtos por nome
    public function buscarPorNome($nome) {
        $produtos = $this->produtoModel->buscarPorNome($nome);
        return ['sucesso' => true, 'produtos' => $produtos];
    }
    
    // Método para atualizar status do produto
    public function atualizarStatus($id, $status) {
        if ($this->produtoModel->atualizarStatus($id, $status)) {
            return ['sucesso' => true, 'mensagem' => 'Status do produto atualizado!'];
        } else {
            return ['sucesso' => false, 'mensagem' => 'Erro ao atualizar status!'];
        }
    }
    
    // Método para obter estatísticas
    public function obterEstatisticas() {
        $estatisticas = $this->produtoModel->obterEstatisticas();
        return ['sucesso' => true, 'estatisticas' => $estatisticas];
    }
    
    // Método para verificar disponibilidade
    public function verificarDisponibilidade($id) {
        $disponivel = $this->produtoModel->verificarDisponibilidade($id);
        return ['sucesso' => true, 'disponivel' => $disponivel];
    }
    
    // Métodos auxiliares
    private function validarDados($dados) {
        $erros = [];
        
        if (empty($dados['nomeProduto'])) {
            $erros[] = 'Nome do produto é obrigatório';
        }
        
        if (empty($dados['descricaoProduto'])) {
            $erros[] = 'Descrição é obrigatória';
        }
        
        if (empty($dados['valorProduto']) || !is_numeric($dados['valorProduto'])) {
            $erros[] = 'Valor deve ser um número válido';
        }
        
        return $erros;
    }
    
    private function processarUpload() {
        if (isset($_FILES['fotoProduto']) && $_FILES['fotoProduto']['error'] == 0) {
            $diretorio = "public/img/";
            $nomeArquivo = $diretorio . basename($_FILES["fotoProduto"]["name"]);
            
            if (move_uploaded_file($_FILES['fotoProduto']['tmp_name'], $nomeArquivo)) {
                return $nomeArquivo;
            }
        }
        
        return false;
    }
    
    private function sanitizar($dado) {
        return htmlspecialchars(strip_tags(trim($dado)));
    }
}
?> 