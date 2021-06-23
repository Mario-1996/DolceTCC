<?php
//iniciar a sessao
session_start();

//iniciar a variavel pagina
$pagina = "paginas/login";

//incluir o arquivo de conexao
include "config/conexao.php";


$site 	= $_SERVER['SERVER_NAME'];
$porta  = $_SERVER['SERVER_PORT'];
$url	= $_SERVER['SCRIPT_NAME'];

$h = "http";


if (isset($_SERVER['HTTPS'])) {

	$h = "https";
}

$base 	= "$h://$site:$porta/$url";

?>
<!DOCTYPE html>
<html>

<head>
	
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">

	<base href="<?= $base; ?>">
	

	<!-- Custom fonts for this template-->
	<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

	<!-- Custom styles for this template-->
	<link href="css/sb-admin-2.min.css" rel="stylesheet">

	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="vendor/summernote/summernote.min.css">
	<link rel="stylesheet" href="sweetalert2.min.css">

	<link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">

	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">

	<script src="vendor/jquery/jquery.min.js"></script>
	<script src="js/jquery.maskMoney.min.js"></script>
	<script src="js/jquery.inputmask.min.js"></script>
	<script src="js/bindings/jquery.inputmask.binding.js"></script>
	<script src="js/sweetalert.min.js"></script>

	<!--===============================================================================================-->	
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>

<script>
    $(document).ready(function() {
      $('#tb').dataTable({
        dom: 'Bfrtip',
        buttons: [
            'excel',
            'pdf'
        ],
        /* Tradução data table */
        "language": {
          "EmptyTable": "Nenhum registro encontrado",
          "info": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
          "infoEmpty": "Mostrando 0 até 0 de 0 registros",
          "infoFiltered": "(Filtrados de _MAX_ registros)",
          "infoPostFix": "",
          "infoThousands": ".",
          "lengthMenu": "_MENU_ Resultados por página",
          "loadingRecords": "Carregando...",
          "processing": "Processando...",
          "zeroRecords": "Nenhum registro encontrado",
          "search": "Pesquisar",
          "paginate": {
            "next": "Próximo",
            "previous": "Anterior",
            "first": "Primeiro",
            "last": "Último"
          }
        },
        /* ícones de próx, última pag... */
        "pagingType": "full_numbers"
      });
    });
  </script>
  <!-- fim data table -->
	<!--===============================================================================================-->
	<script src="js/main.js"></script>

</head>

