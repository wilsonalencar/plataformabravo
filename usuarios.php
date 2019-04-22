<?php
require_once('model/usuario.php');
require_once('model/responsabilidade.php');
require_once('model/perfilusuario.php');

define('SAVE', 1);
define('GET', 2);
define('DEL', 3);
$usuario = new usuario;
$responsabilidade = new responsabilidade;
$perfilusuario = new perfilusuario;

$usuario->id								= $usuario->getRequest('id', 0);
$usuario->nome 								= $usuario->getRequest('nome', '');
$usuario->email 							= $usuario->getRequest('email', '');
$usuario->id_perfilusuario  				= $usuario->getRequest('id_perfilusuario', 0);
$usuario->id_plataforma  					= $usuario->getRequest('id_plataforma', 0);
$usuario->id_agenda  						= $usuario->getRequest('id_agenda', 0);
$usuario->id_apontamento	  				= $usuario->getRequest('id_apontamento', 0);
$usuario->id_responsabilidade  				= $usuario->getRequest('id_responsabilidade', 0);
$usuario->reset_senha		  				= $usuario->getRequest('reset_senha', 0);
$usuario->status		  					= $usuario->getRequest('status', 'A');
$usuario->senha 							= $usuario->getRequest('senha', '');
$usuario->id_empresas						= $usuario->getRequest('id_empresas', '');
$usuario->id_tributos 						= $usuario->getRequest('id_tributos', '');
$usuario->id_perfilportal 					= $usuario->getRequest('id_perfilportal', '');
$usuario->id_portalempresas 				= $usuario->getRequest('id_portalempresas', '');
$usuario->cnpj_cpf 							= $usuario->getRequest('cnpj_cpf', '');
$usuario->id_perfilfolha 					= $usuario->getRequest('id_perfilfolha', '');
$usuario->id_folhaempresas 					= $usuario->getRequest('id_folhaempresas', '');

if ($usuario->reset_senha == funcionalidadeConst::RESET_FALSE) {
	$usuario->senha 				= $usuario->getRequest('senha', '');
}

$msg 							= $usuario->getRequest('msg', '');	
$success 						= $usuario->getRequest('success', false);
$action 						= $usuario->getRequest('action', 0);

if ($action == SAVE) {

	$success = $usuario->save();
	$msg     = $usuario->msg; 
	
	if ($success) {
		header("LOCATION:usuarios.php?id=".$usuario->id."&msg=".$msg."&success=".$success);
	}	
}

if ($action == GET) {
	echo json_encode(array('success'=>$usuario->get($usuario->getRequest('id')), 'msg'=>$usuario->msg, 'data'=>$usuario->array));
	exit;
}

if ($action == DEL) {
	$success = $usuario->deleta($usuario->id);
	$msg = $usuario->msg;
	require_once('consulta_usuarios.php');
	exit;
}

require_once('view/usuarios/frm_usuarios.php');
?>