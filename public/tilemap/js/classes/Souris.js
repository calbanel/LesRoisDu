function Souris(){

    //Position
    this.x;
    this.y;


}


requestAnimationFrame(gameLoop);
canvas.addEventListener('mousedown', function(event) {
    var rect = canvas.getBoundingClientRect();
    souris.x = event.pageX - rect.left;
    souris.y = event.pageY - rect.top;
        })

canvas.addEventListener('mouseup', function(event) {
    souris.x = false;
    souris.y = false;
        })