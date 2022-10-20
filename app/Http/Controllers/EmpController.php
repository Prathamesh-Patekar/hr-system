<?php
namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Role;
use App\Models\UserRole;
use App\Promotion;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;
use Validator;
use Redirect;

class EmpController extends Controller {

	public function search_empcode(Request $request){
		if($request->ajax()){
			$eCode = $request->emp_code;
			// $name = $emp_code;

			if(Employee::where('code', '=', $eCode)->exists()){
				$code="This Employee Code is already exists";
				
			}else{
				$code="";
			}             
			return $code;
			
		}	
	}
	public function search_empemail(Request $request){
		if($request->ajax()){
			$mail = $request->emp_email;
				\Log::info($mail);
			
			if(User::where('email', '=', $mail)->exists()){
				$code="This Email is alredy exists";
				
			}else{
				$code="";
			}             
			return $code;
			
		}	
	}
	
	public function addEmployee() {
		$roles = Role::get();

		return view('hrms.employee.add', compact('roles'));
	}

	public function processEmployee(Request $request) {
		$request->validate([
			'emp_code' =>'required|unique:employees,code',
		  ]);
		$filename = public_path('photos/a.png');
		if ($request->file('photo')) {
			$file = $request->file('photo');
			$filename = str_random(12);
			$fileExt = $file->getClientOriginalExtension();
			$allowedExtension = ['jpg', 'jpeg', 'png'];
			$destinationPath = public_path('photos');
			if (!in_array($fileExt, $allowedExtension)) {
				return redirect()->back()->with('message', 'Extension not allowed');
			}
			$filename = $filename . '.' . $fileExt;
			$file->move($destinationPath, $filename);
		}
		// $emp_code=$request->emp_code;
		// if ($emp_code != "") {
		// 	$input['emp_code'] = Input::get('emp_code');

		// 	// Must not already exist in the `email` column of `users` table
		// 	$rules = array('code' => 'unique:employees,code');

		// 	$validator = Validator::make($input, $rules);

		// 	if ($validator->fails()) {
		// 		echo 'That email address is already registered. You sure you don\'t have an account?';
		// 	}
		// 	else {
		// 		// Register the new user or whatever.
		// 	}

			// $enpl = Employee::where('code', '=', $request->emp_code)->exists();
			// 	\Log::info($enpl);
			// 	// return redirect()->back()->with('error', 'Employee code already exists.');
			// 	return Redirect::back()->withErrors(['msg' => 'The Message']);
			// }

		$user = new User;
		$user->name = $request->emp_name;
		$user->email = str_replace(' ', '_', $request->emp_email);
		$user->password = bcrypt('123456');
		$user->save();
		$emp = new Employee;
		
		$emp->photo = $filename;
		$emp->name = $request->emp_name;
		$emp->personal_email = $request->personal_email;
		$emp->code = $request->emp_code;
		$emp->status = $request->emp_status;
		$emp->gender = $request->gender;
		$emp->date_of_birth = date_format(date_create($request->dob), 'Y-m-d');
		$emp->date_of_joining = date_format(date_create($request->doj), 'Y-m-d');
		$emp->number = $request->number;
		$emp->qualification = $request->qualification;
		$emp->emergency_number = $request->emergency_number;
		$emp->pan_number = $request->pan_number;
		$emp->aadhar_number = $request->aadhar_number;
		$emp->esic_number = $request->esic_number;
		$emp->father_name = $request->father_name;
		$emp->current_address = $request->current_address;
		$emp->permanent_address = $request->permanent_address;
		$emp->formalities = $request->formalities;
		$emp->offer_acceptance = $request->offer_acceptance;
		$emp->probation_period = $request->probation_period;
		$emp->date_of_confirmation = date_format(date_create($request->date_of_confirmation), 'Y-m-d');
		$emp->department = $request->department;
		$emp->salary = $request->salary;
		$emp->account_number = $request->account_number;
		$emp->bank_name = $request->bank_name;
		$emp->ifsc_code = $request->ifsc_code;
		$emp->pf_account_number = $request->pf_account_number;
		$emp->un_number = $request->un_number;
		$emp->pf_status = $request->pf_status;

		$emp->user_id = $user->id;
		$emp->save();

		$userRole = new UserRole();
		$userRole->role_id = $request->role;
		$userRole->user_id = $user->id;
		$userRole->save();

		//$emp->userrole()->create(['role_id' => $request->role]);

		return json_encode(['title' => 'Success', 'message' => 'Employee added successfully', 'class' => 'modal-header-success']);

	}

