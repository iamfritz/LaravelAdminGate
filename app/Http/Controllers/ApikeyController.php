<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Apikey;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

use App\Services\ApikeyService;

class ApikeyController extends Controller
{
    protected $apikeyService;
    
    public function __construct(ApikeyService $apikeyService)
    {
        $this->apikeyService = $apikeyService;
    }    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginate = 5;
        $data = $this->apikeyService->latest($paginate);
        
        return view('apikey.index',compact('data'))
            ->with('i', (request()->input('page', 1) - 1) * $paginate);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('admin')) {
            abort(403, "You don't have permission to access.");
        }
                
        $this->apikeyService->create([
            'key'           => Str::random(64), // Generate a random API key
            'user_id'       => 1, // You can associate keys with users if needed
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        return redirect()->route('apikey.index')
                        ->with('success','API key generated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Apikey  $apikey
     * @return \Illuminate\Http\Response
     */
    public function destroy(Apikey $apikey)
    {
        
        if (Gate::denies('admin')) {
            abort(403, "You don't have permission to access.");
        }        

        $this->apikeyService->delete($apikey);
    
        return redirect()->route('apikey.index')
                        ->with('success','API Key deleted successfully');
    }
}