<?php include "header.php"; ?>
        
        <div class="container mt-5 mb-5">

            <?php

                //Inclui o arquivo de conexão com o Banco de Dados
                include("conexaoBD.php");

                $listarProdutos = "SELECT * FROM Produtos"; //Seleciona todos os campos da tabela Produtos

                //Aqui fazer os códigos da passagem de parâmetros por get, no final!!!

                $res = mysqli_query($conn, $listarProdutos); //Executa o comando de listagem
                $totalProdutos = mysqli_num_rows($res); //Função para retornar a quantidade de registros da tabela

                //Aqui fazer os códigos IF/ELSE para o número de produtos cadastrados
            ?>
            <div class="alert alert-info text-center">Há <strong>X</strong> produtos cadastrados!</div>
            <form name="formFiltro" action="index.php" method="GET">
                <div class="form-floating mt-3">
                    <select class="form-select" name="filtroProduto" required>
                        <option value="todos">Visualizar todos os Produtos</option>
                        <option value="disponivel">Visualizar apenas Produtos disponíveis</option>
                        <option value="esgotado">Visualizar apenas Produtos esgotados</option>
                    </select>
                    <label for="filtroProduto">Selecione um Filtro</label>
                    <br>
                </div>
                <button type="submit" class="btn btn-success" style='float:right'><i class='bi bi-funnel'></i>  Filtrar Produtos</button><br>
            </form>

            <hr>

            <div class="row">

                <?php
                    //Aqui ficará o while para listar os produtos
                    //Varre a tabela em busca de registros e armazena em um array
                    //Enquanto houverem dados na linha da tabela, atribui o valor atual do array a uma variável
                    while($registro = mysqli_fetch_assoc($res)){
                        $idProduto        = $registro["idProduto"];
                        $fotoProduto      = $registro["fotoProduto"];
                        $nomeProduto      = $registro["nomeProduto"];
                        $descricaoProduto = $registro["descricaoProduto"];
                        $valorProduto     = $registro["valorProduto"];
                        $statusProduto    = $registro["statusProduto"];
                        echo "
                            <div class='col-sm-3'>

                                <div class='card' style='width:100%; height:100%;'>
                                    <div class='card-body' style='height:100%'>
                                        <a href='visualizarProduto.php' style='text-decoration:none;' title='Visualizar Produto de $nomeProduto'>
                                            <img class='card-img-top' src='$fotoProduto' alt='Foto de $nomeProduto'>
                                        </a>
                                    </div>
                                    <div class='card-body text-center'>
                                        <h4 class='card-title'>Nome do Produto</h4>
                                        <p class='card-text'>Valor: <b>R$ $valo</b></p>
                                        <div class='d-grid' style='border-size:border-box'>
                                            <a class='btn btn-success' href='visualizarProduto.php' style='text-decoration:none;'  title='Visualizar NOME DO PRODUTO'>
                                                Visualizar Produto
                                            </a>  
                                        </div>
                                    </div>
                                </div>
                            </div>
                        ";
                    }
                ?>
                    
            </div>
        </div>

<?php include "footer.php" ?>