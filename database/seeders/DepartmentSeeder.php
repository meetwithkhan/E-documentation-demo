<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\DepartmentFunction;
use App\Models\Designation;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        // Departments with their functions
        $departments = [
            'Production'         => ['Production'],
            'QA'                 => ['Chemical Lab', 'Pkg Lab', 'Micro Lab', 'IPQA'],
            'Store'              => ['Store'],
            'Engineering'        => ['Engineering'],
            'Accounting & Finance' => ['Accounting & Finance'],
            'HR & Admin'         => ['HR & Admin'],
        ];

        foreach ($departments as $deptName => $functions) {
            $dept = Department::firstOrCreate(['name' => $deptName]);
            foreach ($functions as $funcName) {
                DepartmentFunction::firstOrCreate([
                    'department_id' => $dept->id,
                    'name'          => $funcName,
                ]);
            }
        }

        // Designations
        $designations = [
            'Executive',
            'Senior Executive',
            'Assistant Manager',
            'Deputy Manager',
            'Manager',
            'Senior Manager',
            'AGM',
            'DGM',
            'GM',
        ];

        foreach ($designations as $name) {
            Designation::firstOrCreate(['name' => $name]);
        }
    }
}