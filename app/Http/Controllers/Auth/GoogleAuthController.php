<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Spatie\Permission\Models\Role;

class GoogleAuthController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Check if user already exists
            $user = User::where('email', $googleUser->getEmail())->first();
            
            if ($user) {
                // User exists, check if account is active
                if ($user->is_active == 0) {
                    return redirect()->route('login')->with('error', __('Your account is temporarily inactive. Please contact your administrator to reactivate your account.'));
                }
                
                // Check if email is verified
                if (empty($user->email_verified_at)) {
                    $user->email_verified_at = now();
                    $user->save();
                }
                
                // Update profile image if available
                if ($googleUser->getAvatar() && empty($user->profile)) {
                    $user->profile = $googleUser->getAvatar();
                    $user->save();
                }
                
                Auth::login($user);
                
                return redirect(RouteServiceProvider::HOME);
            } else {
                // Create new user
                $fullName = $googleUser->getName() ?? $googleUser->getNickname() ?? 'User';
                $nameParts = explode(' ', $fullName, 2);
                
                $userData = [
                    'first_name' => $nameParts[0] ?? 'User',
                    'last_name' => $nameParts[1] ?? '',
                    'email' => $googleUser->getEmail(),
                    'password' => Hash::make(uniqid() . time()), // Random password since Google handles auth
                    'type' => 'owner',
                    'lang' => 'english',
                    'subscription' => 1,
                    'code' => uniqid(),
                    'parent_id' => 1,
                    'email_verified_at' => now(), // Google emails are already verified
                    'email_verification_token' => null,
                    'profile' => $googleUser->getAvatar(),
                ];
                
                $owner = User::create($userData);
                $userRole = Role::findByName('owner');
                $owner->assignRole($userRole);
                
                // Create default data
                defaultTenantCreate($owner->id);
                defaultMaintainerCreate($owner->id);
                defaultTemplate($owner->id);
                FrontHomePageSection($owner->id);
                AdditionalPageSection($owner->id);
                
                // Send welcome email
                $module = 'owner_create';
                $setting = settings();
                if (!empty($owner)) {
                    $data['subject'] = 'New User Created';
                    $data['module'] = $module;
                    $data['name'] = $owner->first_name;
                    $data['email'] = $owner->email;
                    $data['url'] = env('APP_URL');
                    $data['logo'] = $setting['company_logo'];
                    $to = $owner->email;
                    commonEmailSend($to, $data);
                }
                
                Auth::login($owner);
                
                return redirect(RouteServiceProvider::HOME);
            }
        } catch (\Exception $e) {
            \Log::error('Google OAuth Error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', __('Unable to login with Google. Please try again.'));
        }
    }
}

