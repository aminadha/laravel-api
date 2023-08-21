<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrganizationCollection;
use App\Http\Resources\OrganizationResource;
use App\Models\Organization;
use Illuminate\Http\Request;

class OrganizationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Organization::get();
        // $data = Organization::withTrashed()->get();
        // $data = Organization::onlyTrashed()->get();
        // $data = Organization::paginate(5);

        return new OrganizationCollection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedInput = $request->validate([
            'name' => ['required', 'unique:organizations'],
            'address' => 'required',
            'postcode' => ['required', 'min:5'],
            'state' => 'required',
            'staff_count' => 'numeric'
        ]);

        $organization = new Organization();
        $organization->fill($validatedInput);
        $organization->save();

        return [
            'data' => $organization,
            'message' => 'Organization created successfully',
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // find record by $id
        $organization = Organization::findOrFail($id);

        // if (!$organization) {
        //     return abort(404, 'No Record Found');
        // }

        return [
            'success' => true,
            'data' => new OrganizationResource($organization),
        ];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedInput = $request->validate([
            'name' => ['required', 'unique:organizations,name,' . $id],
            'address' => 'required',
            'postcode' => ['required', 'min:5'],
            'state' => 'required',
            'staff_count' => 'numeric'
        ]);

        // find record by $id
        $organization = Organization::find($id);

        // update organization data 
        $organization->fill($validatedInput);
        $organization->name = strtoupper(trim($validatedInput['name']));
        $organization->address = trim($validatedInput['address']);

        // save organization to db
        $organization->save();

        return $organization;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $organization = Organization::findOrFail($id);

        $organization->delete();

        return response()->json([
            'success' => true,
            'data' => null,
            'message' => 'Record deleted'
        ]);
    }

    public function restore(string $id)
    {
        $organization = Organization::onlyTrashed()->findOrfail($id);
        $organization->restore();

        return [
            'success' => true,
            'data' => $organization,
            'message' => 'Record restored'
        ];
    }

    public function forceDelete(string $id)
    {
        $organization = Organization::withTrashed()->findOrfail($id);
        $organization->forceDelete();

        return [
            'success' => true,
            'data' => null,
            'message' => 'Record force deleted'
        ];
    }
}
