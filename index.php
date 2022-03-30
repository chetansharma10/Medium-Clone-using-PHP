<?php 
    session_start();
    if($_SESSION['currentUser'][5]==NULL){
        $_SESSION['currentUser'][5]='./assets/defaultAcc.png';
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medium-Where Good Ideas Find You</title>
    <link rel="stylesheet" href="./css/index.css">
  
    <style>
        .logOut{
            background-color: transparent;
            border:none;
            outline: none;
            font-size: 15px;
            margin: 5px;
            cursor: pointer;
        }
        #avatar:hover{
            opacity:0.8;
            transition:0.5s ease;
        }

        .postAuthorImg{
            border-radius: 100%;
            border:0.1px solid lightgray;
        }

        #postImgx{
            object-fit: cover;
            object-position: center;
            width:100%;
            height:100%;

        }
       

        #authorPic{
            border-radius: 100%;
            border:0.1px solid lightgray;
        }

    </style>
</head>
<body>
    <div class="main">
        <!-- Navbar -->
        <?php
            include_once "nav.php";
        ?>
        <!-- Extra -->
        <div class="extra">
            <div class="info">
                <h1>Medium is a place<br>to write,read,and<br>connect</h1>
                <p>It's easy and free to post your thinking on any topic and <br>connect with millions of readers.</p>
                <a href="" class="startWriting">Start Writing</a>
            </div>
        </div>

        <!-- Trending -->
       
        <div class="trending">
            <div class="trendHead">
                <div class="trendLogo">
                    <svg width="28" height="29" viewBox="0 0 28 29" fill="none" class="ip y"><path fill="#fff" d="M0 .8h28v28H0z"></path><g opacity="0.8" clip-path="url(#trending_svg__clip0)"><path fill="#fff" d="M4 4.8h20v20H4z"></path><circle cx="14" cy="14.79" r="9.5" stroke="#000"></circle><path d="M5.46 18.36l4.47-4.48M9.97 13.87l3.67 3.66M13.67 17.53l5.1-5.09M16.62 11.6h3M19.62 11.6v3" stroke="#000" stroke-linecap="round"></path></g><defs><clipPath id="trending_svg__clip0"><path fill="#fff" transform="translate(4 4.8)" d="M0 0h20v20H0z"></path></clipPath></defs></svg>
                </div>
                <p>Trending on Medium</p>
            </div>

            <div class="trendContainer">
                <!-- Trend Item -->
                <?php
                    $trendingPosts=[];
                    $trendingPostsData=[];
                    function whosPostIs($uid){
                        global $conn;
                        $query="SELECT firstName,userPic FROM Users where uid='$uid';";
                        $result=mysqli_query($conn,$query);
                        if($result){

                            $x=mysqli_fetch_row($result);
                            return $x;
                        }
                        else{
                            return -1;
                        }
                    }
            
                    function readAllPosts(){
                        global $conn;
                        global $trendingPosts;
                        $query="SELECT * FROM Posts LIMIT 3;";
                        $result=mysqli_query($conn,$query);
                        if($result){

                            $trendingPosts=mysqli_fetch_all($result);
                            return true;
                        }
                        else{
                            return false;
                        }
                    }

                    if(readAllPosts()){
                    foreach($trendingPosts as $key=>$value){
                        $date=date("F ,j",strtotime($value[3]));
                        $postName=$value[1];
                        echo '
                        <div class="trendItem" id="'.$value[0].'">
                            <div class="content">
                                <div class="leftNum">
                                    <p>0'.($key+1).'</p>
                                </div>

                                <div class="rightNum">
                                    <div class="author">
                                        <img id="authorPic" src="'.whosPostIs($value[0])[1].'" width="20" height="20">
                                        <p>'.whosPostIs($value[0])[0].'</p>
                                    </div>
                                    <p class="ptname">'.$postName.'</p>
                                    <p class="ptdate">'.$date.'</p>
                                </div>

                            </div>
                        </div>
                        ';
                   
                    }

                    }


                 ?>
                

               



                
            </div>
         
        </div>
        <!-- Footer -->
        <div class="footer">
            <div class="footerLeft">

               <!-- Php Code -->
               <?php

                    function getPostImg($postId){
                        global $conn;
                        $query="SELECT imgUrl FROM Images where postId='$postId';";
                        $result=mysqli_query($conn,$query);
                        if($result){
    
                            $x=mysqli_fetch_row($result);
                            return $x;
                        }
                        else{
                            return -1;
                        }
                    }

                    function whoAddPost($uid){
                        global $conn;
                        $query="SELECT firstName,userPic FROM Users where uid='$uid';";
                        $result=mysqli_query($conn,$query);
                        if($result){
    
                            $x=mysqli_fetch_row($result);
                            return $x;
                        }
                        else{
                            return -1;
                        }
                    }

                    if(strlen($_SESSION['currentUser'][1])>0){
                        //Auth
                        $query="SELECT * FROM Posts;";

                    }
                    else{
                        //Not Auth
                        $query="SELECT * FROM Posts LIMIT 3;";



                    }
                    $result=mysqli_query($conn,$query);
                    if($result){

                        $data=mysqli_fetch_all($result);
                        foreach($data as $key=>$value){
                            $postId=$value[0];
                            $postImg=getPostImg($postId)[0];
                            if($postImg!=-1){
                                $heading=strVal($value[1]);
                                $desc=strVal($value[2]);
                                $created_on=strVal($value[3]);
                                $likes=$value[4];
                                $who=whoAddPost($value[5])[0];
                                $whoImg=whoAddPost($value[5])[1];

                                $date=date("F ,j, Y",strtotime($created_on));
                                
                              

                          

                                echo
                                '
                                <div class="postItem"  id="'.$postId.'">
                                    <div class="leftPost">
                                        <div class="postAuthor">
                                            <img class="postAuthorImg" src="'.$whoImg. '" width="20" height="20">
                                            <p class="postAuthorName">'.$who.'</p>
                                        </div>
                                        <p class="postTitle">'.$heading.'</p>
                                        <p class="postContent">'.substr($desc,0,50).'...'.'</p>
                                        <p class="postCreatedOn">'.$date.'</p>
                                    </div>
                                    <div class="rightPost">
                                        <img src="'.$postImg.'" id="postImgx" >
                                    </div>
                                </div>  

                           

                                ';
                            }
                        }
                    }
                    else{
                        echo "Something Went Wrong";
                    }


                ?>

               
            </div>
            <div class="footerRight">
                <p>DISCOVER MORE OF WHAT MATTERS TO YOU</p>
                <div class="tags">
                    <a href="" class="tagItem">Self</a>
                    <a href="" class="tagItem">Dogs</a>
                    <a href="" class="tagItem">Relationships</a>
                    <a href="" class="tagItem">Friendship</a>
                    <a href="" class="tagItem">Nature</a>
                    <a href="" class="tagItem">Ukarine</a>

                </div>
            </div>
            <script >
                 
                const elements = document.querySelectorAll('.postItem');

                // adding the event listener by looping
                elements.forEach(element => {
                    element.addEventListener('click', (e)=>{
                        console.log(element.getAttribute("id"));
                        var xhr=new XMLHttpRequest();
                        xhr.open("POST","/MediumClone/middleware.php",true);  
                        var formData=new FormData();
                        formData.append("postId",element.getAttribute("id"));
                        xhr.send(formData);
                        xhr.onreadystatechange = function(){
                            if(xhr.readyState == 4 && xhr.status == 200)
                            {
                                // some code ...
                                window.location.pathname="/MediumClone/"+xhr.response
                            }
                        }
                    });
                });







                const elements2 = document.querySelectorAll('.trendItem');

                // adding the event listener by looping
                elements2.forEach(element => {
                    element.addEventListener('click', (e)=>{
                        console.log(element.getAttribute("id"));
                        var xhr=new XMLHttpRequest();
                        xhr.open("POST","/MediumClone/middleware.php",true);  
                        var formData=new FormData();
                        formData.append("postId",element.getAttribute("id"));
                        xhr.send(formData);
                        xhr.onreadystatechange = function(){
                            if(xhr.readyState == 4 && xhr.status == 200)
                            {
                                // some code ...
                                window.location.pathname="/MediumClone/"+xhr.response
                            }
                        }
                    });
                });
                             
            </script>
        </div>

    </div>
    <script src="./js/index.js"></script>

</body>
</html>