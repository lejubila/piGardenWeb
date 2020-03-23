<?php

namespace Backpack\CRUD\PanelTraits;

use Backpack\CRUD\Exception\AccessDeniedException;

trait Access
{
    /*
    |--------------------------------------------------------------------------
    |                                   CRUD ACCESS
    |--------------------------------------------------------------------------
    */

    public function allowAccess($access)
    {
        // $this->addButtons((array)$access);
        return $this->access = array_merge(array_diff((array) $access, $this->access), $this->access);
    }

    public function denyAccess($access)
    {
        // $this->removeButtons((array)$access);
        return $this->access = array_diff($this->access, (array) $access);
    }

    /**
     * Check if a permission is enabled for a Crud Panel. Return false if not.
     *
     * @param string $permission Permission.
     *
     * @return bool
     */
    public function hasAccess($permission)
    {
        if (! in_array($permission, $this->access)) {
            return false;
        }

        return true;
    }

    /**
     * Check if any permission is enabled for a Crud Panel. Return false if not.
     *
     * @param array $permission_array Permissions.
     *
     * @return bool
     */
    public function hasAccessToAny($permission_array)
    {
        foreach ($permission_array as $key => $permission) {
            if (in_array($permission, $this->access)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if all permissions are enabled for a Crud Panel. Return false if not.
     *
     * @param array $permission_array Permissions.
     *
     * @return bool
     */
    public function hasAccessToAll($permission_array)
    {
        foreach ($permission_array as $key => $permission) {
            if (! in_array($permission, $this->access)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check if a permission is enabled for a Crud Panel. Fail if not.
     *
     * @param string $permission Permission
     *
     * @return bool
     *
     * @throws \Backpack\CRUD\Exception\AccessDeniedException in case the permission is not enabled
     */
    public function hasAccessOrFail($permission)
    {
        if (! in_array($permission, $this->access)) {
            throw new AccessDeniedException(trans('backpack::crud.unauthorized_access', ['access' => $permission]));
        }

        return true;
    }
}
