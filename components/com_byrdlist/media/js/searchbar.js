/**
 * Search
 * 
 */
function _search()
{
	if (request.readyState != 0)
		request = null;
	
	//loading resources
	var _filter = _get('filter');
	var _postal_code = _get('postal_code');
	var _search_distances = document.getElementsByClassName('search_distance');
	
	//initializing variables
	var _distance_val = 0;
	var _filter_val = _filter.value;
	var _postal_code_val = _postal_code.value;
	for (var i = 0; i < _search_distances.length; i++)
	{
		var _chkbox = _search_distances[i];
		if (_chkbox.checked)
		{
			var _distance_val = _chkbox.value;
			break;
		}
	}
	
	var url = "?option=com_byrdlist&view=listings&layout=search_results&format=ajax"
		+ "&filter=" + _filter_val
		+ "&distance=" + _distance_val
		+ "&postal_code=" + _postal_code_val
		;
	
	//reasons to fail
	if (!ajaxSubmit(url, _search_results)) return false;
	
	return true;
}
function _search_results()
{
	//reasons to fail
	if (request.readyState != 4) return false;
	if (request.status != 200) return false;
	
	//initializing variables
	var response = request.responseText;
	
	//loading resources
	var _results = _get('search_results');
	
	_results.innerHTML = response;
}




/**
 * Functions making it quick and easy to work with javascript and Ajax
 * 
 * @Example:
 * <pre>
 * 	if (!ajaxSubmit(url, imageWasDeleted )) return false;
 * </pre>
 * 
 */
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