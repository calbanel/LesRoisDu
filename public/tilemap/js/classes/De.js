class De{

	constructor(url, faceDe){
		//Position du dé
		this.x = 128;
		this.y = 128;

		//Nombre de face du dé
		this.nbFaces = faceDe;

		//Face courante
		this.faceCourante = 0;

		//Obervers du dé
		this.observers = [];


		// Chargement de l'image dans l'attribut image
		this.image = new Image();
		this.image.referenceDuPerso = this;
		this.image.onload = function() {
			if(!this.complete) {
				throw "Erreur de chargement du sprite nommé \"" + url + "\".";
			}

		// Taille de la De
		this.referenceDuPerso.largeur = this.width;
		this.referenceDuPerso.hauteur = this.height;


	}

		this.image.src = assetsBaseDir + "sprites/" + url;
	}

	update(){
		this.lancerDe();
		alert('Vous avez obtenu ' + this.faceCourante + '.');

		var pionRouge = JSON.parse(localStorage.getItem('positionPion2'));
		var pionVert = JSON.parse(localStorage.getItem('positionPion1'));
		var pionBleu = JSON.parse(localStorage.getItem('positionPion4'));
		var pionJaune = JSON.parse(localStorage.getItem('positionPion3'));

		var pionstab = [{'couleur': "red", 'placement': pionRouge.positionPion2},{'couleur': "green", 'placement': pionVert.positionPion1},{'couleur': "blue", 'placement': pionBleu.positionPion4},{'couleur': "yellow", 'placement': pionJaune.positionPion3}];

		var jsonString = JSON.stringify({pions: pionstab});

		$.ajax({
	        type: "POST",
	        url: "http://iparla.iutbayonne.univ-pau.fr:8001/api/partie/" + idPartie,
	        data: "$data="+jsonString,
  			success: function() {
            	console.log("Position pions mis à jour");
        	}

    	});

	}

	updateOnClick(x , y){
		if (this.isClicked(x,y)) {
			this.update();
		}
	}

	draw(context, map){
		context.drawImage(
			this.image,
			this.x,
			this.y,
			this.largeur,
			this.hauteur
			);
	}


	addObservers(o){
		this.observers.push(o);
	}

	notifyObservers(){
		for (let o of this.observers) {
			o.updateFaceCourante(this.faceCourante);
		}
	}

	isClicked(x, y) {
		var myTop = this.y;
		var myRgt = this.x + this.largeur;
		var myBot = this.y + this.hauteur;
		var myLft = this.x;

		var clicked = true;
		if(y < myTop || y > myBot || x < myLft || x > myRgt)
		{
			return false;
		}
		return clicked;

	}

	lancerDe(){
		var faceObtenue = Math.floor(Math.random() * this.nbFaces) + 1;
		this.faceCourante = faceObtenue;

		this.notifyObservers();
	}

}
