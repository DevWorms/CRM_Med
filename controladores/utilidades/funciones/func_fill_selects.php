<?php 
	require_once dirname(__FILE__) . '/../../datos/ConexionBD.php';

	function fillSelect($table,$value,$text){
		$pdo = ConexionBD::obtenerInstancia()->obtenerBD();
		$query = "SELECT * FROM " . $table;
		$stm= $pdo->prepare($query);
        $stm->execute();
        $resultados = $stm->fetchAll();
        echo "<option value='0'>Seleccione</option>";
		foreach($resultados as $row){
			echo "<option value='".$row[$value]."'>" . $row[$text] . "</option>";
		}
	}	

?>