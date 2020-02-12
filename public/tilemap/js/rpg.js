var map = new Map("plateau30cases");


var pion = new Pion("pionV1.png", 1, 1)
map.addPion(pion);



window.onload = function() {
	var canvas = document.getElementById('canvas');
	var ctx = canvas.getContext('2d');

	canvas.width  = map.getLargeur();
	canvas.height = map.getHauteur();
	
	canvas.onclick = function(e) {
		var caseClick = getPosCase(e);
		
		if (caseClick.ligne == pion.y & caseClick.colonne == pion.x) {
			
		 	if (posParcours != 31) {
				
				posParcours = posParcours + 1;
				pion.teleporterVersCase(parcoursX[posParcours],parcoursY[posParcours]);
				
			}

		}

	}

	setInterval(function() {
	map.dessinerMap(ctx);
	}, 40);

	var posParcours = 0;	
	//déclaration des cases(colonnes) du parcours en dur en attendant mieux
	var parcoursX = new Array(1,2,3,4,5,6,7,8,9,10,10,10,9,8,7,6,5,4,3,2,1,1,1,2,3,4,5,6,7,8,9,10);

	//déclaration des cases(lignes) du parcours en dur en attendant mieux
	var parcoursY = new Array(1,1,1,1,1,1,1,1,1,1,2,3,3,3,3,3,3,3,3,3,3,4,5,5,5,5,5,5,5,5,5,5);



	// // Gestion du clavier
	// window.onkeydown = function(event) {
	// 	var e = event || window.event;
	// var key = e.which || e.keyCode;
	
	
	// switch(key) {
	// case 38 : case 122 : case 119 : case 90 : case 87 : // Flèche haut, z, w, Z, W
	// 	pion.deplacerHaut();
	// 	break;
	// case 40 : case 115 : case 83 : // Flèche bas, s, S
	// 	pion.deplacerBas();
	// 	break;
	// case 37 : case 113 : case 97 : case 81 : case 65 : // Flèche gauche, q, a, Q, A
	// 	pion.deplacerGauche();
	// 	break;
	// case 39 : case 100 : case 68 : // Flèche droite, d, D
	// 	pion.deplacerDroite();
	// 	break;
	// default : 
	// 	//alert(key);
	// 	// Si la touche ne nous sert pas, nous n'avons aucune raison de bloquer son comportement normal.
	// 	return true;
	// }


	// return false;
	// }

}

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
	
	var colonneCase = Math.floor(pos.x / 64) + 1;
	var ligneCase = Math.floor(pos.y / 64) + 1;

	return {
		ligne: ligneCase,
		colonne: colonneCase
	};

}
