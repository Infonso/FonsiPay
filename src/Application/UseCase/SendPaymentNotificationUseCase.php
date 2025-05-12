<?php
// src/Application/UseCase/SendPaymentNotificationUseCase.php
namespace App\Application\UseCase;

use App\Application\Port\NotificationSenderInterface;
use App\Domain\Entity\Payment;
use Firebase\JWT\JWT;

class SendPaymentNotificationUseCase
{
  private string $jwtSecret;
  private NotificationSenderInterface $sender;

  public function __construct(string $jwtSecret, NotificationSenderInterface $sender)
  {
    $this->jwtSecret = $jwtSecret;
    $this->sender = $sender;
  }

  public function execute(Payment $payment): string
  {
    $payload = $payment->toArray();
    $jwt = JWT::encode($payload, $this->jwtSecret, 'HS256');
    return $this->sender->send($payment, $jwt);
  }
}
