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
		souris.x = event.pageX;
		souris.y = event.pageY;
		console.log(souris.x);
		console.log(souris.y);
			})

	canvas.addEventListener('mouseup', function(event) {
		souris.x = false;
		souris.y = false;
		console.log('nie');
			})

			
	//----------------------------------------------------------------------------------------------------------
	//	DEPLACEMENT DU PION AU CLIQUE
	//----------------------------------------------------------------------------------------------------------
	// canvas.onclick = function(e) {
	// 	var caseClick = getPosCase(e);
	
	// 	if (caseClick.ligne == pion.y & caseClick.colonne == pion.x) {
	
	// 		posParcours = posParcours + 1; 
	
	// 		if (posParcours > FINPARCOURS) {
	
	// 			pion.teleporterVersCase(parcoursX[FINPARCOURS],parcoursY[FINPARCOURS]);
	
	// 		}
	// 		else
	// 		{
	// 			pion.teleporterVersCase(parcoursX[posParcours],parcoursY[posParcours]);
	// 		}
	
	// 	}
	
	// }



	//----------------------------------------------------------------------------------------------------------
	//	AVANCER DE "VALEURDÉ" CASES, SI BOUTON "LANCER DÉ" == TRUE
	//----------------------------------------------------------------------------------------------------------
	var valeurDé = sessionStorage.getItem("valeurDé");
	var clique = "false";	
	
	setInterval(function(){

		valeurDé = sessionStorage.getItem("valeurDé");
		clique = sessionStorage.getItem("clique");

		if (clique == "true") {
			
			posParcours = posParcours + parseInt(valeurDé); 
			
			if (posParcours > FINPARCOURS) {
				
				pion.teleporterVersCase(parcoursX[FINPARCOURS],parcoursY[FINPARCOURS]);
				
			}
			else
			{
				pion.teleporterVersCase(parcoursX[posParcours],parcoursY[posParcours]);
			}

			sessionStorage.setItem("clique","false");
		}

	}, 100);

		
	
	//----------------------------------------------------------------------------------------------------------
	//	ACTUALISATION CONTINUE DE LA MAP
	//----------------------------------------------------------------------------------------------------------
	setInterval(function() {
		map.dessinerMap(ctx);
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



	//----------------------------------------------------------------------------------------------------------
	// TEST PARCOURS AUTO
	//----------------------------------------------------------------------------------------------------------
	// var maMap = Array();
	// for (var ligne = 1; ligne < map.terrainHeight ; ligne++) {
	
	// 	for (var colonne = 1 < map.terrainWidth ; colonne++) {
	
	// 		maMap.push()
	
	// 	}
	
	// }
	
}



//----------------------------------------------------------------------------------------------------------
//	FONCTIONS :
//----------------------------------------------------------------------------------------------------------

function getMousePos(c, evt)
{
	var rect = c.getBoundingClientRect(); // permet de recupérer que l'espace du canvas pas autour
	return {
		x: evt.clientX - rect.left,
		y: evt.clientY - rect.top
	};
}

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
