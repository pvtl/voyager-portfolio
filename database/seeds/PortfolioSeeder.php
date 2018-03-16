<?php

use TCG\Voyager\Models\Role;
use TCG\Voyager\Models\Menu;
use Illuminate\Database\Seeder;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\MenuItem;
use TCG\Voyager\Models\DataType;
use TCG\Voyager\Models\Permission;
use Pvtl\VoyagerPortfolio\Portfolio;
use Illuminate\Support\Facades\DB;

class PortfolioSeeder extends Seeder
{
    protected $permissions = [
        'browse_portfolio',
        'read_portfolio',
        'edit_portfolio',
        'add_portfolio',
    ];

    /**
     * Run all Seeds
     *
     * @return void
     */
    public function run()
    {
        $this->addPermissions();
        $this->addBread();
        $this->addDefaults();
        $this->addToAdminMenu();
    }

    /**
     * Add permissions to Voyager
     *
     * @return void
     */
    protected function addPermissions()
    {
        $role = Role::where('name', 'admin')->firstOrFail();

        $dataType = DataType::firstOrNew([
            'name' => 'portfolio',
            'slug' => 'portfolio',
            'display_name_singular' => 'Portfolio Item',
            'display_name_plural' => 'Portfolio',
            'icon' => 'voyager-certificate',
            'model_name' => 'Pvtl\\VoyagerPortfolio\\Portfolio',
            'controller' => '',
            'generate_permissions' => 1
        ]);
        $dataType->save();

        foreach ($this->permissions as $permissionName) {
            $permission = Permission::firstOrNew([
                'key' => $permissionName,
                'table_name' => 'portfolio',
            ]);
            $permission->save();

            DB::table('permission_role')->insert([
                'permission_id' => $permission->id,
                'role_id' => $role->id,
            ]);
        }
    }

