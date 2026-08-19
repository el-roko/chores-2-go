<?php
session_start();
require_once "../classes/Service.php";

$s = new Service;

// select_service.php;

if(isset($_POST["btn"])){
    $categoryid = $_POST["cate"];
    $planid = $_POST["plan"];

        if(!empty($categoryid) && !empty($planid)){
             $_SESSION["cate_id"] = $categoryid;
             $_SESSION["plan_id"] =  $planid;
            $keepers = $s->fetch_keeper_by_service($categoryid, $planid);

            $_SESSION["keeper"] = $keepers;
            header("location:../select_keeper.php");
            exit;
                // if ($result && count($result) > 0) {
                //     echo "<h3>Keepers found:</h3>";
                //     echo "<ul>";z
                //     foreach ($result as $row) { 

                     
                //         echo "<li>" . $row['keeper_fname'] . ' '. $row["keeper_lname"]; "</li>";
                //         echo "<li>". $row["keeper_gender"]; "</li>";
                //         echo '<img src="uploads/$row["kp_image"]" alt="">';
                //     }
                //     echo "</ul>";
                // } else {
                //     echo "<p>No keepers found for this category and plan.</p>";
                // }
        } //end of !empty

}else{
    header("location:../search_booking.php");
    exit;
}








?>