 <?php
          if(isset($_SESSION["errormsg"])){
            echo "<div class='alert alert-danger text-center'>".$_SESSION['errormsg']."</div>";
            unset($_SESSION["errormsg"]);
          }
          if(isset($_SESSION["feedback"])){
            echo "<div class='alert alert-success text-center'>".$_SESSION['feedback']."</div>";
            unset($_SESSION["feedback"]);
          }
        ?>