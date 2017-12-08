<?php
if(isset($_POST['id'])){
    try {
        $fileName = "../lib/bd/bd.txt";
        $bd = fopen($fileName, "r");

        $return = fread($bd, filesize($fileName));
        fclose($bd);
        $return = json_decode($return);
        if (!is_array($return)) {
            $return = array();
        }
        unset($return[$_POST["id"]]);
        sort($return);
        $return = json_encode($return);
        $bd = fopen($fileName, "w+");
        $err = fwrite($bd, $return);

        $err = ($err === false) ? "ERRO" : "OK";

        fclose($bd);

        die(json_encode(array("MSG" => $err)));
    } catch (Exception $exc) {
        echo json_encode($exc);
    }
}
?>
