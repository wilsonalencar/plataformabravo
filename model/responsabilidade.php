<?php
require_once('app.php');
/**
* Lucas Barbosa de Alencar
*/
class responsabilidade extends app
{
	public $id;
	public $codigo;
	public $nome;
	public $status;
	public $msg;
	public $array;

	private function checkExiste()
	{
		$conn = $this->ApontDB->mysqli_connection;		
		$query = sprintf("SELECT codigo FROM responsabilidades WHERE codigo = '%s' AND id <> %d", $this->codigo, $this->id);	
		
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro durante a verificação do código da responsabilidade";
			return false;	
		}
		
		if (!empty($result->fetch_array(MYSQLI_ASSOC))) {
			$this->msg = "Codigo da responsabilidade já está sendo utilizado";
			return false;			
		}
		return true;
	}

	private function check()
	{
		if (empty($this->codigo)) {
			$this->msg = "Insira o código da responsabilidade.";
			return false;
		}

		if (empty($this->nome)) {
			$this->msg = "Insira o nome da responsabilidade.";
			return false;
		}

		if (!$this->checkExiste()) {
			return false;
		}

		return true;
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
	
	public function montaSelect($selected=0)
	{
		$conn = $this->ApontDB->mysqli_connection;
		$query = sprintf("SELECT id,nome FROM responsabilidades WHERE status = '%s' ORDER BY nome", $this::STATUS_SISTEMA_ATIVO);

		if($result = $conn->query($query))
		{
			while($row = $result->fetch_array(MYSQLI_ASSOC))
			echo sprintf("<option %s value='%d'>%s</option>\n", $selected == $row['id'] ? "selected" : "",
			$row['id'], $row['nome']);
		}
	}

	public function insert()
	{
		$conn = $this->ApontDB->mysqli_connection;
		$query = sprintf(" INSERT INTO responsabilidades (codigo, nome, status, usuario)
		VALUES ('%s','%s','%s',%d)", 
			$this->codigo, $this->nome, $this->status, $_SESSION['usuarioID']);	

		if (!$conn->query($query)) {
			$this->msg = "Ocorreu um erro, contate o administrador do sistema!";
			return false;	
		}
		$this->msg = "Registros inseridos com sucesso!";
		return true;
	}

	public function update()
	{
		$conn = $this->ApontDB->mysqli_connection;
		$query = sprintf(" UPDATE responsabilidades SET nome = '%s', status ='%s', usuario = %d, data_alteracao = NOW() WHERE id = %d", 
			$this->nome, $this->status, $_SESSION['usuarioID'], $this->id);	
	
		if (!$conn->query($query)) {
			$this->msg = "Ocorreu um erro, contate o administrador do sistema!";
			return false;	
		}

		$this->msg = "Registros atualizados com sucesso!";
		return true;
	}

	public function get($id)
	{
		if (!$id) {
			return false;
		}
		$conn = $this->ApontDB->mysqli_connection;
		$query = sprintf("SELECT id, codigo, nome, status, usuario FROM responsabilidades WHERE id =  %d ", $id);
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro no carregamento da responsabilidade";	
			return false;	
		}
		$this->array = $result->fetch_array(MYSQLI_ASSOC);
		$this->msg = 'Registro carregado com sucesso';
		return true;
	}

	public function lista()
	{
		$conn = $this->ApontDB->mysqli_connection;
		$query = sprintf("SELECT id, codigo, nome, status, usuario FROM responsabilidades");
		
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro no carregamento dos responsabilidades";	
			return false;	
		}
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$row['status'] = $this->formatStatus($row['status']);
			$this->array[] = $row;
		}
	}

	private function formatStatus($status)
	{
		if ($status == $this::STATUS_SISTEMA_ATIVO) {
			return "Ativo";
		}
		return "Inativo";
	}

	public function deleta($id)
	{
		if (!$id) {
			return false;
		}
		
		$conn = $this->ApontDB->mysqli_connection;
		$query = sprintf("DELETE FROM responsabilidades WHERE id = %d ", $id);
		
		if (!$result = $conn->query($query)) {
			$this->msg = "A responsabilidade tem um vinculo externo, exclusão não permitida.";	
			return false;	
		}

		$this->msg = 'Registro excluido com sucesso';
		return true;	
	}


}

?>