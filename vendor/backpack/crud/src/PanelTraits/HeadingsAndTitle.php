<?php

namespace Backpack\CRUD\PanelTraits;

trait HeadingsAndTitle
{
    public $titles = [];
    public $headings = [];
    public $subheadings = [];

    // -----
    // TITLE
    // -----
    // What shows up in the browser tab

    /**
     * Get the title string for the current controller method (action).
     *
     * @param  bool $action   create / edit / reorder / etc
     * @return string
     */
    public function getTitle($action = false)
    {
        if (! $action) {
            $action = $this->getActionMethod();
        }

        if (isset($this->titles[$action])) {
            return $this->titles[$action];
        }
    }

    /**
     * Change the title of a page for a certain controller method (action).
     *
     * @param string $string string to use as title
     * @param string $action create / edit / reorder / etc
     */
    public function setTitle($string, $action = false)
    {
        if (! $action) {
            $action = $this->getActionMethod();
        }

        $this->titles[$action] = $string;
    }

    // -------
    // HEADING
    // -------
    // The biggest heading on page (h1)

    /**
     * Get the heading string for the current controller method (action).
     *
     * @param  bool $action   create / edit / reorder / etc
     * @return string
     */
    public function getHeading($action = false)
    {
        if (! $action) {
            $action = $this->getActionMethod();
        }

        if (isset($this->headings[$action])) {
            return $this->headings[$action];
        }
    }

    /**
     * Change the heading of a page for a certain controller method (action).
     *
     * @param string $string string to use as heading
     * @param string $action create / edit / reorder / etc
     */
    public function setHeading($string, $action = false)
    {
        if (! $action) {
            $action = $this->getActionMethod();
        }

        $this->headings[$action] = $string;
    }

    // ----------
    // SUBHEADING
    // ----------
    // Smaller text next to the biggest heading on page.

    /**
     * Get the subheading for a certain controller method (action).
     *
     * @param  bool $action   create / edit / reorder / etc
     * @return string
     */
    public function getSubheading($action = false)
    {
        if (! $action) {
            $action = $this->getActionMethod();
        }

        if (isset($this->subheadings[$action])) {
            return $this->subheadings[$action];
        }
    }

    /**
     * Change the subheading of a page for a certain controller method (action).
     *
     * @param string $string string to use as subheading
     * @param string $action create / edit / reorder / etc
     */
    public function setSubheading($string, $action = false)
    {
        if (! $action) {
            $action = $this->getActionMethod();
        }

        $this->subheadings[$action] = $string;
    }
}
