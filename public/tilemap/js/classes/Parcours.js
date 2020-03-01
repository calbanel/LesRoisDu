class Parcours {

    constructor(nom, map) {

        this.casesPosition = new Array();
        this.cases = new Array();
        this.map = map;

        this.toolBox = new ToolBox();

        this.jsonMap = this.toolBox.getJsonDefi();
        this.listeDefis = this.jsonMap.defis;

    }

    update(col, lig) {
        for (var i = 0; i < this.cases.length; i++) {
            if (this.cases[i].isClicked(col, lig)) {
                this.cases[i].displayDefi();
            }
        }
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
                var tuile = this.map.terrain[(ligne * nbColonne) + colonne];

                if (tuile == 1) {
                    this.casesPosition.push(new Array(colonne, ligne));
                }
            }
        }

        return this.casesPosition;

    }

    creerCasesDuParcours() {

        var positionCases = this.getPositionCases();

        var defi = 'defi n°'

        for (var i = 0; i < this.listeDefis.length; i++) {
        }
        for (var i = 0; i < positionCases.length; i++) {

            this.cases[i] = new Case('Case_128.png',
                this.listeDefis[i].defi,
                positionCases[i][0],
                positionCases[i][1]);

        }
    }
}