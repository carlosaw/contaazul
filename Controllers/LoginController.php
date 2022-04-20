<?php

namespace Controllers;

use \Core\Controller;
use \Models\Users;
class LoginController extends Controller {
	
	public function index() {
		$data = array();
		//Se existir email e senha 
		if(isset($_POST['email']) && !empty($_POST['email'])) {
			$email = addslashes($_POST['email']);//pega email
			$pass = addslashes($_POST['password']);//pega senha

			$u = new Users();//Chama o model Users

			if($u->doLogin($email, $pass)) {//Se bater
				header("Location: ".BASE_URL);
				exit;
			} else {
				$data['error'] = 'Email e/ou senha errados!';
			}
		}

		$this->loadView('login', $data);
	}

	public function logout() {
		$u = new Users();
		$u->setLoggedUser();		
		$u->logout();
		header("Location: ".BASE_URL);			
	}
	
}