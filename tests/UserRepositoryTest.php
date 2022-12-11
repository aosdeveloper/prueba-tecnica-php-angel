<?php
namespace Angel\PruebaTecnicaPhpAngel\Tests;

use OutOfBoundsException;
use PHPUnit\Framework\TestCase;
use \Angel\PruebaTecnicaPhpAngel\Domain\User;
use \Angel\PruebaTecnicaPhpAngel\Domain\UserId;
use \Angel\PruebaTecnicaPhpAngel\UserRepository;
use \Angel\PruebaTecnicaPhpAngel\InMemoryPersistence;

final class UserRepositoryTest extends TestCase
{
  private UserRepository $repository;

  protected function setUp():void
  {
    $this->repository = new UserRepository(new InMemoryPersistence());
  }

  public function testCanGenerateId()
  {
    $this->assertEquals(1, $this->repository->generateId()->toInt());
  }

  public function testThrowsExceptionWhenTryingToFindUserWhichDoesNotExists()
  {
    $this->expectException(OutOfBoundsException::class);
    $this->expectExceptionMessage("Usuario con el ID 181 no existe!");
    $this->repository->findById(UserId::fromInt(181));
  }

  public function testCanCreateUser()
  {
    // create user
    $userId = $this->repository->generateId();
    $user = User::create($userId, 'asaavedra', '123456', 'angel.saavedra@gmail.com');
    $this->repository->save($user);

    $this->repository->findById($userId);

    $this->assertEquals($userId, $this->repository->findById($userId)->getId());
    $this->assertEquals('asaavedra', $this->repository->findById($userId)->getUsername());
    $this->assertEquals('123456', $this->repository->findById($userId)->getPasswd());
    $this->assertEquals('angel.saavedra@gmail.com', $this->repository->findById($userId)->getEmail());
    $this->assertEquals(true, $this->repository->findById($userId)->getActive());
  }

  public function testCanUpdateUser()
  {
    $userId = $this->repository->generateId();
    $user = User::create($userId, 'asaavedra', '123456', 'angel.saavedra@gmail.com');
    $this->repository->save($user);
    
    $user->setEmail("angelus@gmail.com");
    $this->repository->save($user);
    $this->assertEquals('angelus@gmail.com', $this->repository->findById($userId)->getEmail());
  }

  public function testCanCreate2Users()
  {
    $userId = $this->repository->generateId();
    $user = User::create($userId, 'asaavedra', '123456', 'angel.saavedra@gmail.com');
    $this->repository->save($user);

    $this->assertEquals(1, $this->repository->count());

    $userId2 = $this->repository->generateId();
    $user2 = User::create($userId2, 'omar', 'angelito', 'omar@yahoo.com');
    $this->repository->save($user2);
    
    $this->assertEquals(2, $this->repository->count());
  }

  public function testCanDeleteUser()
  {

    $userId = $this->repository->generateId();
    $user = User::create($userId, 'asaavedra', '123456', 'angel.saavedra@gmail.com');
    $this->repository->save($user);

    $this->assertEquals(1, $this->repository->count());

    $userId2 = $this->repository->generateId();
    $user2 = User::create($userId2, 'omar', 'angelito', 'omar@yahoo.com');
    $this->repository->save($user2);
    
    $this->assertEquals(2, $this->repository->count());

    $this->repository->delete($user->getId());

    $this->assertEquals(1, $this->repository->count());
  }

  public function testCandFindUser()
  {
    $userId = $this->repository->generateId();
    $user = User::create($userId, 'asaavedra', '123456', 'angel.saavedra@gmail.com');
    $this->repository->save($user);

    $this->assertEquals(1, $this->repository->count());

    $userId2 = $this->repository->generateId();
    $user2 = User::create($userId2, 'omar', 'angelito', 'omar@yahoo.com');
    $this->repository->save($user2);
    
    $this->assertEquals(2, $this->repository->count());

    $user->setEmail("angel.saavedra@gmail.com");
    $this->repository->save($user);

    $this->assertEquals('angel.saavedra@gmail.com', $this->repository->findById($userId)->getEmail());
    $this->assertEquals('asaavedra', $this->repository->findByUsername('asaavedra')->getUsername());
    $this->assertEquals('angel.saavedra@gmail.com', $this->repository->findByUsername('asaavedra')->getEmail());
    $this->assertEquals('angel.saavedra@gmail.com', $this->repository->findByEmail('angel.saavedra@gmail.com')->getEmail());

    $user = $this->repository->findByEmail('angel.saavedra@gmail.com');
    $user->setUsername('saavedra');
    $this->repository->save($user);
    
    $this->assertNotEquals('asaavedra', $this->repository->findById($user->getId())->getUsername());
    $this->assertEquals('saavedra', $this->repository->findById($user->getId())->getUsername());
  }
}