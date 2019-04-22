<?php 
/**
* 
*/
class perfilusuario extends app
{
	public function apontamentoPerfis($id=false)
	{
		$conn = $this->ApontDB->mysqli_connection;
		$conn_platform = $this->PlatformDB->mysqli_connection;

		$exist = array();
		if ($id) {
			$original = 'SELECT email FROM plataformausuario where id = "'.$id.'"';
			if($result_original = $conn_platform->query($original))
			{
				$usuario = $result_original->fetch_array(MYSQLI_ASSOC);
			}

			$query_finder = 'SELECT id_perfilusuario FROM usuarios where email = "'.$usuario['email'].'"';
			if($result_finder = $conn->query($query_finder))
			{
				if (!empty($result_finder)) {
					while($row = $result_finder->fetch_array(MYSQLI_ASSOC))
					$exist[$row['id_perfilusuario']] = 1;
				}
			}
		}

		$query = sprintf("SELECT id,nome FROM perfilusuario WHERE status = '%s' ORDER BY nome", $this::STATUS_SISTEMA_ATIVO);

		if($result = $conn->query($query))
		{
			while($row = $result->fetch_array(MYSQLI_ASSOC))
			echo sprintf("<option %s value='%d'>%s</option>\n", array_key_exists($row['id'], $exist) ? "selected" : "",
			$row['id'], $row['nome']);
		}
	}

	public function agendaPerfis($id=false)
	{
		$conn = $this->AgendaDB->mysqli_connection;
		$conn_platform = $this->PlatformDB->mysqli_connection;

		$exist = array();
		if ($id) {
			$original = 'SELECT email FROM plataformausuario where id = "'.$id.'"';
			if($result_original = $conn_platform->query($original))
			{
				$usuario = $result_original->fetch_array(MYSQLI_ASSOC);
			}

			$query_finder = 'SELECT id FROM users where email = "'.$usuario['email'].'"';
			if($result_finder = $conn->query($query_finder))
			{
				if (!empty($result_finder)) {
					$usuario_innagenda = $result_finder->fetch_array(MYSQLI_ASSOC);

					$perfil_query = 'SELECT role_id FROM role_user where user_id = "'.$usuario_innagenda['id'].'"';
					if ($perfil_result = $conn->query($perfil_query)) {
						if (!empty($perfil_result)) {
							while($finded = $perfil_result->fetch_array(MYSQLI_ASSOC))
							$exist[$finded['role_id']] = 1;
						}
					}
				}
			}
		}

		$query = "SELECT id,name FROM roles ORDER BY name";
		if($result = $conn->query($query))
		{
			while($row = $result->fetch_array(MYSQLI_ASSOC))
			echo sprintf("<option %s value='%d'>%s</option>\n", array_key_exists($row['id'], $exist) ? "selected" : "",
			$row['id'], utf8_encode($row['name']));
		}
	}

	public function plataformaPerfis($selected=0)
	{
		$conn = $this->PlatformDB->mysqli_connection;
		$query = sprintf("SELECT id,nome FROM plataformaperfilusuario WHERE status = '%s' ORDER BY nome", $this::STATUS_SISTEMA_ATIVO);

		if($result = $conn->query($query))
		{
			while($row = $result->fetch_array(MYSQLI_ASSOC))
			echo sprintf("<option %s value='%d'>%s</option>\n", $selected == $row['id'] ? "selected" : "",
			$row['id'], $row['nome']);
		}
	}	

