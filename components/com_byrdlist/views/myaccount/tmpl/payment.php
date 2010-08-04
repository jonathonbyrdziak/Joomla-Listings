<h2 class="contentheading">Add Listing</h2> 
 
<form action="/tree/directory.html" method="post" enctype="multipart/form-data" name="adminForm" id="adminForm"> 
<table width="100%" cellpadding="0" cellspacing="4" border="0" align="center" id="editForm"> 
	<tr>
		<td colspan="2" align="left"> 
			<input type="button" value="Submit" onclick="javascript:submitbutton('savelisting')" class="button" /> <input type="button" value="Cancel" onclick="history.back();" class="button" /> 
		</td>
	</tr> 
	<tr valign="bottom"> 
		<td width="20%" align="left" valign="top">
			Category:
		</td> 
		<td width="80%" align="left" colspan="2"> 
			<ul class="linkcats" id="linkcats"> 
				<li id="lc2">Directory > Computers</li> 
			</ul>
			
			<a href="#" onclick="javascript:togglemc();return false;" id="lcmanage">Change category</a> 
			<div id="mc_con"> 
				<div id="mc_selectcat"> 
					<span id="mc_active_pathway">Directory > Computers</span> 
					
					<select name="new_cat_id" id="browsecat" size=8 class="inputbox">
						<option value="0" >< Back</option>
						<option value="17" >Internet</option>
						<option value="18" >Laptops</option>
						<option value="19" >Software</option>
					</select>
				</div> 
				<input type="button" class="button" value="Update category" id="mcbut1" onclick="updateMainCat()" /> 
				<input type="button" class="button" value="Also appear in this category" id="mcbut2" onclick="addSecCat()" /> 
			</div> 
		</td> 
	</tr> 
	<tr>
		<td valign="top" align="left">
			<strong>Name</strong>:
		</td>
		<td align="left">
			<input class="inputbox text_area" type="text" name="link_name" id="link_name" size="50" value="" />
		</td>
	</tr>
	<tr>
		<td valign="top" align="left">
			Description:
		</td>
		<td align="left">
			<textarea class="inputbox" name="link_desc" style="width:95%;height:250px"></textarea>
		</td>
	</tr>
	<tr>
		<td valign="top" align="left">Address:</td>
		<td align="left">
			<input class="inputbox text_area" type="text" name="address" id="address" size="30" value="" />
		</td>
	</tr>
	<tr>
		<td valign="top" align="left">City:</td>
		<td align="left">
			<input class="inputbox text_area" type="text" name="city" id="city" size="30" value="" />
		</td>
	</tr>
	<tr>
		<td valign="top" align="left">State:</td>
		<td align="left">
			<input class="inputbox text_area" type="text" name="state" id="state" size="30" value="" />
		</td>
	</tr>
	<tr>
		<td valign="top" align="left">Country:</td>
		<td align="left">
		<input class="inputbox text_area" type="text" name="country" id="country" size="30" value="" />
		</td>
	</tr>
	<tr>
		<td valign="top" align="left">Postcode:</td>
		<td align="left">
		<input class="inputbox text_area" type="text" name="postcode" id="postcode" size="30" value="" />
		</td>
	</tr>
	<tr>
		<td valign="top" align="left">Telephone:</td>
		<td align="left">
		<input class="inputbox text_area" type="text" name="telephone" id="telephone" size="30" value="" />
		</td>
	</tr>
	<tr>
		<td valign="top" align="left">Fax:</td>
		<td align="left">
		<input class="inputbox text_area" type="text" name="fax" id="fax" size="30" value="" />
		</td>
	</tr>
	<tr>
		<td valign="top" align="left">E-mail:</td>
		<td align="left">
		<input class="inputbox text_area" type="text" name="email" id="email" size="30" value="" />
		</td>
	</tr>
	<tr>
		<td valign="top" align="left">Website:</td>
		<td align="left">
		<input class="text_area inputbox" type="text" name="website" id="website" size="30" value="" />
		</td>
	</tr>
	<tr>
		<td valign="top" align="left">Tags:</td>
		<td align="left">
		<input class="inputbox text_area" type="text" name="cf28" id="cf28" size="40" value="" maxlength="80" />
		</td>
	</tr>
	<tr>
		<td valign="top" align="left">Image:</td>
		<td align="left">
		<input class="inputbox" type="file" name="cf23" />
		</td>
	</tr>
	<tr>
		<td valign="top" align="left">Download:</td>
		<td align="left">
		<input class="inputbox text_area" type="file" name="cf24" id="cf24" />
		</td>
	</tr>
	<tr>
		<td valign="top" align="left">Release Year:</td>
		<td align="left">
		<select name="cf29" class="inputbox">
			<option value="">&nbsp;</option>
			<option value="2010">2010</option>
			<option value="2009">2009</option>
			<option value="2008">2008</option>
			<option value="2007">2007</option>
			<option value="2006">2006</option>
			<option value="2005">2005</option>
			<option value="2004">2004</option>
			<option value="2003">2003</option>
			<option value="2002">2002</option>
			<option value="2001">2001</option>
			<option value="2000">2000</option>
			<option value="1999">1999</option>
			<option value="1998">1998</option>
			<option value="1997">1997</option>
			<option value="1996">1996</option>
			<option value="1995">1995</option>
			<option value="1994">1994</option>
			<option value="1993">1993</option>
			<option value="1992">1992</option>
			<option value="1991">1991</option>
			<option value="1990">1990</option>
			<option value="1989">1989</option>
			<option value="1988">1988</option>
			<option value="1987">1987</option>
			<option value="1986">1986</option>
			<option value="1985">1985</option>
			<option value="1984">1984</option>
			<option value="1983">1983</option>
			<option value="1982">1982</option>
			<option value="1981">1981</option>
			<option value="1980">1980</option>
			<option value="1979">1979</option>
			<option value="1978">1978</option>
			<option value="1977">1977</option>
			<option value="1976">1976</option>
			<option value="1975">1975</option>
			<option value="1974">1974</option>
			<option value="1973">1973</option>
			<option value="1972">1972</option>
			<option value="1971">1971</option>
			<option value="1970">1970</option>
			<option value="1969">1969</option>
			<option value="1968">1968</option>
			<option value="1967">1967</option>
			<option value="1966">1966</option>
			<option value="1965">1965</option>
			<option value="1964">1964</option>
			<option value="1963">1963</option>
			<option value="1962">1962</option>
			<option value="1961">1961</option>
			<option value="1960">1960</option>
			<option value="1959">1959</option>
			<option value="1958">1958</option>
			<option value="1957">1957</option>
			<option value="1956">1956</option>
			<option value="1955">1955</option>
			<option value="1954">1954</option>
			<option value="1953">1953</option>
			<option value="1952">1952</option>
			<option value="1951">1951</option>
			<option value="1950">1950</option>
			<option value="1949">1949</option>
			<option value="1948">1948</option>
			<option value="1947">1947</option>
			<option value="1946">1946</option>
			<option value="1945">1945</option>
			<option value="1944">1944</option>
			<option value="1943">1943</option>
			<option value="1942">1942</option>
			<option value="1941">1941</option>
			<option value="1940">1940</option>
		</select>
		</td>
	</tr>
	<tr>
		<td valign="top" align="left">Running Time:</td>
		<td align="left">
		<input class="inputbox text_area" type="text" name="cf30" id="cf30" size="30" value="" />
		A minutes
		</td>
	</tr>
	<tr>
		<td valign="top" align="left">Director:</td>
		<td align="left">
		<input class="inputbox text_area" type="text" name="cf31" id="cf31" size="30" value="" maxlength="80" />
		</td>
	</tr>
	<tr>
		<td valign="top" align="left">Starring:</td>
		<td align="left">
		<input class="inputbox text_area" type="text" name="cf32" id="cf32" size="50" value="" maxlength="120" />
		</td>
	</tr>
	<tr>
		<td valign="top" align="left">Box Office:</td>
		<td align="left">
		$<input class="inputbox text_area" type="text" name="cf33" id="cf33" size="30" value="" />
		</td>
	</tr>
	<tr>
		<td valign="top" align="left">Poster:</td>
		<td align="left">
		<input class="inputbox text_area" type="file" name="cf34" id="cf34" />
		</td>
	</tr>
	<tr>
		<td valign="top" align="left">Genre:</td>
		<td align="left">
		<input class="inputbox text_area" type="text" name="cf35" id="cf35" size="30" value="" maxlength="80" />
		</td>
	</tr>
	<tr>
		<td valign="top" align="left">Singer:</td>
		<td align="left">
		<input class="inputbox text_area" type="text" name="cf36" id="cf36" size="30" value="" />
		</td>
	</tr>
	<tr>
		<td valign="top" align="left">Release Date:</td>
		<td align="left">
		<select name="cf37" class="inputbox">
			<option value="">&nbsp;</option>
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
			<option value="6">6</option>
			<option value="7">7</option>
			<option value="8">8</option>
			<option value="9">9</option>
			<option value="10">10</option>
			<option value="11">11</option>
			<option value="12">12</option>
			<option value="13">13</option>
			<option value="14">14</option>
			<option value="15">15</option>
			<option value="16">16</option>
			<option value="17">17</option>
			<option value="18">18</option>
			<option value="19">19</option>
			<option value="20">20</option>
			<option value="21">21</option>
			<option value="22">22</option>
			<option value="23">23</option>
			<option value="24">24</option>
			<option value="25">25</option>
			<option value="26">26</option>
			<option value="27">27</option>
			<option value="28">28</option>
			<option value="29">29</option>
			<option value="30">30</option>
			<option value="31">31</option>
		</select>
		<select name="cf37_2" class="inputbox">
			<option value="">&nbsp;</option>
			<option value="1">Jan</option>
			<option value="2">Feb</option>
			<option value="3">Mar</option>
			<option value="4">Apr</option>
			<option value="5">May</option>
			<option value="6">Jun</option>
			<option value="7">Jul</option>
			<option value="8">Aug</option>
			<option value="9">Sep</option>
			<option value="10">Oct</option>
			<option value="11">Nov</option>
			<option value="12">Dec</option>
		</select>
		<select name="cf37_3" class="inputbox">
			<option value="">&nbsp;</option>
			<option value="2010">2010</option>
			<option value="2009">2009</option>
			<option value="2008">2008</option>
			<option value="2007">2007</option>
			<option value="2006">2006</option>
			<option value="2005">2005</option>
			<option value="2004">2004</option>
			<option value="2003">2003</option>
			<option value="2002">2002</option>
			<option value="2001">2001</option>
			<option value="2000">2000</option>
			<option value="1999">1999</option>
			<option value="1998">1998</option>
			<option value="1997">1997</option>
			<option value="1996">1996</option>
			<option value="1995">1995</option>
			<option value="1994">1994</option>
			<option value="1993">1993</option>
			<option value="1992">1992</option>
			<option value="1991">1991</option>
			<option value="1990">1990</option>
			<option value="1989">1989</option>
			<option value="1988">1988</option>
			<option value="1987">1987</option>
			<option value="1986">1986</option>
			<option value="1985">1985</option>
			<option value="1984">1984</option>
			<option value="1983">1983</option>
			<option value="1982">1982</option>
			<option value="1981">1981</option>
			<option value="1980">1980</option>
			<option value="1979">1979</option>
			<option value="1978">1978</option>
			<option value="1977">1977</option>
			<option value="1976">1976</option>
			<option value="1975">1975</option>
			<option value="1974">1974</option>
			<option value="1973">1973</option>
			<option value="1972">1972</option>
			<option value="1971">1971</option>
			<option value="1970">1970</option>
			<option value="1969">1969</option>
			<option value="1968">1968</option>
			<option value="1967">1967</option>
			<option value="1966">1966</option>
			<option value="1965">1965</option>
			<option value="1964">1964</option>
			<option value="1963">1963</option>
			<option value="1962">1962</option>
			<option value="1961">1961</option>
			<option value="1960">1960</option>
			<option value="1959">1959</option>
			<option value="1958">1958</option>
			<option value="1957">1957</option>
			<option value="1956">1956</option>
			<option value="1955">1955</option>
			<option value="1954">1954</option>
			<option value="1953">1953</option>
			<option value="1952">1952</option>
			<option value="1951">1951</option>
			<option value="1950">1950</option>
			<option value="1949">1949</option>
			<option value="1948">1948</option>
			<option value="1947">1947</option>
			<option value="1946">1946</option>
			<option value="1945">1945</option>
			<option value="1944">1944</option>
			<option value="1943">1943</option>
			<option value="1942">1942</option>
			<option value="1941">1941</option>
			<option value="1940">1940</option>
		</select>
		</td>
	</tr>
	<tr>
		<td valign="top" align="left">Version:</td>
		<td align="left">
		<input class="inputbox text_area" type="text" name="cf38" id="cf38" size="30" value="" />
		</td>
	</tr>
	<tr>
		<td valign="top" align="left">Download:</td>
		<td align="left">
		<input class="inputbox text_area" type="text" name="cf39" id="cf39" size="30" value="" />
		</td>
	</tr>
	<tr>
		<td valign="top" align="left">Height:</td>
		<td align="left">
		<input class="inputbox text_area" type="text" name="cf40" id="cf40" size="30" value="" />
		cm
		</td>
	</tr>
	<tr>
		<td valign="top" align="left">Weight:</td>
		<td align="left">
		<input class="inputbox text_area" type="text" name="cf41" id="cf41" size="30" value="" />
		kg
		</td>
	</tr>
	<tr>
		<td valign="top" align="left">Gender:</td>
		<td align="left">
		<ul style="margin:0;padding:0;list-style-type:none">
			<li style="background-image:none;padding:0">
				<input type="radio" name="cf42" value="Male" id="cf42_0" />
				<label for="cf42_0">Male</label>
			</li>
			<li style="background-image:none;padding:0">
				<input type="radio" name="cf42" value="Female" id="cf42_1" />
				<label for="cf42_1">Female</label>
			</li>
		</ul>
		</td>
	</tr>
	<tr>
		<td valign="top" align="left">Skin Color:</td>
		<td align="left">
		<select name="cf43" id="cf43" class="inputbox text_area">
			<option value="">&nbsp;</option>
			<option value="Fair">Fair</option>
			<option value="Medium">Medium</option>
			<option value="Dark">Dark</option>
		</select>
		</td>
	</tr>
	<tr>
		<td valign="top" align="left">Body Type:</td>
		<td align="left">
		<select name="cf44" id="cf44" class="inputbox text_area">
			<option value="">&nbsp;</option>
			<option value="Thin">Thin</option>
			<option value="Average">Average</option>
			<option value="Curvy">Curvy</option>
			<option value="Plus size">Plus size</option>
			<option value="Muscular">Muscular</option>
		</select>
		</td>
	</tr>
	<tr>
		<td valign="top" align="left">Age:</td>
		<td align="left">
		<input class="inputbox text_area" type="text" name="cf45" id="cf45" size="30" value="" />
		</td>
	</tr>
	<tr>
		<td valign="top" align="left">Born:</td>
		<td align="left">
		<select name="cf46" class="inputbox">
			<option value="">&nbsp;</option>
			<option value="2010">2010</option>
			<option value="2009">2009</option>
			<option value="2008">2008</option>
			<option value="2007">2007</option>
			<option value="2006">2006</option>
			<option value="2005">2005</option>
			<option value="2004">2004</option>
			<option value="2003">2003</option>
			<option value="2002">2002</option>
			<option value="2001">2001</option>
			<option value="2000">2000</option>
			<option value="1999">1999</option>
			<option value="1998">1998</option>
			<option value="1997">1997</option>
			<option value="1996">1996</option>
			<option value="1995">1995</option>
			<option value="1994">1994</option>
			<option value="1993">1993</option>
			<option value="1992">1992</option>
			<option value="1991">1991</option>
			<option value="1990">1990</option>
			<option value="1989">1989</option>
			<option value="1988">1988</option>
			<option value="1987">1987</option>
			<option value="1986">1986</option>
			<option value="1985">1985</option>
			<option value="1984">1984</option>
			<option value="1983">1983</option>
			<option value="1982">1982</option>
			<option value="1981">1981</option>
			<option value="1980">1980</option>
			<option value="1979">1979</option>
			<option value="1978">1978</option>
			<option value="1977">1977</option>
			<option value="1976">1976</option>
			<option value="1975">1975</option>
			<option value="1974">1974</option>
			<option value="1973">1973</option>
			<option value="1972">1972</option>
			<option value="1971">1971</option>
			<option value="1970">1970</option>
			<option value="1969">1969</option>
			<option value="1968">1968</option>
			<option value="1967">1967</option>
			<option value="1966">1966</option>
			<option value="1965">1965</option>
			<option value="1964">1964</option>
			<option value="1963">1963</option>
			<option value="1962">1962</option>
			<option value="1961">1961</option>
			<option value="1960">1960</option>
			<option value="1959">1959</option>
			<option value="1958">1958</option>
			<option value="1957">1957</option>
			<option value="1956">1956</option>
			<option value="1955">1955</option>
			<option value="1954">1954</option>
			<option value="1953">1953</option>
			<option value="1952">1952</option>
			<option value="1951">1951</option>
			<option value="1950">1950</option>
			<option value="1949">1949</option>
			<option value="1948">1948</option>
			<option value="1947">1947</option>
			<option value="1946">1946</option>
			<option value="1945">1945</option>
			<option value="1944">1944</option>
			<option value="1943">1943</option>
			<option value="1942">1942</option>
			<option value="1941">1941</option>
			<option value="1940">1940</option>
		</select>
		</td>
	</tr>
