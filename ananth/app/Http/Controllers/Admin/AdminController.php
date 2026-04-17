<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\HandlesUserProfileUpdates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Image;
use App\Models\User;
use App\Models\Blogs;
use App\Models\BlogCategories;
use App\Models\ContributorPost;
use App\Models\Contact;
use App\Models\TeamMember;
use App\Mail\AdminCreatedContributor;
use App\Mail\NewRegistrationAdminNotification;
use App\Support\ContributorPlans;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    use HandlesUserProfileUpdates;

    public function showAdminLogin()
    {
        if(Auth::user() && Auth::user()->user_role == 'admin'){
            return redirect()->route('admin.dashboard');
        } 
        return view('admin.login');
    }

    public function logOut(Request $request) 
    {
	Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('showAdminLogin');
    } 

    public function login(Request $request)
    {
        Validator::make($request->all(),[
            'email' => 'required|email|',
            'password' => 'required'
        ])->validate();
        $email = $request->email;
        $password = $request->password;
        $hash_pass = Hash::make($password);
        if (Auth::attempt(['email' => $email, 'password' => $password]))
        {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }
        else{
            return  redirect()->back()->with('error','Please enter correct email and password');
        }
    }

    public function showDashboard()
    {
        $userCount = User::count();
        $blogCount = Blogs::count();
        return view('admin.dashboard', [
            'userCount' => $userCount,
            'blogCount' => $blogCount,
        ]);
    }

    public function usersList(Request $request)
    {
        if(isset($_GET['query'])){            
            $search_text = $_GET['query'];
            $users = User::orderBy('created_at','desc')->where('name', 'LIKE', '%'.$search_text.'%')->paginate(100);       
            $users->appends($request->all());
        }else{
            $users = User::orderBy('id','desc')->paginate(300);            
        }

        return view('admin.usersList', [
            'users'=>$users
        ]);
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        if (Auth::id() === $user->id) {
            return redirect()->back()->with('error', 'You cannot delete your own admin account while logged in.');
        }

        Blogs::where('user_id', $user->id)->delete();
        ContributorPost::where('user_id', $user->id)->delete();
        $user->delete();

        return redirect()->back()->with('message', 'User and associated posts deleted successfully.');
    }

    public function addUser()
    {
        return view('admin.addUser', [
            'contributorPlans' => ContributorPlans::adminSelectablePlans(),
        ]);
    }

    public function editProfile()
    {
        return view('admin.profile', [
            'user' => Auth::user(),
        ]);
    }

    public function updateProfile(Request $request)
    {
        $this->updateProfileFromRequest($request, Auth::user());

        return redirect()->route('admin.profile.edit')->with('message', 'Profile updated successfully.');
    }

    function generateUniqueUsername($baseUsername)
    {
        $username = $baseUsername;
        $counter = 1;

        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }

        return $username;
    }

    public function saveUser(Request $request)
    {
        $request->validate([
            'name'             => 'required',
            'email'            => ['nullable', 'email', 'unique:users,email'],
            'designation'      => 'required',
            'profile_pic'      => 'required',
            'account_type'     => 'required|in:author,contributor',
            'contributor_plan' => ['nullable', Rule::in(ContributorPlans::adminSelectableCodes())],
        ]);

        $baseUsername = Str::slug($request->input('name'));
        $uniqueUsername = $this->generateUniqueUsername($baseUsername);
        $selectedPlan = ContributorPlans::normalize($request->contributor_plan, ContributorPlans::FREE);

        $providedEmail = $request->filled('email') ? trim($request->email) : null;

        $user = new User();
        $user->name = $request->name;
        $user->email = $providedEmail ?? ($uniqueUsername . '@ananthdecodeslogistics.com');
        $user->username = $uniqueUsername;
        $user->password = Hash::make("345hysdygYGTYg5!237");
        $user->user_role = $request->account_type === 'contributor' ? 'guest' : 'author';
        $user->status = $request->account_type === 'contributor' ? 'approved' : 'approved';
        $user->contributor_plan = $request->account_type === 'contributor' ? $selectedPlan : null;
        $user->payment_status = $request->account_type === 'contributor'
            ? ($selectedPlan === ContributorPlans::FREE ? 'complimentary' : 'paid')
            : null;
        $user->activated_at = $request->account_type === 'contributor' ? now() : null;
        $user->designation = $request->designation;
        $user->insta = $request->insta;
        $user->linkedin = $request->linkedin;
        $user->twitter = $request->twitter;
        $user->intro = $request->intro;
        if( $request->hasFile('profile_pic') ) {
            $image = $request->file('profile_pic');
            $filename = Str::slug($request->input('name'))."-".time().'.webp';
            $resizedImage = Image::make($image);
            if($resizedImage->height() > $resizedImage->width()){
                $width = 600;
                $height = null;
              }
              else{
                $width = 600;
                $height = 600;
              }
              $resizedImage->resize($width, $height, function ($constraint) {
                  $constraint->aspectRatio();
            })->save(public_path('img/site/' . $filename));
            $user->profile_pic = $filename;
        }
        $user->save();

        if ($request->account_type === 'contributor') {
            // Notify the admin that a new contributor was manually added
            try {
                $adminEmail = config('mail.admin_email', 'admin@ananthdecodeslogistics.com');
                Mail::to($adminEmail)->send(new NewRegistrationAdminNotification($user));
            } catch (\Throwable $e) {
                Log::warning('Failed to send admin notification for manually created contributor.', [
                    'user_id' => $user->id,
                    'error'   => $e->getMessage(),
                ]);
            }

            // Send welcome email with password setup link if a real email was provided
            if ($providedEmail) {
                $this->sendAdminCreatedContributorEmail($user);
                return redirect()->back()->with('message', "Contributor created! A welcome email with password setup link has been sent to {$providedEmail}.");
            }
        }

        return redirect()->back()->with('message', "User Successfully Created!");
    }

    public function editUser($id)
    {
        $editUser = User::find($id);
        return view('admin.editUser', [
            'editUser' => $editUser,
            'contributorPlans' => ContributorPlans::adminSelectablePlans(),
        ]);
    }

    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'name'             => 'required',
            'email'            => ['nullable', 'email', "unique:users,email,{$id}"],
            'designation'      => 'required',
            'profile_pic'      => 'nullable',
            'account_type'     => 'required|in:author,contributor',
            'contributor_plan' => ['nullable', Rule::in(ContributorPlans::adminSelectableCodes())],
        ]);

        $updateUser = User::find($id);
        $wasContributor = $updateUser->user_role === 'guest';
        $previousPlan = $updateUser->contributorPlanCode();
        $selectedPlan = ContributorPlans::normalize($request->contributor_plan, ContributorPlans::FREE);
        $updateUser->name = $request->name;
        if ($request->filled('email')) {
            $updateUser->email = trim($request->email);
        }
        $updateUser->user_role = $request->account_type === 'contributor' ? 'guest' : 'author';
        $updateUser->status = $request->account_type === 'contributor' ? 'approved' : $updateUser->status;
        $updateUser->contributor_plan = $request->account_type === 'contributor' ? $selectedPlan : null;
        $updateUser->payment_status = $request->account_type === 'contributor'
            ? ($selectedPlan === ContributorPlans::FREE ? 'complimentary' : 'paid')
            : null;
        $updateUser->activated_at = $request->account_type === 'contributor'
            ? (($wasContributor && $previousPlan === $selectedPlan && $updateUser->activated_at) ? $updateUser->activated_at : now())
            : null;
        $updateUser->designation = $request->designation;
        $updateUser->insta = $request->insta;
        $updateUser->linkedin = $request->linkedin;
        $updateUser->twitter = $request->twitter;
        $updateUser->intro = $request->intro;

        if( $request->hasFile('profile_pic') ) {
            $image = $request->file('profile_pic');
            $filename = Str::slug($request->input('name'))."-".time().'.webp';
            $resizedImage = Image::make($image);
            if($resizedImage->height() > $resizedImage->width()){
                $width = 600;
                $height = null;
              }
              else{
                $width = 600;
                $height = 600;
              }
              $resizedImage->resize($width, $height, function ($constraint) {
                  $constraint->aspectRatio();
            })->save(public_path('img/site/' . $filename));
            $updateUser->profile_pic = $filename;
        }

        $updateUser->save();

        if ($request->account_type === 'contributor') {
            $this->moveAuthorBlogsToContributor($updateUser);
        } elseif ($wasContributor) {
            $updateUser->status = null;
            $updateUser->save();
        }

        return redirect()->back()->with('message', "User Successfully Updated");
    }

    private function sendAdminCreatedContributorEmail(User $user): void
    {
        try {
            $token    = Password::broker()->createToken($user);
            $resetUrl = url(route('password.reset', ['token' => $token, 'email' => $user->email], false));
            Mail::to($user->email)->send(new AdminCreatedContributor($user, $resetUrl));
        } catch (\Throwable $e) {
            Log::warning('Failed to send admin-created contributor email.', [
                'user_id' => $user->id,
                'error'   => $e->getMessage(),
            ]);
        }
    }

    private function moveAuthorBlogsToContributor(User $user): void
    {
        $category = BlogCategories::firstOrCreate(
            ['category_slug' => 'transport-logistics'],
            [
                'category_name' => 'Transport & Logistics',
                'name' => 'Transport & Logistics',
                'slug' => 'transport-logistics',
            ]
        );

        $blogs = Blogs::where('user_id', $user->id)->get();

        foreach ($blogs as $blog) {
            $featuredImage = $blog->thumbnail;

            if ($featuredImage && File::exists(public_path('media/' . $featuredImage))) {
                File::ensureDirectoryExists(storage_path('app/public/posts'));
                File::copy(
                    public_path('media/' . $featuredImage),
                    storage_path('app/public/posts/' . $featuredImage)
                );
            }

            ContributorPost::create([
                'user_id' => $user->id,
                'category_id' => $category->id,
                'title' => $blog->title,
                'slug' => ContributorPost::generateUniqueSlug($blog->slug ?: $blog->title),
                'body' => $blog->content,
                'featured_image' => $featuredImage,
                'status' => (int) $blog->status === 1 && (int) $blog->visibility === 1 ? 'published' : 'pending',
                'published_at' => (int) $blog->status === 1 && (int) $blog->visibility === 1 ? ($blog->updated_at ?? $blog->created_at ?? now()) : null,
            ]);

            $blog->delete();
        }
    }

    public function messages()
    {
        $messages = Contact::orderBy('id', 'desc')->paginate(100);
        return view('admin.messages', [
            'messages'=>$messages,
        ]);
    }
    
    public function addMember()
    {
        return view('admin.addMember');
    }

    public function saveMember(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required',
            'designation' => 'required',
        ]);
        
        $member = new TeamMember();
        $member->name = $request->name;
        $member->designation = $request->designation;
        $member->insta = $request->insta;
        $member->linkedin = $request->linkedin;
        $member->twitter = $request->twitter;
        $member->position = $request->position;
        
        if( $request->hasFile('image') ) {
            $image = $request->file('image');
            $filename = Str::slug($request->input('name'))."-".time().'.webp';
            $resizedImage = Image::make($image);
            if($resizedImage->height() > $resizedImage->width()){
                $width = 600;
                $height = null;
              }
              else{
                $width = 600;
                $height = 600;
              }
              $resizedImage->resize($width, $height, function ($constraint) {
                  $constraint->aspectRatio();
              })->save(public_path('img/site/' . $filename));
            $member->image = $filename;
        }
        $member->save();

        return redirect()->back()->with('message', "Member Successfully Created!");

    }

    public function listMember()
    {
        $members = TeamMember::all();
        return view('admin.listMember', [
            'members' => $members
        ]);
    }

    public function editMember($id)
    {
        $editMember = TeamMember::find($id);
        return view('admin.editMember', [
            'editMember' => $editMember
        ]);
    }

    public function updateMember(Request $request, $id)
    {
        $updateMember = TeamMember::find($id);
        $updateMember->name = $request->name;
        $updateMember->designation = $request->designation;
        $updateMember->insta = $request->insta;
        $updateMember->linkedin = $request->linkedin;
        $updateMember->twitter = $request->twitter;
        $updateMember->position = $request->position;
        
        if( $request->hasFile('image') ) {
            $image = $request->file('image');
            $filename = Str::slug($request->input('name'))."-".time().'.webp';
            $resizedImage = Image::make($image);
            if($resizedImage->height() > $resizedImage->width()){
                $width = 600;
                $height = null;
              }
              else{
                $width = 600;
                $height = 600;
              }
              $resizedImage->resize($width, $height, function ($constraint) {
                  $constraint->aspectRatio();
              })->save(public_path('img/site/' . $filename));
            $updateMember->image = $filename;
        }
        $updateMember->save();

        return redirect()->back()->with('message', "Member Successfully Updated!");
    }

    public function deleteMember($id)
    {
        $deleteMember = TeamMember::find($id);
        $deleteMember->delete();
        return redirect('admin/members-list')->with('message', 'Member Successfully Deleted!');

    }

}
