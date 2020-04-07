class Game {

    constructor(url)
    {
        var toolBox = new ToolBox();
        toolBox.requete(url);
    }

    initialize(objRes){
        var nbCases = objRes.plateau_de_jeu.nbCases + 1;
        var map = 'plateau_' + nbCases +'_128';
        //Récupération des infos dans les fichiers JSON
        //Récupérations des informations relatives à la map
        //this.map = loadPlateau(this.idPlateau);
        this.map = new Map(map);

        //Récupérations des informations relatives aux défis

        //INITIALISATION DU PLATEAU
        //Récupération des défis
        var casesDuPlateau = objRes.plateau_de_jeu.cases;
        var defis = [];

        const caseDepart = "Case départ, pas de défi !";
        defis.push(caseDepart);

        for (let index = 0; index < casesDuPlateau.length; index++) {
            const element = casesDuPlateau[index];
            defis.push(element.defi);
        }
        this.parcours = new Parcours(defis, this.map);
        this.parcours.creerCasesDuParcours();
        //Nos cases
        this.cases = this.parcours.getCases();

        //INITIALISATION DU/DES PIONS(S)
        var nbPion = objRes.nbPionsParPlateau;
        var lesPions = objRes.plateau_de_jeu.pions;
        this.pions = [];
        for (let index = 0; index < nbPion; index++) {

            this.pions.push(new Pion(this.map, this.parcours, lesPions[index].player, lesPions[index].position, nbCases));

        }

        //INITIALISATION DU DE
        var nbFacesDe = objRes.nbFacesDe;
        this.dice = new De(nbFacesDe);

        //Gestionnaire d'évênement
        new InputHandler(this);

        const GAME_WIDTH =  this.map.getLargeur();
        const GAME_HEIGHT = this.map.getHauteur();
	    canvas.width  = GAME_WIDTH;
        canvas.height = GAME_HEIGHT;


        game.start();
    }

    load()
    {

    }

    start(){

        this.pions.forEach(pion => {
            //Ajout des pion à la map pour pouvoir les dessiner
            this.map.addPion(pion);

            //Chaque case observe l'état des pions
            this.cases.forEach(casess => {
                casess.addPionObserved(pion);
            })

        });

        this.map.setDice(this.dice);
        this.map.setParcours(this.parcours);

        //Chaque pion observe l'état du dé
        this.pions.forEach(pion => {
            this.dice.addObservers(pion);
        });

        this.gameLoop();

    }

    update(deltaTime){
        this.pions.forEach(pion => {
            pion.updatePos();
        });
        // fetch(parametres)
		// .then(response => {
		// 	return response.json()
		// })
		// .then(data => {
		// 	for (var i = 0; i < nbPion; i++) {
		// 		var posPion = data["plateau_de_jeu"]["pions"][i]["position"];
		// 		console.log("pos "+i+" : "+posPion);
		// 		// game.map.pions[i].setPosition(posPion);
		// 	}
		// })
    }

    draw(ctx){
        this.map.draw(ctx);
    }

    gameLoop() {
        var lastTime = 0;
        function gameLoop(timestamp) {
          let deltaTime = timestamp - lastTime;
          lastTime = timestamp;

          ctx.clearRect(0, 0, game.GAME_WIDTH, game.GAME_HEIGHT);

          game.update(deltaTime);
          
          game.draw(ctx);

          requestAnimationFrame(gameLoop);
        }

        requestAnimationFrame(gameLoop);

    }
}
