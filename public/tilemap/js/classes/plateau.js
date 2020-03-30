class Game {

    constructor(url)
    {
        var toolBox = new ToolBox();
        toolBox.requete(url);
    }

    initialize(objRes){
        var nbCases = objRes.nbCases;
        var map = 'plateau_' + nbCases +'_128';
        //Récupération des infos dans les fichiers JSON
        //Récupérations des informations relatives à la map
        //this.map = loadPlateau(this.idPlateau);
        this.map = new Map(map);

        //Récupérations des informations relatives aux défis

        //INITIALISATION DU PLATEAU
        //Récupération des défis
        var casesDuPlateau = objRes.cases;
        var defis = [];

        for (let index = 0; index < casesDuPlateau.length; index++) {
            const element = casesDuPlateau[index];
            defis.push(element.defi);
        }
        this.parcours = new Parcours(defis, this.map);
        this.parcours.creerCasesDuParcours();
        this.cases = this.parcours.getCases();

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
        this.map.setParcours(this.parcours);
        this.gameLoop();
    }

    update(deltaTime){

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
