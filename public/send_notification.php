<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Domain\Entity\Payment;
use App\Application\UseCase\SendPaymentNotificationUseCase;
use App\Infrastructure\Http\GuzzleNotificationSender;
use Ramsey\Uuid\Uuid;


$jwtSecret = 'mi_clave_secreta';
$endpointUrl = 'http://localhost/Fonsipay/public/receive_notification.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Recoger datos del formulario
  $amount = $_POST['amount'] ?? null;
  $status = 'Sended';
  $debtor = $_POST['debtor_account'] ?? null;
  $creditor = $_POST['creditor_account'] ?? null;

  if (!$amount || !$status || !$debtor || !$creditor) {
    http_response_code(400);
    echo "Datos incompletos.";
    exit;
  }

  // Crear objeto Payment
  $payment = new Payment(
    amount: $amount,
    status: $status,
    debtor_account: $debtor,
    creditor_account: $creditor,
    notification_id: Uuid::uuid4()->toString()
  );

  // Crear adaptador e inyectarlo en el caso de uso
  $sender = new GuzzleNotificationSender($endpointUrl);
  $useCase = new SendPaymentNotificationUseCase($jwtSecret, $sender);
  $response = $useCase->execute($payment);

  echo $response;
}
