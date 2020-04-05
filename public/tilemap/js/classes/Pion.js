class Pion {
	constructor(map, player, position, nbCases) {
		//Petit toolBox des familles
		this.toolBox = new ToolBox();

		//Informations de la map
		this.map = map;

		this.nbCases = nbCases;

		this.player = player;
		//Position dans le canvas
		this.setPlayer(player);

		this.setPosition(position);
		this.positionnePionByPositionDansParcours();
		this.updateXandYposition();

		//Position du pion avant le déplacement
		this.oldCol = 0;
		this.oldLig = 0;

		//Prochaine case où il faut se déplacer
		this.nextCol = 0;
		this.nextLig = 0;

		//Etat du pion
		this.isSelected = false;

		//Etat du dé
		this.faceCouranteDe = 0;

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

		this.image.src = assetsBaseDir + "sprites/" + "pion_" + this.couleur + ".png";

	}

	setPlayer(player){

		switch (player) {
			case 1:
				this.posXPlayer = 32 - 32 / 2;
				this.posYPlayer = 32 - 32 / 2;
				this.couleur = 'vert';
				break;

			case 2:
				this.posXPlayer = 96 - 32 / 2;
				this.posYPlayer = 32 - 32 / 2;
				this.couleur = 'rouge';
				break;


			case 3:
				this.posXPlayer = 32 - 32 / 2;
				this.posYPlayer = 96 - 32 / 2;
				this.couleur = 'jaune';
				break;

			case 4:
				this.posXPlayer = 96 - 32 / 2;
				this.posYPlayer = 96 - 32 / 2;
				this.couleur = 'bleu';
				break;

			default:
				alert('Il ne peut exister de joueur ' + player + '.');
				break;
		}
	}

	setPosition(position){
			this.posPion = position;
	}

	update() {

		if (this.isSelected) {
			this.advanceBasedOnPawnValue();
		}

		this.updateXandYposition();
		this.setPositionIntoAPI(this.posPion, this.player);
}
	updateOnClick(x, y) {
		if (this.isClicked(x, y)) {

			this.isSelected = true;
			this.showMeSelected();

		}else{

			this.isSelected = false;
			this.showMeNormally();

		}
	}

	updateFaceCourante(faceCourante) {

		this.faceCouranteDe = faceCourante;
		this.update();

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

	saveOldPosition() {
		console.log("col :"+this.col);
		console.log("lig :"+this.lig);
		console.log("oldCol :"+this.oldCol);
		console.log("oldLig :"+this.oldLig);
		console.log("");
		this.oldCol = this.col;
		this.oldLig = this.lig;
	}

	setCol(col) {
		this.col = col;
	}

	setLig(lig) {
		this.lig = lig;
	}

	teleportToCase(col, lig) {
		//On enregistre l'ancienne position
		this.saveOldPosition();

		//On change de position
		this.setCol(col);
		this.setLig(lig);


	}

	goToNextCase() {

		var casesAround = this.getInfoCasesAround();
		console.log(casesAround);

		casesAround.forEach(caseAround => { //Pour toutes les cases autour du pion

			console.log("case1? :"+(caseAround[0].id == 1));
            console.log("nouv ? :"+!this.isNextCaseWasMyLastOne(caseAround));
			console.log("canva? :"+this.isNextCaseIsActuallyOnTheCanvas(caseAround));
			console.log("");

			if ((caseAround[0].id == 1) && //Si la cases est une case du parcours
				!this.isNextCaseWasMyLastOne(caseAround) && // Et qu'elle n'était pas ma case précédente
				this.isNextCaseIsActuallyOnTheCanvas(caseAround)) { //Et que la case est dans le canvas

				this.nextCol = caseAround[0].pos.col;
				this.nextLig = caseAround[0].pos.lig;

				// console.log("posPion :"+this.posPion);
				// console.log("col :"+this.col);
				// console.log("lig :"+this.lig);
				// console.log("oldCol :"+this.oldCol);
				// console.log("oldLig :"+this.oldLig);
				// console.log("");

			}

		});

		this.teleportToCase(this.nextCol, this.nextLig);

		// console.log("posPion :"+this.posPion);
		// console.log("col :"+this.col);
		// console.log("lig :"+this.lig);
		// console.log("oldCol :"+this.oldCol);
		// console.log("oldLig :"+this.oldLig);
		// console.log("");

	}

	advanceBasedOnPawnValue() {

		if (this.posPion > this.nbCases) {
			alert('STOP ! Vous êtes arrivé au bout du parcours !');
		} else {

			if (this.posPion < this.nbCases ) {

				alert('Vous avez obtenu ' + this.faceCouranteDe + '.');

				for (let i = 0; i < this.faceCouranteDe; i++)
				{
					this.goToNextCase();
					this.posPion = this.posPion + 1;
				}					
			}

			if (this.posPion == this.nbCases) {

				alert('Vous avez obtenu ' + this.faceCouranteDe + '.');

				for (let i = 0; i < this.faceCouranteDe; i++)
				{
					this.goToNextCase();
					this.posPion = this.posPion + 1;
				}	

				alert('Bravo ! Vous avez terminé le parcours !');
			}
		}
	}

	isNextCaseWasMyLastOne(caseAround) {

		console.log(caseAround[0].pos.col);
		console.log(caseAround[0].pos.lig);
		console.log(this.oldCol);
		console.log(this.oldLig);

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

	showMeSelected() {
		this.image.src = assetsBaseDir + "sprites/" + "pion_" + this.couleur + "_selected.png";
	}

	showMeNormally() {
		this.image.src = assetsBaseDir + "sprites/" + "pion_" + this.couleur + ".png";
	}

	getPositionCases() {
			var nbLignes = this.map.terrain.length / this.map.terrainWidth;
			var nbColonne = this.map.terrainWidth
			var ligne = 0;
			var colonne = 0;
			var casesPosition = [];
			for (ligne; ligne < nbLignes; ligne++) {

					for (var colonne = 0; colonne < nbColonne; colonne++) {
							var tuile = this.toolBox.getIdTile(colonne, ligne, this.map);

							if (tuile == 1) {
									 casesPosition.push(new Array(colonne, ligne));
							}
					}
			}
			return casesPosition;
	}

	getInfoCaseCourante(positionPion){
		var positionCases;
		if (positionPion > this.nbCases) {
			return false;
		} else {
			positionCases= this.getPositionCases();
			return positionCases[[positionPion][0]];
		}


	}

	positionnePionByPositionDansParcours(){

		var positionPionCase = (this.getInfoCaseCourante(this.posPion));

		if (positionPionCase) {

			var col = positionPionCase[0];
			var lig = positionPionCase[1];
			this.col = col;
			this.lig = lig;

		}

		if (this.posPion > 0) {

			var positionOldCase = (this.getInfoCaseCourante((this.posPion) - 1));
	
			var oldCol = positionOldCase[0];
			var oldLig = positionOldCase[1];
			this.oldCol = oldCol;
			this.oldLig = oldLig;

		}

		console.log("monPion: "+this.col);
		console.log("monPion: "+this.lig);
		console.log("monPion: "+this.oldCol);
		console.log("monPion: "+this.oldLig);

		// this.col = 0;
		// this.lig = 0;

		// for (var i = 0; i < this.posPion; i++) {

		// 	this.goToNextCase();

		// }
	
	}

	setPositionIntoAPI(position, player){

		if(position > this.nbCases){
			var pos = this.nbCases-1;
		}
		else{
			var pos = position;
		}

		var pionstab = [{'player': player, 'placement': pos}];

		var jsonString = JSON.stringify({pions: pionstab});

		$.ajax({
	        type: "POST",
	        url: parametres,
	        data: "$data="+jsonString
    	});
	}

	updateXandYposition(){
		//On met à jour la position
		this.x = (this.col * this.map.TILE_WIDTH) + this.posXPlayer;
		this.y = (this.lig * this.map.TILE_HEIGHT) + this.posYPlayer;
	}

}
