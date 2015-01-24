<?php 
session_start();require "functions.php";
  showHeader("Edit your restaurant",false);
if (isset($_SESSION["logged_in"]) ){
$loggedIn= $_SESSION["logged_in"];
$userId = $_SESSION["user_id"];
$alreadyOwner="";
$alreadyOwnerError="";
$nameExists="";
$nameExistsError="";
$dbinsert="";
$name ="";
$nameError ="";
$city="";
$cityError="";
$addressStreet="";
$addressStreetError="";
$addressNumber="";
$addressNumberError="";
$postalCode="";
$postalCodeError="";
$phone="";
$phoneError="";
$allGood=false;
$orderOnline="";
$orderOnlineError="";
$country="";
$countryError="";
$id="";
$yelp="";
$yelpError="";
$yelpId="";
$categories="";

function test_input($data) {
					$data = trim($data);
					$data = stripslashes($data);
					$data = htmlspecialchars($data);
					return $data;
				}
				
function spatiesnaarstreepjes($string) {
    $string = strtolower($string);
    $string = preg_replace("/[\s-]+/", " ", $string);
    $string = preg_replace("/[\s_]/", "-", $string);
    return $string;
}				
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
	
	if (empty($_POST["yelpId"])) {
	$allGood= false;
	
	}
	if (!empty($_POST["yelp"])){
	$yelpId = $_POST["yelp"];
	$allGood = true;
	}
	
	if (empty($_POST["categories"])) {
	$allGood= false;
	
	}
	if (!empty($_POST["categories"])){
	$categories1 = $_POST["categories"];
	$categories= json_encode($categories1);
	$allGood = true;
	}
}

if ($allGood == true) {
$servername = "www.db4free.net";
$username = "webtech7";
$password = "W€btek678";
$db = "restaurantwebapp";
// Create connection
$conn = new mysqli($servername, $username, $password, $db);
// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT id FROM restaurants where user_id='$userId'";
$result=$conn->query($sql);
if ($result->num_rows > 0) {
$alreadyOwner=true;
$alreadyOwnerError="You are already an owner";
} else {
$alreadyOwner=false;
$alreadyOwnerError="";

}
$sql = "SELECT id FROM restaurants where id='$id'";
$result=$conn->query($sql);
if ($result->num_rows > 0) {
$nameExists=true;
$nameExistsError="The name already exists";
}else {
$nameExists=false;
$nameExistsError="";
}
if ($alreadyOwner==false AND $nameExists ==false){ 
$sql = "INSERT INTO restaurants (user_id, id, phone, postal_code, online_orders, address_street, address_number, city, country_code, name, yelp, yelp_id, categories)
VALUES ('$userId','$id', '$phone', '$postalCode', '$orderOnline', '$addressStreet', '$addressNumber', '$city', '$country', '$name', '$yelp', '$yelpId', '$categories')";
if ($conn->query($sql) === TRUE) {
    $dbinsert="Everything went well";
} else {
    $dbinsert= "Error: " . $sql . "<br>" . $conn->error;
}


}
}
}
?>
  </head>
  <body>
  	<div class="image-background jumbotron" style="background:url(http://www.restaurantampersand.nl/wp-content/uploads/2013/10/restaurant.jpeg) !important;background-size:cover !important;background-position:center !important;min-height:calc(100vh - 50px);margin-bottom:0;" id="image-background">
 <div class="container"> 
 <?php 
