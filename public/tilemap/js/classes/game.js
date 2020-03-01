class Game {

    constructor()
    {
        this.map = new Map("plateauBlancCase");
        this.parcours = new Parcours("defi", this.map);
        const GAME_WIDTH =  this.map.getLargeur();
        const GAME_HEIGHT = this.map.getHauteur();
	    canvas.width  = GAME_WIDTH;
        canvas.height = GAME_HEIGHT;

        this.pion = new Pion("pion_vert.png", this.map, 0, 0);
        this.dice = new De("de.png", 128, 128);

        

        this.gameWidth = canvas.width;
        this.gameHeight = canvas.height;

        new InputHandler(this);
    }

    start(){
        this.map.addPion(this.pion);
        this.map.setDice(this.dice);
        this.parcours.creerCasesDuParcours();
        this.map.setParcours(this.parcours);
        this.dice.addObservers(this.pion);
        
    }

    update(deltaTime){
        
    }

    draw(ctx){
        this.map.draw(ctx);
    }
}