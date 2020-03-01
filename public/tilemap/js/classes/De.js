class De{

	constructor(url, x, y){
		//Position du dé
		this.x = x;
		this.y = y;

		//Nombre de face du dé
		this.nbFaces = 4;

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
			o.update(this.faceCourante);
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

	