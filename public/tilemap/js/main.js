	var canvas = document.getElementById('canvas');
	var ctx = canvas.getContext('2d');
	
	

	var game = new Game("plateauBlancCase", "defi");
	
	game.initialize();
	game.load();
	game.start();
	var lastTime = 0;
	function gameLoop(timestamp) {
	  let deltaTime = timestamp - lastTime;
	  lastTime = timestamp;
	
	  ctx.clearRect(0, 0, game.GAME_WIDTH, game.GAME_HEIGHT);
	
	  
	  game.update(deltaTime);
	  game.draw(ctx);
	
	  requestAnimationFrame(gameLoop);
	}
	
	requestAnimationFrame(gameLoop);
