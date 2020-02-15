class Case{

	constructor(url, colonne, ligne){
		this.colonne = colonne;
		this.ligne = ligne;
		// Chargement de l'image dans l'attribut image
		this.image = new Image();
		this.image.referenceDuPerso = this;
		this.image.onload = function() {
			if(!this.complete) {
				throw "Erreur de chargement du sprite nommé \"" + url + "\".";
			}
				
		// Taille de la case
		this.referenceDuPerso.largeur = this.width;
		this.referenceDuPerso.hauteur = this.height;
	}

		this.image.src = assetsBaseDir + "sprites/" + url;
	}

	update(deltaTime){

	}

	draw(context, map){
		context.drawImage(
		this.image,
		this.colonne,
		this.ligne,
		this.largeur,
		this.hauteur
		);
	}

	

	clicked(sourisX, sourisY) {
		var myTop = this.ligne;
		var myRgt = this.colonne + this.largeur;
		var myBot = this.ligne + this.hauteur;
		var myLft = this.colonne;
		var clicked = true;
		if(sourisX < myLft || sourisX > myRgt || sourisY < myTop || sourisY > myBot)
		{
			clicked = false;
		}

		return clicked;

	}
}

	