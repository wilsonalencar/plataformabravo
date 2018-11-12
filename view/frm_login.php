<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Bravo - Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo app::dominio; ?>view/assets/css/main.css">
</head>
<body>

<div class="background-login" style="background-image: url('<?php echo app::dominio; ?>view/assets/img/background-login.png');">
	<div class="logo-login">
        <img src="<?php echo app::dominio; ?>view/assets/img/logo-login.png">
        <h3>Plataforma</h3>
    </div>
    <div class="box-login">
        <h3>LOGIN</h3>
        <form class="form-horizontal" role="form" action="login.php" name="login" method="post">
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
            <div class="col-md-14">
                <p>Informe seu e-mail</p>
                <input type="text" class="form-control" placeholder="EMAIL" name="login">
            </div>
            <br />

            <div class="col-md-14">
                <p>Senha</p>
                <input type="password" class="form-control" name="senha" placeholder="SENHA">
            </div>
            <br />

            <div class="form-group">
                <div class="col-md-12">
                    <button type="submit" class="button-login">
                         ENTRAR
                    </button>
                </div>
            </div>                        
        </form>
    </div>   
</div>

</body>
</html>
