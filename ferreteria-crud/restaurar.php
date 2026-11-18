<?php
require_once __DIR__.'/config/conexion.php';
$tablas=['clientes','proveedores','articulos','facturas'];
$tabla=$_POST['tabla']??'';$id=(int)($_POST['id']??0);
if(!in_array($tabla,$tablas,true)||$id<1){http_response_code(400);exit('Solicitud inválida.');}
try{
 $q=$pdo->prepare("UPDATE $tabla SET eliminado_en=NULL WHERE id=? AND eliminado_en IS NOT NULL");
 $q->execute([$id]);
 if($q->rowCount()){
  $log=$pdo->prepare("INSERT INTO movimientos(tipo,tabla_afectada,registro_id,descripcion) VALUES('Restauración',?,?,?)");
  $log->execute([$tabla,$id,"Se restauró un registro de $tabla"]);
 }
 header('Location: papelera.php?restaurado=1');exit;
}catch(PDOException $e){header('Location: papelera.php?error=1');exit;}
