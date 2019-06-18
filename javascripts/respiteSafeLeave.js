/* Javascript elements for the respiteSageLeave function */

// Alerts a user if she is leaving a page in which changes have been made.
// The user is given the option to return to the page or continue


// Usage
//
// To include this script, include the following line in your html:
// <script type="application/javascript" src="javascripts/respiteSafeLeave.js"></script>
//
// To ensure that an input field is checked for changes before leaving, include
// onchange="respiteDirty()"
// as an attribute of the <input> element
//
// To prevent the user from being alerted when leaving a page (such as on submit), include
// onclick="respiteClean()"
// as an attribute of the <input> element, e.g. the submit button.
// This marks the page as having no changed input fields.


var changed = false;


// Sets page status to indicate that changes have been made
function respiteDirty()
{
	changed = true;
}



// Sets page status to indicate that no changes have been made.
function respiteClean()
{
	changed = false;
}



// Alerts the user before leaving the page
window.onbeforeunload = function(event){
  event = event || window.event;
  if(changed == true){
    return event.returnValue = "Are you sure you want to leave? Your recent changes have not been saved."
  }
}
