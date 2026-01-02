<?php

namespace App\Http\Controllers;

use App\Models\Advantage;
use Illuminate\Http\Request;

class AdvantageController extends Controller
{

    public function index()
    {
        if (\Auth::user()->can('manage advantage')) {
            // Include both default (parent_id = 0) and user-specific advantages
            $advantages = Advantage::where(function($query) {
                $query->where('parent_id', parentId())
                      ->orWhere('parent_id', 0);
            })->orderBy('parent_id', 'asc')->orderBy('id', 'desc')->get();
            return view('advantage.index', compact('advantages'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }
    public function create()
    {
        return view('advantage.create');
    }

    public function store(Request $request)
    {

        // dd($request->all());
        if (\Auth::user()->can('create advantage')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'description' => 'required',

                ],
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $amenity = new Advantage();
            $amenity->name = $request->name;
            $amenity->description = $request->description;
            $amenity->parent_id = parentId();
            $amenity->save();

            return redirect()->back()->with('success', __('Advantage successfully created.'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }

    public function edit(Advantage $advantage)
    {

        return view('advantage.edit', compact('advantage'));
    }

    public function update(Request $request, Advantage $advantage)
    {
        if (\Auth::user()->can('edit advantage')) {
            // Prevent editing of default items
            if ($advantage->parent_id == 0) {
                return redirect()->back()->with('error', __('Default items cannot be edited.'));
            }

            $validator = \Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'description' => 'required',
                ],
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }


            $advantage->name = $request->name;
            $advantage->description = $request->description;
            $advantage->parent_id = parentId();
            $advantage->save();

            return redirect()->back()->with('success', __('Advantage successfully updated.'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }

    public function destroy(Advantage $advantage)
    {
        if (\Auth::user()->can('delete advantage')) {
            // Prevent deletion of default items
            if ($advantage->parent_id == 0) {
                return redirect()->back()->with('error', __('Default items cannot be deleted.'));
            }

            if ($advantage) {
                $advantage->delete();
            }
            return redirect()->back()->with('success', __('Advantage successfully deleted.'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }
}
