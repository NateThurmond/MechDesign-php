<?php 
    
    session_start();
    
    if ( isset($_SESSION["myusername"]) ) {
        
        echo $_SESSION["myusername"];
    }
    else {
        echo 'N/A';
    }
    