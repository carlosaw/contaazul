<?php

namespace Controllers;

use \Core\Controller;
use \Models\Users;
use \Models\Companies;
use \Models\Purchases;
class PurchasesController extends Controller {

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
		$p = new Purchases();
		$u->setLoggedUser();//Pega a sessão do usuario logado
		$company = new Companies($u->getCompany());//Usa user pra pegar compania
		$data['company_name'] = $company->getName();
		$data['user_name'] = $u->getNameUser();

		$data['statuses'] = array(
			'0'=>'Aguardando Pgto.',
			'1'=>'Pago',
			'2'=>'Cancelado'
		);

		if($u->hasPermission('purchases_view')) {
			$p = new Purchases();

			$data['p'] = 1;
			if(isset($_GET['p']) && !empty($_GET['p'])) {
				$data['p'] = intval($_GET['p']);
				if($data['p'] == 0) {
					$data['p'] = 1;
				}
			}
			$offset = ( 10 * ($data['p']-1) );

			$data['purchases_list'] = $p->getList($offset, $u->getCompany());
			$data['purchases_count'] = $p->getCount($u->getCompany());
			$data['pu_count'] = ceil( $data['purchases_count'] / 10 );
			$data['edit_permission'] = $u->hasPermission('purchases_edit');

			$this->loadTemplate("purchases", $data);
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
		$data['user_name'] = $u->getNameUser();

		if($u->hasPermission('purchases_edit')) {
			$p = new Purchases();
			
			if(isset($_POST['user_id']) && !empty($_POST['user_id'])) {
				$user_id = addslashes($_POST['user_id']);
				$quant = $_POST['quant'];
				$data['permission_edit'] = $u->hasPermission('purchases_edit');	

				if(isset($_POST['status']) && $data['permission_edit']) {
					$status = addslashes($_POST['status']);				
					$p->changeStatus($status, $user_id, $u->getCompany());
					header("Location: ".BASE_URL."purchases");
				}

				$p->addPurchase($u->getCompany(), $user_id, $quant, $status);
				header("Location: ".BASE_URL."purchases");
			}

			$this->loadTemplate("purchases_add", $data);
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

		$data['statuses'] = array(
			'0'=>'Aguardando Pgto.',
			'1'=>'Pago',
			'2'=>'Cancelado'
		);

		if($u->hasPermission('purchases_view')) {
			$p = new Purchases();

			$data['permission_edit'] = $u->hasPermission('purchases_edit');	
			if(isset($_POST['status']) && $data['permission_edit']) {
				$status = addslashes($_POST['status']);				
				$p->changeStatus($status, $id, $u->getCompany());
				header("Location: ".BASE_URL."purchases");
			}
			// Pega os dados para editar
			$data['purchases_info'] = $p->getInfo($id, $u->getCompany());
			
			$this->loadTemplate("purchases_edit", $data);
		} else {
			header("Location: ".BASE_URL);
		}
  }
}