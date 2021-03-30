
function ajouterHotel(){
    var hotel1=document.getElementById("hotel1");
    var hotel2=document.getElementById("hotel2");
    if(hotel1.style.display=="none" && hotel2.style.display=="none"){
        hotel1.style.display="block";
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
    }
}