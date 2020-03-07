class Pion {
	constructor(url, map, player) {
		//Petit toolBox des familles
		this.toolBox = new ToolBox();

		//Informations de la map
		this.map = map;

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

		//Position dans le canvas
		switch (player) {
			case 1:
				this.posXPlayer = 32 - 32 / 2;
				this.posYPlayer = 32 - 32 / 2;
				break;
		
			case 2: 
				this.posXPlayer = 96 - 32 / 2;
				this.posYPlayer = 32 - 32 / 2;
				break;

			
			case 3: 
				this.posXPlayer = 32 - 32 / 2;
				this.posYPlayer = 96 - 32 / 2;
				break;

			case 4: 
				this.posXPlayer = 96 - 32 / 2;
				this.posYPlayer = 96 - 32 / 2;
				break;

			default:
				alert('Il ne peut exister de joueur ' + player + '.');
				break;
		}

		this.x = this.posXPlayer;
		this.y = this.posYPlayer;
		

		//Position dans la map
		this.col = this.toolBox.convertXtoCol(this.x, this.map.TILE_WIDTH);
		this.lig = this.toolBox.convertXtoCol(this.y, this.map.TILE_HEIGHT);

		//Position du pion avant le déplacement
		this.oldCol = 0;
		this.oldLig = 0;

		//Prochaine case où il faut se déplacer
		this.nextCol = 0;
		this.nextLig = 0;

		//Etat du pion
		this.isSelected = false;


		
	}

	update(diceFace) {

		if (this.isSelected) {
			var nbCaseTogo = diceFace;

			for (let i = 0; i < nbCaseTogo; i++) {

						this.goToNextCase();
				
			}

			this.isSelected = false;
			
		}


	}

	draw(context) {
		context.drawImage(
			this.image,
			(((this.col - 1) * this.map.TILE_HEIGHT) + this.map.TILE_HEIGHT) + this.posXPlayer,
			(((this.lig - 1) * this.map.TILE_HEIGHT) + this.map.TILE_HEIGHT) + this.posYPlayer,
			this.largeur,
			this.hauteur
		);
	}

	isClicked(x, y) {
		var myTop = this.y;
		var myRgt = this.x + this.largeur;
		var myBot = this.y + this.hauteur;
		var myLft = this.x;

		var clicked = true;
		if (y < myTop || y > myBot || x < myLft || x > myRgt) {
			clicked = false;
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
		var idTop = this.toolBox.getIdTile(posTop.col, posTop.lig, this.map);
		var idRgt = this.toolBox.getIdTile(posRgt.col, posRgt.lig, this.map);
		var idBot = this.toolBox.getIdTile(posBot.col, posBot.lig, this.map);
		var idLft = this.toolBox.getIdTile(posLft.col, posLft.lig, this.map);

		var CasesAround = [
			[{ id: idTop, pos: posTop }],
			[{ id: idRgt, pos: posRgt }],
			[{ id: idBot, pos: posBot }],
			[{ id: idLft, pos: posLft }]
		];

		//On retourne l'ID et la position des cases autour du pion
		return CasesAround;

	}

	saveOldPosition(){
		this.oldCol = this.col;
		this.oldLig = this.lig;
	}

	setCol(col){
		this.col = col;
	}

	setLig(lig){
		this.lig = lig;
	}
	
	teleportToCase(col, lig) {
		//On enregistre l'ancienne position
		this.saveOldPosition();

		//On change de position
		this.setCol(col);
		this.setLig(lig);

		//On met à jour la position
		this.x = (this.col * this.map.TILE_WIDTH) + this.posXPlayer;
		this.y = (this.lig * this.map.TILE_HEIGHT) + this.posYPlayer;
	}

	goToNextCase() {

		var casesAround = this.getInfoCasesAround();

		casesAround.forEach(caseAround => { //Pour toutes les cases autour du pion

			if (caseAround[0].id == 1 && //Si la cases est une case du parcours
				!this.isNextCaseWasMyLastOne(caseAround) && // Et qu'elle n'était pas ma case précédente
				this.isNextCaseIsActuallyOnTheCanvas(caseAround)) { //Et que la case est dans le canvas

				this.nextCol = caseAround[0].pos.col; //
				this.nextLig = caseAround[0].pos.lig;

			}

		});

		this.teleportToCase(this.nextCol, this.nextLig);

	}

	isNextCaseWasMyLastOne(caseAround) {

		if (caseAround[0].pos.col == this.oldCol &&
			caseAround[0].pos.lig == this.oldLig) {
			return true;
		} else {
			return false;
		}
	}

	isNextCaseIsActuallyOnTheCanvas(caseAround) {

		if (caseAround[0].pos.col >= 0 &&
			caseAround[0].pos.col <= this.map.terrainWidth - 1 &&
			caseAround[0].pos.lig >= 0 &&
			caseAround[0].pos.lig <= this.map.terrainHeight - 1) {

			return true;
		} else {
			return false;
		}
	}

	showIsSelected(){
		this.image.src = assetsBaseDir + "sprites/" + "pion_rouge.png";
	}

	showMeNormally(){
		this.image.src = assetsBaseDir + "sprites/" + "pion_vert.png"
	}



}


