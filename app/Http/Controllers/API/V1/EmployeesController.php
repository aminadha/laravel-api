<?php

namespace App\Http\Controllers\API\V1;

use App\Actions\Employee\CreateEmployee;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Http\Resources\EmployeeCollection;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Employee::with(['organization', 'branch'])->get();

        return [
            'data' => $data
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inputs = $request->all();

        $employee = new Employee;
        $employee->fill($inputs);
        $employee->save();

        return [
            'data' => $employee,
            'message' => 'Employee created successfully',
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employee = Employee::findOrFail($id);
        $employee->load(['organization', 'branch']);

        return $employee;

        // return [
        //     'data' => $employee,
        //     'message' => 'Employee data retrieved',
        // ];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $inputs = $request->all();

        // find record by $id
        $employee = Employee::find($id);

        // update Employee data 
        $employee->fill($inputs);
        $employee->name = strtoupper(trim($inputs['name']));

        // save Employee to db
        $employee->save();

        return $employee;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee = Employee::findOrFail($id);

        $employee->delete();

        return response()->json([
            'success' => true,
            'data' => null,
            'message' => 'Record deleted'
        ]);
    }
}
