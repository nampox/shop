<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class CmsController extends Controller
{
    /**
     * Display the CMS dashboard
     */
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('email_verified_at', '!=', null)->count(),
            'recent_users' => User::where('created_at', '>=', now()->subDays(7))->count(),
        ];

        return view('cms.dashboard', compact('stats'));
    }

    /**
     * Display posts management page
     */
    public function posts()
    {
        return view('cms.posts');
    }

    /**
     * Display pages management page
     */
    public function pages()
    {
        return view('cms.pages');
    }

    /**
     * Display media library page
     */
    public function media()
    {
        return view('cms.media');
    }

    /**
     * Display users management page
     */
    public function users()
    {
        $users = User::latest()->paginate(10);
        return view('cms.users', compact('users'));
    }

    /**
     * Display settings page
     */
    public function settings()
    {
        return view('cms.settings');
    }
}

