<?php session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Order Successfully Completed</title>

    <link rel="stylesheet" type="text/css" href="stylesheet.css">
    <script type="text/javascript">
      var totalCost = 0.00;
      function calculateTotal(itemCost) {
        totalCost = totalCost + itemCost;
      }

      function getTotalCost() {
        document.getElementById("finalTotal").innerHTML = totalCost.toFixed(2);
      }

      // will populate the items selected
      function getItems() {
        	// create a requst to json file with all data and parse for table display
        	var xmlhttp = new XMLHttpRequest();

        	xmlhttp.onreadystatechange = function() {
        		if (this.readyState == 4 && this.status == 200) {
        			var itemsObject = JSON.parse(this.responseText);
        			var fullList = "";
              var cartList = <?php
              // set a javascript formated array of the items in the session
              //    and allow it to be displayed
              $javascriptArray = "{";

              $i = 0;

              foreach ($_SESSION as $key => $value) {

                if ($i < (count($_SESSION) - 1) && $key !== "firstname") {
                  $javascriptArray = $javascriptArray . $key . ":" . $value .", " ;
                  $i++;
                }
                elseif ($i < (count($_SESSION) - 1)) {
                  $javascriptArray = $javascriptArray . "};" ;
                  $i = $i + 6;
                }
              }
              echo $javascriptArray;
              ?>

              // parse for use in displaying what is in the cart
              var x;
              for (x in cartList) {

                // past cost
                calculateTotal(itemsObject.items[cartList[x]].price);

        				var itemsList = "<tr class=\"itemTable\">" +
        						"<td><img src=\"" + itemsObject.items[cartList[x]].picture + "\" style=\"imageFormat\"></td>" +
        						"<td>" + itemsObject.items[cartList[x]].item + "</td>" +
        						"<td>$" + itemsObject.items[cartList[x]].price.toFixed(2) + "</td>" +
        						"<td>" + itemsObject.items[cartList[x]].count + "</td>" +
        						"<td>" + itemsObject.items[cartList[x]].qty + "</td>" +
        						// "<td>" + itemsObject.items[i].availability + "</td>" +
        						// "<td><input id=\"" + itemsObject.items[i].itemID + "\" type=\"button\" name=\"" + itemsObject.items[i].itemID +
        						//             "\" value=\"Add to Cart\" onclick=\"addToCart(" + itemsObject.items[i].itemID + ")\"></td>" +
        						// "<td><input id=\"" + itemsObject.items[i].itemID + "1\" type=\"text\" name=\"" + itemsObject.items[i].itemID +
        						// 						"\" form=\"cart_form\" value=\"Add to Cart\" onclick=\"addToCart(" + itemsObject.items[i].itemID + ")\" hidden></td>" +
        					"</tr>";
        					fullList = fullList + itemsList;
        			}
        		var table = document.getElementById("itemTableDisplay");
        		table.innerHTML = fullList;
              getTotalCost();
        		}
        	};
        	xmlhttp.open("POST", "items.txt", true);
        	xmlhttp.send();
      }
    </script>
  </head>
  <body>

    <div class="header">Order Successfully Completed</div>

    <p class="confirm">
    <?php
      echo "Thank you " . $_SESSION["firstname"] . " " . $_SESSION["lastname"] . " for your order. <br />" ;
      echo "Shipped to: " . $_SESSION["address"] . " " . $_SESSION["city"] . " " . $_SESSION["state"] . " " . $_SESSION["zipcode"];

      // session over
      session_destroy();

    ?>
  </p>

    <br />

  <table class="itemTable" id="itemTableDisplay">

  </table>

  <script type="text/javascript">
    getItems();
  </script>


<br />
  <table class="totalFormat">
    <tr>
      <td> Total $</td>
      <td> <div id="finalTotal"></div> </td>
    </tr>
  </table>

  </body>
</html>
