<?php
namespace Angel\PruebaTecnicaPhpAngel;

#use Persistence;
use OutOfBoundsException;
use Angel\PruebaTecnicaPhpAngel\Domain\User;
use Angel\PruebaTecnicaPhpAngel\Domain\UserId;

class UserRepository {

  public function __construct(private Persistence $persistence)
  {
    #
  }

  public function generateId()
  {
    return UserId::fromInt($this->persistence->generateId());
  }

  public function findById(UserId $id): User
  {
    try {
      $userArray = $this->persistence->retrieve($id->toInt());
    } catch (OutOfBoundsException $e) {
      throw new OutOfBoundsException(sprintf("Usuario con el ID %d no existe!", 
        $id->toInt()), 0, $e);
    }
    return User::fromArray($userArray);
  }

  public function findByUsername(string $username): User
  {
    try {
      $userArray = $this->persistence->retrieveByUsername($username);
    } catch (OutOfBoundsException $e) {
      throw new OutOfBoundsException(sprintf("Usuario con el Username '%s' no existe!", 
        $id->toInt()), 0, $e);
    }
    return User::fromArray($userArray);
  }

  public function findByEmail(string $email): User
  {
    try {
      $userArray = $this->persistence->retrieveByEmail($email);
    } catch (OutOfBoundsException $e) {
      throw new OutOfBoundsException(sprintf("Usuario con el Email '%s' no existe!", 
        $id->toInt()), 0, $e);
    }
    return User::fromArray($userArray);
  }

  public function save(User $user)
  {
    $this->persistence->persist([
      'id'        => $user->getId()->toInt(),
      'username'  => $user->getUsername(),
      'passwd'    => $user->getPasswd(),
      'email'     => $user->getEmail(),
      'active'    => $user->getActive(),
      'created'   => $user->getCreated(),
    ]);
  }

  public function delete(UserId $id): void
  {
    try {
      $this->persistence->delete($id->toInt());
    } catch (OutOfBoundsException $e) {
      throw new OutOfBoundsException(sprintf("Usuario con el ID %d no existe!", 
        $id->toInt()), 0, $e);
    }
  }

  public function count()
  {
    return $this->persistence->count();
  }
}