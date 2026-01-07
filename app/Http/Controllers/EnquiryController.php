<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Property;
use Illuminate\Http\Request;

class EnquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (\Auth::user()->can('manage enquiry')) {
            $enquiries = Contact::where('parent_id', \Auth::user()->id)
                ->with(['property' => function($query) {
                    $query->where('parent_id', \Auth::user()->id)
                        ->with(['thumbnail', 'propertyImages']);
                }])
                ->orderBy('id', 'desc')
                ->get();
            
            return view('enquiry.index', compact('enquiries'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (\Auth::user()->can('show enquiry')) {
            $enquiry = Contact::where('id', $id)
                ->where('parent_id', \Auth::user()->id)
                ->firstOrFail();
            
            // Get Lead Form Fields for this owner
            $leadFormFields = \App\Models\LeadFormField::where('parent_id', \Auth::user()->id)
                ->orderBy('is_default', 'desc')
                ->orderBy('sort_order', 'asc')
                ->get();
            
            // Get property if exists
            $property = null;
            if ($enquiry->property_id) {
                $property = Property::where('id', $enquiry->property_id)
                    ->where('parent_id', \Auth::user()->id)
                    ->first();
            }
            
            return view('enquiry.show', compact('enquiry', 'leadFormFields', 'property'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (\Auth::user()->can('edit enquiry')) {
            $enquiry = Contact::where('id', $id)
                ->where('parent_id', \Auth::user()->id)
                ->firstOrFail();
            
            return view('enquiry.edit', compact('enquiry'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (\Auth::user()->can('edit enquiry')) {
            $enquiry = Contact::where('id', $id)
                ->where('parent_id', \Auth::user()->id)
                ->firstOrFail();
            
            $validator = \Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'email' => 'required|email',
                    'subject' => 'required',
                    'message' => 'required',
                ]
            );
            
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }
            
            $enquiry->name = $request->name;
            $enquiry->email = $request->email;
            $enquiry->contact_number = $request->contact_number;
            $enquiry->subject = $request->subject;
            $enquiry->message = $request->message;
            $enquiry->save();
            
            return redirect()->route('enquiry.index')->with('success', __('Enquiry successfully updated.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (\Auth::user()->can('delete enquiry')) {
            $enquiry = Contact::where('id', $id)
                ->where('parent_id', \Auth::user()->id)
                ->firstOrFail();
            
            $enquiry->delete();
            
            return redirect()->back()->with('success', __('Enquiry successfully deleted.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
