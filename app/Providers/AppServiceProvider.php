<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

// Add your models and policies here
use App\Models\Terrain;
use App\Models\TerrainImage;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Review;
use App\Models\Favorite;

use App\Policies\TerrainPolicy;
use App\Policies\TerrainImagePolicy;
use App\Policies\BookingPolicy;
use App\Policies\PaymentPolicy;
use App\Policies\ReviewPolicy;
use App\Policies\FavoritePolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Terrain::class => TerrainPolicy::class,
        TerrainImage::class => TerrainImagePolicy::class,
        Booking::class => BookingPolicy::class,
        Payment::class => PaymentPolicy::class,
        Review::class => ReviewPolicy::class,
        Favorite::class => FavoritePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
