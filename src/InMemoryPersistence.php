<?php
namespace Angel\PruebaTecnicaPhpAngel;

use OutOfBoundsException;

class InMemoryPersistence implements Persistence
{
  private array $data = [];
  private int $lastId = 0;

  public function generateId(): int
  {
    return ++$this->lastId;
  }

  public function persist(array $data)
  {
    $this->data[$data['id']] = $data;
  }

  public function retrieve(int $id): array
  {
    if(!isset($this->data[$id])){
      throw new OutOfBoundsException(sprintf("No se encontró el ID: %d", $id));
    }
    return $this->data[$id];
  }

  public function retrieveByUsername(string $username): array
  {
    $user = null;
    foreach($this->data as $data){
      if($data['username'] == $username){
        $user = $data;
      }
    }
    if(empty($user)){
      throw new OutOfBoundsException(sprintf("No se encontró el Username: %s", $username));
    }
    return $user;
  }

  public function retrieveByEmail(string $email): array
  {
    $user = null;
    foreach($this->data as $data){
      if($data['email'] == $email){
        $user = $data;
      }
    }
    if(empty($user)){
      throw new OutOfBoundsException(sprintf("No se encontró el Email: %s", $email));
    }
    return $user;
  }

  public function delete(int $id): void
  {
    if(!isset($this->data[$id])){
      throw new OutOfBoundsException(sprintf("No se encontró el ID: %d", $id));
    }
    unset($this->data[$id]);
  }

  public function count()
  {
    return count($this->data);
  }
}