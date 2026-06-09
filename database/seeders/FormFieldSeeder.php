<?php

namespace Database\Seeders;

use App\Models\FormField;
use Illuminate\Database\Seeder;

class FormFieldSeeder extends Seeder
{
    public function run(): void
    {
        $fields = [
            // Personal Information Section
            ['key' => 'section_personal', 'label' => 'Personal Information', 'type' => 'section_header', 'section' => 'personal', 'sort_order' => 1, 'required' => false],
            ['key' => 'first_name', 'label' => 'First Name', 'type' => 'text', 'placeholder' => 'E.g. Aloysius', 'section' => 'personal', 'sort_order' => 2, 'required' => true],
            ['key' => 'middle_name', 'label' => 'Middle Name', 'type' => 'text', 'placeholder' => 'E.g. Musanyusa', 'section' => 'personal', 'sort_order' => 3, 'required' => false],
            ['key' => 'last_name', 'label' => 'Sur Name', 'type' => 'text', 'placeholder' => 'E.g. Kisitu', 'section' => 'personal', 'sort_order' => 4, 'required' => false],
            ['key' => 'email', 'label' => 'Email Address', 'type' => 'email', 'placeholder' => 'email', 'section' => 'personal', 'sort_order' => 5, 'required' => true],
            ['key' => 'phone', 'label' => 'Phone Number', 'type' => 'tel', 'placeholder' => '+256111 111 111', 'description' => 'Please provide an active phone number where we can easily reach you for follow-up communication about your application.', 'section' => 'personal', 'sort_order' => 6, 'required' => true],
            ['key' => 'district', 'label' => 'Place of Residence (District)', 'type' => 'text', 'placeholder' => 'District', 'section' => 'personal', 'sort_order' => 7, 'required' => true],
            ['key' => 'county', 'label' => 'County', 'type' => 'text', 'placeholder' => 'County', 'section' => 'personal', 'sort_order' => 8, 'required' => true],
            ['key' => 'sub_county', 'label' => 'Sub-County', 'type' => 'text', 'placeholder' => 'Sub-county', 'section' => 'personal', 'sort_order' => 9, 'required' => true],
            ['key' => 'village', 'label' => 'Village', 'type' => 'text', 'placeholder' => 'Village', 'section' => 'personal', 'sort_order' => 10, 'required' => true],
            ['key' => 'date_of_birth', 'label' => 'Date of Birth', 'type' => 'date', 'placeholder' => 'Choose Date', 'section' => 'personal', 'sort_order' => 11, 'required' => true],
            ['key' => 'gender', 'label' => 'Gender', 'type' => 'radio', 'options' => ['Male', 'Female'], 'section' => 'personal', 'sort_order' => 12, 'required' => true],
            ['key' => 'nin', 'label' => 'Fill in your NIN, if not for (parent/relative)', 'type' => 'text', 'placeholder' => 'NIN', 'section' => 'personal', 'sort_order' => 13, 'required' => true],
            ['key' => 'education_level', 'label' => 'What is your current highest level of education?', 'type' => 'radio', 'options' => ["Bachelor's Degree", 'Diploma', 'UACE (S6)', 'UCE (S4)', 'PLE (P7)', 'Other'], 'section' => 'personal', 'sort_order' => 14, 'required' => true],
            ['key' => 'education_other', 'label' => 'If others: Specify', 'type' => 'text', 'placeholder' => 'Your answer', 'section' => 'personal', 'sort_order' => 15, 'required' => false],
            ['key' => 'tiktok', 'label' => 'Tiktok account', 'type' => 'url', 'placeholder' => 'Insert link', 'description' => 'Insert link', 'section' => 'personal', 'sort_order' => 16, 'required' => false],

            // Emergency Contact Section
            ['key' => 'section_emergency', 'label' => 'Emergency Contact', 'type' => 'section_header', 'section' => 'emergency', 'sort_order' => 17, 'required' => false],
            ['key' => 'next_of_kin_name', 'label' => 'Next of kin (Full name)', 'type' => 'text', 'placeholder' => 'Parent / Guardian Name', 'description' => 'Provide the name and contact information of someone we can reach in case of an emergency, such as a parent, guardian, or close relative.', 'section' => 'emergency', 'sort_order' => 18, 'required' => true],
            ['key' => 'next_of_kin_relationship', 'label' => 'Next of kin Relationship', 'type' => 'text', 'placeholder' => 'Your answer', 'section' => 'emergency', 'sort_order' => 19, 'required' => true],
            ['key' => 'next_of_kin_phone', 'label' => 'Next of kin Contact number', 'type' => 'tel', 'placeholder' => '+256111 111 111', 'section' => 'emergency', 'sort_order' => 20, 'required' => true],
            ['key' => 'next_of_kin_nin', 'label' => 'Next of kin NIN', 'type' => 'text', 'placeholder' => 'NIN', 'section' => 'emergency', 'sort_order' => 21, 'required' => false],

            // Motivation Section
            ['key' => 'section_motivation', 'label' => 'Motivation', 'type' => 'section_header', 'section' => 'motivation', 'sort_order' => 22, 'required' => false],
            ['key' => 'hear_about', 'label' => 'How did you hear about us?', 'type' => 'radio', 'options' => ['Jangu website', 'Linked In', 'Instagram', 'Facebook', 'Tiktok', 'Friend', 'Other'], 'description' => 'Let us know how you first found out about this program or Jangu International. This helps us understand how our message is reaching people like you.', 'section' => 'motivation', 'sort_order' => 23, 'required' => true],
            ['key' => 'hear_about_other', 'label' => 'If others: Specify', 'type' => 'text', 'placeholder' => 'Your answer', 'section' => 'motivation', 'sort_order' => 24, 'required' => false],
            ['key' => 'recommender', 'label' => 'Who recommended you to this program', 'type' => 'text', 'placeholder' => 'Name of recommender', 'description' => 'If someone recommended you to this program, please share their name and how you know them. If not, you can simply write "None."', 'section' => 'motivation', 'sort_order' => 25, 'required' => false],
            ['key' => 'personal_statement', 'label' => 'Write a personal statement between 200-500 words expressing your interest for this program?', 'type' => 'textarea', 'placeholder' => 'Write a personal statement between 200-500 words expressing your interest', 'description' => 'Tell us why you\'re interested in joining this program. Share your personal story, what motivates you, your goals, and how this opportunity can help you grow and make a difference in your community. Keep your response between 200–500 words.', 'section' => 'motivation', 'sort_order' => 26, 'required' => true],
            ['key' => 'business_description', 'label' => 'Are you currently running any business? If yes, please briefly explain what it does.', 'type' => 'textarea', 'description' => 'Share the type of business, its main products or services, and its current stage of operation.', 'section' => 'motivation', 'sort_order' => 27, 'required' => true],
            ['key' => 'previous_programs', 'label' => 'Have you previously participated in any entrepreneurship or related skilling programs?', 'type' => 'checkbox', 'options' => ['Yes', 'No'], 'description' => 'Select yes if you have attended any workshops, trainings, or initiatives, even if they were short-term.', 'section' => 'motivation', 'sort_order' => 28, 'required' => false],
            ['key' => 'skills_talents', 'label' => 'What unique skills or talents do you have, and how would you like to contribute them to our community if selected?', 'type' => 'textarea', 'placeholder' => 'Write your unique skills or talents you have,', 'description' => 'Briefly share any unique skills or talents you have, and how you plan to use them to contribute to and engage with our community.', 'section' => 'motivation', 'sort_order' => 29, 'required' => true],
            ['key' => 'applied_before', 'label' => 'Have you applied for this program before?', 'type' => 'radio', 'options' => ['Yes', 'No'], 'section' => 'motivation', 'sort_order' => 30, 'required' => true],
            ['key' => 'applied_times', 'label' => 'If Yes, how many times have you applied?', 'type' => 'select', 'options' => ['Never', 'Once', 'Two times', 'Three times'], 'section' => 'motivation', 'sort_order' => 31, 'required' => false],
            ['key' => 'time_commitment', 'label' => 'If selected, how much time can you dedicate to actively participating in our programs?', 'type' => 'radio', 'options' => ['3 months', '9 months', '2 years', 'Other'], 'description' => 'Please share how much time you can consistently commit, considering our program activities and expectations.', 'section' => 'motivation', 'sort_order' => 32, 'required' => true],
            ['key' => 'time_commitment_other', 'label' => 'If Other time commitment, specify', 'type' => 'text', 'placeholder' => 'Your answer', 'section' => 'motivation', 'sort_order' => 33, 'required' => false],
            ['key' => 'consent_1', 'label' => 'Consent - Information Accuracy', 'type' => 'consent', 'description' => 'I hereby declare that the information provided above is true, complete, and accurate to the best of my knowledge.', 'section' => 'motivation', 'sort_order' => 34, 'required' => true],
            ['key' => 'consent_2', 'label' => 'Consent - Admission Requirements', 'type' => 'consent', 'description' => 'I agree that if selected, I will present a medical form, a letter from the local chairman, and a consent letter from a parent or close guardian before final admission into the program.', 'section' => 'motivation', 'sort_order' => 35, 'required' => true],
        ];

        foreach ($fields as $field) {
            FormField::create($field);
        }
    }
}
