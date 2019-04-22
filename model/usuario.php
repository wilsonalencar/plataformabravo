<?php
require_once('app.php');
/**
* Lucas Barbosa de Alencar
*/
class usuario extends app
{
	public $id;
	public $nome;
	public $email;
	public $id_perfilusuario;
	public $id_plataforma;
	public $id_agenda;
	public $id_apontamento;
	public $id_responsabilidade;
	public $reset_senha;
	public $status;
	public $senha;
	public $senha2;
	public $msg;
	public $id_empresas;
	public $id_tributos;

	private function check(){
		
		if (empty($this->email)) {
			$this->msg = "Favor informar o email do usuário.";
			return false;
		}
			
		if (!$this->validaEmail($this->email)) {
			$this->msg = "Favor informar um email válido.";
			return false;
		}

		if (!$this->PlataformaCheck()) {
			return false;
		}

		if (empty($this->nome)) {
			$this->msg = "Favor informar o nome do usuário.";
			return false;	
		}

		if (empty($this->id_plataforma)) {
			$this->msg = "Favor informar o perfil do usuário para a plataforma.";
			return false;	
		}

		if (empty($this->id_responsabilidade) && ($this->id_plataforma != funcionalidadeConst::PERFIL_BPO) && ($this->id_plataforma != funcionalidadeConst::PERFIL_PORTAL) ) {
			$this->msg = "Para criar um usuário para o sistema Gestão de Projetos, é necessário informar a responsabilidade do mesmo.";
			return false;	
		}

		if (empty($this->id_apontamento) && ($this->id_plataforma != funcionalidadeConst::PERFIL_BPO) && ($this->id_plataforma != funcionalidadeConst::PERFIL_PORTAL) ) {
			$this->msg = "Para criar um usuário para o sistema Gestão de Projetos, é necessário informar o perfil do mesmo.";
			return false;	
		}

		if (empty($this->id_agenda) && ($this->id_plataforma != funcionalidadeConst::PERFIL_PROJETOS) && ($this->id_plataforma != funcionalidadeConst::PERFIL_PORTAL) ) {
			$this->msg = "Para criar um usuário para o sistema Tax Calendar, é necessário informar o perfil do mesmo.";
			return false;	
		}

		if (empty($this->id_perfilportal) && ($this->id_plataforma != funcionalidadeConst::PERFIL_PROJETOS) && ($this->id_plataforma != funcionalidadeConst::PERFIL_BPO)) {
			$this->msg = "Para criar um usuário para o sistema Portal do Fornecedor, é necessário informar o perfil do mesmo.";
			return false;	
		}
		
		return true;
	}

	private function PlataformaCheck()
	{
		$conn = $this->PlatformDB->mysqli_connection;		
		$query = sprintf("SELECT email FROM plataformausuario WHERE email = '%s' AND id <> %d", $this->email, $this->id);	
		
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro durante a verificação do email";
			return false;	
		}
		
		if (!empty($result->fetch_array(MYSQLI_ASSOC))) {
			$this->msg = "Email já está sendo utilizado por outro usuário.";
			return false;			
		}

