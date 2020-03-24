<?php

namespace Backpack\CRUD\Tests\Unit\CrudPanel;

use Config;

class CrudPanelViewsTest extends BaseCrudPanelTest
{
    private $customView = 'path/to/custom/view';
    private $customContentClass = 'col-md-12';

    // CREATE

    public function testSetCreateView()
    {
        $this->crudPanel->setCreateView($this->customView);
        $this->assertAttributeEquals($this->customView, 'createView', $this->crudPanel);
    }

    public function testGetCreateView()
    {
        $this->crudPanel->setCreateView($this->customView);
        $this->assertEquals($this->customView, $this->crudPanel->getCreateView());
    }

    public function testSetCreateContentClass()
    {
        $this->crudPanel->setCreateContentClass($this->customContentClass);
        $this->assertAttributeEquals($this->customContentClass, 'createContentClass', $this->crudPanel);
    }

    public function testGetCreateContentClass()
    {
        $this->crudPanel->setCreateContentClass($this->customContentClass);
        $this->assertEquals($this->customContentClass, $this->crudPanel->getCreateContentClass());
    }

    public function testGetCreateContentClassFromConfig()
    {
        Config::set('backpack.crud.create_content_class', $this->customContentClass);

        $this->assertEquals(Config::get('backpack.crud.create_content_class'), $this->crudPanel->getCreateContentClass());
    }

    // UPDATE

    public function testSetEditView()
    {
        $this->crudPanel->setEditView($this->customView);
        $this->assertAttributeEquals($this->customView, 'editView', $this->crudPanel);
    }

    public function testGetEditView()
    {
        $this->crudPanel->setEditView($this->customView);
        $this->assertEquals($this->customView, $this->crudPanel->getEditView());
    }

    public function testSetEditContentClass()
    {
        $this->crudPanel->setEditContentClass($this->customContentClass);
        $this->assertAttributeEquals($this->customContentClass, 'editContentClass', $this->crudPanel);
    }

    public function testGetEditContentClass()
    {
        $this->crudPanel->setEditContentClass($this->customContentClass);
        $this->assertEquals($this->customContentClass, $this->crudPanel->getEditContentClass());
    }

    public function testGetEditContentClassFromConfig()
    {
        Config::set('backpack.crud.edit_content_class', $this->customContentClass);

        $this->assertEquals(Config::get('backpack.crud.edit_content_class'), $this->crudPanel->getEditContentClass());
    }

    public function testSetUpdateView()
    {
        $this->crudPanel->setUpdateView($this->customView);
        $this->assertAttributeEquals($this->customView, 'editView', $this->crudPanel);
    }

    public function testGetUpdateView()
    {
        $this->crudPanel->setEditView($this->customView);
        $this->assertEquals($this->customView, $this->crudPanel->getUpdateView());
    }

    public function testSetUpdateContentClass()
    {
        $this->crudPanel->setUpdateContentClass($this->customContentClass);
        $this->assertAttributeEquals($this->customContentClass, 'editContentClass', $this->crudPanel);
    }

    public function testGetUpdateContentClass()
    {
        $this->crudPanel->setEditContentClass($this->customContentClass);
        $this->assertEquals($this->customContentClass, $this->crudPanel->getUpdateContentClass());
    }

    public function testGetUpdateContentClassFromConfig()
    {
        Config::set('backpack.crud.edit_content_class', $this->customContentClass);

        $this->assertEquals(Config::get('backpack.crud.edit_content_class'), $this->crudPanel->getUpdateContentClass());
    }

    // SHOW

    public function testSetShowView()
    {
        $this->crudPanel->setShowView($this->customView);
        $this->assertAttributeEquals($this->customView, 'showView', $this->crudPanel);
    }

    public function testGetShowView()
    {
        $this->crudPanel->setShowView($this->customView);
        $this->assertEquals($this->customView, $this->crudPanel->getShowView());
    }

    public function testSetShowContentClass()
    {
        $this->crudPanel->setShowContentClass($this->customContentClass);
        $this->assertAttributeEquals($this->customContentClass, 'showContentClass', $this->crudPanel);
    }

    public function testGetShowContentClass()
    {
        $this->crudPanel->setShowContentClass($this->customContentClass);
        $this->assertEquals($this->customContentClass, $this->crudPanel->getShowContentClass());
    }

    public function testGetShowContentClassFromConfig()
    {
        Config::set('backpack.crud.show_content_class', $this->customContentClass);

        $this->assertEquals(Config::get('backpack.crud.show_content_class'), $this->crudPanel->getShowContentClass());
    }

