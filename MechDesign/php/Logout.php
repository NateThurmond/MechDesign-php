
<?php 
    session_start();
    session_destroy();
    
    unset($_SESSION['myusername']);
    
    header("location:../index.php?wrongPass=2");
