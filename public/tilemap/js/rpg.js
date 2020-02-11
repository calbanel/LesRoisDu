var map = new Map("plateau30cases");


var pion = new Pion("pionV1.png", 1, 1)
map.addPion(pion);



window.onload = function() {
	var canvas = document.getElementById('canvas');
	var ctx = canvas.getContext('2d');

	canvas.width  = map.getLargeur();
	canvas.height = map.getHauteur();
	

	setInterval(function() {
	map.dessinerMap(ctx);
	}, 40);

	
	// Gestion du clavier
	window.onkeydown = function(event) {
		var e = event || window.event;
	var key = e.which || e.keyCode;
	
	
	switch(key) {
	case 38 : case 122 : case 119 : case 90 : case 87 : // Flèche haut, z, w, Z, W
		pion.deplacerHaut();
		break;
	case 40 : case 115 : case 83 : // Flèche bas, s, S
		pion.deplacerBas();
		break;
	case 37 : case 113 : case 97 : case 81 : case 65 : // Flèche gauche, q, a, Q, A
		pion.deplacerGauche();
		break;
	case 39 : case 100 : case 68 : // Flèche droite, d, D
		pion.deplacerDroite();
		break;
	default : 
		//alert(key);
		// Si la touche ne nous sert pas, nous n'avons aucune raison de bloquer son comportement normal.
		return true;
	}


	return false;
	}

}
