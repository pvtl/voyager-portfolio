<?php

use TCG\Voyager\Models\Role;
use Illuminate\Database\Seeder;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\DataType;
use TCG\Voyager\Models\Permission;
use Pvtl\VoyagerPortfolio\PortfolioCategories;
use Illuminate\Support\Facades\DB;

class PortfolioCategorySeeder extends Seeder
{
    protected $permissions = [
        'browse_portfolio_categories',
        'read_portfolio_categories',
        'edit_portfolio_categories',
        'add_portfolio_categories',
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
            'name' => 'portfolio_categories',
            'slug' => 'portfolio-categories',
            'display_name_singular' => 'Category',
            'display_name_plural' => 'Categories',
            'icon' => 'voyager-categories',
            'model_name' => 'Pvtl\\VoyagerPortfolio\\PortfolioCategories',
            'controller' => '',
            'generate_permissions' => '1',
        ]);
        $dataType->save();

        foreach ($this->permissions as $permissionName) {
            $permission = Permission::firstOrNew([
                'key' => $permissionName,
                'table_name' => 'portfolio_categories',
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
        $categoryDataType = DataType::where('slug', 'portfolio-categories')->firstOrFail();

        $dataRow = $this->dataRow($categoryDataType, 'id');
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
                'details'      => json_encode([
                    'validation' => [
                        'rule' => 'required|string'
                    ]
                ]),
                'order'        => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($categoryDataType, 'name');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => 'Name',
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

        $dataRow = $this->dataRow($categoryDataType, 'slug');
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
                        'origin' => 'name',
                        'forceUpdate' => true,
                    ],
                    'validation' => [
                        'rule' => 'required|unique:portfolio_categories,slug'
                    ]
                ]),
                'order' => 3,
            ])->save();
        }

        $dataRow = $this->dataRow($categoryDataType, 'parent_id');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'select_dropdown',
                'display_name' => 'Parent ID',
                'required'     => 0,
                'browse'       => 0,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
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
                'order' => 4,
            ])->save();
        }

        $dataRow = $this->dataRow($categoryDataType, 'order');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => 'Order',
                'required'     => 1,
                'browse'       => 0,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => json_encode([
                    'default' => 1,
                ]),
                'order' => 5,
            ])->save();
        }

        $dataRow = $this->dataRow($categoryDataType, 'created_at');
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
                'order'        => 6,
            ])->save();
        }

        $dataRow = $this->dataRow($categoryDataType, 'updated_at');
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
                'order'        => 7,
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
        $post = PortfolioCategories::firstOrNew(['slug' => 'uncategorized']);
        if (!$post->exists) {
            $post->fill([
                'name' => 'Uncategorized',
                'slug' => 'uncategorized',
                'parent_id' => null,
                'order' => 1,
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
