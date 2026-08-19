<?php
session_start();
  

require_once "../classes/Keeper.php";


if(isset($_POST["btnimg"])){


    $fname = $_FILES["image"]["name"];
    $filetmp = $_FILES["image"]["tmp_name"];
    $ferror = $_FILES["image"]["error"];
    $fsize = $_FILES["image"]["size"];

    if($ferror != 0){
        $_SESSION["errormsg"] = "Please upload a real file";
        header("location:../keeper_profile.php");
        exit;
    }

    if($fsize > (1024 * 1024 * 2)){
         $_SESSION["errormsg"] = "Your file is to large, maximum size is 2mb";
        header("location:../keeper_profile.php");
        exit;
    }
   
    $accepted = ["jpg","jpeg","png"]; 
    $user_ext = strtolower(pathinfo($fname,PATHINFO_EXTENSION));
    $user_ext = strtolower($user_ext);
    if(!in_array($user_ext,$accepted)){
         $_SESSION["errormsg"] = "Wrong file type, Upload image with extension png, jpg or jpeg";
        header("location:../keeper_profile.php");
        exit;
    }

        
   
    $unique_filename = uniqid("keeper_").time()."_".$fname ;
    
    
   $res =  move_uploaded_file($filetmp,"../uploads/$unique_filename");
   if($res == true){
 
         $k = new Keeper;
         $post_inserted = $k->update_image($unique_filename,$_SESSION["useronline"]);
        if($post_inserted == true){
            $_SESSION["feedback"] = "Image updated successfully";
            header("location:../edit_keeperprofile.php");
            exit;
    }
    
   }else{
    $_SESSION["errormsg"] = " Update failed try again";
     header("location:../edit_keeperprofile.php");
     exit;
   }
   //var_dump($res);
}
else{
    header("location:../keeper_profile.php");
    exit;
}



?>