
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
	this.colonne + 10,
	this.ligne + 10,
	this.largeur,
	this.hauteur
	);

}

Case.prototype.clicked = function(){
	
	console.log(souris.x);
    var myTop = y;
    var myRgt = x + this.largeur;
    var myBot = y + this.hauteur;
    var myLft = x;
	var clicked = true;
    if(souris.x < myLft || souris.x > myRgt || souris.y < myTop || souris.y > myBot)
    {
        clicked = false;
    }

    return clicked;

}





