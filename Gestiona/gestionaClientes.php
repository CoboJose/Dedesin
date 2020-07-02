<?php
function consultaCliente($conexion, $dni_cif){
	
$consulta = "SELECT * FROM Clientes where DNI_CIF = :dni_cif";
$stmt = $conexion->prepare($consulta);
$stmt -> bindParam(':dni_cif',$dni_cif);
$stmt -> execute();
return $stmt -> fetch();
}
    
?>