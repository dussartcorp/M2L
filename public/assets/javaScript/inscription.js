
function ajouterHotel(){
    var hotel1=document.getElementById("hotel1");
    var hotel2=document.getElementById("hotel2");
    if(hotel1.style.display=="none" && hotel2.style.display=="none"){
        hotel1.style.display="block";
        document.getElementById("libelleResa").style.display="block"
        document.getElementById("liSuppHotel").style.pointerEvents="";
    }
    else if(hotel1.style.display=="block" && hotel2.style.display=="none"){
        hotel2.style.display="block"
    }
}

function supprimerHotel(){
    var hotel1=document.getElementById("hotel1");
    var hotel2=document.getElementById("hotel2");
    if(hotel1.style.display=="block" && hotel2.style.display=="block"){
        hotel2.style.display="none";
    }
    else if(hotel1.style.display=="block" && hotel2.style.display=="none"){
        hotel1.style.display="none"
        document.getElementById("libelleResa").style.display="none"
        document.getElementById("liSuppHotel").style.pointerEvents="none";
    }
}

function ajouterRestauration(){
    var restauration1=document.getElementById("idRestauration1");
    var restauration2=document.getElementById("idRestauration2");
    if(restauration1.style.display=="none" && restauration2.style.display=="none"){
        restauration1.style.display="block";
        document.getElementById("lblRestauration").style.display="block";
        document.getElementById("liSuppResto").style.pointerEvents="";
    }
    else if(restauration1.style.display=="block"&&restauration2.style.display=="none"){
        restauration2.style.display="block";
    }
}

function supprimerRestauration(){
    var restauration1=document.getElementById("idRestauration1");
    var restauration2=document.getElementById("idRestauration2");
    if(restauration1.style.display=="block" &&restauration2.style.display=="block"){
        restauration2.style.display="none";
    }
    else if(restauration1.style.display=="block"&&restauration2.style.display=="none"){
        restauration1.style.display="none";
        document.getElementById("lblRestauration").style.display="none";
        document.getElementById("liSuppResto").style.pointerEvents="none";
    }
}