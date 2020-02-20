class Parcours{
    constructor(map){

        this.casesPosition = new Array();
        this.cases = new Array();
        this.map = map;



    }

    update(deltaTime){

    }
    
    draw(context, map){
        
        for(var i = 0; i< this.cases.length; i++){
            this.cases[i].draw(context, map);
        }
        
    }
    
    getPositionCases(){
        var nbLignes = this.map.terrain.length / this.map.terrainWidth;
        var nbColonne = this.map.terrainWidth
		var ligne = 0;
		var colonne = 0;
		for(ligne; ligne < nbLignes ; ligne++) {
			
			for(var colonne = 0 ; colonne < nbColonne ; colonne++) {
                var tuile = this.map.terrain[(ligne  * nbColonne) + colonne];

                if(tuile == 1){
                    this.casesPosition.push(new Array(colonne, ligne));
                }
			}
        }

        return this.casesPosition;

    }

    creerCasesDuParcours(){

        var positionCases = this.getPositionCases();

        var defi = 'defi n°'

        for(var i = 0; i < positionCases.length; i++){

            this.cases[i] = new Case('case.png', defi + i,
                                     positionCases[i][0],
                                     positionCases[i][1]);

        }
    }
}