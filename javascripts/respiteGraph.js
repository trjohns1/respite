/* Javascript elements for the respiteGraph function */

// Place the following line in the scripts section of your html document:
//     <script type="application/javascript" src="javascripts/respiteGraph.js"></script>

// Note the naming convention that must be followed in the HTML document.
// The value of "graphName" uniquely identifies each graph on a page
// Use diferent values of "graphName" for multiple graphs on the same page.
// "graphName" must be appended to the appropriate identifier for each element as specifified below:
// graphName        : used in the function call to respiteGraph
// graphName-button : used to identify the id attribute of a button that initiates the function call to respiteGraph
// graphName-canvas : used to specify the id attribute of the location where the canvas will be created
// graphName-header : used to identify the id attribute the axis label information
// graphName-data   : identifies the name attribute of the element containing data to graph

// the graphName-header element should contain the following additional data elements.
// data-xAxis          : contains the label for the x axis
// data-yAxis          : contains the label for the y axis
// data-barColor       : color of bar in valid HTML format (e.g. "#FF0000)
// data-margin         : width of margin (in pixels) inside of canvas
// data-barLabelPerc   : percent width of the bar label section in relation to the graph. Allows more space for text. (0-100)
// data-legendSize     : legend text size (in ems). Eg. ".5" means 50% size.
// data-barSize        : width of the bar (in pixels)

// the graphName-data element should contain two additional data elements. This is the actual data to graph
// data-name   : identifies the name portion of the data associated with graphName-header
// data-value  : identifies the value portion of the data associated with graphName-header

// This naming convention identifies each element that respiteGraph needs to function and includes the 
// data marked up in HTML5 data- attributes.
// Thus, the entire markup for the data can be hidden from the user's view.
// Or, the an HTML-only version of the data can be marked up in a table, list or other format
// Style the graph with the css class "respiteGraphCanvas"




// -----------------------------------------------------------------------------------------------------
// Main function for respiteGraph
// -----------------------------------------------------------------------------------------------------

function respiteGraph(graph)
{

	//Constants
	em = 10; // size (in pixels) of one em
	canvasWidth = 1000;
	
	// -- First check to see if valid HTML markup is present --
	checkHTMLDoc(graph);

	// -- Next get headers and data from HTML document, but return if markup is invalid --

	// Get headers from HTML document. If getHeaders produces an error, print error message and return
	var headers = new Array();
	headers = getHeaders(graph);
	if(!headers)
	{
		// Print error message and return
		alert('Error getting headers (metadata) from HTML document. Cannot display graph.');
		return false;
	}
	
	// Read data from HTML document. If getData produces an error, print error message and return
	var data = new Object();
	data = getData(graph);
	if(!data)
	{
		// Print error message and return
		alert('Error getting data from HTML document. Cannot display graph.');
		return false;
	}

	
		
	// -- HTML markup appears valid --
	// -- headers and data now contain headers and data as array objects --

	
	//If the graph is already displayed, hide it
	if((document.getElementById(graph + "-button").innerHTML)=="Hide Graph")
	{
		// Change the button label
		document.getElementById(graph + "-button").innerHTML="Show Graph";
		// Destroy the canvas
		document.getElementById(graph + "-canvas").innerHTML="";
	}
	// Else if the graph is not currently displayed, show it.
	else
	{
		// Change the button label
		document.getElementById(graph + "-button").innerHTML="Hide Graph";


		// -- Create the canvas --
				
		// unpack headers
		margin = Number(headers[3]); // canvas inner margin (in pixels)
		barLabelPerc = Number(headers[4]); // percentage of canvas used for legend
		legendSize = Number(headers[5]); // size of legend text (in ems)
		barSize = Number(headers[6]); // size of bars (in pixels)

		// Calculate dimensions
		legendMargin = (legendSize * 1 * em);
		barGutter = (barSize / 2);
		canvasHeight = ((barSize * data.length) + (barGutter * 2 * data.length) + (legendSize * em) + (legendMargin * 2) + (margin * 2));

		// Calculate data min and max values
		// extract data values from the two dimensional data array
		var values = new Array();
		for(var i = 0; i < data.length; i++) {
		values[i] = data[i][1];
		}
		values = values.sort(function(a,b){return b-a});
		dataMax = values[0];
		dataMin = values[values.length-1];
		
		// Create canvas HTML string
		var canvasString = '<canvas class="respiteGraphCanvas" id="respiteGraphCanvas-'
		canvasString += graph;
		canvasString += '" width="';
		canvasString += canvasWidth;
		canvasString += '" height="';
		canvasString += canvasHeight;
		canvasString += '">Your browser does not support the HTML canvas feature necessary to display this graph.</canvas>';

		// Create the canvas
		document.getElementById(graph + "-canvas").innerHTML=canvasString;


		// Create a copy of data to use for scaling
		var dataScaled = new Array();
		for(var i=0; i < data.length; i++)
		{
			dataScaled[i]=new Array(2); // allow each row of dataSet to hold an array of length 2
		}

		for(var i=0; i<data.length; i++) {
			dataScaled[i][0] = data[i][0];
			dataScaled[i][1] = data[i][1];
		}
		
		// create frameData object to hold information about the animation parameters
		var frameData = new Object();
		frameData.numFrames = 10; // number of frames in the animation
		frameData.currentFrame = 0; // counter that identifies which frame is currently being drawn
		frameData.interval = 30; // framerate in milliseconds

		// call the animation routing at regular intervals until complete
		var animationCycle = setInterval(function() {animate(graph, headers, data, dataMax, dataMin, dataScaled, frameData)}, frameData.interval);

		// set a cycle to stop the animation
		var animationStopCheck = frameData.interval * frameData.numFrames * 10;
		var animationStopCycle = setInterval(function(){animationStop(animationCycle)}, animationStopCheck);
	}
}











