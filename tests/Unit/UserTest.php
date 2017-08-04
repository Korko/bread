<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->artisan('migrate:refresh');
        $this->seed();
    }

    public function testCanAccessAll()
    {
        $user = factory(\App\User::class)->make(['root' => '']);
        $this->assertTrue($user->canAccess('/'));
        $this->assertTrue($user->canAccess('/toto'));

        $user = factory(\App\User::class)->make(['root' => '/']);
        $this->assertTrue($user->canAccess('/'));
        $this->assertTrue($user->canAccess('/toto'));
    }


    public function testCanAccessLimited()
    {
        $user = factory(\App\User::class)->make(['root' => '/,-/a']);
        $this->assertTrue($user->canAccess('/'));
        $this->assertTrue($user->canAccess('/toto'));

        $this->assertFalse($user->canAccess('/a'));
    }

    public function testCanAccessDirect()
    {
        $user = factory(\App\User::class)->make(['root' => '/a/b/c']);
        $this->assertTrue($user->canAccess('/'));
        $this->assertTrue($user->canAccess('/a'));
        $this->assertTrue($user->canAccess('/a/b'));
        $this->assertTrue($user->canAccess('/a/b/c'));
        $this->assertTrue($user->canAccess('/a/b/c/d'));

        $this->assertFalse($user->canAccess('/toto'));
        $this->assertFalse($user->canAccess('/a/bc'));
        $this->assertFalse($user->canAccess('/a/b/cd'));
    }
}
