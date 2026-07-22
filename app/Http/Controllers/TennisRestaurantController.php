<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class TennisRestaurantController extends Controller
{
    public function index()
    {
        $galleryImages = [
            'slatko-1-400x340.webp',
            'slatko-2-400x340.webp',
            'slatko-3-400x340.webp',
            'slatko-4-400x340.webp',
            'slatko-5-400x340.webp',
        ];

        $dishes = [
            'popular-dish-tennis-court-gallery-1-150x150.webp',
            'popular-dish-tennis-court-gallery-2-150x150.webp',
            'popular-dish-tennis-court-gallery-3-150x150.webp',
        ];

        return Inertia::render('TennisRestaurant', [
            'galleryImages' => $galleryImages,
            'dishes' => $dishes,
            'seo' => [
                'title' => 'Tennis Court Restaurant | Aleksandar Palace',
                'description' => 'Enjoy tasty food, great coffee and lovely service at our Tennis Court Restaurant.',
            ],
        ]);
    }
}
