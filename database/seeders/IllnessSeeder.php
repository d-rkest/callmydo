<?php

namespace Database\Seeders;

use App\Models\Illness;
use Illuminate\Database\Seeder;

class IllnessSeeder extends Seeder
{
    public function run(): void
    {
        $illnesses = [
            [
                'name' => 'Malaria',
                'category' => 'west_africa_common_illness',
                'symptoms' => 'High fever, chills, sweating, headache, nausea, muscle pain.',
                'local_remedy' => 'Neem leaves or papaya leaf extract, bitter leaf soup, ginger and lime tea.',
                'otc_medications' => 'Artemisinin Combination Therapy (ACT) (e.g., Coartem, Lonart), Paracetamol for fever relief.',
            ],
            [
                'name' => 'Typhoid Fever',
                'category' => 'west_africa_common_illness',
                'symptoms' => 'Prolonged fever, weakness, stomach pain, diarrhea or constipation.',
                'local_remedy' => 'Unripe pawpaw soaked in water, guava leaf tea, clove and ginger infusion.',
                'otc_medications' => 'Ciprofloxacin or Azithromycin (prescription may be needed), ORS for dehydration.',
            ],
            [
                'name' => 'Cholera',
                'category' => 'west_africa_common_illness',
                'symptoms' => 'Severe diarrhea, dehydration, vomiting, leg cramps.',
                'local_remedy' => 'Salt and sugar oral rehydration solution, coconut water, ginger tea.',
                'otc_medications' => 'ORS sachets, Zinc supplements, Antibiotics (Doxycycline, Azithromycin).',
            ],
            [
                'name' => 'Dengue Fever',
                'category' => 'west_africa_common_illness',
                'symptoms' => 'High fever, joint pain, rash, severe headache.',
                'local_remedy' => 'Papaya leaf juice, coconut water, turmeric tea.',
                'otc_medications' => 'Paracetamol (avoid aspirin and ibuprofen).',
            ],
            [
                'name' => 'Pain Crisis (Sickle Cell)',
                'category' => 'sick_cell_disease',
                'symptoms' => 'Severe body pain, swelling in hands/feet, fatigue.',
                'local_remedy' => 'Warm compress, hydration with water or herbal teas, bitter leaf juice.',
                'otc_medications' => 'Paracetamol, Ibuprofen (under medical supervision).',
            ],
            [
                'name' => 'Anemia (Sickle Cell)',
                'category' => 'sick_cell_disease',
                'symptoms' => 'Fatigue, pale skin, dizziness, shortness of breath.',
                'local_remedy' => 'Ugu (pumpkin) leaf soup, beetroot juice, liver-rich diet.',
                'otc_medications' => 'Folic Acid, Iron supplements (if prescribed).',
            ],
            [
                'name' => 'Leg Ulcers (Sickle Cell)',
                'category' => 'sick_cell_disease',
                'symptoms' => 'Open sores on legs, pain, swelling.',
                'local_remedy' => 'Honey application, aloe vera gel, shea butter.',
                'otc_medications' => 'Antiseptic creams, wound dressings.',
            ],
            [
                'name' => 'Asthma Attack',
                'category' => 'general_illness',
                'symptoms' => 'Shortness of breath, wheezing, chest tightness, coughing.',
                'local_remedy' => 'Ginger and honey tea, steam inhalation, bitter kola.',
                'otc_medications' => 'Salbutamol inhaler (Ventolin), antihistamines.',
            ],
            [
                'name' => 'Hypertension',
                'category' => 'general_illness',
                'symptoms' => 'Dizziness, headaches, nosebleeds, blurred vision.',
                'local_remedy' => 'Hibiscus tea (Zobo), garlic and ginger in warm water, bitter leaf juice.',
                'otc_medications' => 'Amlodipine, Lisinopril (prescription required).',
            ],
            [
                'name' => 'Diabetes',
                'category' => 'general_illness',
                'symptoms' => 'Frequent urination, excessive thirst, unexplained weight loss.',
                'local_remedy' => 'Bitter melon, guava leaf tea, turmeric.',
                'otc_medications' => 'Metformin (prescription needed), Glucose control supplements.',
            ],
            [
                'name' => 'Common Cold',
                'category' => 'general_illness',
                'symptoms' => 'Runny nose, sneezing, sore throat, mild fever, congestion, cough.',
                'local_remedy' => 'Ginger tea with honey and lemon, steam inhalation with eucalyptus or menthol, garlic and turmeric in warm water or soup.',
                'otc_medications' => 'Paracetamol, antihistamines (e.g., Loratadine, Cetirizine), cough syrups (e.g., Benylin, Robitussin).',
            ],
            [
                'name' => 'Diarrhea',
                'category' => 'general_illness',
                'symptoms' => 'Frequent watery stools, stomach cramps, dehydration.',
                'local_remedy' => 'Rice water or coconut water, activated charcoal, ginger and honey tea.',
                'otc_medications' => 'ORS sachets, Loperamide (e.g., Imodium).',
            ],
            [
                'name' => 'Ulcer',
                'category' => 'general_illness',
                'symptoms' => 'Stomach pain, bloating, heartburn, nausea.',
                'local_remedy' => 'Unripe plantain soaked in water, aloe vera juice, carrot juice.',
                'otc_medications' => 'Omeprazole, Lansoprazole, antacids (e.g., Gaviscon, Milk of Magnesia).',
            ],
            [
                'name' => 'Fever',
                'category' => 'general_illness',
                'symptoms' => 'High body temperature, chills, sweating, headache.',
                'local_remedy' => 'Neem leaf tea, bathing with lukewarm water, orange and lemon juice for hydration.',
                'otc_medications' => 'Paracetamol, Ibuprofen.',
            ],
            [
                'name' => 'Constipation',
                'category' => 'general_illness',
                'symptoms' => 'Difficulty passing stool, bloating, stomach pain.',
                'local_remedy' => 'Pawpaw and banana, warm water with lemon, flaxseeds.',
                'otc_medications' => 'Lactulose syrup, Bisacodyl (Dulcolax).',
            ],
            [
                'name' => 'Cough',
                'category' => 'general_illness',
                'symptoms' => 'Persistent coughing, sore throat, chest congestion.',
                'local_remedy' => 'Honey and ginger syrup, steam inhalation with eucalyptus oil, bitter kola.',
                'otc_medications' => 'Cough syrups (e.g., Benylin, Robitussin), Vitamin C supplements.',
            ],
        ];

        foreach ($illnesses as $illness) {
            Illness::updateOrCreate(
                ['name' => $illness['name']],
                $illness
            );
        }
    }
}