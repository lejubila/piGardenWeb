<?php

namespace Backpack\CRUD\Tests\Unit\CrudPanel;

use Backpack\CRUD\Exception\AccessDeniedException;

class CrudPanelAccessTest extends BaseCrudPanelTest
{
    private $unknownPermission = 'unknownPermission';

    private $defaultAccessList = [
        'list',
        'create',
        'update',
        'delete',
    ];

    private $fullAccessList = [
        'list',
        'create',
        'update',
        'delete',
        'revisions',
        'reorder',
        'show',
        'details_row',
    ];

    public function testDefaultAccess()
    {
        $this->assertEquals($this->defaultAccessList, $this->crudPanel->access);
    }

    public function testHasAccess()
    {
        foreach ($this->defaultAccessList as $permission) {
            $this->assertTrue($this->crudPanel->hasAccess($permission));
        }

        foreach (array_diff($this->fullAccessList, $this->defaultAccessList) as $permission) {
            $this->assertFalse($this->crudPanel->hasAccess($permission));
        }
    }

    public function testAllowAccess()
    {
        $permission = 'reorder';

        $this->crudPanel->allowAccess($permission);

        $this->assertTrue($this->crudPanel->hasAccess($permission));
    }

    public function testAllowAccessToUnknownPermission()
    {
        $this->crudPanel->allowAccess($this->unknownPermission);

        $this->assertTrue($this->crudPanel->hasAccess($this->unknownPermission));
    }

    public function testDenyAccess()
    {
        $permission = 'delete';

        $this->crudPanel->denyAccess($permission);

        $this->assertFalse($this->crudPanel->hasAccess($permission));
        $this->assertEquals(array_diff($this->crudPanel->access, [$permission]), $this->crudPanel->access);
    }

    public function testDenyAccessToUnknownPermission()
    {
        $this->crudPanel->denyAccess($this->unknownPermission);

        $this->assertFalse($this->crudPanel->hasAccess($this->unknownPermission));
        $this->assertEquals($this->defaultAccessList, $this->crudPanel->access);
    }

    public function testHasAccessToAny()
    {
        $this->assertTrue($this->crudPanel->hasAccessToAny($this->fullAccessList));
    }

    public function testHasAccessToAnyDenied()
    {
        $this->assertFalse($this->crudPanel->hasAccessToAny(array_diff($this->fullAccessList, $this->defaultAccessList)));
    }

    public function testHasAccessToAll()
    {
        $this->assertTrue($this->crudPanel->hasAccessToAll($this->defaultAccessList));
    }

    public function testHasAccessToAllDenied()
    {
        $this->assertFalse($this->crudPanel->hasAccessToAll($this->fullAccessList));
    }

    public function testHasAccessOrFail()
    {
        foreach ($this->defaultAccessList as $permission) {
            $this->assertTrue($this->crudPanel->hasAccessOrFail($permission));
        }
    }

    public function testHasAccessOrFailDenied()
    {
        $this->expectException(AccessDeniedException::class);

        $this->crudPanel->hasAccessOrFail($this->unknownPermission);
    }
}
