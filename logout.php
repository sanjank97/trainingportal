<?php 
   session_start();
   
    if(isset($_SESSION["employee"]))
    {
        session_destroy();
        header("Location:index.php");
    }
    else
    {
        header("Location:index.php");  
    }
   


?>
 <script>
     window.localStorage.clear();
 </script>
  