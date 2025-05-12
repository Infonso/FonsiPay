<?php

namespace App\Application\UseCase;

use App\Domain\Entity\Payment;
use Firebase\JWT\JWT;

class ProcessPaymentUseCase
{
  private string $jwtSecret;

  public function __construct(string $jwtSecret)
  {
    $this->jwtSecret = $jwtSecret;
  }

  public function execute(Payment $payment): array
  {
    $payload = $payment->toArray();
    $jwt = JWT::encode($payload, $this->jwtSecret, 'HS256');

    return [
      'json' => json_encode($payload),
      'signature' => $jwt
    ];
  }
}
