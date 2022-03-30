window.addEventListener('scroll',(e)=>{
    if(e.target.scrollingElement.scrollTop>=108){
        document.querySelector('.nav').style.backgroundColor="white";
    }
    else{
        document.querySelector('.nav').style.backgroundColor="transparent";
    }
})




