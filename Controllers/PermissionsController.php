<?php

namespace Controllers;

use \Core\Controller;
use \Models\Users;
use \Models\Companies;
use \Models\Permissions;
class PermissionsController extends Controller {

	public function __construct() {
    //parent::__construct();
    $u = new Users();
		if($u->isLogged() == false) {
			header("Location: ".BASE_URL."login");
			exit;
		}
  }

  public function index() {
    $data = array();

    $u = new Users();
		$u->setLoggedUser();//Pega a sessão do usuario logado
		$company = new Companies($u->getCompany());//Usa user pra pegar compania
		$data['company_name'] = $company->getName();
		$data['user_email'] = $u->getEmail();
		$data['user_name'] = $u->getNameUser();

		if($u->hasPermission('permissions_view')) {//só manda pro view se tiver permission
		$permissions = new Permissions();
		// Pega a listagem das permissões daquela empresa e manda pro view
		$data['permissions_list'] = $permissions->getList($u->getCompany());
		$data['permissions_groups_list'] = $permissions->getGroupList($u->getCompany());

			$this->loadTemplate('permissions', $data);
		} else {
			header("Location: ".BASE_URL);
		}
	}

	public function add() {
		$data = array();

		$u = new Users();
	$u->setLoggedUser();//Pega a sessão do usuario logado
	$company = new Companies($u->getCompany());//Usa user pra pegar compania
	$data['company_name'] = $company->getName();
	$data['user_email'] = $u->getEmail();
	$data['user_name'] = $u->getNameUser();

	if($u->hasPermission('permissions_view')) {//só manda pro view se tiver permission
		$permissions = new Permissions();

		if(isset($_POST['name']) && !empty($_POST['name'])) {
			$pname = addslashes($_POST['name']);

			$permissions->add($pname, $u->getCompany());
			header("Location: ".BASE_URL."/permissions");
		}
		
			$this->loadTemplate('permissions_add', $data);
		} else {
			header("Location: ".BASE_URL);
		}
	}

	public function add_group() {
		$data = array();

		$u = new Users();
	$u->setLoggedUser();//Pega a sessão do usuario logado
	$company = new Companies($u->getCompany());//Usa user pra pegar compania
	$data['company_name'] = $company->getName();
	$data['user_email'] = $u->getEmail();
	$data['user_name'] = $u->getNameUser();

	if($u->hasPermission('permissions_view')) {//só manda pro view se tiver permission
		$permissions = new Permissions();

		if(isset($_POST['gname']) && !empty($_POST['gname'])) {
			$pname = addslashes($_POST['gname']);
			$plist = $_POST['permissions'];

			$permissions->addGroup($pname, $plist, $u->getCompany());
			header("Location: ".BASE_URL."/permissions");
		}

		$data['permissions_list'] = $permissions->getList($u->getCompany()); 
		
			$this->loadTemplate('permissions_addgroup', $data);
		} else {
			header("Location: ".BASE_URL);
		}

	}

	public function delete($id) {
		$data = array();

		$u = new Users();
	$u->setLoggedUser();//Pega a sessão do usuario logado
	$company = new Companies($u->getCompany());//Usa user pra pegar compania
	$data['company_name'] = $company->getName();
	$data['user_email'] = $u->getEmail();
	$data['user_name'] = $u->getNameUser();

	if($u->hasPermission('permissions_view')) {//só manda pro view se tiver permission
		$permissions = new Permissions();
		$permissions->delete($id);
		header("Location: ".BASE_URL."/permissions");

		} else {
			header("Location: ".BASE_URL);
		}

	}

	public function delete_group($id) {
		$data = array();
		$u = new Users();
		$u->setLoggedUser();//Pega a sessão do usuario logado
		$company = new Companies($u->getCompany());//Usa user pra pegar compania
		$data['company_name'] = $company->getName();
		$data['user_email'] = $u->getEmail();
		$data['user_name'] = $u->getNameUser();

		if($u->hasPermission('permissions_view')) {//só manda pro view se tiver permission
			$permissions = new Permissions();
			$permissions->deleteGroup($id);
			header("Location: ".BASE_URL."/permissions");
		} else {
			header("Location: ".BASE_URL);
		}
	}

	public function edit_group($id) {
		$data = array();

		$u = new Users();
	$u->setLoggedUser();//Pega a sessão do usuario logado
	$company = new Companies($u->getCompany());//Usa user pra pegar compania
	$data['company_name'] = $company->getName();
	$data['user_email'] = $u->getEmail();
	$data['user_name'] = $u->getNameUser();
	//só manda pro view se tiver permission
	if($u->hasPermission('permissions_view')) {
		$permissions = new Permissions();

		if(isset($_POST['gname']) && !empty($_POST['gname'])) {
			$pname = addslashes($_POST['gname']);
			$plist = $_POST['permissions'];

			$permissions->editGroup($pname, $plist, $id, $u->getCompany());
			header("Location: ".BASE_URL."/permissions");
		}

		$data['permissions_list'] = $permissions->getList($u->getCompany()); 
		$data['group_info'] = $permissions->getGroup($id, $u->getCompany());

			$this->loadTemplate('permissions_editgroup', $data);
		} else {
			header("Location: ".BASE_URL);
		}
	}
}