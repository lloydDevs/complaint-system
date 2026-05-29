<?php

namespace Database\Seeders;

use App\Models\Suggestion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class SuggestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'service_improvement',
            'policy',
            'staff_behavior',
            'facilities',
            'processes',
            'other',
        ];

        $statuses = [
            'pending',
            'under_review',
            'acknowledged',
            'implemented',
            'declined',
        ];

        $names = [
            'Juan Dela Cruz',
            'Maria Santos',
            'Carlos Reyes',
            'Angela Cruz',
            'Mark Bautista',
            'Sophia Mendoza',
            'Daniel Garcia',
            'Liza Ramos',
            'John Villanueva',
            'Patricia Flores',
        ];

        $designations = [
            'Teacher',
            'Student',
            'Barangay Resident',
            'IT Specialist',
            'Business Owner',
            'Engineer',
            'Nurse',
            'Driver',
            'Community Volunteer',
            'Government Employee',
        ];

        $suggestions = [
            'Install additional street lights in dark areas.',
            'Improve customer assistance response times.',
            'Provide better restroom maintenance in public offices.',
            'Create a digital complaint and feedback system.',
            'Improve drainage systems to prevent flooding.',
            'Conduct regular staff courtesy training.',
            'Add CCTV cameras in crowded public places.',
            'Simplify permit processing requirements.',
            'Provide more seating areas in waiting lounges.',
            'Improve queue management systems.',
            'Renovate old public service facilities.',
            'Implement online appointment scheduling.',
            'Provide clearer directional signages.',
            'Upgrade computer systems in offices.',
            'Develop an SMS notification system for updates.',
            'Increase security patrol visibility.',
            'Provide priority lanes for senior citizens.',
            'Conduct monthly cleanliness inspections.',
            'Install traffic signs in busy intersections.',
            'Improve waste disposal management.',
            'Provide faster internet connectivity in offices.',
            'Add emergency hotline posters.',
            'Improve disaster preparedness procedures.',
            'Provide employee skills enhancement seminars.',
            'Implement stricter anti-smoking policies.',
            'Upgrade transportation terminal facilities.',
            'Create youth engagement programs.',
            'Improve water supply systems.',
            'Provide free digital literacy workshops.',
            'Develop more green public spaces.',
        ];

        for ($i = 0; $i < 30; $i++) {
            Suggestion::create([
                'name' => rand(0, 4) === 0
                    ? null
                    : $names[array_rand($names)],

                'designation' => rand(0, 5) === 0
                    ? null
                    : $designations[array_rand($designations)],

                'suggestion' => $suggestions[$i],

                'category' => $categories[array_rand($categories)],

                'status' => $statuses[array_rand($statuses)],

                'admin_notes' => rand(0, 1)
                    ? 'This suggestion is currently under evaluation by the administration.'
                    : null,

                // Make sure user ID 1 exists
                'reviewed_by' => rand(0, 1)
                    ? 1
                    : null,

                'reviewed_at' => rand(0, 1)
                    ? Carbon::now()->subDays(rand(1, 60))
                    : null,

                'created_at' => Carbon::now()->subDays(rand(1, 90)),

                'updated_at' => now(),
            ]);
        }
    }
}
