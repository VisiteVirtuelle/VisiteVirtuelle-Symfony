var room = {
			rooms:new Map(),
			camera:new THREE.PerspectiveCamera(75, 1, 1, 1100),
			geometry:new THREE.SphereBufferGeometry(500, 60, 40),
			texture:"",
			material:"",
			scene:new THREE.Scene(),
			renderer:new THREE.WebGLRenderer({canvas: document.getElementById("canvasVue")}),
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
			
			getClic : function()
			{
				return this.clic;
			},
			
			getRooms : function()
			{
				return this.rooms;
			},
			
			getCamera : function()
			{
				return this.camera;
			},
			
			getGeometry : function()
			{
				return this.geometry;
			},
			
			getTexture : function()
			{
				return this.texture;
			},
			
			getMaterial : function()
			{
				return this.material;
			},
			
			getScene : function()
			{
				return this.scene;
			},
			
			getRenderer : function()
			{
				return this.renderer;
			},
			
			getMesh : function()
			{
				return this.mesh;
			},
			
			getMouse : function()
			{
				return this.mouse;
			},
			
			getRaycaster : function()
			{
				return this.raycaster;
			},
			
			getIsUserInteracting : function()
			{
				return this.isUserInteracting;
			},
			
			getOnMouseDownMouseY : function()
			{
				return this.onMouseDownMouseY;
			},
			
			getOnMouseDownMouseX : function()
			{
				return this.onMouseDownMouseX;
			},
			
			getLon : function()
			{
				return this.lon;
			},
			
			getOnMouseDownLon : function()
			{
				return this.onMouseDownLon;
			},
			
			getLat : function()
			{
				return this.lat;
			},
			
			getTheta : function()
			{
				return this.theta;
			},
			
			getPhi : function()
			{
				return this.phi;
			},
			
			getOnMouseDownLat : function()
			{
				return this.onMouseDownLat;
			},
			///////////////////////////////////////////////////
			
			setClic : function(valeur)
			{
				this.clic = valeur;
			},
			
			setRooms : function(valeur)
			{
				 this.rooms= valeur;
			},
			
			setCamera : function(valeur)
			{
				 this.camera= valeur;
			},
			
			setGeometry : function(valeur)
			{
				 this.geometry= valeur;
			},
			
			setTexture : function(valeur)
			{
				 this.texture= valeur;
			},
			
			setMaterial : function(valeur)
			{
				 this.material= valeur;
			},
			
			setScene : function(valeur)
			{
				 this.scene= valeur;
			},
			
			setRenderer : function(valeur)
			{
				 this.renderer= valeur;
			},
			
			setMesh : function(valeur)
			{
				 this.mesh= valeur;
			},
			
			setMouseX : function(valeur)
			{
				 this.mouse.x= valeur;
			},
			
			setMouseY : function(valeur)
			{
				 this.mouse.y= valeur;
			},
			
			setRaycaster : function(valeur)
			{
				 this.raycaster= valeur;
			},
			
			setIsUserInteracting : function(valeur)
			{
				 this.isUserInteracting= valeur;
			},
			
			setOnMouseDownMouseY : function(valeur)
			{
				 this.onMouseDownMouseY= valeur;
			},
			
			setOnMouseDownMouseX : function(valeur)
			{
				 this.onMouseDownMouseX= valeur;
			},
			
			setLon : function(valeur)
			{
				 this.lon= valeur;
			},
			
			setOnMouseDownLon : function(valeur)
			{
				 this.onMouseDownLon= valeur;
			},
			
			setOnMouseDownLat : function(valeur)
			{
				 this.onMouseDownLat= valeur;
			},
			
			setLat : function(valeur)
			{
				 this.lat= valeur;
			},
			
			setTheta : function(valeur)
			{
				 this.theta= valeur;
			},
			
			setPhi : function(valeur)
			{
				 this.phi= valeur;
			},
			
			cameraSet : function()
			{
				this.camera.target = new THREE.Vector3(0, 0, 0);
				this.scene.add(this.camera);
			},
			
			geometrySet : function()
			{
				this.geometry.scale(-1, 1, 1);
			},
			
			meshSet : function()
			{
				//alert(this.rooms.values().next().value);
				this.material= new THREE.MeshBasicMaterial({map: this.rooms.values().next().value,overdraw: 0.5});
				this.mesh = new THREE.Mesh(this.geometry, this.material);
				this.scene.add(this.mesh);
			},

			loadImg : function(path,name,boutton)
			{
				this.mesh.material.map = path;
				boutton.affichageCube(name);
			},
				
			update : function()
			{
				//Mise a jour déplacement verticale
				this.lat = Math.max( - 85, Math.min( 85, this.lat ) );
				this.phi = THREE.Math.degToRad( 90 - this.lat );
				this.theta = THREE.Math.degToRad( this.lon );

				this.camera.target.x = 500 * Math.sin( this.phi ) * Math.cos( this.theta );
				this.camera.target.y = 500 * Math.cos( this.phi );
				this.camera.target.z = 500 * Math.sin( this.phi ) * Math.sin( this.theta );

				//Mets a jour l'affichage de la camera
				this.camera.lookAt( this.camera.target );
				this.renderer.render( this.scene, this.camera );
			},
			
			/*animate : function(boutton)
			{
				requestAnimationFrame(this.animate);
				this.update();
				boutton.raycaste(this);
				this.renderer.render(this.scene, this.camera);
			}*/
			
			initGui : function()
			{
				var gui = new dat.gui.GUI();
				var obj = { Room: 0 };

				var tempThis = this
				gui.add(obj, 'Room', Array.from(this.rooms.keys())).onChange
				(
					function()
					{
						//text2.innerHTML = obj.Room;
						//console.log(this.);
						tempThis.loadImg(tempThis.rooms.get(obj.Room),obj.Room);
					}
				);
			}
};

