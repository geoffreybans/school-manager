<?php
class Log_in extends CI_Model {

	public function auth($username) {
	
	$sql = $this->db->query("SELECT * FROM users WHERE name = '$username'");
	return $sql;
	
	
	}
	}

?>