class Game {

    constructor()
    {
        this.map = new Map("plateauBlancCase");
        this.parcours = new Parcours("defi", this.map);
        const GAME_WIDTH =  this.map.getLargeur();
        const GAME_HEIGHT = this.map.getHauteur();
	    canvas.width  = GAME_WIDTH;
        canvas.height = GAME_HEIGHT;

        this.pion = new Pion("pion_vert.png", this.map, 1);
        this.pion2 = new Pion("pion_jaune.png", this.map, 2);
        this.pion3 = new Pion("pion_bleu.png", this.map, 3);
        this.pion4 = new Pion("pion_rouge.png", this.map, 4);
        this.dice = new De("de.png", 128, 128);

        

        this.gameWidth = canvas.width;
        this.gameHeight = canvas.height;

        new InputHandler(this);
    }

    start(){

        this.map.addPion(this.pion);
        this.map.addPion(this.pion2);
        this.map.addPion(this.pion3);
        this.map.addPion(this.pion4);

        this.map.setDice(this.dice);
        this.parcours.creerCasesDuParcours();
        this.map.setParcours(this.parcours);

        this.dice.addObservers(this.pion);
        this.dice.addObservers(this.pion2);
        this.dice.addObservers(this.pion3);
        this.dice.addObservers(this.pion4);
        
    }

    update(deltaTime){
        
    }

    draw(ctx){
        this.map.draw(ctx);
    }
}