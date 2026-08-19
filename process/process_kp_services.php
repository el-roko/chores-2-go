<?php
session_start();
    require_once "../classes/Keeper.php";

    $k = new Keeper;

   

        if(isset($_POST["btn"])){
             $category = $_POST["services"];
            $plan = $_POST["plan"];
            $id = $_SESSION["useronline"];
                    if(!empty($category)){
                        $succes = "success";
                            foreach($category as $cateid){
                                 $ser = $k->insert_kp_services($cateid,$plan,$_SESSION["useronline"]);
                                        if($ser === "duplicate"){
                                           $success = "duplicate";
                                           break;
                                        }elseif($ser === "fail"){
                                            $success = "fail";
                                            break;
                                        }
                            }

                                    if($succes == "success"){
                                        $_SESSION["feedback"] = "Successful";
                                            header("location:../keeper_profile.php");
                                            exit;
                                    }elseif($sucess == "duplicate"){
                                        $_SESSION["errormsg"] = "service already exist for user";
                                            header("location:../keeper_profile.php");
                                            exit;
                                    }else{
                                        $_SESSION["errormsg"] = "Oops... failed";
                                            header("location:../kp_services.php");
                                            exit;
                                    }
                            
                                             
                                        

                             

        
                        
                    }
                    $selected = $category;

           
               
        }else{
            header("location:../kp_services.php");
            exit;
        }







?>