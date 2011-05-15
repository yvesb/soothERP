Array.prototype.contains = function(element) {
    for(var i = 0; i < this.length; i++){
        if(this[i] == element){return true;}
    }
	return false;
};

Array.prototype.indexOf = function(element){
    for(var i = 0; i < this.length; i++){
        if(this[i] == element){return i;}
    }
    return -1;
};

Array.prototype.intersect = function(tab){
    var temp = [];
    for(var i = 0; i < this.length; i++){
        for(var k = 0; k < tab.length; k++){
            if(this[i] == tab[k]){
                temp.push( this[i]);
                break;
            }
        }
    }
    return temp;
};

String.prototype.textWidth = function(fontFamily , fontSize){
	var container = document.createElement("div");
		container.id = "magicDiv";
		container.style.visibility = "hidden";
		container.style.fontFamily = fontFamily;
		container.style.fontSize = fontSize + "px";
		container.style.display = "inline";
	
	document.body.appendChild(container);
	$("magicDiv").innerHTML = this;
	var width = $("magicDiv").offsetWidth;
	var height = $("magicDiv").offsetHeight;
	$("magicDiv").parentNode.removeChild($("magicDiv"));
	return {width : width, height : height};
};
