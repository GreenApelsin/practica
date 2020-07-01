if (document.location.pathname == "/send"){
    window.onload = function() {
        document.getElementById('upload').style.width = document.getElementById('filesend').offsetWidth - 6;
        document.getElementById('fileformlabel').style.width = document.getElementById('filesend').offsetWidth - 6;
    }

    window.onresize = function( event )
    {
        document.getElementById('upload').style.width = document.getElementById('filesend').offsetWidth - 6;
        document.getElementById('fileformlabel').style.width = document.getElementById('filesend').offsetWidth - 6;
    };
}

function getName (str){
    if (str.lastIndexOf('\\')){
        var i = str.lastIndexOf('\\')+1;
    }
    else{
        var i = str.lastIndexOf('/')+1;
    }

    if (i == 0){
        var filename = "Выбери или перетащи";
    }else{
        var filename = str.slice(i);

    }
    var uploaded = document.getElementById("fileformlabel");
    post.name.value = filename;
    uploaded.innerHTML = filename;
}