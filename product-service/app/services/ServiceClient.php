<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ServiceClient
{
    protected $baseUrl;
    protected $serviceName;
    protected $token;

    public function __construct(string $serviceName, ?string $token = null)
    {
        $this->serviceName = $serviceName;
        $this->baseUrl = env(strtoupper($serviceName) . '_SERVICE_URL', "http://{$serviceName}");
        $this->token = $token;
    }

    public function get(string $endpoint, array $params = [])
    {
        return $this->request('get', $endpoint, ['query' => $params]);
    }

    public function post(string $endpoint, array $data = [])
    {
        return $this->request('post', $endpoint, ['json' => $data]);
    }

    public function put(string $endpoint, array $data = [])
    {
        return $this->request('put', $endpoint, ['json' => $data]);
    }

    public function delete(string $endpoint)
    {
        return $this->request('delete', $endpoint);
    }

    protected function request(string $method, string $endpoint, array $options = [])
    {
        $request = Http::baseUrl($this->baseUrl);

        if ($this->token) {
            $request = $request->withToken($this->token);
        }

        return $request->$method($endpoint, $options['json'] ?? $options['query'] ?? []);
    }
}