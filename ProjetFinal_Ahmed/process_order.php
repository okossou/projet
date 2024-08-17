<?php
include 'config.php';
session_start();
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    header('location:login.php');
    exit;
}


if (isset($_POST['checkout'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);

    $user_check_query = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'");
    if (mysqli_num_rows($user_check_query) == 0) {
        die("User ID does not exist in the users table.");
    }

    $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'");
    $total_amount = 0;

    while ($item = mysqli_fetch_assoc($cart_query)) {
        $total_amount += $item['price'] * $item['quantity'];
    }

    $insert_order = mysqli_query($conn, "INSERT INTO orders (user_id, name, address, phone) VALUES ('$user_id', '$name', '$address', '$phone')");

    if ($insert_order) {
        $order_id = mysqli_insert_id($conn);

        // Re-execute cart query because the previous one was exhausted by while loop
        $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'");

        while ($cart_item = mysqli_fetch_assoc($cart_query)) {
            $product_name = $cart_item['name'];
            $product_price = $cart_item['price'];
            $product_quantity = $cart_item['quantity'];
            $product_query = mysqli_query($conn, "SELECT id FROM products WHERE name='$product_name'");
            $row = mysqli_fetch_assoc($product_query);
            $product_id = $row['id'];

            $check_product_query = mysqli_query($conn, "SELECT * FROM products WHERE name = '$product_name'");
            if (mysqli_num_rows($check_product_query) > 0) {
                $insert_item = mysqli_query($conn, "INSERT INTO order_items (order_id, product_id, product_name, product_price, quantity) VALUES ('$order_id', '$product_id', '$product_name', '$product_price', '$product_quantity')");
                if (!$insert_item) {
                    echo "Error inserting item: " . mysqli_error($conn);
                }
            } else {
                echo "Error: Product with name= $product_name does not exist.";
            }
        }

        echo "<script src='https://www.paypal.com/sdk/js?client-id=ATOQCQk90plwBiDXodEHryueMe-Xhs2_EBhv-G68duswDLl6Nop6HcYl6uWu0n_jGqu-z5O9Lq-8Eimx'></script>
        <div style='display: flex; justify-content: center; align-items: center; height: 100vh;'>
        <div id='paypal-button-container'></div>
        </div>
        <script>
            paypal.Buttons({
                createOrder: function(data, actions) {
                    return actions.order.create({
                        purchase_units: [{
                            amount: {
                                value: '$total_amount'
                            }
                        }]
                    });
                },
                onApprove: function(data, actions) {
                    return actions.order.capture().then(function(details) {
                        alert('Transaction completed by ' + details.payer.name.given_name);
                        window.location.replace('index.php');
                    });
                }
            }).render('#paypal-button-container');
        </script>";

        mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'");
        exit;
    } else {
        echo "Erreur lors de la passation de la commande: " . mysqli_error($conn);
    }
}
?>
