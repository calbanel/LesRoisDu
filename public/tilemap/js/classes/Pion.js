
function Pion(url, colonne, ligne)
{

	this.colonne = colonne;
	this.ligne = ligne;
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
	((this.colonne - 1) * map.TILE_WIDTH) + map.TILE_WIDTH / 4,
	((this.ligne - 1) * map.TILE_HEIGHT) + map.TILE_HEIGHT/4,
	this.largeur,
	this.hauteur
	);
}
	
Pion.prototype.deplacerHaut = function() {
		
	// On effectue le déplacement
	this.ligne = this.ligne - 1;
		
	return true;
}

Pion.prototype.deplacerDroite = function() {
		
	// On effectue le déplacement
	this.colonne = this.colonne + 1;
		
	return true;
}

Pion.prototype.deplacerBas = function() {
		
	// On effectue le déplacement
	this.ligne = this.ligne + 1;
		
	return true;
}

Pion.prototype.deplacerGauche = function() {
		
	// On effectue le déplacement
	this.colonne = this.colonne - 1;
		
	return true;
}

Pion.prototype.teleporterVersCase = function(colonne,ligne) {
		
	this.colonne = colonne;
	this.ligne = ligne;
		
	return true;
}




