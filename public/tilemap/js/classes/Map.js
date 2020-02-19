class Map{
	
	constructor(nom){
		this.nom = nom;
		// Création de l'objet XmlHttpRequest
	var xhr = getXMLHttpRequest();

	// Chargement du fichier
	xhr.open("GET", assetsBaseDir +'maps/' + nom + '.json', false);
	xhr.send(null);
	if(xhr.readyState != 4 || (xhr.status != 200 && xhr.status != 0)) // Code == 0 en local
		throw new Error("Impossible de charger la carte nommée \"" + nom + "\" (code HTTP : " + xhr.status + ").");
	var mapJsonData = xhr.responseText;
	
	// Récupération des données 
	var mapData = JSON.parse(mapJsonData);
	var nomTileSet = 'Octogone.png'
	this.tileset = new Tileset(nomTileSet);

	this.terrain = mapData.layers[0].data;
	this.terrainHeight = mapData.layers[0].height;
	this.terrainWidth = mapData.layers[0].width;

	this.TILE_HEIGHT = mapData.tileheight;
	this.TILE_WIDTH = mapData.tilewidth;

	// Liste des cases présents sur le terrain.
	this.cases = new Array();
	// Liste des pions présents sur le terrain.
	this.pions = new Array();

	this.dice = new Array();
	}

	// Pour ajouter un pion
	addPion (pion) {
		this.pions.push(pion);
	};

	addDe(de){
		this.dice.push(de);
	}

	// Pour ajouter une case
	addCase(casee){
		this.cases.push(casee);
	}

	// Pour récupérer la taille (en tiles) de la carte
	getLargeur() {
		return this.terrainWidth * this.TILE_WIDTH;
	}
	getHauteur() {
		
		return (this.terrain.length / this.terrainWidth) * this.TILE_WIDTH ;	
	}

	
	update(deltaTime){
		// Update des cases
		for(var i = 0, l = this.cases.length ; i < l ; i++) {
			this.cases[i].update(deltaTime);
		}
	}

	draw(context) {
		
		//Dessin du plateau
		var nbLignes = this.terrain.length / this.terrainWidth;
		var ligne = 0;
		var colonne = 0;
		for(ligne; ligne < nbLignes ; ligne++) {
			
			for(var colonne = 0, nbColonne = this.terrainWidth ; colonne < nbColonne ; colonne++) {
				var tuile = this.terrain[(ligne  * nbColonne) + colonne];
				this.tileset.draw(tuile, context, this, colonne * this.TILE_HEIGHT, ligne * this.TILE_HEIGHT);
			}
		}
		
		// Dessin des pions
		for(var i = 0, l = this.pions.length ; i < l ; i++) {
			this.pions[i].draw(context, this);
		}
		

		// Dessin des cases
		for(var i = 0, l = this.cases.length ; i < l ; i++) {
			this.cases[i].draw(context, this);
		}

		// Dessin du dé
		for(var i = 0, l = this.dice.length ; i < l ; i++) {
			this.dice[i].draw(context, this);
		}
		

	}

}	
	