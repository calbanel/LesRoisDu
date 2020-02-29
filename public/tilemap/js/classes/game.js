class Game {

    constructor()
    {
        this.map = new Map("plateauBlancCase");
        const GAME_WIDTH =  this.map.getLargeur();
        const GAME_HEIGHT = this.map.getHauteur();
	    canvas.width  = GAME_WIDTH;
        canvas.height = GAME_HEIGHT;

        this.pion = new Pion("pion_rouge.png", 10, 10);
        this.dice = new De("de.png", 128, 128);
        this.parcours = new Parcours("defi", this.map);

        

        this.gameWidth = canvas.width;
        this.gameHeight = canvas.height;

        new InputHandler(this);
    }

    start(){
        this.map.addPion(this.pion);
        this.map.setDice(this.dice);
        this.parcours.creerCasesDuParcours();
        this.map.setParcours(this.parcours);
    }

    update(deltaTime){
        
    }

    draw(ctx){
        this.map.draw(ctx);
    }
}