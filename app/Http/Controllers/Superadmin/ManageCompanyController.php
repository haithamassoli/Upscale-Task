<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Company;

use Illuminate\Http\Request;



class ManageCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::all();
        return view('dashboard.superadmin.companies', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.superadmin.company_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'unique:companies|email|nullable',
            'website' => 'string|nullable',
            'logo' => 'mimes:jpg,png,jpeg|max:5048'
        ]);

        if ($request->hasfile('logo')) {
            $newImageName = time() . '-' . $request->name . '.' . $request->logo->extension();
            $request->logo->move(storage_path('app/public/logo'), $newImageName);
            $company = Company::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'website' => $request->input('website'),
                'logo' => $newImageName,
            ]);
            return redirect('superadmin/companies')->with('success', 'Added successfully');
        } else {
            $company = Company::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'website' => $request->input('website'),
            ]);
            return redirect('superadmin/companies')->with('success', 'Added successfully');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = Company::findOrFail($id);
        return view('dashboard.superadmin.company_edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'email',
            'website' => 'string',
            'logo' => 'mimes:jpg,png,jpeg|max:5048'
        ]);

        if ($request->hasfile('logo')) {
            $newImageName = time() . '-' . $request->name . '.' . $request->logo->extension();
            $request->logo->move(storage_path('img'), $newImageName);
            $company = Company::where('id', $id)
                ->update([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'website' => $request->input('website'),
                    'logo' => $newImageName,
                ]);
            return redirect('superadmin/companies')->with('success', 'Updated successfully');
        } else {
            $company = Company::where('id', $id)
                ->update([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'website' => $request->input('website'),
                ]);
            return redirect('superadmin/companies')->with('success', 'Updated successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Company::destroy($id);
        return redirect('superadmin/companies')->with('success', 'Deleted successfully');
    }
}
