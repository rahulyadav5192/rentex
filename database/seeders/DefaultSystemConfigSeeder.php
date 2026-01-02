<?php

namespace Database\Seeders;

use App\Models\Type;
use App\Models\Amenity;
use App\Models\Advantage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DefaultSystemConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Check if defaults already exist
        $existingTypes = Type::where('parent_id', 0)->count();
        $existingAmenities = Amenity::where('parent_id', 0)->count();
        $existingAdvantages = Advantage::where('parent_id', 0)->count();

        // Seed Default Types
        // 2 Invoice types, 4 Expense types, Maintainer types, and Maintenance Issue types
        if ($existingTypes == 0) {
            $defaultTypes = [
                // Invoice Types (2)
                [
                    'title' => 'Monthly Rent',
                    'type' => 'invoice',
                    'parent_id' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'title' => 'Utility Bill',
                    'type' => 'invoice',
                    'parent_id' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // Expense Types (4)
                [
                    'title' => 'Maintenance & Repairs',
                    'type' => 'expense',
                    'parent_id' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'title' => 'Property Management',
                    'type' => 'expense',
                    'parent_id' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'title' => 'Insurance',
                    'type' => 'expense',
                    'parent_id' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'title' => 'Property Tax',
                    'type' => 'expense',
                    'parent_id' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // Maintainer Types
                [
                    'title' => 'Plumber',
                    'type' => 'maintainer_type',
                    'parent_id' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'title' => 'Electrician',
                    'type' => 'maintainer_type',
                    'parent_id' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'title' => 'Carpenter',
                    'type' => 'maintainer_type',
                    'parent_id' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'title' => 'General Maintenance',
                    'type' => 'maintainer_type',
                    'parent_id' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'title' => 'HVAC Technician',
                    'type' => 'maintainer_type',
                    'parent_id' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // Maintenance Issue Types
                [
                    'title' => 'Plumbing Issue',
                    'type' => 'issue',
                    'parent_id' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'title' => 'Electrical Problem',
                    'type' => 'issue',
                    'parent_id' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'title' => 'HVAC Malfunction',
                    'type' => 'issue',
                    'parent_id' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'title' => 'Structural Damage',
                    'type' => 'issue',
                    'parent_id' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'title' => 'Appliance Repair',
                    'type' => 'issue',
                    'parent_id' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

            Type::insert($defaultTypes);
            $this->command->info('Default Types seeded successfully!');
        } else {
            $this->command->info('Default Types already exist. Skipping...');
        }

        // Seed Default Amenities (5 entries)
        if ($existingAmenities == 0) {
            $defaultAmenities = [
                [
                    'name' => 'Swimming Pool',
                    'description' => 'Private or shared swimming pool facility',
                    'image' => null, // Can add image path later if needed
                    'parent_id' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Parking',
                    'description' => 'Dedicated parking space available',
                    'image' => null,
                    'parent_id' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Gym/Fitness Center',
                    'description' => 'On-site gym or fitness center',
                    'image' => null,
                    'parent_id' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Security',
                    'description' => '24/7 security and surveillance',
                    'image' => null,
                    'parent_id' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Garden/Lawn',
                    'description' => 'Private or shared garden/lawn area',
                    'image' => null,
                    'parent_id' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

            Amenity::insert($defaultAmenities);
            $this->command->info('Default Amenities seeded successfully!');
        } else {
            $this->command->info('Default Amenities already exist. Skipping...');
        }

        // Seed Default Advantages (5 entries)
        if ($existingAdvantages == 0) {
            $defaultAdvantages = [
                [
                    'name' => 'Near Public Transport',
                    'description' => 'Close to public transportation hubs',
                    'parent_id' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Shopping Mall Nearby',
                    'description' => 'Convenient access to shopping centers',
                    'parent_id' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Schools in Area',
                    'description' => 'Educational institutions nearby',
                    'parent_id' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Medical Facilities',
                    'description' => 'Hospitals and clinics in proximity',
                    'parent_id' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Pet Friendly',
                    'description' => 'Pet-friendly property with amenities',
                    'parent_id' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

            Advantage::insert($defaultAdvantages);
            $this->command->info('Default Advantages seeded successfully!');
        } else {
            $this->command->info('Default Advantages already exist. Skipping...');
        }
    }
}

