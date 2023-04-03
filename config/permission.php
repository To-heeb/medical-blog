<?php

return [

    'models' => [

        /*
         * When using the "HasPermissions" trait from this package, we need to know which
         * Eloquent model should be used to retrieve your permissions. Of course, it
         * is often just the "Permission" model but you may use whatever you like.
         *
         * The model you want to use as a Permission model needs to implement the
         * `Spatie\Permission\Contracts\Permission` contract.
         */

        'permission' => Spatie\Permission\Models\Permission::class,

        /*
         * When using the "HasRoles" trait from this package, we need to know which
         * Eloquent model should be used to retrieve your roles. Of course, it
         * is often just the "Role" model but you may use whatever you like.
         *
         * The model you want to use as a Role model needs to implement the
         * `Spatie\Permission\Contracts\Role` contract.
         */

        'role' => Spatie\Permission\Models\Role::class,

    ],

    'table_names' => [

        /*
         * When using the "HasRoles" trait from this package, we need to know which
         * table should be used to retrieve your roles. We have chosen a basic
         * default value but you may easily change it to any table you like.
         */

        'roles' => 'roles',

        /*
         * When using the "HasPermissions" trait from this package, we need to know which
         * table should be used to retrieve your permissions. We have chosen a basic
         * default value but you may easily change it to any table you like.
         */

        'permissions' => 'permissions',

        /*
         * When using the "HasPermissions" trait from this package, we need to know which
         * table should be used to retrieve your models permissions. We have chosen a
         * basic default value but you may easily change it to any table you like.
         */

        'model_has_permissions' => 'model_has_permissions',

        /*
         * When using the "HasRoles" trait from this package, we need to know which
         * table should be used to retrieve your models roles. We have chosen a
         * basic default value but you may easily change it to any table you like.
         */

        'model_has_roles' => 'model_has_roles',

        /*
         * When using the "HasRoles" trait from this package, we need to know which
         * table should be used to retrieve your roles permissions. We have chosen a
         * basic default value but you may easily change it to any table you like.
         */

        'role_has_permissions' => 'role_has_permissions',
    ],

    'column_names' => [
        /*
         * Change this if you want to name the related pivots other than defaults
         */
        'role_pivot_key' => null, //default 'role_id',
        'permission_pivot_key' => null, //default 'permission_id',

        /*
         * Change this if you want to name the related model primary key other than
         * `model_id`.
         *
         * For example, this would be nice if your primary keys are all UUIDs. In
         * that case, name this `model_uuid`.
         */

        'model_morph_key' => 'model_id',

        /*
         * Change this if you want to use the teams feature and your related model's
         * foreign key is other than `team_id`.
         */

        'team_foreign_key' => 'team_id',
    ],

    /*
     * When set to true, the method for checking permissions will be registered on the gate.
     * Set this to false, if you want to implement custom logic for checking permissions.
     */

    'register_permission_check_method' => true,

    /*
     * When set to true the package implements teams using the 'team_foreign_key'. If you want
     * the migrations to register the 'team_foreign_key', you must set this to true
     * before doing the migration. If you already did the migration then you must make a new
     * migration to also add 'team_foreign_key' to 'roles', 'model_has_roles', and
     * 'model_has_permissions'(view the latest version of package's migration file)
     */

    'teams' => false,

    /*
     * When set to true, the required permission names are added to the exception
     * message. This could be considered an information leak in some contexts, so
     * the default setting is false here for optimum safety.
     */

    'display_permission_in_exception' => false,

    /*
     * When set to true, the required role names are added to the exception
     * message. This could be considered an information leak in some contexts, so
     * the default setting is false here for optimum safety.
     */

    'display_role_in_exception' => false,

    /*
     * By default wildcard permission lookups are disabled.
     */

    'enable_wildcard_permission' => false,

    'cache' => [

        /*
         * By default all permissions are cached for 24 hours to speed up performance.
         * When permissions or roles are updated the cache is flushed automatically.
         */

        'expiration_time' => \DateInterval::createFromDateString('24 hours'),

        /*
         * The cache key used to store all permissions.
         */

        'key' => 'spatie.permission.cache',

        /*
         * You may optionally indicate a specific cache driver to use for permission and
         * role caching using any of the `store` drivers listed in the cache.php config
         * file. Using 'default' here means to use the `default` set in cache.php.
         */

        'store' => 'default',
    ],

    /*
    *
    * All Permissions
    *
    */

    'permissions' => [

        // Users
        'view users' => [
            'display_name' => 'View users',
            'description'  => 'Can view users',
            'group'        => 'User',
        ],

        'create users' => [
            'display_name' => 'Create users',
            'description'  => 'Can create users',
            'group'        => 'User',
        ],

        'edit users' => [
            'display_name' => 'Edit users',
            'description'  => 'Can edit users',
            'group'        => 'User',
        ],

        'delete users' => [
            'display_name' => 'Delete users',
            'description'  => 'Can delete users',
            'group'        => 'User',
        ],

        // Roles
        'view roles' => [
            'display_name' => 'View roles',
            'description'  => 'Can view roles',
            'group'        => 'Role',
        ],

        'create roles' => [
            'display_name' => 'Create roles',
            'description'  => 'Can create roles',
            'group'        => 'Role',
        ],

        'edit roles' => [
            'display_name' => 'Edit roles',
            'description'  => 'Can edit roles',
            'group'        => 'Role',
        ],

        'delete roles' => [
            'display_name' => 'Delete roles',
            'description'  => 'Can delete roles',
            'group'        => 'Role',
        ],

        // Permissions
        'view permissions' => [
            'display_name' => 'View permissions',
            'description'  => 'Can view permissions',
            'group'        => 'Permission',
        ],

        'create permissions' => [
            'display_name' => 'Create permissions',
            'description'  => 'Can create permissions',
            'group'        => 'Permission',
        ],

        'edit permissions' => [
            'display_name' => 'Edit permissions',
            'description'  => 'Can edit permissions',
            'group'        => 'Permission',
        ],

        'delete permissions' => [
            'display_name' => 'Delete permissions',
            'description'  => 'Can delete permissions',
            'group'        => 'Permission',
        ],

        // Answers
        'manage answers' => [
            'display_name' => 'Manage all answers',
            'description'  => 'Can manage all answers',
            'group'        => 'Answer',
        ],

        'view answers' => [
            'display_name' => 'View answers',
            'description'  => 'Can view answers',
            'group'        => 'Answer',
        ],

        'create answers' => [
            'display_name' => 'Create answers',
            'description'  => 'Can create answers',
            'group'        => 'Answer',
        ],

        'edit answers' => [
            'display_name' => 'Edit answers',
            'description'  => 'Can edit answers',
            'group'        => 'Answer',
        ],

        'delete answers' => [
            'display_name' => 'Delete answers',
            'description'  => 'Can delete answers',
            'group'        => 'Answer',
        ],

        // Post
        'view posts' => [
            'display_name' => 'View posts',
            'description'  => 'Can view posts',
            'group'        => 'Post',
        ],

        'create posts' => [
            'display_name' => 'Create posts',
            'description'  => 'Can create posts',
            'group'        => 'Post',
        ],

        'edit posts' => [
            'display_name' => 'Edit posts',
            'description'  => 'Can edit posts',
            'group'        => 'Post',
        ],

        'delete posts' => [
            'display_name' => 'Delete posts',
            'description'  => 'Can delete posts',
            'group'        => 'Post',
        ],

        // Questions
        'view questions' => [
            'display_name' => 'View questions',
            'description'  => 'Can view questions',
            'group'        => 'Question',
        ],

        'create questions' => [
            'display_name' => 'Create questions',
            'description'  => 'Can create questions',
            'group'        => 'Question',
        ],

        'edit questions' => [
            'display_name' => 'Edit questions',
            'description'  => 'Can edit questions',
            'group'        => 'Question',
        ],

        'delete questions' => [
            'display_name' => 'Delete questions',
            'description'  => 'Can delete questions',
            'group'        => 'Question',
        ],


        // Comments
        'view comments' => [
            'display_name' => 'View comments',
            'description'  => 'Can view comments',
            'group'        => 'Comment',
        ],

        'create comments' => [
            'display_name' => 'Create comments',
            'description'  => 'Can create comments',
            'group'        => 'Comment',
        ],

        'edit comments' => [
            'display_name' => 'Edit comments',
            'description'  => 'Can edit comments',
            'group'        => 'Comment',
        ],

        'delete comments' => [
            'display_name' => 'Delete comments',
            'description'  => 'Can delete comments',
            'group'        => 'Comment',
        ],

        // Tags
        'view tags' => [
            'display_name' => 'View tags',
            'description'  => 'Can view tags',
            'group'        => 'Tag',
        ],

        'create tags' => [
            'display_name' => 'Create tags',
            'description'  => 'Can create tags',
            'group'        => 'Tag',
        ],

        'edit tags' => [
            'display_name' => 'Edit tags',
            'description'  => 'Can edit tags',
            'group'        => 'Tag',
        ],

        'delete tags' => [
            'display_name' => 'Delete tags',
            'description'  => 'Can delete tags',
            'group'        => 'Tag',
        ],

        // Categories
        'view categories' => [
            'display_name' => 'View categories',
            'description'  => 'Can view categories',
            'group'        => 'Category',
        ],

        'create categories' => [
            'display_name' => 'Create categories',
            'description'  => 'Can create categories',
            'group'        => 'Category',
        ],

        'edit categories' => [
            'display_name' => 'Edit categories',
            'description'  => 'Can edit categories',
            'group'        => 'Category',
        ],

        'delete categories' => [
            'display_name' => 'Delete categories',
            'description'  => 'Can delete categories',
            'group'        => 'Category',
        ],


        // Logs
        'manage logs' => [
            'display_name' => 'Manage logs',
            'description'  => 'Can manage logs',
            'group'        => 'Logs',
        ],
    ],
];
