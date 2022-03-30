<?php
    session_start();
    include_once "connection.php";

    $uid=$_POST['cid'];
    $pid=$_POST['pid'];
    function createBookmarkTable(){
        global $conn;
        $createTable="CREATE TABLE IF NOT EXISTS Bookmarks(

            bid INT PRIMARY KEY AUTO_INCREMENT,
            uid INT,
            CONSTRAINT book_fk
            FOREIGN KEY(uid) REFERENCES Users(uid),
            pid INT NOT NULL
                );";
    
        $status=mysqli_query($conn,$createTable);
        if($status){
            return true;
        }
        else{
            return false;
        }
    }
    function isExists($uid,$pid){
        global $conn;
        $query="SELECT * FROM Bookmarks where uid='$uid' AND pid='$pid';";
        $result=mysqli_query($conn,$query);
        if($result){
            $data=mysqli_fetch_all($result);
            return count($data)>0;
        }
        else{
            return false;
        }
    }
    function insertFieldInBookMark($uid,$pid){
        global $conn;
        $q="INSERT INTO Bookmarks(uid,pid) VALUES('$uid','$pid')";
        $status=mysqli_query($conn,$q);
        if($status){
            return true;
        }
        else{
            return false;
        }
    }
    if($_SESSION['currentUser'][0]==$uid){
        if(createBookmarkTable()){
            if(!isExists($uid,$pid)){
                if(insertFieldInBookMark($uid,$pid)){
                    echo "Done";
                }
                else{
                    echo "Error";   
                }
            }
        }
        else{
            echo "Done";
        }
    }

?>