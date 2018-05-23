"use strict";
// constantes
const
GRID_OFFSET = {
	x : 20,
	y : 20
};
const
GRID_NB_ROW = 30;
const
GRID_NB_COL = 30;
const
GRID_SPACING_POINT = 9;
const
GRID_CROSS_LENGTH = 2;
// ////////////////////////////D�CLARATION DES
// OBJETS////////////////////////////
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
	this.FindMiddlePoint = function(){
		if(!m_polygone.length)return;
		// ...
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

function Floor() {
	var m_rooms = new Array();
	var m_tempRoom = new Room();
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
		if(m_tempRoom.GetPolygone().length<=2){
			alert("La Pièce doit contenir plus de points !");
			return false;
		}
		m_tempRoom.SetName(prompt('Entrez le nom de la pièce'));
		m_rooms.push(m_tempRoom);
		m_tempRoom = new Room();
		return true;
	};
	this.PushPointTempRoom = function(posx, posy){
		m_tempRoom.PushPolygone({x:posx,y:posy});
	};
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

function WindowCanvas() {
	var m_canvas = document.getElementById("myCanvas");
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
	var m_status = 0;
	var m_statusValue = {
		IDLE : 0,
		DRAWING_ROOM : 1
	};
	var m_selectedFloor = -1;
	var m_hoveredRoom = -1;
	var m_selectedRoom= -1;
	// m�thodes

	this.GetCursorPosition = function() {
		return m_cursorPosition;
	};
	this.GetCanvas = function() {
		return m_canvas;
	};
	this.GetCtx = function() {
		return m_ctx;
	};
	this.GetStatusValue = function(){
		return m_statusValue;
	};
	this.GetStatus = function(){
		return m_status;
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
	this.SetStatus = function(status){
		m_status = status;
	};
	this.SetSelectedRoom = function(){
		m_selectedRoom = m_hoveredRoom;
	};
	this.DrawGrid = function() {
		m_ctx.fillStyle = "SILVER";
		m_ctx.fillRect(GRID_OFFSET.x - GRID_CROSS_LENGTH,
				GRID_OFFSET.y - GRID_CROSS_LENGTH ,
				GRID_SPACING_POINT * GRID_NB_COL + GRID_CROSS_LENGTH /2,
				GRID_SPACING_POINT * GRID_NB_ROW+ GRID_CROSS_LENGTH /2);
		m_ctx.lineWidth = 2;
	    m_ctx.strokeStyle = 'DimGray';
	    // d�ssin de la grille
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
		// affichage du num�ro de l'�tage
		m_ctx.fillStyle = "White";
		m_ctx.fillRect(390, 618, 110,30)
		m_ctx.fillStyle = "Black";
		m_ctx.font = '15px consolas';
		m_ctx.fillText('Étage : ' + ("00" + m_selectedFloor).slice(-2) + "/" + ("00" + (m_floors.length-1)).slice(-2), 390, 638);
		
	};
	
	this.NewFloor = function(){
		if(m_status == m_statusValue.DRAWING_ROOM) return;
		if(m_floors.length>99){
			alert("Vous ne pouvez plus faire d'étage")
			return;
		}
		m_selectedRoom=-1;
		m_floors.splice(++m_selectedFloor, 0, new Floor());
		this.DrawSelectedFloor();
	};
	
	this.DeleteFloor = function(){
		if(m_status == m_statusValue.DRAWING_ROOM) return;
		if(m_floors.length==1){
			alert("Impossible de supprimer cet étage");
			return;
		}
		m_selectedRoom=-1;
		m_floors.splice(m_selectedFloor, 1);
		if(m_selectedFloor) m_selectedFloor--;
		this.DrawSelectedFloor();
	};

	this.NewRoom = function(){
		if(m_status == m_statusValue.DRAWING_ROOM) return;
		m_status = m_statusValue.DRAWING_ROOM;
	}
	this.GetCursorToGrid = function(){
		if(m_cursorPosition.x==null)return;
		var tempPoint = {x : null, y : null};
		tempPoint.x = Math.floor((m_cursorPosition.x - GRID_OFFSET.x + GRID_SPACING_POINT / 2) / GRID_SPACING_POINT);
		tempPoint.y = Math.floor((m_cursorPosition.y - GRID_OFFSET.y + GRID_SPACING_POINT / 2) / GRID_SPACING_POINT);
		if((tempPoint.x<0)||
				(tempPoint.y<0)||
				(tempPoint.x>GRID_NB_COL-1)||
				(tempPoint.y>GRID_NB_ROW-1)
				){
			return {x : null, y : null};
		}
		return tempPoint;
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
		if(m_status == m_statusValue.DRAWING_ROOM) return;
		if(m_selectedFloor==0)return;
		m_selectedRoom=-1;
		m_selectedFloor--;
		this.DrawSelectedFloor();
	};
	this.GoNextFloor = function(){
		if(m_status == m_statusValue.DRAWING_ROOM) return;
		if(m_selectedFloor==m_floors.length-1)return;
		m_selectedRoom=-1;
		m_selectedFloor++;
		this.DrawSelectedFloor();
	};
	this.SetNameSelectedRoom = function(){
		if(m_selectedRoom == -1){
			alert("vous n'avez pas selectionné de pièce");
			return;
		}
		this.GetSelectedFloor().GetRooms()[m_selectedRoom].SetName(prompt("Entrez le nouveau nom de la pièce"));
		this.DrawSelectedFloor();
	};
	this.DeleteSelectedRoom = function(){
		if(m_selectedRoom == -1){
			alert("vous n'avez pas selectionné de pièce");
			return;
		}
		this.GetSelectedFloor().GetRooms().splice(m_selectedRoom, 1);
		m_selectedRoom = -1;
		this.DrawSelectedFloor();
	};
	this.Save = function(){
		var xmlString = "<blueprint>";					//d�but de la balise blueprint
		
		for(var iFloor=0; iFloor<m_floors.length; iFloor++){
			xmlString += "<floor>";							//d�but de la balise floor
			
			var tempRooms = m_floors[iFloor].GetRooms();
			for(var iRoom=0; iRoom<tempRooms.length; iRoom++){
				var tempRoom = tempRooms[iRoom];
				
				xmlString += "<room>" +							//d�but balise room
				"<name>" + tempRoom.GetName() + "</name>"; 			//r�cup�ration du nom
				for(var j=0; j < tempRoom.GetPolygone().length; j++){
					
					xmlString += "<point>" +						//d�but balise point
					"<x>" + tempRoom.GetPolygone()[j].x + "</x>" +		//balise x
					"<y>" + tempRoom.GetPolygone()[j].y + "</y>" +		//balise y
					"</point>";										//fin balise point
				}
				xmlString += "</room>";							//fin balise room
			}
			xmlString += "</floor>";						//fin balise floor
		}
		xmlString += "</blueprint>";					//fin de la balise blueprint
		console.log(xmlString);
	};

	// d�sactivation du menu clique droit
	m_canvas.addEventListener("contextmenu", (event) => {
        event.preventDefault();
    });
	this.DrawSelectedFloor = function(){
		this.DrawGrid();
		m_floors[m_selectedFloor].DrawFloor(m_ctx, m_roomColors);
		// affichage de la pi�ce selectionn�
		m_ctx.fillStyle = "white";
		m_ctx.fillRect(620, 5, 560,30)
		m_ctx.fillStyle = "Black";
		if(m_selectedRoom == -1){
			m_ctx.fillText("Pièce sélectionnée : Aucune pièce sélectionné", 620, 20);
		}else{
			console.log(this.GetSelectedFloor().GetRooms()[m_selectedRoom].GetName());
			m_ctx.fillText("Pièce sélectionnée : " + this.GetSelectedFloor().GetRooms()[m_selectedRoom].GetName(), 620, GRID_OFFSET.y);
		}
	};
}

var mainWindow = new WindowCanvas();
mainWindow.NewFloor();
//mainWindow.DrawSelectedFloor();

$("#myCanvas").mousemove(
		function(event) {
			var m_canvas = document.getElementById('myCanvas'), x = event.pageX
					- m_canvas.offsetLeft, y = event.pageY - m_canvas.offsetTop;
			mainWindow.SetCursorPosition(x, y);
			if(mainWindow.GetStatus() == mainWindow.GetStatusValue().IDLE){
				mainWindow.RaycastHoveredFloor();
			}
		});
$('#myCanvas').mousedown(function(event) {
    switch (event.which) {
        case 1:
            console.log('Left Mouse button pressed.');
            if(mainWindow.GetStatus() == mainWindow.GetStatusValue().IDLE){
            	// si le mode est en attente
            	if(mainWindow.GetHoveredRoom() != -1){
            		mainWindow.SetSelectedRoom();
            		mainWindow.DrawSelectedFloor();
            		// alert("ouai " + mainWindow.GetHoveredRoom());
            	}
            }else if(mainWindow.GetStatus() == mainWindow.GetStatusValue().DRAWING_ROOM){
            	// si le mode est en dessin
            	if(mainWindow.GetCursorToGrid().x!=null){
            		// dessin de la pi�ce
            		mainWindow.GetCtx().beginPath();// dessin du cercle
            		mainWindow.GetCtx().arc(GRID_OFFSET.x + mainWindow.GetCursorToGrid().x * GRID_SPACING_POINT,GRID_OFFSET.y + mainWindow.GetCursorToGrid().y * GRID_SPACING_POINT, GRID_CROSS_LENGTH/2, 2*Math.PI, false);
            		mainWindow.GetCtx().strokeStyle = "yellow";
            		mainWindow.GetCtx().stroke();
            		mainWindow.GetSelectedFloor().PushPointTempRoom(mainWindow.GetCursorToGrid().x,mainWindow.GetCursorToGrid().y);
            	}
            } 

            break;
        case 2:
        	console.log('Middle Mouse button pressed.');
            break;
        case 3:
        	console.log('Right Mouse button pressed.');
        	if(mainWindow.GetStatus() == mainWindow.GetStatusValue().DRAWING_ROOM){
        		// ajout de la pi�ce
        		if(mainWindow.GetSelectedFloor().AddRoom()){
            		// d�ssin de la pi�ce SI la pi�ce peut �tre plac�
            		mainWindow.DrawSelectedFloor();
            		mainWindow.SetStatus(mainWindow.GetStatusValue().IDLE);        			
        		}

        	}
            break;
        default:
        	console.log('mouse buttun not assigned');
    }
});