<!-- menu.php -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">
        <img src="https://static.wixstatic.com/media/138d8c_5300fa3dcde7496dac6008d4f1f90eea~mv2.png/v1/fill/w_97,h_97,al_c,q_85,usm_0.66_1.00_0.01,enc_auto/ARQUEIRO_fw.png" alt="Logo" width="30" height="30">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="offcanvas">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="contrato.php">Contrato</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Metas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Revendas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Vendedor</a>
            </li>
        </ul>
    </div>
</nav>

<!-- Certifique-se de que o jQuery está carregado antes deste script -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

<script>
    $(document).ready(function () {
        $('[data-toggle="offcanvas"]').on('click', function () {
            $('.offcanvas-collapse').toggleClass('open');
        });
    });
</script>