// -----------------------------------------------------------------------------------------------------
// Checks that the HTML document has the basic components to support the graph
// -----------------------------------------------------------------------------------------------------

function checkHTMLDoc(graph)
{
	// Check to see if there is a -button element
	if(!(document.getElementById(graph + "-button")))
	{
		// Print error message and return
		alert('Error getting graph button. Cannot display graph.');
		return false;
	}

	// Check to see if there is a -canvas element
	if(!(document.getElementById(graph + "-canvas")))
	{
		// Print error message and return
		alert('Error getting canvas attribute. No document location identified for graph.');
		return false;
	}
}








// -----------------------------------------------------------------------------------------------------
// Reads headers out of HTML document and returns them in an array
// Returns null if an error was encountered
// -----------------------------------------------------------------------------------------------------

function getHeaders(graph)
{
	// If header id attribute is not present return false
	if(!(headerElement=document.getElementById(graph + '-header')))
	{
		return null;
	}

	var headers= new Array();
	
	if(!(headers[0]=headerElement.getAttribute('data-xAxis')))
	{
		return null;
	}
	if(!(headers[1]=headerElement.getAttribute('data-yAxis')))
	{
		return null;
	}
	if(!(headers[2]=headerElement.getAttribute('data-barColor')))
	{
		return null;
	}

	if(!(headers[3]=headerElement.getAttribute('data-margin')))
	{
		return null;
	}
	if(!(headers[4]=headerElement.getAttribute('data-barLabelPerc')))
	{
		return null;
	}
	if(!(headers[5]=headerElement.getAttribute('data-legendSize')))
	{
		return null;
	}
	if(!(headers[6]=headerElement.getAttribute('data-barSize')))
	{
		return null;
	}
		return headers;
}






// -----------------------------------------------------------------------------------------------------
// Reads data out of HTML document and returns them in an array called dataSet
// Returns null if an error was encountered
// -----------------------------------------------------------------------------------------------------

function getData(graph)
{
	// Get an array of all the elements of type name-data
//	var dataElements = document.getElementsByName(graph + '-data')
	var selectString = "." + graph + "-data";
	var dataElements = document.querySelectorAll(selectString);
	if(dataElements.length == 0)
	{
		return null;
	}
	
	// Loop through each array element to get the associated data-name attribute
	var dataNames = new Array();
	for(var i=0;i<dataElements.length;i++)
	{
		dataNames[i]=dataElements[i].getAttribute('data-name');
		if (dataNames[i]==null) return null;
	}

	// Loop through each array element to get the associated data-value attribute
	var dataValues = new Array();
	for(var i=0;i<dataElements.length;i++)
	{
		dataValues[i]=dataElements[i].getAttribute('data-value');
		if (dataValues[i]==null) return null;
	}
	
	// combine dataNames and dataValues into a single array
	var dataSet = new Array();  // declare dataSet as the array to hold all the data
	for(var i=0;i<dataElements.length;i++)
	{
		dataSet[i]=new Array(2); // allow each row of dataSet to hold an array of length 2
	}

	// loop through dataNames and dataValues and copy them into dataSet
	for(var i=0;i<dataElements.length;i++)
	{
		dataSet[i][0] = dataNames[i];
		dataSet[i][1] = Number(dataValues[i]); // convert strings to numbers
	}

	return dataSet;
}










