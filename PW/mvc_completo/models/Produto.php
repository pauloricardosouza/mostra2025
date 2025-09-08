<?php
// MODEL - Responsável pelos dados e operações no banco
class Produto {
    private $conn;
    
    public function __construct($conexao) {
        $this->conn = $conexao;
    }
    
    // Método para cadastrar produto
    public function cadastrar($dados) {
        $sql = "INSERT INTO Produtos (fotoProduto, nomeProduto, descricaoProduto, valorProduto, statusProduto) 
                VALUES (?, ?, ?, ?, 'disponivel')";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssd", 
            $dados['fotoProduto'],
            $dados['nomeProduto'], 
            $dados['descricaoProduto'],
            $dados['valorProduto']
        );
        
        return $stmt->execute();
    }
    
    // Método para listar todos os produtos
    public function listarTodos() {
        $sql = "SELECT * FROM Produtos ORDER BY nomeProduto";
        $result = $this->conn->query($sql);
        
        $produtos = [];
        while ($row = $result->fetch_assoc()) {
            $produtos[] = $row;
        }
        
        return $produtos;
    }
    
    // Método para listar produtos disponíveis
    public function listarDisponiveis() {
        $sql = "SELECT * FROM Produtos WHERE statusProduto = 'disponivel' ORDER BY nomeProduto";
        $result = $this->conn->query($sql);
        
        $produtos = [];
        while ($row = $result->fetch_assoc()) {
            $produtos[] = $row;
        }
        
        return $produtos;
    }
    
    // Método para buscar produto por ID
    public function buscarPorId($id) {
        $sql = "SELECT * FROM Produtos WHERE idProduto = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        return $stmt->get_result()->fetch_assoc();
    }
    
    // Método para atualizar produto
    public function atualizar($id, $dados) {
        $sql = "UPDATE Produtos SET nomeProduto = ?, descricaoProduto = ?, valorProduto = ? WHERE idProduto = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssdi", 
            $dados['nomeProduto'],
            $dados['descricaoProduto'],
            $dados['valorProduto'],
            $id
        );
        
        return $stmt->execute();
    }
    
    // Método para atualizar produto com foto
    public function atualizarComFoto($id, $dados) {
        $sql = "UPDATE Produtos SET fotoProduto = ?, nomeProduto = ?, descricaoProduto = ?, valorProduto = ? WHERE idProduto = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssdi", 
            $dados['fotoProduto'],
            $dados['nomeProduto'],
            $dados['descricaoProduto'],
            $dados['valorProduto'],
            $id
        );
        
        return $stmt->execute();
    }
    
    // Método para excluir produto
    public function excluir($id) {
        $sql = "DELETE FROM Produtos WHERE idProduto = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        
        return $stmt->execute();
    }
    
    // Método para buscar produtos por nome
    public function buscarPorNome($nome) {
        $sql = "SELECT * FROM Produtos WHERE nomeProduto LIKE ? ORDER BY nomeProduto";
        $stmt = $this->conn->prepare($sql);
        $nomeBusca = "%$nome%";
        $stmt->bind_param("s", $nomeBusca);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $produtos = [];
        while ($row = $result->fetch_assoc()) {
            $produtos[] = $row;
        }
        
        return $produtos;
    }
    
    // Método para atualizar status do produto
    public function atualizarStatus($id, $status) {
        $sql = "UPDATE Produtos SET statusProduto = ? WHERE idProduto = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $status, $id);
        
        return $stmt->execute();
    }
    
    // Método para obter estatísticas de produtos
    public function obterEstatisticas() {
        $sql = "SELECT 
                    COUNT(*) as total_produtos,
                    COUNT(CASE WHEN statusProduto = 'disponivel' THEN 1 END) as produtos_disponiveis,
                    COUNT(CASE WHEN statusProduto = 'esgotado' THEN 1 END) as produtos_esgotados,
                    AVG(valorProduto) as valor_medio
                FROM Produtos";
        
        $result = $this->conn->query($sql);
        return $result->fetch_assoc();
    }
    
    // Método para verificar se produto está disponível
    public function verificarDisponibilidade($id) {
        $sql = "SELECT statusProduto FROM Produtos WHERE idProduto = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        $result = $stmt->get_result()->fetch_assoc();
        return $result && $result['statusProduto'] === 'disponivel';
    }
}
?> 