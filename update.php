<?php
    session_start();
    include_once "connection.php";
    
    $postId=$_POST['pid'];

    function readPrevLikes($postId){
        global $conn;
    
        $query="SELECT likes FROM Posts WHERE postId='$postId';";
        $result=mysqli_query($conn,$query);
        if($result){
            $data=mysqli_fetch_row($result)[0];
            return $data;
        }
        else{
            return -1;
        }

    }
    function updateLikes($postId,$prevLikes){
        global $conn;
        $prevLikes=$prevLikes+1;
        $query="UPDATE Posts SET likes='$prevLikes' WHERE postId='$postId'";
        $result=mysqli_query($conn,$query);
        if($result){
            
            return true;
        }
        else{
            return false;
        }
    }

    $prevLikes=(int)readPrevLikes($postId);
    if($_SESSION['postId']!=$postId){
        if(updateLikes($postId,$prevLikes)){
            $newLike=readPrevLikes($postId);
            $_SESSION['postId']=$postId;
            echo $newLike;
        }
        else{
            echo $prevLikes;
        }
    }
    else{
        echo $prevLikes;
    }




?>