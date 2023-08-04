<form method="post" enctype="multipart/form-data">
    <div>
        <label>
            Feed url: <br />
            <input type="text" name="url" />
        </label>
    </div>

    <div>
        <label>
            Zdroj: <br />
            <input type="text" name="source" />
        </label>
    </div>
    <div>
        <input type="submit" name="send" value="send" />
    </div>
</form>

<?php

    use Expando\InsightsPackage\Request\FeedRequest;

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
            $response = $insights->send(new FeedRequest($_POST['source'], $_POST['url']));
        }
        catch (\Expando\InsightsPackage\Exceptions\InsightsException $e) {
            die($e->getMessage());
        }
        echo '<strong>Status: ' . $response->getStatus() .'</strong><br>';
        echo '<strong>Hash: ' . $response->getHash() .'</strong>';
    }
?>
