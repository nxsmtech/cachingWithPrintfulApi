<?php


class GuzzleApi
{
    public function request($method, $url, $parameters = null)
    {
        $client = new GuzzleHttp\Client();
        $configs = include('../config/config.php');
        $headers = $headers = [
            'Accept' => 'application/json',
        ];

        $key = $configs->printful_api_key;

        if ($key) {
            $headers = $headers = [
                'Authorization' => 'Basic ' . $key,
                'Accept' => 'application/json',
            ];
        }

        if ($parameters) {
            $parameters = json_encode($parameters);
        }

        try {
            $response = $client->request($method, $url, [
                'headers' => $headers,
                'body' => $parameters,
            ]);

            $result = json_decode($response->getBody());
            return $result->result;
        } catch (Exception $exception) {
            echo $exception->getMessage();
        }
    }
}