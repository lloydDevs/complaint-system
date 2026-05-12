<?php

namespace Database\Factories;

use App\Models\Complaint;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Complaint>
 */
class ComplaintFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Complaint::class;

    public function definition(): array
    {
        $agencies = [
            // Executive Departments
            'Department of Agriculture (DA)',
            'Department of Education (DepEd)',
            'Department of Energy (DOE)',
            'Department of Environment and Natural Resources (DENR)',
            'Department of Finance (DOF)',
            'Department of Foreign Affairs (DFA)',
            'Department of Health (DOH)',
            'Department of Information and Communications Technology (DICT)',
            'Department of the Interior and Local Government (DILG)',
            'Department of Justice (DOJ)',
            'Department of Labor and Employment (DOLE)',
            'Department of National Defense (DND)',
            'Department of Public Works and Highways (DPWH)',
            'Department of Science and Technology (DOST)',
            'Department of Social Welfare and Development (DSWD)',
            'Department of Tourism (DOT)',
            'Department of Trade and Industry (DTI)',
            'Department of Transportation (DOTr)',
            'Department of Budget and Management (DBM)',
            // Other Major Agencies
            'Bureau of Internal Revenue (BIR)',
            'Bureau of Customs (BOC)',
            'Social Security System (SSS)',
            'Government Service Insurance System (GSIS)',
            'Philippine Health Insurance Corporation (PhilHealth)',
        ];

        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'code' => 'CMP-'.now()->format('Y').'-'.strtoupper(Str::random(6)),
            'title' => $this->faker->sentence(6),
            'description' => $this->faker->paragraphs(2, true),
            'admin_response' => $this->faker->optional(0.5)->sentence(12),
            'agency' => $this->faker->randomElement($agencies),
            'department' => $this->faker->randomElement(['Administrative', 'Technical', 'Field Office', 'Customer Service']),
            'respondent_name' => $this->faker->name(),
            'respondent_position' => $this->faker->jobTitle(),
            'status' => $this->faker->randomElement(['pending', 'resolved', 'viewed']),
        ];
    }
}
