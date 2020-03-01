class Case {

	constructor(url, defi, colonne, ligne) {
		this.colonne = colonne;
		this.ligne = ligne;
		// Chargement de l'image dans l'attribut image
		this.image = new Image();
		this.image.referenceDuPerso = this;
		this.image.onload = function () {
			if (!this.complete) {
				throw "Erreur de chargement du sprite nommé \"" + url + "\".";
			}

			// Taille de la case
			this.referenceDuPerso.largeur = this.width;
			this.referenceDuPerso.hauteur = this.height;
		}

		this.defi = defi;
		this.image.src = assetsBaseDir + "sprites/" + url;


	}

	update(deltaTime) {

	}

	draw(context, map) {
		context.drawImage(
			this.image,
			((this.colonne - 1) * map.TILE_WIDTH) + map.TILE_WIDTH,
			((this.ligne - 1) * map.TILE_HEIGHT) + map.TILE_HEIGHT,
			this.largeur,
			this.hauteur
		);
	}



	isClicked(col, lig) {
		var clicked = true;
		if (col != this.colonne || lig != this.ligne) {
			return false;
		}
		return clicked;

	}

	displayDefi() {
		alert(this.defi);
	}

}

