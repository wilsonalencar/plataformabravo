<?php
  require_once(app::path.'view/header.php');
?>
<div id="page-wrapper">
	<div class="header"> 
            <h1 class="page-header">
                 Acessos
            </h1>
          <ol class="breadcrumb">
            <li><a href="#">Acessos a Sistemas Habilitados </a></li>
          </ol> 
                  
      </div>
	
     <div id="page-inner"> 
         <div class="row">
             <div class="col-lg-12">
                  <div class="card">
                      <br />
                      <div class="row">
                          <div class="card-content">
                              <div class="col-lg-2"></div>
                              
                              <?php if ( $_SESSION['id_perfilusuario'] != funcionalidadeConst::PERFIL_BPO) { ?>
                              <div class="col-lg-3" align="center" style="background-color: #1e272e" onclick="Gestao()"><br />
                                <img src="<?php echo app::dominio; ?>view/assets/img/bravo-icon.png"><br /><p style="color: white">Gestão de Projetos</p><br />
                              </div>
                              <?php } ?>

                              <div class="col-lg-2"></div>

                              <?php if ($_SESSION['id_perfilusuario'] != funcionalidadeConst::PERFIL_PROJETOS) {?>
                              <div class="col-lg-3" align="center" style="background-color: #1e272e" onclick="Tax()"><br />
                                <img src="<?php echo app::dominio; ?>view/assets/img/bravo-icon.png"><br/><p style="color: white">Tax Calendar</p><br />
                              </div>
                              <?php } ?>

                              <div class="col-lg-2"></div>
                          </div>
                      </div>
                      <br/>
                  </div>
              </div>
          </div>
      </div>
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
<?php
  require_once(app::path.'view/footer.php');
?>