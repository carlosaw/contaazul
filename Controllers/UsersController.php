<?php

namespace Controllers;

use \Core\Controller;
use \Models\Users;
use \Models\Companies;
use \Models\Permissions;

class UsersController extends Controller {

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

		if($u->hasPermission('users_view')) {//só manda pro view se tiver permission
			$data['users_list'] = $u->getList($u->getCompany());

    	$this->loadTemplate('users', $data);
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

	if($u->hasPermission('users_view')) {//só manda pro view se tiver permission
		$p = new Permissions();

		if(isset($_POST['email']) && !empty($_POST['email'])) {
			$name = addslashes($_POST['name']);
			$email = addslashes($_POST['email']);
			$password = addslashes($_POST['password']);
			$group = addslashes($_POST['group']);

			$a = $u->add($name, $email, $password, $group, $u->getCompany());

			if($a == '1') {
				header("Location: ".BASE_URL."users");
			} else {
				$data['error_msg'] = "Este email já Existe!";
			}				
		}

		$data['group_list'] = $p->getGroupList($u->getCompany());

			$this->loadTemplate('users_add', $data);
		} else {
			header("Location: ".BASE_URL);
		}
	}

  public function edit($id) {
    $data = array();
    $u = new Users();
		$u->setLoggedUser();//Pega a sessão do usuario logado
		$company = new Companies($u->getCompany());//Usa user pra pegar compania
		$data['company_name'] = $company->getName();
		$data['user_email'] = $u->getEmail();
		$data['user_name'] = $u->getNameUser();

		if($u->hasPermission('users_view')) {//só manda pro view se tiver permission
			$p = new Permissions();

			if(isset($_POST['group']) && !empty($_POST['group'])) {
				$name = addslashes($_POST['name']);
				$password = addslashes($_POST['password']);
				$group = addslashes($_POST['group']);

				$u->edit($name, $password, $group, $id, $u->getCompany());
				header("Location: ".BASE_URL."users");		
			}

			$data['user_info'] = $u->getInfo($id, $u->getCompany());
			$data['group_list'] = $p->getGroupList($u->getCompany());

    	$this->loadTemplate('users_edit', $data);
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

		if($u->hasPermission('users_view')) {//só manda pro view se tiver permission
			$p = new Permissions();

    		$u->delete($id, $u->getCompany());
    		header("Location: ".BASE_URL."users");
    	} else {
    		header("Location: ".BASE_URL);
    	}
    }
}