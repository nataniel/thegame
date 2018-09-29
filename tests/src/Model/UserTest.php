<?php
namespace MainTest\Model;

use PHPUnit\Framework\TestCase;
use Main\Model\User;

/**
 * Class UserTest
 * @package MainTest\Model
 * @covers  User
 */
class UserTest extends TestCase
{
    /**
     * @covers User::setLogin()
     * @covers User::getLogin()
     * @covers User::setEmail()
     * @covers User::getEmail()
     */
    public function testEmailAsLogin()
    {
        $user = new User([ 'email' => 'a@bc.com' ]);
        $this->assertEquals($user->getEmail(), $user->getLogin());

        $user->setLogin('test@test.pl');
        $this->assertEquals('test@test.pl', $user->getEmail());
    }

    /**
     * @covers User::setName()
     */
    public function testSetName()
    {
        $user = new User();
        $user->setName('Kasia Kowalska');
        $this->assertEquals('Kasia', $user->getFirstName());
        $this->assertEquals('Kowalska', $user->getLastName());
    }

    /**
     * @covers User::getName()
     */
    public function testGetName()
    {
        $user = new User([ 'first_name' => 'Kasia', 'last_name' => 'Kowalska' ]);
        $this->assertEquals('Kasia Kowalska', $user->getName());
    }

    /**
     * @covers User::getPreference()
     * @covers User::setPreference()
     */
    public function testPreferences()
    {
        $user = new User([
            'preferences' => [
                [ 'name' => 'test', 'value' => 1, ],
                [ 'name' => 'avatar', 'value' => 'img.jpg', ],
            ],
        ]);

        $this->assertEquals(1, $user->getPreference('test'));
        $this->assertEmpty($user->getPreference('not-existing'));

        $user->setPreference('acme', '#yolo');
        $this->assertEquals('#yolo', $user->getPreference('acme'));
    }

    /**
     * @covers User::isInGroup()
     */
    public function testIsInGroup()
    {
        $user = new User([ 'groups' => [ User\Group::ADMINISTRATORZY ]]);
        $this->assertTrue($user->isInGroup(User\Group::ADMINISTRATORZY));
        $this->assertFalse($user->isInGroup(User\Group::ZAREJESTROWANI_UZYTKOWNICY));
    }
}
