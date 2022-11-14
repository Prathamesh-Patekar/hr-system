<?php

namespace App\Http\Controllers;

use App\EmployeeLeaves;
use App\Http\Requests;
use App\LeaveDraft;
use App\Models\Employee;
use App\Models\Holiday;
use App\Models\HolidayFilenames;
use App\Models\LeaveType;
use App\Models\Team;
use App\User;
use App\Holiday_employee;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\HolidaysImport;
use App\Http\Controllers\Controller;
use Carbon\Carbon;


class LeaveController extends Controller {
	/**
	 * LeaveController constructor.
	 * @param Mailer $mailer
	 */
	public function __construct(Mailer $mailer) {
		$this->mailer = $mailer;
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function addLeaveType() {
		return view('hrms.leave.add_leave_type');
	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	Public function processLeaveType(Request $request) {
		$leave = new LeaveType;
		$leave->leave_type = $request->leave_type;
		$leave->description = $request->description;
		$leave->save();

		\Session::flash('flash_message', 'Leave Type successfully added!');
		return redirect()->back();

	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function showLeaveType() {
		$leaves = LeaveType::paginate(10);
		return view('hrms.leave.show_leave_type', compact('leaves'));
	}

	/**
	 * @param $id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function showEdit($id) {
		$result = LeaveType::whereid($id)->first();
		return view('hrms.leave.add_leave_type', compact('result'));
	}

	/**
	 * @param Request $request
	 * @param $id
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	Public function doEdit(Request $request, $id) {
		$leave_type = $request->leave_type;
		$description = $request->description;

		$edit = LeaveType::findOrFail($id);
		if (!empty($leave_type)) {
			$edit->leave_type = $leave_type;
		}
		if (!empty($description)) {
			$edit->description = $description;
		}
		$edit->save();

		\Session::flash('flash_message', 'Leave Type successfully updated!');
		return redirect('leave-type-listing');
	}

	/**
	 * @param $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function doDelete($id) {
		$leave = LeaveType::find($id);
		$leave->delete();
		\Session::flash('flash_message1', 'Leave Type successfully Deleted!');
		return redirect('leave-type-listing');
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function doApply() {
		$leaves = LeaveType::get();
		return view('hrms.leave.apply_leave', compact('leaves'));
	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function processApply(Request $request) {
		$days = explode('days leave', $request->number_of_days);
		
		if (sizeof($days) < 2) {
			$days = explode('day leave', $request->number_of_days);
		}
	
		$number_of_days = $this->wordsToNumber($days[0]);

		$leave = new EmployeeLeaves;  

		$team = Team::where('member_id', \Auth::user()->employee->id)->first();
		if ($team) {
			$tl_id = $team->leader_id;
			$manager_id = $team->manager_id;

			$manager = Employee::where('id', $manager_id)->with('user')->first();
			$teamLead = Employee::where('id', $tl_id)->with('user')->first();
			$leave->tl_id = $tl_id;
			$leave->manager_id = $manager_id;

			$emails[] = ['email' => $manager->user->email, 'name' => $manager->user->name];
			$emails[] = ['email' => $teamLead->user->email, 'name' => $teamLead->user->name];
		}																													

		$leave->user_id = \Auth::user()->id;

		$id = \Auth::user()->id;
		$employee = EmployeeLeaves::where(['leave_type_id'=> 2])->first();
		if ($employee){

			// $data = date('l',strtotime($request->dateFrom));
			// if($data == "Monday"){

			// 	$date = new Carbon($request->dateFrom);
			// 	$diff = $date->subDays(3)->toDateString();
			// 	$diff_to =  new Carbon($diff);

			// 	$find = EmployeeLeaves::where(['user_id'=> $id,'date_to' => $diff,'status' => 1])->first();
			// 	\Log::info($find);
				
			// 	if($find){
			// 		$leave->date_from = date('Y-m-d', strtotime($diff_to->addDays(1)->toDateString()));
			// 		$leave->date_to = date('Y-m-d', strtotime($request->dateTo));
			// 		if($request->dateFrom == $request->dateTo){
			// 			$leave->days = $number_of_days + 3;
			// 		}else{
			// 			$leave->days = $number_of_days + 2;
			// 		}
			// 	}else{
			// 		$leave->date_from = date('Y-m-d', strtotime($request->dateFrom));
			// 		$leave->date_to = date('Y-m-d', strtotime($request->dateTo));
			// 		$leave->days = $number_of_days;
			// 	}
			// }else{
						
				$date = new Carbon($request->dateFrom);
				$t1 = Carbon::createFromFormat('H:i', $request->time_from);
				$t2 = Carbon::createFromFormat('H:i', $request->time_to);
				$diff = $t1->diff($t2);
				$hours = $diff->h;
				if($hours > 4 ){

				$diff = $date->subDays(1)->toDateString();
				$diff_to =  new Carbon($diff);

				for($i=0;$i>=0;$i++){
					$holiday = Holiday::where('date_from' , '=', $diff_to)->first();
					
					if($holiday){
						$diff_to =  new Carbon($diff_to);
						$diff_to = $diff_to->subDays(1)->toDateString();
						$pre_date =  new Carbon($diff_to);
						break;
						
					}else{
						$pre_date =  new Carbon($diff_to);
						
						$data = date('l',strtotime($pre_date));
						// echo $diff_to;
						
						
						if($data == 'Sunday'){
							$diff_to = $pre_date->subDays(2)->toDateString();
							// echo $diff_to."<br>";
							$i++;
							continue;
						}else{
							$pre_date;
							// echo $pre_date;
						}
						break;
					}
				}

			// echo $pre_date ."dsafs";
			// 	return ;
				$date_to =  new Carbon($pre_date);
				
				$find = EmployeeLeaves::where(['user_id'=> $id,'date_to' => $date_to ,'status' => 1])->first();

				if($find != ""){

					$t1 = Carbon::createFromFormat('H:i:s',$find->from_time);
					$t2 = Carbon::createFromFormat('H:i:s',$find->to_time);
					$diff = $t1->diff($t2);
					$hours = $diff->h;
					
				
					if($hours > 4){
						$leave->date_from = date('Y-m-d', strtotime($date_to->addDays(1)->toDateString()));
						$leave->date_to = date('Y-m-d', strtotime($request->dateTo));
						$all_dates = array();
						$startDate = new Carbon($leave->date_from);
						$endDate = new Carbon($request->dateTo);

						while (($startDate)->lte($endDate)){
							$all_dates[] =$startDate->toDateString();
							$startDate->addDay();
						}
							$count = count($all_dates);
							$leave->days = $number_of_days + $count;
							

					}
					else{
						$leave->date_from = date('Y-m-d', strtotime($request->dateFrom));
						$leave->date_to = date('Y-m-d', strtotime($request->dateTo));
						$leave->days = $number_of_days;
					}
				}
				else{
					$leave->date_from = date('Y-m-d', strtotime($request->dateFrom));
					$leave->date_to = date('Y-m-d', strtotime($request->dateTo));
					$leave->days = $number_of_days;
				}
			}
			else{
				$leave->date_from = date('Y-m-d', strtotime($request->dateFrom));
				$leave->date_to = date('Y-m-d', strtotime($request->dateTo));
				$leave->days = $number_of_days;
			}
				$leave->from_time = $request->time_from;
				$leave->to_time = $request->time_to;
				$leave->reason = $request->reason;
				$leave->status = '0';
				$leave->leave_type_id = $request->leave_type;
				$leave->save();
		
		}

		$leaveType = LeaveType::where('id', $request->leave_type)->first();

		$emails = ['email' => env('MAIL_USERNAME'), 'name' => env('HR_NAME')];

		$leaveDraft = LeaveDraft::where('leave_type_id', $request->leave_type)->first();

		$subject = isset($leaveDraft->subject) ? $leaveDraft->subject : '';
		$user = \Auth::user();
		$toReplace = ['%name%', '%leave_type%', '%from_date%', '%to_date%', '%days%'];
		$replaceWith = [$user->name, $leaveType->leave_type, $request->dateFrom, $request->dateTo, $number_of_days];
		$body = str_replace($toReplace, $replaceWith, '');


		//now send a mail
		 $this->mailer->send('emails.leave_approval', ['user' => $user], function ($message) use ($emails, $user, $subject) {
	        foreach ($emails as $email) {
	          $message->from($user->email, $user->name);
	          $message->to($emails['email'], $emails['name'])->subject('Request for leave');
	        }
		});


		\Session::flash('flash_message', 'Leave successfully applied!');
		return redirect()->back();
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function showMyLeave() {

		$leaves = EmployeeLeaves::where('user_id', \Auth::user()->id)->paginate(15);
		$showleaves = Holiday_employee::where('user_id', \Auth::user()->id)->get();
		return view('hrms.leave.show_my_leaves', compact('leaves', 'showleaves'));
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function showAllLeave() {
		if (!\Auth::user()->isHR()) {
			$leaves = EmployeeLeaves::with('user.employee')->where('tl_id', \Auth::user()->id)->orWhere('manager_id', \Auth::user()->id)->paginate(15);
		} else {
			$leaves = EmployeeLeaves::with('user.employee')->paginate(15);
		}

		$column = '';
		$string = '';
		$dateFrom = '';
		$dateTo = '';
		return view('hrms.leave.total_leave_request', compact('leaves', 'column', 'string', 'dateFrom', 'dateTo'));
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function showLeaveDraft() {
		$leaves = LeaveType::get();
		return view('hrms.leave.leave_draft', compact('leaves'));
	}

	/**
	 * @param Requests\LeaveDraftRequest $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function createLeaveDraft(Requests\LeaveDraftRequest $request) {
		$draft = new LeaveDraft;
		$draft->subject = $request->subject;
		$draft->body = $request->body;
		$draft->leave_type_id = $request->leave_type;
		$draft->save();

		\Session::flash('flash_message', 'Leave successfully drafted!');
		return redirect()->back();
	}

	function wordsToNumber($data) {
		// Replace all number words with an equivalent numeric value
		$data = strtr(
			$data,
			array(
				'zero' => '0',
				'a' => '1',
				'one' => '1',
				'two' => '2',
				'three' => '3',
				'four' => '4',
				'five' => '5',
				'six' => '6',
				'seven' => '7',
				'eight' => '8',
				'nine' => '9',
				'ten' => '10',
				'eleven' => '11',
				'twelve' => '12',
				'thirteen' => '13',
				'fourteen' => '14',
				'fifteen' => '15',
				'sixteen' => '16',
				'seventeen' => '17',
				'eighteen' => '18',
				'nineteen' => '19',
				'twenty' => '20',
				'thirty' => '30',
				'forty' => '40',
				'fourty' => '40', // common misspelling
				'fifty' => '50',
				'sixty' => '60',
				'seventy' => '70',
				'eighty' => '80',
				'ninety' => '90',
				'hundred' => '100',
				'thousand' => '1000',
				'million' => '1000000',
				'billion' => '1000000000',
				'and' => '',
			)
		);

		// Coerce all tokens to numbers
		$parts = array_map(
			function ($val) {
				return floatval($val);
			},
			preg_split('/[\s-]+/', $data)
		);

		$stack = new \SplStack(); //Current work stack
		$sum = 0; // Running total
		$last = null;

		foreach ($parts as $part) {
			if (!$stack->isEmpty()) {
				// We're part way through a phrase
				if ($stack->top() > $part) {
					// Decreasing step, e.g. from hundreds to ones
					if ($last >= 1000) {
						// If we drop from more than 1000 then we've finished the phrase
						$sum += $stack->pop();
						// This is the first element of a new phrase
						$stack->push($part);
					} else {
						// Drop down from less than 1000, just addition
						// e.g. "seventy one" -> "70 1" -> "70 + 1"
						$stack->push($stack->pop() + $part);
					}
				} else {
					// Increasing step, e.g ones to hundreds
					$stack->push($stack->pop() * $part);
				}
			} else {
				// This is the first element of a new phrase
				$stack->push($part);
			}

			// Store the last processed part
			$last = $part;
		}

		return $sum + $stack->pop();
	}

	public function searchLeave(Request $request) {
		try
		{
			$string = $request->string;
			if ($string == 'Approved' || $string == 'approved') {
				$string = 1;
			} elseif ($string == 'Pending' || $string == 'pending') {
				$string = 0;

			} elseif ($string == 'Disapproved' || $string == 'disapproved') {
				$string = 2;
			}

			$column = $request->column;
			$dateTo = $request->dateTo;
			$dateFrom = $request->dateFrom;
			

			$data = ['name' => 'users.name', 'code' => 'employees.code', 'days' => 'employee_leaves.days', 'leave_type' => 'leave_types.leave_type', 'status' => 'employee_leaves.status'];
			

			if ($request->button == 'Search') {
				/**
				 * First we build a query string which is common in both cases whether we have a condition set or not
				 */
				$leaves = \DB::table('users')->select(
					'users.id', 'users.name', 'employees.code', 'employee_leaves.days', 'employee_leaves.date_from',
					'employee_leaves.date_to', 'employee_leaves.status', 'leave_types.leave_type', 'employee_leaves.remarks')
					->join('employees', 'employees.user_id', '=', 'users.id')
					->join('employee_leaves', 'employee_leaves.user_id', '=', 'users.id')
					->join('leave_types', 'leave_types.id', '=', 'employee_leaves.leave_type_id');
				if (!empty($column) && !empty($string) && empty($dateFrom) && empty($dateTo)) {
					$leaves = $leaves->whereRaw($data[$column] . " like '%" . $string . "%' ")->paginate(20);
				} elseif (!empty($dateFrom) && !empty($dateTo) && empty($column) && empty($string)) {
					$dateTo = date('Y-m-d', strtotime($request->dateTo)) ;
					$dateFrom =date('Y-m-d', strtotime($request->dateFrom) );
					$leaves = $leaves->whereBetween('date_from', [$dateFrom, $dateTo])->paginate(20);
				} elseif (!empty($column) && !empty($string) && !empty($dateFrom) && !empty($dateTo)) {
					$dateTo = date('Y-m-d', strtotime($request->dateTo ));
					$dateFrom =date('Y-m-d', strtotime($request->dateFrom));
					$leaves = $leaves->whereRaw($data[$column] . " like '%" . $string . "%'")->whereBetween('date_from', [$dateFrom, $dateTo])->paginate(20);
				} else {
					$leaves = $leaves->paginate(20);
				}
				$post = 'post';

				return view('hrms.leave.total_leave_request', compact('leaves', 'post', 'column', 'string', 'dateFrom', 'dateTo'));
			} else {
				/**
				 * First we build a query string which is common in both cases whether we have a condition set or not
				 */
				$leaves = \DB::table('users')->select('users.id', 'users.name', 'employees.code', 'employee_leaves.days', 'employee_leaves.date_from', 'employee_leaves.date_to', 'employee_leaves.status', 'leave_types.leave_type', 'employee_leaves.remarks')->join('employees', 'employees.user_id', '=', 'users.id')->join('employee_leaves', 'employee_leaves.user_id', '=', 'users.id')->join('leave_types', 'leave_types.id', '=', 'employee_leaves.leave_type_id');

				if (!empty($column) && !empty($string) && empty($dateFrom) && empty($dateTo)) {
					$leaves = $leaves->whereRaw($data[$column] . " like '%" . $string . "%' ")->get();
				} elseif (!empty($dateFrom) && !empty($dateTo) && empty($column) && empty($string)) {
					$dateTo = date('Y-m-d', strtotime($request->dateTo));
					$dateFrom = date('Y-m-d', strtotime($request->dateFrom));
					$leaves = $leaves->whereBetween('date_from', [$dateFrom, $dateTo])->get();
				} elseif (!empty($column) && !empty($string) && !empty($dateFrom) && !empty($dateTo)) {
					$dateTo = date('Y-m-d' ,strtotime($request->dateTo));
					$dateFrom = date('Y-m-d', strtotime($request->dateFrom));
					$leaves = $leaves->whereRaw($data[$column] . " like '%" . $string . "%'")->whereBetween('date_from', [$dateFrom, $dateTo])->get();
				} else {
					$leaves = $leaves->get();
				}
				/*$leaves = $leaves->get();*/

				$fileName = 'Leave_Listing_' . rand(1, 1000) . '.csv';
				$filePath = storage_path('export/') . $fileName;
				$file = new \SplFileObject($filePath, "a");
				// Add header to csv file.
				$headers = ['id', 'name', 'code', 'leave_type', 'date_from', 'date_to', 'days', 'status', 'remarks'];
				$file->fputcsv($headers);
				$status = '';
				foreach ($leaves as $leave) {
					if ($leave->status == 0) {
						$status = 'Pending';
					} elseif ($leave->status == 1) {
						$status = 'Approved';
					} elseif ($leave->status == 2) {
						$status = 'Disapproved';
					}
					$file->fputcsv([$leave->id, $leave->name, $leave->code, $leave->leave_type, $leave->date_from, $leave->date_to, $leave->days, $status, $leave->remarks]);
				}

				return response()->download(storage_path('export/') . $fileName);

			}
		} catch (\Exception $e) {
			return redirect()->back()->with('message', $e->getMessage());
		}
	}

