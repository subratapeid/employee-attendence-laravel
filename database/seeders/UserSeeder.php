<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'Admin')->first();
        $superAdminRole = Role::where('name', 'Super Admin')->first();
        $employeeRole = Role::where('name', 'Employee')->first();
        $fieldGroupRole = Role::where('name', 'Field Group')->first();
        
        User::create([
            'name' => 'Field Group',
            'email' => 'fieldgroup@gmail.com',
            'emp_id' => 'JT0301',
            'password' => bcrypt('12345'),
            'phone' => '9547415324',
            'state' => 'Karnataka',
            'district' => 'Bangalore',
            'location' => 'Yelahanka',
            'latitude' => '13.08379650',
            'longitude' => '77.58638670',
            'status' => 'Active',
        ])->assignRole($fieldGroupRole);

        User::create([
            'name' => 'Subrata Porel',
            'email' => 'subratap.eid@gmail.com',
            'emp_id' => 'JT0301',
            'password' => bcrypt('12345'),
            'phone' => '9547415324',
            'state' => 'Karnataka',
            'district' => 'Bangalore',
            'location' => 'Yelahanka',
            'latitude' => '13.08379650',
            'longitude' => '77.58638670',
            'status' => 'Active',
        ])->assignRole($adminRole);

        User::create([
            'name' => 'Mahesh S',
            'email' => 'maheshs@integramicro.co.in',
            'emp_id' => '2359',
            'password' => bcrypt('12345'),
            'phone' => '9844394427',
            'state' => 'Karnataka',
            'district' => 'Bangalore',
            'location' => 'Yelahanka',
            'latitude' => '13.08379650',
            'longitude' => '77.58638670',
            'status' => 'Active',
        ])->assignRole($adminRole);

        // Create super admin user
        User::create([
            'name' => 'Subrata P',
            'email' => 'subratap@integramicro.co.in',
            'emp_id' => 'JT0301',
            'password' => bcrypt('12345'),
            'phone' => '6366960297',
            'state' => 'Karnataka',
            'district' => 'Bangalore',
            'location' => 'Jakkur',
            'latitude' => '13.08379650',
            'longitude' => '77.58638670',
            'status' => 'Active',

        ])->assignRole($superAdminRole);
        User::create([
            'name' => 'Shravankumar Rajubhai Vaghela',
            'email' => 'shravankumarrv@integramicro.co.in',
            'emp_id' => '4492',
            'password' => bcrypt('12345'),
            'phone' => '7600064247',
            'state' => 'Gujarat',
            'district' => 'Mahesana',
            'location' => 'Butapadali',
            'status' => 'Active',
        ])->assignRole($employeeRole);

        User::create([
            'name' => 'Chaudhari Saurabh Kumar',
            'email' => 'saurabhk@integramicro.co.in',
            'emp_id' => '4493',
            'password' => bcrypt('12345'),
            'phone' => '6355839678',
            'state' => 'Gujarat',
            'district' => 'Mahesana',
            'location' => 'Palodar',
            'status' => 'Active',
        ])->assignRole($employeeRole);

        User::create([
            'name' => 'Chaudhari Krinil Jashvanthkumar',
            'email' => 'krinilj@integramicro.co.in',
            'emp_id' => '4547',
            'password' => bcrypt('12345'),
            'phone' => '8238221284',
            'state' => 'Gujarat',
            'district' => 'Mahesana',
            'location' => 'Palodar',
            'status' => 'Active',
        ])->assignRole($employeeRole);

        User::create([
            'name' => 'Chaudhary Hinaben Saradarbhai',
            'email' => 'hinabens@integramicro.co.in',
            'emp_id' => '4548',
            'password' => bcrypt('12345'),
            'phone' => '9510183226',
            'state' => 'Gujarat',
            'district' => 'Banaskantha',
            'location' => 'Nalasar',
            'status' => 'Active',
        ])->assignRole($employeeRole);

        User::create([
            'name' => 'Ajaykumar Devjeebhai Chaudhary',
            'email' => 'devjeebhaic@integramicro.co.in',
            'emp_id' => '4549',
            'password' => bcrypt('12345'),
            'phone' => '7016176172',
            'state' => 'Gujarat',
            'district' => 'Banaskantha',
            'location' => 'Nalasar',
            'status' => 'Active',
        ])->assignRole($employeeRole);

        User::create([
            'name' => 'Ananda Kumar Barik',
            'email' => 'anandabarik@integramicro.co.in',
            'emp_id' => '4550',
            'password' => bcrypt('12345'),
            'phone' => '9938277069',
            'state' => 'Odisha',
            'district' => 'Bhubaneswar',
            'location' => 'Batighar',
            'status' => 'Active',
        ])->assignRole($employeeRole);

        User::create([
            'name' => 'Priyadarsini Das',
            'email' => 'priyadarsinidas@integramicro.co.in',
            'emp_id' => '4551',
            'password' => bcrypt('12345'),
            'phone' => '',
            'state' => 'Odisha',
            'district' => 'Bhubaneswar',
            'location' => 'Batighar',
            'status' => 'Active',
        ])->assignRole($employeeRole);

        User::create([
            'name' => 'Parmar Sejal',
            'email' => 'parmars@integramicro.co.in',
            'emp_id' => '4552',
            'password' => bcrypt('12345'),
            'phone' => '9106023589',
            'state' => 'Gujarat',
            'district' => 'Jamnagar',
            'location' => 'Juna Nagna',
            'status' => 'Active',
        ])->assignRole($employeeRole);

        User::create([
            'name' => 'Zala Harsh Nilesh',
            'email' => 'harshnilesh@integramicro.co.in',
            'emp_id' => '4553',
            'password' => bcrypt('12345'),
            'phone' => '8849098383',
            'state' => 'Gujarat',
            'district' => 'Jamnagar',
            'location' => 'Juna Nagna',
            'status' => 'Active',
        ])->assignRole($employeeRole);

        User::create([
            'name' => 'Pravinkumar Patel',
            'email' => 'pravinkumarp@integramicro.co.in',
            'emp_id' => '4555',
            'password' => bcrypt('12345'),
            'phone' => '8849098383',
            'state' => 'Gujarat',
            'district' => 'Mahesana',
            'location' => 'Butapadali',
            'status' => 'Active',
        ])->assignRole($employeeRole);


    }
}
