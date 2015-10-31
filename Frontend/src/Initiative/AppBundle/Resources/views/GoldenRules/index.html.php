<?php
$reception_id = 2;

$url = $this->container->getParameter('apiUrl')."receptions/".$reception_id;

$accesstoken = $_COOKIE['api'];
$headr       = array();
$headr[]     = 'Content-length: 0';
$headr[]     = 'Content-type: application/json';
$headr[]     = 'x-wsse: ApiKey="'.$accesstoken.'"';

$ch     = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headr);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
$result = curl_exec($ch);
curl_close($ch);

// Will dump a beauty json :3
$reception_data = json_decode($result, true);
//echo"<pre>";
//print_r($reception_data['Reception']);
$reception      = $reception_data['Reception'];


$url_produse = $this->container->getParameter('apiUrl')."products.json";

$accesstoken = $_COOKIE['api'];
$headr       = array();
$headr[]     = 'Content-length: 0';
$headr[]     = 'Content-type: application/json';
$headr[]     = 'x-wsse: ApiKey="'.$accesstoken.'"';

$ch              = curl_init();
curl_setopt($ch, CURLOPT_URL, $url_produse);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headr);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
$result_products = curl_exec($ch);
curl_close($ch);

$json_products = json_decode($result_products, true);
echo "<pre>";
//print_r($json_products);
$products      = $json_products['Produse'];

//
//print_r($products);
//die();
?>

<htmL>
    <head>
        <link rel="stylesheet" type="text/css" href="/css/receptie.css">
    </head>
    <body>
        <div class="receptie_container">
            <h1>BOOOOOOOOOOOOOOOTSTRAPPPP !</h1>



            <div class="receptie_top">

                <div class="receptie_top_stanga">

                    <p>Tabel date firma...</p>



                    <?php echo "Date firma aici"; ?>
                </div>
                <div class="receptie_top_dreapta">
                    <?php echo "altceva aici"; ?>
                </div>

                <div class="clearer"></div>
                <h3>NOTA DE RECEPTIE SI CONSTATARE DE DIFERENTE</h3>

                <?php
                echo "<hr>";
                echo "Aceasta receptie a fost facuta de la : ";
                echo $reception['client'];
                ?>
            </div>
            <div class="receptie_produse">
                <?php
                echo "<hr>";

                foreach ($products as $product) {
                    echo'<div class="produs">';
                    echo"Nume produs :";
                    print_r($product['nume']);
                    print_r("<br> ");
                    echo "Id produs in baza:";
                    print_r($product['id']);
                    print_r(" &nbsp;&nbsp;&nbsp;&nbsp;");
                    echo "Pret produs: ";
                    print_r($product['pret']);
                    print_r(" &nbsp;&nbsp;&nbsp;&nbsp;");
                    echo "Cantitate: ";
                    print_r($product['cantitate']);
                    print_r(" &nbsp;&nbsp;&nbsp;&nbsp;");
                    echo "Unitate Masura: ";
                    print_r($product['unitate_masura']);


                    echo'</div>';
                    print_r("<br>");
                }



                for ($i = 0; $i < 5; $i++) {
                    echo "<br>";
                    echo "LINIA $i de produse";
                }
                ?>
            </div>
            <div class="receptie_bottom">
                <?php
                echo "<hr> aici este footer-ul";
                ?>
            </div>
        </div>
    </body>
</htmL>