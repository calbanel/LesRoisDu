class Game {

    constructor()
    {
        this.map = new Map("plateau30cases");
        const GAME_WIDTH =  this.map.getLargeur();
        const GAME_HEIGHT = this.map.getHauteur();
	    canvas.width  = GAME_WIDTH;
        canvas.height = GAME_HEIGHT;

        this.pion = new Pion("pion_rouge.png", 1, 1);
        this.cases = new Case("case.png", 1, 0);
        this.dice = new De("de.png", 0, 1);
        this.parcours = new Parcours(this.map);

        

        this.gameWidth = canvas.width;
        this.gameHeight = canvas.height;

        new InputHandler(this);
    }

    start(){
        this.map.addCase(this.cases);
        this.map.addPion(this.pion);
        this.map.addDe(this.dice);
        this.parcours.getPositionCases();
    }

    update(deltaTime){
        
    }

    draw(ctx){
        this.map.draw(ctx);
    }
}