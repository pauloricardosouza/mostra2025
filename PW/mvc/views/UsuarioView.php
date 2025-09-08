<?php
// VIEW - Responsável pela interface do usuário
class UsuarioView {
    
    // Método para exibir formulário de cadastro
    public function exibirFormularioCadastro() {
        include 'header.php';
        ?>
        <div class="container text-center mb-3 mt-3">
            <h2>Cadastro de Usuário:</h2>
            <div class="d-flex justify-content-center mb-3">
                <div class="row">
                    <div class="col-12">
                        <form action="index.php?acao=cadastrar" method="POST" class="was-validated" enctype="multipart/form-data">
                            <div class="form-floating mb-3 mt-3">
                                <input type="file" class="form-control" id="fotoUsuario" name="fotoUsuario" required>
                                <label for="fotoUsuario">Foto</label>
                            </div>

                            <div class="form-floating mb-3 mt-3">
                                <input type="text" class="form-control" id="nomeUsuario" placeholder="Nome" name="nomeUsuario" required>
                                <label for="nomeUsuario">Nome Completo</label>
                            </div>

                            <div class="form-floating mb-3 mt-3">
                                <input type="date" class="form-control" id="dataNascimentoUsuario" name="dataNascimentoUsuario" required>
                                <label for="dataNascimentoUsuario">Data de Nascimento</label>
                            </div>
                            
                            <div class="form-floating mb-3 mt-3">
                                <select class="form-select" id="cidadeUsuario" name="cidadeUsuario" required>
                                    <option value="curiuva">Curiúva</option>
                                    <option value="imbau">Imbaú</option>
                                    <option value="ortigueira">Ortigueira</option>
                                    <option value="reserva">Reserva</option>
                                    <option value="telemacoBorba" selected>Telêmaco Borba</option>
                                    <option value="tibagi">Tibagi</option>
                                </select>
                                <label for="cidadeUsuario">Cidade</label>
                            </div>

                            <div class="form-floating mb-3 mt-3">
                                <input type="text" class="form-control" id="telefoneUsuario" placeholder="Telefone" name="telefoneUsuario" required>
                                <label for="telefoneUsuario">Telefone</label>
                            </div>
                            
                            <div class="form-floating mb-3 mt-3">
                                <input type="email" class="form-control" id="emailUsuario" placeholder="Email" name="emailUsuario" required>
                                <label for="emailUsuario">Email</label>
                            </div>
                            
                            <div class="form-floating mt-3 mb-3">
                                <input type="password" class="form-control" id="senhaUsuario" placeholder="Senha" name="senhaUsuario" required>
                                <label for="senhaUsuario">Senha</label>
                            </div>
                            
                            <div class="form-floating mt-3 mb-3">
                                <input type="password" class="form-control" id="confirmarSenhaUsuario" placeholder="Confirme a Senha" name="confirmarSenhaUsuario" required>
                                <label for="confirmarSenhaUsuario">Confirme a Senha</label>
                            </div>
                            
                            <button type="submit" class="btn btn-success">Cadastrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
        include 'footer.php';
    }
    
    // Método para exibir formulário de login
    public function exibirFormularioLogin($erro = null) {
        include 'header.php';
        ?>
        <div class="container text-center mb-3 mt-3">
            <?php if ($erro): ?>
                <div class="alert alert-danger text-center"><?php echo $erro; ?></div>
            <?php endif; ?>

            <h2>Acessar o Sistema:</h2>
            <div class="d-flex justify-content-center mb-3">
                <div class="row">
                    <div class="col-12">
                        <form action="index.php?acao=login" method="POST" class="was-validated">
                            <div class="form-floating mb-3 mt-3">
                                <input type="email" class="form-control" id="emailUsuario" placeholder="Email" name="emailUsuario" required>
                                <label for="emailUsuario">Email</label>
                            </div>
                            <div class="form-floating mt-3 mb-3">
                                <input type="password" class="form-control" id="senhaUsuario" placeholder="Senha" name="senhaUsuario" required>
                                <label for="senhaUsuario">Senha</label>
                            </div>
                            <button type="submit" class="btn btn-success">Login</button>
                        </form>
                    </div>
                </div>
            </div>

            <p>
                Ainda não possui cadastro? <a href="index.php?acao=cadastro">Clique aqui!</a>&nbsp<i class="bi bi-emoji-smile"></i>
            </p>
        </div>
        <?php
        include 'footer.php';
    }
    
    // Método para exibir resultado do cadastro
    public function exibirResultadoCadastro($resultado) {
        include 'header.php';
        ?>
        <div class="container mt-3 mb-3">
            <?php if ($resultado['sucesso']): ?>
                <div class="alert alert-success text-center"><?php echo $resultado['mensagem']; ?></div>
                
                <?php if (isset($resultado['dados'])): ?>
                    <div class="container mt-3">
                        <div class="mt-3 text-center">
                            <img src="<?php echo $resultado['dados']['fotoUsuario']; ?>" style="width:150px" title="Foto de <?php echo $resultado['dados']['nomeUsuario']; ?>">
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <tr><th>NOME</th><td><?php echo $resultado['dados']['nomeUsuario']; ?></td></tr>
                                <tr><th>DATA DE NASCIMENTO</th><td><?php echo $resultado['dados']['dataNascimentoUsuario']; ?></td></tr>
                                <tr><th>CIDADE</th><td><?php echo $resultado['dados']['cidadeUsuario']; ?></td></tr>
                                <tr><th>TELEFONE</th><td><?php echo $resultado['dados']['telefoneUsuario']; ?></td></tr>
                                <tr><th>EMAIL</th><td><?php echo $resultado['dados']['emailUsuario']; ?></td></tr>
                            </table>
                        </div>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="alert alert-danger text-center"><?php echo $resultado['mensagem']; ?></div>
            <?php endif; ?>
            
            <div class="text-center mt-3">
                <a href="index.php?acao=cadastro" class="btn btn-primary">Novo Cadastro</a>
                <a href="index.php?acao=login" class="btn btn-secondary">Fazer Login</a>
            </div>
        </div>
        <?php
        include 'footer.php';
    }
}
?> 