	public function exportData($request) {
	}

	public function getLeaveCount(Request $request) {
		$leaveTypeId = $request->leaveTypeId;
		$userId = $request->userId;

		$count = EmployeeLeaves::where(['user_id' => $userId, 'leave_type_id' => $leaveTypeId, 'status' => '1'])->get();
		$day = '';
		foreach ($count as $days) {
			$day += $days->days;
		}
		$totalLeaves = totalLeaves($leaveTypeId);
		$remainingLeaves = $totalLeaves - $day;
		return json_encode($remainingLeaves);

	}

	/**
	 * @param Request $request
	 *
	 * @return string
	 */
	public function approveLeave(Request $request) {	
		$leaveId = $request->leaveId;
		$remarks = $request->remarks;
		$employeeLeave = EmployeeLeaves::where('id', $leaveId)->first();
		$user = User::where('id', $employeeLeave->user_id)->first();
		$this->mailer->send('emails.leave_status', ['user' => $user, 'status' => 'approved', 'remarks' => $remarks, 'leave' => $employeeLeave], function ($message) use ($user) {
			$message->from('no-reply@techsevin.com', 'Techsevin Solution LLP');
			$message->to($user->email, $user->name)->subject('Your leave has been approved');
		});
		
		\DB::table('employee_leaves')->where('id', $leaveId)->update(['status' => '1', 'remarks' => $remarks]);

		if($employeeLeave->leave_type_id != 3){
		

		$check = Holiday_employee::where('user_id', "=", $user->id)->first();
	
		if(empty($check))
		{
			$insert = new Holiday_employee();
			$insert->user_id = $user->id;
			$insert->allow_leaves = 0;

			if($employeeLeave->days == '0')
			{
				$t1 = Carbon::createFromFormat('H:i:s',$employeeLeave->from_time);
				$t2 = Carbon::createFromFormat('H:i:s',$employeeLeave->to_time);
				$diff = $t1->diff($t2);
				$hours = $diff->h;

				// $diff = date('H:i:s', strtotime($employeeLeave->from_time)) - date('H:i:s', strtotime($employeeLeave->to_time));
				if ($hours <= 4){
					$taken = 0.5;
					$insert->taken_leaves = $taken;
				}else{
					$taken = 1;
					$insert->taken_leaves = $taken;
				}
					
			}
			else
			{
				$insert->taken_leaves = $employeeLeave->days;
			}	

				$insert->save();
		}
		else{
			$all_taken = $check->taken_leaves;

			if($employeeLeave->days == '0')
			{
				$insert = Holiday_employee::where('user_id', "=", $user->id)->first();
				$all_taken = $insert->taken_leaves;
				$t1 = Carbon::createFromFormat('H:i:s',$employeeLeave->from_time);
				$t2 = Carbon::createFromFormat('H:i:s',$employeeLeave->to_time);
				$diff = $t1->diff($t2);
				$hours = $diff->h;

				// $diff = date('H:i:s', strtotime($employeeLeave->from_time)) - date('H:i:s', strtotime($employeeLeave->to_time));
				if ($hours <= 4){
					$taken = 0.5 + $all_taken;
					\DB::table('holiday_employees')->where('user_id', $user->id)->update(['taken_leaves' => $taken]);
				}else{
					$taken = 1 + $all_taken;
					\DB::table('holiday_employees')->where('user_id', $user->id)->update(['taken_leaves' => $taken]);
				}
					
			}else{
				\DB::table('holiday_employees')->where('user_id', $user->id)->update(['taken_leaves' => $employeeLeave->days + $all_taken]);
			}
		}	
	}	

		return json_encode($diff);
	}

