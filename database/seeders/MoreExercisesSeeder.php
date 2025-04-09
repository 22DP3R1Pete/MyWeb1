<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Exercise;

class MoreExercisesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure we don't get duplicate exercises
        $existingNames = Exercise::pluck('name')->toArray();
        
        // Array of more specialized exercises to add
        $exercises = [
            // Olympic lifting
            [
                'name' => 'Snatch',
                'muscle_group' => 'Full Body',
                'equipment' => 'Barbell',
                'instructions' => 'With a wide grip, lift the barbell from the floor to overhead in one fluid motion, landing in a squat position, then stand.'
            ],
            [
                'name' => 'Power Clean',
                'muscle_group' => 'Full Body',
                'equipment' => 'Barbell',
                'instructions' => 'Pull a barbell from the floor to your shoulders in one explosive movement, catching it in a quarter squat position, then stand.'
            ],
            
            // Functional training
            [
                'name' => 'Medicine Ball Slams',
                'muscle_group' => 'Full Body',
                'equipment' => 'Medicine Ball',
                'instructions' => 'Hold a medicine ball overhead, then slam it to the ground with maximum force. Catch the ball on the bounce and repeat.'
            ],
            [
                'name' => 'TRX Rows',
                'muscle_group' => 'Back',
                'equipment' => 'TRX Straps',
                'instructions' => 'Grasp TRX handles with arms extended, body at an angle. Pull your body up until hands are beside ribs, then lower back down.'
            ],
            [
                'name' => 'Box Jumps',
                'muscle_group' => 'Legs',
                'equipment' => 'Plyometric Box',
                'instructions' => 'Stand in front of a sturdy box. Bend knees slightly, then jump up onto the box, landing softly. Step back down and repeat.'
            ],
            
            // Yoga/Flexibility
            [
                'name' => 'Downward Dog',
                'muscle_group' => 'Full Body',
                'equipment' => 'Bodyweight',
                'instructions' => 'Start on hands and knees, lift hips up and back to form an inverted V shape. Press heels toward the floor and relax your head.'
            ],
            [
                'name' => 'Warrior Pose',
                'muscle_group' => 'Legs',
                'equipment' => 'Bodyweight',
                'instructions' => 'Stand with feet wide apart, turn one foot out 90 degrees. Bend the knee of the turned-out leg while extending arms and looking over your front hand.'
            ],
            
            // Calisthenics
            [
                'name' => 'Muscle-Up',
                'muscle_group' => 'Upper Body',
                'equipment' => 'Pull-up Bar',
                'instructions' => 'Perform a high pull-up, then transition to a dip position above the bar by rotating your wrists. Finish by extending your arms.'
            ],
            [
                'name' => 'Pistol Squat',
                'muscle_group' => 'Legs',
                'equipment' => 'Bodyweight',
                'instructions' => 'Balance on one leg, extend the other leg forward. Lower your body until your thigh is parallel to the ground, then return to standing.'
            ],
            [
                'name' => 'Human Flag',
                'muscle_group' => 'Core',
                'equipment' => 'Vertical Bar',
                'instructions' => 'Grip a vertical pole with both hands, one high and one low. Using core and shoulder strength, lift your body horizontally.'
            ],
            
            // Sport-specific
            [
                'name' => 'Agility Ladder Drills',
                'muscle_group' => 'Cardio',
                'equipment' => 'Agility Ladder',
                'instructions' => 'Place an agility ladder on the ground. Step through the ladder using various footwork patterns such as high knees, lateral steps, or in-out steps.'
            ],
            [
                'name' => 'Speed Skater Jumps',
                'muscle_group' => 'Legs',
                'equipment' => 'Bodyweight',
                'instructions' => 'Jump laterally from one foot to the other, mimicking a speed skater. Swing arms across your body for momentum and balance.'
            ],
            
            // Equipment-specific
            [
                'name' => 'Landmine Press',
                'muscle_group' => 'Shoulders',
                'equipment' => 'Landmine',
                'instructions' => 'Place one end of a barbell in a landmine attachment, grip the other end. Press the weight up and away from your body, then lower it back down.'
            ],
            [
                'name' => 'TRX Pike',
                'muscle_group' => 'Core',
                'equipment' => 'TRX Straps',
                'instructions' => 'Place feet in TRX straps, get into a push-up position. Pike your hips up toward the ceiling, then return to the starting position.'
            ],
            
            // Specialized hypertrophy
            [
                'name' => 'Guillotine Press',
                'muscle_group' => 'Chest',
                'equipment' => 'Barbell',
                'instructions' => 'Lie on a bench, grip the barbell wider than shoulder-width. Lower the bar to your neck area rather than chest, then press back up.'
            ],
            [
                'name' => 'Meadows Row',
                'muscle_group' => 'Back',
                'equipment' => 'Barbell',
                'instructions' => 'Place one end of a barbell in a corner, stand perpendicular to it holding the other end. Perform a one-arm row with your elbow close to your body.'
            ],
            [
                'name' => '21s Bicep Curls',
                'muscle_group' => 'Arms',
                'equipment' => 'Barbell',
                'instructions' => 'Perform 7 half curls from bottom to middle position, 7 half curls from middle to top position, then 7 full curls for a total of 21 reps.'
            ],
            
            // Rehabilitation/Prehabilitation
            [
                'name' => 'Rotator Cuff External Rotation',
                'muscle_group' => 'Shoulders',
                'equipment' => 'Resistance Band',
                'instructions' => 'Secure a resistance band and hold with elbow bent at 90 degrees, arm against your side. Rotate your forearm outward, then return to starting position.'
            ],
            [
                'name' => 'Banded Face Pull',
                'muscle_group' => 'Shoulders',
                'equipment' => 'Resistance Band',
                'instructions' => 'Attach a band at face height, hold with arms extended. Pull the band toward your face with elbows high, squeezing shoulder blades together.'
            ],
            
            // Stability/Balance
            [
                'name' => 'Single-Leg RDL',
                'muscle_group' => 'Legs',
                'equipment' => 'Dumbbell',
                'instructions' => 'Stand on one leg holding a dumbbell in the opposite hand. Hinge at the hip, extending free leg behind you while lowering the weight, then return to standing.'
            ],
            [
                'name' => 'Bosu Ball Squat',
                'muscle_group' => 'Legs',
                'equipment' => 'Bosu Ball',
                'instructions' => 'Stand on the flat side of a Bosu ball with feet shoulder-width apart. Perform a squat while maintaining balance, then return to standing.'
            ],
            
            // Strongman
            [
                'name' => 'Farmer\'s Walk',
                'muscle_group' => 'Full Body',
                'equipment' => 'Dumbbells',
                'instructions' => 'Hold heavy dumbbells or specialized handles at your sides. Walk for distance or time while maintaining good posture.'
            ],
            [
                'name' => 'Tire Flip',
                'muscle_group' => 'Full Body',
                'equipment' => 'Tractor Tire',
                'instructions' => 'Squat behind a large tire, grip underneath it. Explosively stand up, flipping the tire over, then repeat on the opposite side.'
            ],
            
            // CrossFit-style
            [
                'name' => 'Wall Ball Shots',
                'muscle_group' => 'Full Body',
                'equipment' => 'Medicine Ball',
                'instructions' => 'Hold a medicine ball at chest level, facing a wall. Squat down, then explode up and throw the ball to a target on the wall. Catch it and repeat.'
            ],
            [
                'name' => 'Double Unders',
                'muscle_group' => 'Cardio',
                'equipment' => 'Jump Rope',
                'instructions' => 'Jump with a rope, making it pass under your feet twice during each jump. Requires rhythm and coordination.'
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
        
        $this->command->info('Added ' . count($newExercises) . ' specialized exercises to the database.');
    }
}