</table> 

<table width="100%" cellpadding="0" cellspacing="0"> 
	<tr>
		<td> 
			<div id="mapcon"> 
				<h3 class="title">Map</h3> 
			 
				<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAS8nbQ7wLX2_yUBqhgNWBBRT0JF8OWkZ0qItR-u_sGs1WX8VN9xT0mlRSqyiW0h8i3ZN03NjjE0DZ2w" type="text/javascript"></script> 
				<script type="text/javascript"> 
					var map = null;
				    var geocoder = null;
					var marker = null;
					var txtEnterAddress = 'Enter an address and press \'Locate in map\' or move the red marker to the location in the map below.';
					var txtLocateInMap = 'Locate in map';
					var txtLocating = 'Locating...';
					var txtNotFound = 'Not found:';
					var defaultCountry = '';
					var defaultState = '';
					var defaultCity = '';
					var defaultLat = '12.554563528593656';
					var defaultLng = '18.984375';
					var defaultZoom = 1;
					var linkValLat = '';
					var linkValLng = '';
					var linkValZoom = '';
					var mapControl = [new GSmallMapControl(), new GMapTypeControl()];
				</script> 
				
				<div style="padding:4px 0; width:95%">
					<input type="button" onclick="locateInMap()" value="Locate in map" name="locateButton" id="locateButton" />
					<span style="padding:0px; margin:3px" id="map-msg"></span>
				</div> 
				
				<div id="map" style="width:100%;height:200px"></div> 
				<input type="hidden" name="lat" id="lat" value="" /> 
				<input type="hidden" name="lng" id="lng" value="" /> 
				<input type="hidden" name="zoom" id="zoom" value="" />
			</div> 
			
		</td>
	</tr> 
	<tr>
		<td> 
			<div id="imagescon"> 
				<h3 class="title">Images</h3> 
				<span><small>Drag to sort images, deselect checkbox to remove.</small></span> 
				<ol id="sortableimages"></ol> 
				<ol id="uploadimages"></ol> 
				<div class="actionimages"> 
					<a href="javascript:addAtt();" id="add_att">Add an image</a> 
					<br /><small>(Limit of 800KB per image)</small> 
				</div> 
			</div> 
			<input type="hidden" name="img_sort_hash" value="" /> 
		</td>
	</tr> 
	<tr>
		<td align="left"> 
			<br /> 
			<input type="hidden" name="option" value="com_mtree" /> 
			<input type="hidden" name="task" value="savelisting" /> 
			<input type="hidden" name="Itemid" value="2" />			
			<input type="hidden" name="cat_id" value="2" /> 
			<input type="hidden" name="other_cats" id="other_cats" value="" /> 
			<input type="hidden" name="da5e5abca6cbab64a7d058c4432ad5a9" value="1" />
			<input type="button" value="Submit" onclick="javascript:submitbutton('savelisting')" class="button" /> 
			<input type="button" value="Cancel" onclick="history.back();" class="button" /> 
		</td>
	</tr> 
</table> 
</form>