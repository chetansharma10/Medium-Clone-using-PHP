<?php
    session_start();
    include_once "connection.php";
    $fid=$_POST['followID'];
    $uid=$_POST['userID'];

    function validateIDS($uid){
        global $conn;
        $query="SELECT * FROM Users where uid='$uid';";
        $result=mysqli_query($conn,$query);
        if($result){
            $data=mysqli_fetch_all($result);
            return count($data);
        }
        else{
            return -1;
        }
    }
    function validateALL($uid,$fid){
        if($_SESSION['currentUser'][0]==$uid){
            return validateIDS($uid)==validateIDS($fid);

        }
        return false;
        
    }


    function checkAlreadyExists($fid,$uid){
        global $conn;
        $query="SELECT * FROM Followers where userID='$uid' AND friID='$fid';";
        $result=mysqli_query($conn,$query);
        if($result){
            $data=mysqli_fetch_all($result);
            return count($data)>0;
        }
        else{
            return false;
        }
    }
   function addInFollowers($uid,$fid){
        global $conn;
        $query="INSERT INTO Followers(userID,friID) VALUES($uid,$fid);";
        $result=mysqli_query($conn,$query);
        if($result){
           
            return true;
        }
        else{
            return false;
        }
   }


   function removeInFollowers($uid,$fid){
        global $conn;
        $query="DELETE FROM Followers WHERE userID='$uid' AND friID='$fid';";
        $result=mysqli_query($conn,$query);
        if($result){
        
            return true;
        }
        else{
            return false;
        }
    }

  
        if(validateALL($uid,$fid)){
            if(!checkAlreadyExists($fid,$uid)){
                 echo addInFollowers($uid,$fid)."Added";
            }
            else{
                 echo removeInFollowers($uid,$fid)."Removed";
            }
        }
    


?>