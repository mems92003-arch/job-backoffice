<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\JobVacancy;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;




class DashboardController extends Controller
{
    public function index()
    {

        if (auth()->user()->role == 'admin') {
            $analytics = $this->adminDashboard();
        } else {
            $analytics = $this->companyOwnerDashboard();
        }

        return view('dashboard.index', compact('analytics'));
    }

    private function adminDashboard()
    {
        // Last 30 days active users (job-seeker role)
        $activeUsers = User::where('last_login_at', ">=", now()->subDays(30))->where('role', "=", 'job-seeker')->count();

        // Total Jobs (not deleted)
        $totalJobs = JobVacancy::whereNull('deleted_at')->count();

        // Total applications (not deleted)
        $totalApplication = JobApplication::whereNull('deleted_at')->count();

        // Most Applied Jobs
        $mostAppliedJobs = JobVacancy::withCount('jobApplications as totalCount')
            ->whereNull('deleted_at')
            ->orderByDesc('totalCount')
            ->limit(5)
            ->get();

        // Conversion Rate
        $conversionRates = JobVacancy::withCount('jobApplications as totalCount')
            ->having('totalCount', '>', 0)
            ->orderByDesc('totalCount')
            ->limit(5)
            ->get()
            ->map(function ($job) {
                if ($job->viewCount > 0) {
                    $job->conversionRate = round($job->totalCount / $job->viewCount * 100, 2);
                } else {
                    $job->conversionRate = 0;
                }
                return $job;
            });

        $analytics = [
            'activeUsers' => $activeUsers,
            'totalJobs' => $totalJobs,
            'totalApplications' => $totalApplication,
            'mostAppliedJobs' => $mostAppliedJobs,
            'conversionRates' => $conversionRates
        ];

        return $analytics;
    }

    private function companyOwnerDashboard() 
    {
        $company = auth()->user()->company;

        $activeUsers = User::where('last_login_at', '>=', now()->subDays(30))
            ->where('role', 'job-seeker')
            ->whereHas('jobApplications', function ($query) use ($company) {
                $query->whereIn('jobVacancyId', $company->jobVacancies->pluck('id'));
            })
            ->count();


        // Total jobs of the company
        $totalJobs = $company->jobVacancies->count();

        // Total applications of the company
        $totalApplications = JobApplication::whereIn('jobVacancyId', $company->jobVacancies->pluck('id'))->count();


        // Most applied jobs of the company
        $mostAppliedJobs = JobVacancy::withCount('jobApplications as totalCount')
            ->whereIn('id', $company->jobVacancies->pluck('id'))
            ->limit(5)
            ->orderByDesc('totalCount')
            ->get();


        // Conversionrates of the company
        $conversionRates = JobVacancy::withCount('jobApplications as totalCount')
            ->whereIn('id', $company->jobVacancies->pluck('id'))
            ->having('totalCount', '>', '0')
            ->limit(2)
            ->orderByDesc('totalCount')
            ->get()
            ->map(function ($job) {
                if ($job->viewCount > 0) {
                    $job->conversionRate = round($job->totalCount / $job->viewCount * 100, 2);
                } else {
                    $job->conversionRate = 0;
                }
                return $job;
            });


        $analytics = [
            'activeUsers' => $activeUsers,
            'totalJobs' => $totalJobs,
            'totalApplications' => $totalApplications,
            'mostAppliedJobs' => $mostAppliedJobs,
            'conversionRates' => $conversionRates
        ];

        return $analytics;
    }
}
