$(document).ready(function(){
    height = $(".navbar").outerHeight();
    $("body").css('padding-top', height);
    $(".sidebar").css('top', height);
});

$(window).resize(function(){
    height = $(".navbar").outerHeight();
    $("body").css('padding-top', height);
    $(".sidebar").css('top', height);
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
                if(email.length > 1){
                    return true;
                } else {
                    return false;
                }
            }
            
            function submitSignUp(){
                if(checkEmail($("#signup-email").val())){
                    document.getElementById("signup-feedback-success").innerHTML = 'A verification email has been sent to your email address. Click the verification link in the email, set your password and you\'re done.';
                    $("#signup-feedback-success").show();
                    $("#signup-feedback-danger").hide();
                } else {
                   document.getElementById("signup-feedback-danger").innerHTML = 'This is not a valid email address.';
                    $("#signup-feedback-danger").show();
                    $("#signup-feedback-success").hide();
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
    var askedArray = new Array();
    askedArray["q"] = $("#top-search-q").val();
    askedArray["place"] = $("#top-search-place").val();
    askedArray["useq"] = 1;
    refreshResults(askedArray);
    resultsfor = "";
    if($("#top-search-q").val() != ""){
        resultsfor = "<i>" + resultsfor + $("#top-search-q").val() + "</i> around ";
    }
    if($("#top-search-place").val() != ""){
        resultsfor = resultsfor + "<i>" + $("#top-search-place").val() + "</i>";
    } else {
        resultsfor = resultsfor + "<i>" + $.cookie("place") + "</i>";
    }
    document.getElementById("results-for").innerHTML = resultsfor;
    $("#sort-by").val(0);
    $("#radius").val("");
}

function refreshResults(askedArray){
    $("#results-loading").css('z-index', 1000);
    $("#results-loading").css('opacity', 0.9);
    get = "";
    get = get + "&radius_filter=" + $("#radius").val();
    get = get + "&rating=" + $("#hidden-rating").html();
    get = get + "&sort=" + $("#sort-by").val();
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
            setTimeout(function(){
                //alert("hey");
                $("#results-loading").css('z-index', -20);
            }, 500);
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