class Parcours {

    constructor(nom, map) {

        this.casesPosition = new Array();
        this.cases = new Array();
        this.map = map;

        this.toolBox = new ToolBox();

        this.jsonMap = this.toolBox.getJsonDefi();
        this.listeDefis = this.jsonMap.defis;

    }

    getCases(){
        return this.cases;
    }

    update() {

    }

    updateOnClick(x , y){
        
        this.cases.forEach(casess => {
            casess.updateOnClick(x,y);
        });
		
	}

    draw(context, map) {

        for (var i = 0; i < this.cases.length; i++) {
            this.cases[i].draw(context, map);
        }

    }

    getPositionCases() {
        var nbLignes = this.map.terrain.length / this.map.terrainWidth;
        var nbColonne = this.map.terrainWidth
        var ligne = 0;
        var colonne = 0;
        for (ligne; ligne < nbLignes; ligne++) {

            for (var colonne = 0; colonne < nbColonne; colonne++) {
                var tuile = this.toolBox.getIdTile(colonne, ligne, this.map);

                if (tuile == 1) {
                    this.casesPosition.push(new Array(colonne, ligne));
                    
                }
            }
        }

        return this.casesPosition;

    }

    creerCasesDuParcours() {

        var positionCases = this.getPositionCases();

        for (var i = 0; i < this.listeDefis.length; i++) {
        }
        for (var i = 0; i < positionCases.length; i++) {

            this.cases[i] = new Case('case_128.png',
                this.listeDefis[i].defi,
                positionCases[i][0],
                positionCases[i][1]);

        }
    }
}