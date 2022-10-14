<pre>
    var_dump({{$find}})
</pre>

@extends('hrms.layouts.base')

@section('content')

<div>
    <div class="panel-heading">
        <span class="panel-title">Personal Details</span>
    </div>
    <table class="table">
        <tbody>
            <tr>
                <td style="width: 10px" class="text-center"><i class="fa fa-birthday-cake"></i>
                </td>
                <td><strong>Name</strong></td>
                <td>{{$find['name']}}</td>
            </tr>
            <tr>
                <td style="width: 10px" class="text-center"><i class="fa fa-birthday-cake"></i>
                </td>
                <td><strong>Name</strong></td>
                <td>{{$find['name']}}</td>
            </tr>
            <tr>
                <td style="width: 10px" class="text-center"><i class="fa fa-birthday-cake"></i>
                </td>
                <td><strong>Employee Personal Email</strong></td>
                <td>{{$find['personal_email']}}</td>
            </tr>
            <tr>
                <td style="width: 10px" class="text-center"><i class="fa fa-birthday-cake"></i>
                </td>
                <td><strong>Employee Personal Email</strong></td>
                <td>{{$find['personal_email']}}</td>
            </tr>
            <tr>
                <td style="width: 10px" class="text-center"><i class="fa fa-birthday-cake"></i>
                </td>
                <td><strong>Employee Code</strong></td>
                <td>{{$find['code']}}</td>
            </tr>
            <tr>
                <td style="width: 10px" class="text-center"><i class="fa fa-birthday-cake"></i>
                </td>
                <td><strong>Employee Status</strong></td>
                <td>{{getSatus($find['status'])}}</td>
            </tr>
            <tr>
                <td style="width: 10px" class="text-center"><i class="fa fa-birthday-cake"></i>
                </td>
                <td><strong>Employee Gender</strong></td>
                <td>{{getGender($find['gender'])}}</td>
            </tr>
            <tr>
                <td style="width: 10px" class="text-center"><i class="fa fa-birthday-cake"></i>
                </td>
                <td><strong>Date of Birth</strong></td>
                <td>{{$find['date_of_birth']}}</td>
            </tr>
            <tr>
                <td style="width: 10px" class="text-center"><i class="fa fa-birthday-cake"></i>
                </td>
                <td><strong>Date of Joining</strong></td>
                <td>{{$find['date_of_joining']}}</td>
            </tr>
            <tr>
                <td style="width: 10px" class="text-center"><i class="fa fa-birthday-cake"></i>
                </td>
                <td><strong>Mobile Number</strong></td>
                <td>{{$find['number']}}</td>
            </tr>
            <tr>
                <td style="width: 10px" class="text-center"><i class="fa fa-birthday-cake"></i>
                </td>
                <td><strong>Qualification</strong></td>
                <td>{{$find['qualification']}}</td>
            </tr>
            <tr>
                <td style="width: 10px" class="text-center"><i class="fa fa-birthday-cake"></i>
                </td>
                <td><strong>PAN Number</strong></td>
                <td>{{$find['pan_number']}}</td>
            </tr>
            <tr>
                <td style="width: 10px" class="text-center"><i class="fa fa-birthday-cake"></i>
                </td>
                <td><strong>Aadhar Number</strong></td>
                <td>{{$find['aadhar_number']}}</td>
            </tr>
            <tr>
                <td style="width: 10px" class="text-center"><i class="fa fa-birthday-cake"></i>
                </td>
                <td><strong>Father's Name</strong></td>
                <td>{{$find['father_name']}}</td>
            </tr>
            <tr>
                <td style="width: 10px" class="text-center"><i class="fa fa-birthday-cake"></i>
                </td>
                <td><strong>Father's Name</strong></td>
                <td>{{$find['father_name']}}</td>
            </tr>
            <tr>
                <td style="width: 10px" class="text-center"><i class="fa fa-birthday-cake"></i>
                </td>
                <td><strong>Emergency Number</strong></td>
                <td>{{$find['emergency_number']}}</td>
            </tr>
            <tr>
                <td style="width: 10px" class="text-center"><i class="fa fa-birthday-cake"></i>
                </td>
                <td><strong>Current Address</strong></td>
                <td>{{$find['current_address']}}</td>
            </tr>
            <tr>
                <td style="width: 10px" class="text-center"><i class="fa fa-birthday-cake"></i>
                </td>
                <td><strong>Permanent Address</strong></td>
                <td>{{$find['permanent_address']}}</td>
            </tr>
            <tr>
                <td style="width: 10px" class="text-center"><i class="fa fa-birthday-cake"></i>
                </td>
                <td><strong>Emergency Number</strong></td>
                <td>{{$find['emergency_number']}}</td>
            </tr>
            
        </tbody>
    </table>