		return true;
	}

	private function checkReset(){
			
		if (empty($this->senha)) {
			$this->msg = "Favor inserir a senha do usuário.";
			return false;
		}

		if (empty($this->senha2)) {
			$this->msg = "Favor inserir a senha para confirmação.";
			return false;	
		}

		if ($this->senha != $this->senha2) {
			$this->msg = "As senhas não são identicas, favor verificar.";
			return false;	
		}
		
		return true;
	}

	private function checkLogin(){
		
		if (empty($this->email)) {
			$this->msg = "Favor informar o email do usuário.";
			return false;
		}
		
		if (empty($this->senha)) {
			$this->msg = "Favor inserir a senha do usuário.";
			return false;
		}

		return true;
	}

	public function login(){

		if (!$this->checkLogin()) {
			return false;
		}

		$conn = $this->PlatformDB->mysqli_connection;		
		$query = sprintf("SELECT A.id, A.nome, A.email, A.senha, A.id_perfilusuario, A.reset_senha FROM plataformausuario A WHERE A.email = '%s' AND A.senha = '%s' AND A.status = '%s'", 
			$this->email, base64_encode($this->senha), $this::STATUS_SISTEMA_ATIVO);	
		
		if (!$result = $conn->query($query)) {
			return false;	
		}

		if (!empty($row = $result->fetch_array(MYSQLI_ASSOC))){
			$_SESSION['id'] 				= $row['id'];
 			$_SESSION['nome'] 	   			= $row['nome'];
 			$_SESSION['email'] 				= $row['email'];
 			$_SESSION['senha'] 				= base64_decode($row['senha']);
 			$_SESSION['id_perfilusuario'] 	= $row['id_perfilusuario'];
 			$_SESSION['reset_senha'] 		= $row['reset_senha'];
 			$_SESSION['logado'] 			= 1;	
 			
 			return true;		
		}

		$this->msg = 'Login inválido';
		return false;
	}

	public function save()
	{
		if (!$this->check()) {
		 	return false;
		}

		if ($this->id > 0) {
			return $this->update();
		}
		return $this->insert();
	}


	public function insertApontamento(){
		$projetos = $this->ApontDB->mysqli_connection;
		$query = sprintf(" INSERT INTO usuarios (nome, email, id_perfilusuario, id_responsabilidade, senha, reset_senha, usuario, status)
		VALUES ('%s','%s', %d, %d, '%s', '%s', '%s', '%s')", 
			$this->nome, $this->email,$this->id_apontamento, $this->id_responsabilidade,md5(funcionalidadeConst::SENHA_PADRAO), funcionalidadeConst::RESET_FALSE, $_SESSION['email'], $this->status);
		if (!$projetos->query($query)) {
			$this->msg = "Ocorreu um erro no GESTÃO DE PROJETOS, contate o administrador do sistema!";
			return false;	
		}
	}

	public function insertAgenda(){
		$agenda = $this->AgendaDB->mysqli_connection;
		$query = sprintf(" INSERT INTO users (name, email, password, reset_senha)
		VALUES ('%s','%s', '%s', %d)", 
			$this->nome, $this->email,@crypt(funcionalidadeConst::SENHA_PADRAO), funcionalidadeConst::RESET_AGENDA_FALSE);
		if (!$agenda->query($query)) {
			$this->msg = "Ocorreu um erro no AGENDA, contate o administrador do sistema!";
			return false;	
		}
		$lastinsertID = $agenda->insert_id;
		$queryRoles = sprintf(" INSERT INTO role_user (user_id, role_id) VALUES (%d, %d)", $lastinsertID, $this->id_agenda);
		if (!$agenda->query($queryRoles)) {
			$this->msg = "Ocorreu um erro no AGENDA, contate o administrador do sistema!";
			return false;	
		}

		if (is_array($this->id_tributos)) {
			foreach ($this->id_tributos as $k => $tributo) {
				$queryTrib = sprintf("INSERT INTO tributo_user (user_id, tributo_id) VALUES (%d, %d)", $lastinsertID, $tributo);
				if (!$agenda->query($queryTrib)) {
					$this->msg = "Ocorreu um erro no AGENDA, contate o administrador do sistema!";
					return false;	
				}
			}
		}

		if (is_array($this->id_empresas)) {
			foreach ($this->id_empresas as $l => $empresa) {
				$queryEmp = sprintf("INSERT INTO empresa_user (user_id, empresa_id) VALUES (%d, %d)", $lastinsertID, $empresa);
				if (!$agenda->query($queryEmp)) {
					$this->msg = "Ocorreu um erro no AGENDA, contate o administrador do sistema!";
					return false;	
				}
			}
		}
	}

	public function insertPortal(){
		$portal = $this->PortalDB->mysqli_connection;
		$query = sprintf(" INSERT INTO usuarios (nome, email, id_perfilusuario, password, reset_senha, usuario, data_criacao, data_alteracao)
		VALUES ('%s','%s',%d,'%s', '%s', '%s', '%s', '%s')", 
			utf8_decode($this->nome), $this->email,$this->id_perfilportal,@crypt(funcionalidadeConst::SENHA_PADRAO), funcionalidadeConst::RESET_PORTAL_FALSE, $_SESSION['email'], date('Y-m-d h:i:s'), date('Y-m-d h:i:s'));
		if (!$portal->query($query)) {
			$this->msg = "Ocorreu um erro no PORTAL, contate o administrador do sistema!";
			return false;	
		}
		
		$lastinsertID = $portal->insert_id;

		if (is_array($this->id_portalempresas)) {
			foreach ($this->id_portalempresas as $l => $empresa) {
				$queryEmp = "INSERT INTO permissaoempresas (id_usuario, id_empresa) VALUES (".$lastinsertID.",".$empresa.")";
				if (!$portal->query($queryEmp)) {
					$this->msg = "Ocorreu um erro no AGENDA, contate o administrador do sistema!";
					return false;	
				}
			}
		}
	}

	public function insert()
	{
		$plataforma = $this->PlatformDB->mysqli_connection;
		$query = sprintf(" INSERT INTO plataformausuario (nome, email, id_perfilusuario, id_responsabilidade, senha, reset_senha, usuario, status, data_cadastro)
		VALUES ('%s','%s', %d, %d, '%s', '%s', '%s', '%s', '%s')", 
			$this->nome, $this->email,$this->id_plataforma, $this->id_responsabilidade,base64_encode(funcionalidadeConst::SENHA_PADRAO), funcionalidadeConst::RESET_TRUE, $_SESSION['email'], $this->status, date('Y-m-d h:i:s'));
		if (!$plataforma->query($query)) {
			$this->msg = "Ocorreu um erro na PLATAFORMA, contate o administrador do sistema!";
			return false;	
		}	

		if ($this->id_plataforma != funcionalidadeConst::PERFIL_BPO && $this->id_plataforma != funcionalidadeConst::PERFIL_PORTAL) {
			if (!$this->findAnotherSystem('apontamento', $this->email)) {
				$this->insertApontamento();
			} else {
				$this->update('apontamento');
			}
		} else {
			if ($this->findAnotherSystem('apontamento', $this->email)) {
				$this->statusUsuarios($this->email, funcionalidadeConst::ATIVO);
			}
		}

		if ($this->id_plataforma != funcionalidadeConst::PERFIL_PROJETOS && $this->id_plataforma != funcionalidadeConst::PERFIL_PORTAL) {
			if (!$this->findAnotherSystem('agenda', $this->email)) {
				$this->insertAgenda();
			} else {
				$this->update('agenda');
			}
		}	else {
			$this->deleteAgenda($this->email, true);
		}

		if ($this->id_plataforma != funcionalidadeConst::PERFIL_PROJETOS && $this->id_plataforma != funcionalidadeConst::PERFIL_BPO) {

			if (!$this->findAnotherSystem('portal', $this->email)) {
				$this->insertPortal();
			} else {
				$this->update('portal');
			}
		}	else {
			if ($this->findAnotherSystem('portal', $this->email)) {
				$this->statusUsuariosPortal($this->email, funcionalidadeConst::INATIVO);
			}
		}

		$this->msg = "Registro inserido com sucesso!";
		return true;
	}


	public function reset()
	{
		if (!$this->checkReset()) {
			return false;
		}

		$conn = $this->PlatformDB->mysqli_connection;
		$query = sprintf(" UPDATE plataformausuario SET senha = '%s', data_alteracao = NOW(), reset_senha = '%s' WHERE id = %d", 
			base64_encode($this->senha), funcionalidadeConst::RESET_FALSE, $_SESSION['id']);	
		if (!$conn->query($query)) {
			$this->msg = "Ocorreu um erro, contate o administrador do sistema! ";
			return false;	
		}

		if ($this->id_plataforma != funcionalidadeConst::PERFIL_BPO && $this->id_plataforma != funcionalidadeConst::PERFIL_PORTAL) {
			$conn = $this->ApontDB->mysqli_connection;
			$query = sprintf(" UPDATE usuarios SET senha = '%s', data_alteracao = NOW() WHERE email = '%s'", 
				md5($this->senha), $_SESSION['email']);

			if (!$conn->query($query)) {
				$this->msg = "Ocorreu um erro, contate o administrador do sistema!";
				return false;	
			}
		}

		if ($this->id_plataforma != funcionalidadeConst::PERFIL_PROJETOS && $this->id_plataforma != funcionalidadeConst::PERFIL_PORTAL) {
			$conn = $this->AgendaDB->mysqli_connection;
			$query = sprintf(" UPDATE users SET password = '%s', updated_at = NOW() WHERE email = '%s'", 
				@crypt($this->senha), $_SESSION['email']);
			if (!$conn->query($query)) {
				$this->msg = "Ocorreu um erro, contate o administrador do sistema! ";
				return false;	
			}
		}

		if ($this->id_plataforma != funcionalidadeConst::PERFIL_PROJETOS && $this->id_plataforma != funcionalidadeConst::PERFIL_BPO) {
			$conn = $this->PortalDB->mysqli_connection;
			$query = sprintf(" UPDATE usuarios SET password = '%s', data_alteracao = NOW() WHERE email = '%s'", 
				@crypt($this->senha), $_SESSION['email']);
			if (!$conn->query($query)) {
				$this->msg = "Ocorreu um erro, contate o administrador do sistema! ";
				return false;	
			}
		}

		$_SESSION['reset_senha'] = funcionalidadeConst::RESET_FALSE;
		$_SESSION['senha'] = $this->senha;
		
		header('LOCATION:index.php');
		return true;
	}

	public function findAnotherSystem($sistema, $email)
	{

		if ($sistema == 'agenda') {
			$conn = $this->AgendaDB->mysqli_connection;
			$query = 'SELECT * FROM users WHERE email = "'.$email.'"';
		}

		if ($sistema == 'apontamento') {
			$conn = $this->ApontDB->mysqli_connection;
			$query = 'SELECT * FROM usuarios WHERE email = "'.$email.'"'; 
		}

		if ($sistema == 'portal') {
			$conn = $this->PortalDB->mysqli_connection;
			$query = 'SELECT * FROM usuarios WHERE email = "'.$email.'"'; 
		}

		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro durante a verificação do email";
			return false;	
		}
		
		if (!empty($result->fetch_array(MYSQLI_ASSOC))) {
			return true;			
		}

		return false;
	}

	public function update($sistema = false)
	{
		if (!empty($this->id)) {
			$conn = $this->PlatformDB->mysqli_connection;
			$query = " UPDATE plataformausuario SET nome = '".$this->nome."', email ='".$this->email."', id_perfilusuario = ".$this->id_plataforma.", id_responsabilidade = ".$this->id_responsabilidade.", reset_senha = '".$this->reset_senha."' , usuario = '".$_SESSION['email']."', data_alteracao = NOW(), status = '".$this->status."'";

			if ($this->reset_senha == 'S') {
				$query .= " , senha = '".base64_encode(funcionalidadeConst::SENHA_PADRAO)."'";	
			}

			$query .=  " WHERE id = '".$this->id."'";

			if (!$conn->query($query)) {
				$this->msg = "Ocorreu um erro, contate o administrador do sistema!";
				return false;
			}
		}

		if ($sistema == 'apontamento' || !empty($this->id)) {
			if ($this->findAnotherSystem('apontamento', $this->email)) {
				if ($this->id_plataforma == funcionalidadeConst::PERFIL_BPO || $this->id_plataforma == funcionalidadeConst::PERFIL_PORTAL) {
					$this->statusUsuarios($this->email, funcionalidadeConst::INATIVO);
				} else {
					$conn = $this->ApontDB->mysqli_connection;
					$query = "UPDATE usuarios SET nome = '".$this->nome."', email ='".$this->email."', id_perfilusuario = ".$this->id_apontamento.", id_responsabilidade = ".$this->id_responsabilidade.", usuario = '".$_SESSION['email']."', data_alteracao = NOW(), status = '".$this->status."' WHERE email = '".$this->email."'";
					if (!$conn->query($query)) {	
						$this->msg = "Ocorreu um erro, contate o administrador do sistema! ";
						return false;	
					}	
				}
			} else {
				$this->insertApontamento();
			}
		}

		if ($sistema == 'agenda' || !empty($this->id)) {
			if ($this->findAnotherSystem('agenda', $this->email)) {
				if ($this->id_plataforma == funcionalidadeConst::PERFIL_PROJETOS || $this->id_plataforma == funcionalidadeConst::PERFIL_PORTAL) {
					$this->deleteAgenda($this->email);
				} else {
					$this->deleteAgenda($this->email, false, true);
					$user = $this->searchAgenda($this->email);
					$conn = $this->AgendaDB->mysqli_connection;

					$query = "UPDATE users SET name = '".$this->nome."', email ='".$this->email."' WHERE id = ".$user['id'];
					if (!$conn->query($query)) {
						$this->msg = "Ocorreu um erro, contate o administrador do sistema! ";
						return false;	
					}

					$queryRoles = sprintf("INSERT INTO role_user (user_id, role_id) VALUES (%d, %d)", $user['id'], $this->id_agenda);
					if (!$conn->query($queryRoles)) {
						$this->msg = "Ocorreu um erro no AGENDA, contate o administrador do sistema!";
						return false;	
					}

					if (is_array($this->id_tributos)) {
						foreach ($this->id_tributos as $k => $tributo) {
							$queryTrib = sprintf("INSERT INTO tributo_user (user_id, tributo_id) VALUES (%d, %d)", $user['id'], $tributo);
							if (!$conn->query($queryTrib)) {
								$this->msg = "Ocorreu um erro no AGENDA, contate o administrador do sistema!";
								return false;	
							}
						}
					}

					if (is_array($this->id_empresas)) {
						foreach ($this->id_empresas as $l => $empresa) {
							$queryEmp = sprintf("INSERT INTO empresa_user (user_id, empresa_id) VALUES (%d, %d)", $user['id'], $empresa);
							if (!$conn->query($queryEmp)) {
								$this->msg = "Ocorreu um erro no AGENDA, contate o administrador do sistema!";
								return false;	
							}
						}
					}
				}
			} else {
				$this->insertAgenda();
			}
		}

		if ($sistema == 'portal' || !empty($this->id)) {
			if ($this->findAnotherSystem('portal', $this->email)) {
				if ($this->id_plataforma == funcionalidadeConst::PERFIL_PROJETOS || $this->id_plataforma == funcionalidadeConst::PERFIL_BPO) {
					$this->statusUsuariosPortal($this->email, funcionalidadeConst::INATIVO);
				} else {
					$this->deletePortal($this->email, true);
					
					$user = $this->searchPortal($this->email);
					$conn = $this->PortalDB->mysqli_connection;

					$query = "UPDATE usuarios SET nome = '".utf8_decode($this->nome)."', email ='".$this->email."' WHERE usuarioid = ".$user['id'];
					if (!$conn->query($query)) {
						$this->msg = "Ocorreu um erro, contate o administrador do sistema!";
						return false;	
					}

					if (is_array($this->id_portalempresas)) {
						foreach ($this->id_portalempresas as $l => $empresa) {
							$queryEmp = sprintf("INSERT INTO permissaoempresas (id_usuario, id_empresa) VALUES (%d, %d)", $user['id'], $empresa);
							if (!$conn->query($queryEmp)) {
								$this->msg = "Ocorreu um erro no PORTAL, contate o administrador do sistema!";
								return false;	
							}
						}
					}
				}
			} else {
				$this->insertPortal();
			}
		}

		$this->msg = "Dados alterados com sucesso";
		return true;
	}

	public function get($id)
	{
		$conn = $this->PlatformDB->mysqli_connection;
		$query = sprintf("SELECT id, nome, email, id_perfilusuario, id_responsabilidade, senha, reset_senha, status FROM plataformausuario WHERE id =  %d ", $this->id);

		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro no carregamento do usuário";	
			return false;	
		}

		$this->array = $result->fetch_array(MYSQLI_ASSOC);
		$this->msg = 'Registro carregado com sucesso';
		return true;
	}

	public function lista()
	{
		$conn = $this->PlatformDB->mysqli_connection;
		$query = sprintf("SELECT A.*, B.nome as perfil FROM plataformausuario A INNER JOIN plataformaperfilusuario B ON A.id_perfilusuario = B.id");

		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro no carregamento dos usuarios";	
			return false;	
		}

		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
    		$this->array[] = $row;
		}
	}
	public function deleta($id)
	{
		if (!$id) {
			return false;
		}

		$this->get($id);
		$this->deleteApontamento($this->array['email']);
		$this->deleteAgenda($this->array['email'], true);

		$conn = $this->PlatformDB->mysqli_connection;
		$query = sprintf("DELETE FROM plataformausuario WHERE id = %d ", $id);
		
		if (!$result = $conn->query($query)) {
			$this->msg = "O usuário tem um vinculo externo, exclusão não permitida.";	
			return false;	
		}

		$this->msg = 'Registro excluido com sucesso';
		return true;	
	}

	public function searchAgenda($email)
	{
		$conn = $this->AgendaDB->mysqli_connection;	
		$query = 'SELECT id FROM users WHERE email = "'.$email.'" limit 1';

		if (!$result = $conn->query($query)) {
			return false;	
		}

		return $result->fetch_array(MYSQLI_ASSOC);
	}

	public function searchPortal($email)
	{
		$conn = $this->PortalDB->mysqli_connection;	
		$query = 'SELECT usuarioid as id FROM usuarios WHERE email = "'.$email.'" limit 1';

		if (!$result = $conn->query($query)) {
			return false;	
		}

		return $result->fetch_array(MYSQLI_ASSOC);
	}

	public function deleteAgenda($email, $all = false, $params = true)
	{
		if (!$email) {
			return false;
		}

		$conn = $this->AgendaDB->mysqli_connection;
		$user = $this->searchAgenda($email);

		$query = sprintf("DELETE FROM tributo_user WHERE user_id = %d ", $user['id']);
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro na exlusão do usuário no agenda.";	
			return false;	
		}

		$query = sprintf("DELETE FROM role_user WHERE user_id = %d ", $user['id']);
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro na exlusão do usuário no agenda.";	
			return false;	
		}

		$query = sprintf("DELETE FROM empresa_user WHERE user_id = %d ", $user['id']);
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro na exlusão do usuário no agenda.";
			return false;	
		}

		if (!$params) {
			$query = sprintf("DELETE FROM users WHERE id = %d ", $user['id']);
			if (!$result = $conn->query($query)) {
				$this->msg = "Ocorreu um erro na exlusão do usuário no agenda.";
				return false;	
			}
		}
	
		return true;	
	}

	public function deletePortal($email, $all = false)
	{
		if (!$email) {
			return false;
		}

		$conn = $this->PortalDB->mysqli_connection;
		$user = $this->searchPortal($email);

		$query = sprintf("DELETE FROM permissaoempresas WHERE id_usuario = %d ", $user['id']);
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro na exlusão do usuário no portal.";
			return false;	
		}

		if (!$all) {
			$query = sprintf("DELETE FROM usuarios WHERE usuarioid = %d ", $user['id']);
			if (!$result = $conn->query($query)) {
				$this->msg = "Ocorreu um erro na exlusão do usuário no portal.";
				return false;	
			}
		}
	
		return true;	
	}

	public function statusUsuarios($email, $status)
	{
		$conn = $this->ApontDB->mysqli_connection;
		$query = sprintf(" UPDATE usuarios SET status = '%s', data_alteracao = NOW() WHERE email = '%s'", 
		$status, $email);	

		if (!$conn->query($query)) {
			$this->msg = "Ocorreu um erro, contate o administrador do sistema!";
			return false;	
		}
		return true;
	}

	public function statusUsuariosPortal($email, $status)
	{
		$conn = $this->PortalDB->mysqli_connection;
		$query = sprintf(" UPDATE usuarios SET status = '%s', data_alteracao = NOW() WHERE email = '%s'", 
		$status, $email);	

		if (!$conn->query($query)) {
			$this->msg = "Ocorreu um erro, contate o administrador do sistema!";
			return false;	
		}
		return true;
	}

	public function deleteApontamento($email)
	{
		if (!$email) {
			return false;
		}
		
		$conn = $this->ApontDB->mysqli_connection;
		$query = sprintf("DELETE FROM usuarios WHERE email = '%s' ", $email);

		if (!$result = $conn->query($query)) {
			$this->msg = "O usuário tem um vinculo externo, exclusão não permitida.";	
			return false;	
		}

		return true;	
	}

}

?>