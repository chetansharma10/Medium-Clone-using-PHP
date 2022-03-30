<?php
    session_start();
    if($_SESSION['isAuth']){
        $val=urlencode($_POST['postId']);

        echo "postView.php/?value=".$val;
    }
    else{
        echo "/signIn.php";
    }
?>
