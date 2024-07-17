<?php
    require_once "Rutas.php";
    $rutas = new Rutas();
    $id = $_GET['id'];
    $registro = json_decode(file_get_contents($url =
    $rutas->dameUrlBase().'/servidor/tareas/'.$id), true);
    if(isset($_POST['titulo'])) {
        $url = $rutas->dameUrlBase().'/servidor/tareas/'.$id;
        $data = array('titulo' => $_POST['titulo'], 'descripcion' => $_POST['descripcion'], 'prioridad' => $_POST['prioridad']);
        $postdata = json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
        array('Content-Type: application/json'));
        $result = curl_exec($ch);
        curl_close($ch);
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
<?php if(!isset($_POST['titulo'])) {
echo '<form action="" method="post" id="form1">
<label for="titulo">Título:</label><br>
<input type="text" id="titulo" name="titulo"
value="'.$registro[0]['titulo'].'"><br>
<label for="descripcion">Descripción:</label><br>
<input type="text" id="descripcion" name="descripcion"
value="'.$registro[0]['descripcion'].'"><br>
<label for="prioridad">Prioridad:</label><br>
<select name="prioridad" id="prioridad"
value="'.$registro[0]['prioridad'].'">
<option value="1">1</option>
<option value="2" selected>2</option>
<option value="3">3</option>
</select>
<br>
<button type="submit" form="form1"
value="Submit">Guardar</button>
</form>';
} else {
echo "Registro modificado";
}
?>
</body>
</html>