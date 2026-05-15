<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('settings.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $user->id],
        ]);

        $user->update($validated);

        return redirect()->route('settings.index')->with('success', 'Account settings updated successfully.');
    }

    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', function ($attribute, $value, $fail) {
                if (!Hash::check($value, Auth::user()->password)) {
                    $fail('The current password is incorrect.');
                }
            }],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('settings.index')->with('success', 'Password changed successfully.');
    }

    public function helpCenter()
    {
        return view('settings.help-center');
    }

    public function helpArticle($slug)
    {
        $articles = $this->helpArticles();

        if (!isset($articles[$slug])) {
            abort(404);
        }

        return view('settings.help-article', [
            'article' => $articles[$slug],
            'slug' => $slug,
        ]);
    }

    private function helpArticles(): array
    {
        return [
            'how-to-log-in' => [
                'title' => 'How to log in to my account',
                'content' => [
                    'To sign in to your boarding house management account, use the login page and enter the email or username that you registered with.',
                    'Make sure your password is entered exactly as you created it, and verify that Caps Lock is not enabled if you encounter a login error.',
                    'If you forget your password, use the password reset option and follow the instructions sent to your email address.',
                    'After successful login, the system will take you directly to the dashboard where you can access tenants, finances, and maintenance tools.',
                    'Always log out when you are finished using the system, especially when you are on a shared or public computer.',
                ],
            ],
            'creating-your-first-tenant-profile' => [
                'title' => 'Creating your first tenant profile',
                'content' => [
                    'To add a new tenant, navigate to the tenant directory and select the Add New Tenant button.',
                    'Enter the tenant name, unit number, contact details, and lease period so the system can track their occupancy and payments.',
                    'If you do not have the exact lease end date yet, choose the closest expected date and update it later when the lease is finalized.',
                    'The tenant profile page also lets you record the tenant status and payment status, which keeps your roster up to date.',
                    'Save the tenant record once all required fields are filled, and then use the list to manage payments and lease renewals.',
                ],
            ],
            'setting-up-payment-tracking' => [
                'title' => 'Setting up payment tracking',
                'content' => [
                    'Payment tracking starts by recording each rent payment as a separate payment record in the finances section.',
                    'Choose the tenant, specify the number of months you are accepting payment for, and submit the record to keep the ledger accurate.',
                    'The system calculates the payment amount automatically so you do not need to manually compute the total for the selected months.',
                    'Use the search and filter tools in the payment ledger to quickly find records by tenant or payment status.',
                    'Review the payment history often to identify overdue payments and follow up with tenants before the lease end date.',
                ],
            ],
            'how-to-edit-tenant-information' => [
                'title' => 'How to edit tenant information',
                'content' => [
                    'To make updates to a tenant profile, open the tenant directory and choose the tenant you want to edit.',
                    'Click the Edit button on the tenant details page to change their contact information, unit assignment, or lease dates.',
                    'Be sure to save your changes so the system can use the new data for billing, lease status, and reporting.',
                    'If the tenant moves to a different room or extends the lease, update the lease start and end dates accordingly.',
                    'Correct tenant information keeps the payment ledger and lease calendar accurate and helps avoid confusion later.',
                ],
            ],
            'viewing-tenant-lease-status' => [
                'title' => 'Viewing tenant lease status',
                'content' => [
                    'The tenant lease status is visible on the tenant profile page and also in the tenant directory at a glance.',
                    'Lease status information tells you whether a lease is active, expiring soon, or overdue for renewal.',
                    'If a tenant is close to their lease end date, the system highlights that status so you can take action in advance.',
                    'Regularly checking lease status helps you keep the building occupancy stable and avoid unexpected vacancies.',
                    'If a lease end date changes, update the tenant record immediately so the status reflects the latest agreement.',
                ],
            ],
            'removing-a-tenant' => [
                'title' => 'Removing a tenant',
                'content' => [
                    'If you need to delete a tenant, open their tenant profile and use the remove or delete option from the page controls.',
                    'Make sure the tenant has no outstanding obligations before removing their record from the system.',
                    'Confirmed removals will delete the tenant data and clear the associated unit from the occupancy roster.',
                    'Use the search feature to locate the tenant quickly if you have many profiles in the system.',
                    'Be careful with deletion because it is permanent; consider archiving the information separately if you need an audit trail.',
                ],
            ],
            'recording-a-payment' => [
                'title' => 'Recording a payment',
                'content' => [
                    'To record a payment, go to the finances section and choose Add Payment to create a new payment entry.',
                    'Select the tenant and pick the number of months the payment covers so the system can calculate the correct amount.',
                    'The application will set the payment amount automatically and assign a due date based on the months selected.',
                    'Include notes when needed so you can remember details such as advance payment or cash receipt information.',
                    'Save the payment record and then review the ledger to confirm the status and historical transaction details.',
                ],
            ],
            'understanding-payment-status' => [
                'title' => 'Understanding payment status',
                'content' => [
                    'Payment status indicates whether a tenant is fully paid, partially paid, pending, or overdue for their rent.',
                    'When a tenant makes a payment that reaches the current lease end date, the system will display Paid for that tenant.',
                    'If the tenant pays but the amount does not cover the lease term, the status will display as Partially Paid.',
                    'Payments that are not fulfilled by their due date may be marked as Overdue, and they require follow-up action.',
                    'Checking payment status often helps you manage income flow and keep tenant accounts current.',
                ],
            ],
            'viewing-payment-history' => [
                'title' => 'Viewing payment history',
                'content' => [
                    'Payment history is available in the ledger, where each transaction is listed with tenant name, unit, and amount.',
                    'Use the search and filter tools to locate records by tenant, payment status, or date ranges.',
                    'The ledger also shows which payments have been marked as paid and which are still pending or overdue.',
                    'Reviewing the history periodically helps you confirm that all payments were recorded accurately.',
                    'Clear documentation of payment history supports easier financial reporting and tenant communication.',
                ],
            ],
            'creating-maintenance-reports' => [
                'title' => 'Creating maintenance reports',
                'content' => [
                    'Use the maintenance board to create a report whenever a repair or inspection is needed.',
                    'Provide a clear subject, location, and details so the maintenance team can address the issue quickly.',
                    'You can also assign urgency and update the report as work progresses.',
                    'Saving the report keeps a record of the issue and allows you to track completion status.',
                    'Maintenance reports help keep the property safe and ensure that tenant concerns are handled professionally.',
                ],
            ],
            'assigning-technicians' => [
                'title' => 'Assigning technicians',
                'content' => [
                    'Once a maintenance task is created, assign a technician so the work can be scheduled and completed.',
                    'Select the best available technician for the issue and add any relevant notes about the job.',
                    'The assignment section is designed to make sure each repair is owned by a responsible team member.',
                    'You can change the assigned technician later if priorities shift or if a different skill set is needed.',
                    'Keeping technician assignments up to date improves response time and maintenance tracking for the property.',
                ],
            ],
            'tracking-maintenance-status' => [
                'title' => 'Tracking maintenance status',
                'content' => [
                    'The maintenance board shows the current status of each task so you always know what is open, in progress, or completed.',
                    'Update the ticket status as work advances to keep the team and tenants informed.',
                    'You can filter or sort reports to focus on urgent repairs and pending issues first.',
                    'Tracking the maintenance status helps you prioritize work and avoid leaving tasks unresolved.',
                    'A clear maintenance history also supports better planning and follow-up for recurring property needs.',
                ],
            ],
            'changing-your-password' => [
                'title' => 'Changing your password',
                'content' => [
                    'To change your password, visit the settings page and choose the change password option.',
                    'Enter your current password, then type the new password twice for confirmation.',
                    'Select a strong password that is hard to guess and includes a mix of letters, numbers, and symbols.',
                    'After changing your password, log out and log back in to confirm the update was successful.',
                    'Use a different password than what you use on other services to keep your account secure.',
                ],
            ],
            'updating-profile-information' => [
                'title' => 'Updating profile information',
                'content' => [
                    'You can update your name, email, and username on the settings page at any time.',
                    'Keeping this information current helps the system identify you correctly and send notifications to the right address.',
                    'If you change your username, make sure it is still unique within the system.',
                    'After saving your profile updates, verify that the changes show up on the settings page and in your account header.',
                    'Accurate profile information is important for both security and daily operations.',
                ],
            ],
            'logging-out-safely' => [
                'title' => 'Logging out safely',
                'content' => [
                    'Always log out after using the system, especially on a shared or public computer.',
                    'Click the logout button from the menu to end your session securely.',
                    'Closing the browser alone does not always sign you out, so use the application logout feature instead.',
                    'If someone else will use the device after you, confirm that the login screen is displayed before leaving.',
                    'Logging out safely protects your account and the property data from unauthorized access.',
                ],
            ],
        ];
    }
}
