<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::all();

        // ✅ Convert image paths to full URLs
        $banners->transform(function ($banner) {
            // If the image_url is not a full link (doesn't start with http), convert it
            if (!str_starts_with($banner->image_url, 'http')) {
                $banner->image_url = asset('storage/' . $banner->image_url);
            }
            return $banner;
        });

        return response()->json($banners);
    }
}
