<form method="post" enctype="multipart/form-data">
    <div>
        <label>
            Url Produktu: <br />
            <input type="text" name="url" />
        </label>
    </div>
    <div>
        <label>
            EAN: <br />
            <input type="text" name="ean" />
        </label>
    </div>
    <div>
        <label>
            ID produktu: <br />
            <input type="text" name="productId" />
        </label>
    </div>
    <div>
        <label>
            ID produktu na shopu: <br />
            <input type="text" name="shopProductId" />
        </label>
    </div>
    <div>
        <input type="submit" name="send" value="send" />
    </div>
</form>
<?php

    require_once 'boot.php';

    use Expando\InsightsPackage\Request\ProductToRegister;
    use Expando\InsightsPackage\Request\RegisterProductsRequest;

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
        die('Client is not logged');
    }

    if ($_POST['send'] ?? null) {
        try {
            $RegisterProductsRequest = new RegisterProductsRequest();
            $ProductToRegister = new ProductToRegister($_POST['url'], $_POST['ean'], $_POST['productId'], $_POST['shopProductId']);
            $RegisterProductsRequest->addProductToRegister($ProductToRegister);
            
            /** @var \Expando\InsightsPackage\Response\Product\RegisterResponse */
            $response = $insights->send($RegisterProductsRequest);
        }
        catch (\Expando\InsightsPackage\Exceptions\InsightsException $e) {
            die($e->getMessage());
        }
        echo '<strong>Status: ' . $response->getStatus() .'</strong><br>';
    }
?>
