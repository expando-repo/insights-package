<?php

declare(strict_types=1);

namespace Expando\InsightsPackage;

use Expando\InsightsPackage\Exceptions\InsightsException;
use Expando\InsightsPackage\Request\ProductFilterRequest;
use Expando\InsightsPackage\Request\ProductRequest;
use Expando\InsightsPackage\Request\FeedRequest;
use Expando\InsightsPackage\Response\Product;
use JetBrains\PhpStorm\ArrayShape;

class Insights
{
    private array $token = [];
    private ?string $access_token = null;
    private ?string $refresh_token = null;
    private ?int $expires = null;
    private string $url = 'https://insights.expan.do';

    /**
     * @return bool
     */
    public function isLogged(): bool
    {
        if (!$this->access_token) {
            return false;
        }
        return true;
    }


    /**
     * @param ?array $token
     */
    public function setToken(?array $token): void
    {
        if ($token !== null) {
            $this->access_token = $token['access_token'] ?? null;
            $this->refresh_token = $token['refresh_token'] ?? null;
            $this->expires = $token['expires'] ?? null;
            $this->token = $token;
        }
    }

    /**
     * @return string[]
     */
    #[ArrayShape(['access_token' => "null|string", 'refresh_token' => "null|string", 'expires' => "int|null", 'token' => "array"])]
    public function getToken(): array
    {
		
        return [
            'access_token' => $this->access_token,
            'refresh_token' => $this->refresh_token,
            'expires' => $this->expires,
            'token' => $this->token,
        ];
    }

    /**
     * @return bool
     */
    public function isTokenExpired(): bool
    {
        if (!$this->expires) {
            return false;
        }
        return $this->isLogged() && $this->expires < time();
    }

    /**
     * @param int $clientId
     * @param string $clientSecret
     * @return array|null
     */
    public function refreshToken(int $clientId, string $clientSecret): ?array
    {
        $post = [
            'grant_type' => 'refresh_token',
            'refresh_token' => $this->refresh_token,
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'scope' => '',
        ];

        $headers = [
            'Accepts-version: 1.0',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url . '/oauth/token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $result = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($result, true);
        if ($data === false || ($data['error'] ?? null)) {
            $this->access_token = null;
            $this->refresh_token = null;
            $this->expires = null;
            $this->token = [];
            return null;
        }
        $this->setToken([
            'access_token' => $data['access_token'],
            'refresh_token' => $data['refresh_token'],
            'expires' => time() + $data['expires_in'],
        ]);
        return $data;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @param IRequest $request
     * @return Product\PostResponse
     * @throws InsightsException
     */
    public function send(IRequest $request): Product\PostResponse
    {
        if (!$this->isLogged()) {
            throw new InsightsException('Translado is not logged');
        }

        if ($request instanceof FeedRequest) {
            $data = $this->sendToTranslado('/feed/' . $request->getSource(), 'POST', $request->asArray());
            $result = new Product\PostResponse($data);
        }
        else {
            throw new InsightsException('Request not defined');
        }

        return $result;
    }

    /**
     * @param int $page
     * @param int $onPage
     * @param int $price_from
     * @param int $price_to
     * @param string $category
     * @param string $price
     * @param string $order
     * @return Product\ListResponse
     * @throws InsightsException
     */
    public function listProducts(int $page = 1, int $onPage = 20, int $price_from = null, int $price_to = null, string $category = null, string $price = null, string $order = null, string $locale = null): Product\ListResponse
    {
        if (!$this->isLogged()) {
            throw new InsightsException('Translado is not logged');
        }

        $data = $this->sendToTranslado('/products/', 'GET', array_filter([
            'page' => $page,
            'on-page' => $onPage,
            'price_from' => $price_from,
            'price_to' => $price_to,
            'category' => $category,
            'price' => $price,
            'order' => $order,
            'locale' => $locale
        ]));
        return new Product\ListResponse($data);
    }

    /**
     * @param int $productId
     * @return Product\GetResponse
     * @throws InsightsException
     */
    public function getProduct(int $productId): Product\GetResponse
    {
        if (!$this->isLogged()) {
            throw new InsightsException('Translado is not logged');
        }

        $data = $this->sendToTranslado('/product/' . $productId . '/', 'GET');
        return new Product\GetResponse($data);
    }

    /**
     * @param string $action
     * @param mixed $method
     * @param array $body
     * @return array
     * @throws InsightsException
     */
    public function sendToTranslado(string $action, $method, array $body = []): array
    {
        $headers = array(
            'Accepts-version: 1.0',
            'Authorization: Bearer ' . $this->access_token,
        );

        $url = $this->url . '/api' . $action;
        if (!empty($body) && $method === 'GET') {
            $url .= '?' . http_build_query($body);
        }
        $ch = curl_init($url);
        if ($ch === false) {
            throw new InsightsException('curl_init() failed');
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if (!empty($body) && in_array($method, ['POST', 'PUT'])) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        }
        $return = curl_exec($ch);
        curl_close($ch);

        if (!$return) {
            throw new InsightsException('Insights did not return a correct response');
        }
        if ($_GET['debug'] ?? null) {
            echo '<pre>';
            print_r($return);
        }
        $data = (array) json_decode($return, true);

        if (!$data || ($data['status'] ?? null) === null) {
            $message = ($data['message'] ?? null);
            throw new InsightsException('Response data is bad' . ($message ? ' ('.$message.')' : ''));
        }

        if ($data['status'] === 'error') {
            throw new InsightsException('Response error: ' . ($data['message'] ?? null));
        }
        return $data;
    }
}
