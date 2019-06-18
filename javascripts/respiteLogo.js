/* Javascript elements for the respiteLogo function */

// Draws a logo using the HTML5 canvas element

var drawLogo = function(){

	// Setup
	var canvas = document.getElementById('logo');
	var context = canvas.getContext('2d');
	
	// Scale the drawing
	context.scale(1, 1);
     
	// Draw the Tag Line
	var tagGradient = context.createLinearGradient(0, 250, 0, 290);
	tagGradient.addColorStop(0, '#000052');
	tagGradient.addColorStop(1, '#8585AC');
	context.fillStyle = tagGradient;
	context.strokeStyle = tagGradient;
	context.font = 'bold italic 3.8em sans-serif';
	context.textBaseline = 'top';
	context.fillText('Responsive Web Framework', 0, 250);

	// Draw the Logo First Letter
	var logoFirstLetterGradient = context.createLinearGradient(0, 0, 0, 200);
	logoFirstLetterGradient.addColorStop(0, '#000052');
	logoFirstLetterGradient.addColorStop(1, '#8585AC');
	context.fillStyle = logoFirstLetterGradient;
	context.strokeStyle = logoFirstLetterGradient;
	context.font = 'bold italic 16em sans-serif';
	context.textBaseline = 'bottom';
	context.fillText('R', 0, 260);
	
	// Draw the Logo Remaining Letters
	var logoFirstLetterGradient = context.createLinearGradient(0, 0, 0, 200);
	logoFirstLetterGradient.addColorStop(0, '#000052');
	logoFirstLetterGradient.addColorStop(1, '#8585AC');
	context.fillStyle = logoFirstLetterGradient;
	context.strokeStyle = logoFirstLetterGradient;
	context.font = 'bold italic 13em sans-serif';
	context.textBaseline = 'bottom';
	context.fillText('ESPITE', 185, 249);
	
	// Draw the Line
	context.strokeStyle = '#730000';
	context.lineWidth = 10;
	context.beginPath();
	context.moveTo(15, 225); 
	context.lineTo(960, 225);
	context.stroke();
	context.closePath();
	
	// Draw the Left Arrow
	context.fillStyle = '#730000';
	context.lineWidth = 2;
	context.beginPath();
	context.moveTo(0, 225); 
	context.lineTo(15,210);
	context.lineTo(15, 240);
	context.lineTo(0, 225);
	context.fill();
	context.closePath();

	// Draw the Right Arrow
	context.fillStyle = '#730000';
	context.lineWidth = 2;
	context.beginPath();
	context.moveTo(975, 225); 
	context.lineTo(960,210);
	context.lineTo(960, 240);
	context.lineTo(975, 225);
	context.fill();
	context.closePath();    
     
  };

  
$(function(){
	var canvas = document.getElementById('logo');
	if (canvas.getContext){
		drawLogo();
	}
});