	/**
	 * @param Request $request
	 *
	 * @return string
	 */
	public function disapproveLeave(Request $request) {
		$leaveId = $request->leaveId;
		$remarks = $request->remarks;
		$employeeLeave = EmployeeLeaves::where('id', $leaveId)->first();
		$user = User::where('id', $employeeLeave->user_id)->first();
		$this->mailer->send('emails.leave_status', ['user' => $user, 'status' => 'disapproved', 'remarks' => $remarks, 'leave' => $employeeLeave], function ($message) use ($user) {
			$message->from('no-reply@techsevin.com', 'Techsevin Solution LLP');
			$message->to($user->email, $user->name)->subject('Your leave has been disapproved');
		});
		\DB::table('employee_leaves')->where('id', $leaveId)->update(['status' => '2', 'remarks' => $remarks]);
		return json_encode('success');
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function showHolidays() {
		$holidays = Holiday::paginate(10);
		$filenames = HolidayFilenames::get();
		return view('hrms.leave.holiday', compact('holidays', 'filenames'));
	}
	

	/**
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	// public function processHolidays(Request $request) {
	// 	try
	// 	{
	// 		if (Input::hasFile('upload_file')) {
	// 			$file = Input::file('upload_file');
	// 			$allowedext = ["xlsx", "xls"];
	// 			$extension = $file->getClientOriginalExtension();
	// 			$filename = $file->getClientOriginalName();
	// 			if (in_array($extension, $allowedext)) {

	// 				//move this file to storage path
	// 				$file->move(storage_path('holidays/'), $filename);
	// 				$holiday = new HolidayFilenames();
	// 				$holiday->name = $filename;
	// 				$holiday->description = $request->description;
	// 				$holiday->date = date_format(date_create($request->date), 'Y-m-d');
	// 				$holiday->save();
	// 				\Session::flash('flash_message', 'Holidays successfully added');
	// 				return redirect()->back();
	// 			} else {
	// 				\Session::flash('flash_message', 'Please upload only excel files with xls or xlsx extension');
	// 				return redirect()->back();
	// 			}

	// 			Excel::load(storage_path('holidays/' . $filename), function ($reader) {
	// 				$rows = $reader->get(['occasion', 'date']);

	// 				foreach ($rows as $row) {
	// 					$holiday = new Holiday();
	// 					$holiday->occasion = $row->occasion;
	// 					$holiday->date_from = $row->date;
	// 					$holiday->save();
	// 				}
	// 				\Session::flash('flash_message', 'Holidays successfullyy added');
	// 				return redirect()->back();
	// 			});
	// 		}
	// 	} catch (\Exception $e) {
	// 		\Log::info($e->getMessage());
	// 		\Log::info($e->getLine());
	// 		return redirect()->back()->with('flash_message', $e->getMessage());
	// 	}
	// }

	//addholiday via sheet

	public function processHolidays(Request $request) {
		try
		{
			if (Input::hasFile('upload_file')) {
				$file = Input::file('upload_file');
				$allowedext = ["xlsx", "xls"];
				$extension = $file->getClientOriginalExtension();
				$filename = $file->getClientOriginalName();
				// \Log::info($filename);


				if (in_array($extension, $allowedext)) {

					//move this file to storage path
					$file->move(storage_path('holidays/'), $filename);
					$holiday = new HolidayFilenames();
					$holiday->name = $filename;
					$holiday->description = $request->description;
					$holiday->date =date('Y-m-d', strtotime($request->date));
					$holiday->save();
					

				} else {
					\Session::flash('flash_message', 'Please upload only excel files with xls or xlsx extension');

					return redirect()->back();
				}
					Excel::import(new HolidaysImport,storage_path('holidays/' . $filename)
				
			);
		    
		}

		} 
		catch (\Exception $e) {
			\Log::info($e->getMessage());
			\Log::info($e->getLine());
			return redirect()->back()->with('flash_message', $e->getMessage());
		}
	
		return redirect()->back()->with('flash_message', 'Excel Data Imported successfully.');


	}


	public function showHoliday() {

		$holidays = Holiday::paginate(10);
		$column = '';
		$string = '';
		return view('hrms.leave.show_holiday', compact('holidays', 'column', 'string'));
	}

	//addholiday maually

	public function addHolidays() {
		return view('hrms.leave.add_holiday');
	}
	public function addHoliday(Request $request) {
		$holiday = new Holiday();
		$holiday->occasion = $request->description;
		$holiday->date_from = date('Y-m-d', strtotime($request->date));
		$holiday->save();
		\Session::flash('flash_message', 'Holiday successfully updated!');
		return redirect('holiday-listing');
	}
	public function showEditHoliday($id) {
		$holidays = Holiday::where('id', $id)->first();
		return view('hrms.leave.edit_holiday', compact('holidays'));
	}

	public function doEditHoliday($id, Request $request) {
		$holiday = Holiday::where('id', $id)->first();
		$holiday->occasion = $request->occasion;
		$holiday->date_from = date('Y-m-d', strtotime($request->date_from));
		$holiday->save();

		\Session::flash('flash_message', 'Holiday successfully updated!');
		return redirect('holiday-listing');

	}

	public function deleteHoliday($id) {
		$holiday = Holiday::find($id);
		$holiday->delete();

		\Session::flash('flash_message', 'Holiday successfully deleted!');
		return redirect('holiday-listing');
	}
	public function searchHoliday(Request $request) {
		$string = $request->string;
		$column = $request->column;
		\Log::info($string);
		\Log::info($column);


		if ($request->button == 'Search') {
			if ($string == '' && $column == '') {
				\Session::flash('success', ' Employee details uploaded successfully.');
				return redirect()->to('holiday-listing');
			} elseif ($string != '' && $column == '') {
				\Session::flash('failed', ' Please select category.');
				return redirect()->to('holiday-listing');
			} elseif ($column == 'occasion') { 
				$holidays = Holiday::where('occasion', 'like', "%$string%")->paginate(20);
			} else {
				$holidays = Holiday::where( function ($q) use ($column, $string) {
					$q->whereRaw($column . " like '%" . $string . "%'");
				}
				)->with('employee')->paginate(20);
			}

			return view('hrms.leave.show_holiday', compact('holidays', 'column', 'string'));
		} 
		// else {
		// 	if ($column == '') {
		// 		$emps = User::with('employee' , 'role.role')->get();
		// 	} elseif ($column == 'email') {
		// 		$emps = Holiday::with('employee' , 'role.role')->where($request->column, $request->string)->paginate(20);
		// 	} else {
		// 		$emps = Holiday::whereHas('employee', function ($q) use ($column, $string) {
		// 			$q->whereRaw($column . " like '%" . $string . "%'");
		// 		}
		// 		)->0000000with('employee','role.role')->get();
		// 	}

		// }e
	}


	public function addLeaves(){


		$data = Employee::with('holiday_employee')->get();
				// return $data;

		return view('hrms.leave.add_leaves',['data'=>$data]);

	}

	public function processLeaves(Request $request){

		$data = User::where('name', '=', $request->name)->first();
		if($request->button == 'add'){
			
		$check = Holiday_employee::where('user_id', "=", $data->id)->first();
		if(!$check)
		{
			$insert = new Holiday_employee();
			$insert->user_id = $data->id;
			$insert->allow_leaves = $request->value;
			$insert->save();
		}else{
			$total = $check->allow_leaves + $request->value ;
			\DB::table('holiday_employees')->where('user_id', $data->id)->update(['allow_leaves' => $total]);
		} 		

		return redirect ('dashboard');

		}else{
			$check = Holiday_employee::where('user_id', "=", $data->id)->first();
			if($check)
			{
				$check->user_id = $data->id;
				// $check->allow_leaves = 0;
				if($check->taken_leaves > $check->allow_leaves){
					$check->taken_leaves = $check->allow_leaves;
				}
				$check->save();
				\Session::flash('flash_message', 'Leave data reseted');
			}else{
				\Session::flash('flash_message', "employee Don't  have leaves!");
			} 
		}
	}

	public function leaves_type(Request $request){
		
		$leave = $request->name;
		$date = $request->date;
		$date_to = new Carbon($date);

		if($leave == '3'){
			$data = $date_to->addMonth(6)->toDateString();
			$description =" one hundred eighty one days leave";
		}
		elseif($leave == '4'){
			$data = $date_to->addDays(4)->toDateString();
			$description =" five days leave";
		}
		$date = date('d-m-Y', strtotime($data));
		return json_encode(array("description" => $description ,"data" => $date));
	}

	
}