    /**
     * Add BREAD to Voyager
     *
     * @return void
     */
    protected function addBread()
    {
        $postDataType = DataType::where('slug', 'portfolio')->firstOrFail();

        $dataRow = $this->dataRow($postDataType, 'id');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'number',
                'display_name' => 'ID',
                'required'     => 1,
                'browse'       => 0,
                'read'         => 0,
                'edit'         => 0,
                'add'          => 0,
                'delete'       => 0,
                'details'      => '',
                'order'        => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($postDataType, 'title');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => 'Title',
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => '',
                'order'        => 2,
            ])->save();
        }

        $dataRow = $this->dataRow($postDataType, 'slug');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => 'Slug',
                'required'     => 1,
                'browse'       => 0,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => json_encode([
                    'slugify' => [
                        'origin'      => 'title',
                        'forceUpdate' => true,
                    ],
                ]),
                'order' => 3,
            ])->save();
        }

        $dataRow = $this->dataRow($postDataType, 'status');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'select_dropdown',
                'display_name' => 'Status',
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => json_encode([
                    'default' => 'DRAFT',
                    'options' => [
                        'PUBLISHED' => 'Published',
                        'DRAFT'     => 'Draft',
                        'PENDING'   => 'Pending',
                    ],
                ]),
                'order' => 4,
            ])->save();
        }

        $dataRow = $this->dataRow($postDataType, 'featured');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'checkbox',
                'display_name' => 'Featured',
                'required'     => 0,
                'browse'       => 0,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => '',
                'order'        => 5,
            ])->save();
        }

        $dataRow = $this->dataRow($postDataType, 'category_id');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'select_dropdown',
                'display_name' => 'Category',
                'required'     => 1,
                'browse'       => 0,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 0,
                'details'      => json_encode([
                    'default' => '',
                    'null'    => '',
                    'options' => [
                        '' => '-- None --',
                    ],
                    'relationship' => [
                        'key'   => 'id',
                        'label' => 'name',
                    ],
                ]),
                'order'        => 6,
            ])->save();
        }

        $dataRow = $this->dataRow($postDataType, 'image');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'image',
                'display_name' => 'Post Image',
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => json_encode([
                    'resize' => [
                        'width'  => '1000',
                        'height' => 'null',
                    ],
                    'quality'    => '70%',
                    'upsize'     => true,
                    'thumbnails' => [
                        [
                            'name'  => 'medium',
                            'scale' => '50%',
                        ],
                        [
                            'name'  => 'small',
                            'scale' => '25%',
                        ],
                        [
                            'name' => 'cropped',
                            'crop' => [
                                'width'  => '300',
                                'height' => '250',
                            ],
                        ],
                    ],
                ]),
                'order' => 7,
            ])->save();
        }

        $dataRow = $this->dataRow($postDataType, 'excerpt');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text_area',
                'display_name' => 'Excerpt',
                'required'     => 1,
                'browse'       => 0,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => '',
                'order'        => 8,
            ])->save();
        }

        $dataRow = $this->dataRow($postDataType, 'body');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'rich_text_box',
                'display_name' => 'Body',
                'required'     => 1,
                'browse'       => 0,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => '',
                'order'        => 9,
            ])->save();
        }

        $dataRow = $this->dataRow($postDataType, 'testimonial');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'rich_text_box',
                'display_name' => 'Testimonial',
                'required'     => 0,
                'browse'       => 0,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => '',
                'order'        => 10,
            ])->save();
        }

        $dataRow = $this->dataRow($postDataType, 'testimonial_author');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => 'Testimonial Author',
                'required'     => 0,
                'browse'       => 0,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => '',
                'order'        => 11,
            ])->save();
        }

        $dataRow = $this->dataRow($postDataType, 'seo_title');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => 'Seo Title',
                'required'     => 0,
                'browse'       => 0,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => '',
                'order'        => 12,
            ])->save();
        }

        $dataRow = $this->dataRow($postDataType, 'meta_description');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text_area',
                'display_name' => 'Meta Description',
                'required'     => 0,
                'browse'       => 0,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => '',
                'order'        => 13,
            ])->save();
        }

        $dataRow = $this->dataRow($postDataType, 'created_at');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'timestamp',
                'display_name' => 'Created At',
                'required'     => 0,
                'browse'       => 0,
                'read'         => 1,
                'edit'         => 0,
                'add'          => 0,
                'delete'       => 0,
                'details'      => '',
                'order'        => 14,
            ])->save();
        }

        $dataRow = $this->dataRow($postDataType, 'updated_at');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'timestamp',
                'display_name' => 'Updated At',
                'required'     => 0,
                'browse'       => 0,
                'read'         => 0,
                'edit'         => 0,
                'add'          => 0,
                'delete'       => 0,
                'details'      => '',
                'order'        => 15,
            ])->save();
        }
    }

    /**
     * Add some default content
     *
     * @return void
     */
    protected function addDefaults()
    {
        $post = Portfolio::firstOrNew(['slug' => 'my-sample-portfolio']);
        if (!$post->exists) {
            $post->fill([
                'title' => 'My Sample Portfolio Post',
                'slug' => 'my-sample-portfolio',
                'status' => 'PUBLISHED',
                'featured' => 1,
                'category_id' => 1,
                'image' => 'posts/post1.jpg',
                'excerpt' => 'Lorem ipsum die sip petris...',
                'body' => '<p>There is no one who loves pain itself, who seeks after it and wants to have it, simply because it is pain. What is Lorem Ipsum? Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p><p>What is Lorem Ipsum? Lorem Ipsum is simply dummy text of the printing and typesetting industry. There is no one who loves pain itself, who seeks after it and wants to have it.</p>',
                'testimonial' => '<p>There is no one who loves pain itself, who seeks after it and wants to have it, simply because it is pain. What is Lorem Ipsum? Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p><p>What is Lorem Ipsum? Lorem Ipsum is simply dummy text of the printing and typesetting industry. There is no one who loves pain itself, who seeks after it and wants to have it.</p>',
                'testimonial_author' => 'John Smith',
                'seo_title' => 'Hello World! - From Pivotal',
                'meta_description' => 'There is no one who loves pain itself, who seeks after',
            ])->save();
        }
    }

    /**
     * Add items to Voyager admin menu
     *
     * @return void
     */
    protected function addToAdminMenu()
    {
        // Ensure the 'admin' menu exists
        Menu::firstOrCreate([
            'name' => 'admin',
        ]);
        $menu = Menu::where('name', 'admin')->firstOrFail();

        // Add a top level 'Portfolio' menu item
        $parentItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title'   => 'Portfolio',
            'url'     => '#',
            'route'   => null,
        ]);
        if (!$parentItem->exists) {
            $parentItem->fill([
                'target'     => '_self',
                'icon_class' => 'voyager-certificate',
                'color'      => null,
                'parent_id'  => null,
                'order'      => 7,
            ])->save();
        }

        // Nest Portfolio and Categories under Blog
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title'   => 'Posts',
            'url'     => '',
            'route'   => 'voyager.portfolio.index',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target'     => '_self',
                'icon_class' => 'voyager-certificate',
                'color'      => null,
                'parent_id'  => $parentItem->id,
                'order'      => 1,
            ])->save();
        }

        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title'   => 'Categories',
            'url'     => '',
            'route'   => 'voyager.portfolio-categories.index',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target'     => '_self',
                'icon_class' => 'voyager-categories',
                'color'      => null,
                'parent_id'  => $parentItem->id,
                'order'      => 2,
            ])->save();
        }
    }

    /**
     * [dataRow description].
     *
     * @param [type] $type  [description]
     * @param [type] $field [description]
     *
     * @return [type] [description]
     */
    protected function dataRow($type, $field)
    {
        return DataRow::firstOrNew([
                'data_type_id' => $type->id,
                'field'        => $field,
            ]);
    }
}
