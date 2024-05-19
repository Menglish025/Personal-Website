<?php
if (isset($_GET['courseName']) && isset($_GET['price'])) {
    $courseName = htmlspecialchars($_GET['courseName']);
    $price = htmlspecialchars($_GET['price']);
} else {
    die("Invalid request.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Matt Jerry's Education Hub</title>
    <link rel="stylesheet" href="CSS.css">
    <script src="https://js.squareup.com/v2/paymentform"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <!-- Include PayPal SDK -->
    <script src="https://www.paypal.com/sdk/js?client-id=YOUR_PAYPAL_CLIENT_ID"></script>
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            background: linear-gradient(to bottom right, #0072ff, #00c6ff);
            font-family: Arial, sans-serif;
        }
        .confirmation-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            max-width: 600px;
            width: 100%;
            text-align: center;
            margin: 20px auto;
        }
        header {
            background-color: rgba(255, 255, 255, 0.95);
            padding: 1em;
            text-align: center;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: center;
        }
        nav ul li {
            margin: 0 15px;
        }
        nav ul li a {
            color: #0072ff;
            text-decoration: none;
            font-weight: bold;
        }
        main {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 1em;
            position: sticky;
            bottom: 0;
        }
        footer p a {
            color: #56ccf2 !important;
            text-decoration: none;
        }
        footer p a:hover {
            color: #2f80ed !important;
            text-decoration: underline;
        }
        .payment-form {
            margin-top: 20px;
            text-align: left;
        }
        .payment-form label {
            display: block;
            margin-bottom: 5px;
        }
        .payment-form input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .payment-form button {
            width: 100%;
            padding: 10px;
            background-color: #0072ff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <header>
        <h1>Checkout</h1>
        <nav>
            <ul>
                <li><a href="homepage.php">Home</a></li>
                <li><a href="courses.php">Courses</a></li>
                <li><a href="about.html">About Me</a></li>
                <li><a href="tutorials.php">Video Tutorials</a></li>
                <li><a href="sign-up.php">Sign Up</a></li>
                <li><a href="sign-in.php">Sign In</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="confirmation-container">
            <h2>Course Purchase Confirmation</h2>
            <div class="confirmation-text">
                <p>Thank you for choosing to purchase the <strong><?php echo $courseName; ?></strong> course.</p>
                <p>The total cost is <strong>$<?php echo $price; ?></strong>.</p>
                <p>Please proceed to payment to complete your purchase.</p>
            </div>
            <div class="payment-form">
                <form id="payment-form" action="square_payment.php" method="post">
                    <div id="sq-card"></div>
                    <input type="hidden" name="courseName" value="<?php echo $courseName; ?>">
                    <input type="hidden" name="price" value="<?php echo $price; ?>">
                    <button id="sq-creditcard" class="button-credit-card" onclick="onGetCardNonce(event)">Proceed to Payment</button>
                </form>
            </div>
        </div>
    </main>

    <footer>
        <p><a href="copyright.html" style="color: #ffffff; text-decoration: none;">Copyright © 2024 Matt Jerry</a></p>
        <p><a href="terms.html" style="color: #ffffff; text-decoration: none;">Terms Of Service</a></p>
        <p><a href="privacypolicy.html" style="color: #ffffff; text-decoration: none;">Privacy Policy</a></p>
    </footer>

    <script type="text/javascript">
        // Square Payment Form Setup
        const squarePaymentForm = new SqPaymentForm({
            applicationId: 'YOUR_SQUARE_APPLICATION_ID', // Replace with your actual application ID
            inputClass: 'sq-input',
            cardNumber: { elementId: 'sq-card-number' },
            cvv: { elementId: 'sq-cvv' },
            expirationDate: { elementId: 'sq-expiration-date' },
            postalCode: { elementId: 'sq-postal-code' },
            callbacks: {
                cardNonceResponseReceived: function(errors, nonce, cardData) {
                    if (errors) {
                        console.error(errors);
                        return;
                    }
                    const nonceInput = document.createElement('input');
                    nonceInput.setAttribute('type', 'hidden');
                    nonceInput.setAttribute('name', 'nonce');
                    nonceInput.setAttribute('value', nonce);
                    document.getElementById('square-payment-form').appendChild(nonceInput);
                    document.getElementById('square-payment-form').submit();
                }
            }
        });

        function onGetCardNonce(event) {
            event.preventDefault();
            squarePaymentForm.requestCardNonce();
        }

        // Stripe Payment Form Setup
        const stripe = Stripe('YOUR_STRIPE_PUBLIC_KEY'); // Replace with your actual Stripe public key
        const elements = stripe.elements();
        const cardElement = elements.create('card');
        cardElement.mount('#card-element');

        // Handle form submission
        const stripeForm = document.getElementById('stripe-payment-form');
        stripeForm.addEventListener('submit', async (event) => {
            event.preventDefault();

            const { token, error } = await stripe.createToken(cardElement);
            if (error) {
                console.error(error);
            } else {
                const tokenInput = document.createElement('input');
                tokenInput.setAttribute('type', 'hidden');
                tokenInput.setAttribute('name', 'stripeToken');
                tokenInput.setAttribute('value', token.id);
                stripeForm.appendChild(tokenInput);
                stripeForm.submit();
            }
        });

        // PayPal Button Setup
        paypal.Buttons({
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '<?php echo $price; ?>'
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    window.location.href = 'success.php';
                });
            },
            onError: function(err) {
                console.error(err);
                window.location.href = 'error.php';
            }
        }).render('#paypal-button-container');

        // Show Payment Form Based on Selection
        function showPaymentForm(method) {
            document.getElementById('square-form').classList.add('hidden');
            document.getElementById('stripe-form').classList.add('hidden');
            document.getElementById('paypal-form').classList.add('hidden');
            document.getElementById('creditcard-form').classList.add('hidden');

            if (method === 'square') {
                document.getElementById('square-form').classList.remove('hidden');
            } else if (method === 'stripe') {
                document.getElementById('stripe-form').classList.remove('hidden');
            } else if (method === 'paypal') {
                document.getElementById('paypal-form').classList.remove('hidden');
            } else if (method === 'creditcard') {
                document.getElementById('creditcard-form').classList.remove('hidden');
            }
        }
    </script>
</body>
</html>
