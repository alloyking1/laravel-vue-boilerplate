<?php

namespace Modules\EcommerceAnalytics\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;
use Inertia\Response;
use Modules\EcommerceAnalytics\Models\ConnectedStore;
use Modules\EcommerceAnalytics\Models\ShopifyConnection;

class ShopifyController extends Controller
{
    /**
     * Show connect store page
     */
    public function connect(): Response
    {
        $connectedStores = auth()->user()
            ->connectedStores()
            ->where('platform', 'shopify')
            ->with('shopifyConnection')
            ->get();

        return Inertia::render('ecommerceanalytics/ConnectShopify', [
            'connectedStores' => $connectedStores,
        ]);
    }

    /**
     * Redirect to Shopify OAuth
     */
    public function redirect(Request $request)
    {
        $request->validate([
            'shop' => 'required|string|regex:/^[a-zA-Z0-9-]+\.myshopify\.com$/',
        ]);

        $shop = $request->input('shop');
        $scopes = 'read_orders,read_products';
        $redirectUri = env('SHOPIFY_REDIRECT_URI')
            ?: route('ecommerceanalytics.shopify.callback');

        $url = "https://{$shop}/admin/oauth/authorize?" . http_build_query([
            'client_id' => env('SHOPIFY_CLIENT_ID'),
            'scope' => $scopes,
            'redirect_uri' => $redirectUri,
            'state' => csrf_token(),
        ]);

        return redirect($url);
    }

    /**
     * Handle Shopify OAuth callback
     */
    public function callback(Request $request)
    {
        $shop = $request->input('shop');
        $code = $request->input('code');

        // Exchange code for access token
        $response = Http::post("https://{$shop}/admin/oauth/access_token", [
            'client_id' => env('SHOPIFY_CLIENT_ID'),
            'client_secret' => env('SHOPIFY_CLIENT_SECRET'),
            'code' => $code,
        ]);

        if ($response->failed()) {
            return redirect()->route('ecommerceanalytics.shopify.connect')
                ->with('error', 'Failed to connect to Shopify');
        }

        $accessToken = $response->json('access_token');

        // Get shop info
        $shopInfo = Http::withHeaders([
            'X-Shopify-Access-Token' => $accessToken,
        ])->get("https://{$shop}/admin/api/2024-01/shop.json");

        // Save connection
        $connectedStore = ConnectedStore::create([
            'user_id' => auth()->id(),
            'platform' => 'shopify',
            'store_name' => $shopInfo->json('shop.name') ?? $shop,
            'store_url' => "https://{$shop}",
            'connection_status' => 'connected',
            'is_active' => true,
        ]);

        ShopifyConnection::create([
            'connected_store_id' => $connectedStore->id,
            'shop_domain' => $shop,
            'access_token' => encrypt($accessToken),
            'shop_info' => $shopInfo->json('shop'),
        ]);

        return redirect()->route('ecommerceanalytics.shopify.connect')
            ->with('success', 'Shopify store connected successfully!');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('ecommerceanalytics::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('ecommerceanalytics::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
