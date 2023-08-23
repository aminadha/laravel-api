<?php

namespace App\Http\Controllers\API\V1;

use App\Actions\Branch\CreateBranch;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBranchRequest;
use App\Http\Requests\UpdateBranchRequest;
use App\Http\Resources\BranchCollection;
use App\Http\Resources\BranchResource;
use App\Models\Branch;

class BranchesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Branch::with('organization')->get();

        return $data;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBranchRequest $request, CreateBranch $action)
    {
        $validatedInput = $request->validated();
        $data = $action->execute($validatedInput, new Branch);

        return [
            'data' => $data,
            'message' => 'Branch created successfully',
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // find record by $id
        $branch = Branch::findOrFail($id);
        return [
            'success' => true,
            'data' => new BranchResource($branch),
        ];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBranchRequest $request, string $id)
    {
        $validatedInput = $request->validated();

        // find record by $id
        $branch = Branch::find($id);

        // update Branch data 
        $branch->fill($validatedInput);
        $branch->name = strtoupper(trim($validatedInput['name']));

        // save Branch to db
        $branch->save();

        return $branch;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $branch = Branch::findOrFail($id);

        $branch->delete();

        return response()->json([
            'success' => true,
            'data' => null,
            'message' => 'Record deleted'
        ]);
    }

    public function restore(string $id)
    {
        $branch = Branch::onlyTrashed()->findOrfail($id);
        $branch->restore();

        return [
            'success' => true,
            'data' => $branch,
            'message' => 'Record restored'
        ];
    }

    public function forceDelete(string $id)
    {
        $branch = Branch::withTrashed()->findOrfail($id);
        $branch->forceDelete();

        return [
            'success' => true,
            'data' => null,
            'message' => 'Record force deleted'
        ];
    }
}
