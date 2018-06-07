var room = {
			rooms:new Map(),
			camera:new THREE.PerspectiveCamera(75, 1, 1, 1100),
			geometry:new THREE.SphereBufferGeometry(500, 60, 40),
			texture:"",
			material:"",
			scene:new THREE.Scene(),
			renderer:new THREE.WebGLRenderer({canvas: document.querySelector("canvas")}),
			mesh:"",
			mouse:new THREE.Vector2(),
			raycaster:new THREE.Raycaster(),
			isUserInteracting:false,
			onMouseDownMouseX :0,
			onMouseDownMouseY :0,
			lon :0,
			onMouseDownLon:0,
			lat :0,
			onMouseDownLat:0,
			phi: 0,
			theta:0,
			clic:false,
			canvas:0,
			
			cameraSet : function()
			{
				this.camera.target = new THREE.Vector3(0, 0, 0);
				this.scene.add(room1.camera);
			},
			
			geometrySet : function()
			{
				this.geometry.scale(-1, 1, 1);
			},
			
			meshSet : function()
			{
				alert(this.rooms.values().next().value);
				this.material= new THREE.MeshBasicMaterial({map: this.rooms.values().next().value,overdraw: 0.5});
				this.mesh = new THREE.Mesh(this.geometry, this.material);
				this.scene.add(this.mesh);
			},

			loadImg : function(path,name)
			{
				this.mesh.material.map = path;
			}			
};

var iboutton
var boutton = {
	rooms:new Map(),
	positionx:"",
	positiony:"",
	positionz:"",
	rotationx:"",
	rotationy:"",
	rotationz:"",
	path:"",
	name:"",
	testClicButton:false,
<<<<<<< HEAD
	bouttonTest : [],
	INTERSECTED:0,
	
	 affichageCube:function(chemin)
	{
		alert("affichage");
		for (var i = 0; i < nombre; i ++)
		{
		//alert("affichagecube");
		if (chemin === this.bouttonTest[i].name)
			{
				room1.scene.add(this.bouttonTest[i]);
				//alert("affichagecube");
				iboutton = i;
				//console.log(boutton1.bouttonTest[iboutton]);
				
				
			}
        else
			{
				room1.scene.remove(this.bouttonTest[i]);
				//alert("Del affichagecube");
			}
		}
	},
	
	raycaste:function(room)
	{
		 if (this.testClicButton)
		{
			room.raycaster.setFromCamera( room.mouse, room.camera );

			var intersects = room.raycaster.intersectObjects( room.scene.children );

			if(room.clic)
			{
			
				room.clic = false;
				if(intersects.length > 0)
				{
				
					if(intersects[ 0 ].object)
					{
					
						if(this.INTERSECTED != intersects[ 0 ].object)
						{
							if ( this.INTERSECTED ){
								this.INTERSECTED.material.emissive.setHex( this.INTERSECTED.currentHex );
							} 
							if(intersects[ 0 ].object.material.emissive)
							{
								//alert("test");
								this.INTERSECTED = intersects[ 0 ].object;
								//text2.innerHTML = INTERSECTED.path;
								alert("raycaste");
								//console.log(this.INTERSECTED.path);
								//console.log(room1.rooms.get(this.INTERSECTED.path));
								this.INTERSECTED = intersects[ 0 ].object;
								this.INTERSECTED.currentHex = this.INTERSECTED.material.emissive.getHex();
								this.INTERSECTED.material.emissive.setHex( 0xffffff );
								room.loadImg(room1.rooms.get(this.INTERSECTED.path), this.INTERSECTED.path);

							}
							else
							{
								this.INTERSECTED = null;
							}
						}
					}
				}
			}
			else
			{
				if(this.INTERSECTED) this.INTERSECTED.material.emissive.setHex(this.INTERSECTED.currentHex);
				this.INTERSECTED = null;
			}
		}
		room.renderer.render(room.scene,room.camera);
	},
	
	getTestClicBoutton : function()
	{
		return this.testClicButton;
	},
	
	getINTERSECTED : function ()
	{
		return this.INTERSECTED;
	},
	
	setTestClicBoutton : function(valeur)
	{
		this.testClicButton = valeur;
	},
	
	setINTERSECTED : function (valeur)
	{
		this.INTERSECTED = valeur;
	}
=======
	boutton:new Array(),
>>>>>>> master
	
};
///////////////////////////////////////////////////////////////////////////
//Listenr d evenements

