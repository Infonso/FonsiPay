<?php

namespace App\Domain\Entity;

class Payment
{
  private string $amount;
  private string $status;
  private string $creditor_account;
  private string $debtor_account;
  private string $notification_id;

  public function __construct(string $amount, string $status, string $creditor_account, string $debtor_account, string $notification_id)
  {
    $this->amount = $amount;
    $this->status = $status;
    $this->creditor_account = $creditor_account;
    $this->debtor_account = $debtor_account;
    $this->notification_id = $notification_id;
  }

  public function toArray(): array
  {
    return [
      'amount' => $this->amount,
      'status' => $this->status,
      'creditor_account' => $this->creditor_account,
      'debtor_account' => $this->debtor_account,
      'notification_id' => $this->notification_id,
    ];
  }

  public static function fromArray(array $data): self
  {
    return new self(
      $data['amount'],
      $data['status'],
      $data['creditor_account'],
      $data['debtor_account'],
      $data['notification_id']
    );
  }
}