	public function agendaEmpresas($id = false)
	{
		$conn = $this->AgendaDB->mysqli_connection;
		$conn_platform = $this->PlatformDB->mysqli_connection;
	
		$exist = array();
		if ($id) {
			$original = 'SELECT email FROM plataformausuario where id = "'.$id.'"';
			if($result_original = $conn_platform->query($original))
			{
				$usuario = $result_original->fetch_array(MYSQLI_ASSOC);
			}

			$query_finder = 'SELECT id FROM users where email = "'.$usuario['email'].'"';
			if($result_finder = $conn->query($query_finder))
			{
				if (!empty($result_finder)) {
					$usuario_innagenda = $result_finder->fetch_array(MYSQLI_ASSOC);

					$perfil_query = 'SELECT empresa_id FROM empresa_user where user_id = "'.$usuario_innagenda['id'].'"';
					if ($perfil_result = $conn->query($perfil_query)) {
						if (!empty($perfil_result)) {
							while($finded = $perfil_result->fetch_array(MYSQLI_ASSOC))
							$exist[$finded['empresa_id']] = 1;
						}
					}
				}
			}
		}


		$query = sprintf("SELECT id,razao_social FROM empresas ORDER BY razao_social");
		if($result = $conn->query($query))
		{
			while($row = $result->fetch_array(MYSQLI_ASSOC))
			echo sprintf("<option %s value='%d'>%s</option>\n", array_key_exists($row['id'], $exist) ? "selected" : "",
			$row['id'], utf8_encode($row['razao_social']));
		}
	}	

	public function portalEmpresas($id = false)
	{
		$conn = $this->AgendaDB->mysqli_connection;
		$conn_platform = $this->PlatformDB->mysqli_connection;
		$conn_portal = $this->PortalDB->mysqli_connection;
	
		$exist = array();
		if ($id) {
			$original = 'SELECT email FROM plataformausuario where id = "'.$id.'"';
			if($result_original = $conn_platform->query($original))
			{
				$usuario = $result_original->fetch_array(MYSQLI_ASSOC);
			}

			$query_finder = 'SELECT usuarioid as id FROM usuarios where email = "'.$usuario['email'].'"';
			if($result_finder = $conn_portal->query($query_finder))
			{
				if (!empty($result_finder)) {
					$usuario_portal = $result_finder->fetch_array(MYSQLI_ASSOC);
					$perfil_query = 'SELECT id_empresa FROM permissaoempresas where id_usuario = "'.$usuario_portal['id'].'"';
					if ($perfil_result = $conn_portal->query($perfil_query)) {
						if (!empty($perfil_result)) {
							while($finded = $perfil_result->fetch_array(MYSQLI_ASSOC))
							$exist[$finded['id_empresa']] = 1;
						}
					}
				}
			}
		}


		$query = sprintf("SELECT id,razao_social FROM empresas ORDER BY razao_social");
		if($result = $conn->query($query))
		{
			while($row = $result->fetch_array(MYSQLI_ASSOC))
			echo sprintf("<option %s value='%d'>%s</option>\n", array_key_exists($row['id'], $exist) ? "selected" : "",
			$row['id'], utf8_encode($row['razao_social']));
		}
	}	

	public function agendaTributos($id = false)
	{
		$conn = $this->AgendaDB->mysqli_connection;
		$conn_platform = $this->PlatformDB->mysqli_connection;
	
		$exist = array();
		if ($id) {
			$original = 'SELECT email FROM plataformausuario where id = "'.$id.'"';
			if($result_original = $conn_platform->query($original))
			{
				$usuario = $result_original->fetch_array(MYSQLI_ASSOC);
			}

			$query_finder = 'SELECT id FROM users where email = "'.$usuario['email'].'"';
			if($result_finder = $conn->query($query_finder))
			{
				if (!empty($result_finder)) {
					$usuario_innagenda = $result_finder->fetch_array(MYSQLI_ASSOC);

					$perfil_query = 'SELECT tributo_id FROM tributo_user where user_id = "'.$usuario_innagenda['id'].'"';
					if ($perfil_result = $conn->query($perfil_query)) {
						if (!empty($perfil_result)) {
							while($finded = $perfil_result->fetch_array(MYSQLI_ASSOC))
							$exist[$finded['tributo_id']] = 1;
						}
					}
				}
			}
		}

		$query = sprintf("SELECT id,nome FROM tributos ORDER BY nome");
		if($result = $conn->query($query))
		{
			while($row = $result->fetch_array(MYSQLI_ASSOC))
			echo sprintf("<option %s value='%d'>%s</option>\n", array_key_exists($row['id'], $exist) ? "selected" : "",
			$row['id'], utf8_encode($row['nome']));
		}
	}	

