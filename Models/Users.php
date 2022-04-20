<?php

namespace Models;

use \Core\Model;
class Users extends Model {

	private $userInfo;
	private $permissions;

	public function isLogged() {
		
		if(isset($_SESSION['ccUser']) && !empty($_SESSION['ccUser'])) {
			return true;
		} else {
			return false;
		}
	}

	public function doLogin($email, $password) {

		$sql = $this->db->prepare("SELECT * FROM users WHERE email = :email AND password = :password");
		$sql->bindValue(':email', $email);
		$sql->bindValue(':password', md5($password));
		$sql->execute();

		if($sql->rowCount() > 0) {//Se houve registro
			$row = $sql->fetch();//Guarda em row
			$_SESSION['ccUser'] = $row['id'];//Cria a sessão ccUser
			//Retorna verdadeiro
			return true;
		} else {
			return false;
		}

	}

	public function setLoggedUser() {

		if(isset($_SESSION['ccUser']) && !empty($_SESSION['ccUser'])) {
			$id = $_SESSION['ccUser'];

			$sql = $this->db->prepare("SELECT * FROM users WHERE id = :id");
			$sql->bindValue(':id', $id);
			$sql->execute();

			if($sql->rowCount() > 0) {
				$this->userInfo = $sql->fetch();
				$this->permissions = new Permissions();
				$this->permissions->setGroup($this->userInfo['id_group'], $this->userInfo['id_company']);
			}
		}
	}

	public function logout() {
		unset($_SESSION['ccUser']);
	}

	public function hasPermission($name) {
		return $this->permissions->haspermission($name);
	}

	public function getCompany() {
		if(isset($this->userInfo['id_company'])) {
			return $this->userInfo['id_company'];
		} else {
			return 0;
		}
	}
	
	public function getEmail() {
		if(isset($this->userInfo['email'])) {
			return $this->userInfo['email'];
		} else {
			return '';
		}
	}
	
	public function getNameUser() {
		if(isset($this->userInfo['name'])) {
			return $this->userInfo['name'];
		} else {
			return '';
		}
	}

	public function getId() {
		if(isset($this->userInfo['id'])) {
			return $this->userInfo['id'];
		} else {
			return '';
		}
	}

	public function getInfo($id, $id_company) {//Retorna um array com as infor do usuario.
		$array = array();

		$sql = $this->db->prepare("SELECT * FROM users WHERE id = :id AND $id_company = :id_company");
		$sql->bindValue(':id', $id);
		$sql->bindValue(':id_company', $id_company);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$array = $sql->fetch();
		}
		return $array;
	}

	public function findUsersInGroup($id) {
		$sql = $this->db->prepare("SELECT COUNT(*) as c FROM users WHERE id_group = :group");
		$sql->bindValue(":group", $id);
		$sql->execute();
		$row = $sql->fetch();
		
		if($row['c'] == '0') {
			return false;
		} else {
			return true;
		}
	}

	public function getList($id_company) {
		$array = array();

		$sql = $this->db->prepare("
			SELECT
				users.id,
				users.name,
				users.email,
				permission_groups.gname 
			FROM users
			LEFT JOIN permission_groups ON permission_groups.id = users.id_group
			WHERE
			users.id_company = :id_company");
		$sql->bindValue(':id_company', $id_company);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll();
		}

		return $array;
	}

	public function add($name, $email, $password, $group, $id_company) {
		//Verifica se já tem usuário com este email.
		$sql = $this->db->prepare("SELECT COUNT(*) as c FROM users WHERE email = :email");
		$sql->bindValue(':email', $email);
		$sql->execute();
		$row = $sql->fetch();

		//Se não achou usuario com este email, adiciona.
		if($row['c'] == '0') {
			$sql = $this->db->prepare("INSERT INTO users (id_company, name, email, password, id_group) VALUES (:id_company, :name, :email, :password, :id_group)");
			$sql->bindValue(':id_company', $id_company);
			$sql->bindValue(':name', $name);
			$sql->bindValue(':email', $email);
			$sql->bindValue(':password', md5($password));
			$sql->bindValue(':id_group', $group);			
			$sql->execute();

			return '1';
		} else {
			return '0';
		}
		
	}

	public function edit($name, $password, $group, $id, $id_company) {
		$sql = $this->db->prepare("UPDATE users SET id_group = :id_group, name = :name WHERE id = :id AND id_company = :id_company");
		$sql->bindValue(':id_group', $group);
		$sql->bindValue(':name', $name);
		$sql->bindValue(':id', $id);
		$sql->bindValue(':id_company', $id_company);
		$sql->execute();

		if(!empty($password)) {//Muda a senha se tiver preenchida.
			$sql = $this->db->prepare("UPDATE users SET password = :password WHERE id = :id AND id_company = :id_company");
			$sql->bindValue(':password', md5($password));
			$sql->bindValue(':id', $id);
			$sql->bindValue(':id_company', $id_company);
			$sql->execute();
		}

	}

	public function delete($id, $id_company) {
		$sql = $this->db->prepare("DELETE FROM users WHERE id = :id AND id_company = :id_company");
		$sql->bindValue(':id', $id);
		$sql->bindValue(':id_company', $id_company);
		$sql->execute();
	}

	public function searchUserByName($name) {
		$array = array();

		$sql = $this->db->prepare("SELECT name, id FROM users WHERE name LIKE :name LIMIT 10");
		$sql->bindValue(':name', '%'.$name.'%');
		$sql->execute();

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll();
		}

		return $array;
	}

}