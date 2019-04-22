<?php
session_start();
require_once('database_apontamento.php');
require_once('database_agenda.php');
require_once('database_plataforma.php');
require_once('database_portalfornecedor.php');
require_once('database_folhapagto.php');
require_once('funcionalidadeConst.php');
/**
* Lucas Alencar
*/
class app extends config
{	
	const STATUS_SISTEMA_ATIVO = 'A';
	const STATUS_SISTEMA_INATIVO = 'I';
	public $mail;
	public $ApontDB;
	public $AgendaDB;
	public $PlatformDB;
	public $PortalDB;
	public $FolhaDB;

 	public function __construct(){
 		$this->validLogin();
 	
 		$this->ApontDB = new apontamentohoras;
 		$this->AgendaDB = new agenda;
 		$this->PlatformDB = new plataforma;
 		$this->PortalDB = new portalfornecedor;
 		$this->FolhaDB = new folhapagto;
 	
 		if (!$this->validAccess()) {
 			header('LOCATION:index.php');
 			//redireciona
 		}
 	}
 	private function validLogin()
 	{
 		if (empty($_SESSION) && $_SERVER['SCRIPT_NAME'] != '/login.php') {
 			header('LOCATION:login.php');
 		}
 	}
 	
 	public function deslogar(){
 		session_destroy();
 	}

 	public function getRequest($variable, $default_value = '') 
 	{
	   //Correção para todo o SCID, CORREÇÃO DE FALHA DE SEGURANÇA - XSS E SQL INJECTION
	   if($variable == "scid" && isset($_REQUEST[$variable]))
	       return intval($_REQUEST[$variable]);
	   
	   if (isset($_POST[$variable]))
	       return $_POST[$variable];

	   if (isset($_GET[$variable]))
	       return $_GET[$variable];

	   if (isset($_REQUEST[$variable]))
	       return $_REQUEST[$variable];

	   return $default_value;
	}

	public function checkAccess($perfil, $funcionalidadeID)
	{	
		$conn = $this->PlatformDB->mysqli_connection;		
		$query = sprintf("SELECT count(1) as acesso FROM plataformapermissao where (select count(1) FROM plataformafuncionalidade where id = %d AND status = '%s') > 0 AND id_perfilusuario = %d and id_funcionalidade = %d", 
			$funcionalidadeID, $this::STATUS_SISTEMA_ATIVO ,$perfil, $funcionalidadeID);	
		
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro durante a verificação do perfil";
			return false;	
		}		
		
		$return = $result->fetch_array(MYSQLI_ASSOC);
		if ( (int) $return['acesso'] > 0) {
			return true;	
		}

		return false;
	}

	function validaEmail($email) 
	{
	    $er = "/^(([0-9a-zA-Z]+[-._+&])*[0-9a-zA-Z]+@([-0-9a-zA-Z]+[.])+[a-zA-Z]{2,6}){0,1}$/";
	    if (preg_match($er, $email)){
		return true;
	    } else {
		return false;
	    }
	}
	
	private function validAccess()
	{	
		$file = $_SERVER['SCRIPT_NAME'];
		$funcConst = new funcionalidadeConst;
		
		if ((!empty($_SESSION)) && $_SESSION['reset_senha'] == $funcConst::RESET_TRUE && $file <> '/reset_senha.php') {
			header('LOCATION:reset_senha.php');
		}

		if ((!empty($_SESSION)) && $file == '/reset_senha.php' && $_SESSION['reset_senha'] == $funcConst::RESET_FALSE) {
			return false;
		}

		if (($file == '/consulta_usuarios.php' || $file == '/usuarios.php') && !$this->checkAccess($_SESSION['id_perfilusuario'], $funcConst::perfil_usuario)) {
			return false;
		}
		
		return true;
	}
}

$app = new app;
$funcConst = new funcionalidadeConst;
?>