
<?php
    session_start();
    include "connection.php";
    $files=[];
    function createPostsTable(){
        global $conn;
        $createTable="CREATE TABLE IF NOT EXISTS Posts(

            postId INT PRIMARY KEY AUTO_INCREMENT,
            title VARCHAR(100) NOT NULL UNIQUE,
            descr TEXT NOT NULL,
            created_on TIMESTAMP,
            likes INT DEFAULT 0,
            uid INT,
            FOREIGN KEY(uid) REFERENCES Users(uid)
            );";
    
        $status=mysqli_query($conn,$createTable);
        if($status){
            return true;
        }
        else{
            return false;
        }

    }

    function createImagesTable(){
        global $conn;
        $createTable="CREATE TABLE IF NOT EXISTS Images(

            imgId INT PRIMARY KEY AUTO_INCREMENT,
            imgUrl TEXT NOT NULL,
            postId INT,
            FOREIGN KEY(postId) REFERENCES Posts(postId)
            );";
    
            $status=mysqli_query($conn,$createTable);
            if($status){
                return true;
            }
            else{
                return false;
            }

    }

    function insertInPosts($title,$desc,$uid){
        global $conn;
        $query="INSERT INTO Posts(title,descr,uid) VALUES('$title','$desc','$uid');";
        $status=mysqli_query($conn,$query);
        if($status){
            return true;
        }
        else{
            return false;
        }
    }

    function insertInImages($imgUrl,$postId){
        global $conn;
        $query="INSERT INTO Images(imgUrl,postId) VALUES('$imgUrl','$postId');";
        $status=mysqli_query($conn,$query);
        if($status){
            return true;
        }
        else{
            return false;
        }
    }

    function getPostId($title){
        global $conn;
        $query="SELECT postId FROM Posts where title='$title';";
        $result=mysqli_query($conn,$query);
        if($result){
            $data=mysqli_fetch_row($result);
            
            return $data[0];
        }
        else{
            return -1;
        }
    }


    function uploadFile($fileName,$file_tmp){
        global $files;
        $exists=file_exists("postsImages");
        if($exists){
            $target_dir = "postsImages/";
            $target_file = $fileName;
            $to=$target_dir.basename($target_file);
            $from=$file_tmp;

            array_push($files,$to);
            if(move_uploaded_file($from,$to)){
               //Save In Database
               
               if(createPostsTable()){
                   if(createImagesTable()){
                      return true;
                   }
                   else{
                       return false;
                   }
               }
               else{
                   return false;
               }
            }
            else{
               return false;
            }
        }
      
    }

    $title=$_POST['title'];
    $desc=$_POST['desc'];
    $uid=$_SESSION['currentUser'][0];

    $startRun=true;
    foreach($_FILES as $key=>$value){
        $type=$_FILES[$key]['type'];
        $checkType=preg_match_all("/jpeg|png/",strval($type));
       
        if(!$checkType){
            $error_response[] = array("error" => "Invalid Types");
            echo json_encode($error_response);
            break;
        }
        else{
            $fileName=$_FILES[$key]['name'];
            $file_tmp=$_FILES[$key]['tmp_name'];
            if(!uploadFile($fileName,$file_tmp)){
                echo "Error";
                $startRun=false;
                break;
            }
            else{
               $startRun=true;
            }
        }

       
    }
    if($startRun){
        $isPost=false;
        // Insert In Post
        if(insertInPosts($title,$desc,$uid)){
            $isPost=true;
        }
        if($isPost){
        //Insert In Images

          $isInserted=false;
          $postId=getPostId($title);
          for($i=0;$i<count($files);$i++){
            if(insertInImages($files[$i],$postId)){
                $isInserted=true;
            }
          }
          if($isInserted){
              echo "Done";
          }


        }
    
    }

?>
