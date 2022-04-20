<?php
namespace Controllers;

use \Core\Controller;
use \Models\Users;
use \Models\Companies;
use \Models\Sales;

class HomeController extends Controller {

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

		$s = new Sales();// Dashboard

		$data['statuses'] = array(
			'0'=>'Aguardando Pgto.',
			'1'=>'Pago',
			'2'=>'Cancelado'
	);
	
	// Produtos Vendidos
	$data['products_sold'] = $s->getSoldProducts(date('Y-m-d', strtotime('-30 days')), date('Y-m-d'), $u->getCompany());
	// Receitas - faturamento
	$data['revenue'] = $s->getTotalRevenue(date('Y-m-d', strtotime('-30 days')), date('Y-m-d'), $u->getCompany());
	// Despesas
	$data['expenses'] = $s->getTotalExpenses(date('Y-m-d', strtotime('-30 days')), date('Y-m-d'), $u->getCompany());

	$data['days_list'] = array();
	for($q=30;$q>0;$q--) {// Número de dias do gráfico
		$data['days_list'][] = date('d/m', strtotime('-'.$q.' days'));
	}

	$data['revenue_list'] = $s->getRevenueList(date('Y-m-d', strtotime('-30 days')), date('Y-m-d'), $u->getCompany());
	$data['expenses_list'] = $s->getExpensesList(date('Y-m-d', strtotime('-30 days')), date('Y-m-d'), $u->getCompany());
	$data['status_list'] = $s->getQuantStatusList(date('Y-m-d', strtotime('-30 days')), date('Y-m-d'), $u->getCompany());

	$this->loadTemplate('home', $data);
	}

}