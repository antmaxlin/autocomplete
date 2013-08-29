// JavaScript Document

//AJAX Class - Set url, divID, and queryString to use. Call with httpRequest.
function AjaxCall() {
	this.req = null;
	this.url = null;
	this.divID = null;
	this.method = 'POST';
	this.async = true;
	this.queryString = null;
	this.visible= false;
	
	this.initReq = function (){
		var self = this;
		this.req.open(this.method,this.url,this.async);
		this.req.onreadystatechange= function() {
			var obj=document.getElementById(self.divID);
			if(self.req.readyState == 4){	
				if(self.req.status == 200){
					obj.innerHTML=self.req.responseText;
					if (self.visible) obj.style.visibility="visible";
					self.onresult();
				} else {
					//alert(self.req.status+"A problem occurred with communicating between the XMLHttpRequest object and the server program.");
				}
			}
		}
		this.req.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8");
		this.req.send(this.queryString);
	}
	
	this.httpRequest = function (){
		//Mozilla-based browsers
		if(window.XMLHttpRequest){
			this.req = new XMLHttpRequest();
		} else if (window.ActiveXObject){
			this.req=new ActiveXObject("Msxml2.XMLHTTP");
			if (!this.req){
				this.req=new ActiveXObject("Microsoft.XMLHTTP");
			}
		}
		//the request could still be null if neither ActiveXObject
		//initializations succeeded
		if(this.req){
			this.initReq();
		}  else {
			//alert("Your browser does not permit the use of all "+"of this application's features!");
		}
	}
	
	this.onresult = function (){
		//Do something after completion here.
	}
}

function handleSpecialKeys(e, div) 
{ 
	switch (e.keyCode) 
	{ 
	      // Return/Enter 
	      case 13:
		  	if (document.getElementById('auto_url').value!=0) {
				var url=document.getElementById('auto_url').value;
				window.location = url;
			} else {
			 	return false;
			}
	          break; 
	      // Escape 
	      case 27: 
		    document.getElementById('auto_url').value='';
		  	noPopup(div);
	          break; 
	      // Up arrow 
	      case 38: 
		 	var x = document.getElementById('auto_counter');
		  if (x.value>1) {
			  	var pdiv="auto_obj_"+x.value;
				x.value=parseInt(x.value)-1;
				var div="auto_obj_"+x.value;
				document.getElementById(pdiv).style.backgroundColor='#FFDCAA';
				document.getElementById(div).style.backgroundColor='#FF8800';
				var udiv="auto_url_"+x.value;
				document.getElementById('auto_url').value=document.getElementById(udiv).value;
			}
	          break; 
	      // Down arrow 
	      case 40: 
		   var x = document.getElementById('auto_counter');
		   var temp = parseInt(x.value)+1;
		   var udiv="auto_url_"+temp;
		   if (document.getElementById(udiv).value!=''){
			  	if (x.value!=0){
			  		var pdiv="auto_obj_"+x.value;
					document.getElementById(pdiv).style.backgroundColor='#FFDCAA';
				}
		 		x.value=parseInt(x.value)+1;
				var div="auto_obj_"+x.value;
				document.getElementById(div).style.backgroundColor='#FF8800';
				var udiv="auto_url_"+x.value;
				document.getElementById('auto_url').value=document.getElementById(udiv).value;
		   }
	          break; 
	      // left & right arrow keys. Absorb them. 
	      case 37: 
	      case 39: 
	          break; 
	      default: 
	          return false; 
	} 
	e.returnValue = false; 
	e.cancelBubble = true; 
	return true; 
} 

function autocomplete_n(e, div, text){
	if (!e) var e = window.event;
	if (handleSpecialKeys(e, div)) return; 
	var ajax1 = new AjaxCall();
	var value=document.getElementById(text).value;
	document.getElementById(div).style.visibility='visible';
	ajax1.divID=div;
	ajax1.queryString="st="+value+"&div="+div;
	ajax1.url='/demo/autocomplete/autocomplete.php';
	ajax1.httpRequest();
}

function noPopup(div){
	
}
function mouseSelect(y){
	var x = document.getElementById('auto_counter');
   	var udiv="auto_url_"+y;
   	if (document.getElementById(udiv).value!=''){
		if (x.value!=0){
			var pdiv="auto_obj_"+x.value;
			document.getElementById(pdiv).style.backgroundColor='#FFDCAA';
		}
		x.value=y;
		var div="auto_obj_"+x.value;
		document.getElementById(div).style.backgroundColor='#FF8800';
		var udiv="auto_url_"+x.value;
		document.getElementById('auto_url').value=document.getElementById(udiv).value;
   	}
}