var map = new Map("plateau30cases");
var pion = new Pion("pionV1.png", 1, 1);
var cases = new Case("case.png", 20, 20);
map.addCase(cases);
map.addPion(pion);
const GAME_WIDTH =  map.getLargeur();;
const GAME_HEIGHT = map.getHauteur();;


class Game {

    constructor()
    {
	    canvas.width  = GAME_WIDTH;
        canvas.height = GAME_HEIGHT;
        
        this.gameWidth = canvas.width;
        this.gameHeight = canvas.height;
    }

    start(){

    }

    update(deltaTime){
        
    }

    draw(ctx){
        map.draw(ctx);
    }
}