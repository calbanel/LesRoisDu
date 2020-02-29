class De{

	constructor(url, x, y){
		this.x = x;
		this.y = y;
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
		var faceDe=Math.random();
		var faceObtenue=Math.ceil(faceDe*4);
		alert("Vous avancez de "+ faceObtenue + " case(s) !");
	}

}

	