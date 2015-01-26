<?php
session_start();
if (isset($_SESSION["logged_in"]) ){ //testing purpose
$loggedIn = $_SESSION["logged_in"];
$userId = $_SESSION["user_id"];
$servername = "www.db4free.net";
$username = "webtech7";
$password = "W€btek678";
$db = "restaurantwebapp";
$onlineOrdersY="";
$onlineOrdersN="";
$yelpY="";
$yelpN="";
$name="";
$allGood=FALSE;
$a1="";
$a2="";
$a3="";
$a4="";
$a5="";
$a6="";
$a7="";
$a8="";
$a9="";
$a10="";
$a11="";
$a12="";
$a13="";
$a14="";
$a15="";
$a16="";
$a17="";
$a18="";
$a19="";
$a20="";
$a21="";
$a22="";
$a23="";
$a24="";
$a25="";
$a26="";
$a27="";
$a28="";
$a29="";
$a30="";
$a31="";
$a32="";
$a33="";
$a34="";
$a35="";
$a36="";
$a37="";
$a38="";
$a39="";
$a40="";
$a41="";
$a42="";
$a43="";
$a44="";
$a45="";
$a46="";
$a47="";
$a48="";
$a49="";
$a50="";
$a51="";
$a52="";
$a53="";
$a54="";
$a55="";
$a56="";
$a57="";
$a58="";
$a59="";
$a60="";
$a61="";
$a62="";
$a63="";
$a64="";
$a65="";
$a66="";
$a67="";
$a68="";
$a69="";
$a70="";
$a71="";
$a72="";
$a73="";
$a74="";
$a75="";
$a76="";
$a77="";
$a78="";
$a79="";
$a80="";
$a81="";
$a82="";
$a83="";
$a84="";
$a85="";
$a86="";
$a87="";
$a88="";
$a89="";
$a90=""; 
function test_input($data) {
					$data = trim($data);
					$data = stripslashes($data);
					$data = htmlspecialchars($data);
					return $data;
				}
function replace_dashes($string) {
    $string = str_replace("-", " ", $string);
    return $string;
}
function spatiesnaarstreepjes($string) {
    $string = strtolower($string);
    $string = preg_replace("/[\s-]+/", " ", $string);
    $string = preg_replace("/[\s_]/", "-", $string);
    return $string;
}
// Create connection
$conn = new mysqli($servername, $username, $password, $db);
// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM restaurants WHERE user_id = '$userId'"; 
$result = $conn->query($sql);	
	
	
?>
  <?php 
  require "functions.php";
  showHeader("Edit your restaurant",false);
  ?>
  <div class="image-background jumbotron owner-edit" style="background:url(http://www.restaurantampersand.nl/wp-content/uploads/2013/10/restaurant.jpeg) !important;background-size:cover !important;background-position:center !important;min-height:calc(100vh - 50px);margin-bottom:0;" id="image-background">
 <div class="container"> 
 	<div id='EnzoJumbo'>
 		
 <?php
 if ($result->num_rows > 0) {
 
 $categories=json_decode($data['categories'],true);

if (in_array("Afghan", $categories)) {
    $a1="selected='selected'";
}
if (in_array("African", $categories)) {
    $a2="selected='selected'";
}
if (in_array("American", $categories)) {
    $a3="selected='selected'";
}
if (in_array("Arabian", $categories)) {
    $a4="selected='selected'";
}
if (in_array("Argentine", $categories)) {
    $a5="selected='selected'";
}
if (in_array("asianfusion", $categories)) {
    $a6="selected='selected'";
}
if (in_array("Australian", $categories)) {
    $a7="selected='selected'";
}
if (in_array("Austrian", $categories)) {
    $a8="selected='selected'";
}
if (in_array("Bangladeshi", $categories)) {
    $a9="selected='selected'";
}
if (in_array("Barbeque", $categories)) {
    $a10="selected='selected'";
}
if (in_array("Basque", $categories)) {
    $a11="selected='selected'";
}
if (in_array("beerhall", $categories)) {
    $a12="selected='selected'";
}
if (in_array("Belgian", $categories)) {
    $a13="selected='selected'";
}
if (in_array("Bistros", $categories)) {
    $a14="selected='selected'";
}
if (in_array("Brasseries", $categories)) {
    $a15="selected='selected'";
}
if (in_array("breakfast_brunch", $categories)) {
    $a16="selected='selected'";
}
if (in_array("British", $categories)) {
    $a17="selected='selected'";
}
if (in_array("Buffets", $categories)) {
    $a18="selected='selected'";
}
if (in_array("Burgers", $categories)) {
    $a19="selected='selected'";
}
if (in_array("Burmese", $categories)) {
    $a20="selected='selected'";
}
if (in_array("Cafes", $categories)) {
    $a21="selected='selected'";
}
if (in_array("Cafeteria", $categories)) {
    $a22="selected='selected'";
}
if (in_array("Cajun", $categories)) {
    $a23="selected='selected'";
}
if (in_array("Cambodian", $categories)) {
    $a24="selected='selected'";
}
if (in_array("Caribbean", $categories)) {
    $a25="selected='selected'";
}
if (in_array("Cheesesteaks", $categories)) {
    $a26="selected='selected'";
}
if (in_array("Chech", $categories)) {
    $a27="selected='selected'";
}
if (in_array("Chinese", $categories)) {
    $a28="selected='selected'";
}
if (in_array("Creperies", $categories)) {
    $a29="selected='selected'";
}
if (in_array("Cuban", $categories)) {
    $a30="selected='selected'";
}
if (in_array("Delis", $categories)) {
    $a31="selected='selected'";
}
if (in_array("Diners", $categories)) {
    $a32="selected='selected'";
}
if (in_array("Ethiopian", $categories)) {
    $a33="selected='selected'";
}
if (in_array("hotdogs", $categories)) {
    $a34="selected='selected'";
}
if (in_array("Filipino", $categories)) {
    $a35="selected='selected'";
}
if (in_array("fishnchips", $categories)) {
    $a36="selected='selected'";
}
if (in_array("Fondue", $categories)) {
    $a37="selected='selected'";
}
if (in_array("French", $categories)) {
    $a38="selected='selected'";
}
if (in_array("Gastropubs", $categories)) {
    $a39="selected='selected'";
}
if (in_array("German", $categories)) {
    $a40="selected='selected'";
}
if (in_array("Giblets", $categories)) {
    $a41="selected='selected'";
}
if (in_array("fluten_free", $categories)) {
    $a42="selected='selected'";
}
if (in_array("Greek", $categories)) {
    $a43="selected='selected'";
}
if (in_array("Halal", $categories)) {
    $a44="selected='selected'";
}
if (in_array("Hawaiian", $categories)) {
    $a45="selected='selected'";
}
if (in_array("Himalayan", $categories)) {
    $a46="selected='selected'";
}
if (in_array("hotdog", $categories)) {
    $a47="selected='selected'";
}
if (in_array("Hungarian", $categories)) {
    $a48="selected='selected'";
}
if (in_array("Indian", $categories)) {
    $a49="selected='selected'";
}
if (in_array("Indonesian", $categories)) {
    $a50="selected='selected'";
}
if (in_array("Irish", $categories)) {
    $a51="selected='selected'";
}
if (in_array("Italian", $categories)) {
    $a52="selected='selected'";
}
if (in_array("Japanese", $categories)) {
    $a53="selected='selected'";
}
if (in_array("Korean", $categories)) {
    $a54="selected='selected'";
}
if (in_array("Kosher", $categories)) {
    $a55="selected='selected'";
}
if (in_array("Laotian", $categories)) {
    $a56="selected='selected'";
}
if (in_array("Lebanese", $categories)) {
    $a57="selected='selected'";
}
if (in_array("raw_food", $categories)) {
    $a58="selected='selected'";
}
if (in_array("Malaysian", $categories)) {
    $a59="selected='selected'";
}
if (in_array("Mediterranean", $categories)) {
    $a60="selected='selected'";
}
if (in_array("Mexican", $categories)) {
    $a61="selected='selected'";
}
if (in_array("mideastern", $categories)) {
    $a62="selected='selected'";
}
if (in_array("Mongolian", $categories)) {
    $a63="selected='selected'";
}
if (in_array("Moroccan", $categories)) {
    $a64="selected='selected'";
}
if (in_array("Pakistani", $categories)) {
    $a65="selected='selected'";
}
if (in_array("Peruvian", $categories)) {
    $a66="selected='selected'";
}
if (in_array("Pizza", $categories)) {
    $a67="selected='selected'";
}
if (in_array("Polish", $categories)) {
    $a68="selected='selected'";
}
if (in_array("Portuguese", $categories)) {
    $a69="selected='selected'";
}
if (in_array("Russian", $categories)) {
    $a70="selected='selected'";
}
if (in_array("Salad", $categories)) {
    $a71="selected='selected'";
}
if (in_array("Sandwiches", $categories)) {
    $a72="selected='selected'";
}
if (in_array("Seafood", $categories)) {
    $a73="selected='selected'";
}
if (in_array("Scandinavian", $categories)) {
    $a74="selected='selected'";
}
if (in_array("Singaporean", $categories)) {
    $a75="selected='selected'";
}
if (in_array("soulfood", $categories)) {
    $a76="selected='selected'";
}
if (in_array("Soup", $categories)) {
    $a77="selected='selected'";
}
if (in_array("Southern", $categories)) {
    $a78="selected='selected'";
}
if (in_array("Spanish", $categories)) {
    $a79="selected='selected'";
}
if (in_array("steak", $categories)) {
    $a80="selected='selected'";
}
if (in_array("sushi", $categories)) {
    $a81="selected='selected'";
}
if (in_array("Taiwanese", $categories)) {
    $a82="selected='selected'";
}
if (in_array("tapas", $categories)) {
    $a83="selected='selected'";
}
if (in_array("tapasmallplates", $categories)) {
    $a84="selected='selected'";
}
if (in_array("Turkish", $categories)) {
    $a85="selected='selected'";
}
if (in_array("Ukrainian", $categories)) {
    $a86="selected='selected'";
}
if (in_array("Vegan", $categories)) {
    $a87="selected='selected'";
}
if (in_array("Vegatarian", $categories)) {
    $a88="selected='selected'";
}
if (in_array("Vietnamese", $categories)) {
    $a89="selected='selected'";
}
if (in_array("Wok", $categories)) {
    $a90="selected='selected'";
}

 
 
    echo ' <form method= "POST" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) .'" role="form" class="form-horizontal"><fieldset><legend>Update Restaurant Data</legend>';
    $data = $result->fetch_assoc(); 
	if ($data["online_orders"] == "Y") {
	$onlineOrdersY = "checked='checked'";
	}
	if ($data["online_orders"] == "N") {
	$onlineOrdersN = "checked='checked'";
	}
	if ($data["yelp"] == "Y") {
	$yelpY = "checked='checked'";
	}
	if ($data["yelp"] == "N") {
	$yelpN = "checked='checked'";
	}
$name = replace_dashes($data["name"]);
echo '
<div id="EnzoJumbo2">
<div class="control-group">
  <label class="control-label" for="name">Restaurant name</label>
  <div class="controls">
    <input id="name" name="name" value="' . $name . '" class="input-xlarge"  type="text">
    <p class="help-block"></p>
  </div>
</div>


<div class="control-group">
  <label class="control-label" for="country_code">Country </label>
  <div class="controls">
    <select id="country_code" name="country_code" class="input-xlarge">
<option value="' . $data["country_code"] . '">' . $data["country_code"] . '</option>
<option value="AF">Afghanistan</option>
<option value="AX">Åland Islands</option>
<option value="AL">Albania</option>
<option value="DZ">Algeria</option>
<option value="AS">American Samoa</option>
<option value="AD">Andorra</option>
<option value="AO">Angola</option>
<option value="AI">Anguilla</option>
<option value="AQ">Antarctica</option>
<option value="AG">Antigua and Barbuda</option>
<option value="AR">Argentina</option>
<option value="AM">Armenia</option>
<option value="AW">Aruba</option>
<option value="AU">Australia</option>
<option value="AT">Austria</option>
<option value="AZ">Azerbaijan</option>
<option value="BS">Bahamas</option>
<option value="BH">Bahrain</option>
<option value="BD">Bangladesh</option>
<option value="BB">Barbados</option>
<option value="BY">Belarus</option>
<option value="BE">Belgium</option>
<option value="BZ">Belize</option>
<option value="BJ">Benin</option>
<option value="BM">Bermuda</option>
<option value="BT">Bhutan</option>
<option value="BO">Bolivia</option>
<option value="BA">Bosnia and Herzegovina</option>
<option value="BW">Botswana</option>
<option value="BV">Bouvet Island</option>
<option value="BR">Brazil</option>
<option value="IO">British Indian Ocean Territory</option>
<option value="BN">Brunei Darussalam</option>
<option value="BG">Bulgaria</option>
<option value="BF">Burkina Faso</option>
<option value="BI">Burundi</option>
<option value="KH">Cambodia</option>
<option value="CM">Cameroon</option>
<option value="CA">Canada</option>
<option value="CV">Cape Verde</option>
<option value="KY">Cayman Islands</option>
<option value="CF">Central African Republic</option>
<option value="TD">Chad</option>
<option value="CL">Chile</option>
<option value="CN">China</option>
<option value="CX">Christmas Island</option>
<option value="CC">Cocos (Keeling) Islands</option>
<option value="CO">Colombia</option>
<option value="KM">Comoros</option>
<option value="CG">Congo</option>
<option value="CD">Congo, The Democratic Republic of The</option>
<option value="CK">Cook Islands</option>
<option value="CR">Costa Rica</option>
<option value="CI">Cote D\'ivoire</option>
<option value="HR">Croatia</option>
<option value="CU">Cuba</option>
<option value="CY">Cyprus</option>
<option value="CZ">Czech Republic</option>
<option value="DK">Denmark</option>
<option value="DJ">Djibouti</option>
<option value="DM">Dominica</option>
<option value="DO">Dominican Republic</option>
<option value="EC">Ecuador</option>
<option value="EG">Egypt</option>
<option value="SV">El Salvador</option>
<option value="GQ">Equatorial Guinea</option>
<option value="ER">Eritrea</option>
<option value="EE">Estonia</option>
<option value="ET">Ethiopia</option>
<option value="FK">Falkland Islands (Malvinas)</option>
<option value="FO">Faroe Islands</option>
<option value="FJ">Fiji</option>
<option value="FI">Finland</option>
<option value="FR">France</option>
<option value="GF">French Guiana</option>
<option value="PF">French Polynesia</option>
<option value="TF">French Southern Territories</option>
<option value="GA">Gabon</option>
<option value="GM">Gambia</option>
<option value="GE">Georgia</option>
<option value="DE">Germany</option>
<option value="GH">Ghana</option>
<option value="GI">Gibraltar</option>
<option value="GR">Greece</option>
<option value="GL">Greenland</option>
<option value="GD">Grenada</option>
<option value="GP">Guadeloupe</option>
<option value="GU">Guam</option>
<option value="GT">Guatemala</option>
<option value="GG">Guernsey</option>
<option value="GN">Guinea</option>
<option value="GW">Guinea-bissau</option>
<option value="GY">Guyana</option>
<option value="HT">Haiti</option>
<option value="HM">Heard Island and Mcdonald Islands</option>
<option value="VA">Holy See (Vatican City State)</option>
<option value="HN">Honduras</option>
<option value="HK">Hong Kong</option>
<option value="HU">Hungary</option>
<option value="IS">Iceland</option>
<option value="IN">India</option>
<option value="ID">Indonesia</option>
<option value="IR">Iran, Islamic Republic of</option>
<option value="IQ">Iraq</option>
<option value="IE">Ireland</option>
<option value="IM">Isle of Man</option>
<option value="IL">Israel</option>
<option value="IT">Italy</option>
<option value="JM">Jamaica</option>
<option value="JP">Japan</option>
<option value="JE">Jersey</option>
<option value="JO">Jordan</option>
<option value="KZ">Kazakhstan</option>
<option value="KE">Kenya</option>
<option value="KI">Kiribati</option>
<option value="KP">Korea, Democratic People\'s Republic of</option>
<option value="KR">Korea, Republic of</option>
<option value="KW">Kuwait</option>
<option value="KG">Kyrgyzstan</option>
<option value="LA">Lao People\'s Democratic Republic</option>
<option value="LV">Latvia</option>
<option value="LB">Lebanon</option>
<option value="LS">Lesotho</option>
<option value="LR">Liberia</option>
<option value="LY">Libyan Arab Jamahiriya</option>
<option value="LI">Liechtenstein</option>
<option value="LT">Lithuania</option>
<option value="LU">Luxembourg</option>
<option value="MO">Macao</option>
<option value="MK">Macedonia, The Former Yugoslav Republic of</option>
<option value="MG">Madagascar</option>
<option value="MW">Malawi</option>
<option value="MY">Malaysia</option>
<option value="MV">Maldives</option>
<option value="ML">Mali</option>
<option value="MT">Malta</option>
<option value="MH">Marshall Islands</option>
<option value="MQ">Martinique</option>
<option value="MR">Mauritania</option>
<option value="MU">Mauritius</option>
<option value="YT">Mayotte</option>
<option value="MX">Mexico</option>
<option value="FM">Micronesia, Federated States of</option>
<option value="MD">Moldova, Republic of</option>
<option value="MC">Monaco</option>
<option value="MN">Mongolia</option>
<option value="ME">Montenegro</option>
<option value="MS">Montserrat</option>
<option value="MA">Morocco</option>
<option value="MZ">Mozambique</option>
<option value="MM">Myanmar</option>
<option value="NA">Namibia</option>
<option value="NR">Nauru</option>
<option value="NP">Nepal</option>
<option value="NL">Netherlands</option>
<option value="AN">Netherlands Antilles</option>
<option value="NC">New Caledonia</option>
<option value="NZ">New Zealand</option>
<option value="NI">Nicaragua</option>
<option value="NE">Niger</option>
<option value="NG">Nigeria</option>
<option value="NU">Niue</option>
<option value="NF">Norfolk Island</option>
<option value="MP">Northern Mariana Islands</option>
<option value="NO">Norway</option>
<option value="OM">Oman</option>
<option value="PK">Pakistan</option>
<option value="PW">Palau</option>
<option value="PS">Palestinian Territory, Occupied</option>
<option value="PA">Panama</option>
<option value="PG">Papua New Guinea</option>
<option value="PY">Paraguay</option>
<option value="PE">Peru</option>
<option value="PH">Philippines</option>
<option value="PN">Pitcairn</option>
<option value="PL">Poland</option>
<option value="PT">Portugal</option>
<option value="PR">Puerto Rico</option>
<option value="QA">Qatar</option>
<option value="RE">Reunion</option>
<option value="RO">Romania</option>
<option value="RU">Russian Federation</option>
<option value="RW">Rwanda</option>
<option value="SH">Saint Helena</option>
<option value="KN">Saint Kitts and Nevis</option>
<option value="LC">Saint Lucia</option>
<option value="PM">Saint Pierre and Miquelon</option>
<option value="VC">Saint Vincent and The Grenadines</option>
<option value="WS">Samoa</option>
<option value="SM">San Marino</option>
<option value="ST">Sao Tome and Principe</option>
<option value="SA">Saudi Arabia</option>
<option value="SN">Senegal</option>
<option value="RS">Serbia</option>
<option value="SC">Seychelles</option>
<option value="SL">Sierra Leone</option>
<option value="SG">Singapore</option>
<option value="SK">Slovakia</option>
<option value="SI">Slovenia</option>
<option value="SB">Solomon Islands</option>
<option value="SO">Somalia</option>
<option value="ZA">South Africa</option>
<option value="GS">South Georgia and The South Sandwich Islands</option>
<option value="ES">Spain</option>
<option value="LK">Sri Lanka</option>
<option value="SD">Sudan</option>
<option value="SR">Suriname</option>
<option value="SJ">Svalbard and Jan Mayen</option>
<option value="SZ">Swaziland</option>
<option value="SE">Sweden</option>
<option value="CH">Switzerland</option>
<option value="SY">Syrian Arab Republic</option>
<option value="TW">Taiwan, Province of China</option>
<option value="TJ">Tajikistan</option>
<option value="TZ">Tanzania, United Republic of</option>
<option value="TH">Thailand</option>
<option value="TL">Timor-leste</option>
<option value="TG">Togo</option>
<option value="TK">Tokelau</option>
<option value="TO">Tonga</option>
<option value="TT">Trinidad and Tobago</option>
<option value="TN">Tunisia</option>
<option value="TR">Turkey</option>
<option value="TM">Turkmenistan</option>
<option value="TC">Turks and Caicos Islands</option>
<option value="TV">Tuvalu</option>
<option value="UG">Uganda</option>
<option value="UA">Ukraine</option>
<option value="AE">United Arab Emirates</option>
<option value="GB">United Kingdom</option>
<option value="US">United States</option>
<option value="UM">United States Minor Outlying Islands</option>
<option value="UY">Uruguay</option>
<option value="UZ">Uzbekistan</option>
<option value="VU">Vanuatu</option>
<option value="VE">Venezuela</option>
<option value="VN">Viet Nam</option>
<option value="VG">Virgin Islands, British</option>
<option value="VI">Virgin Islands, U.S.</option>
<option value="WF">Wallis and Futuna</option>
<option value="EH">Western Sahara</option>
<option value="YE">Yemen</option>
<option value="ZM">Zambia</option>
<option value="ZW">Zimbabwe</option>
</select>

  </div>
</div>

<br />

<div class="control-group">
  <label class="control-label" for="city">City</label>
  <div class="controls">
    <input id="city" name="city" value="' . $data["city"] . '" class="input-xlarge" type="text">
    <p class="help-block"></p>
  </div>
</div>




<div class="control-group">
  <label class="control-label" for="address_street">Street</label>
  <div class="controls">
    <input id="address_street" name="address_street" value="' . $data["address_street"] . '" class="input-xlarge" type="text">
    <p class="help-block"></p>
  </div>
</div>


<div class="control-group">
  <label class="control-label" for="address_number">Street number</label>
  <div class="controls">
    <input id="address_number" name="address_number" value="' . $data["address_number"] . '" class="input-xlarge" type="text">
    <p class="help-block"></p>
  </div>
</div>


<div class="control-group">
  <label class="control-label" for="postal_code">Postal code</label>
  <div class="controls">
    <input id="postal_code" name="postal_code" value="' . $data["postal_code"] . '" class="input-xlarge" type="text">
    <p class="help-block"></p>
  </div>
</div>


<div class="control-group">
  <label class="control-label" for="phone">Phone number</label>
  <div class="controls">
    <input id="phone" name="phone" value="' . $data["phone"] . '" class="input-xlarge" type="text">
    <p class="help-block"></p>
  </div>
</div>

<div class="control-group">
<label class="control-label" for="yelp">Categories</label> 
    <br />
<label> <select multiple="multiple" class="form-control" name="categories[]" id="categories">
<option value="Afghan" ' . $a1.'>Afghan</option>
<option value="African" ' . $a2.'>African</option>
<option value="American" ' . $a3.'>American</option>
<option value="Arabian" ' . $a4.'>Arabian</option>
<option value="Argentine" ' . $a5.'>Argentine</option>
<option value="asianfusion" ' . $a6.'>Asian Fusion</option>
<option value="Australian" ' . $a7.'>Australian</option>
<option value="Austrian" ' . $a8.'>Austrian</option>
<option value="Bangladeshi" ' . $a9.'>Bangladeshi</option>
<option value="Barbeque" ' . $a10.'>Barbeque</option>
<option value="Basque" ' . $a11.'>Basque</option>
<option value="beerhall" ' . $a12.'>Beer Hall</option>
<option value="Belgian" ' . $a13.'>Belgian</option>
<option value="Bistros" ' . $a14.' >Bistros</option>
<option value="Brasseries" ' . $a15.'>Brasseries</option>
<option value="breakfast_brunch" ' . $a16.'>Breakfast &amp; brunch</option>
<option value="British" ' . $a17.'>British</option>
<option value="Buffets" ' . $a18.'>Buffets</option>
<option value="Burgers" ' . $a19.'>Burgers</option>
<option value="Burmese" ' . $a20.'>Burmese</option>
<option value="Cafes" ' . $a21.'>Cafes</option>
<option value="Cafetaria" ' . $a22.'>Cafetaria</option>
<option value="Cajun" ' . $a23.'>Cajun</option>
<option value="Cambodian" ' . $a24.'>Cambodian</option>
<option value="Caribbean" ' . $a25.'>Caribbean</option>
<option value="Cheesesteaks" ' . $a26.'>Cheesesteaks</option>
<option value="Chech" ' . $a27.'>Chech</option>
<option value="Chinese" ' . $a28.'>Chinese</option>
<option value="Creperies" ' . $a29.'>Creperies</option>
<option value="Cuban" ' . $a30.'>Cuban</option>
<option value="Delis" ' . $a31.'>Delis</option>
<option value="Diners" ' . $a32.'>Diners</option>
<option value="Ethiopian" ' . $a33.'>Ethiopian</option>
<option value="hotdogs" ' . $a34.'>Fast Food</option>
<option value="Filipino" ' . $a35.'>Filipino</option>
<option value="fishnchips" ' . $a36.'>Fish &amp; Chips</option>
<option value="Fondue" ' . $a37.'>Fondue</option>
<option value="French" ' . $a38.'>French</option>
<option value="Gastropubs" ' . $a39.'>Gastropubs</option>
<option value="German" ' . $a40.'>German</option>
<option value="Giblets" ' . $a41.'>Giblets</option>
<option value="fluten_free" ' . $a42.'>Gluten-free</option>
<option value="Greek" ' . $a43.'>Greek</option>
<option value="Halal" ' . $a44.'>Halal</option>
<option value="Hawaiian" ' . $a45.'>Hawaiian</option>
<option value="Himalayan" ' . $a46.'>Himalayan</option>
<option value="hotdog" ' . $a47.'>Hot Dogs</option>
<option value="Hungarian" ' . $a48.'>Hungarian</option>
<option value="Indian" ' . $a49.'>Indian</option>
<option value="Indonesian" ' . $a50.'>Indonesian</option>
<option value="Irish" ' . $a51.'>Irish</option>
<option value="Italian" ' . $a52.'>Italian</option>
<option value="Japanese" ' . $a53.'>Japanese</option>
<option value="Korean" ' . $a54.'>Korean</option>
<option value="Kosher" ' . $a55.'>Kosher</option>
<option value="Laotian" ' . $a56.'>Laotian</option>
<option value="Lebanese" ' . $a57.'>Lebanese</option>
<option value="raw_food" ' . $a58.'>Live/Raw Food</option>
<option value="Malaysian" ' . $a59.'>Malaysian</option>
<option value="Mediterranean" ' . $a60.'>Mediterranean</option>
<option value="Mexican" ' . $a61.'>Mexican</option>
<option value="mideastern" ' . $a62.'>Middle Eastern</option>
<option value="Mongolian" ' . $a63.'>Mongolian</option>
<option value="Moroccan" ' . $a64.'>Moroccan</option>
<option value="Pakistani" ' . $a65.'>Pakistani</option>
<option value="Peruvian" ' . $a66.'>Peruvian</option>
<option value="Pizza" ' . $a67.'>Pizza</option>
<option value="Polish" ' . $a68.'>Polish</option>
<option value="Portuguese" ' . $a69.'>Portuguese</option>
<option value="Russian" ' . $a70.'>Russian</option>
<option value="Salad" ' . $a71.'>Salad</option>
<option value="Sandwiches" ' . $a72.'>Sandwiches</option>
<option value="Seafood" ' . $a73.'>Seafood</option>
<option value="Scandinavian" ' . $a74.'>Scandinavian</option>
<option value="Singaporean" ' . $a75.'>Singaporean</option>
<option value="soulfood" ' . $a76.'>Soul Food</option>
<option value="Soup" ' . $a77.'>Soup</option>
<option value="Southern" ' . $a78.'>Southern</option>
<option value="Spanish" ' . $a79.'>Spanish</option>
<option value="steak" ' . $a80.'>Steakhouses</option>
<option value="sushi" ' . $a81.'>Sushi Bars</option>
<option value="Taiwanese" ' . $a82.'>Taiwanese</option>
<option value="tapas" ' . $a83.'>Tapas Bars</option>
<option value="tapasmallplates" ' . $a84.'>Tapas/Small Plates</option>
<option value="Turkish" ' . $a85.'>Turkish</option>
<option value="Ukrainian" ' . $a86.'>Ukrainian</option>
<option value="Vegan" ' . $a87.'>Vegan</option>
<option value="Vegetarian" ' . $a88.'>Vegetarian</option>
<option value="Vietnamese" ' . $a89.'>Vietnamese</option>
<option value="Wok" ' . $a90.'>Wok</option>
                      </select> 
</div>
</label>
<p class="help-block">Hold down Ctrl or &#8984; to select multiple categories</p>

<div class="control-group">
<label class="control-label" for="order_online">Online Ordering</label>
   <div class="radio">
  <label><input type="radio"  name="order_online" value = "Y" ' . $onlineOrdersY . '>Yes  </label>
</div>
<div class="radio">
  <label><input type="radio" name="order_online" value= "N" ' . $onlineOrdersN . '>No   </label>
</div>

<div class="control-group">
  <label class="control-label" for="distance">Order proximity</label>
  <div class="controls">
    <input id="distance" name="distance" class="form-control"  placeholder="" value="' .$data["distance"] . '"class="input-xlarge" type="number">
    <p class="help-block">Numbers only, must be in kilometers <br /> </p>
  </div>
</div>

<div class="control-group">
<label class="control-label" for="yelp">Yelp</label>
   <div class="radio">
  <label><input type="radio" id="yelp-y" name="yelp" value = "Y" ' . $yelpY . '>Yes  </label>
</div>
<div class="radio">
  <label><input type="radio" name="yelp" value= "N" ' . $yelpN . '>No   </label>
</div>  
  
 
</div>
<br />
<div class="control-group">
<div class ="controls">
<button type="submit" class="btn btn-default">Submit</button>
<p class="help-block">Click to submit!</p>
</div>
</div>
</fieldset>
</form>

';
    
} else {
    echo 'You are not yet a restaurant owner.';
}
$conn->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

if (empty($_POST["name"])) {
	$nameError="Required";
	$allGood=false;
	}
	
	if (!empty($_POST["name"])) {
	$nameFirst=test_input($_POST["name"]);
	if (preg_match ('/[a-zA-Z ]/', $nameFirst)) {
	$allGood=true;
	$name=$nameFirst;
	$id=spatiesnaarstreepjes($name);
	
	}
	if(!preg_match ('/[a-zA-Z ]/', $nameFirst)) {
	$nameError = "Must exist out of letters and spaces only";
	$allGood= FALSE;
	}
	}
	
	if (empty($_POST["city"])) {
	$cityError="Required";
	$allGood=false;
	}
	if (!empty($_POST["city"])) {
	$cityFirst=test_input($_POST["city"]);
	if (preg_match ('/[a-zA-Z ]/', $cityFirst)) {
	$allGood=true;
	$city=$cityFirst;
	}
	if(!preg_match ('/[a-zA-Z ]/', $cityFirst)) {
	$cityError = "Must exist out of letters and spaces only";
	$allGood= FALSE;
	}
	}
	
	if (empty($_POST["address_street"])) {
	$addressStreetError="Required";
	$allGood=false;
	}
	if (!empty($_POST["address_street"])) {
	$addressStreetFirst=test_input($_POST["address_street"]);
	if (preg_match ('/[a-zA-Z ]/', $addressStreetFirst)) {
	$allGood=true;
	$addressStreet=$addressStreetFirst;
	}
	if(!preg_match ('/[a-zA-Z ]/', $addressStreetFirst)) {
	$addressStreetError = "Must exist out of letters and spaces only";
	$allGood= FALSE;
	}
	}

	if (empty($_POST["address_number"])) {
	$addressNumberError="Required";
	$allGood=false;
	}
	if (!empty($_POST["address_number"])) {
	$addressNumberFirst=test_input($_POST["address_number"]);
	if (preg_match ('/[a-zA-Z0-9 ]/', $addressNumberFirst)) {
	$allGood=true;
	$addressNumber=$addressNumberFirst;
	}
	if(!preg_match ('/[a-zA-Z0-9 ]/', $addressNumberFirst)) {
	$addressNumberError = "Must exist out of numbers, letters and spaces only";
	$allGood= FALSE;
	}
	}
	
	if (empty($_POST["postal_code"])) {
	$postalCodeError="Required";
	$allGood=false;
	}
	if (!empty($_POST["postal_code"])) {
	$postalCodeFirst=test_input($_POST["postal_code"]);
	if (preg_match ('/[a-zA-Z0-9 ]/', $postalCodeFirst)) {
	$allGood=true;
	$postalCode=$postalCodeFirst;
	}
	if(!preg_match ('/[a-zA-Z0-9 ]/', $postalCodeFirst)) {
	$postalCodeError = "Must exist out of numbers, letters and spaces only";
	$allGood= FALSE;
	}
	}
	
	if (empty($_POST["phone"])) {
	$phoneError="Required";
	$allGood=false;
	}
	if (!empty($_POST["phone"])) {
	$phoneFirst=test_input($_POST["phone"]);
	if (preg_match ('/[0-9 ]/', $phoneFirst)) {
	$allGood=true;
	$phone=$phoneFirst;
	}
	if(!preg_match ('/[0-9 ]/', $phoneFirst)) {
	$phoneError = "Must exist out of numbers and spaces only";
	$allGood= FALSE;
	}
	}
	
	
	if (empty($_POST["country_code"])) {
	$countryError= "Required";
	$allGood= false;
	
	}
	if (!empty($_POST["country_code"])){
	$country = $_POST["country_code"];
	$allGood = true;
	} 
	
	
	if (empty($_POST["order_online"])) {
	$orderOnlineError= "Required";
	$allGood= false;
	
	}
	if (!empty($_POST["order_online"])){
	$orderOnline = $_POST["order_online"];
	$allGood = true;
	}
	
	if (empty($_POST["yelp"])) {
	$yelpError= "Required";
	$allGood= false;
	
	}
	if (!empty($_POST["yelp"])){
	$yelp = $_POST["yelp"];
	$allGood = true;
	}
	
		if (!empty($_POST["distance"])) {
	$distanceFirst=test_input($_POST["distance"]);
	if (preg_match ('/[0-9]/', $distanceFirst)) {
	$allGood=true;
	$distance=$distanceFirst;
	}
	if(!preg_match ('/[0-9]/', $distanceFirst)) {
	$distanceError = "Must exist out of numbers only";
	$allGood= FALSE;
	}
	}
	
		if (empty($_POST["categories"])) {
	$allGood= false;
	
	}
	if (!empty($_POST["categories"])){
        $categories1 = $_POST["categories"];
        $categories= json_encode($categories1);
        $allGood = true;
	} else {
        $categories = "";
        $allGood = true;
    }
	
	
	
}

if ($allGood == true) {



// Create connection
$conn = new mysqli($servername, $username, $password, $db);
// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}

$sql = "UPDATE restaurants SET  
                            name='$name',
							id='$id', 
							phone='$phone', 
							postal_code='$postalCode', 
							online_orders='$orderOnline', 
							address_street='$addressStreet', 
							address_number='$addressNumber', 
							city='$city', 
							country_code='$country',
							distance='$distance',
							yelp='$yelp',
							categories='$categories'
							WHERE user_id='$userId'"; 

if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully, refresh the page to see your new information";
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();


}

}
Else {
echo "Please log in";

}
?>
 
 </div>
 </div>
 </div>
 

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
      <script src="js/main.js"></script>
  </body>
</html>
