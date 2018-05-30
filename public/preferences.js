	var geometry2 = new THREE.BoxBufferGeometry(20, 20, 20);
    var xmlhttp = "";
    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.open("GET", "http://localhost:8000/public/pref/preferences.xml", false);
    xmlhttp.send();
    const xmlDoc = xmlhttp.responseXML;	
	
	var x = xmlDoc.getElementsByTagName("user");
	var verif = 0;
	for(i = 0; i < x.length ; i++)
	{
		consolelog(x[i].getElementsByTagName("name")[0].childNodes[0].nodeValue);
		if(x[i].getElementsByTagName("name")[0].childNodes[0].nodeValue == visit.owner.username ) 
			{
				document.getElementById("panel_view").className = "bg-"+ x[i].getElementsByTagName("bg")[0].childNodes[0].nodeValue;
				verif = 1;
			}
	}
	
	if(verif==0)
	{
		document.getElementById("panel_view").className = "bg-secondary";
	}
