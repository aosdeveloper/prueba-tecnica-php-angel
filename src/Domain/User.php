<?php
namespace Angel\PruebaTecnicaPhpAngel\Domain;
use Datetime;

class User {
  private function __construct(
    private UserId $id,
    private string $username,
    private string $passwd,
    private string $email,
    private bool $active,
    private string $created,
  ) {
    #
  }

  public static function create(UserId $id, string $username, string $passwd, string $email, bool $active=true): User
  {
    $created = new Datetime();
    return new self(
      $id,
      $username,
      $passwd,
      $email,
      $active,
      $created->format('Y-m-d H:i:s')
    );
  }

  public static function fromArray(array $user): User
    {
        return new self(
            UserId::fromInt($user['id']),
            $user['username'],
            $user['passwd'],
            $user['email'],
            $user['active'],
            $user['created']
        );
    }

  public function getId(): UserId
  {
    return $this->id;
  }

  public function getUsername(): string
  {
    return $this->username;
  }

  public function getPasswd(): string
  {
    return $this->passwd;
  }

  public function getEmail(): string
  {
    return $this->email;
  }

  public function getActive(): string
  {
    return $this->active;
  }

  public function getCreated(): string
  {
    return $this->created;
  }

  public function setUsername($username)
  {
    $this->username = $username;
  }

  public function setPasswd($passwd)
  {
    $this->passwd = $passwd;
  }

  public function setEmail($email)
  {
    $this->email = $email;
  }

  public function setActive($active)
  {
    $this->active = $active;
  }
}