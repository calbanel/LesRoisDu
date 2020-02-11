function Tileset(url){
	//Chargement de l'image dans l'attribut image
	this.image = new Image();
	this.image.referenceDuTileset = this;
	this.image.onload = function(){
		if(!this.complete){
			throw new Error("Erreur de chargement du tileset nommé \"" + url + "\".");
		}
		//Largeur du tileset et tile
		this.referenceDuTileset.largeur = this.width / 64;
		
	}
	this.image.src = assetsBaseDir + 'tilesets/' + url;
}

//Méthode de dessin du tile numéro "numero" dans le contexte 2D "context" aux doordonnées x et y 
Tileset.prototype.dessinerTile = function(numero, context, xDestination, yDestination){
		var xSourceEnTiles = numero % this.largeur;
		if(xSourceEnTiles == 0) xSourceEnTiles = this.largeur;
		var ySourceEnTiles = Math.ceil(numero / this.largeur);
		var xSource = (xSourceEnTiles - 1) * 64;
		var ySource = (ySourceEnTiles - 1) * 64;
		context.drawImage(this.image, xSource, ySource, 64, 64, xDestination, yDestination, 64, 64);

}