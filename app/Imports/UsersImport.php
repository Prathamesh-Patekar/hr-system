<?php

namespace App\Imports;
use App\Models\Employee;
use App\Models\Role;
use App\Models\UserRole;
use App\User;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class UsersImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            if ($code=Employee::where('code', '=', $row['code'])->exists() ) {
                \Log::info($code);
                $emp = Employee::where('code', '=', $row['code'])->first();
                $id=  $emp->user_id;
                $emp_name=  $row['first_name'];
                $emp_email= $row['email'];
                $middle_name=$row['middle_name'];
                $last_name=  $row['last_name'];
                $personal_email=$row['personal_email'];
                $emp_code=  $row['code'];
                $emp_status= $row['status'];
                $gender=  $row['gender'];
                $dob= \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['date_of_birth'])->format('Y-m-d');
                $doj= \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['date_of_joining'])->format('Y-m-d') ;
                $mob_number=  $row['mobile_number'];
                $alt_mobile_number=   $row['alt_mobile_number'];
                $qualification=  $row['qualification'];
                $emerg_name=  $row['emerg_name'];
                $emerg_rel= $row['emerg_rel'];
                $emer_number=$row['emerg_rel'];
                $pan_number=  $row['pan_number'];
                $aadhar_number=  $row['aadhar_number'];
                $esic_number=$row['esic_number'];
                $father_name=$row['father_name'];
                $address=  $row['current_address'];
                $permanent_address= $row['permanent_address'];
                $formalities=$row['formalities'];
                $offer_acceptance=  $row['offer_acceptance'];
                $prob_period=   $row['probation_period'];
                $doc=\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['date_of_confirmation'])->format('Y-m-d') ;
                $department=  $row['department'];
                $salary=  $row['salary'];
                $account_number= $row['account_number'];
                $bank_name= $row['bank_name'];
                $ifsc_code=  $row['ifsc_code'];
                $pf_account_number= $row['pf_account_number'];
                $un_number= $row['un_number'];
                $esic_number=  $row['esic_number'];
                $pf_status=  $row['pf_status'];
                // $int=intval($mob_number);
                // $gettype=gettype($mob_number);
                    // \Log::info($gettype);
                if ($emp_email != "") {
                    $user = User::where('id', $id)->first();
                    $user->email = $emp_email;
                    $user->name = $emp_name;
                    $user->save();
                }
                $edit = Employee::where('code', $emp_code)->first();
                				// if (!empty($mob_number)) {
                				// if($gettype == "double"){
                				// 	$edit->number = $mob_number;
                					// \Log::info($int);
                			// 	}else {
                			// 	// \Log::info($int);
                			// 		\Session::flash('success', 'Please enter only Numberic value in mobile number');
                			// 		return redirect()->back();
                			// 	}
                			// }
                			// if (!empty($photo)) {
                			// 	$edit->photo = $photo;
                			// }
                            if (!empty($mob_number)) {
                				$edit->number = $mob_number;
                			}
                			if (!empty($emp_name)) {
                				$edit->name = $emp_name;
                			}
                			if (!empty($middle_name)) {
                				$edit->mname = $middle_name;
                			}if (!empty($last_name)) {
                				$edit->lname = $last_name;
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
                			if (!empty($alt_mobile_number)) {
                				$edit->mnumber_two = $alt_mobile_number;
                			}
                			if (!empty($qualification)) {
                				$edit->qualification = $qualification;
                			}
                			if (!empty($emerg_name)) {
                				$edit->emerg_name = $emerg_name;
                			}	if (!empty($emerg_rel)) {
                				$edit->emerg_rel = $emerg_rel;
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
                $user = User::create([
                    'name' => $row['first_name'],
                    'email'    => $row['email'],
                    'password' =>  bcrypt('123456'),
                ]);
                Employee::create([
                    'name'  => $row['first_name'],
                    'mname' => $row['middle_name'] ,
                    'lname' => $row['last_name']   ,
                    'personal_email' => $row['personal_email']  ,
                    'code'  => $row['code']   ,
                    'status' => $row['status']   ,
                    'gender'  => $row['gender']  ,
                    'date_of_birth' =>\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['date_of_birth'])->format('Y-m-d'),
                    'date_of_joining'  => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['date_of_joining'])->format('Y-m-d') ,
                    'number'  => $row['mobile_number']   ,
                    'mnumber_two'  => $row['alt_mobile_number']   ,
                    'qualification'  => $row['qualification']   ,
                    'emerg_name'  => $row['emerg_name']   ,
                    'emerg_rel' => $row['emerg_rel']  ,
                    'emergency_number'=>  $row['emerg_rel']  ,
                    'pan_number' => $row['pan_number']    ,
                    'aadhar_number'  => $row['aadhar_number']   ,
                    'father_name' => $row['father_name']   ,
                    'current_address'  => $row['current_address']   ,
                    'permanent_address' => $row['permanent_address']   ,
                    'offer_acceptance'   => $row['offer_acceptance']  ,
                    'probation_period'   => $row['probation_period']  ,
                    'date_of_confirmation'  =>\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['date_of_confirmation'])->format('Y-m-d'),
                    'department'  => $row['department']   ,
                    'salary'   => $row['salary']  ,
                    'account_number'=> $row['account_number']    ,
                    'bank_name'  => $row['bank_name'] ,
                    'ifsc_code'   => $row['ifsc_code'] ,
                    'pf_account_number'  => $row['pf_account_number']  ,
                    'un_number' => $row['un_number']   ,
                    'esic_number' => $row['esic_number']    ,
                    'pf_status'   => $row['pf_status']  ,
                    'formalities' => $row['formalities']  ,

                    'user_id'=>  $user->id, 

                ]);
                UserRole::create([
                    'user_id' => $user->id,
                    'role_id'=> $row['role']  ,
                        
                ]);
               

            }

           
        }
    }

}
