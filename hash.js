var forms = document.getElementsByTagName('form'); //get all forms on the site
for(var i=0; i<forms.length;i++) forms[i].addEventListener('submit', //to each form...
function(){ //add a submit pre-processing function that will:
    var hidden = document.createElement('input');  //create an extra input element
    hidden.setAttribute('type','hidden'); //set it to hidden so it doesn't break view 
    hidden.setAttribute('name','fragment');  //set a name to get by it in PHP
    hidden.setAttribute('value',window.location.hash); //set a value of #HASH
    this.appendChild(hidden); //append it to the current form
});