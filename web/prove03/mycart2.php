<?php

  session_start();


    foreach ($_GET as $key => $value) {
      // for the condition if the session is active and just needs to
      //    update the cart items during browse
      if ($value == "-2") {
        if (isset($_SESSION[$key])) {
            if ($_SESSION[$key] != "-1") {
              echo "Added (Delete?)";
            }
        }
        else {
          // not set then use default not being in cart
          echo "Add to Cart";
        }

      // add it to the session
      } else if ($value != "-1") {
        $_SESSION[$key] = $value;
        echo "Added (Delete?)";
      }
      else {

        unset($_SESSION[$key]);
        echo "Add to Cart";
      }
    }
?>
