
function Case(url, colonne, ligne)
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
		this.referenceDuPerso.hauteur = this.height;
	}

	this.image.src = assetsBaseDir + "sprites/" + url;

}

Case.prototype.dessinerCase = function(context, map) {
	context.drawImage(
	this.image,
	((this.colonne - 1) * map.TILE_WIDTH) + map.TILE_WIDTH / 4,
	((this.ligne - 1) * map.TILE_HEIGHT) + map.TILE_HEIGHT/4,
	this.largeur,
	this.hauteur
	);
}

Case.prototype.clicked = function(mouseInfo){
    var myTop = y;
    var myRgt = x + this.largeur;
    var myBot = y + this.hauteur;
    var myLft = x;
    var clicked = true;
    if(mouseInfo.x < myLft || mouseInfo.x > myRgt || mouseInfo.y < myTop || mouseInfo.y > myBot)
    {
        clicked = false;
    }

    return clicked;

}






