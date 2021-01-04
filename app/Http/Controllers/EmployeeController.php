<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;
use DataTables;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
    	if ($request->ajax()) {
            $data = Employee::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-warning btn-sm editEmployee">Edit</a>';
   
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteEmployee">Delete</a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('Employee');
    }

    public function store(Request $request)
    {
        Employee::updateOrCreate(['id' => $request->employee_id],
                ['Nama' => $request->nama, 'Alamat' => $request->alamat]);        
   
        return response()->json(['success'=>'Data Karyawan berhasil disimpan.']);
    }

    public function edit($id)
    {
        $employee = Employee::find($id);
        return response()->json($employee);
    }

    public function destroy($id)
    {
        Employee::find($id)->delete();
     
        return response()->json(['success'=>'Data Karyawan berhasil dihapus.']);
    }
}
