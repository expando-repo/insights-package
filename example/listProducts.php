<?php

    use Expando\InsightsPackage\Request\ProductRequest;

    require_once 'boot.php';

    $insights = new \Expando\InsightsPackage\Insights();
    $insights->setToken($_SESSION['insights_token'] ?? null);
    $insights->setUrl($_SESSION['client_data']['insights_url']);
    if ($insights->isTokenExpired()) {
        $insights->refreshToken($_SESSION['client_data']['client_id'], $_SESSION['client_data']['client_secret']);
        if ($insights->isLogged()) {
            $_SESSION['insights_token'] = $insights->getToken();
        }
    }

    if (!$insights->isLogged()) {
        die('Translator is not logged');
    }

    if ($_POST['send'] ?? null) {
        try {
            $response = $insights->listProducts($_POST['page'], $_POST['on-page'], (int)$_POST['price_from'], (int)$_POST['price_to'], $_POST['category'], $_POST['price'] ?? null, $_POST['order'] ?? null, $_POST['locale'] ?? null);
        }
        catch (\Expando\InsightsPackage\Exceptions\InsightsException $e) {
            die($e->getMessage());
        }

        echo 'Product count: ' . $response->getTotal() . '<br />';
        echo 'Current page: ' . $response->getCurrentPage() . '<br />';
        echo 'Status: ' . $response->getStatus() . '<br />';
        echo '-----------------------------<br />';

        echo '<ul>';
        foreach ($response->getProducts() as $product) {
            echo '<li><strong>Product EAN:</strong> ' . $product->getProductEan() . '</li>';
            echo '<ul>';
            foreach ($product->getProductData() as $key => $attribute) {
                echo '<li><strong>'. $key .'</strong>: '. $attribute.'</li>';
            }
            echo '</ul>';
        }
        echo '</ul>';
    }
?>

<form method="post">
    <div>
        <label>
            on page<br />
            <input type="text" name="on-page" value="<?php echo $_POST['on-page'] ?? 10 ?>"  />
        </label>
    </div>
    <div>
        <label>
            page<br />
            <input type="text" name="page" value="<?php echo $_POST['page'] ?? 1 ?>"  />
        </label>
    </div>
    <div>
        <label>
            price from<br />
            <input type="text" name="price_from" value="<?php echo $_POST['price_from'] ?? null ?>"  />
        </label>
    </div>
    <div>
        <label>
            price to<br />
            <input type="text" name="price_to" value="<?php echo $_POST['price_to'] ?? null ?>"  />
        </label>
    </div>
    <div>
        <label>
            category<br />
            <input type="text" name="category" value="<?php echo $_POST['category'] ?? null ?>"  />
        </label>
    </div>
    <div>
        <label>
            locale<br />
            <input type="text" name="locale" value="<?php echo $_POST['locale'] ?? null ?>"  />
        </label>
    </div>
    <div>
        <label>
            price<br />
            <input type="radio" name="price" value="highest" /><label>highest</label>
            <input type="radio" name="price" value="lowest" /><label>lowest</label>
            <input type="radio" name="price" value="neutral" /><label>neutral</label>
            <input type="radio" name="price" value="only_seller" /><label>Only seller</label>
        </label>
    </div>
    <div>
        <label>
            order<br />
            <input type="radio" name="order" value="asc" /><label>asc</label>
            <input type="radio" name="order" value="desc" /><label>desc</label>
        </label>
    </div>
    <div>
        <input type="submit" name="send" value="send" />
    </div>
</form>
