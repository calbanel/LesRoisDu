class Pion{
	constructor(url, x, y){
		//Position dans le canvas
		this.x = x;
		this.y = y;
		//Position dans la map
		this.col = Math.floor(this.x / 128);
		this.lig = Math.floor(this.y / 128);

		//Position du pion avant le déplacement
		this.oldCol = 0;
		this.oldLig = 0;

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
		this.x,
		this.y,
		this.largeur,
		this.hauteur
		);
	}
	
	
	
	teleportToCase(col,lig) {
		this.oldCol = this.col;
		this.oldLig = this.lig;

		this.col = col;
		this.lig = lig;
			
		return true;
	}
	

	isClicked(x, y) {
		var myTop = this.y;
		var myRgt = this.x + this.largeur;
		var myBot = this.y + this.hauteur;
		var myLft = this.x;

		var clicked = true;
		if(y < myTop || y > myBot || x < myLft || x > myRgt)
		{
			return false;
		}
		return clicked;

	}

	getPositionInMap(map){
		this.col = Math.floor(this.x / map.TILE_WIDTH);
		this.lig = Math.floor(this.y / map.TILE_HEIGHT);
		
		return { col: this.col, lig: this.lig};
	}

	getInfoCasesAround(map){
		//On récupère la position du pion dans la map
		var posPion = this.getPositionInMap(map);

		//On récupère la position des cases autour du pion
		var posTop = { col: posPion.col, lig: posPion.lig - 1 }
		var posRgt = { col: posPion.col + 1, lig: posPion.lig }
		var posBot = { col: posPion.col, lig: posPion.lig + 1 }
		var posLft = { col: posPion.col - 1, lig: posPion.lig }

		//On récupère l'ID des cases autour du pion
		var idTop = map.terrain[(posTop.lig * map.terrainWidth) + posTop.col];
		var idRgt = map.terrain[(posRgt.lig * map.terrainWidth) + posRgt.col];
		var idBot = map.terrain[(posBot.lig * map.terrainWidth) + posBot.col];
		var idLft = map.terrain[(posLft.lig * map.terrainWidth) + posLft.col];

		var CasesAround = [
			[{ id: idTop, pos: posTop}],
			[{ id: idRgt, pos: posRgt}],
			[{ id: idBot, pos: posBot}],
			[{ id: idLft, pos: posLft}]
			];

		//On retourne l'ID et la position des cases autour du pion
		return CasesAround;

	}
	
}


