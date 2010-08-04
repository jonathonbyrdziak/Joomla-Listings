function _imageClick( _a )
{
	//loading resources
	var _mainimage = _get( 'mainimage' );
	var _image = _a.getElementsByTagName( 'img' )[0];
	
	//reasons to fail
	if (!_mainimage) return false;
	
	//initializing variables
	var _mainsrc = _mainimage.src;
	var _imagesrc = _image.src;
	
	_mainimage.src = _imagesrc;
	_image.src = _mainsrc;
	
	return false;
}
function _get( _id )
{
	return document.getElementById( _id );
}