<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * One permission per admin sidebar module. Fixed/seeded rather than
     * user-creatable — a permission string is only meaningful if code
     * actually checks it.
     *
     * Clients and client system accounts use a granular CRUD split instead
     * of one catch-all permission, since access to them (and especially to
     * stored third-party system passwords) needs finer control than the
     * rest of the admin modules.
     */
    public function run(): void
    {
        $permissions = [
            'manage-sessions',
            'manage-students',
            'manage-certificates',
            'manage-materials',
            'manage-services',
            'manage-contact-us',
            'manage-partners',
            'manage-trending',
            'manage-galleries',
            'manage-users',
            'manage-documents',
            'manage-assessments',

            'view-clients',
            'create-clients',
            'update-clients',
            'delete-clients',
            'view-client-documents',
            'upload-client-documents',
            'download-client-documents',
            'delete-client-documents',

            'view-client-systems',
            'create-client-systems',
            'update-client-systems',
            'delete-client-systems',
            'view-client-system-passwords',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $this->migrateLegacyManageClients();
    }

    // manage-clients predates the granular client/document/system-account split above.
    // Any role still holding it gets the full equivalent set before it's removed, so
    // existing role assignments don't silently lose access.
    private function migrateLegacyManageClients(): void
    {
        $legacy = Permission::where('name', 'manage-clients')->first();
        if (!$legacy) {
            return;
        }

        $fullClientAccess = [
            'view-clients', 'create-clients', 'update-clients', 'delete-clients',
            'view-client-documents', 'upload-client-documents', 'download-client-documents', 'delete-client-documents',
            'view-client-systems', 'create-client-systems', 'update-client-systems', 'delete-client-systems',
            'view-client-system-passwords',
        ];

        foreach ($legacy->roles as $role) {
            $role->givePermissionTo($fullClientAccess);
        }

        $legacy->delete();
    }
}
