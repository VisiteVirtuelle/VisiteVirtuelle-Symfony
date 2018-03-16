//Creation des variables
var camera, 
    scene, 
    renderer, 
    mesh,
    sizeImage = 20, 
    isUserInteracting = false,
    onMouseDownMouseX = 0, 
    onMouseDownMouseY = 0,
    lon = 0, onMouseDownLon = 0,
    lat = 0, onMouseDownLat = 0,
    phi = 0, theta = 0;

var rooms = new Map();

getXHR();


init();
animate();

function init()
{
    var container;
    container = document.getElementById( 'visit_viewer' );
    
    // on initialise la camera 
    camera = new THREE.PerspectiveCamera( 75, window.innerWidth/window.innerHeight, 1, 1100 );
    camera.target = new THREE.Vector3( 0, 0, 0 );
    
    // on initialise la scène
    scene = new THREE.Scene();
        
    var geometry = new THREE.SphereBufferGeometry( 500, 60, 40 );
    geometry.scale( -1, 1, 1 );

    // on initialise le moteur de rendu
    renderer = new THREE.WebGLRenderer();
    renderer.setPixelRatio( window.devicePixelRatio );
    renderer.setSize( window.innerWidth/2, window.innerHeight/2  );
    container.appendChild( renderer.domElement );
    
    
    //Creation de la vue 360
    var texture = new THREE.TextureLoader().load("http://localhost:8000/visit/" + visit.id + "/" + rooms.values().next().value);
    var material = new THREE.MeshBasicMaterial( { map: texture,overdraw: 0.5 } );   
    mesh = new THREE.Mesh( geometry, material );
    scene.add( mesh );
    
    //Initialisation du menu
    initGui();

    //Evenement souris 
    addEventListener( 'mousedown',  MouseDown,      false );
    addEventListener( 'mousemove',  MouseMove,      false );
    addEventListener( 'mouseup',    MouseUp,        false );
    addEventListener( 'wheel',      MouseWheel,     false );
    addEventListener( 'resize',     onWindowResize, false );
}



//Fonction qui redimensionne l'affichage de la scene 
function onWindowResize()
{
     //alert("reSize");
     renderer.setSize(window.innerWidth/2 - 20, window.innerHeight/2 - 20);
}

//Clique de la souris enfonce
function MouseDown( event )
{
    //event.preventDefault();
    isUserInteracting = true;
    onMouseDownMouseX = event.clientX;
    onMouseDownMouseY = event.clientY;
    onMouseDownLon = lon;
    onMouseDownLat = lat;
}

//Fonction qui déplace la caméra si le clic gauche
function MouseMove( event ) 
{
    //Si clique de la souris enfonce
    if ( isUserInteracting === true ) 
    {
        // Mises a jour des valeurs de la longitude et l latitude
        lon = ( onMouseDownMouseX - event.clientX ) * 0.1 + onMouseDownLon;
        lat = ( event.clientY - onMouseDownMouseY ) * 0.1 + onMouseDownLat;
    }
}

//Fonction quand on lâche le clique desactiver le mouvement de la camera 
function MouseUp( event ) 
{
    isUserInteracting = false;
}

//Fonction qui gere le controle molette et permet de zoomer ou dezoumer sur une image
function MouseWheel( event ) 
{
    var fov = camera.fov + event.deltaY * 0.05;
    camera.fov = THREE.Math.clamp( fov, 10, 75 );
    camera.updateProjectionMatrix();
}

// fonction animate qui s'occupera d'afficher la scène 
//et de se rappeler elle-même grâce à la fonction requestAnimationFrame.
function animate() 
{
    requestAnimationFrame( animate );
    renderer.render( scene, camera );
    update();
    onresize();
}

//Fonction qui mets a jour les valeurs de la camera
function update()
{
    //Mise a jour déplacement verticale
    lat = Math.max( - 85, Math.min( 85, lat ) );
    phi = THREE.Math.degToRad( 90 - lat );
    theta = THREE.Math.degToRad( lon );
    
    camera.target.x = 500 * Math.sin( phi ) * Math.cos( theta );
    camera.target.y = 500 * Math.cos( phi );
    camera.target.z = 500 * Math.sin( phi ) * Math.sin( theta );
    
    //Mets a jour l'affichage de la camera
    camera.lookAt( camera.target );
    renderer.render( scene, camera );
}

function loadImg(path)
{
    mesh.material.map = THREE.ImageUtils.loadTexture( "http://localhost:8000/visit/" + visit.id + "/" + path );
    mesh.material.needsUpdate = true;   
}

function initGui()
{
    var obj = {
        Room: 0
    };
    
    var gui = new dat.gui.GUI();
    
    gui.add(obj, 'Room', Array.from(rooms.keys())).onChange( 
        function(){
            loadImg(rooms.get(obj.Room));
        }
    );
}

function getXHR()
{
        if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp = new XMLHttpRequest();
} else {// code for IE6, IE5
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
}

xmlhttp.open("GET", "http://localhost:8000/visit/" + visit.id + "/visit.xml", false);
xmlhttp.send();
xmlDoc = xmlhttp.responseXML;
var x = xmlDoc.getElementsByTagName("room");


for ( i = 0; i < x.length; i++)
{
    rooms.set(
        x[i].getElementsByTagName("name")[0].childNodes[0].nodeValue,
        x[i].getElementsByTagName("url")[0].childNodes[0].nodeValue
    );
}
    
}