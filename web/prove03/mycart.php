<?php
  session_start();
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Shopping Cart</title>
    <link rel="stylesheet" type="text/css" href="stylesheet.css">

    <script type="text/javascript">
      var totalCost = 0.00;
      function calculateTotal(itemCost) {
        totalCost = totalCost + itemCost;
      }

      function getTotalCost() {
        document.getElementById("finalTotal").innerHTML = totalCost.toFixed(2);
      }

      function getItems() {
      	// create a requst to json file with all data and parse for table display
      	var xmlhttp = new XMLHttpRequest();

      	xmlhttp.onreadystatechange = function() {
      		if (this.readyState == 4 && this.status == 200) {
      			var itemsObject = JSON.parse(this.responseText);
      			var fullList = "<tr class=\"itemTable\"><th>Picture</th><th>Item</th><th>Price</th><th>Count</th><th>Qty</th></tr>";
            var cartList = <?php
            // set a javascript formated array of the items in the session
            //    and allow it to be displayed
            if (Count($_SESSION) > 0 ) {
                $javascriptArray = "{";

                $i = 0;

                foreach ($_SESSION as $key => $value) {

                  if ($i < (count($_SESSION) - 1)) {
                    $javascriptArray = $javascriptArray . $key . ":" . $value .", " ;
                    $i++;
                  }
                  else {
                    $javascriptArray = $javascriptArray . $key . ":" . $value ."};" ;
                  }
                }
                echo $javascriptArray;
              } else {
              echo "0;";
            }
            ?>

            if (cartList == 0) {
              fullList = fullList + "<tr><td> Cart Is Empty </td> <td> </td><td> </td><td> </td><td> </td></tr>";
            }
            // parse for use in displaying what is in the cart
            var x;
            for (x in cartList) {
              calculateTotal(itemsObject.items[cartList[x]].price);
      				var itemsList = "<tr class=\"itemTable\">" +
      						"<td><img src=\"" + itemsObject.items[cartList[x]].picture + "\" style=\"imageFormat\"></td>" +
      						"<td>" + itemsObject.items[cartList[x]].item + "</td>" +
      						"<td>$" + itemsObject.items[cartList[x]].price.toFixed(2) + "</td>" +
      						"<td>" + itemsObject.items[cartList[x]].count + "</td>" +
      						"<td>" + itemsObject.items[cartList[x]].qty + "</td>" +
      					"</tr>";
      					fullList = fullList + itemsList;

      			}
      		var table = document.getElementById("itemTableDisplay");
      		table.innerHTML = fullList;
                    getTotalCost();
          }
      	};
      	xmlhttp.open("post", "items.txt", true);
      	xmlhttp.send();
      }

    </script>
  </head>
  <body>
    <div class="header">Shopping Cart</div>
    	<table class="itemTable" id="itemTableDisplay">
        <script type="text/javascript">
        getItems();

        </script>
    	</table>

      <br />
        <table class="totalFormat">
          <tr>
            <td> Total $</td>
            <td> <div id="finalTotal"></div> </td>
          </tr>
        </table>

    <br />
    <div style="text-align: center;">
      <?php
        // if there are no items in the cart don't allow to checkout
        if (Count($_SESSION) > 0) {
          echo "<a href=\"checkout.php\" class=\"nextPageButton nextPageButton2\">Checkout</a>";
        }
      ?>
      <br />
      <br />
      <a href="browse.php" class="nextPageButton nextPageButton2">Browse items</a>
    </div>


  </body>
</html>