	public function portalPerfis($id=false)
	{
		$conn = $this->PortalDB->mysqli_connection;
		$conn_platform = $this->PlatformDB->mysqli_connection;

		$exist = array();
		if ($id) {
			$original = 'SELECT email FROM plataformausuario where id = "'.$id.'"';
			if($result_original = $conn_platform->query($original))
			{
				$usuario = $result_original->fetch_array(MYSQLI_ASSOC);
			}

			$query_finder = 'SELECT id_perfilusuario FROM usuarios where email = "'.$usuario['email'].'"';
			if($result_finder = $conn->query($query_finder))
			{
				if (!empty($result_finder)) {
					while($row = $result_finder->fetch_array(MYSQLI_ASSOC))
					$exist[$row['id_perfilusuario']] = 1;
				}
			}
		}

		$query = "SELECT id,nome FROM perfilusuario ORDER BY nome";
		if($result = $conn->query($query))
		{
			while($row = $result->fetch_array(MYSQLI_ASSOC))
			echo sprintf("<option %s value='%d'>%s</option>\n", array_key_exists($row['id'], $exist) ? "selected" : "",
			$row['id'], utf8_encode($row['nome']));
		}
	}

	public function folhaPerfis($id=0)
	{
		$conn = $this->FolhaDB->mysqli_connection;
		$conn_platform = $this->PlatformDB->mysqli_connection;

		$exist = array();
		if ($id) {
			$original = 'SELECT email FROM plataformausuario where id = "'.$id.'"';
			if($result_original = $conn_platform->query($original))
			{
				$usuario = $result_original->fetch_array(MYSQLI_ASSOC);
			}

			$query_finder = 'SELECT id_perfilusuario FROM usuarios where email = "'.$usuario['email'].'"';
			if($result_finder = $conn->query($query_finder))
			{
				if (!empty($result_finder)) {
					while($row = $result_finder->fetch_array(MYSQLI_ASSOC))
					$exist[$row['id_perfilusuario']] = 1;
				}
			}
		}

		$query = "SELECT id,nome FROM perfilusuario ORDER BY nome";
		if($result = $conn->query($query))
		{
			while($row = $result->fetch_array(MYSQLI_ASSOC))
			echo sprintf("<option %s value='%d'>%s</option>\n", array_key_exists($row['id'], $exist) ? "selected" : "",
			$row['id'], utf8_encode($row['nome']));
		}
	}

	public function folhaEmpresas($id=0)
	{
		$conn = $this->FolhaDB->mysqli_connection;
		$conn_platform = $this->PlatformDB->mysqli_connection;
	
		$exist = array();
		if ($id) {
			$original = 'SELECT email FROM plataformausuario where id = "'.$id.'"';
			if($result_original = $conn_platform->query($original))
			{
				$usuario = $result_original->fetch_array(MYSQLI_ASSOC);
			}

			$query_finder = 'SELECT usuarioid as id FROM usuarios where email = "'.$usuario['email'].'"';
			if($result_finder = $conn->query($query_finder))
			{
				if (!empty($result_finder)) {
					$usuario_folha = $result_finder->fetch_array(MYSQLI_ASSOC);
					$perfil_query = 'SELECT id_empresa FROM permissaoempresas where id_usuario = "'.$usuario_folha['id'].'"';
					if ($perfil_result = $conn->query($perfil_query)) {
						if (!empty($perfil_result)) {
							while($finded = $perfil_result->fetch_array(MYSQLI_ASSOC))
							$exist[$finded['id_empresa']] = 1;
						}
					}
				}
			}
		}

		$query = sprintf("SELECT id,razao_social FROM empresa ORDER BY razao_social");
		if($result = $conn->query($query))
		{
			while($row = $result->fetch_array(MYSQLI_ASSOC))
			echo sprintf("<option %s value='%d'>%s</option>\n", array_key_exists($row['id'], $exist) ? "selected" : "",
			$row['id'], utf8_decode($row['razao_social']));
		}
	}
}