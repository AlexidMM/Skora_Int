<?php
    include 'conexion.php';
    include_once 'carrito.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PayPal JS SDK Standard Integration</title>

    <script src="https://www.paypal.com/sdk/js?client-id=AdrUrZMoR1QBIRB31DsKw45k0wSxAJVx3pY6ovM_1kB4OIq3PrWS6ED5l8uXkeCf3jVUNFVVBHIPh2_2&currency=MXN"
    ></script>
  </head>
  <body>

    <div id="paypal-button-container"></div>
    
    <?php
        $total = 0;
        $items = array();
        foreach ($_SESSION['carrito'] as $item) {
            $subtotal = $item['prec_art'] * $item['cantidad'];
            $total += $subtotal;
            $items[] = array(
                'name' => $item['nom_art'],
                'unit_amount' => array(
                    'currency_code' => 'MXN',
                    'value' => $item['prec_art']
                ),
                'quantity' => $item['cantidad']
            );
        }
    ?>
    
    <script>
        paypal.Buttons({
            style:{
                color: 'blue',
                shape: 'pill',
                label: 'pay'
            },
            createOrder: function(data, actions){
                return actions.order.create({
                    purchase_units: [{
                        amount : {
                            currency_code: 'MXN',
                            value: '<?php echo $total; ?>',
                            breakdown: {
                                item_total: {
                                    currency_code: 'MXN',
                                    value: '<?php echo $total; ?>'
                                }
                            }
                        },
                        items: <?php echo json_encode($items); ?>
                    }]
                });
            },

            onApprove: function(data, actions){
                actions.order.capture().then(async function (detalles){
                    alert("Pago realizado :) ")
                    <?php unset($_SESSION['carrito']); ?>
                    window.location.href="../prod.php";
                    localStorage.setItem("purchase", JSON.stringify)
                    await fetch("conexion.php", {
                        method: "post",
                        body: JSON.stringify
                    })
                });
            },

            onCancel:function(data){
                alert("Pago cancelado :(");
                console.log(data);
            }
        }).render('#paypal-button-container');
    </script>
    
  </body>
</html>