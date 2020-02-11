function Map(nom) {
	
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

	this.tileHeight = mapData.tileheight;
	this.tileWidth = mapData.tilewidth;

	// Liste des personnages présents sur le terrain.
	this.personnages = new Array();
	
	// Pour ajouter un personnage
	Map.prototype.addPersonnage = function(perso) {
		this.personnages.push(perso)
	};
	
	
	// Pour récupérer la taille (en tiles) de la carte
	Map.prototype.getLargeur = function() {
		return this.terrainWidth * this.tileWidth;
	}
	Map.prototype.getHauteur = function() {
		
		return (this.terrain.length / this.terrainWidth) * this.tileWidth ;	
	}

	
	Map.prototype.dessinerMap = function(context) {
		
		//Dessin du plateau
		var nbLignes = this.terrain.length / this.terrainWidth;
		var ligne = 0;
		var colonne = 0;
		for(ligne; ligne < nbLignes ; ligne++) {
			
			for(var colonne = 0, nbColonne = this.terrainWidth ; colonne < nbColonne ; colonne++) {
				var tuile = this.terrain[(ligne  * nbColonne) + colonne];
				this.tileset.dessinerTile(tuile, context, colonne * this.tileHeight, ligne * this.tileHeight);
			}
		}
		
		// Dessin des personnages
		for(var i = 0, l = this.personnages.length ; i < l ; i++) {
			this.personnages[i].dessinerPersonnage(context);
		}

	}

}
