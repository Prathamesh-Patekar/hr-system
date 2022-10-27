
@extends('hrms.layouts.base')

@section('content')
<div>
    <br>
    <div>   
        <div class="panel-heading">
         <strong> <span class="panel-title"><b> Personal Details</b></span></strong> 
        </div>           
        <table class="table">
            <tbody>
                <tr>
                    <td style="width: 10px" class="text-center">
                    </td>
                    <td><strong>Employee Code</strong></td>
                    <td>{{$emps->employee->code}}</td>
                </tr>
                <tr>
                    <td style="width: 10px" class="text-center">
                    </td>
                    <td><strong>First Name</strong></td>
                    <td>{{ $emps->employee->name}}</td>
                </tr> 
                <tr>
                    <td style="width: 10px" class="text-center">
                    </td>
                    <td><strong>Middle Name</strong></td>
                    <td>{{ $emps->employee->mname}}</td>
                </tr>
                <tr>
                    <td style="width: 10px" class="text-center">
                    </td>
                    <td><strong>Last Name</strong></td>
                    <td>{{ $emps->employee->lname}}</td>
                </tr>
                <tr>
                    <td class="text-center"></td>
                    <td><strong>Designation</strong></td>
                    <td>{{isset($emps->role->role->name)?$emps->role->role->name:''}}</td>
                </tr>
            
                <tr>
                    <td style="width: 10px" class="text-center">
                    </td>
                    <td><strong>Employee Work Email</strong></td>
                    <td>{{ $emps->email}}</td>

            
                </tr>
                <tr>
                    <td style="width: 10px" class="text-center">
                    </td>
                    <td><strong>Employee Personal Email</strong></td>
                    <td>{{ $emps->employee->personal_email}}</td>
                </tr>
                <tr>
                    <td style="width: 10px" class="text-center">
                    </td>
                    <td><strong>Mobile Number</strong></td>
                    <td>{{$emps->employee->number}}</td>
                </tr>
                <tr>
                    <td style="width: 10px" class="text-center">
                    </td>
                    <td><strong>Alternative Mobile Number</strong></td>
                    <td>{{$emps->employee->mnumber_two}}</td>
                </tr>
           
                <tr>
                    <td style="width: 10px" class="text-center">
                    </td>
                    <td><strong>Employee Status</strong></td>
                    <td>{{getSatus($emps->employee->status)}}</td>
                </tr>
                <tr>
                    <td style="width: 10px" class="text-center">
                    </td>
                    <td><strong>Employee Gender</strong></td>
                    <td>{{getGender($emps->employee->gender)}}</td>
                </tr>
                <tr>
                    <td style="width: 10px" class="text-center">
                    </td>
                    <td><strong>Date of Birth</strong></td>
                    <td>{{$emps->employee->date_of_birth}}</td>
                </tr>
                <tr>
                    <td style="width: 10px" class="text-center">
                    </td>
                    <td><strong>Date of Joining</strong></td>
                    <td>{{$emps->employee->date_of_joining}}</td>
                </tr>
          
                <tr>
                    <td style="width: 10px" class="text-center">
                    </td>
                    <td><strong>Qualification</strong></td>
                    <td>{{$emps->employee->qualification}}</td>
                </tr>
                <tr>
                    <td style="width: 10px" class="text-center">
                    </td>
                    <td><strong>PAN Number</strong></td>
                    <td>{{$emps->employee->pan_number}}</td>
                </tr>
                <tr>
                    <td style="width: 10px" class="text-center">
                    </td>
                    <td><strong>Aadhar Number</strong></td>
                    <td>{{$emps->employee->aadhar_number}}</td>
                </tr>
                <tr>
                    <td style="width: 10px" class="text-center">
                    </td>
                    <td><strong>Father's Name</strong></td>
                    <td>{{$emps->employee->father_name}}</td>
                </tr>
                <tr>
                    <td style="width: 10px" class="text-center">
                    </td>
                    <td><strong>Emergency Contact Person Name </strong></td>
                    <td>{{$emps->employee->emerg_name}}</td>
                </tr>
                <tr>
                    <td style="width: 10px" class="text-center">
                    </td>
                    <td><strong>Emergency Contact Person Relation</strong></td>
                    <td>{{$emps->employee->emerg_rel}}</td>
                </tr>
            
                <tr>
                    <td style="width: 10px" class="text-center">
                    </td>
                    <td><strong>Emergency Number</strong></td>
                    <td>{{$emps->employee->emergency_number}}</td>
                </tr>
                <tr>
                    <td style="width: 10px" class="text-center">
                    </td>
                    <td><strong>Current Address</strong></td>
                    <td>{{$emps->employee->current_address}}</td>
                </tr>
                <tr>
                    <td style="width: 10px" class="text-center">
                    </td>
                    <td><strong>Permanent Address</strong></td>
                    <td>{{$emps->employee->permanent_address}}</td>
                </tr>
                <tr>
                    <td style="width: 10px" class="text-center">
                    </td>
                    <td><strong>Emergency Number</strong></td>
                    <td>{{$emps->employee->emergency_number}}</td>
                </tr>
                
            </tbody>
        </table>
    </div><br>
    <div>
        <div class="panel-heading">
            <span class="panel-title">Employment Details</span>
        </div>
        <table class="table">
            <tbody>
            <tr>
                <td class="text-center"></td>
                <td><strong>Designation</strong></td>
                <td>{{isset($emps->role->role->name)?$emps->role->role->name:''}}</td>
            </tr>
            <tr>
                <td style="width: 10px" class="text-center"></td>
                <td><strong>Employee ID</strong></td>
                <td>{{$emps->employee->code}}</td>
            </tr>
             <tr>
                <td style="width: 10px" class="text-center">
                </td>
                <td><strong>Employee status</strong></td>
                <td>{{getSatus($emps->employee->status)}}</td>
            </tr>
           <tr>
                <td class="text-center"></td>
                    <td><strong>Joining Formalities</strong></td>
                <td>{{getFormality($emps->employee->formalities)}}</td>
            </tr>
            <tr>
                <td class="text-center"></td>
                        <td><strong>Offer Acceptance</strong></td>
                <td>{{getOffer($emps->employee->formalities)}}</td>
            </tr>  
            <tr>
                <td style="width: 10px" class="text-center">
                </td>
                <td><strong>Probation Period</strong></td>
                <td>{{isset($emps->employee->probation_period) ? $emps->employee->probation_period:''}}</td>
            </tr>
            <tr>
                <td class="text-center"></td>
                <td><strong>Date Joined</strong></td>
                <td>{{$emps->employee->date_of_joining}}</td>
            </tr>
            <tr>
                <td class="text-center"></td>
                <td><strong>Date Confirmed</strong></td>
                <td>{{$emps->employee->date_of_confirmation}}</td>
            </tr>
            <tr>
                <td class="text-center"></td>
                <td><strong>Department</strong></td>
                <td>{{$emps->employee->department}}</td>
            </tr>
         
            <tr>
                <td class="text-center"></td>
                <td><strong>Salary</strong></td>
                <td>{{$emps->employee->salary}}</td>
            </tr>
            </tbody>
        </table>
    </div><br>
    <div>
        <div class="panel-heading">
            <span class="panel-title">Banking Details</span>
        </div>
        <table class="table">
            <tbody>
            <tr>
                <td style="width: 10px" class="text-center"></td>
                <td><strong>Account Number</strong></td>
                <td>{{isset($emps->employee->account_number) ? $emps->employee->account_number:''}}</td>
            </tr>
            <tr>
                <td style="width: 10px" class="text-center"></td>
                <td><strong>Bank Name</strong></td>
                <td>{{isset($emps->employee->bank_name) ? $emps->employee->bank_name: ''}}</td>
            </tr>
            <tr>
                <td style="width: 10px" class="text-center"></td>
                <td><strong>Ifsc Code</strong></td>
                <td>{{isset($emps->employee->ifsc_code) ? $emps->employee->ifsc_code: ''}} </td>
            </tr>
            <tr>
                <td style="width: 10px" class="text-center"></td>
                <td><strong>Pf Account Number</strong></td>
                <td>{{isset($emps->employee->pf_account_number) ? $emps->employee->pf_account_number:''}}</td>
            </tr>
            <tr>
                <td class="text-center"></td>
                <td><strong> PF Status</strong></td>
                <td>{{getPfStatus($emps->employee->pf_status)}}</td>
            </tr>
            
            <tr>
                <td style="width: 10px" class="text-center"></td>
                <td><strong>Un Number</strong></td>
                <td>{{isset($emps->employee->un_number) ? $emps->employee->un_number:''}}</td>
            </tr>
            <tr>
                <td style="width: 10px" class="text-center">
                </td>
                <td><strong>ESIC Number</strong></td>
                <td>{{isset($emps->employee->esic_number) ? $emps->employee->esic_number:''}}</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
