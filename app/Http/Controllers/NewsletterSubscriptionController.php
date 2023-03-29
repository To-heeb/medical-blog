<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscription;
use App\Http\Requests\Newsletter\StoreNewsletterSubscriptionRequest;
use App\Http\Requests\Newsletter\UpdateNewsletterSubscriptionRequest;

class NewsletterSubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNewsletterSubscriptionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(NewsletterSubscription $newsletterSubscription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNewsletterSubscriptionRequest $request, NewsletterSubscription $newsletterSubscription)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NewsletterSubscription $newsletterSubscription)
    {
        //
    }
}
