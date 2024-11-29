<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeCompanyAdminMail;
use App\Mail\WelcomePersonMail;
use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    
    use RegistersUsers;
    
    /**
    * Where to redirect users after registration.
    *
    * @var string
    */
    protected $redirectTo = '/';
    
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware('guest');
        
        // Yeni kullanıcı oluşturulduğunda adres formuna yönlendir
        $this->middleware(function ($request, $next) {
            if (session('new_user_created')) {
                return redirect()->route('address.form', ['user_id' => Auth::id()]);
            }
            
            return $next($request);
        });
    }
    
    /**
    * Get a validator for an incoming registration request.
    *
    * @param  array  $data
    * @return \Illuminate\Contracts\Validation\Validator
    */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
    
    /**
    * Create a new user instance after a valid registration.
    *
    * @param  array  $data
    * @return \App\Models\User
    */
    protected function create(array $data)
    {
        if ($data['user_type'] == 'person') {
            // Şirket referans numarası veya token ile şirketi bulun
            $company = Company::where('reference_token', $data['company_reference'])->first();
            
            if (!$company) {
                // Referans numarası veya token geçersizse hata döndürün
                throw ValidationException::withMessages(['company_reference' => 'Sie haben eine ungültige Firmenreferenznummer eingegeben.']);
            }
            
            // Kullanıcıyı oluştur
            $user = User::create([
                'name' => $data['name'],
                'surname' => $data['surname'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'company_id' => $company->id, // Şirket ID'sini atayın
            ]);
            $user->assignRole('Mitarbeiter');
            // Adres formuna yönlendir
            Auth::login($user);
            Mail::to($user->email)->send(new WelcomePersonMail($user, $company));
            return $user;
        } else {
            // Şirket kullanıcı kaydı
            $company = Company::create([
                'name' => $data['company_name'],
                'tax_number' => $data['tax_number'],
                'phone' => $data['company_phone'],
                'fax' => $data['company_fax'],
                'hrb' => $data['company_hrb'],
                'iban' => $data['company_iban'],
                'bic' => $data['company_bic'],
                'stnr' => $data['company_stnr'],
                'ust_id_nr' => $data['company_ust_id_nr'],
                'registry_court' => $data['company_registry_court'],
                'general_manager' => $data['company_general_manager'],
                'email' => $data['company_email'],
                'address' => json_encode([
                    'country' => $data['company_country'],
                    'city' => $data['company_city'],
                    'street' => $data['company_street'],
                    'zip_code' => $data['company_zip_code'],
                ]),
                'reference_token' => Str::uuid()->toString(),
            ]);
            
            // Kullanıcıyı oluştur
            $user = User::create([
                'name' => $data['name'],
                'surname' => $data['surname'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'address' => json_encode([
                    'country' => $data['country'],
                    'city' => $data['city'],
                    'street' => $data['street'],
                    'zip_code' => $data['zip_code'],
                ]),
                'company_id' => $company->id,
            ]);
            $user->assignRole('Firmenleiter');
            // Kullanıcıyı oturum aç
            Mail::to($user->email)->send(new WelcomeCompanyAdminMail($user, $company));
            return $user;
        }
    }  
}
