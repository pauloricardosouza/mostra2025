<?php
// CONTROLLER - Responsável pela lógica de negócio
require_once __DIR__ . '/../models/Usuario.php';

class UsuarioController {
    private $usuarioModel;
    
    public function __construct($conexao) {
        $this->usuarioModel = new Usuario($conexao);
    }
    
    // Método para processar cadastro
    public function cadastrar() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            // Validações
            $erros = $this->validarDados($_POST);
            
            if (empty($erros)) {
                // Processar upload da foto
                $fotoUsuario = $this->processarUpload();
                
                if ($fotoUsuario) {
                    // Preparar dados para cadastro
                    $dados = [
                        'fotoUsuario' => $fotoUsuario,
                        'nomeUsuario' => $this->sanitizar($_POST['nomeUsuario']),
                        'dataNascimentoUsuario' => $_POST['dataNascimentoUsuario'],
                        'cidadeUsuario' => $_POST['cidadeUsuario'],
                        'telefoneUsuario' => $this->sanitizar($_POST['telefoneUsuario']),
                        'emailUsuario' => $this->sanitizar($_POST['emailUsuario']),
                        'senhaUsuario' => md5($_POST['senhaUsuario'])
                    ];
                    
                    // Tentar cadastrar
                    if ($this->usuarioModel->cadastrar($dados)) {
                        return ['sucesso' => true, 'mensagem' => 'Usuário cadastrado com sucesso!', 'dados' => $dados];
                    } else {
                        return ['sucesso' => false, 'mensagem' => 'Erro ao cadastrar usuário!'];
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
    
    // Método para processar login
    public function fazerLogin() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $this->sanitizar($_POST['emailUsuario']);
            $senha = $_POST['senhaUsuario'];
            
            if (empty($email) || empty($senha)) {
                return ['sucesso' => false, 'mensagem' => 'Email e senha são obrigatórios!'];
            }
            
            $usuario = $this->usuarioModel->fazerLogin($email, $senha);
            
            if ($usuario) {
                // Criar sessão
                session_start();
                $_SESSION['logado'] = true;
                $_SESSION['idUsuario'] = $usuario['idUsuario'];
                $_SESSION['nomeUsuario'] = $usuario['nomeUsuario'];
                $_SESSION['tipoUsuario'] = $usuario['tipoUsuario'];
                
                return ['sucesso' => true, 'mensagem' => 'Login realizado com sucesso!', 'usuario' => $usuario];
            } else {
                return ['sucesso' => false, 'mensagem' => 'Email ou senha inválidos!'];
            }
        }
        
        return ['sucesso' => false, 'mensagem' => 'Método inválido!'];
    }
    
    // Métodos auxiliares
    private function validarDados($dados) {
        $erros = [];
        
        if (empty($dados['nomeUsuario'])) {
            $erros[] = 'Nome é obrigatório';
        }
        
        if (empty($dados['emailUsuario'])) {
            $erros[] = 'Email é obrigatório';
        }
        
        if (empty($dados['senhaUsuario'])) {
            $erros[] = 'Senha é obrigatória';
        }
        
        return $erros;
    }
    
    private function processarUpload() {
        if (isset($_FILES['fotoUsuario']) && $_FILES['fotoUsuario']['error'] == 0) {
            $diretorio = "public/img/";
            $nomeArquivo = $diretorio . basename($_FILES["fotoUsuario"]["name"]);
            
            if (move_uploaded_file($_FILES['fotoUsuario']['tmp_name'], $nomeArquivo)) {
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