if (isset($_SESSION["logged_in"]) ){ ?> 
<div id='EnzoJumbo'>
    <form method= "POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" role="form" class="form-horizontal">
<fieldset>


<legend>Submit restaurant</legend>


<div class="control-group">
  <label class="control-label" for="name">Restaurant name</label>
  <div class="controls">
    <input id="name" name="name" placeholder="" class="input-xlarge"  type="text">
    <p class="help-block"><?php echo $nameError; ?></p>
  </div>
</div>


<div class="control-group">
  <label class="control-label" for="country_code">Country <?php echo $countryError;?></label>
  <div class="controls">
    <select id="country_code" name="country_code" class="input-xlarge">
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
<option value="CI">Cote D'ivoire</option>
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
<option value="KP">Korea, Democratic People's Republic of</option>
<option value="KR">Korea, Republic of</option>
<option value="KW">Kuwait</option>
<option value="KG">Kyrgyzstan</option>
<option value="LA">Lao People's Democratic Republic</option>
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


<div class="control-group">
  <label class="control-label" for="city">City</label>
  <div class="controls">
    <input id="city" name="city" placeholder="" class="input-xlarge" type="text">
    <p class="help-block"><?php echo $cityError; ?></p>
  </div>
</div>


<div class="control-group">
  <label class="control-label" for="address_street">Street</label>
  <div class="controls">
    <input id="address_street" name="address_street" placeholder="" class="input-xlarge" type="text">
    <p class="help-block"><?php echo $addressStreetError; ?></p>
  </div>
</div>


<div class="control-group">
  <label class="control-label" for="address_number">Street number</label>
  <div class="controls">
    <input id="address_number" name="address_number" placeholder="" class="input-xlarge" type="text">
    <p class="help-block"><?php echo $addressNumberError; ?></p>
  </div>
</div>


<div class="control-group">
  <label class="control-label" for="postal_code">Postal code</label>
  <div class="controls">
    <input id="postal_code" name="postal_code" placeholder="" class="input-xlarge" type="text">
    <p class="help-block"><?php echo $postalCodeError; ?></p>
  </div>
</div>


<div class="control-group">
  <label class="control-label" for="phone">Phone number</label>
  <div class="controls">
    <input id="phone" name="phone" placeholder="" class="input-xlarge" type="text">
    <p class="help-block"><?php echo $phoneError; ?></p>
  </div>
</div>

<div class="control-group">
<label class="control-label" for="order_online">Online Ordering</label>
   <div class="radio">
  <label><input type="radio" name="order_online" value = "Y">Yes  <?php echo $orderOnlineError; ?></label>
</div>
<div class="radio">
  <label><input type="radio" name="order_online" value= "N">No  <?php echo $orderOnlineError; ?> </label>
</div>

<div class="control-group">
<label class="control-label" for="yelp">Yelp</label>
   <div class="radio">
  <label><input type="radio" name="yelp" value = "Y">Yes  <?php echo $yelpError; ?></label>
</div>
<div class="radio">
  <label><input type="radio" name="yelp" value= "N">No  <?php echo $yelpError; ?> </label>
</div> 

<div class="control-group">
<label class="control-label" for="yelp">Categories</label> 
<label> <select multiple="multiple" class="form-control" name="categories[]" id="categories">
<option value="Afghan">Afghan</option>
<option value="African">African</option>
<option value="American">American</option>
<option value="Arabian">Arabian</option>
<option value="Argentine">Argentine</option>
<option value="asianfusion">Asian Fusion</option>
<option value="Australian">Australian</option>
<option value="Austrian">Austrian</option>
<option value="Bangladeshi">Bangladeshi</option>
<option value="Barbeque">Barbeque</option>
<option value="Basque">Basque</option>
<option value="beerhall">Beer Hall</option>
<option value="Belgian">Belgian</option>
<option value="Bistros">Bistros</option>
<option value="Brasseries">Brasseries</option>
<option value="breakfast_brunch">Breakfast &amp; brunch</option>
<option value="British">British</option>
<option value="Buffets">Buffets</option>
<option value="Burgers">Burgers</option>
<option value="Burmese">Burmese</option>
<option value="Cafes">Cafes</option>
<option value="Cafetaria">Cafetaria</option>
<option value="Cajun">Cajun</option>
<option value="Cambodian">Cambodian</option>
<option value="Caribbean">Caribbean</option>
<option value="Cheesesteaks">Cheesesteaks</option>
<option value="Chech">Chech</option>
<option value="Chinese">Chinese</option>
<option value="Creperies">Creperies</option>
<option value="Cuban">Cuban</option>
<option value="Delis">Delis</option>
<option value="Diners">Diners</option>
<option value="Ethiopian">Ethiopian</option>
<option value="hotdogs">Fast Food</option>
<option value="Filipino">Filipino</option>
<option value="fishnchips">Fish &amp; Chips</option>
<option value="Fondue">Fondue</option>
<option value="French">French</option>
<option value="Gastropubs">Gastropubs</option>
<option value="German">German</option>
<option value="Giblets">Giblets</option>
<option value="fluten_free">Gluten-free</option>
<option value="Greek">Greek</option>
<option value="Halal">Halal</option>
<option value="Hawaiian">Hawaiian</option>
<option value="Himalayan">Himalayan</option>
<option value="hotdog">Hot Dogs</option>
<option value="Hungarian">Hungarian</option>
<option value="Indian">Indian</option>
<option value="Indonesian">Indonesian</option>
<option value="Irish">Irish</option>
<option value="Italian">Italian</option>
<option value="Japanese">Japanese</option>
<option value="Korean">Korean</option>
<option value="Kosher">Kosher</option>
<option value="Laotian">Laotian</option>
<option value="Lebanese">Lebanese</option>
<option value="raw_food">Live/Raw Food</option>
<option value="Malaysian">Malaysian</option>
<option value="Mediterranean">Mediterranean</option>
<option value="Mexican">Mexican</option>
<option value="mideastern">Middle Eastern</option>
<option value="Mongolian">Mongolian</option>
<option value="Moroccan">Moroccan</option>
<option value="Pakistani">Pakistani</option>
<option value="Peruvian">Peruvian</option>
<option value="Pizza">Pizza</option>
<option value="Polish">Polish</option>
<option value="Portuguese">Portuguese</option>
<option value="Russian">Russian</option>
<option value="Salad">Salad</option>
<option value="Sandwiches">Sandwiches</option>
<option value="Seafood">Seafood</option>
<option value="Scandinavian">Scandinavian</option>
<option value="Singaporean">Singaporean</option>
<option value="soulfood">Soul Food</option>
<option value="Soup">Soup</option>
<option value="Southern">Southern</option>
<option value="Spanish">Spanish</option>
<option value="steak">Steakhouses</option>
<option value="sushi">Sushi Bars</option>
<option value="Taiwanese">Taiwanese</option>
<option value="tapas">Tapas Bars</option>
<option value="tapasmallplates">Tapas/Small Plates</option>
<option value="Turkish">Turkish</option>
<option value="Ukrainian">Ukrainian</option>
<option value="Vegan">Vegan</option>
<option value="Vegetarian">Vegetarian</option>
<option value="Vietnamese">Vietnamese</option>
<option value="Wok">Wok</option>
                      </select> 
<input type="hidden" name="yelpId" value=""> 
</div>
</label>
<p class="help-block">Hold down ctrl to select multiple categories</p>
<div class="control-group">
<div class ="controls">
<button type="submit" class="btn btn-default">Submit</button>
<p class="help-block">Click to submit!</p>
</div>
</div>
</fieldset>
</form>
<?php echo $dbinsert . "<br />" . $nameExistsError . "<br />" . $alreadyOwnerError; 
} // voor logged in if af te sluiten
else {
echo "<div class='jumbotron'>Please log in and try again";header("Location: login.php");
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
