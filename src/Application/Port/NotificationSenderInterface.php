<?php

namespace App\Application\Port;

use App\Domain\Entity\Payment;

interface NotificationSenderInterface
{
  public function send(Payment $payment, string $signature): string;
}
