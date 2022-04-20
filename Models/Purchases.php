<?php
namespace Models;

use \Core\Model;

class Purchases extends Model {

	public function getList($offset, $id_company) {
		$array = array();
				
		$sql = $this->db->prepare("
			SELECT
				purchases.id,
				purchases.date_purchase,
				purchases.total_price,
				purchases.status,
				users.name,
				inventory.name				
			FROM purchases
			INNER JOIN users ON users.id = purchases.id_user
			INNER JOIN purchases_products ON purchases_products.id_purchase = purchases.id
			INNER JOIN inventory ON inventory.id = purchases_products.id_product
			WHERE
				purchases.id_company = :id_company
			ORDER BY purchases.date_purchase DESC
			LIMIT $offset, 10");
		$sql->bindValue(':id_company', $id_company);
		$sql->execute();
		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll();
		}
		return $array;
	}

	public function changeStatus($status, $id, $id_company) {
		$sql = $this->db->prepare("UPDATE purchases SET status = :status WHERE id = :id AND id_company = :id_company");
		$sql->bindValue(':status', $status);
		$sql->bindValue(':id', $id);
		$sql->bindValue(':id_company', $id_company);
		$sql->execute();
	}

	public function addPurchase($id_company, $id_user, $quant, $status) {
		$i = new Inventory();
		// Adiciona a Compra com preço zerado
		$sql = $this->db->prepare("INSERT INTO purchases SET id_company = :id_company, id_user = :id_user, date_purchase = NOW(), total_price = :total_price, status = :status");
		$sql->bindValue(":id_company", $id_company);		
		$sql->bindValue(":id_user", $id_user);
		$sql->bindValue(":total_price", '0');
		$sql->bindValue(":status", $status);
		$sql->execute();
		
		$id_purchase = $this->db->lastInsertId();

		// Pega os preços dos Produtos
		$total_price = 0;
		foreach($quant as $id_prod => $quant_prod) {
			$sql = $this->db->prepare("SELECT price FROM inventory WHERE id = :id AND id_company = :id_company");
			$sql->bindValue(":id", $id_prod);
			$sql->bindValue(":id_company", $id_company);
			$sql->execute();

			if($sql->rowCount() > 0) {
				$row = $sql->fetch();
				$price = $row['price'];
				// Adiciona os Produtos da Compra
				$sqlp = $this->db->prepare("INSERT INTO purchases_products SET id_company = :id_company, id_purchase = :id_purchase, id_product = :id_product, quant = :quant, purchase_price = :purchase_price");
				$sqlp->bindValue(":id_company", $id_company);
				$sqlp->bindValue(":id_purchase", $id_purchase);
				$sqlp->bindValue(":id_product", $id_prod);
				$sqlp->bindValue(":quant", $quant_prod);
				$sqlp->bindValue(":purchase_price", $price);
				$sqlp->execute();

				// Aumenta quantidade de produtos no histórico
				$i->increase($id_prod, $id_company, $quant_prod, $id_user);

				$total_price += $price * $quant_prod;
			}
		}
		// Substitui na Compra
		$sql = $this->db->prepare("UPDATE purchases SET total_price = :total_price WHERE id = :id");
		$sql->bindValue(":total_price", $total_price);
		$sql->bindValue(":id", $id_purchase);
		$sql->execute();
	}

	public function getInfo($id, $id_company) {
		$array = array();
		
		$sql = $this->db->prepare("
			SELECT
				*,
				( select users.name from users where users.id = purchases.id_user ) as user_name
			FROM purchases
			WHERE
				id = :id AND
				id_company = :id_company");
		$sql->bindValue(":id", $id);
		$sql->bindValue(":id_company", $id_company);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$array['info'] = $sql->fetch();
		}
		/*
		echo '<pre>';
		print_r($array);
		exit;
		*/
		$sql = $this->db->prepare("
			SELECT
				purchases_products.quant,
				purchases_products.purchase_price,
				inventory.name,
				inventory.id
			FROM purchases_products
			LEFT JOIN inventory
				ON inventory.id = purchases_products.id_product
			WHERE 
				purchases_products.id_purchase =:id_purchase AND
				purchases_products.id_company = :id_company");
		$sql->bindValue(":id_purchase", $id);
		$sql->bindValue(":id_company", $id_company);
		$sql->execute();
		/*
		echo '<pre>';
		print_r($sql);
		exit;		
		*/
		if($sql->rowCount() > 0) {
			$array['products'] = $sql->fetchAll();
		}

		return $array;
	}

	public function getCount($id_company) {
		$r = 0;

		$sql = $this->db->prepare("SELECT COUNT(*) as c FROM purchases WHERE id_company = :id_company");
		$sql->bindValue(":id_company", $id_company);
		$sql->execute();
		$row = $sql->fetch();

		$r = $row['c'];

		return $r;
	}

	public function getPurchasesFiltered($user_name, $period1, $period2, $status, $order, $id_company) {
		$array = array();

		$sql = "SELECT
		inventory.name,
		purchases.date_purchase,
		purchases.status,
		purchases.total_price
		FROM purchases
		INNER JOIN purchases_products ON purchases_products.id_purchase = purchases.id
		INNER JOIN inventory ON inventory.id = purchases_products.id_product
		WHERE ";

		$where = array();
		$where[] = "purchases.id_company = :id_company";

		if(!empty($user_name)) {
			$where[] = "inventory.name LIKE '%".$user_name."%'";
		}

		if(!empty($period1) && !empty($period2)) {
			$where[] = "purchases.date_purchase BETWEEN :period1 AND :period2";
		}

		if($status != '') {
			$where[] = "purchases.status = :status";
		}
		
		$sql .= implode(' AND ', $where);

		switch($order) {
			case 'date_desc':
			default:
				$sql .= " ORDER BY purchases.date_purchase DESC";
				break;
			case 'date_asc':
				$sql .= " ORDER BY purchases.date_purchase ASC";
				break;
			case 'status':
				$sql .= " ORDER BY purchases.status";
				break;
		}
		/*echo $sql;
		exit;*/
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":id_company", $id_company);
		
		if(!empty($period1) && !empty($period2)) {
			$sql->bindValue(":period1", $period1);
			$sql->bindValue(":period2", $period2);
		}

		if($status != '') {
			$sql->bindValue(":status", $status);
		}
		
		$sql->execute();

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll();
		}		
		return $array;
	}
}