	public function showEmployee() {
		$emps = User::with('employee', 'role.role')->paginate(15);
		$column = '';
		$string = '';
		
		return view('hrms.employee.show_emp', compact('emps', 'column', 'string'));
	}

	public function showEdit($id) {
		//$emps = Employee::whereid($id)->with('userrole.role')->first();
		$emps = User::where('id', $id)->with('employee', 'role.role')->first();
		$roles = Role::get();

		return view('hrms.employee.add', compact('emps', 'roles'));
	}

	public function doEdit(Request $request, $id) {
		$filename = public_path('photos/a.png');
		if ($request->file('photo')) {
			$file = $request->file('photo');
			$filename = str_random(12);
			$fileExt = $file->getClientOriginalExtension();
			$allowedExtension = ['jpg', 'jpeg', 'png'];
			$destinationPath = public_path('photos');
			if (!in_array($fileExt, $allowedExtension)) {
				return edirect()->back()->withErrors('message', 'Extension not allowed');
				// return back()->withErrors(['photo' => ['Your custom message here.']]);
				// return Redirect::back()->withErrors(['msg' => 'Extension not allowed]);

			}
			$filename = $filename . '.' . $fileExt;
			$file->move($destinationPath, $filename);

		}

		$photo = $filename;
		$emp_name = $request->emp_name;
		$emp_code = $request->emp_code;
		$emp_email = $request->emp_email;
		$personal_email = $request->personal_email;

		if ($emp_email != "") {
			$user = User::where('id', $id)->first();
			$user->email = $emp_email;
			$user->save();
		}
		$emp_status = $request->status;
		$emp_role = $request->role;
		$gender = $request->gender;
		$dob = date_format(date_create($request->date_of_birth), 'Y-m-d');
		$doj = date_format(date_create($request->date_of_joining), 'Y-m-d');
		$mob_number = $request->number;
		$qualification = $request->qualification;
		$emer_number = $request->emergency_number;
		$pan_number = $request->pan_number;
		$aadhar_number = $request->aadhar_number;
		$father_name = $request->father_name;
		$address = $request->current_address;
		$permanent_address = $request->permanent_address;
		$formalities = $request->formalities;
		$offer_acceptance = $request->offer_acceptance;
		$prob_period = $request->probation_period;
		$doc = date_format(date_create($request->date_of_confirmation), 'Y-m-d');
		$department = $request->department;
		$salary = $request->salary;
		$account_number = $request->account_number;
		$bank_name = $request->bank_name;
		$ifsc_code = $request->ifsc_code;
		$pf_account_number = $request->pf_account_number;
		$un_number = $request->un_number;
		$pf_status = $request->pf_status;
		$esic_number = $request->esic_number;

		

		//$edit = Employee::findOrFail($id);
		$edit = Employee::where('user_id', $id)->first();

		if (!empty($photo)) {
			$edit->photo = $photo;
		}
		if (!empty($emp_name)) {
			$edit->name = $emp_name;
		}
		if (!empty($personal_email)) {
			$edit->personal_email = $personal_email;
		}
		if (!empty($emp_code)) {
			$edit->code = $emp_code;
		}
		if (isset($emp_status)) {
			$edit->status = $emp_status;
		}
		if (isset($emp_role)) {
			$userRole = UserRole::firstOrNew(['user_id' => $edit->user_id]);
			$userRole->role_id = $emp_role;
			$userRole->save();
		}
		if (isset($gender)) {
			$edit->gender = $gender;
		}
		if (!empty($dob)) {
			$edit->date_of_birth = $dob;
		}
		if (!empty($doj)) {
			$edit->date_of_joining = $doj;
		}
		if (!empty($mob_number)) {
			$edit->number = $mob_number;
		}
		if (!empty($qualification)) {
			$edit->qualification = $qualification;
		}
		if (!empty($emer_number)) {
			$edit->emergency_number = $emer_number;
		}
		if (!empty($pan_number)) {
			$edit->pan_number = $pan_number;
		}
		if (!empty($aadhar_number)) {
			$edit->aadhar_number = $aadhar_number;
		}
		if (!empty($father_name)) {
			$edit->father_name = $father_name;
		}
		if (!empty($address)) {
			$edit->current_address = $address;
		}
		if (!empty($permanent_address)) {
			$edit->permanent_address = $permanent_address;
		}

		if (isset($formalities)) {
			$edit->formalities = $formalities;
		}
		if (isset($offer_acceptance)) {
			$edit->offer_acceptance = $offer_acceptance;
		}
		if (!empty($prob_period)) {
			$edit->probation_period = $prob_period;
		}
		if (!empty($doc)) {
			$edit->date_of_confirmation = $doc;
		}
		if (!empty($department)) {
			$edit->department = $department;
		}
		if (!empty($salary)) {
			$edit->salary = $salary;
		}
		if (!empty($account_number)) {
			$edit->account_number = $account_number;
		}
		if (!empty($bank_name)) {
			$edit->bank_name = $bank_name;
		}
		if (!empty($ifsc_code)) {
			$edit->ifsc_code = $ifsc_code;
		}
		if (!empty($pf_account_number)) {
			$edit->pf_account_number = $pf_account_number;
		}
		if (!empty($un_number)) {
			$edit->un_number = $un_number;
		}
		if (!empty($esic_number)) {
			$edit->esic_number = $esic_number;
		}
		if (isset($pf_status)) {
			$edit->pf_status = $pf_status;
		}
	

		$edit->save();
		return json_encode(['title' => 'Success', 'message' => 'Employee details successfully updated', 'class' => 'modal-header-success']);
	}

