<?php include ("header.php") ?>

<div class='container mt-3 mb-3'>

    <?php

        session_start(); //Inicia sessão

        if(isset($_SESSION['logado']) && $_SESSION['logado'] === true){ //Verifica se há sessão iniciada
            $idUsuario   = $_SESSION['idUsuario'];
            $tipoUsuario = $_SESSION['tipoUsuario'];

            if($tipoUsuario == 'cliente'){
                //Query para listar TODOS os registros da tabela Compras
                $listarCompras = "
                    SELECT 
                        Compras.idCompra,
                        Compras.dataCompra,
                        Compras.horaCompra,
                        Compras.valorCompra,
                        Produtos.nomeProduto,
                        Produtos.descricaoProduto,
                        Produtos.fotoProduto
                    FROM Compras
                    INNER JOIN Produtos ON Compras.idProduto = Produtos.idProduto
                    WHERE Compras.idUsuario = $idUsuario;
                ";

                include("conexaoBD.php");
                //A função mysqli_query é responsável pela execução de comandos SQL no Banco de Dados
                $res = mysqli_query($conn, $listarCompras) or die ("Erro ao tentar listar Compras");

                $totalCompras = mysqli_num_rows($res); //Busca o total de registros retornados pela QUERY

                echo "<div class='alert alert-info text-center'>Você possui <strong>$totalCompras</strong> compra(s) registrada(s)! </div>";

                //Montar o cabeçalho da tabela para exibir os registros
                echo "
                    <table class='table'>
                        <thead class='table-dark'>
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
                ";

                //Enquanto houver registros, executa a função abaixo para armazenar nas variáveis
                while($registro = mysqli_fetch_assoc($res)){
                    //Cria variáveis PHP e armazena os registros encontrados na tabela
                    $idCompra    = $registro['idCompra'];
                    $fotoProduto = $registro['fotoProduto'];
                    $nomeProduto = $registro['nomeProduto'];
                    $dataCompra  = $registro['dataCompra'];
                    //Usa a função substr para pegar partes da string
                    $diaCompra   = substr($dataCompra, 8, 2);
                    $mesCompra   = substr($dataCompra, 5, 2);
                    $anoCompra   = substr($dataCompra, 0, 4);
                    $horaCompra  = $registro['horaCompra'];
                    $valorCompra = $registro['valorCompra'];

                    //Exibe os valores armazenados nas variáveis
                    echo "
                        <tr>
                            <td>$idCompra</td>
                            <td><img src='$fotoProduto' title='Foto de $nomeProduto' style='width:50px;'></td>
                            <td>$nomeProduto</td>
                            <td>$diaCompra/$mesCompra/$anoCompra</td>
                            <td>$horaCompra</td>
                            <td>$valorCompra</td>
                        </tr>
                    ";
                }
                echo "</tbody>";
                echo "</table>";
                mysqli_close($conn); //Encerra a conexão com o banco de dados
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

<?php include ("footer.php") ?>