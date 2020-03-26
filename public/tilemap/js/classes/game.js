class Game {

    constructor(url)
    {

        var toolBox = new ToolBox();
        toolBox.requete(url);

    }

    initialize(objRes){

        var nbCases = 27;
        var map = 'plateau_' + nbCases +'_128';
        //Récupération des infos dans les fichiers JSON
        //Récupérations des informations relatives à la map
        //this.map = loadPlateau(this.idPlateau);
        this.map = new Map(map);

        //Récupérations des informations relatives aux défis

        //Initialisation du plateau
        this.parcours = new Parcours("defi", this.map);
        this.parcours.creerCasesDuParcours();

        //Nos cases
        this.cases = this.parcours.getCases();

        //Initialisation du/des pion(s)
        this.pions = [];
        this.nombrePion = 2;
        for (let index = 1; index < this.nombrePion + 1; index++) {
            
            this.pions.push(new Pion(this.map, index));
            
        }

        //Initialisation du dé
        this.dice = new De("de.png", 7);

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