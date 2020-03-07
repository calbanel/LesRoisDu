class InputHandler {
    constructor(game) {

        
        //Récupération des éléments cliquable de notre jeu
		var observers = [];

        observers.push(game.dice);

        var cases = game.parcours.getCases();
        cases.forEach(casess => {
            observers.push(casess);
        });
       
        var pions = game.pions;
        pions.forEach(pion => {
            observers.push(pion);
        })
       

        //Position du clique
        this.sourisX = 0;
        this.sourisY = 0;

        //EVENT LISTENER
        canvas.addEventListener('mousedown', function (event) {
            var rect = canvas.getBoundingClientRect();
            this.sourisX = event.pageX - rect.left;
            this.sourisY = event.pageY - rect.top;

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

    
	addObservers(o){
		this.observers.push(o);
    }
    
    notifyObservers(){
		for (let o of this.observers) {
			o.updateOnClick(this.sourisX , this.sourisY);
		}
	}


}
