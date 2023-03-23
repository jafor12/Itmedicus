<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompaniesController extends Controller
{
    public function index() {
        $Companies = Company::orderBy('id', 'desc')->get();
        return view('admin.company.index', ['Companies' => $Companies]);
    }

    public function addCompany()
    {
        return view('admin.company.add-company');
    }
    public function storeCompany(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'web_link' => 'required',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = time().'.'.$request->logo->extension();
        $request->logo->move(public_path('images'), $imageName);

        $postData = ['name' => $request->name, 'email' => $request->email, 'web_link' => $request->web_link, 'logo' => $imageName];

        Company::create($postData);
        return redirect('/company')->with(['message' => 'company added successfully!', 'status' => 'success']);
    }
    public function editCompany($id){
        $company = Company::find($id);
        return view('admin.company.edit-company',[
            'company' =>$company
        ]);

    }

    public function updateCompany(Request $request) {
        $company= Company::find($request->company_id);
        $imageName = '';
        if ($request->hasFile('logo')) {
            $imageName = time().'.'.$request->logo->extension();
            $request->logo->move(public_path('images'), $imageName);
            if ($company->logo) {
                Storage::delete('images/' . $company->logo);
            }
        } else {
            $imageName = $company->logo;
        }

        $postData = ['name' => $request->name, 'email' => $request->email, 'web_link' => $request->web_link, 'logo' => $imageName];
        $company->update($postData);
        return redirect('/company')->with(['message' => 'Post updated successfully!', 'status' => 'success']);
    }

    public function deleteCompany($id){
        $company = Company::find($id);
        Storage::delete('public/images/' . $company->image);
        $company->delete();
        return redirect('/company')->with(['message' => 'Post deleted successfully!', 'status' => 'info']);
    }

}
