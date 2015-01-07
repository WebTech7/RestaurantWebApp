$(document).ready(function(){
    height = $(".navbar").outerHeight();
    $("body").css('padding-top', height);
    $(".sidebar").css('top', height);
    height = $("#specify").outerHeight() - $("#results-for-header").outerHeight();
    $("#map").css('height', height);
    $("#googleMap").css('height', height);
    $("#sort-wrap").css('margin-top', 0);
    if($("#results-for-header").outerHeight() != 73){
        $("#sort-wrap").css('margin-top', 20);
    } else {
        $("#sort-wrap").css('margin-top', 0);
    }
});

$(window).resize(function(){
    height = $(".navbar").outerHeight();
    $("body").css('padding-top', height);
    $(".sidebar").css('top', height);
    height = $("#specify").outerHeight() - $("#results-for-header").outerHeight();
    $("#map").css('height', height);
    $("#googleMap").css('height', height);
    $("#sort-wrap").css('margin-top', 0);
    if($("#results-for-header").outerHeight() != 73){
        $("#sort-wrap").css('margin-top', 20);
    } else {
        $("#sort-wrap").css('margin-top', 0);
    }
});

            loginScreen = false;

            function showLogin(){
                $("#login-form").show();
                $("#signup-form").hide();
                $("#login-without-fb").show();
                $("#signup-without-fb").hide();
                $(".login-button").css('background', '#CCC');
                $(".signup-button").css('background', '#e6e6e6');
                $(".login-button").css('pointer-events', 'none');
                $(".signup-button").css('pointer-events', 'auto');
                        $(".fb-login-button").html("<h3>FACEBOOK LOGIN</h3>");
            }

            function showSignUp(){
                $("#signup-form").show();
                $("#login-form").hide();
                $("#signup-without-fb").show();
                $("#login-without-fb").hide();
                $(".signup-button").css('background', '#CCC');
                $(".login-button").css('background', '#e6e6e6');
                $(".signup-button").css('pointer-events', 'none');
                $(".login-button").css('pointer-events', 'auto');
                        $(".fb-login-button").html("<h3>FACEBOOK SIGN UP</h3>");
            }

            function openLogin(type){
                $("#login-screen-wrapper").show();
                if(type == 'login'){
                    showLogin();
                } else if(type == 'signup'){
                    showSignUp();
                }
            }

            $("#login-screen-wrapper").on('click', function() {
              $("#login-screen-wrapper").hide();
            }).children().on('click',function(){
                return false;
            });

             $(".login-screen-cross").on('click', function() {
                $("#login-screen-wrapper").hide();
            })

            $(document).ready(function(){
                $("#login-screen-wrapper").hide();
            });

            function checkEmail(email) {
                var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            }

            function submitSignUp(){
                    $("#signup-feedback-success").hide();
                    $("#signup-feedback-danger").hide();
                    $("#ajax-response").show();
                if(checkEmail($("#signup-email").val())){
                    $.post( "signup.php", {email: $("#signup-email").val()} , function( data ) {
                      $( "#ajax-response" ).html( data );
                        $(".remove-signup").hide();
                    });
                } else {
                   document.getElementById("signup-feedback-danger").innerHTML = 'This is not a valid email address.';
                    $("#signup-feedback-danger").show();
                    $("#signup-feedback-success").hide();
                    $("#ajax-response").hide();
                }
            }

            function loginSuccess(){
                if($("#login-email").val() == 'success'){
                    return true;
                } else {
                    return false;
                }
            }

            function login(){
                //some AJAX
            }

            function submitLogin(){
                if(loginSuccess()){
                    $("#login-screen-wrapper").hide();
                    $("#signup-feedback-danger").hide();
                    login();
                } else {
                    $("#login-feedback-danger").show();
                    document.getElementById("login-feedback-danger").innerHTML = 'The combination of email address and password is not known by us.';
                }
            }

            var clicked = 0;

            $(".star-large-none").click(function(){
                clicked = 0;
                emptySrc = 'https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_empty.png';
                for(a=0;a<=5;a++){
                    $("#"+a+"").attr("src", emptySrc);
                }
                refineRating(0);
                $("#hidden-rating").html("0");
                $(".star-large-none").hide();
            });

            $(".star-large").click(function(){
                $(".star-large-none").show();
                clicked = 0;
                emptySrc = 'https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_empty.png';
                    this.src = emptySrc;
                    for(a=0;a<=5;a++){
                        $("#"+a+"").attr("src", emptySrc);
                    }
                fullSrc = 'https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_full.png';
                this.src = fullSrc;
                for(a=0;a<$(this).val();a++){
                    $("#"+a+"").attr("src", fullSrc);
                    if(a+1==$(this).val()){refineRating($(this).val());}
                }
                clicked = $(this).val();
                $("#hidden-rating").html($(this).val());
            });
            $(".star-large").hover(function(){
                emptySrc = 'https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_empty.png';
                    this.src = emptySrc;
                    for(a=0;a<=5;a++){
                        $("#"+a+"").attr("src", emptySrc);
                    }
                fullSrc = 'https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_full.png';
                this.src = fullSrc;
                for(a=1;a<=$(this).val();a++){
                    $("#"+a+"").attr("src", fullSrc);
                }
            }, function(){
                    fullSrc = 'https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_full.png';
                    emptySrc = 'https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_empty.png';
                    for(a=0;a<=5;a++){
                        if(a > parseInt(clicked)){
                            $("#"+a+"").attr("src", emptySrc);
                        } else {
                            $("#"+a+"").attr("src", fullSrc);
                        }
                }
            });

