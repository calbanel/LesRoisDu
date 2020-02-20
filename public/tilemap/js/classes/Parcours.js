class Parcours{
    constructor(map){

        this.casesPosition = new Array();
        this.map = map;



    }

    update(deltaTime){

    }
    
    draw(context, map){
		//Dessine toutes les cases du parcours
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
        
        console.log(this.casesPosition);
        return this.casesPosition;

    }


}