<?php 
    include "connection.php";
    session_start();

    $data=$_POST['value'];
    $id=$_SESSION['currentUser'][0];


    function updateStatus($data,$id){
        global $conn;
        $query="UPDATE Users SET status='$data' WHERE uid='$id';";
        $result=mysqli_query($conn,$query);
        if($result){
            return true;
        }
        else{
            return false;
        }
    }

    if(updateStatus($data,$id)){
        echo true;
    }
    else{
        echo false;
    }




?>