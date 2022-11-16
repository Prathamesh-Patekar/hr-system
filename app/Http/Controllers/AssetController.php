<?php

namespace App\Http\Controllers;

use App\Exports\AssetsExport;
use App\Imports\AssetsImport;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Asset;
use App\Models\AssignAsset;
use App\Models\AssignAccessory;

use App\Models\Employee;
use App\Models\UserRole;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class AssetController extends Controller
{

    public function exportAsset(Request $request) 
    {
        $string = $request->string;
        
        return Excel::download(new AssetsExport, 'assets.xlsx');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addAsset()
    {
        $emps = User::get();
        return view('hrms.asset.add_asset', compact('emps'));
    }
   

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    Public function processAsset(Request $request)
    {
        $asset = new Asset();
        if($request->cpu){
            $asset->name = $request->cpu;
            // \Log::info($request->cpu);
            $asset->device= $request->device;
            $asset->device_sr= $request->cpu_sr;
            $asset->processor= $request->cpu_processor;
            $asset->ram= $request->cpu_ram;
            $asset->storage_type= $request->d_type;
            $asset->status= 0;

            if($request->d_type == 5 ){
                $asset->ssd= $request->cpu_ssd;
            }elseif($request->d_type == 6 ){
                $asset->hdd= $request->cpu_hdd;
            }else{
                $asset->ssd= $request->cpu_ssd;
                $asset->hdd= $request->cpu_hdd;
            }
            $asset->description= $request->cpu_description;
            $asset->save();
            \Session::flash('flash_message', 'Asset successfully added!');
            return redirect()->back();
        }
        elseif($request->laptop){
            $asset->name = $request->laptop;
            $asset->device=1;
            $asset->device_sr= $request->laptop_sr;
            $asset->processor= $request->laptop_processor;
            $asset->ram= $request->laptop_ram;
            $asset->storage_type= $request->disk_type;
            $asset->status= 0;
            if($request->d_type == 5 ){
                $asset->ssd= $request->laptop_ssd;
            }elseif($request->d_type == 6 ){
                $asset->hdd= $request->laptop_hdd;
            }else{
                $asset->ssd= $request->laptop_ssd;
                $asset->hdd= $request->laptop_hdd;
            }
            $asset->description= $request->laptop_description;
            $asset->save();
            \Session::flash('flash_message', 'Asset successfully added!');
            return redirect()->back();
        }
        elseif($request->phone){
            $asset->name = $request->phone;
            $asset->device=2;
            $asset->processor= $request->phone_processor;
            $asset->ram= $request->phone_ram;
            $asset->ssd= $request->phone_storage;
            $asset->os= $request->phone_os;
            $asset->imei= $request->phone_imei;
            $asset->description= $request->phone_description;
            $asset->status= 0;

            $asset->save();
            \Session::flash('flash_message', 'Asset successfully added!');
            return redirect()->back();
        }
        elseif($request->tablet){
            $asset->name = $request->tablet;
            $asset->device=3;
            $asset->processor= $request->tablet_processor;
            $asset->ram= $request->tablet_ram;
            $asset->ssd= $request->tablet_storage;
            $asset->os= $request->tablet_os;
            $asset->imei= $request->tablet_imei;
            $asset->description= $request->tablet_description;
            $asset->status= 0;
            $asset->save();
            \Session::flash('flash_message', 'Asset successfully added!');
            return redirect()->back();
        }
      
     
       
       

    }
    Public function uploadAssetView(Request $request){
        return view('hrms.asset.upload_asset');
    }
     Public function uploadAccessoryView(Request $request){
        return view('hrms.asset.upload_accessory');
    }
    Public function uploadAsset(Request $request){
        try {
        Input::hasFile('upload_file');
        $file = Input::file('upload_file');
        $import=new AssetsImport();
        Excel::import($import,$file); 
        
        } catch (\Exception $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
        \Session::flash('flash_message', 'Excel Data Imported successfully.');
        return redirect('asset-listing');

    }
    
   

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showAsset(request $request)
    {
        $string = $request->string;
		$column = $request->column;
        if ($request->button == 'Search') {
			if ($string == '' && $column == '') {
				\Session::flash('success', ' Assets details uploaded successfully.');
				return redirect()->to('asset-listing');
			} else {
				$assets = Asset::where('device', $column)->paginate(20);
			} 

			return view('hrms.asset.show_asset', compact('assets', 'column', 'string'));
		} elseif($request->button == 'Export') {
			if ($column == '') {
                $assets = Asset::where('name', '!=' , 'personal')->get();
			} else {
                $assets = Asset::where('device', $column)->where('name', '!=' , 'personal')->get();
			} 
			$fileName = 'Assets_Listing_' . rand(1, 1000) . '.xlsx';
			$filePath = storage_path('export/') . $fileName;
			$file = new \SplFileObject($filePath, "a");
			// Add header to csv file.
			$headers = ['device','name','device_sr','processor','ram','storage_type','primary_storage','hdd','os','imei','description','created_at','updated_at'];
		
			
			$file->fputcsv($headers);
            try {
                foreach ($assets as $asset) {
                    $file->fputcsv([
                        getDevice($asset->device),
                        $asset->name,
                        $asset->device_sr,
                        (empty($asset->processor)) ? "NA" : $asset->processor,
                        (empty($asset->ram)) ? "NA" : $asset->ram,
                        (empty($asset->storage_type)) ? "NA" : getStorageType($asset->storage_type),
                        (empty($asset->ssd)) ? "NA" : $asset->ssd,
                        (empty($asset->hdd)) ? "NA" : $asset->hdd,
                        (empty($asset->os)) ? "NA" : $asset->os,
                        (empty($asset->imei)) ? "NA" : $asset->imei,
                        (empty($asset->description)) ? "NA" : $asset->description,
                        $asset->created_at,
                        $asset->updated_at,
                    ]
                    );
                }
            } catch (\Exception $e) {
			return redirect()->back()->with('message', $e->getMessage());
		}

			return response()->download(storage_path('export/') . $fileName);
		}
        $assets = Asset::where('name', '!=' , 'personal')->paginate(15);
        return view('hrms.asset.show_asset', compact('assets','string','column'));
    }
    public function showAssetInfo($id) {
       
        $assets = Asset::where('id', $id)->get();
        return view('hrms.asset.show_asset_info', compact('assets'));
    }
   


    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showEdit($id)
    {
        $result = Asset::whereid($id)->first();
        return view('hrms.asset.add_asset', compact('result'));
    }

    public function addAccessory()
    {
        $emps = User::get();
        return view('hrms.asset.add_accessory', compact('emps'));
    }
    Public function processAccessory(Request $request)
    {
        $asset = new Asset();
        $asset->name = $request->accessory_name;
        $asset->device=$request->accessory;
        $asset->device_sr= $request->accessory_sr;
        $asset->description= $request->accessory_description;
        $asset->status= 0;
        $asset->save();
        \Session::flash('flash_message', 'Asset successfully added!');
        return redirect()->back();
    }
    public function showAccessoryEdit($id)
    {
        $result = Asset::whereid($id)->first();
        return view('hrms.asset.add_accessory', compact('result'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function doEdit(Request $request, $id)
    {

        if($request->cpu){
            $cpu= $request->cpu;
            // \Log::info($request->cpu);
            $device= $request->device;
            $cpu_sr= $request->cpu_sr;
            $cpu_processor= $request->cpu_processor;
            $cpu_ram= $request->cpu_ram;
            $d_type= $request->d_type;
            if($request->d_type == 5 ){
                $cpu_ssd= $request->cpu_ssd;
            }elseif($request->d_type == 6 ){
                $cpu_hdd= $request->cpu_hdd;
            }else{
                $cpu_ssd= $request->cpu_ssd;
                $cpu_hdd= $request->cpu_hdd;
            }
            $cpu_description= $request->cpu_description;
               
            $edit = Asset::findOrFail($id);
            
            if (!empty($cpu)) {
                $edit->name = $cpu;
            }
            if (!empty($device)) {
                $edit->device = $device;
            }
            if (!empty($cpu_sr)) {
                $edit->device_sr = $cpu_sr;
            }
            if (!empty($cpu_processor)) {
                $edit->processor = $cpu_processor;
            }
            if (!empty($cpu_ram)) {
                $edit->ram = $cpu_ram;
            }
            if (!empty($d_type)) {
                $edit->storage_type = $d_type;
            }
           
            if (!empty($description)) {
                $edit->description = $cpu_description;
            }
            $edit->os = "";
            $edit->imei ="";
            if($request->d_type == '5' ){
                if (!empty($cpu_ssd)) {
                    $edit->ssd = $cpu_ssd;
                    $edit->hdd = "";
                }
            }elseif($request->d_type == '6' ){
                if (!empty($cpu_hdd)) {
                    $edit->ssd = "";
                    $edit->hdd = $cpu_hdd;
                }
            }else{
                if (!empty($cpu_ssd)) {
                    $edit->ssd = $cpu_ssd;
                }
                if (!empty($cpu_hdd)) {
                    $edit->hdd = $cpu_hdd;
                }
            }
           
            $edit->save();
            \Session::flash('flash_message', 'Asset successfully updated!');
            return redirect('asset-listing');
            
        }elseif($request->laptop){
            $cpu= $request->laptop;
            $device= 1;
            $cpu_sr= $request->laptop_sr;
            $cpu_processor= $request->laptop_processor;
            $cpu_ram= $request->laptop_ram;
            $disk_type= $request->disk_type;
            if($disk_type == '5' ){
                $cpu_ssd= $request->laptop_ssd;
                $cpu_hdd= 0;

            }elseif($disk_type == '6' ){
                $cpu_hdd= $request->laptop_hdd;
                $cpu_ssd= 0;

            }else{
                $cpu_ssd= $request->laptop_ssd;
                $cpu_hdd= $request->laptop_hdd;
            }
            $cpu_description= $request->laptop_description;
               
            $edit = Asset::findOrFail($id);
            
            if (!empty($cpu)) {
                $edit->name = $cpu;
            }
            if (!empty($device)) {
                $edit->device = $device;
            }
        
            if (!empty($cpu_sr)) {
                $edit->device_sr = $cpu_sr;
            }
            if (!empty($cpu_processor)) {
                $edit->processor = $cpu_processor;
            }
            if (!empty($cpu_ram)) {
                $edit->ram = $cpu_ram;
            }
            if (!empty($d_type)) {
                $edit->storage_type = $d_type;
            }
           
            if (!empty($description)) {
                $edit->description = $cpu_description;
            }
          
                $edit->os = "";
                $edit->imei ="";
            if($request->disk_type == '5' ){
                if (!empty($cpu_ssd)) {
                    $edit->ssd = $cpu_ssd;
                    $edit->hdd = 0;
                }
            }elseif($request->disk_type == '6' ){
                if (!empty($cpu_hdd)) {
                    $edit->ssd = 0;
                    $edit->hdd = $cpu_hdd;
                }
            }else{
                if (!empty($cpu_ssd)) {
                    $edit->ssd = $cpu_ssd;
                }
                if (!empty($cpu_hdd)) {
                    $edit->hdd = $cpu_hdd;
                }
            }
           
            $edit->save();
            \Session::flash('flash_message', 'Asset successfully updated!');
            return redirect('asset-listing');
            
        }
        elseif($request->phone){
            $phone= $request->phone;
            $device=2;
            $processor= $request->phone_processor;
            $ram= $request->phone_ram;
            $phone_storage= $request->phone_storage;
            $os= $request->phone_os;
            $imei= $request->phone_imei;
            $cpu_description= $request->phone_description;
               
            $edit = Asset::findOrFail($id);
            $edit->storage_type=4;
            $edit->hdd = 0;
            $edit->device_sr = "";
            
            if (!empty($phone)) {
                $edit->name = $phone;
            }
            if (!empty($device)) {
                $edit->device = $device;
            }
            
            if (!empty($processor)) {
                $edit->processor = $processor;
            }
            if (!empty($ram)) {
                $edit->ram = $ram;
            }
            if (!empty($description)) {
                $edit->description = $cpu_description;
            }
            if (!empty($phone_storage)) {
                $edit->ssd = $phone_storage;
            }
            if (!empty($os)) {
                $edit->os = $os;
            }if (!empty($imei)) {
                $edit->imei = $imei;
            }
            
            $edit->save();
            \Session::flash('flash_message', 'Asset successfully updated!');
            return redirect('asset-listing');

        }
        elseif($request->tablet){
          
            $phone= $request->tablet;
            $device=3;
            $processor= $request->tablet_processor;
            $ram= $request->tablet_ram;
        
            $phone_storage= $request->tablet_storage;
            $os= $request->tablet_os;
            $imei= $request->tablet_imei;
            $cpu_description= $request->tablet_description;
               
            $edit = Asset::findOrFail($id);
            $edit->storage_type=4;
            $edit->hdd = "";
            $edit->device_sr = "";
            
            if (!empty($phone)) {
                $edit->name = $phone;
            }
            if (!empty($device)) {
                $edit->device = $device;
            }
            if (!empty($device_sr)) {
                $edit->device_sr = $device_sr;
            }
            if (!empty($processor)) {
                $edit->processor = $processor;
            }
            if (!empty($ram)) {
                $edit->ram = $ram;
            }
            if (!empty($description)) {
                $edit->description = $cpu_description;
            }
            if (!empty($phone_storage)) {
                $edit->ssd = $phone_storage;
            }
            if (!empty($os)) {
                $edit->os = $os;
            }if (!empty($imei)) {
                $edit->imei = $imei;
            }
            
            $edit->save();
            \Session::flash('flash_message', 'Asset successfully updated!');
            return redirect('asset-listing');

        }
    
    }
    public function doAccessoryEdit(Request $request, $id){
        $name = $request->accessory_name;
        $device=$request->accessory;
        $device_sr= $request->accessory_sr;
        $description= $request->accessory_description;
        $edit = Asset::findOrFail($id); 
        if (!empty($name)) {
            $edit->name = $name;
        }
        if (!empty($device)) {
            $edit->device = $device;
        }
        if (!empty($device_sr)) {
            $edit->device_sr = $device_sr;
        }
        if (!empty($description)) {
            $edit->description = $description;
        }
        $edit->save();
        \Session::flash('flash_message', 'Accessory successfully updated!');
        return redirect('asset-listing');

    }



    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function doDelete($id)
    {
        $asset = Asset::find($id);
        $asset->delete();
        \Session::flash('flash_message', 'Asset successfully Deleted!');
        return redirect('asset-listing');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function doAssign()
    {
        $emps = User::where('status',0)->get();
        $role=[1,7];
        // $issueAuth = UserRole::with('user')
        // ->whereIn('role_id',$role)
        // ->get();
        $issueAuth = UserRole::whereHas('user', function ($q)  {
            $q->where('status',0);
        })
        ->with('user')
        ->whereIn('role_id',$role)
        ->get();

        // return $issueAuth;
        $device=[0,1,2,3];
        $accessory=[4,5,6];
        $assets = Asset::whereIn('device', $device)
        ->where('status', 0)
        ->get();
        $accessories = Asset::whereIn('device', $accessory)
        ->where('status', 0)
        ->get();
        return view('hrms.asset.assign_asset', compact('emps', 'assets','accessories','issueAuth'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processAssign(Request $request)
    {  
        // $accessory_id=$request->accessory_id;
        // \Log::info(gettype($accessory_id));
        // foreach ($accessory_id as $value) {
        //     $accessory_assignment = new AssignAccessory();
        //     $access_id=(int)$value;
        //     $accessory_assignment->accessory_id = $access_id;
        //     $accessory_assignment->user_id = $request->emp_id;
        //     $accessory_assignment->authority_id = $request->authority_id;
        //     $accessory_assignment->date_of_assignment = date_format(date_create($request->doa), 'Y-m-d');
        //     $accessory_assignment->save();  
        // }
        $assignment = new AssignAsset();
        
        if ($request->owner == "0") {
           
            $accessory_id=$request->accessory_id;
            $accessory_name=[];
            if($request->accessory_id){
                foreach ($accessory_id as  $value) {
                    $value;
                    $assets = Asset::where('id', $value)->get();
                    
                    foreach ($assets as  $asset) {
                        $accessory_device=getDevice($asset->device);
                        $accessory_name =$asset->name;
                        $accessory=$accessory_device. ":". $accessory_name;
                        $accessory_names[]=$accessory;
                    }
                }
                
    
            }
            $accessory_names;
            $assignment->owner = $request->owner;

            $assignment->user_id = $request->emp_id;
            $assignment->asset_id = $request->asset_id;
            if (empty($accessory_id)) {
                $assignment->accessory_id = [];
    
            }else{
                $assignment->accessory_id = $accessory_id;
            }
            $accessory_names;
            if (empty($accessory_names)) {
                $assignment->accessory_name = [];
    
            }else{
                $assignment->accessory_name = $accessory_names;
    
            }
            
            $assignment->authority_id = $request->authority_id;
            $assignment->date_of_assignment = date_format(date_create($request->doa), 'Y-m-d');
            $accessory_id[]= $request->asset_id;
            if($assignment->save()){
                foreach($accessory_id as $asset){
                $edit = Asset::findOrFail($asset);
                $edit->status = 1;
                $edit->save();
                }
            }
    
            \Session::flash('flash_message', 'Asset successfully assigned!');
            return redirect('assignment-listing');
        }elseif($request->owner_id ="1" ){
            $personal = Asset::where('name', 'personal')->get();
            foreach ($personal as  $value) {
                $value->id;
            } 
            $assignment->owner = 1;
            $assignment->asset_id = $value->id;
            $assignment->user_id = $request->emp_id;
            $assignment->authority_id = $request->authority_id;
            $assignment->accessory_id = [];
            $assignment->accessory_name = [];
            $assignment->date_of_assignment = date_format(date_create($request->doa), 'Y-m-d');
            $assignment->save();
            \Session::flash('flash_message', 'Asset successfully assigned!');
            return redirect('assignment-listing');

        }
       
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showAssignment(Request $request)
    {
        $string =$request->string;
        $column = $request->column;

		if ($request->button == 'Search') {
			if ($string == '' && $column == '') {
				\Session::flash('success', ' Assignment details uploaded successfully.');
				return redirect()->to('assignment-listing');
			} elseif ($string != '' && $column == '') {
				\Session::flash('failed', ' Please select category.');
				return redirect()->to('assignment-listing');
			} else {
				 $assets = AssignAsset::whereHas('employee', function ($q) use ($column, $string) {
					$q->whereRaw($column . " like '%" . $string . "%'");
				}
				)->with('employee','authority', 'asset')->paginate(20);
			} 

			return view('hrms.asset.show_assignment', compact('column', 'string','assets'));
		} 
        elseif($request->button == 'Export'){
			if ($column == '') {
                $assets = AssignAsset::with(['employee','authority', 'asset'])->get();

			} else {
				$assets = AssignAsset::whereHas('employee', function ($q) use ($column, $string) {
					$q->whereRaw($column . " like '%" . $string . "%'");
				}
				)->with('employee','authority', 'asset')->get();
			}
			$fileName = 'Assignment_Listing_' . rand(1, 1000) . '.xlsx';
			$filePath = storage_path('export/') . $fileName;
			$file = new \SplFileObject($filePath, "a");
			// Add header to csv file.
			$headers = ['Employee','owner','asset','accessories','authority_id','date_of_assignment'];
		
			$file->fputcsv($headers);
			foreach ($assets as $asset) {
                $name="";
                foreach($asset->accessory_name as $names){
                 $name.=$names.' ';
                }
				$file->fputcsv([
                    $asset->employee->name,
                    getDevice($asset->owner),
					(empty($asset->asset->name)) ? "NA" : $asset->asset->name,
                    (empty($name)) ? "NA" : $name,
                    $asset->authority->name,
                    $asset->date_of_assignment,
				]
				);
			}
			return response()->download(storage_path('export/') . $fileName);
		}
        $assets = AssignAsset::with(['employee','authority', 'asset'])->paginate(15);
        
        return view('hrms.asset.show_assignment', compact('assets','string','column'));
    }

    public function showAssignmentInfo($id){
         $assets = AssignAsset::with(['employee','authority', 'asset'])->where('id', $id)->get();
        return view('hrms.asset.show_assignment_info', compact('assets'));
    }
    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showEditAssign($id)
    {
        // $assigns = AssignAsset::whereHas('asset', function ($q) {
        //     $q->whereRaw('status', 0);
        // }
        // )->where('id', $id)->get();

        $assigns = AssignAsset::with(['employee', 'asset'])->where('id', $id)->first();
        
        $accessory_id=$assigns->accessory_id;
        $accessory_device = Asset::whereIn('id', $accessory_id)
        ->get();
        // foreach ($accessory_device as $value) {
        //     return getDevice($value->device);
        // }
        
        $emps = User::where('status',0)->get();
    //  return $assets;
        $role=[1,7];
        $issueAuth = UserRole::whereHas('user', function ($q)  {
            $q->where('status',0);
        })
        ->with('user')
        ->whereIn('role_id',$role)
        ->get();

        // $issueAuth = UserRole::whereHas('user', function ($q)  {
        //     $q->where('status',0);
        // })
        // ->with('user')
        // ->whereIn('role_id',$role)
        // ->get();
        // return $issueAuth;
        $device=[0,1,2,3];
        $accessory=[4,5,6];
        $assets = Asset::whereIn('device', $device)
        ->where('status', 0)
        ->get();
        $accessories = Asset::whereIn('device', $accessory)
        ->where('status', 0)
        ->get();
        return view('hrms.asset.edit_asset_assignment', compact('assigns', 'emps', 'assets','accessories','issueAuth'));
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function doEditAssign($id, Request $request)
    {
       
        $assignment = AssignAsset::with(['employee', 'asset'])->where('id', $id)->first();
        $assignment->asset_id;
        $status_ids=$assignment->accessory_id;
        $status_ids[]=$assignment->asset_id;

        foreach($status_ids as $asset){
            $accessory_status = Asset::findOrFail($asset);
            $accessory_status->status = 0;
            $accessory_status->save();
        }
        

     
        if ($request->owner == "0") {
            $accessory_id=$request->accessory_id;
            $accessory_name=[];
            if($request->accessory_id){
                foreach ($accessory_id as  $value) {
                    $value;
                    $assets = Asset::where('id', $value)->get();
                    foreach ($assets as  $asset) {
                        $accessory_device=getDevice($asset->device);
                        $accessory_name =$asset->name;
                        $accessory=$accessory_device. ":". $accessory_name;
                        $accessory_names[]=$accessory;
                    }
                }
            }
            $accessory_names;
            $assignment->owner = $request->owner;
            $assignment->user_id = $request->emp_id;
            $assignment->asset_id = $request->asset_id;
            $assignment->authority_id = $request->authority_id;
            $assignment->date_of_assignment = date_format(date_create($request->doa), 'Y-m-d');
            if (empty($accessory_id)) {
                $assignment->accessory_id = [];

            }else{
                $assignment->accessory_id = $accessory_id;
            }
            if (empty($accessory_names)) {
                $assignment->accessory_name = [];

            }else{
                $assignment->accessory_name = $accessory_names;

            } 
            $accessory_id[]= $request->asset_id;
            if($assignment->save()){
                foreach($accessory_id as $asset){
                $edit = Asset::findOrFail($asset);
                $edit->status = 1;
                $edit->save();
                }
            }
            \Session::flash('flash_message', 'Asset Assignment successfully updated!');
            return redirect('assignment-listing');
        }elseif($request->owner_id ="1" ){
            $personal = Asset::where('name', 'personal')->get();
            foreach ($personal as  $value) {
                $value->id;
            } 
            $assignment->owner = 1;
            $assignment->asset_id = $value->id;
            $assignment->user_id = $request->emp_id;
            $assignment->authority_id = $request->authority_id;
            $assignment->accessory_id = [];
            $assignment->accessory_name = [];
            $assignment->date_of_assignment = date_format(date_create($request->doa), 'Y-m-d');
            $assignment->save();
            \Session::flash('flash_message', 'Asset Assignment successfully updated!');
            return redirect('assignment-listing');
        }
        
        
    }


    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function doDeleteAssign($id)
    {
        $assignment = AssignAsset::with(['employee', 'asset'])->where('id', $id)->first();
        $assignment->asset_id;
        $status_ids=$assignment->accessory_id;
        $status_ids[]=$assignment->asset_id;

        foreach($status_ids as $asset){
            $accessory_status = Asset::findOrFail($asset);
            $accessory_status->status = 0;
            $accessory_status->save();
        }
        
        $assign = AssignAsset::find($id);
        $assign->delete();
         
        \Session::flash('flash_message', 'Asset Assignment successfully Deleted!');
        return redirect('assignment-listing');
    }

}