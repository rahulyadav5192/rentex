<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LeadFormField;
use App\Models\User;

class DefaultLeadFormFieldsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get all owners
        $owners = User::where('type', 'owner')->get();

        foreach ($owners as $owner) {
            // Check if default fields already exist for this owner
            $existingFields = LeadFormField::where('parent_id', $owner->id)
                ->where('is_default', true)
                ->count();

            if ($existingFields > 0) {
                continue; // Skip if defaults already exist
            }

            // Create default fields
            $defaultFields = [
                [
                    'field_name' => 'name',
                    'field_label' => 'Name',
                    'field_type' => 'input',
                    'field_options' => null,
                    'is_required' => true,
                    'is_default' => true,
                    'sort_order' => 1,
                    'parent_id' => $owner->id,
                ],
                [
                    'field_name' => 'email',
                    'field_label' => 'Email',
                    'field_type' => 'input',
                    'field_options' => null,
                    'is_required' => true,
                    'is_default' => true,
                    'sort_order' => 2,
                    'parent_id' => $owner->id,
                ],
                [
                    'field_name' => 'phone',
                    'field_label' => 'Phone',
                    'field_type' => 'input',
                    'field_options' => null,
                    'is_required' => true,
                    'is_default' => true,
                    'sort_order' => 3,
                    'parent_id' => $owner->id,
                ],
            ];

            foreach ($defaultFields as $fieldData) {
                LeadFormField::create($fieldData);
            }
        }
    }
}
