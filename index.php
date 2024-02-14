<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- Adicione o Bootstrap via CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Adicione o FontAwesome via CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
</head>
<body>

    <?php include("menu.php"); ?>

    <div class="container mt-4">
        <h1>Dashboard</h1>

    <!-- Adicione dois selects para ano e mês -->
    <div class="form-row align-items-center">
        <div class="form-group col-md-3">
            <label for="ano">Ano:</label>
            <select class="form-control" id="ano" name="ano">
                <?php
                $anoAtual = date("Y");
                for ($ano = 2020; $ano <= $anoAtual; $ano++) {
                    echo '<option value="' . $ano . '" ' . ($ano == $anoAtual ? 'selected' : '') . '>' . $ano . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="form-group col-md-3">
            <label for="mes">Mês:</label>
            <select class="form-control" id="mes" name="mes">
                <?php
                $meses = [
                    1 => 'Janeiro',
                    2 => 'Fevereiro',
                    3 => 'Março',
                    4 => 'Abril',
                    5 => 'Maio',
                    6 => 'Junho',
                    7 => 'Julho',
                    8 => 'Agosto',
                    9 => 'Setembro',
                    10 => 'Outubro',
                    11 => 'Novembro',
                    12 => 'Dezembro'
                ];

                $mesAtual = date("n");
                foreach ($meses as $numeroMes => $nomeMes) {
                    echo '<option value="' . $numeroMes . '" ' . ($numeroMes == $mesAtual ? 'selected' : '') . '>' . $nomeMes . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="form-group col-md-2 align-self-end">
            <label for="btnAtualizar" class="invisible">Atualizar:</label>
            <button type="button" class="btn btn-primary btn-block" id="btnAtualizar">Atualizar</button>
        </div>
    </div>


    <?php
        // Conexão com o banco de dados (usando o código de conexão fornecido anteriormente)
        include("conexao.php");

        // Obtenha o ano e o mês selecionados
        $anoSelecionado = isset($_GET['ano']) ? $_GET['ano'] : date("Y");
        $mesSelecionado = isset($_GET['mes']) ? $_GET['mes'] : date("n");

        // Cálculo do total de contratos vendidos no ano
        $sqlContratos = "SELECT COUNT(idcontrato) AS total_contratos
                        FROM cliente
                        WHERE YEAR(datacadastro) = $anoSelecionado";
        $resultContratos = $conn->query($sqlContratos);
        $totalContratos = ($resultContratos->num_rows > 0) ? $resultContratos->fetch_assoc()['total_contratos'] : 0;

        // Cálculo do total de mensalidades no ano
        $sqlMensalidades = "SELECT SUM(mensalidade) AS total_mensalidades
                            FROM cliente
                            WHERE YEAR(datacadastro) = $anoSelecionado";
        $resultMensalidades = $conn->query($sqlMensalidades);
        $totalMensalidades = ($resultMensalidades->num_rows > 0) ? number_format($resultMensalidades->fetch_assoc()['total_mensalidades'], 2, ',', '.') : 0;

        // Obtenção das informações das revendas e suas metas
        $sqlRevendas = "SELECT r.idrevenda, r.nomerevenda, m.valormeta
                        FROM revenda r
                        LEFT JOIN meta m ON r.idrevenda = m.idrevenda
                        AND m.anometa = $anoSelecionado AND m.mesmeta = $mesSelecionado";
        $resultRevendas = $conn->query($sqlRevendas);

        $totalGerado = 0;
        $metaTotal = 0;

        echo '<div class="row">';

        if ($resultRevendas->num_rows > 0) {
            // Exibe as informações das revendas em cartões
            while ($revenda = $resultRevendas->fetch_assoc()) {
                echo '<div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">' . $revenda['nomerevenda'] . '</h5>
                                <p class="card-text">Meta: R$ ' . number_format($revenda['valormeta'], 2, ',', '.') . '</p>';

                // Cálculo do total já gerado pela revenda
                $sqlTotalGerado = "SELECT SUM(mensalidade) AS total_gerado
                                    FROM cliente
                                    WHERE MONTH(datacadastro) = $mesSelecionado AND YEAR(datacadastro) = $anoSelecionado and idrevenda = " . $revenda['idrevenda'];
                $resultTotalGerado = $conn->query($sqlTotalGerado);
                $totalRevenda = ($resultTotalGerado->num_rows > 0) ? number_format($resultTotalGerado->fetch_assoc()['total_gerado'], 2, ',', '.') : 0;

                echo '<p class="card-text">Total Gerado: R$ ' . $totalRevenda . '</p>';

                // Cálculo do restante para a meta
                $restanteParaMeta = max(0, $revenda['valormeta'] - floatval(str_replace(',', '.', $totalRevenda)));
                echo '<p class="card-text">R$ Restante para Meta: R$ ' . number_format($restanteParaMeta, 2, ',', '.') . '</p>';

                // Cálculo da porcentagem atingida
                $valorMeta = floatval(str_replace(',', '.', $revenda['valormeta']));
                $totalRevendaFloat = floatval(str_replace(',', '.', $totalRevenda));

                $porcentagemAtingida = ($valorMeta > 0) ? number_format(($totalRevendaFloat / $valorMeta) * 100, 2, ',', '.') : '0';
                echo '<p class="card-text">% Porcentagem Atingido: ' . $porcentagemAtingida . '%</p>';

                echo '</div>
                    </div>
                </div>';
            }
        }

        echo '</div>';
        ?>


        <div class="row mt-4">
            <!-- Cartão de Total de Contratos -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-file-contract"></i> Total de Contratos no Ano</h5>
                        <p class="card-text"><?php echo $totalContratos; ?></p>
                    </div>
                </div>
            </div>

            <!-- Cartão de Total de Mensalidades -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-money-bill-wave"></i> Total de Mensalidades no Ano</h5>
                        <p class="card-text">R$ <?php echo $totalMensalidades; ?></p>
                    </div>
                </div>
            </div>

            <!-- Cartão de Meta Total das Revendas -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-bullseye"></i> Meta Total das Revendas</h5>
                        <p class="card-text">R$ <?php echo number_format($metaTotal, 2, ',', '.'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Adicione o jQuery via CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <!-- Adicione o JavaScript do Bootstrap via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Adicione um evento de clique ao botão de atualização
        document.getElementById('btnAtualizar').addEventListener('click', function () {
            // Obtenha os valores selecionados de ano e mês
            var anoSelecionado = document.getElementById('ano').value;
            var mesSelecionado = document.getElementById('mes').value;
            
            // Redirecione para a mesma página com os novos parâmetros
            window.location.href = 'index.php?ano=' + anoSelecionado + '&mes=' + mesSelecionado;
        });
    </script>
</body>
</html>
