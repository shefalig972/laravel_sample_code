<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\EmployeePool;

class EmployeePoolController extends Controller {

    /**
     * @method:      index
     * @params:      request data
     * @createddate: 10-03-2019 (dd-mm-yyyy)
     * @developer:   Varun
     * @purpose:     to display the employee list with search,pagination and sorting
     * @return:      return view
     */
    public function index(Request $request) {
        $conditions = [
            ['id', '!=', $this->ClientSession->id],
        ];
        if ($request->isMethod('post')) {
            $keyword = $request->get('search');
            $employees = EmployeePool::whereIn('parent_id', $this->ClientSession->id)
                            ->where($conditions)->where(function($querys) use($keyword) {
                        $querys->orWhere(DB::raw('concat(firstname," ",lastname)'), 'LIKE', "%$keyword%")
                                ->orWhere('email', 'LIKE', "%$keyword%");
                    })->latest()->paginate(env('PAGINATION_RECORDS'));

            $view = 'employee_pool.search';
        } else {
            $employees = EmployeePool::whereIn('parent_id', $this->ClientSession->id)
                            ->where($conditions)->latest()->paginate(env('PAGINATION_RECORDS'));
            $view = 'employee_pool.index';
        }
        return view($view, compact('employees'));
    }

    /**
     * @method:      create
     * @params:      []
     * @createddate: 10-03-2019 (dd-mm-yyyy)
     * @developer:   Varun
     * @purpose:     to display the employee create form
     * @return:      []
     */
    public function create() {
        return view('employee_pool.create');
    }

    /**
     * @method:      store
     * @params:      request data
     * @createddate: 10-03-2019 (dd-mm-yyyy)
     * @developer:   Varun
     * @purpose:     to store the employee infomation
     * @return:      redirect to employee list page
     */
    public function store(Request $request) {
        if ($request->isMethod('post')) {
            $requestData = $request->all();
            $this->ValidationCheck(['firstname' => 'required', 'lastname' => 'required', 'email' => 'required|email|unique:users,email', 'gender' => 'required', 'user_language' => 'required'], [
                'email.unique' => 'This email address already saved in database.'
            ]);
            try {
                $requestData['parent_id'] = $this->ClientSession->id;
                $requestData['usertype'] = 1;
                EmployeePool::create($requestData);
                return redirect('/employee')->with('flash_message', 'Employee has been created successfully.');
            } catch (\Exception $e) {
                return redirect('/employee')->with('error_message', 'There is something wrong.Please try again later.');
            }
        }
    }

    /**
     * @method:      edit
     * @params:      id
     * @createddate: 10-03-2019 (dd-mm-yyyy)
     * @developer:   Varun
     * @purpose:     to edit the employee information
     * @return:      
     */
    public function edit($id) {
        $employee = EmployeePool::where('id', $id)->first();
        return view('employee_pool.edit', compact('employee'));
    }

    /**
     * @method:      update
     * @params:      request data,encrypt Id
     * @createddate: 10-03-2019 (dd-mm-yyyy)
     * @developer:   Varun
     * @purpose:     to update the employee information
     * @return:      return to employee list
     */
    public function update(Request $request) {
        if ($request->isMethod('patch')) {
            $requestData = $request->all();
            $this->ValidationCheck(['firstname' => 'required', 'lastname' => 'required', 'email' => 'required|email|unique:users,email,' . $id, 'gender' => 'required', 'user_language' => 'required'], [
                'email.unique' => 'This email address already saved in database.'
            ]);
            try {
                EmployeePool::where('id', $request->get('record_id'))->update($requestData);
                return redirect('/employee')->with('flash_message', 'Employee Information has been updated successfully.');
            } catch (\Exception $e) {
                return redirect('/employee')->with('error_message', 'There is something wrong.Please try again later.');
            }
        }
    }

    /**
     * @method:      status
     * @params:      $id
     * @createddate: 10-03-2019 (dd-mm-yyyy)
     * @developer:   Varun
     * @purpose:     update employee status [0, 1]
     * @return:      return to employee page
     */
    public function status($id) {
        try {
            $employee = EmployeePool::where('id', $id)->first();
            $status = !empty($employee->status) ? "0" : "1";
            $message = !empty($employee->status) ? 'Employee Status has been deactivated successfully.' : 'Employee Status has been activated successfully.';
            EmployeePool::where('id', $id)->update([
                'status' => $status
            ]);
            return redirect('/employee')->with('flash_message', $message);
        } catch (\Exception $e) {
            return redirect('/employee')->with('error_message', 'There is something wrong.Please try again later.');
        }
    }

    /**
     * @method:      destroy
     * @params:      id
     * @createddate: 10-03-2019 (dd-mm-yyyy)
     * @developer:   Varun
     * @purpose:     delete employee record
     */
    public function destroy($id) {
        try {
            EmployeePool::where('id', $id)->delete();
            return redirect('/employee')->with('flash_message', 'Employee has been deleted successfully.');
        } catch (\Exception $e) {
            return redirect('/employee')->with('error_message', 'There is something wrong.Please try again later.');
        }
    }

    /**
     * @method:      ValidationCheck
     * @params:      validationFields,messages
     * @createddate: 10-03-2019 (dd-mm-yyyy)
     * @developer:   Varun
     * @purpose:     function to validate the user inputs
     */
    public function ValidationCheck($validationFieldsArray, $messages = []) {
       return request()->validate($validationFieldsArray, $messages);
    }

}
