<?php
    session_start()
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Write-Your Ideas</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <link rel="stylesheet" href="./css/write.css">

</head>
<body id="body">
    <div class="navWrite">
        <div class="logWrite">
            <div class="logImg">
                <svg class="svgIcon-use" height="25" viewBox="0 0 1043.63 592.71"><g data-name="Layer 2"><g data-name="Layer 1"><path d="M588.67 296.36c0 163.67-131.78 296.35-294.33 296.35S0 460 0 296.36 131.78 0 294.34 0s294.33 132.69 294.33 296.36"></path><path d="M911.56 296.36c0 154.06-65.89 279-147.17 279s-147.17-124.94-147.17-279 65.88-279 147.16-279 147.17 124.9 147.17 279"></path><path d="M1043.63 296.36c0 138-23.17 249.94-51.76 249.94s-51.75-111.91-51.75-249.94 23.17-249.94 51.75-249.94 51.76 111.9 51.76 249.94"></path></g></g></svg>
            </div>
            <p>Draft in  <?php echo strtoupper($_SESSION['currentUser'][1]);?></p>
        </div>

        <button class="publish" id="publish">Publish</button>
    </div>
   

    <div class="writeHere">
            <div class="area">
                <button class="addImg" id="addImg">
                    <svg class="svgIcon-use" width="25" height="25"><path d="M20 12h-7V5h-1v7H5v1h7v7h1v-7h7" fill-rule="evenodd"></path></svg>
                </button>
                <input type="file"  hidden id="hiddenImg" >
                <input type="text" placeholder="Title" value="" id="title">
            </div>
            <div class="det">
                <div class="section" id="section">
                </div>
                <textarea  placeholder="Tell Your Story here..." id="description"></textarea>
            </div>
      
    </div>

    <script src="./js/post.js"></script>
</body>
</html>