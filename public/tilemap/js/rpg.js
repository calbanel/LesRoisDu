var map = new Map("plateau30cases");

var pion = new Pion("pionV1.png", 1, 1);
map.addPion(pion);
var souris = new Souris();




window.onload = function() {
	var canvas = document.getElementById('canvas');
	var ctx = canvas.getContext('2d');
	
	canvas.width  = map.getLargeur();
	canvas.height = map.getHauteur();

	canvas.addEventListener('mousedown', function(event) {
		var rect = canvas.getBoundingClientRect();
		souris.x = event.pageX - rect.left;
		souris.y = event.pageY - rect.top;
			})

	canvas.addEventListener('mouseup', function(event) {
		souris.x = false;
		souris.y = false;
			})




	//----------------------------------------------------------------------------------------------------------
	//	AVANCER DE "VALEURDÉ" CASES, SI BOUTON "LANCER DÉ" == TRUE
	//----------------------------------------------------------------------------------------------------------

		
	
	//----------------------------------------------------------------------------------------------------------
	//	ACTUALISATION CONTINUE DE LA MAP
	//----------------------------------------------------------------------------------------------------------
	setInterval(function() {
		map.dessinerMap(ctx);
		
		console.log(souris.x);
		console.log(souris.y);
		if (souris.x && souris.Y){
			
			console.log('clik');
			map.updateMap();
		}
	
	}, 40);

	
	
	//----------------------------------------------------------------------------------------------------------
	//	DECLARATION DU PARCOURS
	//----------------------------------------------------------------------------------------------------------
	var posParcours = 0;	
	//déclaration des cases(colonnes) du parcours en dur en attendant mieux
	var parcoursX = new Array(1,2,3,4,5,6,7,8,9,10,10,10,9,8,7,6,5,4,3,2,1,1,1,2,3,4,5,6,7,8,9,10);
	
	//déclaration des cases(lignes) du parcours en dur en attendant mieux
	var parcoursY = new Array(1,1,1,1,1,1,1,1,1,1,2,3,3,3,3,3,3,3,3,3,3,4,5,5,5,5,5,5,5,5,5,5);
	
	const FINPARCOURS = parcoursX.length - 1;

	
}



//----------------------------------------------------------------------------------------------------------
//	FONCTIONS :
//----------------------------------------------------------------------------------------------------------
function getPosCase(e)
{
	var pos = getMousePos(canvas, e);
	
	var colonneCase = Math.ceil(pos.x / map.TILE_WIDTH) ;
	var ligneCase = Math.ceil(pos.y / map.TILE_HEIGHT) ;
	
	return {
		ligne: ligneCase,
		colonne: colonneCase
	};
	
}
