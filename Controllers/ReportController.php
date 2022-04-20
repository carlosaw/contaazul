<?php

namespace Controllers;

use \Core\Controller;
use \Models\Users;
use \Models\Companies;
use \Models\Sales;
use \Models\Inventory;
use \Models\Purchases;

class ReportController extends Controller {

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

		if($u->hasPermission('report_view')) {
			$this->loadTemplate("report", $data);
		} else {
			header("Location: ".BASE_URL);
		}
  }

	public function sales() {
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

		if($u->hasPermission('report_view')) {
			
			$this->loadTemplate("report_sales", $data);
		} else {
			header("Location: ".BASE_URL);
		}
    }

    public function purchases() {
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

		if($u->hasPermission('report_view')) {

			$this->loadTemplate("report_purchases", $data);
		} else {
			header("Location: ".BASE_URL);
		}
    }

	public function sales_pdf() {
		$data = array();
		$u = new Users();
		$u->setLoggedUser();//Pega a sessão do usuario logado
		$data['statuses'] = array(
			'0'=>'Aguardando Pgto.',
			'1'=>'Pago',
			'2'=>'Cancelado'
		);

		if($u->hasPermission('report_view')) {
			$client_name = addslashes($_GET['client_name']);
			$period1 = addslashes($_GET['period1']);
			$period2 = addslashes($_GET['period2']);
			$status = addslashes($_GET['status']);
			$order = addslashes($_GET['order']);

			$s = new Sales();

			$data['sales_list'] = $s->getSalesFiltered($client_name, $period1, $period2, $status, $order, $u->getCompany());
			$data['filters'] = $_GET;

			//$this->load->library('mpdf-development/mpdf');

            ob_start();
            $this->loadView("report_sales_pdf", $data);
            $html = ob_get_contents();
            ob_end_clean();

            $mpdf = new \Mpdf\Mpdf();
            $mpdf->WriteHTML($html);
            $mpdf->Output('arquivo.pdf', 'I');
            // I = abra no browser
            // D = faz o download
            // F = Salva no servidor
            //$link = 'http://localhost/contazul/arquivo.pdf';
            //echo "Faça o download no link:<br/>".$link;

			$this->loadView("report_sales_pdf", $data);
		} else {
			header("Location: ".BASE_URL);
		}
  }

	public function purchases_pdf() {
		$data = array();
		$u = new Users();
		$u->setLoggedUser();//Pega a sessão do usuario logado
		$data['statuses'] = array(
			'0'=>'Aguardando Pgto.',
			'1'=>'Pago',
			'2'=>'Cancelado'
		);

		if($u->hasPermission('report_view')) {
			$user_name = addslashes($_GET['user_name']);
			$period1 = addslashes($_GET['period1']);
			$period2 = addslashes($_GET['period2']);
			$status = addslashes($_GET['status']);
			$order = addslashes($_GET['order']);
			$i = new Inventory();
			$p = new Purchases();
			
			$data['purchases_list'] = $p->getPurchasesFiltered($user_name, $period1, $period2, $status, $order, $u->getCompany());

			$data['filters'] = $_GET;

			//$this->loadLibrary('mpdf-development/mpdf');

            ob_start();
            $this->loadView("report_purchases_pdf", $data);
            $html = ob_get_contents();
            ob_end_clean();

            $mpdf = new \Mpdf\Mpdf();
            $mpdf->WriteHTML($html);
            $mpdf->Output('arquivo.pdf', 'I');

			$this->loadView("report_purchases_pdf", $data);
		} else {
			header("Location: ".BASE_URL);
		}
  }

    public function inventory() {
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

		if($u->hasPermission('report_view')) {
			
			$this->loadTemplate("report_inventory", $data);
		} else {
			header("Location: ".BASE_URL);
		}
    }

    public function inventory_pdf() {
    	$data = array();
    	$u = new Users();
		$u->setLoggedUser();//Pega a sessão do usuario logado

		if($u->hasPermission('report_view')) {
			$i = new Inventory();
			$data['inventory_list'] = $i->getInventoryFiltered($u->getCompany());

			$data['filters'] = $_GET;

			//$this->loadLibrary('mpdf-development/mpdf');

            ob_start();
            $this->loadView("report_inventory_pdf", $data);
            $html = ob_get_contents();
            ob_end_clean();

            $mpdf = new \Mpdf\Mpdf();
            $mpdf->WriteHTML($html);
            $mpdf->Output('arquivo.pdf', 'I');
            // I = abra no browser
            // D = faz o download
            // F = Salva no servidor
            //$link = 'http://localhost/contazul/arquivo.pdf';
            //echo "Faça o download no link:<br/>".$link;
		} else {
			header("Location: ".BASE_URL);
		}
    }
}