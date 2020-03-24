class InputHandler {
    constructor(game) {

        
        //Récupération des éléments cliquable de notre jeu
		var observers = [];

        observers.push(game.dice);

        var pions = game.pions;
        pions.forEach(pion => {
            observers.push(pion);
        });

        var cases = game.parcours.getCases();
        cases.forEach(casess => {
            observers.push(casess);
        });
       

        //Position du clique
        this.sourisX = 0;
        this.sourisY = 0;

        //EVENT LISTENER
        canvas.addEventListener('mousedown', function (event) {
            var rect = canvas.getBoundingClientRect();
            this.sourisX = event.x - rect.left;
            this.sourisY = event.y - rect.top;
            
            if (this.sourisX && this.sourisY) {
                for (let o of observers) {
                    o.updateOnClick(this.sourisX , this.sourisY);
                }

            }
        })

        canvas.addEventListener('mouseup', function (event) {
            this.sourisX = false;
            this.sourisY = false;
        })

    }

}
