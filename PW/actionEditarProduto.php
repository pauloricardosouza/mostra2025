<?php include "header.php" ?>

<div class='container mt-3 mb-3'>

<?php

    //Verifica o método de requisição do servidor
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        //Bloco para declaração de variáveis
        $fotoProduto = $nomeProduto = $descricadoProduto = $valorProduto = "";
        $erroPreenchimento = false;

        $idProduto   = testar_entrada($_POST["idProduto"]); //Recebe o ID do Produto para sabermos de quem são os dados que deverão ser atualizados

        //Validação do campo nomeProduto
        //Utiliza a função empty para verificar se o campo está vazio
        if(empty($_POST["nomeProduto"])){
            echo "<div class='alert alert-warning text-center'>
                    O campo <strong>NOME</strong> é obrigatório!
                </div>
            ";
            $erroPreenchimento = true;
        }
        else{
            //Armazena o valor na variável
            $nomeProduto = testar_entrada($_POST["nomeProduto"]);
        }

        //Validação do campo descricaoProduto
        //Utiliza a função empty para verificar se o campo está vazio
        if(empty($_POST["descricaoProduto"])){
            echo "<div class='alert alert-warning text-center'>
                    O campo <strong>DESCRIÇÃO</strong> é obrigatório!
                </div>
            ";
            $erroPreenchimento = true;
        }
        else{
            //Armazena o valor na variável
            $descricaoProduto = testar_entrada($_POST["descricaoProduto"]);
        }

        //Validação do campo valorProduto
        //Utiliza a função empty para verificar se o campo está vazio
        if(empty($_POST["valorProduto"])){
            echo "<div class='alert alert-warning text-center'>
                    O campo <strong>VALOR</strong> é obrigatório!
                </div>
            ";
            $erroPreenchimento = true;
        }
        else{
            //Armazena o valor na variável
            $valorProduto = testar_entrada($_POST["valorProduto"]);
        }

        //Início da validação do campo FOTO
        $diretorio    = "img/"; //Define para qual diretório do sistema as imagens serão movidas
        $fotoProduto  = $diretorio . basename($_FILES["fotoProduto"]["name"]); //img/nomeDaFoto
        $erroUpload   = false; //Variável para verificar erros no upload
        $tipoDaImagem = strtolower(pathinfo($fotoProduto, PATHINFO_EXTENSION));//Converter para minúsculo e adquirir a extensão do arquivo

        //Verificar se tamanho do arquivo é maior do que zero
        if ($_FILES['fotoProduto']['size'] != 0){

            //Verificar se o tamanho do arquivo é maior do que 5MB (Em bytes)
            if($_FILES['fotoProduto']['size'] > 5000000){
                echo "<div class='alert alert-warning text-center'>
                        A <strong>FOTO</strong> não deve possuir mais do que 5MB!
                    </div>";
                $erroUpload = true;
            }

            //Verificar o tipo do arquivo (pela extensão)
            if($tipoDaImagem != "jpg" && $tipoDaImagem != "jpeg" && $tipoDaImagem != "png" && $tipoDaImagem != "webp"){
                echo "<div class='alert alert-warning text-center'>
                    A <strong>FOTO</strong> deve estar no formato JPG, JPEG, PNG ou WEBP!
                </div>";
                $erroUpload = true;
            }

            //Verifica se houve algum erro no upload
            if($erroUpload){
                echo "<div class='alert alert-warning text-center'>
                    Erro ao tentar fazer o upload da <strong>FOTO</strong>!
                </div>";
                $erroUpload = true;
            }
            else{
                //Usa a função move_uploaded_file para mover o arquivo para o diretório img
                if(!move_uploaded_file($_FILES['fotoProduto']['tmp_name'], $fotoProduto)){
                    echo "<div class='alert alert-warning text-center'>
                        Erro ao tentar mover a <strong>FOTO</strong> para o diretório $diretorio!
                    </div>";
                $erroUpload = true;
                }
            }

        }
        else {
            $fotoProduto = $_POST["fotoAtual"]; //Caso não haja atualização da foto, mantém a foto atual
            $erroUpload = false;
        }

        //Se não houver erro de preenchimento ou erro de upload
        if(!$erroPreenchimento && !$erroUpload){

            //Cria a Query Responsável por realizar a alteraçoes dos dados do(a) Produto na Base de Dados
            $editarProduto = "UPDATE Produtos
                        SET
                            fotoProduto           = '$fotoProduto',
                            nomeProduto           = '$nomeProduto',
                            descricaoProduto      = '$descricaoProduto',
                            valorProduto          = '$valorProduto',
                            statusProduto         = 'disponivel'
                        WHERE idProduto = $idProduto";

            //Inclui o arquivo de conexão com o BD
            include "conexaoBD.php";

            //Se a query for executada com sucesso, exibe mensagem e tabela
            if(mysqli_query($conn, $editarProduto)){

                echo "<div class='alert alert-success text-center'>Produto(a) editado(a) com sucesso!</div>";
                
                echo "<div class='container mt-3'>
                        <div class='mt-3 text-center'>
                            <img src='$fotoProduto' style='width:150px' title='Foto de $nomeProduto'>
                        </div>
                        <div class='table-responsive'>
                            <table class='table'>
                                <tr>
                                    <th>NOME</th>
                                    <td>$nomeProduto</td>
                                </tr>
                                <tr>
                                    <th>DESCRIÇÃO PRODUTO</th>
                                    <td>$descricaoProduto</td>
                                </tr>
                                <tr>
                                    <th>VALOR</th>
                                    <td>$valorProduto</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                
                ";
                mysqli_close($conn); //Encerra a conexão com o banco de dados
            }
            //Se não conseguir editar dados do Produto na base de dados, emite alerta danger
            else{
                echo "<div class='alert alert-danger text-center'>
                            Erro ao tentar editar dados do <strong>Produto</strong>!
                        </div>" . $editarProduto;
            }
        }
    }
    else{
        //Redireciona para a página formUsuario.php
        header("location:formProduto.php");
    }

    function testar_entrada($dado){
        $dado = trim($dado); //TRIM - Remove espaços desnecessários
        $dado = stripslashes($dado); //Remove barras invertidas
        $dado = htmlspecialchars($dado); //Converte caracteres especiais

        return($dado);
    }

?>

</div>

<?php include "footer.php" ?>