</div>

<div>
    <div class="panel-heading">
        <span class="panel-title">Employment Details</span>
    </div>
    <table class="table">
        <tbody>
        <tr>
            <td style="width: 10px" class="text-center"><i class="fa fa-key"></i></td>
            <td><strong>Employee ID</strong></td>
            <td>{{$find->code}}</td>
        </tr>
        <tr>
            <td style="width: 10px" class="text-center"><i class="fa fa-genderless"></i>
            </td>
            <td><strong>Employee status</strong></td>
            <td>{{getSatus($find->status)}}</td>
        </tr>
        <tr>
            <td class="text-center"><i class="fa fa-calendar"></i></td>
                <td><strong>Joining Formalities</strong></td>
            <td>{{getFormality($find->formalities)}}</td>
        </tr>
        <tr>
            <td class="text-center"><i class="fa fa-calendar"></i></td>
                    <td><strong>Offer Acceptance</strong></td>
            <td>{{getOffer($find->formalities)}}</td>
        </tr> 
        <tr>
            <td style="width: 10px" class="text-center"><i class="fa fa-genderless"></i>
            </td>
            <td><strong>Probation Period</strong></td>
            <td>{{isset($find->probation_period) ? $find->probation_period:''}}</td>
        </tr>
        <tr>
            <td class="text-center"><i class="fa fa-calendar"></i></td>
            <td><strong>Date Joined</strong></td>
            <td>{{$find->date_of_joining}}</td>
        </tr>
        <tr>
            <td class="text-center"><i class="fa fa-calendar"></i></td>
            <td><strong>Date Confirmed</strong></td>
            <td>{{$find->date_of_confirmation}}</td>
        </tr>
        <tr>
            <td class="text-center"><i class="fa fa-briefcase"></i></td>
            <td><strong>Department</strong></td>
            <td>{{$find->department}}</td>
        </tr>
        <!-- <tr>
            <td class="text-center"><i class="fa fa-cubes"></i></td>
            <td><strong>Designation</strong></td>
            <td>{{isset($find->userrole->role->name)?$find->userrole->role->name:''}}</td>
        </tr> -->

        <tr>
            <td class="text-center"><i class="fa fa-credit-card"></i></td>
            <td><strong>Salary</strong></td>
            <td>{{$find->salary}}</td>
        </tr>
        </tbody>
    </table>
</div>

<div>
    <div class="panel-heading">
        <span class="panel-title">Banking Details</span>
    </div>
    <table class="table">
        <tbody>
        <tr>
            <td style="width: 10px" class="text-center"><i class="fa fa-credit-card"></i></td>
            <td><strong>Account Number</strong></td>
            <td>{{isset($find->account_number) ? $find->account_number:''}}</td>
        </tr>
        <tr>
            <td style="width: 10px" class="text-center"><i class="fa fa-bank"></i></td>
            <td><strong>Bank Name</strong></td>
            <td>{{isset($find->bank_name) ? $find->bank_name: ''}}</td>
        </tr>
        <tr>
            <td style="width: 10px" class="text-center"><i class="fa fa-code"></i></td>
            <td><strong>Ifsc Code</strong></td>
            <td>{{isset($find->ifsc_code) ? $find->ifsc_code: ''}} </td>
        </tr>
        <tr>
            <td style="width: 10px" class="text-center"><i class="fa fa-tags"></i></td>
            <td><strong>Pf Account Number</strong></td>
            <td>{{isset($find->pf_account_number) ? $find->pf_account_number:''}}</td>
        </tr>
        <tr>
            <td class="text-center"><i class="fa fa-calendar"></i></td>
            <td><strong> PF Status</strong></td>
            <td>{{getPfStatus($find->pf_status)}}</td>
        </tr>
        
        <tr>
            <td style="width: 10px" class="text-center"><i class="fa fa-tags"></i></td>
            <td><strong>Un Number</strong></td>
            <td>{{isset($find->un_number) ? $find->un_number:''}}</td>
        </tr>
        <tr>
            <td style="width: 10px" class="text-center"><i class="fa fa-tags"></i>
            </td>
            <td><strong>ESIC Number</strong></td>
            <td>{{isset($find->esic_number) ? $find->esic_number:''}}</td>
        </tr>
        </tbody>
    </table>
</div>
@endsection