    public function testSetPreviewView()
    {
        $this->crudPanel->setPreviewView($this->customView);
        $this->assertAttributeEquals($this->customView, 'showView', $this->crudPanel);
    }

    public function testGetPreviewView()
    {
        $this->crudPanel->setShowView($this->customView);
        $this->assertEquals($this->customView, $this->crudPanel->getPreviewView());
    }

    // LIST ENTRIES

    public function testSetListView()
    {
        $this->crudPanel->setListView($this->customView);
        $this->assertAttributeEquals($this->customView, 'listView', $this->crudPanel);
    }

    public function testGetListView()
    {
        $this->crudPanel->setListView($this->customView);
        $this->assertEquals($this->customView, $this->crudPanel->getListView());
    }

    public function testSetListContentClass()
    {
        $this->crudPanel->setListContentClass($this->customContentClass);
        $this->assertAttributeEquals($this->customContentClass, 'listContentClass', $this->crudPanel);
    }

    public function testGetListContentClass()
    {
        $this->crudPanel->setListContentClass($this->customContentClass);
        $this->assertEquals($this->customContentClass, $this->crudPanel->getListContentClass());
    }

    public function testGetListContentClassFromConfig()
    {
        Config::set('backpack.crud.list_content_class', $this->customContentClass);

        $this->assertEquals(Config::get('backpack.crud.list_content_class'), $this->crudPanel->getListContentClass());
    }

    // DETAILS ROW

    public function testSetDetailsRowView()
    {
        $this->crudPanel->setDetailsRowView($this->customView);
        $this->assertAttributeEquals($this->customView, 'detailsRowView', $this->crudPanel);
    }

    public function testGetDetailsRowView()
    {
        $this->crudPanel->setDetailsRowView($this->customView);
        $this->assertEquals($this->customView, $this->crudPanel->getDetailsRowView());
    }

    // REORDER

    public function testSetReorderView()
    {
        $this->crudPanel->setReorderView($this->customView);
        $this->assertAttributeEquals($this->customView, 'reorderView', $this->crudPanel);
    }

    public function testGetReorderView()
    {
        $this->crudPanel->setReorderView($this->customView);
        $this->assertEquals($this->customView, $this->crudPanel->getReorderView());
    }

    public function testSetReorderContentClass()
    {
        $this->crudPanel->setReorderContentClass($this->customContentClass);
        $this->assertAttributeEquals($this->customContentClass, 'reorderContentClass', $this->crudPanel);
    }

    public function testGetReorderContentClass()
    {
        $this->crudPanel->setReorderContentClass($this->customContentClass);
        $this->assertEquals($this->customContentClass, $this->crudPanel->getReorderContentClass());
    }

    public function testGetReorderContentClassFromConfig()
    {
        Config::set('backpack.crud.reorder_content_class', $this->customContentClass);

        $this->assertEquals(Config::get('backpack.crud.reorder_content_class'), $this->crudPanel->getReorderContentClass());
    }

    // REVISIONS

    public function testSetRevisionsView()
    {
        $this->crudPanel->setRevisionsView($this->customView);
        $this->assertAttributeEquals($this->customView, 'revisionsView', $this->crudPanel);
    }

    public function testGetRevisionsView()
    {
        $this->crudPanel->setRevisionsView($this->customView);
        $this->assertEquals($this->customView, $this->crudPanel->getRevisionsView());
    }

    public function testSetRevisionsTimelineView()
    {
        $this->crudPanel->setRevisionsTimelineView($this->customView);
        $this->assertAttributeEquals($this->customView, 'revisionsTimelineView', $this->crudPanel);
    }

    public function testGetRevisionsTimelineView()
    {
        $this->crudPanel->setRevisionsTimelineView($this->customView);
        $this->assertEquals($this->customView, $this->crudPanel->getRevisionsTimelineView());
    }

    public function testSetRevisionsTimelineContentClass()
    {
        $this->crudPanel->setRevisionsTimelineContentClass($this->customContentClass);
        $this->assertAttributeEquals($this->customContentClass, 'revisionsTimelineContentClass', $this->crudPanel);
    }

    public function testGetRevisionsTimelineContentClass()
    {
        $this->crudPanel->setRevisionsTimelineContentClass($this->customContentClass);
        $this->assertEquals($this->customContentClass, $this->crudPanel->getRevisionsTimelineContentClass());
    }

    public function testGetRevisionsTimelineContentClassFromConfig()
    {
        Config::set('backpack.crud.revisions_timeline_content_class', $this->customContentClass);

        $this->assertEquals(Config::get('backpack.crud.revisions_timeline_content_class'), $this->crudPanel->getRevisionsTimelineContentClass());
    }
}
