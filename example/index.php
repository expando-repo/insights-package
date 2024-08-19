<?php
    require_once 'boot.php';

    if (empty($_SESSION['client_data'])) {
        header('Location: redirect.php');
        exit;
    }

    $insights = new \Expando\InsightsPackage\Insights();
    $insights->setToken($_SESSION['insights_token'] ?? null);
    $insights->setUrl($_SESSION['client_data']['insights_url']);
    if ($insights->isTokenExpired()) {
        $insights->refreshToken($_SESSION['client_data']['client_id'], $_SESSION['client_data']['client_secret']);
        if ($insights->isLogged()) {
            $_SESSION['insights_token'] = $insights->getToken();
        }
    }
?>

<?php if (!$insights->isLogged()) { ?>
    <a href="redirect.php">Login (get token)</a>
<?php } else { ?>
    <ul>
        <li><a href="listProducts.php">list products</a></li>
        <li><a href="listSources.php">list sources</a></li>
        <li><a href="listCategories.php">list categories</a></li>
        <li><a href="getProduct.php">get product</a></li>
        <li><a href="registerProduct.php">post product</a></li>
        <li><a href="postFeed.php">post feed</a></li>
        <li><a href="logout.php">logout (delete token)</a></li>
    </ul>
<?php } ?>
