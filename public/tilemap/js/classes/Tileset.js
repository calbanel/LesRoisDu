class Tileset{
	constructor(url){

		//Chargement de l'image dans l'attribut image
		this.image = new Image();
		this.image.referenceDuTileset = this;
		this.image.onload = function(){
			if(!this.complete){
				throw new Error("Erreur de chargement du tileset nommé \"" + url + "\".");
			}
			//Largeur du tileset et tile
			this.referenceDuTileset.largeur = this.width / 128;
		
		}	

		this.image.src = assetsBaseDir + 'tilesets/' + url;
	}

	draw(numero, context, map, xDestination, yDestination){
		var xSourceEnTiles = numero % this.largeur;
		if(xSourceEnTiles == 0) xSourceEnTiles = this.largeur;
		var ySourceEnTiles = Math.ceil(numero / this.largeur);
		var xSource = (xSourceEnTiles - 1) * map.TILE_WIDTH;
		var ySource = (ySourceEnTiles - 1) * map.TILE_HEIGHT;
		context.drawImage(this.image, xSource, ySource, map.TILE_WIDTH, map.TILE_HEIGHT, xDestination, yDestination, map.TILE_WIDTH, map.TILE_HEIGHT);

	}

	getIdTile(col, lig, map){
		var id = "undefined";
		if (col>= 0 && col <= map.terrainWidth && lig >= 0 && lig<= map.terrainHeight)
		{
			id = map.terrain[(lig  * map.terrainWidth) + col];
		}

		return id;
       
	}
	
	getNumCase(x, y, map){
		return position = {
			col: Math.floor(x/map.TILE_WIDTH),
			lig: Math.floor(y/map.TILE_HEIGHT)
		}
	}

}