addEventListener('mousedown',  MouseDown,      false);
addEventListener('mousemove',  MouseMove,      false);
addEventListener('mouseup',    MouseUp,        false);
/////////////////////////////////////////////////////////////////////////
//Creation de l objet room

var room1 = Object.create(room);
var boutton1 = Object.create(boutton);
<<<<<<< HEAD

var triangleShape = new THREE.Shape();
				triangleShape.moveTo( 80, 20 );
				triangleShape.lineTo( 40, 80 );
				triangleShape.lineTo( 120, 80 );
				triangleShape.lineTo( 80, 20 ); // close path

room1.scene.add(triangleShape);
console.log(triangleShape);
=======
var rect
room1.canavs = room1.renderer.domElement;
>>>>>>> master
////////////////////////////////////////////////////////////////////////

//Fonction pour commencer la visite
//Lire XML
getXHR();
//Lancer le menu
initGui();
////////////////////////////////////////////////////////////////////////

room1.renderer.setSize( 1000, 800 );
//document.getElementById('container').appendChild(room1.renderer.domElement);
////////////////////////////////////////////////////////////////////////
//Parametre de la salle
room1.cameraSet();
room1.geometrySet();
room1.meshSet();
//Affichage de la salle
<<<<<<< HEAD
room1.getRenderer().render( room1.getScene(), room1.getCamera() );
console.log(boutton1.bouttonTest[0].name);
if ( boutton1.getTestClicBoutton() === true) room1.scene.add(boutton1.bouttonTest[0]);	
const canvas = room1.getRenderer().domElement;

//Lancer le menu
room1.initGui();
=======
room1.renderer.render( room1.scene, room1.camera );	

/////////////////////////////////////////////////////////////////////////
//Fonction qui mets a jour les valeurs de la camera
function update()
{
    //Mise a jour déplacement verticale
    //room1.lat = Math.max( - 85, Math.min( 85, room1.lat ) );
    room1.phi = THREE.Math.degToRad( 90 - room1.lat );
    room1.theta = THREE.Math.degToRad( room1.lon );

    room1.camera.target.x = 500 * Math.sin( room1.phi ) * Math.cos( room1.theta );
    room1.camera.target.y = 500 * Math.cos( room1.phi );
    room1.camera.target.z = 500 * Math.sin( room1.phi ) * Math.sin( room1.theta );

    //Mets a jour l'affichage de la camera
    room1.camera.lookAt( room1.camera.target );
}
>>>>>>> master

// fonction animate qui s'occupera d'afficher la scène
function animate()
{
	resizeCanvasToDisplaySize();
    requestAnimationFrame(animate);
    update();
    room1.renderer.render(room1.scene, room1.camera);
}

requestAnimationFrame(animate);

//////////////////////////////////////////////////////////////////////////
//FONCTION D EVENEMENTS

function MouseDown( event )
{
	//event.preventDefault();
	//alert("coucou");
	room1.clic = false;
	room1.onMouseDownMouseX = event.clientX;
	room1.onMouseDownMouseY = event.clientY;
	//console.log(onMouseDownMouseX);
	//console.log(onMouseDownMouseY);
	//console.log(canvas.offsetLeft);
	//console.log(canvas.offsetRight);
	///console.log(canvas.clientHeight);
	//console.log(canvas.clientWidth);
	room1.onMouseDownLon = room1.lon;
	room1.onMouseDownLat = room1.lat;
	//console.log("x est :" + event.clientX);
	//console.log("y est :" + event.clientY);
	//console.log("width est :" + canvas.clientWidth);
	//console.log("height est :" + canvas.clientHeight);
	//console.log("fin canvas en x :" + (126 + canvas.clientWidth));
	//console.log("fin canvas en y :" + (174 + canvas.clientHeight));
	if ( rect.x < event.clientX && event.clientX < (rect.x+canvas.clientWidth) && rect.y < event.clientY && event.clientY < (rect.y+canvas.clientHeight))
	{
		isUserInteracting = true;
	}
	console.log(event.clientX);
	console.log(event.clientY);
}

