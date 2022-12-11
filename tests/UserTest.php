<?php
namespace Angel\PruebaTecnicaPhpAngel\Tests;

use OutOfBoundsException;
use PHPUnit\Framework\TestCase;
use \Angel\PruebaTecnicaPhpAngel\Domain\User;
use \Angel\PruebaTecnicaPhpAngel\Domain\UserId;
use \Angel\PruebaTecnicaPhpAngel\UserRepository;
use \Angel\PruebaTecnicaPhpAngel\InMemoryPersistence;

final class UserTest extends TestCase
{
  public function testUser()
  {
    $userId = UserId::fromInt(1);
    $user = User::create($userId,'angelus','123456','asaavedra@gmail.com',true);

    $this->assertEquals('angelus', $user->getUsername());
    $this->assertNotEquals('angelito', $user->getUsername());
    $this->assertEquals('asaavedra@gmail.com', $user->getEmail());
    $this->assertEquals('123456', $user->getPasswd());
    $this->assertEquals(true, $user->getActive());
    $this->assertEquals(1, $userId->toInt());

    $user->setUsername('asaavedra');
    $this->assertEquals('asaavedra', $user->getUsername());

    $user->setEmail('angel.saavedra@gmail.com');
    $this->assertEquals('angel.saavedra@gmail.com', $user->getEmail());

    $user->setPasswd('987654');
    $this->assertEquals('987654', $user->getPasswd());

    $user->setActive(false);
    $this->assertEquals(false, $user->getActive());
  }  

}