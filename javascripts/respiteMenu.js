/* Javascript elements for the respiteMenu function */

// For javascript enabled browsers moves the menu bar to the left on the screen



var mainForm = document.getElementById("mainForm")

// When page initially loads check window size and move menu bar if appropriate
if(window.innerWidth > 1023){
//	document.body.insertBefore(document.getElementById("menuBar"), document.getElementById("appPanelOuter"));
   mainForm.insertBefore(document.getElementById("menuBar"), document.getElementById("appPanelOuter"));
}

// When page is resized move menu bar if appropriate

window.onresize=function() {
	if(window.innerWidth > 1023){
		mainForm.insertBefore(document.getElementById("menuBar"), document.getElementById("appPanelOuter"));
	}
	else {
		mainForm.insertBefore(document.getElementById("menuBar"), document.getElementById("footer"));
	}
}
