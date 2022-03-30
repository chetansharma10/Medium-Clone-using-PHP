<?php
    $server_name="localhost";
    $username="root";
    $password="";

    $conn=mysqli_connect($server_name,$username,$password);


    if(!$conn){
        echo "Connection Problem ".mysqli_connect_error();
    }
    else{

        // Create Database Only Once
        $query="CREATE DATABASE IF NOT EXISTS Medium";
        if (mysqli_query($conn, $query)) {
            // echo "Database Created";

            $sql = "
                USE  Medium;
                ";
            if(mysqli_query($conn,$sql)){
                // echo "Database Selected";


            }
            else{
                // echo "Database Error";
            }
                
               
        } else {
            // echo "Problem in Database";
        }

    }
    
    function checkDatabaseExists(){
        global $conn;
        if (mysqli_select_db($conn, 'Medium')) {
           return true;
        } else {
           return false;
        }
    }

?>