<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bravo - Plataforma</title> 
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo app::dominio; ?>/view/assets/materialize/css/materialize.min.css" media="screen,projection" />
    <link href="<?php echo app::dominio; ?>view/assets/css/bootstrap.css" rel="stylesheet" />
    <link href="<?php echo app::dominio; ?>view/assets/css/font-awesome.css" rel="stylesheet" />
    <link href="<?php echo app::dominio; ?>view/assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
    <link href="<?php echo app::dominio; ?>view/assets/css/custom-styles.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

    <link rel="stylesheet" href="<?php echo app::dominio; ?>view/assets/js/Lightweight-Chart/cssCharts.css"> 

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/datatables-tabletools/2.1.5/css/TableTools.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/buttons/1.1.2/css/buttons.dataTables.min.css">
</head>

<?php if (!empty($_SESSION['logado']) && $_SERVER['SCRIPT_NAME'] != '/login.php') { ?>
    <body>
        <div id="wrapper">
            <nav class="navbar navbar-default top-navbar" role="navigation">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle waves-effect waves-dark" data-toggle="collapse" data-target=".sidebar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand waves-effect waves-dark" href="index.php">
                        <img src="<?php echo app::dominio; ?>view/assets/img/bravo-icon.png">
                    </a>

    				
    		<div id="sideNav" href=""><i class="material-icons dp48">toc</i></div>
                </div>

                <ul class="nav navbar-top-links navbar-right"> 
    				  <li><a class="dropdown-button waves-effect waves-dark active-menu" href="#!" data-activates="dropdown1"><i class="fa fa-user fa-fw"></i> <b><?php echo $_SESSION['nome']; ?></b> <i class="material-icons right">arrow_drop_down</i></a></li>
                </ul>
            </nav>
    		<!-- Dropdown Structure -->
    <ul id="dropdown1" class="dropdown-content">
        <li><a href="<?php echo app::dominio; ?>login.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
        </li>
    </ul>
      
            <nav class="navbar-default navbar-side" role="navigation">
                <div class="sidebar-collapse">
                    <ul class="nav" id="main-menu">
                        <li>
                            <a class="active-menu waves-effect waves-dark" href="index.php"><i class="fa fa-home"></i> Home</a>
                        </li>
                        
                        <?php if ($app->checkAccess($_SESSION['id_perfilusuario'], $funcConst::perfil_usuario)){ ?>
                        <li>
                            <a href="#" class="waves-effect waves-dark active-menu"><i class="fa fa-user"></i> Usuários<span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level">
                                 <li>
                                    <a class="active-menu" href="<?php echo app::dominio; ?>usuarios.php" >Adicionar</a>
                                </li>
                                <li>
                                    <a class="active-menu" href="<?php echo app::dominio; ?>consulta_usuarios.php" >Consultar</a>
                                </li>
                            </ul>
                        </li>
                        <?php } ?>

                        <?php if ( $_SESSION['id_perfilusuario'] != funcionalidadeConst::PERFIL_BPO) { ?>
                            <li>
                                <a class="active-menu" href="#" onclick="Gestao()"><i class="fa fa-bar-chart-o"></i> Gestão de Projetos  </a>
                            </li>
                        <?php } ?>

                        <?php if ($_SESSION['id_perfilusuario'] != funcionalidadeConst::PERFIL_PROJETOS) {?>
                                <li>
                                    <a class="active-menu" href="#" onclick="Tax()"><i class="fa fa-book"></i> Tax Calendar</a>
                                </li>
                        <?php } ?>

                    </ul>
                </div>
            </nav>



        <form action="<?php echo funcionalidadeConst::LINK_GP ?>" id="projetos" method="post">
            <input type="hidden" name="login" value="<?php echo $_SESSION['email']; ?>">
            <input type="hidden" name="senha" value="<?php echo $_SESSION['senha']; ?>">
        </form>

        <form action="<?php echo funcionalidadeConst::LINK_TAX ?>" id="agenda" method="post">
            <input type="hidden" name="email" value="<?php echo $_SESSION['email']; ?>">
            <input type="hidden" name="password" value="<?php echo $_SESSION['senha']; ?>">
        </form>



<script type="text/javascript">
  function Gestao(){
    $('#projetos').submit();
  }

  function Tax(){
    $('#agenda').submit();
  }

</script>
<?php   } ?>