<?php

namespace Backpack\CRUD\PanelTraits;

trait Views
{
    protected $createView = 'crud::create';
    protected $editView = 'crud::edit';
    protected $showView = 'crud::show';
    protected $detailsRowView = 'crud::details_row';
    protected $revisionsView = 'crud::revisions';
    protected $revisionsTimelineView = 'crud::inc.revision_timeline';
    protected $reorderView = 'crud::reorder';
    protected $listView = 'crud::list';
    protected $createContentClass;
    protected $editContentClass;
    protected $listContentClass;
    protected $showContentClass;
    protected $reorderContentClass;
    protected $revisionsTimelineContentClass;

    // -------
    // CREATE
    // -------

    /**
     * Sets the create template.
     *
     * @param string $view name of the template file
     *
     * @return string $view name of the template file
     */
    public function setCreateView($view)
    {
        $this->createView = $view;

        return $this->createView;
    }

    /**
     * Gets the create template.
     * @return string name of the template file
     */
    public function getCreateView()
    {
        return $this->createView;
    }

    /**
     * Sets the create content class.
     * @param string $createContentClass content class
     */
    public function setCreateContentClass(string $createContentClass)
    {
        $this->createContentClass = $createContentClass;
    }

    /**
     * Gets the create content class.
     * @return string content class for create view
     */
    public function getCreateContentClass()
    {
        return $this->createContentClass ?? config('backpack.crud.create_content_class', 'col-md-8 col-md-offset-2');
    }

    // -------
    // READ
    // -------

    /**
     * Sets the list template.
     *
     * @param string $view name of the template file
     *
     * @return string $view name of the template file
     */
    public function setListView($view)
    {
        $this->listView = $view;

        return $this->listView;
    }

    /**
     * Gets the list template.
     * @return string name of the template file
     */
    public function getListView()
    {
        return $this->listView;
    }

    /**
     * Sets the list content class.
     * @param string $listContentClass content class
     */
    public function setListContentClass(string $listContentClass)
    {
        $this->listContentClass = $listContentClass;
    }

    /**
     * Gets the list content class.
     * @return string content class for list view
     */
    public function getListContentClass()
    {
        return $this->listContentClass ?? config('backpack.crud.list_content_class', 'col-md-12');
    }

    /**
     * Sets the details row template.
     *
     * @param string $view name of the template file
     *
     * @return string $view name of the template file
     */
    public function setDetailsRowView($view)
    {
        $this->detailsRowView = $view;

        return $this->detailsRowView;
    }

    /**
     * Gets the details row template.
     * @return string name of the template file
     */
    public function getDetailsRowView()
    {
        return $this->detailsRowView;
    }

    /**
     * Sets the show template.
     *
     * @param string $view name of the template file
     *
     * @return string $view name of the template file
     */
    public function setShowView($view)
    {
        $this->showView = $view;

        return $this->showView;
    }

    /**
     * Gets the show template.
     * @return string name of the template file
     */
    public function getShowView()
    {
        return $this->showView;
    }

    /**
     * Sets the edit content class.
     * @param string $editContentClass content class
     */
    public function setShowContentClass(string $showContentClass)
    {
        $this->showContentClass = $showContentClass;
    }

    /**
     * Gets the edit content class.
     * @return string content class for edit view
     */
    public function getShowContentClass()
    {
        return $this->showContentClass ?? config('backpack.crud.show_content_class', 'col-md-8 col-md-offset-2');
    }

    // -------
    // UPDATE
    // -------

    /**
     * Sets the edit template.
     *
     * @param string $view name of the template file
     *
     * @return string $view name of the template file
     */
    public function setEditView($view)
    {
        $this->editView = $view;

        return $this->editView;
    }

    /**
     * Gets the edit template.
     * @return string name of the template file
     */
    public function getEditView()
    {
        return $this->editView;
    }

    /**
     * Sets the edit content class.
     * @param string $editContentClass content class
     */
    public function setEditContentClass(string $editContentClass)
    {
        $this->editContentClass = $editContentClass;
    }

    /**
     * Gets the edit content class.
     * @return string content class for edit view
     */
    public function getEditContentClass()
    {
        return $this->editContentClass ?? config('backpack.crud.edit_content_class', 'col-md-8 col-md-offset-2');
    }

    /**
     * Sets the reorder template.
     *
     * @param string $view name of the template file
     *
     * @return string $view name of the template file
     */
    public function setReorderView($view)
    {
        $this->reorderView = $view;

        return $this->reorderView;
    }

    /**
     * Gets the reorder template.
     * @return string name of the template file
     */
    public function getReorderView()
    {
        return $this->reorderView;
    }

    /**
     * Sets the reorder content class.
     * @param string $reorderContentClass content class
     */
    public function setReorderContentClass(string $reorderContentClass)
    {
        $this->reorderContentClass = $reorderContentClass;
    }

    /**
     * Gets the reorder&nest content class.
     * @return string content class for reorder and nest view
     */
    public function getReorderContentClass()
    {
        return $this->reorderContentClass ?? config('backpack.crud.reorder_content_class', 'col-md-8 col-md-offset-2');
    }

    /**
     * Sets the revision template.
     *
     * @param string $view name of the template file
     *
     * @return string $view name of the template file
     */
    public function setRevisionsView($view)
    {
        $this->revisionsView = $view;

        return $this->revisionsView;
    }

    /**
     * Sets the revision template.
     *
     * @param string $view name of the template file
     *
     * @return string $view name of the template file
     */
    public function setRevisionsTimelineView($view)
    {
        $this->revisionsTimelineView = $view;

        return $this->revisionsTimelineView;
    }

    /**
     * Gets the revisions template.
     * @return string name of the template file
     */
    public function getRevisionsView()
    {
        return $this->revisionsView;
    }

    /**
     * Gets the revisions template.
     * @return string name of the template file
     */
    public function getRevisionsTimelineView()
    {
        return $this->revisionsTimelineView;
    }

    /**
     * Sets the revisions timeline content class.
     * @param string revisions timeline content class
     */
    public function setRevisionsTimelineContentClass(string $revisionsTimelineContentClass)
    {
        $this->revisionsTimelineContentClass = $revisionsTimelineContentClass;
    }

    /**
     * Gets the revisions timeline content class.
     * @return string content class for revisions timeline view
     */
    public function getRevisionsTimelineContentClass()
    {
        return $this->revisionsTimelineContentClass ?? config('backpack.crud.revisions_timeline_content_class', 'col-md-8 col-md-offset-2');
    }

    // -------
    // ALIASES
    // -------

    public function getPreviewView()
    {
        return $this->getShowView();
    }

    public function setPreviewView($view)
    {
        return $this->setShowView($view);
    }

    public function getUpdateView()
    {
        return $this->getEditView();
    }

    public function setUpdateView($view)
    {
        return $this->setEditView($view);
    }

    public function setUpdateContentClass(string $editContentClass)
    {
        return $this->setEditContentClass($editContentClass);
    }

    public function getUpdateContentClass()
    {
        return $this->getEditContentClass();
    }
}
