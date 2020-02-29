class Pion {
	constructor(url, map, x, y) {
		//Informations de la map
		this.map = map;

		//Position dans le canvas
		this.x = x;
		this.y = y;
		//Position dans la map
		this.col = this.convertXtoCol();
		this.lig = this.convertYtoLig();

		//Position du pion avant le déplacement
		this.oldCol = 0;
		this.oldLig = 0;

		//Prochaine case où il faut se déplacer
		this.nextCol = 0;
		this.nextLig = 0;
		

		// Chargement de l'image dans l'attribut image
		this.image = new Image();
		this.image.referenceDuPerso = this;
		this.image.onload = function () {
			if (!this.complete)
				throw "Erreur de chargement du sprite nommé \"" + url + "\".";

			// Taille du pion
			this.referenceDuPerso.largeur = this.width;
			this.referenceDuPerso.hauteur = this.height;
		}

		this.image.src = assetsBaseDir + "sprites/" + url;
	}

	update() {
		console.log('Ma position en col : ' + this.col);
		console.log('Ma position en lig : ' + this.lig);
		this.goToNextCase();
		console.log('Ma position en col : ' + this.col);
		console.log('Ma position en lig : ' + this.lig);
	}

	draw(context) {
		context.drawImage(
			this.image,
			((this.col - 1) * this.map.TILE_HEIGHT) + this.map.TILE_HEIGHT,
			((this.lig - 1) * this.map.TILE_HEIGHT) + this.map.TILE_HEIGHT,
			this.largeur,
			this.hauteur
		);
	}

	convertXtoCol(){
		return this.col = Math.floor(this.x / this.map.TILE_WIDTH);
		
	}
	
	convertYtoLig(){
		return this.lig = Math.floor(this.y / this.map.TILE_HEIGHT);
	}
	
	isClicked(x, y) {
		var myTop = this.y;
		var myRgt = this.x + this.largeur;
		var myBot = this.y + this.hauteur;
		var myLft = this.x;

		var clicked = true;
		if (y < myTop || y > myBot || x < myLft || x > myRgt) {
			return false;
		}
		return clicked;

	}

	getPositionInMap() {
		return { col: this.col, lig: this.lig };
	}

	getInfoCasesAround() {
		//On récupère la position du pion dans la map
		var posPion = this.getPositionInMap();

		//On récupère la position des cases autour du pion
		var posTop = { col: posPion.col, lig: posPion.lig - 1 }
		var posRgt = { col: posPion.col + 1, lig: posPion.lig }
		var posBot = { col: posPion.col, lig: posPion.lig + 1 }
		var posLft = { col: posPion.col - 1, lig: posPion.lig }

		//On récupère l'ID des cases autour du pion
		var idTop = this.map.terrain[(posTop.lig * this.map.terrainWidth) + posTop.col];
		var idRgt = this.map.terrain[(posRgt.lig * this.map.terrainWidth) + posRgt.col];
		var idBot = this.map.terrain[(posBot.lig * this.map.terrainWidth) + posBot.col];
		var idLft = this.map.terrain[(posLft.lig * this.map.terrainWidth) + posLft.col];


		var CasesAround = [
			[{ id: idTop, pos: posTop }],
			[{ id: idRgt, pos: posRgt }],
			[{ id: idBot, pos: posBot }],
			[{ id: idLft, pos: posLft }]
		];

		//On retourne l'ID et la position des cases autour du pion
		return CasesAround;

	}

	teleportToCase(col, lig) {
		//On enregistre l'ancienne position
		this.oldCol = this.col;
		this.oldLig = this.lig;

		//On change de position
		this.col = col;
		this.lig = lig;

		//On met à jour la position
		this.x = this.col * this.map.TILE_WIDTH;
		this.y = this.lig * this.map.TILE_HEIGHT;

		return true;
	}

	goToNextCase(){

		var casesAround = this.getInfoCasesAround();

		casesAround.forEach(caseAround => {
			if (caseAround[0].id == 1 && 
				!this.isNextCaseWasMyLastOne(caseAround) &&
				this.isNextCaseIsActuallyOnTheCanvas(caseAround)) {

				this.nextCol = caseAround[0].pos.col;
				this.nextLig = caseAround[0].pos.lig;


			}

		});

		this.teleportToCase(this.nextCol, this.nextLig);

	}
	
	isNextCaseWasMyLastOne(caseAround){
		if (caseAround[0].pos.col == this.oldCol &&
			caseAround[0].pos.lig == this.oldLig) {
			return true;
		}else{
			return false;
		}
	}

	isNextCaseIsActuallyOnTheCanvas(caseAround){

		if (caseAround[0].pos.col >= 0 &&
			caseAround[0].pos.col <= this.map.terrainWidth && 
			caseAround[0].pos.lig >= 0 &&
			caseAround[0].pos.lig <= this.map.terrainHeight){

			return true;
		}else{
			return false;
		}
	}

}