<body>

	<?php
	//completar o nome da página
	$pagina = $pagina . ".php";

	//se não esta logado
	//mostrar tela do login
	if (!isset($_SESSION["dolce"]["id"])) {
		//incluir o login
		include $pagina;
	} else {


	 if ($_SESSION["dolce"]["idtipousuario"] == 1) {
		echo '<title>Admin - Dolce</title>';
	} else if ($_SESSION['dolce']['idtipousuario'] == 2) {
		echo '<title>Funcionario - Dolce</title>';
	}
	;?>

		<!-- Page Wrapper -->
		<div id="wrapper">
			<!-- Sidebar -->
			<ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

				<!-- Sidebar - Brand -->
				<i class="sidebar-brand d-flex  bg-gradient-dark align-items-center justify-content-center" href="index.php">
				<img src="images/logoDolce.png" width="auto" height="20" alt="Dolce Menu" title="dolce menu">
					<h5 class="letra">Menu</h5>
				</i>

				<!-- Divider -->
				<hr class="sidebar-divider">

				<!-- Nav Item - Pages Collapse Menu -->
				<?php
				if ($_SESSION["dolce"]["idtipousuario"] == 1) {
				echo '<li class="nav-item">
					<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
						<i class="fas fa-fw fa-folder"></i>
						<span>Cadastros</span>
					</a>
					<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
						<div class="bg-white py-2 collapse-inner rounded">
							<h6 class="collapse-header">Cadastro:</h6>
							<a class="collapse-item" href="cadastro/cliente">
							<i class="fa fa-users"></i> Clientes</a>
							<a class="collapse-item" href="cadastro/produto">
							<i class="fas fa-cart-plus"></i> Produto</a>
							<a class="collapse-item" href="cadastro/tipo">
							<i class="fa fa-plus-square"></i> Tipo de Produto</a>			
							<a class="collapse-item" href="cadastro/modelo">
							<i class="fa fa-plus-square"></i> Modelo de Produto</a>
							<a class="collapse-item" href="cadastro/usuario">
							<i class="fas fa-user"></i> Usuários</a>
						</div>
					</div>
				</li>';
				} else if ($_SESSION["dolce"]["idtipousuario"] == 2) {
				echo '<li class="nav-item">
					<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
						<i class="fas fa-fw fa-folder"></i>
						<span>Cadastros</span>
					</a>
					<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
						<div class="bg-white py-2 collapse-inner rounded">
							<h6 class="collapse-header">Cadastro:</h6>
							<a class="collapse-item" href="cadastro/cliente">
							<i class="fa fa-users"></i> Clientes</a>
							</div>
					</div>
					</li>';}
							?>
				</nav>

				
				<!-- Divider -->
				<hr class="sidebar-divider">

				<!-- Nav Item - Utilities Collapse Menu -->
				<?php
				if ($_SESSION["dolce"]["idtipousuario"] == 1) {
						echo' <li class="nav-item">
						<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
							<i class="fas fa-fw fa-folder"></i>
							<span>Relatorios</span>
						</a>
						<div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
							<div class="bg-white py-2 collapse-inner rounded">
								<h6 class="collapse-header">Relatorios:</h6>
								<a class="collapse-item" href="relatorios/maisVendidos">
								<i class="fas fa-chart-line"></i> Mais Vendidos</a>
								<a class="collapse-item" href="relatorios/pedidos">
								<i class="fas fa-edit"></i> Pedidos</a>
								<a class="collapse-item" href="relatorios/vendedor">
								<i class="fas fa-user"></i> Vendedor</a>
								<a class="collapse-item" href="relatorios/venda">
								<i class="fas fa-calendar-check"></i> Vendas por Mês</a>
								<a class="collapse-item" href="relatorios/clientes">
								<i class="fas fa-users"></i> Clientes</a>
								<a class="collapse-item" href="relatorios/liscaixa">
								<i class="fas fa-cart-plus"></i> Caixa</a>
							</div>
						</div>
					</li>';

					} else if ($_SESSION['dolce']['idtipousuario'] == 2) {

						echo'<li class="nav-item " >
						<a class="nav-link collapsed disabled" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
							<i class="fas fa-fw fa-folder"></i>
							<span>Relatorios</span>
						</a>
						<div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
							<div class="bg-white py-2 collapse-inner rounded">
								<h6 class="collapse-header" >Relatorios:</h6>
								<a class="collapse-item" href="relatorios/maisVendidos">
								<i class="fas fa-chart-line"></i> Mais Vendidos</a>
								<a class="collapse-item" href="relatorios/pedidos">
								<i class="fas fa-edit"></i> Pedidos</a>
								<a class="collapse-item" href="relatorios/vendedor">
								<i class="fas fa-user"></i> Vendedor</a>
								<a class="collapse-item" href="relatorios/venda">
								<i class="fas fa-calendar-check"></i> Vendas por Mês</a>
								<a class="collapse-item" href="relatorios/clientes">
								<i class="fas fa-users"></i> Clientes</a>
								<a class="collapse-item" href="relatorios/caixa">
								<i class="fas fa-cart-plus"></i> Caixa</a>
							</div>
						</div>
					</li>';
				}
				?>
				

				<!-- Divider -->
				<hr class="sidebar-divider">


			</ul>
			<!-- End of Sidebar -->

			<!-- Content Wrapper -->
			<div id="content-wrapper" class="d-flex flex-column">

				<!-- Main Content -->
				<div id="content">

					<!-- Topbar -->
					<nav class="navbar navbar-expand navbar-light bg-gray topbar mb-4 static-top shadow">
					<a class="nav-link" href="paginas/home">
						<img src="images/logoNome.png" width="auto" height="50" alt="Dolce" title="dolce Home">
					</a>
						<!-- Topbar Navbar -->
						<ul class="navbar-nav ml-auto">

							<div class="topbar-divider d-none d-sm-block"></div>

							<li>
							<div class="nav-item dropdown ">
							<a class=" dropdown-toggle nav-link" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
							<span class="mr-2 d-none d-lg-inline text-gray-600 "><i class="fas fa-user-circle"></i>
										<?= $_SESSION["dolce"]["nome"]; ?></span>
							</a>
							<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
							<h6 class="bg-white collapse-inner rounded"><i class="fa fa-wrench"></i> Opções:</h6><hr>
									<a class="collapse-item" href="cadastro/mudaSenha">
									<i class="fas fa-bell"></i> Mudar Senha</a>
							</div>
							</div>
							</li>

							<div class="topbar-divider d-none d-sm-block"></div>
							<li class="nav-item dropdown no-arrow">
                   				 <a class="nav-link" href="" data-toggle="modal" data-target="#logoutModal">
									<span class="mr-2 d-none d-lg-inline text-gray-600" title="Sair do Sistema"><i class="fa fa-power-off"></i> Sair</span>
								</a>
              				</li>

							<div class="topbar-divider d-none d-sm-block"></div>

						</ul>

					</nav>
					<!-- End of Topbar -->

					<!-- Begin Page Content -->
					<div class="container-fluid">

						<?php
						//adicionar a programação para abrir a página desejada

						$pagina = "paginas/home.php";

						//verificar se o parametro existe
						if (isset($_GET["parametro"])) {
							//recuperar o parametro
							$p = trim($_GET["parametro"]);
							//separar por /
							$p = explode("/", $p);

							$pasta 		= $p[0];
							$arquivo	= $p[1];

							//configurar nome do arquivo
							$pagina = "$pasta/$arquivo.php";

							//verificar se o id ou o 3 item existe
							if (isset($p[2]))
								$id = $p[2];
						}

						//verificar se a pagina existe
						if (file_exists($pagina))
							include $pagina;
						else
							include "paginas/404.php";

						?>

					</div>
					<!-- /.container-fluid -->

				</div>
				<!-- End of Main Content -->

				<!-- Footer -->
				<footer class="sticky-footer bg-white">
					<div class="container my-auto">
						<div class="copyright text-center my-auto">
							<span>Copyright &copy; Desenvolvido por Mario & Ayslan - 2021</span>
						</div>
					</div>
				</footer>
				<!-- End of Footer -->

			</div>
			<!-- End of Content Wrapper -->

		</div>
		<!-- End of Page Wrapper -->
		 <!-- Sair Modal-->
		 <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><img src="images/logoNome.png" 
						width="auto" height="55" alt="Dolce Menu" title="dolce sair"></h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Deseja Realmente Sair do Sistema ?</div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>
                        <a class="btn btn-success" href="sair.php">Sair</a>
                    </div>
                </div>
            </div>
        </div>
	

	<?php

		//continuação do  codigo php

	}

	//se esta logado
	//mostrar home ou a pagina que esta tentando visitar


	?>

	<!-- Bootstrap core JavaScript-->

	<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

	<!-- Parsley para validar -->
	<script src="js/parsley.min.js"></script>

	<!-- Core plugin JavaScript-->
	<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

	<!-- Custom scripts for all pages-->
	<script src="js/sb-admin-2.min.js"></script>

	<!-- Page level plugins -->
	<script src="vendor/chart.js/Chart.min.js"></script>

	<!-- Summernote - formatação inteligente para textarea -->
	<script src="vendor/summernote/summernote.min.js"></script>


	<script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
</body>

</html>