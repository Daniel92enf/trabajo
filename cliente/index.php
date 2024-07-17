<?php
    require_once "Rutas.php";
    $rutas = new Rutas();   
    $registros = json_decode(file_get_contents($rutas->dameUrlBase().'/servidor/index.php?action=tareas'), true);// aquí se decodifica o lee la respuesta archivo json   
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title></title>
</head>
<body>
<?php echo
    $rutas->dameMenuInicio()."&nbsp;&nbsp;&nbsp;&nbsp;".$rutas->dameMenuNuevo();
?>
<br>
<table border="1">
<thead>
<tr>
<th>ID</th>
<th>TÍTULO</th>
<th>DESCRIPCIÓN</th>
<th>PRIORIDAD</th>
<th>OPCIONES</th>
</tr>
</thead>
<tbody>
<?php
    foreach ($registros as $registro) {
        echo "<tr>";
        echo "<td>".$registro['id']."</td>";
        echo "<td>".$registro['titulo']."</td>";
        echo "<td>".$registro['descripcion']."</td>";
        echo "<td>".$registro['prioridad']."</td>";
        echo "<td>".$rutas->dameMenuModificar($registro['id'])."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$rutas->dameMenuEliminar($registro['id'])."</td>";
        echo "</tr>";
    }
?>
</tbody>
</table>
</body>
</html>