function submitTopSearch(){
    $("#sort-by").val(0);
    $("#radius").val("");
    $("#kind-of-rest").val("");
    $("#order").val("");
    var askedArray = new Array();
    askedArray["q"] = $("#top-search-q").val();
    askedArray["place"] = $("#top-search-place").val();
    askedArray["useq"] = 1;
    refreshResults(askedArray);
    resultsfor = "";
    title = "";
    if($("#top-search-q").val() != ""){
        resultsfor = "<i>" + resultsfor + $("#top-search-q").val() + "</i> around ";
        title = title + $("#top-search-q").val() + " | ";
    }
    if($("#top-search-place").val() != ""){
        resultsfor = resultsfor + "<i>" + $("#top-search-place").val() + "</i>";
        title = title + $("#top-search-place").val();
    } else {
        resultsfor = resultsfor + "<i>" + $.cookie("place") + "</i>";
        title = title + $.cookie("place");
    }
    document.getElementById("results-for").innerHTML = resultsfor;
    $(document).prop('title', title + ' | RestaurantWebApp');
}

function refreshResults(askedArray){
    $("#results-loading").css('z-index', 1000);
    $("#results-loading").css('opacity', 0.9);
    get = "";
    get = get + "&radius_filter=" + $("#radius").val();
    get = get + "&rating=" + $("#hidden-rating").html();
    get = get + "&sort=" + $("#sort-by").val();
    get = get + "&order=" + $("#order").val();
    get = get + "&kindofrest=" + $("#kind-of-rest").val();
    if(askedArray.hasOwnProperty("q")){
        get = get + "&q="+askedArray["q"];
    }
    if(askedArray.hasOwnProperty("place")){
        get = get + "&place="+askedArray["place"];
    }
    if(askedArray.hasOwnProperty("sort")){
        get = get + "&sort=" + askedArray["sort"];
        get = get + "&q=" + document.getElementById("current-q").innerHTML;
    }
    if(askedArray.hasOwnProperty("radius_filter")){
        get = get + "&radius_filter=" + askedArray["radius_filter"];
        get = get + "&q=" + document.getElementById("current-q").innerHTML;
    }
    if(askedArray.hasOwnProperty("rating")){
        get = get + "&rating=" + askedArray["rating"];
        get = get + "&q=" + document.getElementById("current-q").innerHTML;
    }
    if(askedArray.hasOwnProperty("kindofrest")){
        get = get + "&kindofrest=" + (askedArray["kindofrest"]);
        get = get + "&q=" + document.getElementById("current-q").innerHTML;
    }
    if(askedArray.hasOwnProperty("order")){
        get = get + "&order=" + (askedArray["order"]);
        get = get + "&q=" + document.getElementById("current-q").innerHTML;
    }
    if(askedArray.hasOwnProperty("usecookieget")){
        if(askedArray["usecookieget"]){
            get = get + "&usecookieget=1";
        }
    }
    if(askedArray.hasOwnProperty("useq")){
        if(askedArray["useq"]){
            get = get + "&useq=1";
        }
    }
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("results-content-wrapper").innerHTML = xmlhttp.responseText;
            $("#results-loading").css('opacity', 0);
            height = $("#specify").outerHeight() - $("#results-for-header").outerHeight();
            $("#map").css('height', height);

myCenter=new google.maps.LatLng(51.508742,-0.120850);

google.maps.event.addDomListener(window, 'load', function(){var mapProp = {
  center:myCenter,
  zoom:5,
  mapTypeId:google.maps.MapTypeId.ROADMAP
  };

var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);

var marker=new google.maps.Marker({
  position:myCenter,
  });

marker.setMap(map);});
                if($("#choose-list").hasClass("active")){
                    $("#list").show();
                    $("#map").hide();
                } else {
                    $("#list").hide();
                    $("#map").show();
                }
            setTimeout(function(){
                $("#results-loading").css('z-index', -20);
            }, 500);
            if($("#results-for-header").outerHeight() != 73){
                $("#sort-wrap").css('margin-top', 20);
            } else {
                $("#sort-wrap").css('margin-top', 0);
            }
        }
    }
    xmlhttp.open("GET", "refreshResults.php?"+get, true);
    xmlhttp.send();
}

