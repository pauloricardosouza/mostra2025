<?php
// MODEL - Responsável pelos dados e operações no banco
class Usuario {
    private $conn;
    
    public function __construct($conexao) {
        $this->conn = $conexao;
    }
    
    // Método para cadastrar usuário
    public function cadastrar($dados) {
        $sql = "INSERT INTO Usuarios (tipoUsuario, fotoUsuario, nomeUsuario, dataNascimentoUsuario, cidadeUsuario, telefoneUsuario, emailUsuario, senhaUsuario) 
                VALUES ('cliente', ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssssss", 
            $dados['fotoUsuario'],
            $dados['nomeUsuario'], 
            $dados['dataNascimentoUsuario'],
            $dados['cidadeUsuario'],
            $dados['telefoneUsuario'],
            $dados['emailUsuario'],
            $dados['senhaUsuario']
        );
        
        return $stmt->execute();
    }
    
    // Método para fazer login
    public function fazerLogin($email, $senha) {
        $sql = "SELECT * FROM Usuarios WHERE emailUsuario = ? AND senhaUsuario = ?";
        $stmt = $this->conn->prepare($sql);
        $senhaCriptografada = md5($senha);
        $stmt->bind_param("ss", $email, $senhaCriptografada);
        $stmt->execute();
        
        return $stmt->get_result()->fetch_assoc();
    }
    
    // Método para buscar usuário por email
    public function buscarPorEmail($email) {
        $sql = "SELECT * FROM Usuarios WHERE emailUsuario = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        
        return $stmt->get_result()->fetch_assoc();
    }
}
?> 