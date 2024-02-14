<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contrato</title>

    <!-- Adicione o Bootstrap via CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

    <?php include("menu.php"); ?>

    <div class="container mt-4">
        <h1>Contratos</h1>

        <?php
        // Conexão com o banco de dados (usando o código de conexão fornecido anteriormente)
        include("conexao.php");

        // Consulta SQL para obter informações da tabela cliente
        $sql = "SELECT idcontrato, c.codigocontrato, c.nomefantasia, c.mensalidade, c.datacadastro, c.datavigor, r.nomerevenda
                FROM cliente c
                INNER JOIN revenda r ON c.idrevenda = r.idrevenda
                ORDER BY idcontrato DESC
                ";
        $result = $conn->query($sql);

        // Verifica se a consulta foi bem-sucedida
        if ($result->num_rows > 0) {
            // Exibe os resultados em uma tabela
            echo '<table class="table">
                    <thead>
                        <tr>
                            <th>Codigo</th>
                            <th>Nome</th>
                            <th>R$ Mensalidade</th>
                            <th>Cadastro</th>
                            <th>Vigor</th>
                            <th>Revenda</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>';

            // Loop pelos resultados e exibe cada linha na tabela
            while ($row = $result->fetch_assoc()) {
                echo '<tr>
                        <td>' . $row['codigocontrato'] . '</td>
                        <td>' . $row['nomefantasia'] . '</td>
                        <td>R$ ' . number_format($row['mensalidade'], 2, ',', '.') . '</td>
                        <td>' . date('d/m/Y', strtotime($row['datacadastro'])) . '</td>
                        <td>' . date('d/m/Y', strtotime($row['datavigor'])) . '</td>
                        <td>' . $row['nomerevenda'] . '</td>
                        <td>
                            <a href="editar_contrato.php?idcontrato=' . $row['idcontrato'] . '" class="btn btn-primary">Editar</a>
                            <!-- Adicione mais ações conforme necessário -->
                        </td>
                    </tr>';
            }

            echo '</tbody></table>';
        } else {
            echo 'Nenhum contrato encontrado.';
        }

        // Fecha a conexão com o banco de dados
        $conn->close();
        ?>

    </div>

    <!-- Adicione o jQuery via CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <!-- Adicione o JavaScript do Bootstrap via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
