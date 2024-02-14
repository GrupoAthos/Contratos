<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Contrato</title>

    <!-- Adicione o Bootstrap via CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

    <?php include("menu.php"); ?>

    <div class="container mt-4">
        <h1>Editar Contrato</h1>

        <?php
        // Verifica se o ID do contrato foi passado via GET
        if (isset($_GET['idcontrato'])) {
            $idcontrato = $_GET['idcontrato'];

            // Conexão com o banco de dados (usando o código de conexão fornecido anteriormente)
            include("conexao.php");

            // Consulta SQL para obter informações do contrato com base no ID
            $sql = "SELECT idcontrato, codigocontrato, nomefantasia, mensalidade, datacadastro, datavigor, idrevenda
                    FROM cliente
                    WHERE idcontrato = $idcontrato";
            $result = $conn->query($sql);

            // Verifica se a consulta foi bem-sucedida
            if ($result->num_rows > 0) {
                // Obtém os dados do contrato
                $contrato = $result->fetch_assoc();
        ?>

                <!-- Formulário de Edição -->
                <form action="atualizar_contrato.php" method="POST">
                    <input type="hidden" name="idcontrato" value="<?php echo $contrato['idcontrato']; ?>">
                    
                    <div class="form-group">
                        <label for="codigocontrato">Código do Contrato:</label>
                        <input type="text" class="form-control" id="codigocontrato" name="codigocontrato" value="<?php echo $contrato['codigocontrato']; ?>">
                    </div>

                    <div class="form-group">
                        <label for="nomefantasia">Nome Fantasia:</label>
                        <input type="text" class="form-control" id="nomefantasia" name="nomefantasia" value="<?php echo $contrato['nomefantasia']; ?>">
                    </div>

                    <div class="form-group">
                        <label for="mensalidade">Mensalidade:</label>
                        <input type="text" class="form-control" id="mensalidade" name="mensalidade" value="<?php echo $contrato['mensalidade']; ?>">
                    </div>

                    <div class="form-group">
                        <label for="datacadastro">Data de Cadastro:</label>
                        <input type="date" class="form-control" id="datacadastro" name="datacadastro" value="<?php echo $contrato['datacadastro']; ?>">
                    </div>

                    <div class="form-group">
                        <label for="datavigor">Data de Vigor:</label>
                        <input type="date" class="form-control" id="datavigor" name="datavigor" value="<?php echo $contrato['datavigor']; ?>">
                    </div>

                    <!-- Adicione mais campos conforme necessário -->

                    <button type="submit" class="btn btn-primary">Atualizar Contrato</button>
                </form>

        <?php
            } else {
                echo 'Contrato não encontrado.';
            }

            // Fecha a conexão com o banco de dados
            $conn->close();
        } else {
            echo 'ID do contrato não fornecido.';
        }
        ?>

    </div>

    <!-- Adicione o jQuery via CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <!-- Adicione o JavaScript do Bootstrap via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
