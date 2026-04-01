<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Contact;
use App\Models\Post;
use App\Models\Student;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function __invoke()
    {
        $stats = [
            'total_pendaftar' => Student::count(),
            'pending' => Student::pending()->count(),
            'accepted' => Student::accepted()->count(),
            'rejected' => Student::rejected()->count(),
            'total_posts' => Post::count(),
            'published_posts' => Post::published()->count(),
            'unread_contacts' => Contact::unread()->count(),
        ];

        $recentStudents = Student::with('user')
            ->latest()
            ->take(5)
            ->get();

        $recentPosts = Post::with('author')
            ->latest()
            ->take(5)
            ->get();

        // Activity log terbaru
        $recentLogs = ActivityLog::with('user')
            ->latest()
            ->take(8)
            ->get();

        // Chart data: pendaftaran per hari (14 hari terakhir)
        $chartData = $this->getRegistrationChartData();

        return view('admin.dashboard', compact(
            'stats', 'recentStudents', 'recentPosts', 'recentLogs', 'chartData'
        ));
    }

    private function getRegistrationChartData(): array
    {
        $days = 14;
        $startDate = Carbon::today()->subDays($days - 1);

        $registrations = Student::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();

        $labels = [];
        $data = [];

        for ($i = 0; $i < $days; $i++) {
            $date = $startDate->copy()->addDays($i);
            $key = $date->toDateString();
            $labels[] = $date->translatedFormat('d M');
            $data[] = $registrations[$key] ?? 0;
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }
}
