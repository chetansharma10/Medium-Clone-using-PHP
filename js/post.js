var publish=document.getElementById("publish");
var desc=document.getElementById("description");
var title=document.getElementById("title");
var hiddenImg=document.getElementById("hiddenImg");
var addImg=document.getElementById("addImg");
var section=document.getElementById("section");
var files=[];
var titVal="";
var desVal="";


desc.addEventListener('select',(e)=>{
    var selected=window.getSelection().toString();
    var me=desc.value.replace(selected,"<h2>"+selected+"</h2>")
    desc.value=me;
})
addImg.addEventListener("click",(e)=>{
    hiddenImg.click()
    hiddenImg.addEventListener('change',(e)=>{

        var reader = new FileReader();
        reader.onload = function(){
            section.style.backgroundImage="url("+reader.result+ ")";
        };
        reader.readAsDataURL(e.target.files[0]);

        for(var i=0;i<e.target.files.length;i++){
            files.push(e.target.files[i])
        }
    })
    
})
publish.addEventListener('click',(e)=>{
    console.log("Publish")

    titVal=title.value;
    var data=desc.value.split("\n");
    var resultant="";
    for(let i=0;i<data.length;i++){
        console.log(data[i])
        resultant=resultant+data[i]+"<br><br>";
    }
    desVal=resultant;
 
    sendRequest();
    


})

function sendRequest(){

    var xhr = new XMLHttpRequest();
    xhr.open("POST","/MediumClone/upload.php",true);  
    
    var formData=new FormData();
    formData.append("title",titVal);
    formData.append("desc",desVal);

    for(var i=0;i<files.length;i++){
        formData.append(`${titVal}-${i}`,files[i]);
    }

    
    xhr.send(formData);

    xhr.onreadystatechange = function(){
        if(xhr.readyState == 4 && xhr.status == 200)
        {
            // some code ...
           
            if(xhr.response.includes("Done")){

                Toastify({
                    text: "Post Added Successfully...",
                    style: {
                    background: "rgba(0, 0, 0, 0.815)",
                    fontFamily:"sans-serif",
                    borderRadius:"5px",
                    }
                }).showToast();
                setTimeout(function(){
                    window.location.pathname=`/MediumClone/index.php`;
                },1000);
            }
        }
    }

}