<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Exercise;

class ExerciseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Chest exercises
        Exercise::create([
            'name' => 'Bench Press',
            'muscle_group' => 'Chest',
            'equipment_needed' => 'Barbell',
            'difficulty_level' => 'Intermediate',
            'instructions' => json_encode([
                'Lie on a flat bench, grip the barbell with hands slightly wider than shoulder-width apart.',
                'Lower the bar to your chest with control.',
                'Press back up to starting position extending your arms fully.',
                'Keep your feet flat on the ground and maintain a slight arch in your lower back.',
            ])
        ]);

        Exercise::create([
            'name' => 'Incline Dumbbell Press',
            'muscle_group' => 'Chest',
            'equipment_needed' => 'Dumbbells',
            'difficulty_level' => 'Intermediate',
            'instructions' => json_encode([
                'Lie on an incline bench set to 30-45 degrees, holding dumbbells at shoulder width.',
                'Press the weights up until your arms are extended.',
                'Lower the dumbbells back down to the sides of your chest.',
                'Keep your feet flat and avoid excessive arching of the back.',
            ])
        ]);

        Exercise::create([
            'name' => 'Push-ups',
            'muscle_group' => 'Chest',
            'equipment_needed' => 'Bodyweight',
            'difficulty_level' => 'Beginner',
            'instructions' => json_encode([
                'Start in a plank position with hands placed slightly wider than shoulders.',
                'Keep your body in a straight line from head to heels.',
                'Lower your body until your chest nearly touches the floor.',
                'Push back up to the starting position extending your arms fully.',
            ])
        ]);

        // Back exercises
        Exercise::create([
            'name' => 'Pull-ups',
            'muscle_group' => 'Back',
            'equipment_needed' => 'Pull-up Bar',
            'difficulty_level' => 'Intermediate',
            'instructions' => json_encode([
                'Hang from a pull-up bar with hands slightly wider than shoulder-width apart.',
                'Pull your body up until your chin clears the bar.',
                'Lower back down with control until arms are fully extended.',
                'Avoid swinging or using momentum.',
            ])
        ]);

        Exercise::create([
            'name' => 'Bent-over Barbell Rows',
            'muscle_group' => 'Back',
            'equipment_needed' => 'Barbell',
            'difficulty_level' => 'Intermediate',
            'instructions' => json_encode([
                'Bend at the waist with knees slightly bent, holding a barbell with hands shoulder-width apart.',
                'Keep your back straight and core engaged.',
                'Pull the barbell towards your lower chest or upper abdomen.',
                'Lower the weight back down with control.',
            ])
        ]);

        Exercise::create([
            'name' => 'Lat Pulldown',
            'muscle_group' => 'Back',
            'equipment_needed' => 'Cable Machine',
            'difficulty_level' => 'Beginner',
            'instructions' => json_encode([
                'Sit at a lat pulldown station, grip the bar with hands wider than shoulder-width.',
                'Keep your chest up and back slightly arched.',
                'Pull the bar down to your upper chest.',
                'Control the return to starting position, fully extending your arms.',
            ])
        ]);

        // Legs exercises
        Exercise::create([
            'name' => 'Squats',
            'muscle_group' => 'Legs',
            'equipment_needed' => 'Barbell',
            'difficulty_level' => 'Intermediate',
            'instructions' => json_encode([
                'Stand with feet shoulder-width apart, barbell across upper back.',
                'Bend knees and hips to lower your body, keeping your back straight.',
                'Lower until thighs are parallel to floor or as deep as flexibility allows.',
                'Push through your heels to return to standing position.',
            ])
        ]);

        Exercise::create([
            'name' => 'Lunges',
            'muscle_group' => 'Legs',
            'equipment_needed' => 'Dumbbells',
            'difficulty_level' => 'Intermediate',
            'instructions' => json_encode([
                'Stand with feet hip-width apart, holding dumbbells at sides.',
                'Step forward with one leg, lowering your body until both knees are bent at 90 degrees.',
                'Keep your front knee above your ankle, not pushed forward.',
                'Push back to starting position and repeat with the other leg.',
            ])
        ]);

        Exercise::create([
            'name' => 'Leg Press',
            'muscle_group' => 'Legs',
            'equipment_needed' => 'Machine',
            'difficulty_level' => 'Beginner',
            'instructions' => json_encode([
                'Sit in a leg press machine with feet shoulder-width apart on the platform.',
                'Release the safety locks and lower the platform by bending your knees.',
                'Push the platform away by extending your knees, without locking them.',
                'Slowly bring the platform back to the starting position.',
            ])
        ]);

        // Shoulders exercises
        Exercise::create([
            'name' => 'Overhead Press',
            'muscle_group' => 'Shoulders',
            'equipment_needed' => 'Barbell',
            'difficulty_level' => 'Intermediate',
            'instructions' => json_encode([
                'Stand with feet shoulder-width apart, holding a barbell at shoulder height.',
                'Engage your core and keep your back straight.',
                'Press the bar overhead until arms are fully extended.',
                'Lower the bar back to shoulder level with control.',
            ])
        ]);

        Exercise::create([
            'name' => 'Lateral Raises',
            'muscle_group' => 'Shoulders',
            'equipment_needed' => 'Dumbbells',
            'difficulty_level' => 'Beginner',
            'instructions' => json_encode([
                'Stand with feet shoulder-width apart, holding dumbbells at your sides.',
                'Keep a slight bend in your elbows throughout the movement.',
                'Raise arms out to the sides until they\'re parallel to the floor.',
                'Lower the weights back down with control.',
            ])
        ]);

        Exercise::create([
            'name' => 'Face Pulls',
            'muscle_group' => 'Shoulders',
            'equipment_needed' => 'Cable Machine',
            'difficulty_level' => 'Intermediate',
            'instructions' => json_encode([
                'Stand facing a cable machine with rope attachment at face height.',
                'Grab the rope with both hands, palms facing each other.',
                'Pull the rope toward your face, separating the ends as you pull.',
                'Squeeze your shoulder blades together at the end of the movement before returning to starting position.',
            ])
        ]);

        // Arms exercises
        Exercise::create([
            'name' => 'Bicep Curls',
            'muscle_group' => 'Arms',
            'equipment_needed' => 'Dumbbells',
            'difficulty_level' => 'Beginner',
            'instructions' => json_encode([
                'Stand with feet shoulder-width apart, holding dumbbells at your sides.',
                'Keep your elbows close to your torso and palms facing forward.',
                'Curl the weights up toward your shoulders while keeping upper arms stationary.',
                'Lower back down with control to starting position.',
            ])
        ]);

        Exercise::create([
            'name' => 'Tricep Dips',
            'muscle_group' => 'Arms',
            'equipment_needed' => 'Bodyweight',
            'difficulty_level' => 'Intermediate',
            'instructions' => json_encode([
                'Position hands on a bench or chair behind you, fingers pointing forward.',
                'Extend your legs in front of you and lift your hips off the ground.',
                'Lower your body by bending your elbows to about 90 degrees.',
                'Push back up to the starting position by extending your arms.',
            ])
        ]);

        Exercise::create([
            'name' => 'Skull Crushers',
            'muscle_group' => 'Arms',
            'equipment_needed' => 'EZ Bar',
            'difficulty_level' => 'Intermediate',
            'instructions' => json_encode([
                'Lie on a bench holding an EZ bar with hands shoulder-width apart.',
                'Begin with the bar held above your chest with arms extended.',
                'Bend elbows to lower the bar toward your forehead, keeping upper arms stationary.',
                'Extend arms to return to starting position.',
            ])
        ]);

        // Core exercises
        Exercise::create([
            'name' => 'Plank',
            'muscle_group' => 'Core',
            'equipment_needed' => 'Bodyweight',
            'difficulty_level' => 'Beginner',
            'instructions' => json_encode([
                'Start in a push-up position, but with forearms on the ground.',
                'Keep your body in a straight line from head to heels.',
                'Engage your core and glutes to maintain the position.',
                'Hold the position for the prescribed time, breathing normally.',
            ])
        ]);

        Exercise::create([
            'name' => 'Russian Twists',
            'muscle_group' => 'Core',
            'equipment_needed' => 'Medicine Ball',
            'difficulty_level' => 'Intermediate',
            'instructions' => json_encode([
                'Sit on the floor with knees bent, feet elevated slightly.',
                'Lean back slightly to engage your core, keeping your back straight.',
                'Hold a medicine ball with both hands in front of your chest.',
                'Twist your torso to touch the ball to the ground on each side, alternating left and right.',
            ])
        ]);

        Exercise::create([
            'name' => 'Hanging Leg Raises',
            'muscle_group' => 'Core',
            'equipment_needed' => 'Pull-up Bar',
            'difficulty_level' => 'Advanced',
            'instructions' => json_encode([
                'Hang from a pull-up bar with hands shoulder-width apart.',
                'Keep your shoulders engaged and body stabilized.',
                'Raise your legs until they\'re parallel to the floor (or higher if possible).',
                'Lower back down with control, avoiding swinging.',
            ])
        ]);

        // Cardio exercises
        Exercise::create([
            'name' => 'Treadmill Running',
            'muscle_group' => 'Cardio',
            'equipment_needed' => 'Treadmill',
            'difficulty_level' => 'Beginner',
            'instructions' => json_encode([
                'Start with a warm-up walk for 3-5 minutes.',
                'Increase speed to a comfortable running pace.',
                'Maintain good posture with shoulders back and core engaged.',
                'Cool down with a slower pace for 3-5 minutes at the end.',
            ])
        ]);

        Exercise::create([
            'name' => 'Jump Rope',
            'muscle_group' => 'Cardio',
            'equipment_needed' => 'Jump Rope',
            'difficulty_level' => 'Beginner',
            'instructions' => json_encode([
                'Hold the rope with handles in each hand, elbows close to your sides.',
                'Swing the rope over your head and jump as it passes under your feet.',
                'Use your wrists (not arms) to swing the rope, keeping movements small.',
                'Maintain a steady rhythm and stay on the balls of your feet.',
            ])
        ]);

        Exercise::create([
            'name' => 'Burpees',
            'muscle_group' => 'Cardio',
            'equipment_needed' => 'Bodyweight',
            'difficulty_level' => 'Intermediate',
            'instructions' => json_encode([
                'Start standing with feet shoulder-width apart.',
                'Drop into a squat position and place hands on the floor.',
                'Kick feet back into a plank position, perform a push-up if desired.',
                'Jump feet back to squat position, then explosively jump up with arms overhead.',
            ])
        ]);
    }
}
