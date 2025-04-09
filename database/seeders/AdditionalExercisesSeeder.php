<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Exercise;
use Illuminate\Support\Facades\DB;

class AdditionalExercisesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure we don't get duplicate exercises
        $existingNames = Exercise::pluck('name')->toArray();
        
        // Array of exercises to add
        $exercises = [
            // Chest exercises
            [
                'name' => 'Dumbbell Flyes',
                'muscle_group' => 'Chest',
                'equipment' => 'Dumbbells',
                'instructions' => 'Lie on a flat bench holding dumbbells above your chest with palms facing each other. Lower the weights in an arc to the sides, then bring them back together.'
            ],
            [
                'name' => 'Cable Crossover',
                'muscle_group' => 'Chest',
                'equipment' => 'Cable Machine',
                'instructions' => 'Stand between two cable stations with handles attached at shoulder height. Pull the handles forward and down in an arc, crossing them in front of your chest.'
            ],
            [
                'name' => 'Decline Bench Press',
                'muscle_group' => 'Chest',
                'equipment' => 'Barbell',
                'instructions' => 'Lie on a decline bench, grip the barbell with hands slightly wider than shoulder-width. Lower the bar to your lower chest, then press back up.'
            ],
            [
                'name' => 'Chest Dips',
                'muscle_group' => 'Chest',
                'equipment' => 'Dip Bars',
                'instructions' => 'Support yourself on dip bars with arms extended. Lean forward slightly, lower your body by bending your elbows, then push back up.'
            ],

            // Back exercises
            [
                'name' => 'Deadlift',
                'muscle_group' => 'Back',
                'equipment' => 'Barbell',
                'instructions' => 'Stand with feet hip-width apart, barbell over feet. Bend at hips and knees to grip the bar, then stand up straight by driving hips forward.'
            ],
            [
                'name' => 'One-Arm Dumbbell Row',
                'muscle_group' => 'Back',
                'equipment' => 'Dumbbell',
                'instructions' => 'Place one hand and knee on a bench, the other foot on the floor. Hold a dumbbell in the free hand, pull it toward your hip, then lower it back down.'
            ],
            [
                'name' => 'T-Bar Row',
                'muscle_group' => 'Back',
                'equipment' => 'T-Bar Machine',
                'instructions' => 'Straddle a T-bar row machine, bend at the hips with a straight back. Pull the weight up toward your chest, then lower it back down with control.'
            ],
            [
                'name' => 'Seated Cable Row',
                'muscle_group' => 'Back',
                'equipment' => 'Cable Machine',
                'instructions' => 'Sit at a cable row station with feet braced. Pull the handle toward your lower abdomen, keeping your back straight, then return to starting position.'
            ],

            // Legs exercises
            [
                'name' => 'Romanian Deadlift',
                'muscle_group' => 'Legs',
                'equipment' => 'Barbell',
                'instructions' => 'Stand with feet hip-width apart, holding a barbell in front of thighs. Hinge at the hips to lower the bar toward the floor, then return to standing.'
            ],
            [
                'name' => 'Leg Extensions',
                'muscle_group' => 'Legs',
                'equipment' => 'Machine',
                'instructions' => 'Sit in a leg extension machine with pads across your lower shins. Extend your legs to lift the weight, then return to starting position.'
            ],
            [
                'name' => 'Hamstring Curls',
                'muscle_group' => 'Legs',
                'equipment' => 'Machine',
                'instructions' => 'Lie face down on a hamstring curl machine. Curl your legs up by bending at the knees, then lower the weight back down.'
            ],
            [
                'name' => 'Bulgarian Split Squat',
                'muscle_group' => 'Legs',
                'equipment' => 'Dumbbells',
                'instructions' => 'Stand with one foot on the ground, the other on a bench behind you. Hold dumbbells at your sides, lower your body by bending the front knee, then push back up.'
            ],
            [
                'name' => 'Calf Raises',
                'muscle_group' => 'Legs',
                'equipment' => 'Machine',
                'instructions' => 'Stand on a calf raise machine with balls of feet on the platform. Raise your heels by extending ankles, then lower back down.'
            ],

            // Shoulders exercises
            [
                'name' => 'Arnold Press',
                'muscle_group' => 'Shoulders',
                'equipment' => 'Dumbbells',
                'instructions' => 'Sit with dumbbells at shoulder height, palms facing you. As you press up, rotate your palms to face forward at the top, then reverse on the way down.'
            ],
            [
                'name' => 'Front Raises',
                'muscle_group' => 'Shoulders',
                'equipment' => 'Dumbbells',
                'instructions' => 'Stand holding dumbbells in front of your thighs. Raise them straight in front of you to shoulder height, then lower back down.'
            ],
            [
                'name' => 'Upright Rows',
                'muscle_group' => 'Shoulders',
                'equipment' => 'Barbell',
                'instructions' => 'Stand holding a barbell in front of your thighs. Pull it up toward your chin, keeping it close to your body, then lower back down.'
            ],
            [
                'name' => 'Reverse Flyes',
                'muscle_group' => 'Shoulders',
                'equipment' => 'Dumbbells',
                'instructions' => 'Bend at the hips with a straight back, holding dumbbells below you. Raise the weights out to the sides, then lower them back down.'
            ],

            // Arms exercises
            [
                'name' => 'Hammer Curls',
                'muscle_group' => 'Arms',
                'equipment' => 'Dumbbells',
                'instructions' => 'Stand with dumbbells at your sides, palms facing in. Curl the weights up toward shoulders while maintaining the neutral grip, then lower back down.'
            ],
            [
                'name' => 'Preacher Curls',
                'muscle_group' => 'Arms',
                'equipment' => 'Barbell',
                'instructions' => 'Sit at a preacher bench with arms extended over the pad. Curl the bar up toward your shoulders, then lower it back down with control.'
            ],
            [
                'name' => 'Cable Pushdowns',
                'muscle_group' => 'Arms',
                'equipment' => 'Cable Machine',
                'instructions' => 'Stand facing a cable machine with a straight bar attached high. Push the bar down by extending your elbows, then return to starting position.'
            ],
            [
                'name' => 'Overhead Tricep Extension',
                'muscle_group' => 'Arms',
                'equipment' => 'Dumbbell',
                'instructions' => 'Hold a dumbbell with both hands above your head. Lower it behind your head by bending your elbows, then extend arms to return to starting position.'
            ],

            // Core exercises
            [
                'name' => 'Crunches',
                'muscle_group' => 'Core',
                'equipment' => 'Bodyweight',
                'instructions' => 'Lie on your back with knees bent, feet flat on the floor. Place hands behind your head, curl your shoulders up off the floor, then lower back down.'
            ],
            [
                'name' => 'Bicycle Crunches',
                'muscle_group' => 'Core',
                'equipment' => 'Bodyweight',
                'instructions' => 'Lie on your back with hands behind your head. Bring opposite elbow and knee together while extending the other leg, alternating sides.'
            ],
            [
                'name' => 'Mountain Climbers',
                'muscle_group' => 'Core',
                'equipment' => 'Bodyweight',
                'instructions' => 'Start in a plank position. Bring one knee toward your chest, then the other, alternating quickly as if running in place.'
            ],
            [
                'name' => 'Ab Rollout',
                'muscle_group' => 'Core',
                'equipment' => 'Ab Wheel',
                'instructions' => 'Kneel on the floor holding an ab wheel in front of you. Roll the wheel forward, extending your body, then use your abs to pull back to starting position.'
            ],

            // Cardio exercises
            [
                'name' => 'Cycling',
                'muscle_group' => 'Cardio',
                'equipment' => 'Stationary Bike',
                'instructions' => 'Adjust the seat height so your knee is slightly bent at the bottom of the pedal stroke. Maintain a steady cadence, adjusting resistance as needed.'
            ],
            [
                'name' => 'Rowing Machine',
                'muscle_group' => 'Cardio',
                'equipment' => 'Rowing Machine',
                'instructions' => 'Sit on the rower with feet secured. Push with legs, lean back slightly, pull the handle to your lower ribs, then reverse the sequence.'
            ],
            [
                'name' => 'Battle Ropes',
                'muscle_group' => 'Cardio',
                'equipment' => 'Battle Ropes',
                'instructions' => 'Stand holding one end of the ropes in each hand. Create waves by alternately raising and lowering your arms, or other variations.'
            ],
            [
                'name' => 'Kettlebell Swings',
                'muscle_group' => 'Cardio',
                'equipment' => 'Kettlebell',
                'instructions' => 'Stand with feet shoulder-width apart, kettlebell between feet. Hinge at hips to grasp the handle, swing it up to chest height using hip drive, then let it swing back.'
            ],
            
            // Additional muscle groups
            
            // Glutes
            [
                'name' => 'Hip Thrust',
                'muscle_group' => 'Glutes',
                'equipment' => 'Barbell',
                'instructions' => 'Sit with your upper back against a bench, barbell across your hips. Drive through your heels to raise hips up, creating a straight line from shoulders to knees.'
            ],
            [
                'name' => 'Glute Bridge',
                'muscle_group' => 'Glutes',
                'equipment' => 'Bodyweight',
                'instructions' => 'Lie on your back with knees bent, feet flat on the floor. Push through your heels to raise hips toward the ceiling, then lower back down.'
            ],
            
            // Calves
            [
                'name' => 'Standing Calf Raises',
                'muscle_group' => 'Calves',
                'equipment' => 'Barbell',
                'instructions' => 'Stand with a barbell across your back, balls of feet on a raised surface. Raise your heels as high as possible, then lower them below the level of the platform.'
            ],
            [
                'name' => 'Seated Calf Raises',
                'muscle_group' => 'Calves',
                'equipment' => 'Machine',
                'instructions' => 'Sit in a calf raise machine with pads on your knees, balls of feet on the platform. Raise your heels as high as possible, then lower back down.'
            ],
            
            // Forearms
            [
                'name' => 'Wrist Curls',
                'muscle_group' => 'Forearms',
                'equipment' => 'Dumbbell',
                'instructions' => 'Sit with forearms resting on knees, palms up, holding a dumbbell. Lower the weight by bending your wrists, then curl it back up.'
            ],
            [
                'name' => 'Reverse Wrist Curls',
                'muscle_group' => 'Forearms',
                'equipment' => 'Dumbbell',
                'instructions' => 'Sit with forearms resting on knees, palms down, holding a dumbbell. Extend your wrists to raise the weight, then lower it back down.'
            ],
            
            // Compound movements
            [
                'name' => 'Clean and Jerk',
                'muscle_group' => 'Full Body',
                'equipment' => 'Barbell',
                'instructions' => 'Lift a barbell from the floor to shoulder height (clean), then press it overhead (jerk). Lower it back to the floor to complete one rep.'
            ],
            [
                'name' => 'Thrusters',
                'muscle_group' => 'Full Body',
                'equipment' => 'Dumbbells',
                'instructions' => 'Hold dumbbells at shoulder height, squat down, as you stand push the weights overhead, then return to starting position.'
            ],
        ];

        // Filter out existing exercises
        $newExercises = array_filter($exercises, function($exercise) use ($existingNames) {
            return !in_array($exercise['name'], $existingNames);
        });

        // Add all new exercises to database
        foreach ($newExercises as $exercise) {
            Exercise::create($exercise);
        }
        
        $this->command->info('Added ' . count($newExercises) . ' new exercises to the database.');
    }
}
