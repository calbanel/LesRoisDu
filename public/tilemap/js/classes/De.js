class De{

	constructor(faceDe){
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
				throw "Erreur de chargement du sprite";
			}

		// Taille du sprite De
		this.referenceDuPerso.largeur = this.width;
		this.referenceDuPerso.hauteur = this.height;


	}

	this.setSprite(faceDe);

}

	update(){
		this.lancerDe();
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

	setSprite(nbFaceDe){

		switch (nbFaceDe) {
			case 1:
				this.image.src = assetsBaseDir + "sprites/De-1.png";
				break;

			case 2:
				this.image.src = assetsBaseDir + "sprites/De-2.png";
				break;

			case 3:
				this.image.src = assetsBaseDir + "sprites/De-3.png";
				break;

			case 4:
				this.image.src = assetsBaseDir + "sprites/de.png";
				break;

			default:

		}
	}

}
