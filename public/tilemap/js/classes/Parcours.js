class Parcours{
    constructor(nom, map){

        this.casesPosition = new Array();
        this.cases = new Array();
        this.map = map;


    // Création de l'objet XmlHttpRequest
	var xhr = getXMLHttpRequest();

	// Chargement du fichier
	xhr.open("GET", assetsBaseDir +'maps/' + 'defi'+ '.json', false);
	xhr.send(null);
	if(xhr.readyState != 4 || (xhr.status != 200 && xhr.status != 0)) // Code == 0 en local
		throw new Error("Impossible de charger la carte nommée \"" + nom + "\" (code HTTP : " + xhr.status + ").");
	var mapJsonData = xhr.responseText;
	
	// Récupération des données 
    var mapData = JSON.parse(mapJsonData);
    
    this.listeDefis = mapData.defis;

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

        for(var i = 0; i<this.listeDefis.length; i++){
        }
        for(var i = 0; i < positionCases.length; i++){

            this.cases[i] = new Case('Case_128.png',
                                     this.listeDefis[i].defi,
                                     positionCases[i][0],
                                     positionCases[i][1]);

        }
    }
}