<?php $view->extend('::base.html.php') ?>
<link rel="stylesheet/less" type="text/css" href="<?php echo $view['assets']->getUrl('css/jquery.dataTables.bootstrap.css') ?>">
<?php
if (isset($_COOKIE['api'])) {


//	$url = $this->container->getParameter('apiUrl')."campaigns.json?filter=0";
    $url = $this->container->getParameter('apiUrl')."products.json";

    $accesstoken = $_COOKIE['api'];

    $headr   = array();
    $headr[] = 'Content-length: 0';
    $headr[] = 'Content-type: application/json';
    $headr[] = 'x-wsse: ApiKey="'.$accesstoken.'"';

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headr);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

    $result = curl_exec($ch);
    curl_close($ch);

    $obj = json_decode($result, true);

    $produse_count = count($obj['Produse']);
    $produse       = $obj['Produse'];
    $i               = 0;

    $url         = $this->container->getParameter('apiUrl')."users/".$_COOKIE['dash_user_id']."/info";
    $accesstoken = $_COOKIE['api'];

    $headr   = array();
    $headr[] = 'Content-length: 0';
    $headr[] = 'Content-type: application/json';
    $headr[] = 'x-wsse: ApiKey="'.$accesstoken.'"';

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headr);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

    $result2 = curl_exec($ch);
    curl_close($ch);

    $obj2 = json_decode($result2, true);
    $role = $obj2['user']['user_role_id'];
} else {
    header('Location: /login');
    die;
}
?>

<div class="container">
    <div class="row">
        <div class="offset-wrapper">
            <div class="evo-space"></div>
            <h2 class="evo-header-bigger">Toate produsele</h2>
            <!-- <div class="evo-space"></div> -->
            <table id="project-table" class="table">
                <thead>
                    <tr>
                        <th data-sort="string">Id</th>
                        <th data-sort="string">Nume</th>
                        <th data-sort="string">Pret</th>
                        <th data-sort="string">Cantitate</th>
                        <th data-sort="string">Unitate Masura</th>
                      
                        <?php if ($role == 3) { ?>
                            <!--<th class="disabled-sort"></th>-->
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                        <?php foreach ($produse as $produs) { ?>
                        <tr class="hover_row">
                            <td><p class="evo-text-smaller"><?php echo $produs['id']; ?></p></td>
                            <td><p class="evo-text-smaller"><a href="products/<?php echo $produs['id']; ?>"><?php echo $produs['nume']; ?></a></p></td>
                            <td><p class="evo-text-smaller"><?php echo $produs['pret']; ?></p></td>
                            <td><p class="evo-text-smaller"><?php echo $produs['cantitate']; ?></p></td>
                            <td><p class="evo-text-smaller"><?php echo $produs['unitate_masura']; ?></p></td>
                        </tr>
                            <?php $i++; ?>
                        <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="evo-space-biggest"></div>
</div>