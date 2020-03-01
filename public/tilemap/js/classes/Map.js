class Map {

	constructor(nom) {

		this.toolBox = new ToolBox();


		var mapData = this.toolBox.getJson(nom)

		var nomTileSet = 'Octogone_128.png'
		this.tileset = new Tileset(nomTileSet);

		this.terrain = mapData.layers[0].data;
		this.terrainHeight = mapData.layers[0].height;
		this.terrainWidth = mapData.layers[0].width;

		this.TILE_HEIGHT = mapData.tileheight;
		this.TILE_WIDTH = mapData.tilewidth;

		// Liste des pions présents sur le terrain.
		this.pions = new Array();

		this.dice = new De();

		this.parcours = new Parcours();


	}

	// Pour ajouter un pion
	addPion(pion) {
		this.pions.push(pion);
	};

	setDice(dice) {
		this.dice = dice;
	}

	setParcours(parcours) {
		this.parcours = parcours;
	}


	// Pour récupérer la taille (en tiles) de la carte
	getLargeur() {
		return this.terrainWidth * this.TILE_WIDTH;
	}
	getHauteur() {
		return (this.terrain.length / this.terrainWidth) * this.TILE_WIDTH;
	}


	update(deltaTime) {
		// Update des cases
		for (var i = 0, l = this.cases.length; i < l; i++) {
			this.cases[i].update(deltaTime);
		}
	}

	draw(context) {

		//Dessin du plateau
		var nbLignes = this.terrain.length / this.terrainWidth;
		var ligne = 0;
		var colonne = 0;
		for (ligne; ligne < nbLignes; ligne++) {

			for (var colonne = 0, nbColonne = this.terrainWidth; colonne < nbColonne; colonne++) {
				var tuile = this.terrain[(ligne * nbColonne) + colonne];
				this.tileset.draw(tuile, context, this, colonne * this.TILE_HEIGHT, ligne * this.TILE_HEIGHT);
			}
		}

		this.dice.draw(context, this);

		this.parcours.draw(context, this);

		// Dessin des pions
		for (var i = 0, l = this.pions.length; i < l; i++) {
			this.pions[i].draw(context);
		}


	}

}
