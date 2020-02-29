class Pion{
	constructor(url, x, y){
		//Position dans le canvas
		this.x = x;
		this.y = y;
		//Position dans la map
		this.col = Math.floor(this.x / 128);
		this.lig = Math.floor(this.y / 128);

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

	getPositionInMap(){
		this.col = Math.floor(this.x / 128);
		this.lig = Math.floor(this.y / 128);
		
		return { col: this.col, lig: this.lig};
	}

	getIdCaseAround(map){
		var posPion = this.getPositionInMap();
		var tabId = new Array();


		var caseTop = { col: posPion.col, lig: posPion.lig - 1 }
		var caseRgt = { col: posPion.col + 1, lig: posPion.lig }
		var caseBot = { col: posPion.col, lig: posPion.lig + 1 }
		var caseLft = { col: posPion.col - 1, lig: posPion.lig }

		var idTop = map.terrain[(caseTop.lig * map.terrainWidth) + caseTop.col];
		var idRgt = map.terrain[(caseRgt.lig * map.terrainWidth) + caseRgt.col];
		var idBot = map.terrain[(caseBot.lig * map.terrainWidth) + caseBot.col];
		var idLft = map.terrain[(caseLft.lig * map.terrainWidth) + caseLft.col];

		tabId.push(idTop);
		tabId.push(idRgt);
		tabId.push(idBot);
		tabId.push(idLft);

		return tabId;

	}
	
}


