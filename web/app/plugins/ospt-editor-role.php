<?php

/**
 * Plugin Name: OSPT Editor Role
 * Version: 1.0.0
 * Description: OSPT Editors are the same as normal Editors, but with permission to manage user accounts.
 * Author: Ollie Treend
 * Class OSPT_User_Roles
 */

class OSPT_Editor_Role {
    protected $role = 'ospt-editor';
    protected $inheritFromRole = 'editor';

    /**
     * Class constructor
     * Register hooks and filters.
     */
    public function __construct(){
        register_activation_hook(__FILE__, array($this, 'add_role'));
        register_deactivation_hook(__FILE__, array($this, 'remove_role'));
        add_filter('editable_roles', array(&$this, 'editable_roles'));
        add_filter('map_meta_cap', array(&$this, 'map_meta_cap'), 10, 4);
    }

    /**
     * Add new user role.
     * Inherit capabilities from $this->inheritFromRole
     */
    public function add_role() {
        global $wp_roles;
        if (!isset($wp_roles)) {
            $wp_roles = new WP_Roles();
        }

        if ($wp_roles->get_role($this->role)) {
            return true;
        }

        $editor = $wp_roles->get_role($this->inheritFromRole);

        // Add a new role with editor caps
        $new_editor = $wp_roles->add_role($this->role, 'OSPT Editor', $editor->capabilities);

        // Additional capabilities which this role should have
        $additionalCapabilities = array(
            'list_users',
            'create_users',
            'edit_users',
            'delete_users',
        );

        foreach ($additionalCapabilities as $cap) {
            $new_editor->add_cap($cap);
        }
    }

    /**
     * Remove user role.
     * Users with this role will be reassigned to $this->inheritFromRole
     */
    public function remove_role() {
        $users = get_users(array('role' => $this->role));
        if (count($users) > 0) {
            foreach ($users as $user) {
                $userid = $user->ID;
                $user_id_role = new WP_User($userid);
                $user_id_role->set_role($this->inheritFromRole);
            }
        }

        remove_role($this->role);
    }

    /**
     * Remove 'Administrator' from the list of roles if the current user is not an admin.
     *
     * @param array $roles
     * @return array
     */
    public function editable_roles($roles) {
        if (isset($roles['administrator']) && !current_user_can('administrator')) {
            unset($roles['administrator']);
        }

        return $roles;
    }

    /**
     * Map capabilities
     * If someone is trying to edit or delete and admin and that user isn't an admin, don't allow it.
     *
     * @param $caps
     * @param $cap
     * @param $user_id
     * @param $args
     * @return array
     */
    public function map_meta_cap($caps, $cap, $user_id, $args) {
        switch ($cap) {
            case 'edit_user':
            case 'remove_user':
            case 'promote_user':
                if (isset($args[0]) && $args[0] == $user_id) {
                    break;
                } elseif (!isset($args[0])) {
                    $caps[] = 'do_not_allow';
                }
                $other = new WP_User(absint($args[0]));
                if ($other->has_cap('administrator')) {
                    if (!current_user_can('administrator')) {
                        $caps[] = 'do_not_allow';
                    }
                }
                break;
            case 'delete_user':
            case 'delete_users':
                if(!isset($args[0])) {
                    break;
                }
                $other = new WP_User(absint($args[0]));
                if ($other->has_cap('administrator')) {
                    if (!current_user_can('administrator')) {
                        $caps[] = 'do_not_allow';
                    }
                }
                break;
            default:
                break;
        }

        return $caps;
    }
}

$ospt_user_roles = new OSPT_Editor_Role();
