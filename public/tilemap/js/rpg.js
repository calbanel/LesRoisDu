var map = new Map("plateauHozirontal");


var joueur = new Personnage("hero.png", 2, 2, DIRECTION.BAS)
map.addPersonnage(joueur);


window.onload = function() {
	var canvas = document.getElementById('canvas');
	var ctx = canvas.getContext('2d');

	canvas.width  = map.getLargeur();
	canvas.height = map.getHauteur();
	
	canvas.onclick = function(e) {
		handleClick(e);
	}

	setInterval(function() {
	map.dessinerMap(ctx);
	}, 40);

	
	// Gestion du clavier
	window.onkeydown = function(event) {
		var e = event || window.event;
	var key = e.which || e.keyCode;
	
	
	switch(key) {
	case 38 : case 122 : case 119 : case 90 : case 87 : // Flèche haut, z, w, Z, W
		joueur.deplacer(DIRECTION.HAUT, map);
		break;
	case 40 : case 115 : case 83 : // Flèche bas, s, S
		joueur.deplacer(DIRECTION.BAS, map);
		break;
	case 37 : case 113 : case 97 : case 81 : case 65 : // Flèche gauche, q, a, Q, A
		joueur.deplacer(DIRECTION.GAUCHE, map);
		break;
	case 39 : case 100 : case 68 : // Flèche droite, d, D
		joueur.deplacer(DIRECTION.DROITE, map);
		break;
	default : 
		//alert(key);
		// Si la touche ne nous sert pas, nous n'avons aucune raison de bloquer son comportement normal.
		return true;
	}


	return false;
	}

}

function getMousePos(c, evt)
{
	var rect = c.getBoundingClientRect(); // permet de recupérer que l'espace du canvas pas autour
	return {
		x: evt.clientX - rect.left,
		y: evt.clientY - rect.top
	};
}

function handleClick(e)
{
	var pos = getMousePos(canvas, e);
	posx = pos.x;
	posy = pos.y;
	
	colonneCase = Math.floor(posx / 64) + 1;
	ligneCase = Math.floor(posy / 64) + 1;

	alert("ligneCase : " + ligneCase + "   colonneCase : " + colonneCase);	

}