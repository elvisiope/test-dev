<?php
if(!isset($_POST['consulta'])){
    exit();
}

if(isset($_POST['id']) && !empty($_POST['id'])){
    $fileName = "../lib/bd/bd.txt";
    $val = "";
    $bd = fopen($fileName, "r");

    $return = fread($bd, filesize($fileName));

    $result = json_decode($return);
    
    foreach ($result as $key => $value) {
       if($key == $_POST["id"]){
           $val = array(
                "id" => $key,
                "nome" => $value->nome,
                "marca" => $value->marca,
                "modelo" => $value->modelo,
                "ano" => $value->ano
            );
            break;
       } 
    }
    
    fclose($bd);
    die(json_encode($val));  
}


$fileName = "../lib/bd/bd.txt";
$val = "";
$bd = fopen($fileName, "r");

$return = fread($bd, filesize($fileName));

$result = json_decode($return);
if(is_array($result)){
    foreach ($result as $key => $value) {
        $val .= sprintf('<tr>');
        $val .= sprintf('  <td>%s</td>',$key);
        $val .= sprintf('  <td>%s</td>',$value->nome);
        $val .= sprintf('  <td>%s</td>',$value->marca);
        $val .= sprintf('  <td>%s</td>',$value->modelo);
        $val .= sprintf('  <td>%s</td>',$value->ano);
        $val .= sprintf('  <td style="text-align: right;">');
        $val .= sprintf('      <button class="btn btn-success edit-carro" attrEdit="%s"><span class="glyphicon glyphicon-pencil"></span></button>',$key);
        $val .= sprintf('      <button class="btn btn-danger delete-carro" attrDelete="%s"><span class="glyphicon glyphicon-remove"></span></button>',$key);
        $val .= sprintf('  </td>');
        $val .= sprintf('<tr>');   
    }    
}
fclose($bd);
echo json_encode($val);

?>