<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Page;
use App\Models\Room;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $pages = Page::where('is_active', true)->get();
        $rooms = Room::where('is_active', true)->get();
        $news = News::where('is_published', true)->get();

        $content = view('sitemap', [
            'pages' => $pages,
            'rooms' => $rooms,
            'news' => $news,
        ])->render();

        return response($content, 200)
            ->header('Content-Type', 'application/xml');
    }
}
