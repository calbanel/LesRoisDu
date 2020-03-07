class Game {

    constructor()
    {
        //Notre map map
        this.map = new Map("plateauBlancCase");
        //Notre parcours
        this.parcours = new Parcours("defi", this.map);
        this.parcours.creerCasesDuParcours();

        const GAME_WIDTH =  this.map.getLargeur();
        const GAME_HEIGHT = this.map.getHauteur();
	    canvas.width  = GAME_WIDTH;
        canvas.height = GAME_HEIGHT;

        //Nos pions
        this.pions = [];
        this.pions.push(new Pion(this.map, 1));
        this.pions.push(new Pion(this.map, 2));
        this.pions.push(new Pion(this.map, 3));
        this.pions.push(new Pion(this.map, 4));

        //Nos cases
        this.cases = this.parcours.getCases();

        //Notre dé
        this.dice = new De("de.png", 128, 128);

        

        this.gameWidth = canvas.width;
        this.gameHeight = canvas.height;

        new InputHandler(this);
    }

    start(){

        this.pions.forEach(pion => {
            this.map.addPion(pion);

            this.cases.forEach(casess => {
                casess.addPionObserved(pion);
            })
            
        });

        this.map.setDice(this.dice);
        this.map.setParcours(this.parcours);

        this.pions.forEach(pion => {
            this.dice.addObservers(pion);
        });
        
    }

    update(deltaTime){
        
    }

    draw(ctx){
        this.map.draw(ctx);
    }
}