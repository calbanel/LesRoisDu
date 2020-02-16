class InputHandler {
    constructor(cases, game) {
      
        this.sourisX = 0;
        this.sourisY =0;

        canvas.addEventListener('mousedown', function(event) {
            var rect = canvas.getBoundingClientRect();
            this.sourisX = event.pageX - rect.left;
            this.sourisY = event.pageY - rect.top;

            if(this.sourisX && this.sourisY){
                    var id = game.map.tileset.getIdTile(this.sourisX, this.sourisY, game.map);
                    console.log(id);

                    switch(id){
                        case 1:
                            alert('Ceci est une case');
                            break;
                        case 2: 
                            alert('Ceci n\'est pas une case');
                            break;
                        default:
                            alert('Je sais même pas où t\'as cliqué');
                    }
            }
        })
        
        canvas.addEventListener('mouseup', function(event) {
            this.sourisX = false;
            this.sourisY = false;
        })
      
    }

    
  }
  