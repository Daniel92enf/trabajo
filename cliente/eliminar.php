<?php
    require_once "Rutas.php";

    $rutas = new Rutas();
    $id = $_GET['id'];
    $url = $rutas->dameUrlBase()."/servidor/tareas/".$id;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    $resultado = "No fue posible eliminar el registro";
    if($result) {
        $resultado = "Registro eliminado exitosamente";
    }
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title></title>
</head>
<body>
<?php echo
$rutas->dameMenuInicio()."&nbsp;&nbsp;&nbsp;&nbsp;".$rutas
->dameMenuNuevo(); ?>
<br>
<?php echo $resultado; ?>
</body>
</html>