	public function doDelete($id) {

		$emp = User::find($id);
		$emp->delete();

		\Session::flash('flash_message', 'Employee successfully Deleted!');

		return redirect()->back();
	}

	public function importFile() {
		return view('hrms.employee.upload');
	}

	public function uploadFile(Request $request) {
		$files = Input::file('upload_file');

		/* try {*/
		foreach ($files as $file) {
			Excel::load($file, function ($reader) {
				$rows =$reader->get( ['role','email','personal_email','code','name','status','gender','date_of_birth','date_of_joining','mobile_number','qualification',
				'pan_number','aadhar_number','father_name','emergency_number','current_address','permanent_address','formalities','offer_acceptance',
				'probation_period','date_of_confirmation','department',
				'salary','account_number', 'bank_name','ifsc_code','pf_account_number','un_number','esic_number',
				'pf_status']);
			
				foreach ($rows as $row) {
					// \Log::info($row->name);
					if (Employee::where('code', '=', $row->code)->exists()) {
						$emp = Employee::where('code', '=', $row->code)->first();
						$id=  $emp->user_id;
						$emp_name = $row->name;
						$emp_code = $row->code;
						$emp_email = $row->email;
						$personal_email = $row->personal_email;
				
						
						$emp_status = $row->status;
						$emp_role = $row->role;
						$gender = $row->gender;
						$dob = date_format(date_create($row->date_of_birth), 'Y-m-d');
						$doj = date_format(date_create($row->date_of_joining), 'Y-m-d');
						$mob_number = $row->mobile_number;
						$qualification = $row->qualification;
						$emer_number = $row->emergency_number;
						$pan_number = $row->pan_number;
						$aadhar_number = $row->aadhar_number;
						$father_name = $row->father_name;
						$address = $row->current_address;
						$permanent_address = $row->permanent_address;
						$formalities = $row->formalities;
						$offer_acceptance = $row->offer_acceptance;
						$prob_period = $row->probation_period;
						$doc = date_format(date_create($row->date_of_confirmation), 'Y-m-d');
						$department = $row->department;
						$salary = $row->salary;
						$account_number = $row->account_number;
						$bank_name = $row->bank_name;
						$ifsc_code = $row->ifsc_code;
						$pf_account_number = $row->pf_account_number;
						$un_number = $row->un_number;
						$pf_status = $row->pf_status;
						$esic_number = $row->esic_number;
						$int=intval($mob_number);
						$gettype=gettype($mob_number);
							// \Log::info($gettype);
						if ($emp_email != "") {
							$user = User::where('id', $id)->first();
							$user->email = $emp_email;
							$user->name = $emp_name;
							$user->save();
						}
						//$edit = Employee::findOrFail($id);
						$edit = Employee::where('code', $emp_code)->first();
							if (!empty($mob_number)) {
							if($gettype == "double"){
								$edit->number = $mob_number;
								// \Log::info($int);
							}else {
							// \Log::info($int);
								\Session::flash('success', 'Please enter only Numberic value in mobile number');
								return redirect()->back();
							}
						}
						// if (!empty($photo)) {
						// 	$edit->photo = $photo;
						// }
						if (!empty($emp_name)) {
							$edit->name = $emp_name;
						}
						if (!empty($personal_email)) {
							$edit->personal_email = $personal_email;
						}
						if (!empty($emp_code)) {
							$edit->code = $emp_code;
						}
						if (isset($emp_status)) {
							$edit->status = $emp_status;
						}
						if (isset($emp_role)) {
							$userRole = UserRole::firstOrNew(['user_id' => $edit->user_id]);
							$userRole->role_id = $emp_role;
							$userRole->save();
						}
						if (isset($gender)) {
							$edit->gender = $gender;
						}
						if (!empty($dob)) {
							$edit->date_of_birth = $dob;
						}
						if (!empty($doj)) {
							$edit->date_of_joining = $doj;
						}
						if (!empty($mob_number)) {
							$edit->number = $mob_number;
						}
						if (!empty($qualification)) {
							$edit->qualification = $qualification;
						}
						if (!empty($emer_number)) {
							$edit->emergency_number = $emer_number;
						}
						if (!empty($pan_number)) {
							$edit->pan_number = $pan_number;
						}
						if (!empty($aadhar_number)) {
							$edit->aadhar_number = $aadhar_number;
						}
						if (!empty($father_name)) {
							$edit->father_name = $father_name;
						}
						if (!empty($address)) {
							$edit->current_address = $address;
						}
						if (!empty($permanent_address)) {
							$edit->permanent_address = $permanent_address;
						}
				
						if (isset($formalities)) {
							$edit->formalities = $formalities;
						}
						if (isset($offer_acceptance)) {
							$edit->offer_acceptance = $offer_acceptance;
						}
						if (!empty($prob_period)) {
							$edit->probation_period = $prob_period;
						}
						if (!empty($doc)) {
							$edit->date_of_confirmation = $doc;
						}
						if (!empty($department)) {
							$edit->department = $department;
						}
						if (!empty($salary)) {
							$edit->salary = $salary;
						}
						if (!empty($account_number)) {
							$edit->account_number = $account_number;
						}
						if (!empty($bank_name)) {
							$edit->bank_name = $bank_name;
						}
						if (!empty($ifsc_code)) {
							$edit->ifsc_code = $ifsc_code;
						}
						if (!empty($pf_account_number)) {
							$edit->pf_account_number = $pf_account_number;
						}
						if (!empty($un_number)) {
							$edit->un_number = $un_number;
						}
						if (!empty($esic_number)) {
							$edit->esic_number = $esic_number;
						}
						if (isset($pf_status)) {
							$edit->pf_status = $pf_status;
						}
						$edit->save();
						\Session::flash('success', ' Employee details updated successfully.');
					}else{
						$user = new User;
						$user->name = $row->name;
						$user->email = str_replace(' ', '_', $row->email);
						$user->password = bcrypt('123456');
						$user->save();
						$emp = new Employee;
						// $emp->photo = $filename;
						$emp->name = $row->name;
						$emp->personal_email = $row->personal_email;
						$emp->code = $row->code;
						$emp->status = $row->status;
						$emp->gender = $row->gender;
						$emp->date_of_birth = date_format(date_create($row->dob), 'Y-m-d');
						$emp->date_of_joining = date_format(date_create($row->doj), 'Y-m-d');
						$emp->number = $row->mobile_number;
						$emp->qualification = $row->qualification;
						$emp->emergency_number = $row->emergency_number;
						$emp->pan_number = $row->pan_number;
						$emp->aadhar_number = $row->aadhar_number;
						$emp->esic_number = $row->esic_number;
						$emp->father_name = $row->father_name;
						$emp->current_address = $row->current_address;
						$emp->permanent_address = $row->permanent_address;
						$emp->formalities = $row->formalities;
						$emp->offer_acceptance = $row->offer_acceptance;
						$emp->probation_period = $row->probation_period;
						$emp->date_of_confirmation = date_format(date_create($row->date_of_confirmation), 'Y-m-d');
						$emp->department = $row->department;
						$emp->salary = $row->salary;
						$emp->account_number = $row->account_number;
						$emp->bank_name = $row->bank_name;
						$emp->ifsc_code = $row->ifsc_code;
						$emp->pf_account_number = $row->pf_account_number;
						$emp->un_number = $row->un_number;
						$emp->pf_status = $row->pf_status;
						$emp->user_id = $user->id;
						$emp->save();
						$userRole = new UserRole();
						$userRole->role_id = $row->role;
						$userRole->user_id = $user->id;
						$userRole->save();
						\Session::flash('success', ' Employee details uploaded successfully.');
					}
				}

				return 1;
				//return redirect('upload_form');*/
			}
			);

		}
		/*catch (\Exception $e) {
           return $e->getMessage();*/

		// \Session::flash('success', ' Employee details uploaded successfully.');

		return redirect()->back();
	}

