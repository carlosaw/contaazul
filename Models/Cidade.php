<?php

namespace Models;

use \Core\Model;
class Cidade extends Model {

	public function getStates() {
		$array = array();

		$sql = "SELECT Uf FROM cidade GROUP BY Uf";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll();
		}

		return $array;
	}

	public function getCityList($state) {
		$array = array();

		$sql = "SELECT Nome, CodigoMunicipio FROM cidade WHERE Uf = :Uf";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":Uf", $state);
		$sql->execute();
		
		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll();
		}

		return $array;
	}

	public function getCity($city_code) {
		$sql = "SELECT Nome FROM cidade WHERE CodigoMunicipio = :codigo";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":codigo", $city_code);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$sql = $sql->fetch();
			return $sql['Nome'];
		}
	}

}