//Fonction qui déplace la caméra si le clic gauche
function MouseMove( event )
{
	if (rect.x < event.clientX && event.clientX < (rect.x+canvas.clientWidth) && rect.y < event.clientY && event.clientY < (rect.y+canvas.clientHeight))
	{
	}
	else{
		isUserInteracting = false;
	}
	
	room1.clic = false;
	//Si clique de la souris enfonce
	
	if ( room1.isUserInteracting === true )
	{
		// Mises a jour des valeurs de la longitude et l latitude
<<<<<<< HEAD
		room1.setLon(( room1.getOnMouseDownMouseX() - event.clientX ) * 0.1 + room1.getOnMouseDownLon());
		room1.setLat(( event.clientY - room1.getOnMouseDownMouseY() ) * 0.1 + room1.getOnMouseDownLat());
		//room1.lon = ( room1.onMouseDownMouseX - event.clientX ) * 0.1 + room1.onMouseDownLon;
		//room1.lat = ( event.clientY - room1.onMouseDownMouseY ) * 0.1 + room1.onMouseDownLat;
		room1.scene.remove(boutton1.bouttonTest[iboutton]);
		//boutton1.bouttonTest[iboutton].position.z =  10;
		//boutton1.bouttonTest[iboutton].position.y =  10;
		room1.scene.add(boutton1.bouttonTest[iboutton]);
		//console.log(boutton1.bouttonTest[iboutton]);
=======
		room1.lon = ( room1.onMouseDownMouseX - event.clientX ) * 0.1 + room1.onMouseDownLon;
		room1.lat = ( event.clientY - room1.onMouseDownMouseY ) * 0.1 + room1.onMouseDownLat;
		
>>>>>>> master
	}
	room1.mouse.x = (( event.clientX / window.innerWidth ) * 2 - 1) ;
	room1.mouse.y = - (( event.clientY / window.innerHeight ) * 2 + 1);
}

//Fonction quand on lâche le clique desactiver le mouvement de la camera
function MouseUp ( event )
{
	room1.clic = true;
	room1.isUserInteracting = false;
}