	public function searchEmployee(Request $request) {
		$string = $request->string;
		$column = $request->column;

		if ($request->button == 'Search') {
			if ($string == '' && $column == '') {
				\Session::flash('success', ' Employee details uploaded successfully.');
				return redirect()->to('employee-manager');
			} elseif ($string != '' && $column == '') {
				\Session::flash('failed', ' Please select category.');
				return redirect()->to('employee-manager');
			} elseif ($column == 'email') {
				$emps = User::with('employee')->where($column, 'like', "%$string%")->paginate(20);
			} else {
				$emps = User::whereHas('employee', function ($q) use ($column, $string) {
					$q->whereRaw($column . " like '%" . $string . "%'");
				}
				)->with('employee')->paginate(20);
			}

			return view('hrms.employee.show_emp', compact('emps', 'column', 'string'));
		} else {
			if ($column == '') {
				$emps = User::with('employee' , 'role.role')->get();
			} elseif ($column == 'email') {
				$emps = User::with('employee' , 'role.role')->where($request->column, $request->string)->paginate(20);
			} else {
				$emps = User::whereHas('employee', function ($q) use ($column, $string) {
					$q->whereRaw($column . " like '%" . $string . "%'");
				}
				)->with('employee','role.role')->get();
			}

			$fileName = 'Employee_Listing_' . rand(1, 1000) . '.csv';
			$filePath = storage_path('export/') . $fileName;
			$file = new \SplFileObject($filePath, "a");
			// Add header to csv file.
			// $headers = ['id','email','photo', 'code', 'name', 'status', 'gender', 'date_of_birth', 'date_of_joining', 'number', 'qualification', 'emergency_number', 'pan_number', 'father_name', 'current_address', 'permanent_address', 'formalities', 'offer_acceptance', 'probation_period', 'date_of_confirmation', 'department', 'salary', 'account_number', 'bank_name', 'ifsc_code', 'pf_account_number', 'un_number', 'pf_status', 'user_id', 'created_at', 'updated_at'];
			$headers = ['User id',' Employee id','role','photo','email','personal_email','code','name','status','gender','date_of_birth','date_of_joining','number','qualification',
			'pan_number','aadhar_number','father_name','emergency_number','current_address','permanent_address','formalities','offer_acceptance',
			'probation_period','date_of_confirmation','department',
			'salary','account_number', 'bank_name','ifsc_code','pf_account_number','un_number','esic_number',
			'pf_status','created_at','updated_at'];
		
			
			$file->fputcsv($headers);
			foreach ($emps as $emp) {
				$file->fputcsv([
					$emp->id,
					$emp->employee->id,
					$emp->role->role->name,


					(
						$emp->employee->photo) ? $emp->employee->photo : 'Not available',
					$emp->email,
					$emp->employee->personal_email,
					$emp->employee->code,
					$emp->employee->name,
					getSatus($emp->employee->status),
					getGender($emp->employee->gender),
					$emp->employee->date_of_birth,
					$emp->employee->date_of_joining,
					$emp->employee->number,
					$emp->employee->qualification,
					$emp->employee->pan_number,
					$emp->employee->aadhar_number,
					$emp->employee->father_name,
					$emp->employee->emergency_number,
					$emp->employee->current_address,
					$emp->employee->permanent_address,
					getFormality($emp->employee->formalities),
					getOffer($emp->employee->offer_acceptance),
					$emp->employee->probation_period,
					$emp->employee->date_of_confirmation,
					$emp->employee->department,
					$emp->employee->salary,
					$emp->employee->account_number,
					$emp->employee->bank_name,
					$emp->employee->ifsc_code,
					$emp->employee->pf_account_number,
					$emp->employee->un_number,
					$emp->employee->esic_number,
					getPfStatus($emp->employee->pf_status),
					$emp->employee->created_at,
					$emp->employee->updated_at,
				]
				);
			}

			return response()->download(storage_path('export/') . $fileName);
		}
	}