var boutton = {
	rooms:new Map(),
	testClicButton:false,
	bouttonTest : [],
	INTERSECTED:0,
	
	 affichageCube:function(chemin)
	{
		for (var i = 0; i < nombre; i ++)
		{
		//alert("affichagecube");
		if (chemin === this.bouttonTest[i].name)
			{
				room1.scene.add(this.bouttonTest[i]);
				//alert("affichagecube");
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
						
							if(intersects[ 0 ].object.material.emissive)
							{
								//alert("test");
								this.INTERSECTED = intersects[ 0 ].object;
								//text2.innerHTML = INTERSECTED.path;
								alert("raycaste");
								console.log(this.INTERSECTED.path);
								console.log(room1.rooms.get(this.INTERSECTED.path));
								room.loadImg(room1.rooms.get(this.INTERSECTED.path), this.INTERSECTED.path,this);

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
	
};
///////////////////////////////////////////////////////////////////////////
//Listenr d evenements

addEventListener('mousedown',  MouseDown,      false);
addEventListener('mousemove',  MouseMove,      false);
addEventListener('mouseup',    MouseUp,        false);
/////////////////////////////////////////////////////////////////////////
//Creation de l objet room

var room1 =  Object.create(room);
var boutton1 = Object.create(boutton);



////////////////////////////////////////////////////////////////////////

//Fonction pour commencer la visite
//Lire XML
getXHR();

////////////////////////////////////////////////////////////////////////

room1.getRenderer().setSize( 1000, 800 );
//document.getElementById('container').appendChild(room1.renderer.domElement);
////////////////////////////////////////////////////////////////////////

//Parametre de la salle
room1.cameraSet();
room1.geometrySet();
room1.meshSet();

//Affichage de la salle
room1.getRenderer().render( room1.getScene(), room1.getCamera() );
if ( boutton1.getTestClicBoutton() === true) boutton1.affichageCube(boutton1.bouttonTest[0].name);	
const canvas = room1.getRenderer().domElement;


//Lancer le menu
room1.initGui();

// fonction animate qui s'occupera d'afficher la scène
function animate()
{
    requestAnimationFrame(animate);
    room1.update();
	boutton1.raycaste(room1);
    room1.renderer.render(room1.getScene(), room1.getCamera());
}

requestAnimationFrame(animate);

//////////////////////////////////////////////////////////////////////////
//FONCTION D EVENEMENTS

function MouseDown( event )
{
	room1.setClic(false);
	room1.setOnMouseDownMouseX(event.clientX);
	room1.setOnMouseDownMouseY(event.clientY);
	room1.setOnMouseDownLon(room1.getLon());
	room1.setOnMouseDownLat(room1.getLat());
	
	if ( 126 < event.clientX && event.clientX < (126+canvas.clientWidth) && 174 < event.clientY && event.clientY < (174+canvas.clientHeight))
	{
		room1.setIsUserInteracting(true);
	}
}

//Fonction qui déplace la caméra si le clic gauche
function MouseMove( event )
{
	room1.setClic(false);
	//Si clique de la souris enfonce
	
	if ( room1.getIsUserInteracting() === true )
	{
		// Mises a jour des valeurs de la longitude et l latitude
		room1.setLon(( room1.getOnMouseDownMouseX() - event.clientX ) * 0.1 + room1.getOnMouseDownLon());
		room1.setLat(( event.clientY - room1.getOnMouseDownMouseY() ) * 0.1 + room1.getOnMouseDownLat());
		//room1.lon = ( room1.onMouseDownMouseX - event.clientX ) * 0.1 + room1.onMouseDownLon;
		//room1.lat = ( event.clientY - room1.onMouseDownMouseY ) * 0.1 + room1.onMouseDownLat;
		
	}
	room1.setMouseX(( event.clientX / window.innerWidth ) * 2 - 1) ;
	room1.setMouseY(( event.clientY / window.innerHeight ) * 2 + 1);
}

//Fonction quand on lâche le clique desactiver le mouvement de la camera
function MouseUp ( event )
{
	room1.setClic(true);
	room1.setIsUserInteracting(false);
}



//////////////////////////////////////////////////////////////////////
function getXHR()
{
	var geometry2 = new THREE.BoxBufferGeometry(20, 20, 20);
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

    for (var i = 0; i < x.length; i++)
    {
		
        room1.getRooms().set(
            x[i].getElementsByTagName("name")[0].childNodes[0].nodeValue,
            new THREE.TextureLoader().load("http://localhost:8000/visit/" + visit.id + "/" + x[i].getElementsByTagName("url")[0].childNodes[0].nodeValue)
        );

       	var object = new THREE.Mesh( geometry2, new THREE.MeshLambertMaterial( { color: Math.random() * 0xffffff } ) );
        if (y.length === 0)
        {

            boutton1.setTestClicBoutton(false);
			
        }
        else
        {
			//alert("boutton");
            boutton1.setTestClicBoutton(true);
			object.position.x = 10;
			object.position.y = 10;
			object.position.z = 10;

			object.rotation.x = Math.random() * 2 * Math.PI;
			object.rotation.y = Math.random() * 2 * Math.PI;
			object.rotation.z = Math.random() * 2 * Math.PI;

			object.scale.x = 0.5;//Math.random() + 0.5;
			object.scale.y = 0.5;//Math.random() + 0.5;
			object.scale.z = 0.5;//Math.random() + 0.5;
			object.path = x[i].getElementsByTagName("next")[0].childNodes[0].nodeValue;
			//alert(object.path);
			object.name = x[i].getElementsByTagName("name")[0].childNodes[0].nodeValue;

            //room1.scene.add(object);
            boutton1.bouttonTest.push(object);
			//console.log(boutton1.boutton.name);
        }
    }
}

