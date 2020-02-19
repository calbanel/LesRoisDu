class De{

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
				
		// Taille de la De
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
			((this.colonne - 1) * map.TILE_WIDTH) + map.TILE_WIDTH,
			((this.ligne - 1) * map.TILE_HEIGHT) + map.TILE_HEIGHT,
			this.largeur,
			this.hauteur
			);
	}

	

	isClicked(sourisX, sourisY) {
		// var myTop = this.ligne;
		// var myRgt = this.colonne + this.largeur;
		// var myBot = this.ligne + this.hauteur;
		// var myLft = this.colonne;
		var clicked = true;
		// if(sourisX < myLft || sourisX > myRgt || sourisY < myTop || sourisY > myBot)
		// {
		// 	clicked = false;
		// }

		if(sourisX != this.colonne || sourisY != this.ligne)
		{
			return false;
		}
		return clicked;

	}
}

	