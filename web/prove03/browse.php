<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Shopping</title>
		<link rel="stylesheet" type="text/css" href="stylesheet.css">

		<script type="text/javascript">
		<?php
			// used to see if the page has been redirected from another page
			if ($_SESSION.exists) {
				echo "var sessionIsActiveBefore = true;";
			}
			else {
				echo "var sessionIsActiveBefore = false;";
			}
		?>

			function addToCart(item, itemID) {

				// create a requst to json file with all data and parse for table display
				var xmlhttp = new XMLHttpRequest();

				xmlhttp.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						var result = this.responseText;

						// toggle in or out of cart
						document.getElementById(itemID).value = result;
					}
				};

				// check if not added to the cart already
				if (sessionIsActiveBefore){
					xmlhttp.open("post", "mycart2.php?" + item + "=" + "-2", true);
					xmlhttp.send();

				} else if (document.getElementById(itemID).value === "Add to Cart") {


					xmlhttp.open("post", "mycart2.php?" + item + "=" + itemID, true);
					xmlhttp.send();

				} else if (document.getElementById(itemID).value === "Added (Delete?)") {
					xmlhttp.open("post", "mycart2.php?" + item + "=" + "-1", true);
					xmlhttp.send();
				}
			}
		</script>
	</head>
	<body>

		<div class="header">Welcome to Music Equipment and Things</div>

			<table class="itemTable" id="itemTableDisplay">

			</table>

		<script type="text/javascript">

			// create a requst to json file with all data and parse for table display
			var xmlhttp = new XMLHttpRequest();

			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					var itemsObject = JSON.parse(this.responseText);
					var fullList = "<tr class=\"itemTable\"><th>Picture</th><th>Item</th><th>Price</th><th>Count</th><th>Qty</th><th>Description</th><th>Availability</th><th>Add To Cart</th></tr>";

					for (var i = 0; i < itemsObject.items.length; i++) {


						 var itemsList = "<tr class=\"itemTable\">" +
								"<td><img src=\"" + itemsObject.items[i].picture + "\" style=\"imageFormat\"></td>" +
								"<td>" + itemsObject.items[i].item + "</td>" +
								"<td>$" + itemsObject.items[i].price.toFixed(2) + "</td>" +
								"<td>" + itemsObject.items[i].count + "</td>" +
								"<td>" + itemsObject.items[i].qty + "</td>" +
								"<td>" + itemsObject.items[i].description + "</td>" +
								"<td>" + itemsObject.items[i].availability + "</td>" +
								"<td class=\"button buttonFormat\"><input id=\"" + itemsObject.items[i].itemID + "\" class=\"button\" type=\"button\" name=\"" + itemsObject.items[i].item +
								            "\" value=\"Add to Cart\" onclick=\"addToCart(\'" + itemsObject.items[i].item + "\', " + itemsObject.items[i].itemID + ")\"></td>" +
							"</tr>";
							fullList = fullList + itemsList;

							if (sessionIsActiveBefore) {
								addToCart(itemsObject.items[i].item, itemsObject.items[i].itemID);
							}
					}
				var table = document.getElementById("itemTableDisplay");
				table.innerHTML = fullList;

				// update session after first load, session might be active but only
				//    needed to update the page initially
				sessionIsActiveBefore = false;

				}
			};
			xmlhttp.open("post", "items.txt", true);
			xmlhttp.send();

		</script>

		<br />
		<br />

		<div style="text-align: center;">
			<a href="mycart.php" class="nextPageButton nextPageButton2">Go To Cart</a>
		</div>

	</body>
</html>
