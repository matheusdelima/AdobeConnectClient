---
layout: default
title: Entities
permalink: /entities/
order: 4
---

# The Entities

The package use two types of objects to send and receive info from Adobe Connect.

## Entities to Send and Receive

Entities are objects with get and set methods and all of them are Arrayable, returning an associative array formatted as the Adobe Connect API needs.

### SCO

All objects on Adobe Connect are SCO, Shareable Content Objects. These objects
are encapsulate in SCO class entity.

SCO normally are meetings, events, folders, contents etc.

```php
<?php
use AdobeConnectClient\SCO;

$sco = SCO::instance()
    ->setType(SCO::TYPE_MEETING)
    ->setFolderId(12345);
```

### Principal

A Principal is user, group and others not objects.

```php
<?php
use AdobeConnectClient\Principal;

$sco = Principal::instance()
    ->setType(Principal::TYPE_USER)
    ->setFirstName('Adobe')
    ->setLastName('Connect');
```

### Permission

The Permission normally involves a Principal and a SCO, but exists special permissions
to applied only in a SCO.

Examples:

Set a SCO Meeting to public access to anyone with the URL.

```php
<?php
use AdobeConnectClient\Connection\Curl\Connection;
use AdobeConnectClient\Client;
use AdobeConnectClient\Permission;

$connection = new Connection('https://hostname.adobeconnect.com');
$client =  new Client($connection);
$client->login('username', 'password');

$scoId = 12345;

$permission = Permission::instance()
    ->setAclId($scoId)
    ->setPrincipalId(Permission::MEETING_PRINCIPAL_PUBLIC_ACCESS)
    ->setPermissionId(Permission::MEETING_ANYONE_WITH_URL);

$client->permissionUpdate($permission);
```

Set a User (Principal) as Host in a Meeting

```php
<?php
use AdobeConnectClient\Connection\Curl\Connection;
use AdobeConnectClient\Client;
use AdobeConnectClient\Permission;

$connection = new Connection('https://hostname.adobeconnect.com');
$client =  new Client($connection);
$client->login('username', 'password');

$scoId = 12345;
$principalId = 987654;

$permission = Permission::instance()
    ->setAclId($scoId)
    ->setPrincipalId($principalId)
    ->setPermissionId(Permission::PRINCIPAL_HOST);

$client->permissionUpdate($permission);
```

## Entities only to receive

These objects are only returned by the web service.

### SCORecord

The SCO Record is a special SCO for a meeting recording.

```php
<?php
use AdobeConnectClient\Connection\Curl\Connection;
use AdobeConnectClient\Client;

$connection = new Connection('https://hostname.adobeconnect.com');
$client = new Client($connection);
$client->login('username', 'password');

$folderId = 123;

$scoRecords = $client->listRecordings($folderId);

foreach ($scoRecords as $scoRecord) {
    // shows a DateInterval
    var_dump($scoRecord->getDuration());
}
```

### CommonInfo

The CommonInfo is only to receive information about the server (the common-info endpoint).

```php
<?php
use AdobeConnectClient\Connection\Curl\Connection;
use AdobeConnectClient\Client;

$connection = new Connection('https://hostname.adobeconnect.com');
$client =  new Client($connection);
$commonInfo = $client->commonInfo();

echo $commonInfo->getVersion();
```