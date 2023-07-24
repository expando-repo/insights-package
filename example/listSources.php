<?php

    use Expando\InsightsPackage\Request\SourceRequest;

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

<h2>get sources</h2>
<form method="post">
    <div>
        <label>
            locale<br />
            <input type="text" name="locale" value="<?php echo $_POST['locale'] ?? null ?>"  />
        </label>
    </div>
    <div>
        <input type="submit" name="send1" value="All sources" /><input type="submit" name="send2" value="My sources" />
    </div>
</form>

<?php
    if ($_POST['send1'] ?? null || $_POST['send2'] ?? null) {
        try {
            $response = $_POST['send1'] ?? null ? $insights->listAllSources($_POST['locale']): $insights->listMySources($_POST['locale']);
        }
        catch (\Expando\InsightsPackage\Exceptions\InsightsException $e) {
            die($e->getMessage());
        }
        echo '<strong>Sources: </strong><br>';
        foreach ($response->getSources() as $locale => $sources) {
            echo '<ul>';
                echo '<li><strong>Locale: ' . $locale . '</strong></li>';
                echo '<ul>';
                foreach ($sources as $source) {
                    echo '<li><strong>Name:</strong> ' . $source->getName() . '</li>';
                }
                echo '</ul>';
            echo '</ul>';
        }

    }
?>