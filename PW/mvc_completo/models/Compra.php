<?php
// MODEL - Responsável pelos dados e operações no banco
class Compra {
    private $conn;
    
    public function __construct($conexao) {
        $this->conn = $conexao;
    }
    
    // Método para efetuar uma compra
    public function efetuarCompra($dados) {
        // Iniciar transação
        $this->conn->begin_transaction();
        
        try {
            // Inserir compra
            $sql = "INSERT INTO Compras (idUsuario, idProduto, dataCompra, horaCompra, valorCompra) 
                    VALUES (?, ?, ?, ?, ?)";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iissd", 
                $dados['idUsuario'],
                $dados['idProduto'],
                $dados['dataCompra'],
                $dados['horaCompra'],
                $dados['valorCompra']
            );
            
            if (!$stmt->execute()) {
                throw new Exception("Erro ao inserir compra");
            }
            
            // Atualizar status do produto para esgotado
            $sqlUpdate = "UPDATE Produtos SET statusProduto = 'esgotado' WHERE idProduto = ?";
            $stmtUpdate = $this->conn->prepare($sqlUpdate);
            $stmtUpdate->bind_param("i", $dados['idProduto']);
            
            if (!$stmtUpdate->execute()) {
                throw new Exception("Erro ao atualizar status do produto");
            }
            
            // Commit da transação
            $this->conn->commit();
            return true;
            
        } catch (Exception $e) {
            // Rollback em caso de erro
            $this->conn->rollback();
            return false;
        }
    }
    
    // Método para listar compras de um usuário
    public function listarComprasUsuario($idUsuario) {
        $sql = "SELECT 
                    Compras.idCompra,
                    Compras.dataCompra,
                    Compras.horaCompra,
                    Compras.valorCompra,
                    Produtos.nomeProduto,
                    Produtos.descricaoProduto,
                    Produtos.fotoProduto
                FROM Compras
                INNER JOIN Produtos ON Compras.idProduto = Produtos.idProduto
                WHERE Compras.idUsuario = ?
                ORDER BY Compras.dataCompra DESC, Compras.horaCompra DESC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $idUsuario);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $compras = [];
        
        while ($row = $result->fetch_assoc()) {
            $compras[] = $row;
        }
        
        return $compras;
    }
    
    // Método para buscar compra por ID
    public function buscarPorId($idCompra) {
        $sql = "SELECT 
                    Compras.*,
                    Produtos.nomeProduto,
                    Produtos.descricaoProduto,
                    Produtos.fotoProduto,
                    Usuarios.nomeUsuario
                FROM Compras
                INNER JOIN Produtos ON Compras.idProduto = Produtos.idProduto
                INNER JOIN Usuarios ON Compras.idUsuario = Usuarios.idUsuario
                WHERE Compras.idCompra = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $idCompra);
        $stmt->execute();
        
        return $stmt->get_result()->fetch_assoc();
    }
    
    // Método para listar todas as compras (admin)
    public function listarTodasCompras() {
        $sql = "SELECT 
                    Compras.*,
                    Produtos.nomeProduto,
                    Produtos.descricaoProduto,
                    Produtos.fotoProduto,
                    Usuarios.nomeUsuario
                FROM Compras
                INNER JOIN Produtos ON Compras.idProduto = Produtos.idProduto
                INNER JOIN Usuarios ON Compras.idUsuario = Usuarios.idUsuario
                ORDER BY Compras.dataCompra DESC, Compras.horaCompra DESC";
        
        $result = $this->conn->query($sql);
        $compras = [];
        
        while ($row = $result->fetch_assoc()) {
            $compras[] = $row;
        }
        
        return $compras;
    }
    
    // Método para obter estatísticas de compras
    public function obterEstatisticas() {
        $sql = "SELECT 
                    COUNT(*) as total_compras,
                    SUM(valorCompra) as valor_total,
                    AVG(valorCompra) as valor_medio
                FROM Compras";
        
        $result = $this->conn->query($sql);
        return $result->fetch_assoc();
    }
}
?> 