<?php include "header.php" ?>

<div class='container mt-3 mb-3'>

    <?php 

        session_start(); //Inicia sessão

        if(isset($_SESSION['logado']) && $_SESSION['logado'] === true){ //Verifica se há sessão iniciada

            if(isset($_POST['idProduto'])){
        
                $idUsuario    = $_SESSION['idUsuario']; //Captura o id do usuário logado (pela sessão)
                $idProduto    = $_POST['idProduto']; //Recebe o idProduto via array POST
                $fotoProduto  = $_POST['fotoProduto']; //Recebe a fotoProduto via array POST
                $nomeProduto  = $_POST['nomeProduto']; //Recebe o nomeProduto via array POST
                $valorCompra  = $_POST['valorProduto']; //Recebe o valorProduto via array POST
                $dataCompra   = date('Y-m-d'); //Captura a data atual
                $horaCompra   = date('H:i:s'); //Captura a hora atual

                //Query para inserir a compra na tabela Compras
                $efetuarCompra = "INSERT INTO Compras (idUsuario, idProduto, dataCompra, horaCompra, valorCompra) VALUES ($idUsuario, $idProduto, '$dataCompra', '$horaCompra', $valorCompra)";
                $atualizarStatusProduto = "UPDATE Produtos SET statusProduto = 'esgotado' WHERE idProduto = $idProduto";
                // Inclui o arquivo de conexão com o banco
                include("conexaoBD.php");

                if(mysqli_query($conn, $efetuarCompra)){
                    if(mysqli_query($conn, $atualizarStatusProduto)){
                        echo "<div class='alert alert-success text-center'>Você comprou $nomeProduto! <i class='bi bi-emoji-smile'></i></div>";
                                    
                        echo "
                            <div class='container mt-3'>
                                <div class='mt-3 text-center'>
                                    <img src='$fotoProduto' style='width:300px' title='Foto de $nomeProduto'>
                                </div>
                            </div>
                        ";
                    }
                    else{
                        echo "
                            <div class='alert alert-danger text-center'>Erro ao tentar realizar a compra (STATUS)! <i class='bi bi-emoji-frown'></i></div>
                        ";
                    }
                }
                else{
                    echo "
                        <div class='alert alert-danger text-center'>Erro ao tentar realizar a compra! <i class='bi bi-emoji-frown'></i></div>
                    " . mysqli_error($conn) . $efetuarCompra;
                }
            }
            else{
                header('location:index.php');
            }
        }
        else{
            header('location:index.php');
        }

    ?>
</div>

<?php include "footer.php" ?>