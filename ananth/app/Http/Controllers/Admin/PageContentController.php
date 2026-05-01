<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Milestone;
use App\Models\HomePageSetting;
use App\Models\AboutPageSetting;
use App\Models\Founder;
use App\Models\FounderCredential;
use App\Models\ServiceCard;
use App\Models\ExpertDeskPillar;
use App\Models\SiteSetting;
use App\Models\PageBanner;
use Illuminate\Support\Facades\Storage;

class PageContentController extends Controller
{
    // Home Page Content Management
    public function editHomePage()
    {
        return view('admin.editHomePage', [
            'settings' => HomePageSetting::instance(),
            'site' => SiteSetting::instance(),
            'credentials' => FounderCredential::ordered()->get(),
            'services' => ServiceCard::ordered()->get(),
            'pillars' => ExpertDeskPillar::ordered()->get(),
        ]);
    }

    public function updateHomePage(Request $request)
    {
        $validated = $request->validate($this->homeRules());
        $settings = HomePageSetting::instance();
        $settings->fill($validated['settings'] ?? []);
        $this->storeImage($request, $settings, 'hero_image', 'settings.hero_image', 'page-content');
        $this->storeImage($request, $settings, 'founder_photo', 'settings.founder_photo', 'page-content');
        $settings->save();

        $this->syncFounderCredentials($validated['credentials'] ?? []);
        $this->syncServices($validated['services'] ?? []);
        $this->syncExpertDeskPillars($validated['pillars'] ?? []);
        $this->updateSiteSettings($request, $validated['site'] ?? []);

        return redirect()->back()->with('success', 'Home page content updated successfully!');
    }

    // About Page Content Management
    public function editAboutPage()
    {
        return view('admin.editAboutPage', [
            'settings' => AboutPageSetting::instance(),
            'founders' => Founder::orderBy('sort_order')->get(),
            'services' => ServiceCard::ordered()->get(),
        ]);
    }

    public function updateAboutPage(Request $request)
    {
        $validated = $request->validate($this->aboutRules());
        $settings = AboutPageSetting::instance();
        $settings->fill($validated['settings'] ?? []);
        $this->storeImage($request, $settings, 'hero_image', 'settings.hero_image', 'page-content');
        $settings->save();

        $this->syncFounders($request, $validated['founders'] ?? []);
        $this->syncServices($validated['services'] ?? []);

        return redirect()->back()->with('success', 'About page content updated successfully!');
    }

    public function editPageBanners()
    {
        $banners = PageBanner::orderBy('key')->get()->keyBy('key');
        $bannerKeys = [
            'blog' => 'Blog banner',
            'expert_desk' => 'The Expert Desk banner',
            'board_insights' => 'Board Insights banner',
            'book_reviews' => 'Book Reviews banner',
        ];

        return view('admin.editPageBanners', compact('banners', 'bannerKeys'));
    }