// -----------------------------------------------------------------------------------------------------
// Main function for creating canvas and drawing the graph
// -----------------------------------------------------------------------------------------------------

function drawGraph(graph, headers, data, dataMax, dataMin)
{
	// Unpack variables
	// Convert strings to numbers as necessary
	xAxis = headers[0]; // x axis label
	yAxis = headers[1]; // y axis label
	barColor = headers[2]; // HTML color of bars
	margin = Number(headers[3]); // canvas inner margin (in pixels)
	barLabelPerc = Number(headers[4]); // percentage of graph used by bar labels
	legendSize = Number(headers[5]); // size of legend text (in ems)
	barSize = Number(headers[6]); // size of bars (in pixels)
	
	// Constants
	yTickLength = 7; // number of pixels the y ticks extend to the left of the y axis
	xTickLength = 7; // number of pixels the x ticks entend below the x axis
	yTickMargin = 10; // number of pixels between y data labels and y ticks
		
	// Calculated dimensions
	legendMargin = (legendSize * 1 * em); // space beneath legend
	barGutter = (barSize / 2); // padding on the top and bottom of each bar
	canvasHeight = ((barSize * data.length) + (barGutter * 2 * data.length) + (legendSize * em) + (legendMargin * 2) + (margin * 2)); // Height of canvas
	barLabelWidth = barLabelPerc / 100 * (canvasWidth - margin - margin);
	graphWidth = (100 - barLabelPerc) / 100 * (canvasWidth - margin - margin);

   // Calculate locations
	yAxisOffset = ((barLabelPerc / 100) * (canvasWidth - margin - margin)) + margin; // distance of y axis from left edge of canvas
	xAxisOffset = (margin + (legendSize *em) + legendMargin + (barSize * data.length) + (barGutter * data.length * 2));
	yAxisLegendPosition = ((yAxisOffset - margin) / 2) + margin;
	xAxisLegendPosition = ((canvasWidth - yAxisOffset - margin) / 2) + yAxisOffset;
	
	// Calculate grid sizes
	maxTicks = 10; // constant. Maximum # of vertical tick marks/lines
	var range = dataMax - dataMin;
	var pointsPerTick = range / maxTicks;
	var pointsPerTickExp = pointsPerTick.toExponential();
	var exp = Number(pointsPerTickExp.substr(pointsPerTickExp.indexOf("+")+1));
	var stepSize = Math.pow(10, exp + 1);  // Numeric distance between ticks
	
	// Scale x axis and determine labels and ranges
	// Get the lowest x axis tick mark
	var xLabelMin = Math.floor(dataMin/stepSize)*stepSize;
	if(xLabelMin > 0) xLabelMin = 0; // if the lowest value is > 0, still start the graph at 0
	
	// Get the highest x axis tick mark
	var xLabelMax = Math.ceil(dataMax/stepSize)*stepSize;
	
	// Calculate the graph range
	var graphRange = xLabelMax - xLabelMin;
	
	// Calculate scaling factor
	var scale = graphWidth / graphRange; // multiply data values by scale to get data distances in pixels
	
	// Calcuate the number of x ticks
	var numXTicks = graphRange / stepSize + 1;
	
	// Create an n*2 array to hold tick marks and labels
	// Format: xTicks[index][xPosition][label]
	var xTicks = new Array();  // declare ticks as the array to hold all the data
	for(var i=0; i < numXTicks; i++)
	{
		xTicks[i]=new Array(2); // allow each row of ticks to hold an array of length 2
	}	
	
	// populate xTicks array with labels
	var xLabel = xLabelMin;
	for(var i=0; i < (numXTicks); i++) {
		xTicks[i][0] = ((i * stepSize) * scale) + yAxisOffset; // position
		xTicks[i][1] = xLabel; // label
		xLabel += stepSize;
	}

	// Find the index of xTicks that is the 0 line for future use
	for(var i=0; i < (numXTicks); i++) {
		if(xTicks[i][1] == 0) var xZeroLine = xTicks[i][0];
	}


	// Setup Canvas
	var canvas = document.getElementById('respiteGraphCanvas-' + graph);
	var context = canvas.getContext('2d');

	// Clear the canvas
	context.clearRect(0,0, canvas.width, canvas.height);

	// Draw y axis legend text
	var xLegendFontString = legendSize + 'em sans-serif';
	context.font = xLegendFontString;
	context.textBaseline = 'top';
	context.textAlign = 'center';
	context.textBaseline = 'top';
	context.fillText(yAxis, yAxisLegendPosition, margin);

	// Draw x axis legend text
	var yLegendFontString = legendSize + 'em sans-serif';
	context.font = yLegendFontString;
	context.textBaseline = 'top';
	context.textAlign = 'center';
	context.textBaseline = 'top';
	context.fillText(xAxis, xAxisLegendPosition, margin);
	
	// Draw y axis
	context.strokeStyle = '#333333';
	context.lineWidth = 1;
	context.beginPath();
	context.moveTo(yAxisOffset, (margin + (legendSize *em) + legendMargin)); 
	context.lineTo(yAxisOffset, (margin + (legendSize *em) + legendMargin + (barSize * data.length) + (barGutter * data.length * 2)));
	context.stroke();
	context.closePath();

	// Draw x axis
	context.strokeStyle = '#333333';
	context.lineWidth = 1;
	context.beginPath();
	context.moveTo(yAxisOffset, xAxisOffset);
	context.lineTo((canvasWidth - margin), xAxisOffset);
	context.stroke();
	context.closePath();
	
	// Draw y axis ticks
	context.strokeStyle = '#333333';
	context.lineWidth = 1;
	context.beginPath();
	var yTickLocation = margin + (legendSize * em) + legendMargin;
	for(var i=0; i < (data.length + 1) ; i++) {
		context.moveTo(yAxisOffset, yTickLocation);
		context.lineTo(yAxisOffset - yTickLength, yTickLocation);
		context.stroke();
		context.closePath;
		yTickLocation += (barSize + (barGutter * 2));
	}

	// Draw y axis labels
	var yLabelFontString = (legendSize * .75) + 'em sans-serif';
	context.font = yLabelFontString;
	context.textBaseline = 'center';
	context.textAlign = 'right';
	context.textBaseline = 'Middle'
	for(var i=0; i < data.length; i++){
		context.fillText(data[i][0], yAxisOffset - yTickLength - yTickMargin, (margin +  (legendSize * em) + legendMargin + barGutter + (i * (barGutter + barGutter + barSize))));	
	}

	// Draw x axis ticks
	context.strokeStyle = '#333333';
	context.lineWidth = 1;
	context.beginPath();
	for(var i=0; i < xTicks.length; i++) {
		context.moveTo(xTicks[i][0], xAxisOffset + xTickLength);
		context.lineTo(xTicks[i][0], xAxisOffset - (data.length * (barSize + barGutter + barGutter)));
		context.stroke();
		context.closePath;
	}

	// Draw x axis labels
	var xTickFontString = (legendSize * .65) + 'em sans-serif';
	context.font = xTickFontString;
	context.textBaseline = 'top';
	context.textAlign = 'center';
	context.textBaseline = 'top'
	for(var i=0; i < xTicks.length; i++) {
		context.fillText(xTicks[i][1], xTicks[i][0], xAxisOffset + xTickLength);
	}

	// Draw bars
	context.strokeStyle = barColor;
	context.lineWidth = barSize;
	context.beginPath();	
	for(var i=0; i < data.length; i++) {
		context.moveTo(xZeroLine, (margin +  (legendSize * em) + legendMargin + barGutter + barSize / 2 + (i * (barGutter + barGutter + barSize))));	
		context.lineTo(xZeroLine + data[i][1] * scale, (margin +  (legendSize * em) + legendMargin + barGutter + barSize / 2 + (i * (barGutter + barGutter + barSize))));
		context.stroke();
		context.closePath;
	}
	return;
}













// -----------------------------------------------------------------------------------------------------
// Manages animation frame cycling and data scaling
// -----------------------------------------------------------------------------------------------------

function animate(graph, headers, data, dataMax, dataMin, dataScaled, frameData)
{
	// scale data
	for(var i=0; i<data.length; i++) {
		dataScaled[i][1] =  data[i][1]/frameData.numFrames * frameData.currentFrame;
	}

	// --		Draw and animate the graph --
	if(frameData.currentFrame < (frameData.numFrames + 1))
	{
		drawGraph(graph, headers, dataScaled, dataMax, dataMin);
	}
	frameData.currentFrame += 1;
}







// -----------------------------------------------------------------------------------------------------
// Stops the animation
// -----------------------------------------------------------------------------------------------------

function animationStop(animationCycle)
{
	clearInterval(animationCycle);
}
