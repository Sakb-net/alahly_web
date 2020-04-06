<?php

use Illuminate\Database\Seeder;
use App\Permission;

class PermissionTableSeeder extends Seeder {

    /**

     * Run the database seeds.

     *

     * @return void

     */
    public function run() {

        $permission = [
                [
                'name' => 'access-all',
                'display_name' => 'all access',
                'description' => 'all access'
            ],
                [
                'name' => 'post-type-all',
                'display_name' => 'All Post type',
                'description' => 'All Post type'
            ],
                [
                'name' => 'statistics',
                'display_name' => 'Statistics',
                'description' => 'Statistics'
            ],
                [
                'name' => 'admin-panel',
                'display_name' => 'login to admin panel',
                'description' => 'login to admin panel'
            ],
                [
                'name' => 'post-all',
                'display_name' => 'All Post',
                'description' => 'All Post'
            ],
                [
                'name' => 'post-list',
                'display_name' => 'Display Post Listing',
                'description' => 'See only Listing Of Post'
            ],
                [
                'name' => 'post-create',
                'display_name' => 'Create Post',
                'description' => 'Create New Post'
            ],
                [
                'name' => 'post-edit',
                'display_name' => 'Edit Post',
                'description' => 'Edit Post'
            ],
                [
                'name' => 'post-edit-only',
                'display_name' => 'Edit His Post',
                'description' => 'Edit His Post'
            ],
                [
                'name' => 'post-show',
                'display_name' => 'Show Post',
                'description' => 'Show Post'
            ],
                [
                'name' => 'post-show-only',
                'display_name' => 'Show His Post',
                'description' => 'Show His Post'
            ],
                [
                'name' => 'post-delete',
                'display_name' => 'Delete Post',
                'description' => 'Delete Post'
            ],
                [
                'name' => 'post-delete-only',
                'display_name' => 'Delete His Post',
                'description' => 'Delete His Post'
            ],
                [
                'name' => 'user-all',
                'display_name' => 'All User',
                'description' => 'All User'
            ],
                [
                'name' => 'user-list',
                'display_name' => 'Display User',
                'description' => 'Display User'
            ],
                [
                'name' => 'user-delete',
                'display_name' => 'Delete User',
                'description' => 'Delete User'
            ],
                [
                'name' => 'user-show',
                'display_name' => 'Show User',
                'description' => 'Show User'
            ],
                [
                'name' => 'user-edit',
                'display_name' => 'Edit User',
                'description' => 'Edit User'
            ],
                [
                'name' => 'user-profile',
                'display_name' => 'User Has Profile',
                'description' => 'User Has Profile'
            ],
                [
                'name' => 'message-all',
                'display_name' => 'All Message',
                'description' => 'All Message'
            ],
                [
                'name' => 'message-replay',
                'display_name' => 'Replay Message',
                'description' => 'Replay Message'
            ],
                [
                'name' => 'message-list',
                'display_name' => 'Display Message',
                'description' => 'Display Message'
            ],
                [
                'name' => 'image-upload',
                'display_name' => 'Upload Image',
                'description' => 'Upload Image'
            ],
                [
                'name' => 'image-edit',
                'display_name' => 'Edit Image',
                'description' => 'Edit Image'
            ],
            [
                'name' => 'category-all',
                'display_name' => 'All Category',
                'description' => 'All Category'
            ],
                [
                'name' => 'category-list',
                'display_name' => 'Display Category Listing',
                'description' => 'See only Category Of Post'
            ],
                [
                'name' => 'category-create',
                'display_name' => 'Create Category',
                'description' => 'Create New Category'
            ],
                [
                'name' => 'category-edit',
                'display_name' => 'Edit Category',
                'description' => 'Edit Category'
            ],
                [
                'name' => 'category-delete',
                'display_name' => 'Delete Category',
                'description' => 'Delete Category'
            ],
            
            [
                'name' => 'section-all',
                'display_name' => 'All Section',
                'description' => 'All Section'
            ],
                [
                'name' => 'section-list',
                'display_name' => 'Display Section Listing',
                'description' => 'See only Section Of Post'
            ],
                [
                'name' => 'section-create',
                'display_name' => 'Create Section',
                'description' => 'Create New Section'
            ],
                [
                'name' => 'section-edit',
                'display_name' => 'Edit Section',
                'description' => 'Edit Section'
            ],
                [
                'name' => 'section-delete',
                'display_name' => 'Delete Section',
                'description' => 'Delete Section'
            ],
            [
                'name' => 'bundle-all',
                'display_name' => 'All Bundle',
                'description' => 'All Bundle'
            ],
                [
                'name' => 'bundle-list',
                'display_name' => 'Display Bundle Listing',
                'description' => 'See only Bundle Of Post'
            ],
                [
                'name' => 'bundle-create',
                'display_name' => 'Create Bundle',
                'description' => 'Create New Bundle'
            ],
                [
                'name' => 'bundle-edit',
                'display_name' => 'Edit Bundle',
                'description' => 'Edit Bundle'
            ],
                [
                'name' => 'bundle-delete',
                'display_name' => 'Delete Bundle',
                'description' => 'Delete Bundle'
            ],
            [
                'name' => 'feature-all',
                'display_name' => 'All Feature',
                'description' => 'All Feature'
            ],
                [
                'name' => 'feature-list',
                'display_name' => 'Display Bundle Listing',
                'description' => 'See only Bundle Of Post'
            ],
                [
                'name' => 'feature-create',
                'display_name' => 'Create Feature',
                'description' => 'Create New Feature'
            ],
                [
                'name' => 'feature-edit',
                'display_name' => 'Edit Feature',
                'description' => 'Edit Feature'
            ],
            [
                'name' => 'feature-delete',
                'display_name' => 'Delete Feature',
                'description' => 'Delete Feature'
            ],
            
            [
                'name' => 'comment-all',
                'display_name' => 'All Comment',
                'description' => 'All Comment'
            ],
                [
                'name' => 'comment-list',
                'display_name' => 'Display Comment Listing',
                'description' => 'See only Comment Of Post'
            ],
                [
                'name' => 'comment-create',
                'display_name' => 'Create Comment',
                'description' => 'Create New Comment'
            ],
                [
                'name' => 'comment-edit',
                'display_name' => 'Edit Comment',
                'description' => 'Edit Comment'
            ],
                [
                'name' => 'comment-edit-only',
                'display_name' => 'Edit His Comment',
                'description' => 'Edit His Comment'
            ],
                [
                'name' => 'comment-delete',
                'display_name' => 'Delete Comment',
                'description' => 'Delete Comment'
            ],
                [
                'name' => 'comment-delete-only',
                'display_name' => 'Delete His Comment',
                'description' => 'Delete His Comment'
            ],
                [
                'name' => 'comment-edit-post-only',
                'display_name' => 'Edit His Post Comment',
                'description' => 'Edit His Post Comment'
            ],
                [
                'name' => 'comment-delete-post-only',
                'display_name' => 'Delete His Post Comment',
                'description' => 'Delete His Post Comment'
            ],
        ];


        foreach ($permission as $key => $value) {

            Permission::create($value);
        }
    }

}
