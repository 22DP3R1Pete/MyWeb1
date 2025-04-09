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
            'equipment' => 'Barbell',
            'instructions' => 'Lie on a flat bench, grip the barbell with hands slightly wider than shoulder-width apart. Lower the bar to your chest, then press back up to starting position.'
        ]);

        Exercise::create([
            'name' => 'Incline Dumbbell Press',
            'muscle_group' => 'Chest',
            'equipment' => 'Dumbbells',
            'instructions' => 'Lie on an incline bench set to 30-45 degrees, holding dumbbells at shoulder width. Press the weights up until your arms are extended, then lower back down.'
        ]);

        Exercise::create([
            'name' => 'Push-ups',
            'muscle_group' => 'Chest',
            'equipment' => 'Bodyweight',
            'instructions' => 'Start in a plank position with hands placed slightly wider than shoulders. Lower your body until your chest nearly touches the floor, then push back up.'
        ]);

        // Back exercises
        Exercise::create([
            'name' => 'Pull-ups',
            'muscle_group' => 'Back',
            'equipment' => 'Pull-up Bar',
            'instructions' => 'Hang from a pull-up bar with hands slightly wider than shoulder-width apart. Pull your body up until your chin clears the bar, then lower back down with control.'
        ]);

        Exercise::create([
            'name' => 'Bent-over Barbell Rows',
            'muscle_group' => 'Back',
            'equipment' => 'Barbell',
            'instructions' => 'Bend at the waist with knees slightly bent, holding a barbell with hands shoulder-width apart. Pull the barbell towards your lower chest, then lower back down.'
        ]);

        Exercise::create([
            'name' => 'Lat Pulldown',
            'muscle_group' => 'Back',
            'equipment' => 'Cable Machine',
            'instructions' => 'Sit at a lat pulldown station, grip the bar with hands wider than shoulder-width. Pull the bar down to your upper chest, then control the return to starting position.'
        ]);

        // Legs exercises
        Exercise::create([
            'name' => 'Squats',
            'muscle_group' => 'Legs',
            'equipment' => 'Barbell',
            'instructions' => 'Stand with feet shoulder-width apart, barbell across upper back. Bend knees and hips to lower your body, keeping your back straight, then return to standing.'
        ]);

        Exercise::create([
            'name' => 'Lunges',
            'muscle_group' => 'Legs',
            'equipment' => 'Dumbbells',
            'instructions' => 'Stand with feet hip-width apart, holding dumbbells at sides. Step forward with one leg, lowering your body until both knees are bent at 90 degrees, then push back to starting position.'
        ]);

        Exercise::create([
            'name' => 'Leg Press',
            'muscle_group' => 'Legs',
            'equipment' => 'Machine',
            'instructions' => 'Sit in a leg press machine with feet shoulder-width apart on the platform. Push the platform away by extending your knees, then slowly bring it back.'
        ]);

        // Shoulders exercises
        Exercise::create([
            'name' => 'Overhead Press',
            'muscle_group' => 'Shoulders',
            'equipment' => 'Barbell',
            'instructions' => 'Stand with feet shoulder-width apart, holding a barbell at shoulder height. Press the bar overhead until arms are fully extended, then lower back to shoulders.'
        ]);

        Exercise::create([
            'name' => 'Lateral Raises',
            'muscle_group' => 'Shoulders',
            'equipment' => 'Dumbbells',
            'instructions' => 'Stand with feet shoulder-width apart, holding dumbbells at your sides. Raise arms out to the sides until they're parallel to the floor, then lower back down.'
        ]);

        Exercise::create([
            'name' => 'Face Pulls',
            'muscle_group' => 'Shoulders',
            'equipment' => 'Cable Machine',
            'instructions' => 'Stand facing a cable machine with rope attachment at face height. Pull the rope toward your face, separating the ends as you pull, then return to starting position.'
        ]);

        // Arms exercises
        Exercise::create([
            'name' => 'Bicep Curls',
            'muscle_group' => 'Arms',
            'equipment' => 'Dumbbells',
            'instructions' => 'Stand with feet shoulder-width apart, holding dumbbells at your sides. Curl the weights up toward your shoulders, then lower back down with control.'
        ]);

        Exercise::create([
            'name' => 'Tricep Dips',
            'muscle_group' => 'Arms',
            'equipment' => 'Bodyweight',
            'instructions' => 'Position hands on a bench or chair behind you, legs extended. Lower your body by bending your elbows, then push back up to the starting position.'
        ]);

        Exercise::create([
            'name' => 'Skull Crushers',
            'muscle_group' => 'Arms',
            'equipment' => 'EZ Bar',
            'instructions' => 'Lie on a bench holding an EZ bar above your chest. Bend elbows to lower the bar toward your forehead, then extend arms to return to starting position.'
        ]);

        // Core exercises
        Exercise::create([
            'name' => 'Plank',
            'muscle_group' => 'Core',
            'equipment' => 'Bodyweight',
            'instructions' => 'Start in a push-up position, but with forearms on the ground. Keep your body in a straight line from head to heels, engaging your core muscles.'
        ]);

        Exercise::create([
            'name' => 'Russian Twists',
            'muscle_group' => 'Core',
            'equipment' => 'Medicine Ball',
            'instructions' => 'Sit on the floor with knees bent, feet elevated slightly. Hold a medicine ball with both hands, twist your torso to touch the ball to the ground on each side.'
        ]);

        Exercise::create([
            'name' => 'Hanging Leg Raises',
            'muscle_group' => 'Core',
            'equipment' => 'Pull-up Bar',
            'instructions' => 'Hang from a pull-up bar with hands shoulder-width apart. Raise your legs until they're parallel to the floor (or higher if possible), then lower back down with control.'
        ]);

        // Cardio exercises
        Exercise::create([
            'name' => 'Treadmill Running',
            'muscle_group' => 'Cardio',
            'equipment' => 'Treadmill',
            'instructions' => 'Start with a warm-up walk, then increase speed to a run. Maintain good posture with shoulders back and core engaged.'
        ]);

        Exercise::create([
            'name' => 'Jump Rope',
            'muscle_group' => 'Cardio',
            'equipment' => 'Jump Rope',
            'instructions' => 'Hold the rope with handles in each hand, swing it over your head and jump as it passes under your feet. Maintain a steady rhythm.'
        ]);

        Exercise::create([
            'name' => 'Burpees',
            'muscle_group' => 'Cardio',
            'equipment' => 'Bodyweight',
            'instructions' => 'Start standing, drop into a squat position and place hands on the floor. Kick feet back into a plank, perform a push-up, jump feet back to squat, then explosively jump up.'
        ]);
    }
}