	public function showDetails() {
		$emps = User::with('employee')->paginate(15);

		return view('hrms.employee.show_bank_detail', compact('emps'));
	}

	public function updateAccountDetail(Request $request) {
		try {
			$model = Employee::where('id', $request->employee_id)->first();
			$model->bank_name = $request->bank_name;
			$model->account_number = $request->account_number;
			$model->ifsc_code = $request->ifsc_code;
			$model->pf_account_number = $request->pf_account_number;
			$model->save();

			return json_encode('success');
		} catch (\Exception $e) {
			\Log::info($e->getMessage() . ' on ' . $e->getLine() . ' in ' . $e->getFile());

			return json_encode('failed');
		}

	}

	public function doPromotion() {
		$emps = User::get();
		$roles = Role::get();

		return view('hrms.promotion.add_promotion', compact('emps', 'roles'));
	}

	public function getPromotionData(Request $request) {
		$result = Employee::with('userrole.role')->where('id', $request->employee_id)->first();
		if ($result) {
			$result = ['salary' => $result->salary, 'designation' => $result->userrole->role->name];
		}

		return json_encode(['status' => 'success', 'data' => $result]);
	}

	public function processPromotion(Request $request) {

		$newDesignation = Role::where('id', $request->new_designation)->first();
		$process = Employee::where('id', $request->emp_id)->first();
		$process->salary = $request->new_salary;
		$process->save();

		\DB::table('user_roles')->where('user_id', $process->user_id)->update(['role_id' => $request->new_designation]);

		$promotion = new Promotion();
		$promotion->emp_id = $request->emp_id;
		$promotion->old_designation = $request->old_designation;
		$promotion->new_designation = $newDesignation->name;
		$promotion->old_salary = $request->old_salary;
		$promotion->new_salary = $request->new_salary;
		$promotion->date_of_promotion = date_format(date_create($request->date_of_promotion), 'Y-m-d');
		$promotion->save();

		\Session::flash('flash_message', 'Employee successfully Promoted!');

		return redirect()->back();
	}

	public function showPromotion() {
		$promotions = Promotion::with('employee')->paginate(10);

		return view('hrms.promotion.show_promotion', compact('promotions'));
	}

}
