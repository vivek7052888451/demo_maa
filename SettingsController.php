<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings;
use App\Models\Timeline;
use Illuminate\Support\Facades\Validator;
use File;
class SettingsController extends Controller
{
    public $settings, $timeline;
    function __construct(Settings $settings, Timeline $timeline)
    {
        $this->settings = $settings;
        $this->timeline = $timeline;
    }
    public function index()
    {   
        $settings = $this->settings->get();
        return view('backend.settings.list', compact('settings'));
    }

    public function addsettings()
    {
        $settings = $this->settings->first();

        return view('backend.settings.add', compact('settings'));
    }

    public function store(Request $request)
    {
     $edit_id = $request->hdn_settimg_id;
   if($edit_id == null)
     {
      if($request->type == 'File')
      {
       if($request->hasFile('file')){

        $input = $request->all();
       
        if ($image = $request->file('file')) {
             $imageDestinationPath = public_path().'/backend/img/settings/value/'; 

            $postImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            
            $image->move($imageDestinationPath, $postImage);
            $input['value'] = "$postImage";
            
        }
           Settings::create($input);
        return back()->with('success', ' File Successfully Add.');

        }
        else
        {
            return back()->with('success', 'Select File Please.');
        }
      } 
      else
      {
        //dd($request->all());
        $input = $request->all();
        Settings::create($input);
        return back()->with('success', ' Text Successfully Add.');
      }
  }
  else
  {
     if($request->type == 'File')
     {
        
       
        if($image = $request->file('file'))
        {
            $editdatas=Settings::find($request->hdn_settimg_id);
            $editdatas->name=$request->name;
            $editdatas->type=$request->type;
            $editdatas->status=$request->status;

              $imageDestinationPath = public_path().'/backend/img/settings/value/'.$editdatas->vlaue;
               if(File::exists($imageDestinationPath))
                 {
                  File::delete($imageDestinationPath);
                 }
                 $image = $request->file('file');
                 $postImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                 $image->move($imageDestinationPath, $postImage);
                 $editdatas['value'] = "$postImage";

                  $editdatas->save();
                  return back()->with('success', ' File Successfully Updated With File Select.');       
        }


        else
        {
            //dd('not file');
              $edit_id = $request->hdn_settimg_id;
              $data = Settings::find($edit_id);
              $data->name=$request->name;
              $data->type=$request->type;
              $data->status=$request->status;
              $data->save();
              return back()->with('success', ' File Successfully Updated Without File Select.');

        }
     }
     else
     {
          $edit_id = $request->hdn_settimg_id;
          $data = Settings::find($edit_id);
          $data->name=$request->name;
          $data->type=$request->type;
          $data->status=$request->status;
          $data->value=$request->value;
          $data->save();
        return back()->with('success', ' Text Successfully Updated.');
     }
    //dd($edit_id = $request->hdn_settimg_id);
  }

    }

    public function edit($id)
    {
      $getdata = $this->settings->find($id);
      return view('backend.settings.add', compact('getdata'));
    }


    public function destroy(Request $request)
    {
        // dd($request->id);
        $settings_data  = $this->settings = $this->settings->where('id', $request->id)->first();
        if (!empty($settings_data)) {
            // $timeline = $this->timeline->saveDetails('Settings', 'Deleted Settings '.$settings_data->id);
            $this->settings->delete();            
            return response()->json(['status' => true, 'message' => 'Settings Deleted Successfully !']);
        }
    }

    public function changeSettingsStatus(Request $request)
    {
        // dd($request->id);
        if (isset($request->id)) {
            $settings  = $this->settings->find($request->id);
            if(!empty($settings)){
                $settings->status = $request->option;
                $settings->save();
                // $timeline = $this->timeline->saveDetails('Settings', 'Change settings status to '.$request->option);
                return response()->json(['status' => true, 'message' => 'Status Updated Successfully !']);
            }
        }
    }
}
