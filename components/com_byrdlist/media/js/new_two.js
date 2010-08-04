var thisform = _get('sleeker');
function readyNewImage()
{
	//initializing variables
	var row = '<div class="row0"><div class="fieldRow lastFieldRow" style="width:98%" id="upload_area"></div></div>';
	var pare = _get('parent_upload_area');
	var inputboxname = _get('inputboxname');
	var description = _get('inputboxdescription');
	var file_name = _get('file_name');
	
	//initializing parent upload area
	document.getElementById('upload_area').id = "";
	file_name.value = null;
	
	var contents = pare.innerHTML;
	pare.innerHTML = row + contents;
	
	inputboxname.value = '';
	description.value = '';
	
	//initializing variables
	var imageidspan = _get('imageid');
	var id = imageidspan.getAttribute('imageid');
	var div = imageidspan.parentNode.parentNode;
	div.id = id;
	
	return true;
}
function _edit( imageid )
{
	//reasons to fail
	if (!imageid) return false;
	
	//initializing variables
	var url = "?option=com_byrdlist&view=listings&layout=new_two&format=ajax&task=editthumbnail&id="+imageid;
	
	//reasons to fail
	if (!ajaxSubmit(url, imageSetAsThumb )) return false;
	
	return true;
}
function _thumb( imageid )
{
	//reasons to fail
	if (!imageid) return false;
	
	//initializing variables
	var url = "?option=com_byrdlist&view=listings&layout=new_two&format=ajax&task=setthumbnail&id="+imageid;
	
	//reasons to fail
	if (!ajaxSubmit(url, imageSetAsThumb )) return false;
	
	return true;
}
function imageSetAsThumb()
{
	//reasons to fail
	if (request.readyState != 4) return false;
	if (request.status != 200) return false;
	
	//initializing variables
	var id = request.responseText;
	
	
	//removing the thumbnail link
	var _span = _get(id+"_span");
	var paren = _span.parentNode;
	paren.removeChild(_span);
	
	//adding the thumbnail links
	var imageactions = document.getElementsByClassName('imageactions');
	
	for (var i = 0; i < imageactions.length; i++)
	{
		var item = imageactions[i];
		var iid = item.parentNode.parentNode.id;
		var len = item.getElementsByTagName('a').length;
		
		//reasons to fail
		if (id == iid) continue;
		if (len == 2) continue;
		
		var _a = '<span id="' + iid + '_span">'
			+'<a href="#" onClick="javascript: _thumb(\'' + iid + '\'); return false;">'
			+'thumbnail | </a> '
			+'</span>';
		
		var _html = item.innerHTML;
		item.innerHTML = _a+_html;
		
	}
	
	return true;
}
function _delete( imageid )
{
	//reasons to fail
	if (!imageid) return false;
	
	//initializing variables
	var url = "?option=com_byrdlist&view=listings&layout=new_two&format=ajax&task=deleteimage&id="+imageid;
	
	//reasons to fail
	if (!ajaxSubmit(url, imageWasDeleted )) return false;
	
	return true;
}
function imageWasDeleted()
{
	//reasons to fail
	if (request.readyState != 4) return false;
	if (request.status != 200) return false;
	
	//initializing variables
	var id = request.responseText;
	var imagediv = _get(id);
	imagediv.innerHTML = "";
	
	return true;
}
function _get( id )
{
	return document.getElementById(id);
}
var request = false;
function ajaxSubmit( url, callBack )
{
	//reasons to fail
	if (!url) return false;
	
	//loading resources
	try {
	  request = new XMLHttpRequest();
	} catch (trymicrosoft) {
		try 
		{
			request = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (othermicrosoft) {
			try
			{
				request = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (failed) {
				request = false;
			}
		}
	}

	if (!request) return false;
	
    request.open("GET", url, true);
    request.onreadystatechange = callBack;
    request.send( null );
    return true;
}
document.getElementsByClassName = function(cl) 
{
	var retnode = [];
	var myclass = new RegExp('\\b'+cl+'\\b');
	var elem = this.getElementsByTagName('*');
	for (var i = 0; i < elem.length; i++) {
	var classes = elem[i].className;
	if (myclass.test(classes)) retnode.push(elem[i]);
	}
	return retnode;
};


function isValid( formid )
{
	if (!_titles())
	{
		
	}
	
	//initializing variables
	var cannotBeEmpty = document.getElementsByClassName('cannotBeEmpty');
	
	for (var i = 0; i < cannotBeEmpty.length; i++)
	{
		var item = cannotBeEmpty[i];
		
		if (isEmpty( item )) return false;
	}
	
	document.getElementById(formid).submit();
	return false;
}
function isEmpty( el )
{
	if (el.value == '' || el.value == 0 || el.value == '0')
	{
		markError( el );
		return true;
	}
	else
	{
		hideError( el );
		return false;
	}
}
function hideError( el )
{
	var error = _get(el.id + "_error");
	error.style.display = 'none';
}
function markError( el )
{
	var error = _get(el.id + "_error");
	error.style.display = 'block';
}
function _focus( el, _value )
{
	if (el.value == _value) el.value = '';
}
function _blur( el, _value )
{
	if (el.value == '') el.value = _value;
}
function _titles()
{
	//initializing variables
	var Street = _get('primary_street');
	var State = _get('primary_state');
	var City = _get('primary_city');
	var Postalcode = _get('primary_postal_code');
	
	if (!Street) return false;
	
	if (Street.value == 'Street') Street.value = '';
	if (State.value == 'State') State.value = '';
	if (City.value == 'City') City.value = '';
	if (Postalcode.value == 'Postal Code') Postalcode.value = '';
	return true;
}


