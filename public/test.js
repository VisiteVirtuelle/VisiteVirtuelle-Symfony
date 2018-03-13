alert("Name:\n" + visit.name + "\n\nPath:\n" + visit.path);

if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp = new XMLHttpRequest();
} else {// code for IE6, IE5
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
}

var xml = visit.path + "visit.xml";
alert(xml);

 
xmlhttp.open("GET", xml, false);
xmlhttp.send();

xmlDoc = xmlhttp.responseXML;

alert("GOT");
var x = xmlDoc.getElementsByTagName("ROOM");
alert("GOT ROOM");

var rooms = new Map();
for ( i = 0; i < x.length; i++)
{
    rooms.set(x[i].getElementsByTagName("NAME")[0].childNodes[0].nodeValue,
             x[i].getElementsByTagName("URLIMG")[0].childNodes[0].nodeValue
    );
}	

alert("end");