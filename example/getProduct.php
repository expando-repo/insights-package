<form method="post">
    <div>
        <label>
            Ean: <br />
            <input type="text" name="ean" />
        </label>
    </div>
    <div>
        <input type="submit" name="send" value="send" />
    </div>
</form>

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
        die('Client is not logged');
    }

    if ($_POST['send'] ?? null) {
        try {
            $response = $insights->getProduct($_POST['ean']);
        }
        catch (\Expando\InsightsPackage\Exceptions\InsightsException $e) {
            die($e->getMessage());
        }

        echo '<ul>';
        echo '<li><strong>Product ean:</strong> ' . $response->getProductEan() . '</li>';
        echo '<ul>';
        foreach ($response->getProductData() as $source => $productData) {
            echo '<li><strong>source: </strong>' . $source .'</li>';
            echo '<ul>';
            foreach ($productData as $key => $attribute) {
                echo '<li><strong>'. $key .'</strong>: '. $attribute.'</li>';
            }
            echo '</ul>';
        }
        echo '</ul>';
        echo '</ul>';
    }
?>
