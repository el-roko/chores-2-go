<?php
session_start();
  

require_once "../classes/Client.php";


if(isset($_POST["btnimg"])){


    $fname = $_FILES["image"]["name"];
    $filetmp = $_FILES["image"]["tmp_name"];
    $ferror = $_FILES["image"]["error"];
    $fsize = $_FILES["image"]["size"];

    if($ferror != 0){
        $err_msg = urlencode("Please upload a real file");
        header("location:../client_profile.php?error=$err_msg");
        exit;
    }

    if($fsize > (1024 * 1024 * 2)){
         $err_msg = urlencode("Your file is too large, maximum size is 2mb");
        header("location:../client_profile.php?error=$err_msg");
        exit;
    }
   
    $accepted = ["jpg","jpeg","png"]; 
    $user_ext = strtolower(pathinfo($fname,PATHINFO_EXTENSION));
    $user_ext = strtolower($user_ext);
    if(!in_array($user_ext,$accepted)){
         $err_msg = urlencode("Wrong file type, Upload image with extension png, jpg or jpeg");
        header("location:../client_profile.php?error=$err_msg");
        exit;
    }

        
   
    $unique_filename = uniqid("client_").time()."_".$fname ;
    
    
   $res =  move_uploaded_file($filetmp,"../uploads/$unique_filename");
   if($res == true){
 
         $c = new Client;
         $post_inserted = $c->update_image($unique_filename,$_SESSION["useronline"]);
        if($post_inserted == true){
           $_SESSION["feedback"] = "Image updated successfully";
            header("location:../edit_clientprofile.php");
            exit;
    }
    
   }else{
    $_SESSION["errormsg"] = " Update failed try again";
     header("location:../edit_keeperprofile.php");
     exit;
   }
//    var_dump($res);
}
else{
    header("location:../client_profile.php");
    exit;
}



?>