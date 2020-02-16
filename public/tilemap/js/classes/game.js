class Game {

    constructor()
    {
        this.map = new Map("plateau30cases");
        const GAME_WIDTH =  this.map.getLargeur();
        const GAME_HEIGHT = this.map.getHauteur();
	    canvas.width  = GAME_WIDTH;
        canvas.height = GAME_HEIGHT;

        this.pion = new Pion("pionV1.png", 1, 1);
        this.cases = new Case("case.png", 20, 20);;
        

        this.gameWidth = canvas.width;
        this.gameHeight = canvas.height;

        new InputHandler(this.cases, this);
    }

    start(){
        this.map.addCase(this.cases);
        this.map.addPion(this.pion);
    }

    update(deltaTime){
        
    }

    draw(ctx){
        this.map.draw(ctx);
    }
}