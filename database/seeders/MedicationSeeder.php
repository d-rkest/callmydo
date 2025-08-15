<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Medication;

class MedicationSeeder extends Seeder
{
    public function run()
    {
        $medications = [
            ['Paracetamol', 'Pain relief, fever reduction', 'Mild', '10-15 mg/kg every 6 hrs', '500-1000 mg every 6 hrs', 'Liver damage (high doses), nausea', 'Liver disease, alcoholism', 'Below 25°C, dry place', 'Avoid alcohol', 'paracetamol.jpg'],
            ['Ibuprofen', 'Pain relief, anti-inflammatory', 'Moderate', '5-10 mg/kg every 6-8 hrs', '200-400 mg every 6-8 hrs', 'Stomach upset, kidney issues', 'Ulcers, kidney disease', 'Below 30°C, dry place', 'Take with food to prevent stomach issues', 'ibuprofen.jpg'],
            ['Amoxicillin', 'Bacterial infections', 'High', '20-40 mg/kg per day in divided doses', '500 mg every 8 hrs', 'Diarrhea, nausea, rash', 'Penicillin allergy', 'Below 25°C, dry place', 'Complete full course', 'amoxicillin.jpg'],
            ['Metformin', 'Type 2 Diabetes management', 'Moderate', 'Not recommended', '500 mg twice daily', 'Hypoglycemia, stomach upset', 'Severe kidney disease', 'Room temperature', 'Monitor blood sugar', 'metformin.jpg'],
            ['Loratadine', 'Allergy relief', 'Mild', '5 mg once daily', '10 mg once daily', 'Drowsiness, dry mouth', 'Pregnancy, liver disease', 'Below 25°C, dry place', 'May cause drowsiness', 'loratadine.jpg'],
            ['Ciprofloxacin', 'Bacterial infections', 'High', '10-20 mg/kg per day in 2 doses', '500-750 mg twice daily', 'Tendonitis, nausea, dizziness', 'Pregnancy, myasthenia gravis', 'Below 30°C, dry place', 'Avoid dairy products', 'ciprofloxacin.jpg'],
            ['Amlodipine', 'Hypertension', 'Moderate', 'Not recommended', '5-10 mg once daily', 'Swelling, dizziness', 'Pregnancy, severe liver disease', 'Below 25°C, dry place', 'Monitor blood pressure', 'amlodipine.jpg'],
            ['Omeprazole', 'Acid reflux, ulcers', 'Moderate', 'Not recommended', '20-40 mg once daily', 'Stomach pain, headache', 'Severe liver disease', 'Below 30°C, dry place', 'Do not crush or chew', 'omeprazole.jpg'],
            ['Salbutamol', 'Asthma relief', 'High', '2 mg/kg per dose', '2-4 mg every 4-6 hrs', 'Tremors, palpitations', 'Heart disease', 'Room temperature', 'Use only when needed', 'salbutamol.jpg'],
            ['Diclofenac', 'Pain relief, inflammation', 'Moderate', '1 mg/kg every 8 hrs', '50 mg every 8 hrs', 'Stomach pain, dizziness', 'Ulcers, kidney disease', 'Below 25°C, dry place', 'Use lowest effective dose', 'diclofenac.jpg'],
            ['Acetaminophen', 'Pain relief, fever reduction', 'Mild', '10-15 mg/kg every 6 hrs', '500-1000 mg every 6 hrs', 'Liver toxicity (high doses)', 'Liver disease, alcoholism', 'Below 25°C, dry place', 'Avoid overdose', 'acetaminophen.jpg'],
            ['Prednisolone', 'Inflammation, allergies', 'High', '1 mg/kg every 12 hrs', '5-60 mg daily', 'Weight gain, mood swings', 'Diabetes, immune suppression', 'Below 30°C, dry place', 'Take with food', 'prednisolone.jpg'],
            ['Azithromycin', 'Bacterial infections', 'High', '10 mg/kg once daily', '500 mg once daily', 'Nausea, diarrhea', 'Liver disease', 'Below 25°C, dry place', 'Complete full course', 'azithromycin.jpg'],
            ['Cetrizine', 'Allergy relief', 'Mild', '5 mg once daily', '10 mg once daily', 'Drowsiness', 'Pregnancy, liver disease', 'Below 30°C, dry place', 'May cause drowsiness', 'cetrizine.jpg'],
            ['Doxycycline', 'Bacterial infections, acne', 'Moderate', '2 mg/kg per dose', '100 mg once daily', 'Skin sensitivity, nausea', 'Pregnancy, severe kidney disease', 'Room temperature', 'Avoid prolonged sun exposure', 'doxycycline.jpg'],
            ['Hydrochlorothiazide', 'Blood pressure control, diuretic', 'Moderate', 'Not recommended', '25 mg once daily', 'Frequent urination', 'Severe kidney disease', 'Below 25°C, dry place', 'Monitor blood pressure', 'hydrochlorothiazide.jpg'],
            ['Metoprolol', 'Heart disease, blood pressure', 'Moderate', 'Not recommended', '50-100 mg once daily', 'Dizziness, fatigue', 'Severe asthma, diabetes', 'Below 30°C, dry place', 'Do not stop suddenly', 'metoprolol.jpg'],
            ['Fluconazole', 'Fungal infections', 'High', 'Not recommended', '150 mg once daily', 'Liver damage (high doses)', 'Liver disease, pregnancy', 'Room temperature', 'Avoid alcohol', 'fluconazole.jpg'],
            ['Vitamin C', 'Immune support', 'Mild', '50-100 mg daily', '500 mg daily', 'Mild nausea', 'None', 'Room temperature', 'Boosts immunity', 'vitamin_c.jpg'],
            ['Erythromycin', 'Bacterial infections', 'Moderate', '10 mg/kg per dose', '250 mg every 6 hrs', 'Nausea, vomiting', 'Liver disease', 'Below 25°C, dry place', 'Take with food', 'erythromycin.jpg'],
        ];

        foreach ($medications as $medication) {
            Medication::create([
                'name' => $medication[0],
                'uses' => $medication[1],
                'potency_level' => $medication[2],
                'recommended_dosage_children' => $medication[3],
                'recommended_dosage_adults' => $medication[4],
                'side_effects' => $medication[5],
                'contraindications' => $medication[6],
                'storage_condition' => $medication[7],
                'other_key_information' => $medication[8],
                'image_url' => $medication[9],
            ]);
        }
    }
}