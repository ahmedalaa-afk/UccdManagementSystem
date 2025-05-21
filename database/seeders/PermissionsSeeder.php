<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $super_admin_permissions = [
            'all'
        ];
        foreach ($super_admin_permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        // super admin section end

        $admin_permissions = [
            // instructor permissions section
            'craete_instructor',
            'update_instructor',
            'delete_instructor',
            'show_instructor',
            'restore_instructor',
            'get_all_instructors',

            // student permissions section
            'import_students',
            'export_students',
            'get_all_students',

            // course permissions section
            'create_course',
            'update_course',
            'delete_course',
            'show_course',
            'restore_course',
            'get_all_enrollment_students',
            'accept_student',
            'reject_student',

            // post permission section
            'create_post',
            'update_post',
            'delete_post',
            'show_post',
            'restore_post',

            // category permission section
            'create_category',
            'update_category',
            'delete_category',
            'show_category',
            'restore_category'
        ];
        foreach ($admin_permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        // admin section end

        $publick_permissions = [
            'create_comment',
            'update_comment',
            'delete_comment',
            'show_comment',

            // like section
            'create_like',
            'delete_like',
        ];

        foreach ($publick_permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
