class InputHandler {
    constructor(cases, game) {
      
        canvas.addEventListener('mousedown', function(event) {
            var rect = canvas.getBoundingClientRect();
            var sourisX = event.pageX - rect.left;
            var sourisY = event.pageY - rect.top;

            if(sourisX && sourisY){
                if(cases.clicked(sourisX, sourisY)){
                    alert("ALERT PD");
                }
            }
                })
        
        canvas.addEventListener('mouseup', function(event) {
            souris.x = false;
            souris.y = false;
                })
  
      
    }
  }
  