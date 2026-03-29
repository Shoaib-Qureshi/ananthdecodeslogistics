<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomePage;
use App\Models\AboutPage;
use App\Models\Milestone;
use Illuminate\Support\Facades\Storage;

class PageContentController extends Controller
{
    // Home Page Content Management
    public function editHomePage()
    {
        $sections = HomePage::all()->keyBy('section_key');
        return view('admin.editHomePage', compact('sections'));
    }

    public function updateHomePage(Request $request)
    {
        $validated = $request->validate([
            'sections' => 'required|array',
            'sections.*.section_key' => 'required|string',
            'sections.*.heading' => 'nullable|string',
            'sections.*.subheading' => 'nullable|string',
            'sections.*.content' => 'nullable|string',
            'sections.*.button_text' => 'nullable|string',
            'sections.*.button_link' => 'nullable|string',
            'sections.*.stat_number' => 'nullable|string',
            'sections.*.stat_label' => 'nullable|string',
        ]);

        try {
            foreach ($validated['sections'] as $sectionData) {
                // Add section field to match section_key
                $sectionData['section'] = $sectionData['section_key'];

                // Only update or create in home_pages table
                $section = HomePage::updateOrCreate(
                    ['section_key' => $sectionData['section_key']],
                    array_filter($sectionData, function($value) {
                        return $value !== null;
                    })
                );

                // Handle image upload
                $imageField = 'image_' . $sectionData['section_key'];
                if ($request->hasFile($imageField)) {
                    $image = $request->file($imageField);
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $destinationPath = public_path('img/site');
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }
                    $image->move($destinationPath, $imageName);

                    // Delete old image if exists
                    if ($section->image && file_exists(public_path($section->image))) {
                        unlink(public_path($section->image));
                    }

                    $section->image = 'img/site/' . $imageName;
                    $section->save();
                }
            }

            return redirect()->back()->with('success', 'Home page content updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error updating home page: ' . $e->getMessage());
        }
    }

    // About Page Content Management
    public function editAboutPage()
    {
        $sections = AboutPage::all()->keyBy('section_key');
        return view('admin.editAboutPage', compact('sections'));
    }

    public function updateAboutPage(Request $request)
    {
        $validated = $request->validate([
            'sections' => 'required|array',
            'sections.*.section_key' => 'required|string',
            'sections.*.heading' => 'nullable|string',
            'sections.*.subheading' => 'nullable|string',
            'sections.*.content' => 'nullable|string',
        ]);

        foreach ($validated['sections'] as $sectionData) {
            // Add section field to match section_key
            $sectionData['section'] = $sectionData['section_key'];

            $section = AboutPage::updateOrCreate(
                ['section_key' => $sectionData['section_key']],
                $sectionData
            );

            // Handle image upload
            $imageField = 'image_' . $sectionData['section_key'];
            if ($request->hasFile($imageField)) {
                $image = $request->file($imageField);
                $imageName = time() . '_' . $image->getClientOriginalName();
                $destinationPath = public_path('img/site');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                $image->move($destinationPath, $imageName);

                // Delete old image if exists
                if ($section->image && file_exists(public_path($section->image))) {
                    unlink(public_path($section->image));
                }

                $section->image = 'img/site/' . $imageName;
                $section->save();
            }
        }

        return redirect()->back()->with('success', 'About page content updated successfully!');
    }

    // Milestones Management
    public function manageMilestones()
    {
        $milestones = Milestone::orderBy('position', 'asc')->get();
        return view('admin.manageMilestones', compact('milestones'));
    }

    public function addMilestone()
    {
        return view('admin.addMilestone');
    }

    public function saveMilestone(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'position' => 'nullable|integer',
            'status' => 'required|boolean',
        ]);

        $milestone = new Milestone();
        $milestone->year = $validated['year'];
        $milestone->title = $validated['title'];
        $milestone->description = $validated['description'] ?? null;
        $milestone->position = $validated['position'] ?? 0;
        $milestone->status = $validated['status'];

        $milestone->save();

        return redirect('/admin/manage-milestones')->with('success', 'Milestone added successfully!');
    }

    public function editMilestone($id)
    {
        $milestone = Milestone::findOrFail($id);
        return view('admin.editMilestone', compact('milestone'));
    }

    public function updateMilestone(Request $request, $id)
    {
        $validated = $request->validate([
            'year' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'position' => 'nullable|integer',
            'status' => 'required|boolean',
        ]);

        $milestone = Milestone::findOrFail($id);
        $milestone->year = $validated['year'];
        $milestone->title = $validated['title'];
        $milestone->description = $validated['description'] ?? null;
        $milestone->position = $validated['position'] ?? 0;
        $milestone->status = $validated['status'];

        $milestone->save();

        return redirect('/admin/manage-milestones')->with('success', 'Milestone updated successfully!');
    }

    public function deleteMilestone($id)
    {
        $milestone = Milestone::findOrFail($id);
        $milestone->delete();

        return redirect()->back()->with('success', 'Milestone deleted successfully!');
    }
}
