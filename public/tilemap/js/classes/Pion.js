
function Pion(url, x, y)
{

	this.x = x;
	this.y = y;
	// Chargement de l'image dans l'attribut image
	this.image = new Image();
	this.image.referenceDuPerso = this;
	this.image.onload = function() {
		if(!this.complete) 
			throw "Erreur de chargement du sprite nommé \"" + url + "\".";
		
		// Taille du personnage
		this.referenceDuPerso.largeur = this.width;
		this.referenceDuPerso.hauteur = this.height ;
	}

	this.image.src = assetsBaseDir + "sprites/" + url;

}

Pion.prototype.dessinerPion = function(context, map) {
	context.drawImage(
	this.image,
	((this.x - 1) * map.TILE_WIDTH) + map.TILE_WIDTH / 4,
	((this.y - 1) * map.TILE_HEIGHT) + map.TILE_HEIGHT/4,
	this.largeur,
	this.hauteur
	);
}
	
Pion.prototype.deplacerHaut = function() {
		
	// On effectue le déplacement
	this.y = this.y - 1;
		
	return true;
}

Pion.prototype.deplacerDroite = function() {
		
	// On effectue le déplacement
	this.x = this.x + 1;
		
	return true;
}

Pion.prototype.deplacerBas = function() {
		
	// On effectue le déplacement
	this.y = this.y + 1;
		
	return true;
}

Pion.prototype.deplacerGauche = function() {
		
	// On effectue le déplacement
	this.x = this.x - 1;
		
	return true;
}





