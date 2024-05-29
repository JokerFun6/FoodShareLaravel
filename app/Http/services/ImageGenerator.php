<?php

namespace App\Http\services;

use GuzzleHttp\Client;

class ImageGenerator
{
    private $client;
    private $url;
    private $authHeaders;

    public function __construct($url, $apiKey, $secretKey)
    {
        $this->url = $url;
        $this->authHeaders = [
            'X-Key' => 'Key ' . $apiKey,
            'X-Secret' => 'Secret ' . $secretKey
        ];
        $this->client = new Client(['base_uri' => $url]);
    }

    public function getModel()
    {
        $response = $this->client->get('key/api/v1/models', ['headers' => $this->authHeaders]);
        $data = json_decode($response->getBody(), true);
        return $data[0]['id'];
    }

    public function generate($prompt, $model, $images = 1, $width = 1920, $height = 1080)
    {
        $params = [
            "type" => "GENERATE",
            "numImages" => $images,
            "width" => $width,
            "style" => "UHD",
            "height" => $height,
            "generateParams" => [
                "query" => $prompt
            ]
        ];

        $response = $this->client->post('key/api/v1/text2image/run', [
            'headers' => $this->authHeaders,
            'multipart' => [
                [
                    'name' => 'model_id',
                    'contents' => $model
                ],
                [
                    'name' => 'params',
                    'contents' => json_encode($params),
                    'headers' => ['Content-Type' => 'application/json']
                ]
            ]
        ]);

        $data = json_decode($response->getBody(), true);
        return $data['uuid'];
    }

    public function checkGeneration($requestId, $attempts = 5, $delay = 10)
    {
        while ($attempts > 0) {
            $response = $this->client->get('key/api/v1/text2image/status/' . $requestId, ['headers' => $this->authHeaders]);
            $data = json_decode($response->getBody(), true);
            if ($data['status'] == 'DONE') {
                return $data['images'];
            }

            $attempts--;
            sleep($delay);
        }
    }
}

//// Использование
//$api = new index('https://api-key.fusionbrain.ai/', '9525A2D4BA2DA9DBC37936A52D1DC9D7', '6FC92508F33E28DCF0197CA92D8E5F55');
//$modelId = $api->getModel();
//$uuid = $api->generate(
//    "Создайте изображение, которое иллюстрирует рецепт [спагети с лососем]. Описание рецепта: [лосось со сливочным лососем]. Изображение должно быть аппетитным и привлекательным, представлять собой блюдо, которое можно приготовить по данному рецепту. Используйте яркие и качественные цвета, чтобы привлечь внимание посетителей сайта. Фон изображения должен быть нейтральным и не отвлекать внимание от блюда. Постарайтесь передать атмосферу и вкус блюда, чтобы заинтересовать пользователей и побудить их попробовать приготовить его сами.",
//    $modelId
//);
//$images = $api->checkGeneration($uuid);
//
//
//$imageData = base64_decode($images[0]);
//
//// Сохранение двоичных данных в файл
//$file = 'image.png';
//file_put_contents($file, $imageData);
//
//// Вывод изображения в браузер
//header('Content-Type: image/png');
//readfile($file);
