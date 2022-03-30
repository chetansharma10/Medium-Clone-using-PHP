<?php
    session_start();
    $value="";
    if(!$_SESSION['isAuth']){
        header("Location:http://localhost/MediumClone/signIn.php");
        die();
    }
    else{
        $x= urldecode($_SERVER['REQUEST_URI']);
        $res=strpos($x,"=");
        $value= substr($x,$res+1);
    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medium Post</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <?php
        $linkCss="http://".$_SERVER['HTTP_HOST']."/MediumClone/"."css/postView.css";
        echo '<link rel="stylesheet" href="'.$linkCss.'">';
    ?>

    <?php
        $linkCss="http://".$_SERVER['HTTP_HOST']."/MediumClone/"."css/dialogData.css";
        echo '<link rel="stylesheet" href="'.$linkCss.'">';
    ?>
</head>
<body>
      <div class="main2">
            <div class="sideBar2">
                <div class="sideLogo">
                    <svg viewBox="0 0 1043.63 592.71" class="bu bk"><g data-name="Layer 2"><g data-name="Layer 1"><path d="M588.67 296.36c0 163.67-131.78 296.35-294.33 296.35S0 460 0 296.36 131.78 0 294.34 0s294.33 132.69 294.33 296.36M911.56 296.36c0 154.06-65.89 279-147.17 279s-147.17-124.94-147.17-279 65.88-279 147.16-279 147.17 124.9 147.17 279M1043.63 296.36c0 138-23.17 249.94-51.76 249.94s-51.75-111.91-51.75-249.94 23.17-249.94 51.75-249.94 51.76 111.9 51.76 249.94"></path></g></g></svg>
                </div>

                <div class="links">
                 
                    <?php  
                        $homeUrl="http://".$_SERVER['HTTP_HOST']."/MediumClone/index.php";;
                        echo '<a href="'.$homeUrl.'">
                            <i class="material-icons">home</i> 
                        </a>';


                        $writeUrl="http://".$_SERVER['HTTP_HOST']."/MediumClone/write.php";
                        echo '
                        <a href="'.$writeUrl.'">
                            <i class="material-icons">edit</i>  
                        </a>  ';    

                        
                        
                        
                        
                    ?>

                    <?php
                        $imgUrl="http://".$_SERVER['HTTP_HOST']."/MediumClone/".$_SESSION['currentUser'][5];
                        echo '<button id="show">'.'<img src=" '.$imgUrl.' " >'.'</button>';
                    ?>


                </div>



            </div>
            <div class="contentBar">
                <div class="contentTop">
                    <?php
                        include_once "connection.php";
                        $postDetails=[];
                        $userDetails=[];
                        $postImages=[];
                        function getUser($postUsrUid){
                            global $conn;
                            global $userDetails;
                            $query="SELECT firstName,lastName,userPic from Users where uid='$postUsrUid'; ";
                            $result=mysqli_query($conn,$query);
                            if($result){
                                $data=mysqli_fetch_row($result);
                                $userDetails=$data;

                            }
                            else{
                                echo "not Ok";
                            }
                        }
                        function getImages($value){
                            global $conn;
                            global $postImages;
                            $query="SELECT imgUrl from Images where postId='$value'; ";
                            $result=mysqli_query($conn,$query);
                            if($result){
                                $data=mysqli_fetch_all($result);
                                $postImages=$data;

                            }
                            else{
                                echo "not Ok";
                            }
                        }

                    

                        function getPostDetails($postId){
                            global $conn;
                            global $postDetails;
                            $query="SELECT * from Posts where postId='$postId'; ";
                            $result=mysqli_query($conn,$query);
                            if($result){
                                $data=mysqli_fetch_row($result);
                                $postDetails=$data;
                                $postUsrUid=$data[5];
                                
                                getUser($postUsrUid);
                                

                            }
                            else{
                                echo "not Ok";
                            }
                        }

                        getPostDetails($value);
                        getImages($value);
                        

                    ?>

                    <?php
                        $imgUrl="http://".$_SERVER['HTTP_HOST']."/MediumClone/".$userDetails[2];

                        echo '
                        <img src="'.$imgUrl.'" class="whoLogo">
                        <p class="whoAdd">Published in <strong>'.$userDetails[0].' '.$userDetails[1].'</strong></p>
                        
                        '
                    ?>
                  

                
                </div>

                <div class="contentBottom">
                    <div class="contentTopBottom">
                        <div class="leftctb">
                            <?php
                            
                                echo' <img src="'.$imgUrl.'" class="imgctb">'
                            
                            ?>
                        </div>
                        <div class="rightctb">
                            <?php
                                $date=$postDetails[3];
                                $date_new=date("F ,j, Y",strtotime($date));
                                echo' <p class="usrName">'.$userDetails[0].' '.$userDetails[1].'</p>
                                <p class="postDate">'.$date_new.'</p>';
                            
                            ?>
                        </div>
                    </div>
                    <div class="contentData">
                        <div class="images">
                            <?php
                                foreach($postImages as $key=>$value){
                                    $imgUrl="http://".$_SERVER['HTTP_HOST']."/MediumClone/".$value[0];
                                   
                                    echo '<img src="'.$imgUrl.'" class="firstImg">';
                                   
                                }
                            ?>
                        </div>

                        <div class="postData">
                            <?php
                                echo '<h1 class="postHeading">'.$postDetails[1].'</h1>';
                                echo '<p class="postContent">'.$postDetails[2].'</p>';

                            ?>
                        </div>

                        <div class="likes">
                            <?php 
                            echo '
                            <button class="addLike" id="'.$postDetails[0].'and'.$_SESSION["currentUser"][0].'"  >
                                <svg width="24" height="24" viewBox="0 0 24 24" aria-label="clap"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.37.83L12 3.28l.63-2.45h-1.26zM13.92 3.95l1.52-2.1-1.18-.4-.34 2.5zM8.59 1.84l1.52 2.11-.34-2.5-1.18.4zM18.52 18.92a4.23 4.23 0 0 1-2.62 1.33l.41-.37c2.39-2.4 2.86-4.95 1.4-7.63l-.91-1.6-.8-1.67c-.25-.56-.19-.98.21-1.29a.7.7 0 0 1 .55-.13c.28.05.54.23.72.5l2.37 4.16c.97 1.62 1.14 4.23-1.33 6.7zm-11-.44l-4.15-4.15a.83.83 0 0 1 1.17-1.17l2.16 2.16a.37.37 0 0 0 .51-.52l-2.15-2.16L3.6 11.2a.83.83 0 0 1 1.17-1.17l3.43 3.44a.36.36 0 0 0 .52 0 .36.36 0 0 0 0-.52L5.29 9.51l-.97-.97a.83.83 0 0 1 0-1.16.84.84 0 0 1 1.17 0l.97.97 3.44 3.43a.36.36 0 0 0 .51 0 .37.37 0 0 0 0-.52L6.98 7.83a.82.82 0 0 1-.18-.9.82.82 0 0 1 .76-.51c.22 0 .43.09.58.24l5.8 5.79a.37.37 0 0 0 .58-.42L13.4 9.67c-.26-.56-.2-.98.2-1.29a.7.7 0 0 1 .55-.13c.28.05.55.23.73.5l2.2 3.86c1.3 2.38.87 4.59-1.29 6.75a4.65 4.65 0 0 1-4.19 1.37 7.73 7.73 0 0 1-4.07-2.25zm3.23-12.5l2.12 2.11c-.41.5-.47 1.17-.13 1.9l.22.46-3.52-3.53a.81.81 0 0 1-.1-.36c0-.23.09-.43.24-.59a.85.85 0 0 1 1.17 0zm7.36 1.7a1.86 1.86 0 0 0-1.23-.84 1.44 1.44 0 0 0-1.12.27c-.3.24-.5.55-.58.89-.25-.25-.57-.4-.91-.47-.28-.04-.56 0-.82.1l-2.18-2.18a1.56 1.56 0 0 0-2.2 0c-.2.2-.33.44-.4.7a1.56 1.56 0 0 0-2.63.75 1.6 1.6 0 0 0-2.23-.04 1.56 1.56 0 0 0 0 2.2c-.24.1-.5.24-.72.45a1.56 1.56 0 0 0 0 2.2l.52.52a1.56 1.56 0 0 0-.75 2.61L7 19a8.46 8.46 0 0 0 4.48 2.45 5.18 5.18 0 0 0 3.36-.5 4.89 4.89 0 0 0 4.2-1.51c2.75-2.77 2.54-5.74 1.43-7.59L18.1 7.68z"></path></svg>
                                '.$postDetails[4].' Likes
                            </button>';
                            

                            echo '
                            <button class="addBook" id="'.$_SESSION['currentUser'][0].'#'.$postDetails[0].'" >
                                <svg width="25" height="25" viewBox="0 0 25 25" fill="none" class="np"><path d="M18 2.5a.5.5 0 0 1 1 0V5h2.5a.5.5 0 0 1 0 1H19v2.5a.5.5 0 1 1-1 0V6h-2.5a.5.5 0 0 1 0-1H18V2.5zM7 7a1 1 0 0 1 1-1h3.5a.5.5 0 0 0 0-1H8a2 2 0 0 0-2 2v14a.5.5 0 0 0 .8.4l5.7-4.4 5.7 4.4a.5.5 0 0 0 .8-.4v-8.5a.5.5 0 0 0-1 0v7.48l-5.2-4a.5.5 0 0 0-.6 0l-5.2 4V7z" fill="#292929"></path></svg>
                                Add to bookmark
                            </button>
                            
                            
                            '


                            ?>

                         
                        </div>
                  
                    </div>
                  
                </div>

           
            </div>

            <div class="userDetails">
                <!-- <input type="text" placeholder="Search"> -->
                <div class="userInfo">
                    <?php
                        $imgUrl="http://".$_SERVER['HTTP_HOST']."/MediumClone/".$userDetails[2];
                        echo '
                        <img src="'.$imgUrl.'" class="userLog">
                        <p class="logName">'.$userDetails[0].' '.$userDetails[1].'</p>
                        ';?>
                   
                    <?php
                    $friId=$postDetails[5];
                    $currID=$_SESSION['currentUser'][0];
                    function countFollowers($uid){
                        global $conn;
                        $query="SELECT * FROM Followers where userID='$uid' ;";
                        $result=mysqli_query($conn,$query);
                        if($result){
                            $data=mysqli_fetch_all($result);
                            return count($data);
                        }
                        else{
                            return 0;
                        } 
                    }
                    function getStatus($uid){
                        global $conn;
                        $query="SELECT status FROM Users where uid='$uid' ;";
                        $result=mysqli_query($conn,$query);
                        if($result){
                            $data=mysqli_fetch_all($result);
                            return $data[0][0]==NULL?"No Status":$data[0][0];
                        }
                        else{
                            return "";
                        } 
                    }
                    echo ' <p  class="followers">'.countFollowers($friId).' followers</p>
                          <p class="desc">'.getStatus($friId).'</p>';
                    function checkFollow($uid,$fid){
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
                    if($currID!=$friId){
                        if(checkFollow($currID,$friId)){
                            echo '   <button style="background-color:gray;"class="follow " style="" id="'.$friId.'#'.$currID.'">Unfollow</button>';
                        }
                        else{
                            echo '   <button style="background-color:#3d8110;" class="follow" id="'.$friId.'#'.$currID.'">Follow</button>';
    
                        }                        
                    
                    }


                    
                    ?>
                </div>
                <h6>Related</h6>
                <div class="relatedPosts">
                        <?php
                            $relatedData=[];
                            function getUserX($value){
                                global $conn;
                                $query="SELECT uid from Posts where postId='$value'; ";
                                $result=mysqli_query($conn,$query);
                                if($result){
                                    $data=mysqli_fetch_row($result);
                                    return $data[0];
                                }
                                else{
                                    return -1;
                                }
                            }
    
                            function getImgByPost($value){
                                global $conn;
                                $query="SELECT imgUrl from Images where postId='$value'; ";
                                $result=mysqli_query($conn,$query);
                                if($result){
                                    $data=mysqli_fetch_all($result);
                                    return $data[0];

                                }
                                else{
                                    return -1;
                                }
                            }
                            function relatedPosts($uid){
                                global $conn;
                                global $relatedData;

                                $query="SELECT * FROM Posts WHERE uid='$uid' ;";
                                $result=mysqli_query($conn,$query);
                                if($result){
                                    $data=mysqli_fetch_all($result);
                                    $relatedData=$data;
                                    return true;

                                }
                                else{
                                    echo false;
                                }
                            }
                            $usr= getUserX($postDetails[0]);
                            if(relatedPosts($usr)){
                                foreach($relatedData as $key=>$value){
                                    if($value[0]!=$postDetails[0]){
                                        $newUrl="http://".$_SERVER['HTTP_HOST']."/MediumClone/".getImgByPost($value[0])[0];
                                        echo '
                                        <div class="item" id="'.$value[0].'">
                                        <img src="'.$newUrl.'" class="leftRel">
                                        <p class="rightRel">'.substr($value[1],0,20).'...</p>
                                        </div>';
                                    }
                                }
                            }

                           
                            ?>
                        
                        
                
                </div>
             

            </div>
           
      </div>


      <!-- Dialog -->
      <div class="dialog">

          <!-- Dialog Item -->
          <div class="dialogItem">
              <!-- Close Btn -->
              <div class="usr">
                    <?php
                        $imgUrl="http://".$_SERVER['HTTP_HOST']."/MediumClone/".$_SESSION['currentUser'][5];
                        echo '
                        <span>
                            <img src=" '.$imgUrl.' " >'.$_SESSION['currentUser'][1].' '.$_SESSION['currentUser'][2].'
                        </span>
                        ';
                    ?>
                  <button id="close"><i class="material-icons">close</i> </button>
              </div>
              

              <!-- DetParent -->
              <div class="det">
                    <div class="statusBar">
                        <?php
                        echo '<textarea style="resize:none;" placeholder="Add Status Here" id="'.$_SESSION['currentUser'][0].'" class="statusValue" ></textarea>';

                        ?>
                        <button class="updateBtn2">Update</button>
                    </div>

                    <div class="followersBar">
                        <p class="hd">You'r Followers</p>
                        <div class="followersList">
                            <?php
                                $followersAll=[];
                                $currUS=$_SESSION['currentUser'][0];
                                function readAllFollowers($usId){
                                    global $conn;
                                    global $followersAll;
                                    $query="SELECT friId FROM Followers WHERE userID='$usId';";
                                    $result=mysqli_query($conn,$query);
                                    if($result){
                                        $followersAll=mysqli_fetch_all($result);
                                        return true;
                                    }
                                    else{
                                        return false;
                                    }
                                }

                                function readData($uid){
                                    global $conn;
                                    $query="SELECT uid,firstName,lastName,userPic FROM Users WHERE uid='$uid';";
                                    $result=mysqli_query($conn,$query);
                                    if($result){
                                        return mysqli_fetch_row($result);
                                    }
                                    else{
                                        return false;
                                    } 
                                }

                                if(readAllFollowers($currUS)){
                                    foreach($followersAll as $key=>$value){
                                        $idx=$followersAll[$key][0];
                                        $crd=readData($idx);
                                        $iurl="http://".$_SERVER['HTTP_HOST']."/MediumClone/".$crd[3];
                                        $fullName=$crd[1].' '.$crd[2];
                                        
                                        echo '

                                        <div class="followersItem" id="'.$idx.'">
                                            <img src="'.$iurl.'">
                                            '.$fullName.'
                                            <button class="boxUnfollow" id="'.$_SESSION['currentUser'][0].'#'.$idx.'">Unfollow</button>
                                        </div>
                                        ';
                                    }
                                }
                                





                            ?>
                           
                        </div>
                    </div>
                    <p class="bd">You'r Bookmarks</p>

                    <div class="bookmarksList">
                        <?php
                            $bookmarks=[];
                            function readAllBookmarks($uid){
                                global $conn;
                                global $bookmarks;
                                $query="SELECT pid from Bookmarks where uid='$uid'";
                                $result=mysqli_query($conn,$query);
                                if($result){
                                    $bookmarks=mysqli_fetch_all($result);
                                    return true;
                                }
                                else{
                                    return false;
                                }

                            }
                            function readImageByPostId($id){
                                global $conn;
                                $query="SELECT imgUrl from Images where postId='$id'";
                                $result=mysqli_query($conn,$query);
                                if($result){
                                   return mysqli_fetch_row($result)[0];
                                }
                                else{
                                    return -1;
                                }

                            }

                            function readPostsData($id){
                                global $conn;
                                $query="SELECT title from Posts where postId='$id'";
                                $result=mysqli_query($conn,$query);
                                if($result){
                                   return mysqli_fetch_row($result)[0];
                                }
                                else{
                                    return -1;
                                }
                            }
                            if( readAllBookmarks($_SESSION['currentUser'][0]))
                            {
                                
                                foreach ($bookmarks as $key => $value) {
                                    # code...
                                    $imgUrl="http://".$_SERVER['HTTP_HOST']."/MediumClone/".readImageByPostId($value[0]);
                                    echo '
                                    <div class="bookmarksItem" id="'.$value[0].'" >
                                        <img src="'.$imgUrl.'" class="postIMG">
                                        <p class="tit" id="'.$value[0].'">'.substr(readPostsData($value[0]),0,20).'...</p>
                                        <button class="removeBtn" id="'.$_SESSION['currentUser'][0].'#'.$value[0].'">Remove</button>
                                    </div>';
                                }      
                                
                            }
                          

                           


                        ?>
                    </div>              
              </div>


              
          </div>
      </div>

















     
      <script>
          var show=document.getElementById("show");
          var dialog=document.querySelector(".dialog");
          var close=document.getElementById("close");
          var addLike=document.querySelector(".addLike");

          var pid=addLike.getAttribute("id").split("and")[0];
          var uid=addLike.getAttribute("id").split("and")[1];
       

          addLike.addEventListener('click',(e)=>{
            var xhr=new XMLHttpRequest();
            xhr.open("POST",window.location.origin+"/MediumClone/update.php",true);
            var formData=new FormData();
            formData.append("type","updateLikes");
            formData.append("uid",uid);
            formData.append("pid",pid);
            xhr.send(formData)
            xhr.onreadystatechange=function(){
                if(xhr.readyState == 4 && xhr.status == 200)
                {
                    addLike.innerHTML=`
                    <svg width="24" height="24" viewBox="0 0 24 24" aria-label="clap"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.37.83L12 3.28l.63-2.45h-1.26zM13.92 3.95l1.52-2.1-1.18-.4-.34 2.5zM8.59 1.84l1.52 2.11-.34-2.5-1.18.4zM18.52 18.92a4.23 4.23 0 0 1-2.62 1.33l.41-.37c2.39-2.4 2.86-4.95 1.4-7.63l-.91-1.6-.8-1.67c-.25-.56-.19-.98.21-1.29a.7.7 0 0 1 .55-.13c.28.05.54.23.72.5l2.37 4.16c.97 1.62 1.14 4.23-1.33 6.7zm-11-.44l-4.15-4.15a.83.83 0 0 1 1.17-1.17l2.16 2.16a.37.37 0 0 0 .51-.52l-2.15-2.16L3.6 11.2a.83.83 0 0 1 1.17-1.17l3.43 3.44a.36.36 0 0 0 .52 0 .36.36 0 0 0 0-.52L5.29 9.51l-.97-.97a.83.83 0 0 1 0-1.16.84.84 0 0 1 1.17 0l.97.97 3.44 3.43a.36.36 0 0 0 .51 0 .37.37 0 0 0 0-.52L6.98 7.83a.82.82 0 0 1-.18-.9.82.82 0 0 1 .76-.51c.22 0 .43.09.58.24l5.8 5.79a.37.37 0 0 0 .58-.42L13.4 9.67c-.26-.56-.2-.98.2-1.29a.7.7 0 0 1 .55-.13c.28.05.55.23.73.5l2.2 3.86c1.3 2.38.87 4.59-1.29 6.75a4.65 4.65 0 0 1-4.19 1.37 7.73 7.73 0 0 1-4.07-2.25zm3.23-12.5l2.12 2.11c-.41.5-.47 1.17-.13 1.9l.22.46-3.52-3.53a.81.81 0 0 1-.1-.36c0-.23.09-.43.24-.59a.85.85 0 0 1 1.17 0zm7.36 1.7a1.86 1.86 0 0 0-1.23-.84 1.44 1.44 0 0 0-1.12.27c-.3.24-.5.55-.58.89-.25-.25-.57-.4-.91-.47-.28-.04-.56 0-.82.1l-2.18-2.18a1.56 1.56 0 0 0-2.2 0c-.2.2-.33.44-.4.7a1.56 1.56 0 0 0-2.63.75 1.6 1.6 0 0 0-2.23-.04 1.56 1.56 0 0 0 0 2.2c-.24.1-.5.24-.72.45a1.56 1.56 0 0 0 0 2.2l.52.52a1.56 1.56 0 0 0-.75 2.61L7 19a8.46 8.46 0 0 0 4.48 2.45 5.18 5.18 0 0 0 3.36-.5 4.89 4.89 0 0 0 4.2-1.51c2.75-2.77 2.54-5.74 1.43-7.59L18.1 7.68z"></path></svg>
                    ${xhr.response} Likes
                    
                    `

                }
            }



          });




          var showIt=true;
          show.addEventListener("click",(e)=>{
              if(showIt){
                dialog.style.display="flex";
                
              }
              else{
               dialog.style.display="none";

              }
              showIt=!showIt;
          });

          close.addEventListener("click",()=>{

            showIt=false;
            dialog.style.display="none"
          });




          const elements3 = document.querySelectorAll('.item');

                // adding the event listener by looping
                elements3.forEach(element => {
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




            const elements4 = document.querySelectorAll('.tit');

                // adding the event listener by looping
                elements4.forEach(element => {
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




          var followBtn=document.querySelector(".follow");
          if(followBtn!=null){

          var whoAddID=followBtn.getAttribute("id").split("#")[0];
          var currUsrID=followBtn.getAttribute("id").split("#")[1];

          followBtn.addEventListener('click',(e)=>{


            var xhr=new XMLHttpRequest();
            xhr.open("POST",window.location.origin+"/MediumClone/followUnfollow.php",true);
            var followFormData=new FormData();
            followFormData.append("followID",whoAddID);
            followFormData.append("userID",currUsrID);

            xhr.send(followFormData)
            xhr.onreadystatechange= function(){

                if(xhr.status==200 && xhr.readyState==4){
                    if(xhr.response.includes("Added")){
                        followBtn.innerHTML="Unfollow";
                        console.log("Added");
                        followBtn.style.backgroundColor="gray";
                        followBtn.style.transition="1s ease";

                    }
                    else{
                        if(xhr.response.includes("Removed")){
                            followBtn.innerHTML="Follow";
                            console.log("Removed");
                            followBtn.style.backgroundColor="#3d8110";
                            followBtn.style.transition="1s ease";

                        }
                    }
                }
            }


          })


          }
          


          var statusValue=document.querySelector(".statusValue");
          var updateBtn2=document.querySelector(".updateBtn2");
          updateBtn2.addEventListener('click',()=>{
             let cuID=statusValue.getAttribute('id');
             let statusData=statusValue.value;
             var xhr=new XMLHttpRequest();
             xhr.open("POST",window.location.origin+"/MediumClone/updateStatus.php",true);
             var statusForm=new FormData();
             statusForm.append("value",statusData);
             xhr.send(statusForm)
            xhr.onreadystatechange= function(){

                if(xhr.status==200 && xhr.readyState==4){
                    if(xhr.response){
                        document.querySelector(".desc").textContent=statusData;
                    }
                    else{
                        document.querySelector(".desc").textContent='No Status ...';
                    }
                }
            }

             
          });



          function removeNode(idx){
                var data=document.querySelector(".followersList");
                let k=-1;
                for(let i=0;i<data.children.length;i++){
                    console.log(data.children[i].getAttribute("id")==idx)
                    if(data.children[i].getAttribute("id")==idx){

                        k=i;
                        break;
                    }

                }
                if(k!=-1){
                    data.removeChild(data.children[k]);

                }
          }

          var unfollows=document.querySelectorAll('.boxUnfollow');
          unfollows.forEach((element)=>{
              element.addEventListener('click',()=>{
                var idx=element.getAttribute("id").split("#")[1];
                var uidx=element.getAttribute("id").split("#")[0];
                console.log(uidx,idx);
                var xhr=new XMLHttpRequest();
                xhr.open("POST",window.location.origin+"/MediumClone/followUnfollow.php",true);
                var followFormData=new FormData();
                followFormData.append("followID",idx);
                followFormData.append("userID",uidx);
                followFormData.append("type","onlyRemove")

                xhr.send(followFormData)
                xhr.onreadystatechange= function(){

                    if(xhr.status==200 && xhr.readyState==4){
                        if(xhr.response.includes("Removed")){
                            removeNode(idx);
                        }
                    }
                }


              })
          })


   

      </script>

      <script>
          var addBook=document.querySelector(".addBook");
          addBook.addEventListener("click",()=>{
              var cid=addBook.getAttribute("id").split("#")[0];
              var pid=addBook.getAttribute("id").split("#")[1];
              var xhr=new XMLHttpRequest();
              xhr.open("POST",window.location.origin+"/MediumClone/addBookmark.php",true);
              var bookData=new FormData();
              bookData.append("pid",pid);
              bookData.append("cid",cid);

              xhr.send(bookData)
                xhr.onreadystatechange= function(){

                    if(xhr.status==200 && xhr.readyState==4){
                        console.log(xhr.response)
                      if(xhr.response=="Done"){
                        Toastify({
                                text: "Post is Added In Bookmarks...",
                                style: {
                                background: "rgba(0, 0, 0, 0.815)",
                                fontFamily:"sans-serif",
                                borderRadius:"5px",
                                }
                            }).showToast();
    
    
                            
                      }
                    }
                }


          })

      </script>

      <script>
   
            function removeNode2(idx){
                var data=document.querySelector(".bookmarksList");
                let k=-1;
                for(let i=0;i<data.children.length;i++){
                    if(data.children[i].getAttribute("id")==idx){
                        k=i;
                        break;
                    }

                }
                if(k!=-1){
                    data.removeChild(data.children[k]);
                }
             }

            var removeBtn=document.querySelectorAll('.removeBtn');
            removeBtn.forEach((element)=>{
                element.addEventListener('click',()=>{
                    var postId=element.getAttribute("id").split("#")[1];
                    var currId=element.getAttribute("id").split("#")[0];
                    var xhr=new XMLHttpRequest();
                    xhr.open("POST",window.location.origin+"/MediumClone/removeBookmark.php",true);
                    var followFormData=new FormData();
                    followFormData.append("postId",postId);
                    followFormData.append("currId",currId);

                    xhr.send(followFormData)
                    xhr.onreadystatechange= function(){
                        if(xhr.status==200 && xhr.readyState==4){
                           if(xhr.response.includes("Done")){
                                removeNode2(postId)
                           }

                        }
                    }


                })
            })

      

      </script>
</body>
</html>