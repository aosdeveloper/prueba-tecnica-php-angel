<?php
namespace Angel\PruebaTecnicaPhpAngel\Domain;

use InvalidArgumentException;

class UserId
{
  private function __construct(private int $id)
  {
    #
  }

  public static function fromInt(int $id): UserId
  {
    self::ensureIsValid($id);
    return new self($id);
  }

  public function toInt(): int
  {
    return $this->id;
  }

  private static function ensureIsValid(int $id)
  {
    if ($id <= 0) {
      throw new InvalidArgumentException('UserId inválido');
    }
  }
}