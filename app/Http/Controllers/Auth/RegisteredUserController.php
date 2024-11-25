<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User\User;
use App\Services\Agency\AgencyService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{

    public function __construct(
        protected AgencyService $agencyService,
    )
    {
        //
    }
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'agency_name' => 'required', 'string', 'max:255',
            'network_code' => 'required', 'string', 'max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $agencyData['name'] = $request->get('agency_name');
        $agencyData['network_code'] = $request->get('network_code');

        try{
            DB::beginTransaction();
            $agency = $this->agencyService->createAgency($agencyData);

            $user = User::create([
                'agency_id' => $agency?->id,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $user->assignRole(config('constant.user_types.owner'));

            event(new Registered($user));

            Auth::login($user);

            DB::commit();
        }catch (\Exception $exception){
            DB::rollback();
            dd($exception);

        }


        return redirect(route('dashboard', absolute: false));
    }
}
