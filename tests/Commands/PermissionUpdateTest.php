<?php

namespace AdobeConnectClient\Tests\Commands;

use AdobeConnectClient\Commands\PermissionUpdate;
use AdobeConnectClient\Entities\Permission;
use AdobeConnectClient\Exceptions\NoAccessException;

class PermissionUpdateTest extends TestCommandBase
{
    public function testPermissionUpdate()
    {
        $this->userLogin();

        $permission = Permission::instance()
            ->setAclId(1)
            ->setPrincipalId(1)
            ->setPermissionId(Permission::PRINCIPAL_HOST);

        $command = new PermissionUpdate($permission);
        $command->setClient($this->client);

        $this->assertTrue($command->execute());
    }

    public function testNoAccess()
    {
        $this->userLogout();

        $permission = Permission::instance()
            ->setAclId(1)
            ->setPrincipalId(1)
            ->setPermissionId(Permission::PRINCIPAL_HOST);

        $command = new PermissionUpdate($permission);
        $command->setClient($this->client);

        $this->expectException(NoAccessException::class);

        $command->execute();
    }

    public function testInvalidDependency()
    {
        $permission = Permission::instance()
            ->setAclId(1)
            ->setPrincipalId(1)
            ->setPermissionId(Permission::PRINCIPAL_HOST);

        $command = new PermissionUpdate($permission);

        $this->expectException(\BadMethodCallException::class);

        $command->execute();
    }
}
