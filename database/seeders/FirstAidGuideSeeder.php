<?php

namespace Database\Seeders;

use App\Models\FirstAidGuide;
use Illuminate\Database\Seeder;

class FirstAidGuideSeeder extends Seeder
{
    public function run(): void
    {
        $guides = [
            [
                'name' => 'Cardiopulmonary Resuscitation (CPR) for Adults',
                'category' => 'Cardiovascular',
                'steps' => "1. Ensure the scene is safe.\n2. Check responsiveness by tapping and shouting.\n3. Call emergency services if unresponsive.\n4. Tilt head back to open airway.\n5. Check breathing for 10 seconds.\n6. Perform chest compressions (2 inches deep, 100-120/min).\n7. Give 2 rescue breaths after 30 compressions.\n8. Continue until help arrives or victim breathes.",
                'video_url' => 'https://www.youtube.com/watch?v=cosVBV96E2g',
            ],
            [
                'name' => 'Choking (Adult or Child)',
                'category' => 'Respiratory',
                'steps' => "1. Ask if the person is choking.\n2. Encourage coughing if possible.\n3. Perform Heimlich: Stand behind, wrap arms around waist, thrust upward above navel.\n4. Repeat until object is expelled.\n5. If unresponsive, lower to ground and start CPR.",
                'video_url' => 'https://www.youtube.com/watch?v=PA9hpOnvtCk',
            ],
            [
                'name' => 'Severe Bleeding',
                'category' => 'Injury',
                'steps' => "1. Wear gloves if available.\n2. Expose wound by removing clothing.\n3. Apply firm pressure with clean cloth.\n4. Maintain pressure until bleeding stops.\n5. Secure dressing with bandage.\n6. Call emergency services.",
                'video_url' => 'https://www.youtube.com/watch?v=s258qSXP6jU',
            ],
            [
                'name' => 'Burns (Minor and Major)',
                'category' => 'Injury',
                'steps' => "Minor Burns:\n1. Cool with water for 10 minutes.\n2. Cover with sterile dressing.\n3. Use pain relievers if needed.\nMajor Burns:\n1. Call emergency services.\n2. Cover with cool, moist dressing.\n3. Prevent shock: Elevate feet, cover with blanket.",
                'video_url' => 'https://www.youtube.com/watch?v=coQh4F0rQCs',
            ],
            [
                'name' => 'Fractures (Broken Bones)',
                'category' => 'Injury',
                'steps' => "1. Keep injury still.\n2. Apply splint if trained.\n3. Use ice packs for swelling.\n4. Seek medical help.",
                'video_url' => 'https://www.youtube.com/watch?v=Eq1kY3GY8e2I',
            ],
            [
                'name' => 'Sprains and Strains',
                'category' => 'Injury',
                'steps' => "1. Rest the injured area.\n2. Apply ice for 15-20 minutes.\n3. Compress with elastic bandage.\n4. Elevate above heart level.",
                'video_url' => 'https://www.youtube.com/watch?v=cdT1eY_fVtM',
            ],
            [
                'name' => 'Nosebleeds',
                'category' => 'Injury',
                'steps' => "1. Sit upright, lean forward.\n2. Pinch nostrils below nasal bridge.\n3. Hold for 10 minutes.\n4. Apply cold compress to nose.\n5. Seek help if bleeding persists.",
                'video_url' => 'https://www.youtube.com/watch?v=sM6C7lgVUOc',
            ],
            [
                'name' => 'Assisting Accident Victims',
                'category' => 'Emergency',
                'steps' => "1. Ensure scene safety.\n2. Call emergency services.\n3. Check responsiveness.\n4. Assess breathing.\n5. Perform CPR if needed.\n6. Control bleeding.\n7. Immobilize fractures.",
                'video_url' => 'https://www.youtube.com/watch?v=TuTgFgfB81k',
            ],
            [
                'name' => 'Bone Injuries (Dislocations)',
                'category' => 'Injury',
                'steps' => "1. Immobilize injury.\n2. Apply splint if trained.\n3. Use cold packs.\n4. Elevate if possible.\n5. Seek medical help.",
                'video_url' => 'https://www.youtube.com/watch?v=B_qCU5gP5cc',
            ],
            [
                'name' => 'Fainting',
                'category' => 'Neurological',
                'steps' => "1. Lay person down.\n2. Loosen tight clothing.\n3. Ensure fresh air.\n4. Monitor responsiveness.\n5. Use recovery position.",
                'video_url' => 'https://www.youtube.com/watch?v=bwxD-2HOipQ',
            ],
            [
                'name' => 'Heart Attack',
                'category' => 'Cardiovascular',
                'steps' => "1. Call emergency services.\n2. Keep person calm.\n3. Loosen clothing.\n4. Give aspirin if no allergy.\n5. Monitor breathing, prepare for CPR.",
                'video_url' => 'https://www.youtube.com/watch?v=y_CuEz2zMaE',
            ],
            [
                'name' => 'Stroke',
                'category' => 'Neurological',
                'steps' => "1. Use FAST: Face drooping, Arm weakness, Speech difficulty, Time to call.\n2. Lay person down, head elevated.\n3. Avoid food/drink.\n4. Monitor and reassure.",
                'video_url' => 'https://www.youtube.com/watch?v=3rNxEC4b-Pc',
            ],
            [
                'name' => 'Electric Shock',
                'category' => 'Injury',
                'steps' => "1. Turn off power source.\n2. Avoid direct contact.\n3. Call emergency help.\n4. Perform CPR if needed.\n5. Treat burns.",
                'video_url' => 'https://www.youtube.com/watch?v=ifF7fRYT_Pc',
            ],
            [
                'name' => 'Drowning',
                'category' => 'Emergency',
                'steps' => "1. Call emergency services.\n2. Remove from water.\n3. Check breathing.\n4. Perform CPR if needed.\n5. Keep warm.",
                'video_url' => 'https://www.youtube.com/watch?v=sJXiNFGf9SI',
            ],
            [
                'name' => 'Seizures',
                'category' => 'Neurological',
                'steps' => "1. Protect from injury.\n2. Avoid restraining.\n3. Turn on side.\n4. Avoid mouth objects.\n5. Call if seizure lasts over 5 minutes.",
                'video_url' => 'https://www.youtube.com/watch?v=3DfoI4ikdP4',
            ],
            [
                'name' => 'Food Poisoning',
                'category' => 'Gastrointestinal',
                'steps' => "1. Keep hydrated.\n2. Avoid solid foods.\n3. Rest and monitor.\n4. Seek help for severe dehydration.",
                'video_url' => 'https://www.youtube.com/watch?v=e2Ce_Cu9OHg',
            ],
            [
                'name' => 'Burns (Chemical or Electrical)',
                'category' => 'Injury',
                'steps' => "Chemical Burns:\n1. Rinse with water.\n2. Remove contaminated clothing.\n3. Avoid ointments.\n4. Seek help.\nElectrical Burns:\n1. Ensure power off.\n2. Treat as major burn.\n3. Monitor shock.",
                'video_url' => 'https://www.youtube.com/watch?v=coQh4F0rQCs',
            ],
            [
                'name' => 'Choking (Infants and Adults)',
                'category' => 'Respiratory',
                'steps' => "Adults:\n1. Encourage coughing.\n2. Perform Heimlich.\n3. Repeat until clear.\nInfants:\n1. Lay face down.\n2. Give 5 back blows.\n3. Give 5 chest thrusts.",
                'video_url' => 'https://www.youtube.com/watch?v=PA9hpOnvtCk',
            ],
            [
                'name' => 'Hypothermia (Cold Exposure)',
                'category' => 'Environmental',
                'steps' => "1. Move to warm place.\n2. Remove wet clothing.\n3. Warm gradually.\n4. Give warm liquids if conscious.\n5. Seek help.",
                'video_url' => 'https://www.youtube.com/watch?v=zN_ycG_6EPg',
            ],
            [
                'name' => 'Heatstroke',
                'category' => 'Environmental',
                'steps' => "1. Move to cool area.\n2. Remove excess clothing.\n3. Apply cool cloths/ice.\n4. Give water if conscious.\n5. Seek help.",
                'video_url' => 'https://www.youtube.com/watch?v=bpNSjLjWQfE',
            ],
            [
                'name' => 'Animal Bites (Dogs, Snakes, Insects)',
                'category' => 'Injury',
                'steps' => "Dog Bites:\n1. Wash wound.\n2. Apply antiseptic.\n3. Seek rabies vaccine.\nSnake Bites:\n1. Keep still.\n2. Keep bite below heart.\n3. Avoid sucking/cutting.\n4. Seek help.",
                'video_url' => 'https://www.youtube.com/watch?v=sKq7PzGDDHE',
            ],
        ];

        foreach ($guides as $guide) {
            FirstAidGuide::updateOrCreate(
                ['name' => $guide['name']],
                $guide
            );
        }
    }
}