<?php 

$restaurantId = "restaurant-naam" ; 
//Hier moet het restaurant ID komen dat we uit de api halen, volgens Yelp documentatie is dit een string.

?>

<a href="restaurant.php?id=<?php echo $restaurantId; ?>">Click here to go to the restaurants page</a> 
<!-- Dit is de link die per restaurant er bij moet staan, waarschijnlijk dus in de for functie die alle resultaten uit de api haalt -->


