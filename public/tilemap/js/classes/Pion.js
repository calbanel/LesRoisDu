class Pion{
	constructor(url, colonne, ligne){
		this.colonne = colonne;
		this.ligne = ligne;
		// Chargement de l'image dans l'attribut image
		this.image = new Image();
		this.image.referenceDuPerso = this;
		this.image.onload = function() {
			if(!this.complete) 
				throw "Erreur de chargement du sprite nommé \"" + url + "\".";
		
			// Taille du pion
			this.referenceDuPerso.largeur = this.width;
			this.referenceDuPerso.hauteur = this.height ;
		}

	this.image.src = assetsBaseDir + "sprites/" + url;
	}

	update(){

	}
	
	draw(context, map) {
		context.drawImage(
		this.image,
		((this.colonne - 1) * map.TILE_WIDTH) + map.TILE_WIDTH / 4,
		((this.ligne - 1) * map.TILE_HEIGHT) + map.TILE_HEIGHT/4,
		this.largeur,
		this.hauteur
		);
	}
	
	
	
	teleporterVersCase(colonne,ligne) {
		this.colonne = colonne;
		this.ligne = ligne;
			
		return true;
	}
	
	
}


