<?php

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
?>

<h2>get Categories</h2>
<form method="post">
    <div>
        <label>
            Source name<br />
            <input type="text" name="source" value="<?php echo $_POST['source'] ?? null ?>"  />
        </label>
    </div>
    <div>
        <input type="submit" name="send" value="All sources" />
    </div>
</form>

<?php
    if ($_POST['send'] ?? null) {
        try {
            $response = $insights->listAllCategories($_POST['source'] ?? null);
        }
        catch (\Expando\InsightsPackage\Exceptions\InsightsException $e) {
            die($e->getMessage());
        }
        echo '<strong>Categories: </strong><br>';
        echo '<ul>';
        foreach ($response->getCategories() as $category) {
                echo  $category->getName().'<br>';
        }
        echo '<ul>';

    }
?>