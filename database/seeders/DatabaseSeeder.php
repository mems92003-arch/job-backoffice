<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\JobApplication;
use App\Models\JobCategory;
use App\Models\JobVacancy;
use App\Models\Resume;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed the root admin
        User::firstOrCreate([
            'email' => 'admin@admin.com',
        ], [
            'name' => 'Admin',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $jobData = json_decode(file_get_contents(database_path('data/job_data.json')), true);

        // 1. Create Job Categories
        foreach ($jobData['jobCategories'] as $category) {
            JobCategory::firstOrCreate([
                'name' => $category,
            ]);
        }

        // 2. Create Companies and Owners
        foreach ($jobData['companies'] as $company) {
            // Create Company Owner 
            $companyOwner = User::firstOrCreate([
                'email' => fake()->unique()->safeEmail(),
            ], [
                'name' => fake()->name(),
                'password' => Hash::make('12345678'),
                'role' => 'company-owner',
                'email_verified_at' => now()
            ]);

            Company::firstOrCreate([
                'name' => $company['name']
            ], [
                'address' => $company['address'],
                'industry' => $company['industry'],
                'website' => $company['website'],
                'ownerId' => $companyOwner->id,
            ]);
        }

        // 3. Create Job Vacancies (تم نقلها بره اللوب بتاع الشركات)
        foreach ($jobData['jobVacancies'] as $job) {
            // Get the created company
            $company = Company::where('name', $job['company'])->firstOrFail();

            // Get the created job category
            $jobCategory = JobCategory::where('name', $job['category'])->firstOrFail();

            JobVacancy::firstOrCreate([
                'title' => $job['title'],
                'companyId' => $company->id
            ], [
                'description' => $job['description'],
                'location' => $job['location'],
                'type' => $job['type'],
                'salary' => $job['salary'],
                'jobCategoryId' => $jobCategory->id,
            ]);



        }


        // ==========================================
// 4. Create Job Applications & Resumes
// ==========================================

        // قراءة ملف الـ JSON الخاص بالتقديمات 
        $applicationsData = json_decode(file_get_contents(database_path('data/job_applications.json')), true);

        foreach ($applicationsData['jobApplications'] as $application) {

            // 1. توليد ID المستخدم يدوياً لضمان حفظه في الميموري والداتابيز
            $userId = (string) Str::uuid();

            // أ. إنشاء المستخدم (Applicant) اللي قدم على الوظيفة
            $applicant = User::firstOrCreate([
                'email' => fake()->unique()->safeEmail(),
            ], [
                'id' => $userId, // <-- إجبار إضافة الـ ID هنا
                'name' => fake()->name(),
                'password' => Hash::make('12345678'),
                'role' => 'job-seeker',
                'email_verified_at' => now()
            ]);

            // التأكد من أخذ الـ ID المضمون
            $finalUserId = $applicant->id ?? $userId;

            // 2. توليد ID السيرة الذاتية يدوياً
            $resumeId = (string) Str::uuid();
            $resumeData = $application['resume'];

            // ب. إنشاء السيرة الذاتية (Resume)
            $resume = Resume::firstOrCreate([
                // استخدمنا الـ fileUrl كعنصر فريد (استخدمنا ?? عشان لو الكلمة في الـ JSON اسمها fileUri ميضربش ايرور)
                'fileUrl' => $resumeData['fileUrl'] ?? $resumeData['fileUri'],
            ], [
                'id' => $resumeId,      // <-- إجبار إضافة الـ ID هنا
                'userId' => $finalUserId,   // <-- ربطه باليوزر المضمون
                'filename' => $resumeData['filename'],
                'contactDetails' => $resumeData['contactDetails'],
                'summary' => $resumeData['summary'],
                'skills' => $resumeData['skills'],
                'experience' => $resumeData['experience'],
                'education' => $resumeData['education'],
            ]);

            $finalResumeId = $resume->id ?? $resumeId;

            // ج. جلب وظيفة عشوائية لربط التقديم بها
            $randomJob = JobVacancy::inRandomOrder()->first();

            // 3. توليد ID طلب التوظيف
            $applicationId = (string) Str::uuid();

            // د. إنشاء طلب التوظيف (Job Application)
            JobApplication::firstOrCreate([
                'userId' => $finalUserId,     // <-- ربطه باليوزر المضمون
                'jobVacancyId' => $randomJob->id,
            ], [
                'id' => $applicationId, // <-- إجبار إضافة الـ ID هنا
                'resumeId' => $finalResumeId, // <-- ربطه بالـ Resume المضمون
                'status' => $application['status'],
                'aiGeneratedScore' => $application['aiGeneratedScore'],
                'aiGeneratedFeedback' => $application['aiGeneratedFeedback'],
            ]);
        }
    }


}