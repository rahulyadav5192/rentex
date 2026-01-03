<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ContactController extends Controller
{

    public function index()
    {
        if (\Auth::user()->can('manage contact')) {
            $contacts = Contact::where('parent_id', \Auth::user()->id)->orderBy('id', 'desc')->get();
            return view('contact.index', compact('contacts'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function create()
    {
        return view('contact.create');
    }


    public function store(Request $request)
    {
        if (\Auth::user()->can('create contact')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'subject' => 'required',
                    'message' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $contact = new Contact();
            $contact->name = $request->name;
            $contact->email = $request->email;
            $contact->contact_number = $request->contact_number;
            $contact->subject = $request->subject;
            $contact->message = $request->message;
            $contact->parent_id = \Auth::user()->id;
            $contact->save();

            return redirect()->back()->with('success', __('Contact successfully created.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function show(Contact $contact)
    {
        //
    }


    public function edit(Contact $contact)
    {
        return view('contact.edit', compact('contact'));
    }


    public function update(Request $request, Contact $contact)
    {
        if (\Auth::user()->can('edit contact')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'subject' => 'required',
                    'message' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }


            $contact->name = $request->name;
            $contact->email = $request->email;
            $contact->contact_number = $request->contact_number;
            $contact->subject = $request->subject;
            $contact->message = $request->message;
            $contact->save();

            return redirect()->back()->with('success', __('Contact successfully updated.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function destroy(Contact $contact)
    {
        if (\Auth::user()->can('edit contact')) {
            $contact->delete();

            return redirect()->back()->with('success', 'Contact successfully deleted.');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
    public function frontDetailStore(Request $request, $code)
    {
        $user = User::where('code', $code)->first();
        
        // Get Lead Form Fields for validation
        $leadFormFields = \App\Models\LeadFormField::where('parent_id', $user->id)
            ->orderBy('is_default', 'desc')
            ->orderBy('sort_order', 'asc')
            ->get();
        
        // Build validation rules
        $rules = [
            'subject' => 'required',
            'message' => 'required',
        ];
        
        foreach ($leadFormFields as $field) {
            if ($field->is_required) {
                if ($field->is_default) {
                    $rules[$field->field_name] = 'required';
                } else {
                    $rules['custom_fields.' . $field->field_name] = 'required';
                }
            }
        }
        
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first())->withInput();
        }

        $contact = new Contact();
        
        // Set default fields
        $contact->name = $request->name ?? null;
        $contact->email = $request->email ?? null;
        $contact->contact_number = $request->phone ?? $request->contact_number ?? null;
        $contact->subject = $request->subject;
        $contact->message = $request->message;
        $contact->parent_id = $user->id;
        
        // Store property_id if provided
        if ($request->filled('property_id')) {
            try {
                $propertyId = Crypt::decrypt($request->property_id);
                // Verify property belongs to this user
                $property = \App\Models\Property::where('id', $propertyId)->where('parent_id', $user->id)->first();
                if ($property) {
                    $contact->property_id = $propertyId;
                }
            } catch (\Exception $e) {
                // Invalid property ID, ignore it
            }
        }
        
        // Store custom fields
        $customFieldsData = [];
        if ($request->has('custom_fields') && is_array($request->custom_fields)) {
            foreach ($request->custom_fields as $fieldName => $fieldValue) {
                // Handle file uploads
                if ($request->hasFile('custom_fields.' . $fieldName)) {
                    $file = $request->file('custom_fields.' . $fieldName);
                    $fileName = time() . '_' . $fieldName . '.' . $file->getClientOriginalExtension();
                    $file->storeAs('upload/contact/documents/', $fileName, 'public');
                    $customFieldsData[$fieldName] = 'upload/contact/documents/' . $fileName;
                } else {
                    $customFieldsData[$fieldName] = $fieldValue;
                }
            }
        }
        $contact->custom_fields = !empty($customFieldsData) ? json_encode($customFieldsData) : null;
        
        $contact->save();

        return redirect()->back()->with('success', __('Contact successfully created.'));
    }
}
