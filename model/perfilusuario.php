<?php 
/**
* 
*/
class perfilusuario extends app
{
	public function apontamentoPerfis($selected=0)
	{
		$conn = $this->ApontDB->mysqli_connection;
		$query = sprintf("SELECT id,nome FROM perfilusuario WHERE status = '%s' ORDER BY nome", $this::STATUS_SISTEMA_ATIVO);

		if($result = $conn->query($query))
		{
			while($row = $result->fetch_array(MYSQLI_ASSOC))
			echo sprintf("<option %s value='%d'>%s</option>\n", $selected == $row['id'] ? "selected" : "",
			$row['id'], $row['nome']);
		}
	}

	public function agendaPerfis($selected=0)
	{
		$conn = $this->AgendaDB->mysqli_connection;
		$query = "SELECT id,name FROM roles ORDER BY name";

		if($result = $conn->query($query))
		{
			while($row = $result->fetch_array(MYSQLI_ASSOC))
			echo sprintf("<option %s value='%d'>%s</option>\n", $selected == $row['id'] ? "selected" : "",
			$row['id'], $row['name']);
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

	public function agendaEmpresas()
	{
		$conn = $this->AgendaDB->mysqli_connection;
		$query = sprintf("SELECT id,razao_social FROM empresas ORDER BY razao_social");

		if($result = $conn->query($query))
		{
			while($row = $result->fetch_array(MYSQLI_ASSOC))
			echo sprintf("<option %s value='%d'>%s</option>\n", $selected == $row['id'] ? "selected" : "",
			$row['id'], $row['razao_social']);
		}
	}	

	public function agendaTributos()
	{
		$conn = $this->AgendaDB->mysqli_connection;
		$query = sprintf("SELECT id,nome FROM tributos ORDER BY nome");

		if($result = $conn->query($query))
		{
			while($row = $result->fetch_array(MYSQLI_ASSOC))
			echo sprintf("<option %s value='%d'>%s</option>\n", $selected == $row['id'] ? "selected" : "",
			$row['id'], $row['nome']);
		}
	}	
}