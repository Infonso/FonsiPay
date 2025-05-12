<?php
// src/Infrastructure/Http/GuzzleNotificationSender.php
namespace App\Infrastructure\Http;

use App\Application\Port\NotificationSenderInterface;
use App\Domain\Entity\Payment;
use GuzzleHttp\Client;

class GuzzleNotificationSender implements NotificationSenderInterface
{
  private string $endpointUrl;
  private Client $client;

  public function __construct(string $endpointUrl)
  {
    $this->endpointUrl = $endpointUrl;
    $this->client = new Client();
  }

  public function send(Payment $payment, string $signature): string
  {
    $response = $this->client->post($this->endpointUrl, [
      'headers' => [
        'Content-Type' => 'application/json',
        'Signature' => $signature
      ],
      'body' => json_encode($payment->toArray())
    ]);

    return $response->getBody()->getContents();
  }
}
