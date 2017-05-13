<?php session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Checkout</title>

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
        			var fullList = "<tr class=\"itemTable\"><th>Picture</th><th>Item</th><th>Price</th><th>Count</th><th>Qty</th></tr>";
              var cartList = <?php
              // set a javascript formated array of the items in the session
              //    and allow it to be displayed
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

    <div class="header">Checkout</div>

    <p>Please Review your order and confirm your items.</p>

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

    <form method="POST" name="orderForm" id="orderForm" action="finalorder.php" style="text-align: center;">
        <fieldset>
            <legend id="contact" style="text-shadow: grey"> Order Form </legend>
            <table>
                <tr>
                    <td><u><b>Contact Information</b></u></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="alignRight">First:</td>
                    <td>
                        <input id="firstname" type="text" name="firstname" placeholder="First Name" onload="focus" required="*">
                    </td>
                </tr>
                <tr>
                    <td class="alignRight">Last:</td>
                    <td>
                        <input id="lastname" type="text" name="lastname" placeholder="Last Name" required="*">
                    </td>
                </tr>
                <tr>
                    <td class="alignRight">Address:</td>
                    <td>
                        <input id="address" type="text" name="address" placeholder="Street" required="*">
                    </td>
                </tr>
                <tr>
                    <td class="alignRight">City:</td>
                    <td>
                        <input id="city" type="text" name="city" placeholder="City" required="*">
                    </td>
                </tr>
                <tr>
                    <td class="alignRight">State:</td>
                    <td>
                        <input id="state" type="text" name="state" placeholder="XX" size="2" maxlength="2" required="*">
                    </td>
                </tr>
                <tr>
                    <td class="alignRight">Zip Code:</td>
                    <td>
                        <input id="zipCode" type="text" name="zipcode" size="6" placeholder="XXXXX" maxlength="5" required="*">
                    </td>
                </tr>
            </table>
        </fieldset>
        <div style="text-align: center; font-size: 16pt; padding: 20px">
            <a href="mycart.php" class="nextPageButton nextPageButton2">Return to Cart</a>
            <input class="nextPageButton nextPageButton2" type="submit" value="Submit Order">
            <p hidden>Missing Fields! Please correct to submit order.</p>
        </div>
    </form>

  </body>
</html>