//////////////////////////////////////////////////////////////////////
function getXHR()
{
	var geometry2 = new THREE.BoxBufferGeometry(10, 10, 10);
    var xmlhttp = "";
    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.open("GET", "http://localhost:8000/visit/" + visit.id + "/visit.xml", false);
    xmlhttp.send();
    const xmlDoc = xmlhttp.responseXML;
    var x = xmlDoc.getElementsByTagName("room");
    var y = xmlDoc.getElementsByTagName("button");
    nombre = x.length;

		var spriteMap = new THREE.TextureLoader().load( "http://localhost:8000/sprite.png" );
		var spriteMaterial = new THREE.SpriteMaterial( { map: spriteMap, color: 0xffffff } );
	
	
    for (var i = 0; i < x.length; i++)
    {
		
        room1.rooms.set(
            x[i].getElementsByTagName("name")[0].childNodes[0].nodeValue,
             new THREE.TextureLoader().load( "http://localhost:8000/visit/" + visit.id + "/" + x[i].getElementsByTagName("url")[0].childNodes[0].nodeValue)
        );
<<<<<<< HEAD
		
		var group = new THREE.Object3D();
		var sprite = new THREE.Sprite( spriteMaterial );
		
				
				
				
       	//var object = new THREE.Mesh( geometry2, new THREE.MeshLambertMaterial( { color: Math.random() * 0xffffff } ) );
        if (x.length === 1)
=======

        var boutton = new THREE.Mesh( geometry2, new THREE.MeshLambertMaterial( { color: Math.random() * 0xffffff } ) );
        if (y.length === 0)
>>>>>>> master
        {

            testClicButton = false;
        }
        else
        {
<<<<<<< HEAD
			//alert("boutton");
            boutton1.setTestClicBoutton(true);
			//profondeur
			object.position.x = 10;
			//hauteur
			object.position.y = 10;
			
			object.position.z = 10;

			object.rotation.x = Math.random() * 2 * Math.PI;
			object.rotation.y = Math.random() * 2 * Math.PI;
			object.rotation.z = Math.random() * 2 * Math.PI;

			object.scale.x = Math.random() ;//Math.random() + 0.5;
			object.scale.y = Math.random() ;//Math.random() + 0.5;
			object.scale.z = Math.random() ;//Math.random() + 0.5;
			object.path = x[i].getElementsByTagName("next")[0].childNodes[0].nodeValue;
			//alert(object.path);
			object.name = x[i].getElementsByTagName("name")[0].childNodes[0].nodeValue;

            //room1.scene.add(object);
            boutton1.bouttonTest.push(object);
			//console.log(boutton1.boutton.name);*/
			
			boutton1.setTestClicBoutton(true);
			
		
		
			/*sprite.scale.set(1, 1, 1);
			sprite.position.set(20, 1, 1);
			sprite.path = x[i].getElementsByTagName("next")[0].childNodes[0].nodeValue;
			sprite.name = x[i].getElementsByTagName("name")[0].childNodes[0].nodeValue;
				
			group.add(sprite);
			boutton1.bouttonTest.push(group);
				
			
			//room1.scene.add(group);*/
=======
            testClicButton = true;

            boutton1.positionx = x[i].getElementsByTagName("positionX")[0].childNodes[0].nodeValue;
            boutton1.positiony = x[i].getElementsByTagName("positionY")[0].childNodes[0].nodeValue;
            boutton1.positionz = x[i].getElementsByTagName("positionZ")[0].childNodes[0].nodeValue;

            boutton1.rotationx = Math.random() * 2 * Math.PI;
            boutton1.rotationy = Math.random() * 2 * Math.PI;
            boutton1.rotationz = Math.random() * 2 * Math.PI;

            boutton1.scalex = Math.random() + 0.5;
            boutton1.scaley = Math.random() + 0.5;
            boutton1.scalez = Math.random() + 0.5;

            boutton1.path = x[i].getElementsByTagName("next")[0].childNodes[0].nodeValue;
            boutton1.name = x[i].getElementsByTagName("name")[0].childNodes[0].nodeValue;
            //object.path = x[i].getElementsByTagName("next")[0].childNodes[0].nodeValue;

            //scene.add(object);
            boutton1.boutton.push(boutton);
>>>>>>> master
        }
		
		//console.log(group);
    }
	
}

function initGui()
{
    var gui = new dat.gui.GUI();
    var obj = { Room: 0 };

    gui.add(obj, 'Room', Array.from(room1.rooms.keys())).onChange(
        function(){
            //text2.innerHTML = obj.Room;
            room1.loadImg(room1.rooms.get(obj.Room),obj.Room);
        }
    );
}

function raycaste()
{
    if (testClicButton)
    {
        raycaster.setFromCamera( mouse, camera );

        var intersects = raycaster.intersectObjects( scene.children );

        if(clic)
        {
            clic = false;
            if(intersects.length > 0)
            {
                if(intersects[ 0 ].object)
                {
                    if(INTERSECTED != intersects[ 0 ].object)
                    {
                        if(intersects[ 0 ].object.material.emissive)
                        {
                            INTERSECTED = intersects[ 0 ].object;
                            text2.innerHTML = INTERSECTED.path;
                            loadImg(rooms.get(INTERSECTED.path), INTERSECTED.path);

                        }
                        else
                        {
                            INTERSECTED = null;
                        }
                    }
                }
            }
        }
        else
        {
            if(INTERSECTED) INTERSECTED.material.emissive.setHex(INTERSECTED.currentHex);
            INTERSECTED = null;
        }
    }
}




function resizeCanvasToDisplaySize(force)
{
    const width = room1.canvas.clientWidth;
    const height = room1.canvas.clientHeight;

    if (force || room1.canvas.width !== width ||room1.canvas.height !== height)
    {
        // you must pass false here or three.js sadly fights the browser
        room1.renderer.setSize(width, height, false);
        camera.aspect = width / height;
        room1.camera.updateProjectionMatrix();
    }
}