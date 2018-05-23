"use strict";

const
GRID_OFFSET = {
	x : 4,
	y : 4
};
const
GRID_NB_ROW = 30;
const
GRID_NB_COL = 30;
const
GRID_SPACING_POINT = 8;
const
GRID_CROSS_LENGTH = 4;

function Room() {
	var m_polygone = new Array();
	var m_name = "";

	this.DrawRoom = function(ctx, color){
		 ctx = document.getElementById('myCanvas').getContext('2d');
		 ctx.fillStyle = color;
		 ctx.beginPath();
		 ctx.moveTo(GRID_OFFSET.x + m_polygone[0].x * GRID_SPACING_POINT, GRID_OFFSET.y + m_polygone[0].y * GRID_SPACING_POINT);
		 for(var i = 1; i < m_polygone.length;i++){
			 ctx.lineTo(GRID_OFFSET.x + m_polygone[i].x * GRID_SPACING_POINT,GRID_OFFSET.y + m_polygone[i].y * GRID_SPACING_POINT);
		 }
		 ctx.closePath();
		 ctx.fill();
	};
	this.PushPolygone = function(point){
		m_polygone.push(point);
	};
	this.GetPolygone = function(){
		return m_polygone;
	};
	this.GetName = function(){
		return m_name;
	};
	this.SetName = function(name){
		if(name == null)return;
		m_name = name.replace(/[&\/\\#,+()$~%.":*?<>{}]/g,'');
	};
	this.Raycast = function(point){
		var x = point.x, y = point.y;

	    var inside = false;
	    
	    for (var i = 0, j = m_polygone.length - 1; i < m_polygone.length; j = i++) {
	        var xi = m_polygone[i].x, yi = m_polygone[i].y;
	        var xj = m_polygone[j].x, yj = m_polygone[j].y;

	        var intersect = ((yi > y) != (yj > y))
	            && (point.x < (xj - xi) * (point.y - yi) / (yj - yi) + xi);
	        if (intersect) inside = !inside;
	    }
	    return inside;
	};
}
// ///////////////////////////////////////////////////////////////////////////////////
function Floor() {
	var m_tempRoom = new Room();
	var m_rooms = new Array();
	this.GetRooms = function() {
		return m_rooms;
	};
	this.DrawFloor = function(ctx, colors) {
		var tempColor = "";
		for(var i =0; i<m_rooms.length;i++){
			tempColor = colors[i%colors.length];
			m_rooms[i].DrawRoom(ctx, tempColor);
		}
	};
	this.AddRoom = function() {
		m_rooms.push(m_tempRoom)
		m_tempRoom = new Room();
		return true;
	};
	this.PushPointTempRoom = function(posx, posy){
		m_tempRoom.PushPolygone({x:posx,y:posy});
	};
	this.SetNameTempRoom = function(name){
		m_tempRoom.SetName(name);
	}
	this.RaycastRooms = function(point){
		if(m_rooms.length < 1) return -1;
		var tempRoom;
		for(var i = 0; i < m_rooms.length; i++){
			tempRoom = m_rooms[i];
			if(tempRoom.Raycast(point)) return i;
		}
		return -1;
	};
}
// ////////////////////////////////////////////////////////////////////////////////////
function WindowCanvas() {
	var m_canvas = document.getElementById("myCanvas");
	m_canvas.width=250;
	m_canvas.height=250;
	var m_ctx = m_canvas.getContext("2d");
	var m_cursorPosition = {
		x : null,
		y : null
	};
	var m_floors = new Array();
	var m_roomColors = new Array();
	m_roomColors.push("LightCoral");
	m_roomColors.push("MediumVioletRed");
	m_roomColors.push("Tomato");
	m_roomColors.push("SlateBlue");
	m_roomColors.push("Green");
	m_roomColors.push("DodgerBlue");
	m_roomColors.push("BurlyWood");
	m_roomColors.push("SaddleBrown");
	m_roomColors.push("Red");
	
	var m_selectedFloor = -1;
	var m_hoveredRoom = -1;
	// méthodes

	this.GetCursorPosition = function() {
		return m_cursorPosition;
	};
	this.GetCanvas = function() {
		return m_canvas;
	};
	this.GetCtx = function() {
		return m_ctx;
	};
	this.GetFloors = function(){
		return m_floors;
	};
	this.GetSelectedFloor = function(){
		return m_floors[m_selectedFloor];
	};
	this.GetRoomColors = function(){
		return m_roomColors;
	};
	this.GetHoveredRoom = function(){
		return m_hoveredRoom;
	};
	this.SetCursorPosition = function(posx, posy) {
		m_cursorPosition.x = posx;
		m_cursorPosition.y = posy;
	};
	this.DrawGrid = function() {
		m_ctx.fillStyle = "SILVER";
		m_ctx.fillRect(GRID_OFFSET.x - GRID_CROSS_LENGTH,
				GRID_OFFSET.y - GRID_CROSS_LENGTH ,
				GRID_SPACING_POINT * GRID_NB_COL + GRID_CROSS_LENGTH /2,
				GRID_SPACING_POINT * GRID_NB_ROW+ GRID_CROSS_LENGTH /2);
		m_ctx.lineWidth = 2;
	    m_ctx.strokeStyle = 'DimGray';
	    // déssin de la grille
		for ( var i = 0; i < GRID_NB_ROW; i++) {
			for ( var j = 0; j < GRID_NB_COL; j++) {		
				m_ctx.beginPath();
				m_ctx.moveTo(GRID_OFFSET.x - (GRID_CROSS_LENGTH / 2)
						+ GRID_SPACING_POINT * j, GRID_OFFSET.y
						+ GRID_SPACING_POINT * i);
				m_ctx.lineTo(GRID_OFFSET.x + (GRID_CROSS_LENGTH / 2)
						+ GRID_SPACING_POINT * j, GRID_OFFSET.y
						+ GRID_SPACING_POINT * i);
				m_ctx.stroke();
				m_ctx.beginPath();
				m_ctx.moveTo(GRID_OFFSET.x + GRID_SPACING_POINT * j,
						GRID_OFFSET.y - (GRID_CROSS_LENGTH / 2)
								+ GRID_SPACING_POINT * i);
				m_ctx.lineTo(GRID_OFFSET.x + GRID_SPACING_POINT * j,
						GRID_OFFSET.y + (GRID_CROSS_LENGTH / 2)
								+ GRID_SPACING_POINT * i);
				m_ctx.stroke();
			}
		}		
	};
	
	this.NewFloor = function(){
		m_floors.splice(++m_selectedFloor, 0, new Floor());
		this.DrawSelectedFloor();
	};

	this.NewRoom = function(){
		m_status = m_statusValue.DRAWING_ROOM;
	};
	
	this.GetCursorToGridForRaycast = function(){
		if(m_cursorPosition.x==null)return;
		var tempPoint = {x : null, y : null};
		tempPoint.x = (m_cursorPosition.x - GRID_OFFSET.x) / GRID_SPACING_POINT;
		tempPoint.y = (m_cursorPosition.y - GRID_OFFSET.y) / GRID_SPACING_POINT;
		if((tempPoint.x<0)||
				(tempPoint.y<0)||
				(tempPoint.x>GRID_NB_COL-1)||
				(tempPoint.y>GRID_NB_ROW-1)
				){
			return {x : null, y : null};
		}
		return tempPoint;
	};
	this.RaycastHoveredFloor = function(){
		m_hoveredRoom = m_floors[m_selectedFloor].RaycastRooms(this.GetCursorToGridForRaycast());
	};
	this.GoPrevFloor = function(){
		if(m_selectedFloor==0)return;
		//m_selectedRoom=-1;
		m_selectedFloor--;
		this.DrawSelectedFloor();
	};
	this.GoNextFloor = function(){
		if(m_selectedFloor==m_floors.length-1)return;
		//m_selectedRoom=-1;
		m_selectedFloor++;
		this.DrawSelectedFloor();
	};

	// désactivation du menu clique droit
	m_canvas.addEventListener("contextmenu", (event) => {
        event.preventDefault();
    });
	
	this.DrawSelectedFloor = function(){
		this.DrawGrid();
		m_floors[m_selectedFloor].DrawFloor(m_ctx, m_roomColors);
		
	};
	this.ReadXml = function(){
		var xmlhttp;
		var xmlDoc;
		
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
		  xmlhttp = new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
		  xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		
		xmlhttp.open("GET","http://localhost:8000/visit/" + visit.id + "/visit.xml",false);
		xmlhttp.send();
		xmlDoc = xmlhttp.responseXML;
		xmlDoc = (new DOMParser()).parseFromString(xmlhttp.responseText, "text/xml");
		
		var xmlBlueprint = xmlDoc.getElementsByTagName("visit")[0].getElementsByTagName("blueprint");
		var itFloor = 1;
		
		var itRoom = 1;
		
		var itPoint = 1;
		
		
		var xmlFloor = xmlBlueprint[0].getElementsByTagName("floor");
		for(var itFloor = 0; itFloor < xmlFloor.length; itFloor++){
			this.NewFloor();
			var xmlRoom = xmlFloor[itFloor].getElementsByTagName("Room");
			
			for(var itRoom = 0; itRoom < xmlRoom.length; itRoom++){
				this.GetSelectedFloor().SetNameTempRoom(xmlRoom[itRoom].getElementsByTagName("Name")[0].childNodes[0].nodeValue); 	//nom
				var xmlPoint = xmlRoom[itRoom].getElementsByTagName("point");
				
				for(var itPoint = 0; itPoint < xmlPoint.length; itPoint++){
					this.GetSelectedFloor().PushPointTempRoom(xmlPoint[itPoint].getElementsByTagName("x")[0].childNodes[0].nodeValue,
							xmlPoint[itPoint].getElementsByTagName("y")[0].childNodes[0].nodeValue);		//coordonnées
				}
				this.GetSelectedFloor().AddRoom();		//ajout de la pièce
			}
		}
	};
}

var mainWindow = new WindowCanvas();
//mainWindow.NewFloor();
mainWindow.ReadXml();
mainWindow.GoPrevFloor();
mainWindow.DrawSelectedFloor();


$("#myCanvas").mousemove(
		function(event) {
			var m_canvas = document.getElementById('myCanvas');
			var x = event.clientX - mainWindow.GetCanvas().getBoundingClientRect().x + 0.5;
			var y = event.clientY - mainWindow.GetCanvas().getBoundingClientRect().y;
			console.log("x:" + x + "; y:" + y);
			mainWindow.SetCursorPosition(x, y);
			//if(mainWindow.GetStatus() == mainWindow.GetStatusValue().IDLE){
				mainWindow.RaycastHoveredFloor();
			//}
		});
$('#myCanvas').mousedown(function(event) {
    switch (event.which) {
        case 1:
           // if(mainWindow.GetStatus() == mainWindow.GetStatusValue().IDLE){
            	// si le mode est en attente
				console.log(mainWindow.GetHoveredRoom());
            	if(mainWindow.GetHoveredRoom() != -1){
					//alert(mainWindow.GetSelectedFloor().GetRooms()[mainWindow.GetHoveredRoom()].GetName());
            		room1.loadImg(room1.rooms.get(mainWindow.GetSelectedFloor().GetRooms()[mainWindow.GetHoveredRoom()].GetName()))
            		//console.log(mainWindow.GetSelectedFloor().GetRooms()[mainWindow.GetHoveredRoom()].GetName());
            	}
           // }else if(mainWindow.GetStatus() == mainWindow.GetStatusValue().DRAWING_ROOM){
            	// si le mode est en dessin
            	//if(mainWindow.GetCursorToGrid().x!=null){
            		// dessin de la pièce
            		mainWindow.GetCtx().beginPath();// dessin du cercle
            		//mainWindow.GetCtx().arc(GRID_OFFSET.x + mainWindow.GetCursorToGrid().x * GRID_SPACING_POINT,GRID_OFFSET.y + mainWindow.GetCursorToGrid().y * GRID_SPACING_POINT, GRID_CROSS_LENGTH/2, 2*Math.PI, false);
            		mainWindow.GetCtx().strokeStyle = "yellow";
            		mainWindow.GetCtx().stroke();
            		//mainWindow.GetSelectedFloor().PushPointTempRoom(mainWindow.GetCursorToGrid().x,mainWindow.GetCursorToGrid().y);
            	//}
          //  } 

            break;
        case 2:
        	console.log('Middle Mouse button pressed.');
            break;
        case 3:
        	console.log('Right Mouse button pressed.');
        	if(mainWindow.GetStatus() == mainWindow.GetStatusValue().DRAWING_ROOM){
        		// ajout de la pièce
        		if(mainWindow.GetSelectedFloor().AddRoom()){
            		// déssin de la pièce SI la pièce peut être placé
            		mainWindow.DrawSelectedFloor();
            		mainWindow.SetStatus(mainWindow.GetStatusValue().IDLE);        			
        		}

        	}
            break;
        default:
        	console.log('mouse buttun not assigned');
    }
});