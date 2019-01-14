<?php
  require_once(app::path.'view/header.php');
?>
    
    <div id="page-wrapper" >
      <div class="header"> 
            <h1 class="page-header">
                 Usuários
            </h1>
          <ol class="breadcrumb">
            <li><a href="#">Usuários</a></li>
            <li><a href="#">Cadastro de usuários Bravo</a></li>
          </ol> 
                  
      </div>
    
         <div id="page-inner"> 
         <div class="row">
         <div class="col-lg-12">
         <div class="card">
                <div class="card-action">
                    Cadastro de Usuários
                </div>
                <div class="card-content">
                  <?php
                      if (!empty($msg)) { 
                        if ($success) {
                            echo "<div class='alert alert-success'>
                                    <strong>Sucesso !</strong> $msg
                                  </div>";
                          }

                          if (!$success) {
                            echo "<div class='alert alert-danger'>
                                    <strong>ERRO !</strong> $msg
                                  </div>";
                          }                           
                        }
                     ?>

                    <form class="col s12" action="usuarios.php" method="post" name="cad_usuarios">
                      <div class="row">
                        <div class="col s6">
                        <label for="nome">Nome</label>
                          <input type="text" id="nome" name="nome" value="<?php echo $usuario->nome; ?>" class="validate" maxlength="255">
                        </div>
                      </div>
                      <div class="row">
                        <div class="col s6">
                        <label for="email">Email</label>
                          <input type="text" id="email" name="email" value="<?php echo $usuario->email; ?>" class="validate" maxlength="255">
                        </div>
                      </div>

                      <div class="row" id="divResetSenha" style="display: none">
                        <label for="senha">Resetar Senha</label><br>
                          <p>
                            <input class="with-gap" name="reset_senha" value="<?php echo funcionalidadeConst::RESET_TRUE ?>" type="radio" id="test3"  />
                            <label for="test3">Sim </label>
                          
                            <input class="with-gap" name="reset_senha" value="<?php echo funcionalidadeConst::RESET_FALSE ?>" checked type="radio" id="test2" />
                            <label for="test2">Não </label>
                          </p>
                      </div>

                      <hr />

                      <div class="row">
                        <div class="col s3">
                          <label for="id_plataforma">Perfil do Usuário</label>
                          <select id="id_plataforma" name="id_plataforma" class="form-control input-sm" onchange="checkSistem(this.value)">
                            <option value="0">Perfil Plataforma Bravo</option>
                            <?php $perfilusuario->plataformaPerfis($usuario->id_perfilusuario); ?>
                          </select>
                        </div> 
                      </div>

                      <hr />
                      
                      <div class="row apontamento" style="display: none">
                        <div class="col s3" >
                            <label for="id_apontamento">Perfil -> Apontamento Horas</label>
                            <select id="id_apontamento" name="id_apontamento" class="form-control input-sm">
                              <option value="">Perfil Gestão de Projetos</option>
                              <?php $perfilusuario->apontamentoPerfis($usuario->id_perfilusuario); ?>
                            </select>
                        </div> 

                        <div class="col s3">
                            <label for="id_responsabilidade">Responsabilidade</label>
                            <select id="id_responsabilidade" name="id_responsabilidade" class="form-control input-sm">
                              <option value="0">Responsabilidades</option>
                                <?php $responsabilidade->montaSelect(); ?>
                            </select>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col s3 agenda" style="display: none">
                          <label for="id_agenda">Perfil -> Agenda</label>
                          <select id="id_agenda" name="id_agenda" class="form-control input-sm">
                            <option value="">Perfil Agenda</option>
                            <?php $perfilusuario->agendaPerfis($usuario->id_perfilusuario); ?>
                          </select>
                        </div>
                        <div class="col s3 agenda" style="display: none">
                          <label for="id_empresas">Agenda -> Empresas</label>
                          <select id="id_empresas" name="id_empresas[]" multiple class="form-control input-sm">
                            <?php $perfilusuario->agendaEmpresas(); ?>
                          </select>
                        </div>
                        <div class="col s3 agenda" style="display: none">
                          <label for="id_tributos">Agenda -> Tributos</label>
                          <select id="id_tributos" name="id_tributos[]" class="form-control input-sm" multiple>
                            <?php $perfilusuario->agendaTributos(); ?>
                          </select>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col s3 portal" style="display: none">
                          <label for="id_perfilportal">Perfil -> Portal do Fornecedor</label>
                          <select id="id_perfilportal" name="id_perfilportal" class="form-control input-sm">
                            <option value="">Perfil Portal do Fornecedor</option>
                            <?php $perfilusuario->portalPerfis($usuario->id); ?>
                          </select>
                        </div>
                        <div class="col s3 portal" style="display: none">
                          <label for="id_portalempresas">Portal do Fornecedor -> Empresas</label>
                          <select id="id_portalempresas" name="id_portalempresas[]" multiple class="form-control input-sm">
                            <?php $perfilusuario->agendaEmpresas(); ?>
                          </select>
                        </div>
                      </div>
                      <hr />

                      <div class="row">
                        <div class="col s3">
                        <label for="Status">Status</label>
                          <select id="status" name="status" class="form-control input-sm">
                            <option value="<?php echo $usuario::STATUS_SISTEMA_ATIVO ?>">Ativo</option>
                            <option value="<?php echo $usuario::STATUS_SISTEMA_INATIVO ?>">Inativo</option>
                          </select>
                        </div>
                      </div>

                      <br />
                      <div class="row">
                      <div class="input-field col s1">
                        </div>
                        <input type="hidden" id="id" name="id" value="<?php echo $usuario->id; ?>">
                        <input type="hidden" id="senha" name="senha" value="">
                        <input type="hidden" id="action" name="action" value="1">
                        <div class="input-field col s2">
                            <a href="<?php echo app::dominio; ?>consulta_usuarios.php"  class="waves-effect waves-light btn">Voltar</a>
                        </div>
                        <div class="input-field col s1">
                            <input type="submit" name="salvar" value="salvar" id="submit" class="waves-effect waves-light btn">
                        </div>
                      </div>
                    </form>

                  <div class="clearBoth"></div>
                  </div>
                  </div>
                  </div>
            </div>
      </div>

  