    public function updatePageBanners(Request $request)
    {
        $validated = $request->validate([
            'banners' => 'required|array',
            'banners.*.key' => 'required|string|in:blog,expert_desk,board_insights,book_reviews',
            'banners.*.eyebrow' => 'nullable|string|max:255',
            'banners.*.heading' => 'nullable|string|max:255',
            'banners.*.subheading' => 'nullable|string|max:2000',
            'banners.*.cta_label' => 'nullable|string|max:255',
            'banners.*.cta_link' => 'nullable|string|max:255',
            'banners.*.is_active' => 'nullable|boolean',
            'banners.*.image' => 'nullable|image|max:4096',
        ]);

        foreach ($validated['banners'] as $index => $data) {
            $banner = PageBanner::firstOrNew(['key' => $data['key']]);
            $banner->fill([
                'eyebrow' => $data['eyebrow'] ?? null,
                'heading' => $data['heading'] ?? null,
                'subheading' => $data['subheading'] ?? null,
                'cta_label' => $data['cta_label'] ?? null,
                'cta_link' => $data['cta_link'] ?? null,
                'is_active' => (bool) ($data['is_active'] ?? false),
            ]);
            $this->storeImage($request, $banner, 'image', "banners.$index.image", 'page-banners');
            $banner->save();
        }

        return redirect()->back()->with('success', 'Page banners updated successfully!');
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

    private function homeRules(): array
    {
        return [
            'settings' => 'required|array',
            'settings.*' => 'nullable',
            'settings.hero_image' => 'nullable|image|max:4096',
            'settings.founder_photo' => 'nullable|image|max:4096',
            'credentials' => 'nullable|array',
            'credentials.*.id' => 'nullable|integer|exists:founder_credentials,id',
            'credentials.*.credential' => 'nullable|string|max:500',
            'credentials.*.sort_order' => 'nullable|integer',
            'services' => 'nullable|array',
            'services.*.id' => 'nullable|integer|exists:service_cards,id',
            'services.*.title' => 'nullable|string|max:255',
            'services.*.description' => 'nullable|string|max:1000',
            'services.*.icon' => 'nullable|string|max:100',
            'services.*.status' => 'nullable|string|max:50',
            'services.*.link_url' => 'nullable|string|max:255',
            'services.*.sort_order' => 'nullable|integer',
            'services.*.visible' => 'nullable|boolean',
            'pillars' => 'nullable|array',
            'pillars.*.id' => 'nullable|integer|exists:expert_desk_pillars,id',
            'pillars.*.title' => 'nullable|string|max:255',
            'pillars.*.body' => 'nullable|string|max:1000',
            'pillars.*.sort_order' => 'nullable|integer',
            'site' => 'nullable|array',
            'site.*' => 'nullable',
            'site.footer_logo' => 'nullable|image|max:2048',
        ];
    }

    private function aboutRules(): array
    {
        return [
            'settings' => 'required|array',
            'settings.*' => 'nullable',
            'settings.hero_image' => 'nullable|image|max:4096',
            'founders' => 'nullable|array',
            'founders.*.id' => 'nullable|integer|exists:founders,id',
            'founders.*.eyebrow' => 'nullable|string|max:255',
            'founders.*.name' => 'nullable|string|max:255',
            'founders.*.title' => 'nullable|string|max:255',
            'founders.*.bio' => 'nullable|string',
            'founders.*.sort_order' => 'nullable|integer',
            'founders.*.visible' => 'nullable|boolean',
            'founders.*.photo' => 'nullable|image|max:4096',
            'founders.*.signature_image' => 'nullable|image|max:2048',
            'services' => 'nullable|array',
            'services.*.id' => 'nullable|integer|exists:service_cards,id',
            'services.*.title' => 'nullable|string|max:255',
            'services.*.description' => 'nullable|string|max:1000',
            'services.*.icon' => 'nullable|string|max:100',
            'services.*.status' => 'nullable|string|max:50',
            'services.*.link_url' => 'nullable|string|max:255',
            'services.*.sort_order' => 'nullable|integer',
            'services.*.visible' => 'nullable|boolean',
        ];
    }

    private function syncFounderCredentials(array $items): void
    {
        $this->syncSimpleRows($items, FounderCredential::class, ['credential', 'sort_order'], 'credential');
    }

    private function syncExpertDeskPillars(array $items): void
    {
        $this->syncSimpleRows($items, ExpertDeskPillar::class, ['title', 'body', 'sort_order'], 'title');
    }

    private function syncServices(array $items): void
    {
        foreach ($items as $item) {
            if (empty($item['title']) && empty($item['description'])) {
                continue;
            }

            $service = !empty($item['id']) ? ServiceCard::find($item['id']) : new ServiceCard();
            if (!$service) {
                continue;
            }
            $service->fill([
                'title' => $item['title'] ?? '',
                'description' => $item['description'] ?? '',
                'icon' => $item['icon'] ?? null,
                'status' => $item['status'] ?? 'active',
                'link_url' => $item['link_url'] ?? null,
                'sort_order' => $item['sort_order'] ?? 0,
                'visible' => (bool) ($item['visible'] ?? false),
            ])->save();
        }
    }

    private function syncFounders(Request $request, array $items): void
    {
        foreach ($items as $index => $item) {
            if (empty($item['name']) && empty($item['bio'])) {
                continue;
            }

            $founder = !empty($item['id']) ? Founder::find($item['id']) : new Founder();
            if (!$founder) {
                continue;
            }
            $founder->fill([
                'eyebrow' => $item['eyebrow'] ?? null,
                'name' => $item['name'] ?? '',
                'title' => $item['title'] ?? null,
                'bio' => $item['bio'] ?? null,
                'sort_order' => $item['sort_order'] ?? 0,
                'visible' => (bool) ($item['visible'] ?? false),
            ]);
            $this->storeImage($request, $founder, 'photo', "founders.$index.photo", 'founders');
            $this->storeImage($request, $founder, 'signature_image', "founders.$index.signature_image", 'founders');
            $founder->save();
        }
    }

    private function syncSimpleRows(array $items, string $modelClass, array $columns, string $requiredColumn): void
    {
        foreach ($items as $item) {
            if (empty($item[$requiredColumn])) {
                continue;
            }

            $payload = [];
            foreach ($columns as $column) {
                $payload[$column] = $item[$column] ?? ($column === 'sort_order' ? 0 : null);
            }

            $model = !empty($item['id']) ? $modelClass::find($item['id']) : new $modelClass();
            if ($model) {
                $model->fill($payload)->save();
            }
        }
    }

    private function updateSiteSettings(Request $request, array $data): void
    {
        $site = SiteSetting::instance();
        $site->fill($data);
        $this->storeImage($request, $site, 'footer_logo', 'site.footer_logo', 'site');
        $site->save();
    }

    private function storeImage(Request $request, $model, string $column, string $input, string $directory): void
    {
        if (!$request->hasFile($input)) {
            return;
        }

        if ($model->{$column}) {
            Storage::disk('public')->delete($model->{$column});
        }

        $model->{$column} = $request->file($input)->store($directory, 'public');
    }
}
