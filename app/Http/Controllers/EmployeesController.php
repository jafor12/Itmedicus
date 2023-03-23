<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Employees;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use function GuzzleHttp\Promise\all;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(): Response
    {
        return response()->view('admin.employees.index', [
//            'employees' => Employees::orderBy('id', 'desc')->get(),
            'employees' => Employees::join('companies', 'Employees.company_id', '=', 'companies.id')
                ->get(['Employees.*', 'companies.name']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->view('admin.employee.create', [
            'companies' => Company::orderBy('id', 'desc')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'company_id' => 'required',
        ]);

        Employees::create($request->post());

        return redirect()->route('employee.index')->with('success','Employee has been created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $employee = Employees::find($id);
        return view('admin.employee.edit',[
            'employees' =>$employee,
            'companies' => Company::orderBy('id', 'desc')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $employees= Employees::find($request->employees_id);
        $request->validate([
            'user_name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'company_id' => 'required',
        ]);

        $employees->fill($request->post())->save();

        return redirect()->route('employee.index')->with('success','Employee Has Been updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Employees $row): RedirectResponse
    {
        $row->delete();

        return redirect()->route('employee.index')
            ->with('success','Product deleted successfully');
    }

}
