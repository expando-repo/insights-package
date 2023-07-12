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
            $response = $insights->listProducts($_POST['page'], $_POST['on-page']);
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
        <input type="submit" name="send" value="send" />
    </div>
</form>