<?php
  require_once(app::path.'/view/footer.php');
?>

<script type="text/javascript">
function checkSistem(value){

  if (value == 0) {
    $('.apontamento').css('display', 'none');
    $('.agenda').css('display', 'none');
    $('.portal').css('display', 'none');
  }

  if (value == 1) {
    $('.apontamento').css('display', 'block');
    $('.agenda').css('display', 'block');
    $('.portal').css('display', 'block');
  }

  if (value == 2) {
    $('.apontamento').css('display', 'none');
    $('.agenda').css('display', 'block');
    $('.portal').css('display', 'none');
  }

  if (value == 3) {
    $('.agenda').css('display', 'none');
    $('.apontamento').css('display', 'block');
    $('.portal').css('display', 'none');
  }

  if (value == 4) {
    $('.apontamento').css('display', 'block');
    $('.agenda').css('display', 'block');
    $('.portal').css('display', 'none');
  }

  //BPO e Fornecedor
  if (value == 5) {
    $('.apontamento').css('display', 'none');
    $('.agenda').css('display', 'block');
    $('.portal').css('display', 'block');
  }

  //BPO, Fornecedor e Projeto
  if (value == 6) {
    $('.apontamento').css('display', 'block');
    $('.agenda').css('display', 'block');
    $('.portal').css('display', 'block');
  }

  //Fornecedor
  if (value == 7) {
    $('.apontamento').css('display', 'none');
    $('.agenda').css('display', 'none');
    $('.portal').css('display', 'block');
  }

  //Projeto e Fornecedor
  if (value == 8) {
    $('.apontamento').css('display', 'block');
    $('.agenda').css('display', 'none');
    $('.portal').css('display', 'block');
  }

}

</script>

<script src="<?php echo app::dominio; ?>view/assets/js/usuarios/usuario.js"></script>