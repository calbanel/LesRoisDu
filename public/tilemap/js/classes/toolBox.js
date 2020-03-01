/*
Classe SINGLETON
*/
class ToolBox {
    constructor() {

        if (ToolBox.instance instanceof ToolBox) {
            return ToolBox.instance;
        }

        Object.freeze(this);
        ToolBox.instance = this;
    }

    getJsonDefi() {

        // Création de l'objet XmlHttpRequest
        var xhr = getXMLHttpRequest();

        // Chargement du fichier
        xhr.open("GET", assetsBaseDir + 'maps/' + 'defi' + '.json', false);
        xhr.send(null);
        if (xhr.readyState != 4 || (xhr.status != 200 && xhr.status != 0)) // Code == 0 en local
            throw new Error("Impossible de charger la carte nommée \"" + nom + "\" (code HTTP : " + xhr.status + ").");
        var mapJsonData = xhr.responseText;

        // Récupération des données 
        var mapData = JSON.parse(mapJsonData);

        return mapData;

    }

    getJson(nom) {

        // Création de l'objet XmlHttpRequest
        var xhr = getXMLHttpRequest();

        // Chargement du fichier
        xhr.open("GET", assetsBaseDir + 'maps/' + nom + '.json', false);
        xhr.send(null);
        if (xhr.readyState != 4 || (xhr.status != 200 && xhr.status != 0)) // Code == 0 en local
            throw new Error("Impossible de charger la carte nommée \"" + nom + "\" (code HTTP : " + xhr.status + ").");
        var mapJsonData = xhr.responseText;

        // Récupération des données 
        var mapData = JSON.parse(mapJsonData);

        return mapData;

    }

}