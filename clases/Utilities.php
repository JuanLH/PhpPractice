<?php
class Utilities{
	public static function getConnection(){
		include "DbPDO.php";
		$db = new DbPDO("sqlsrv", "localhost", "1433", "luis", "root", "valoracion_online");
		return $db;
	}
}
?>