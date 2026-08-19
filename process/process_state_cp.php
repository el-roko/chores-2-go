<?php
require_once "../classes/Client.php";
$c = new Client;

if(!empty($_POST["state_id"])){
    $stateId = intval($_POST["state_id"]);
    $savedLgaId = isset($_POST["saved_lga"]) ? intval($_POST["saved_lga"]) : null;
    $lgas = $c->fetch_lga_by_state($stateId);

    if($lgas){
        foreach($lgas as $l){
            $selected = ($savedLgaId === intval($l["lga_id"])) ? " selected" : "";
            echo "<option value=\"{$l["lga_id"]}\"{$selected}>{$l["lga_name"]}</option>";
        }
    } else {
        echo '<option value="">No LGAs available</option>';
    }
} else {
    header("location:../edit_clientprofile.php");
    exit;
}

?>