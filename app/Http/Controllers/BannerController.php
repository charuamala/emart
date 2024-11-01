<?php

namespace App\Http\Controllers;

use App\Models\Banner; // Make sure to import the Banner model
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Import Str for slug generation
use Illuminate\Support\Facades\DB; // Import DB facade

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = Banner::orderBy('id','DESC')->get();
        return view('backend.banners.index', compact('banners'));
    }
    public function edit($id){
        $banner = Banner::find($id);
        if($banner){
            return view('backend.banners.edit', compact('banner'));
        }else {
            return back()->with('error','Data not found');
        }
    }
    public function updateStatus(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'id' => 'required|integer|exists:banners,id',
            'mode' => 'required',
        ]);
        // Convert 'mode' to a boolean
            $mode = filter_var($request->mode, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);

            // Check if mode is null (which means it wasn't a valid boolean)
            if ($mode === null) {
                return response()->json(['message' => 'The mode field must be true or false.'], 422);
            }
        // Update status based on mode
        //echo $request->mode.'dddddddddddddd';//die;
        if($request->mode == 'true') {
            DB::table('banners')->where('id', $request->id)->update(['status' => 'active']);
        } else {
            DB::table('banners')->where('id', $request->id)->update(['status' => 'inactive']);
        }

        return response()->json(['msg' => 'Status updated successfully.', 'status' => true]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.banners.create');
    }
    public function update(Request $request,$id){
        $banner = Banner::find($id);
        if($banner){
             // Validate the request
            $this->validate($request, [
                "title" => 'string|required',
                "description" => 'string|nullable',
               // "photo" => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                "condition" => 'nullable|in:banner,promo',
                "status" => 'nullable|in:active,inactive',
            ]);
            $data = $request->except('_token');
            //print_r($data);die;
            // Handle photo upload
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/banners'), $filename);
                $data['photo'] = $filename;
            }
            // Create the banner and check the status
            $status = $banner->fill($data)->save();
            if ($status) {
                return redirect()->route('banner.index')->with('success', 'Successfully Updated');
            } else {
                return back()->with('error', 'Something went wrong!');
            }
            }else {
                return back()->with('error','Data not found');
            }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $this->validate($request, [
            "title" => 'string|required',
            "description" => 'string|nullable',
            "photo" => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            "condition" => 'nullable|in:banner,promo',
            "status" => 'nullable|in:active,inactive',
        ]);

        $data = $request->except('_token');

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/banners'), $filename);
            $data['photo'] = $filename;
        }

        $slug = Str::slug($request->input("title"));
        $slug_count = Banner::where('slug', $slug)->count();

        // Append counter to slug if it already exists
        if ($slug_count > 0) {
            $slug .= '-' . ($slug_count + 1);
        }

        $data['slug'] = $slug;

        // Create the banner and check the status
        $status = Banner::create($data);
        if ($status) {
            return redirect()->route('banner.index')->with('success', 'Successfully Created');
        } else {
            return back()->with('error', 'Something went wrong!');
        }
    }
    public function destroy($id){
        $banner = Banner::find($id);
        if($banner){
            $status = $banner->delete();
            if($status){
                return redirect()->route('banner.index')->with('success',"Banner deleted Successfully");
            }else{
                return back()->with('error','Something went wrong!');
            }
        }else {
            return back()->with('error','Data not found');
        }
    }
    // Other methods remain unchanged...
}
