<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Http\Request;

class ActivateOrganization extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $validatedInput = $request->validate([
            'id' => 'required'
        ]);

        $organization = Organization::find($validatedInput['id']);
        $organization->status = 'active';
        $organization->activated_at = now();
        $organization->save();

        return response()->json([
            $organization
        ]);
    }
}
