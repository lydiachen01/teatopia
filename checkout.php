<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
     <!-- Bootstrap CDN -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
     <!-- Bootstrap CDN -->
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="styles.css">
    <title>Shopping Cart 🍵</title>
    <style>
        #checkoutPage {
            margin: 0 150px; 
            padding-top: 120px;
        }
        li {
            margin: 10px 0; /* Adjusted margin for better spacing */
            display: flex;
            justify-content: space-between;
        }
        strong {
            text-align: right;
            margin-right: 20px;
        }
        button {
            background-color: #416843;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px;
            cursor: pointer;
            position: fixed;
            bottom: 20px;
            right: 20px;
        }
        button:hover {
            background-color: #094f23; 
        }
        #thankYouMessage {
            font-size: 50px;
            margin: 60px auto;
            width: 50%;
            text-align: center;
        }
        .hide-text {
            display: none;
        }
    
        .navbar-btn {
            background-color: transparent;
        }
    </style>
</head>
<body>
    <!-- Navbar Component -->
    <div id="header" style="z-index: 100;"></div>
    <script>
        $(function () {
            $("#header").load("navbar.php");
        });
    </script>

    <div id="checkoutPage">
        <h1 style="text-align: center;" id="cTitle">Checkout</h1>
        <ol id="checkout-items">
            <!-- Cart items will be displayed here -->
        </ol>
        <p id="subtotal">Subtotal: $0.00</p>
        <p id="tax">Tax (6.25%): $0.00</p>
        <p id="total" style="font-weight: 1000;">Total: $0.00</p>

        <button id="thankYouButton">Complete Purchase</button>
    </div>

    <p id="thankYouMessage" style="display: none;">Thank you for shopping with us!!</p>

    <script>
        let cart = {};

        document.addEventListener("DOMContentLoaded", function () {
            const checkoutItems = document.getElementById('checkout-items');
            const subtotalElement = document.getElementById('subtotal');
            const taxElement = document.getElementById('tax');
            const totalElement = document.getElementById('total');
            const thankYouButton = document.getElementById('thankYouButton');
            const thankYouMessage = document.getElementById('thankYouMessage');
            const checkoutTitle = document.getElementById('cTitle');

            <?php

            $conn = new mysqli("localhost", "u9rnmkwnhqk3j", "@*2l@2f7i%&2", "dbygr11xzpv4y5");

            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            $query = "SELECT productName, price FROM product_table";
            $result = mysqli_query($conn, $query);

            $prices = array();

            while ($row = mysqli_fetch_assoc($result)) {
                $prices[$row['productName']] = $row['price'];
            }

            mysqli_close($conn);
            ?>

            const teaPrices = <?php echo json_encode($prices); ?>;

            function getUrlParameter(name) {
                const urlParams = new URLSearchParams(window.location.search);
                return urlParams.get(name);
            }

            const cartData = getUrlParameter('cartData');
            
            if (cartData) {
                cart = JSON.parse(decodeURIComponent(cartData));
                console.log('Cart:', cart);
            } else {
                console.log('Cart is empty or undefined.');
            }

            let subtotal = 0;
            const taxRate = 0.0625;

            for (const productName in cart) {
                const quantity = cart[productName];
                const itemPrice = calculateItemPrice(productName);
                const teaSubtotal = itemPrice * quantity;
                subtotal += teaSubtotal;

                const li = document.createElement('li');
                li.innerHTML = `<span>${productName}</span><span>x ${quantity}</span><strong>$${teaSubtotal.toFixed(2)}</strong>`;
                checkoutItems.appendChild(li);
            }
            const tax = subtotal * taxRate;
            const total = subtotal + tax;

            subtotalElement.innerHTML = `Subtotal: <strong>$${subtotal.toFixed(2)}</strong>`;
            taxElement.innerHTML = `Tax (6.25%): <strong>$${tax.toFixed(2)}</strong>`;
            totalElement.innerHTML = `TOTAL <strong>$${total.toFixed(2)}</strong>`;

            function calculateItemPrice(itemName) {
                return teaPrices[itemName];
            }

            thankYouButton.addEventListener('click', function () {
                thankYouMessage.style.display = 'block';
                checkoutItems.classList.add('hide-text');
                subtotalElement.classList.add('hide-text');
                taxElement.classList.add('hide-text');
                totalElement.classList.add('hide-text');
                thankYouButton.classList.add('hide-text');
                checkoutTitle.classList.add('hide-text');

                setTimeout(function () {
                    window.location.href = 'index.html';
                }, 1500);
            });
        });
    </script>

    <!-- Footer -->

</body>
</html>