$("#sort-by").on("change", function(){
    var askedArray = new Array();
    askedArray["sort"] = $("#sort-by").val();
    askedArray["usecookieget"] = 1;
    refreshResults(askedArray);
});

$("#kind-of-rest").on("change", function(){
    var askedArray = new Array();
    askedArray["kindofrest"] = $("#kind-of-rest").val();
    askedArray["usecookieget"] = 1;
    refreshResults(askedArray);
});

$("#order").on("change", function(){
    var askedArray = new Array();
    askedArray["order"] = $("#order").val();
    askedArray["usecookieget"] = 1;
    refreshResults(askedArray);
});

$("#radius").on("change", function(){
    var askedArray = new Array();
    askedArray["radius_filter"] = $("#radius").val();
    askedArray["usecookieget"] = 1;
    refreshResults(askedArray);
});

function refineRating(rating){
    var askedArray = new Array();
    askedArray["rating"] = rating;
    askedArray["usecookieget"] = 1;
    refreshResults(askedArray);
}

var points = 0;
function topSearchLocation() {
    if (navigator.geolocation) {
        $("#location-or-load").attr('src', 'http://www.ballarat.vic.gov.au/media/2651383/loading.gif');
        navigator.geolocation.getCurrentPosition(showTopPosition);
    } else {
        alert("Geolocation is not supported by this browser.");
    }
}

function showTopPosition(position) {
    str = position.coords.latitude + ',' + position.coords.longitude;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                $("#top-search-place").val(xmlhttp.responseText);
                $("#top-search-place").css('background-color', '#86cea6');
                $("#top-search-place").css('border-color', '#86cea6');
                setTimeout(function(){$("#top-search-place").css('background-color', '#FFF');
                $("#top-search-place").css('border-color', '#ccc');}, 300);
                $("#location-or-load").attr('src', 'https://cdn2.iconfinder.com/data/icons/flat-ui-icons-24-px/24/location-24-48.png');
            }
        }
        xmlhttp.open("GET", "geo.php?latlng=" + str, true);
        xmlhttp.send();
}


function showList(){
  $("#choose-map").attr("class", "");
  $("#choose-list").attr("class", "active");
  $("#list").show();
  $("#map").hide();
    $("#results-content-wrapper").css('padding', '0px 10px');
    $(".results").css('padding-bottom', 25);
}

function showMap(){
  $("#choose-map").attr("class", "active");
  $("#choose-list").attr("class", "");
  $("#list").hide();
  $("#map").show();
    $("#results-content-wrapper").css('padding', 0);
    $(".results").css('padding-bottom', 0);
}
