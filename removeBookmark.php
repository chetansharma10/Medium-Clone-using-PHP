<?php   
    session_start();
    include_once "connection.php";
    $postId=$_POST['postId'];
    $currId=$_POST['currId'];

    echo $currId.$postId;
    function removeRecord($currId,$postId){
        global $conn;
        $query="DELETE FROM Bookmarks where uid='$currId' AND pid='$postId';";
        $result=mysqli_query($conn,$query);
        if($result){
            return true;
        }
        else{
            return false;
        }
    }

    if(removeRecord($currId,$postId)){
        echo "Done";
    }
    else{
        echo "Not Done";
    }


?>