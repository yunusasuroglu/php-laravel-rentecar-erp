<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Company;
use App\Models\Contract;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HomeController extends Controller
{

    public function SuperAdminDashboard()
    {
        // Toplam şirket sayısını alıyoruz
        $totalCompanies = Company::count();
        
        // Sayfa görünümüne şirket sayısını gönderiyoruz
        return view('superadmin.super-admin-home', compact('totalCompanies'));
    }
    public function CompanyAdminDashboard()
    {
        $companyId = auth()->user()->company_id;
        
        $company = Company::with('users')->find($companyId);
        $users = $company ? $company->users : collect();
        $cars = $company ? $company->cars : collect();
        $today = Carbon::now()->startOfDay();
        $userCount = $users->count();
        $carCount = $cars->count();
        
        $carsStartingToday = Car::whereHas('contracts', function($query) use ($companyId, $today) {
            $query->where('company_id', $companyId)
                  ->where('status', 1)
                  ->whereDate('start_date', '=', $today);
        })->take(6)->get();
        
        // Bugün sona erecek olan sözleşmeleri al ve ilişkili araçları getir (maksimum 6 araç)
        $carsEndingToday = Car::whereHas('contracts', function($query) use ($companyId, $today) {
            $query->where('company_id', $companyId)
                  ->where('status', 1)
                  ->whereDate('end_date', '=', $today);
        })->take(6)->get();
        
        // Bugün kiralanmış olmayan araçları al (maksimum 6 araç)
        $availableCars = Car::where('company_id', $companyId)
            ->whereDoesntHave('contracts', function($query) use ($today) {
                $query->where('status', 1)
                      ->where(function($query) use ($today) {
                          $query->where('start_date', '<=', $today)
                                ->where('end_date', '>=', $today);
                      });
            })->take(6)->get();
        
        $contractCount = Contract::where('company_id', $companyId)->count();
        $invoiceCount = Invoice::where('company_id', $companyId)->count();
        $dailyGain = Contract::where('company_id', $companyId)->where('status', 6)->whereDate('created_at', $today)->sum('total_amount');
        
        return view('company-admin-home',compact('userCount','carCount','contractCount','dailyGain','invoiceCount','carsStartingToday','carsEndingToday','availableCars'));
    }
    public function EmployeeAdminDashboard()
    {
        return view('employee-admin-home');
    }
    public function home()
    {
        $user = Auth::user();
        
        if ($user->hasRole('Süper Admin')) {
            return redirect()->route('home.superadmin');
        } elseif ($user->hasRole('Firmenleiter')) {
            return redirect()->route('home.company');
        } elseif ($user->hasRole('Mitarbeiter')) {
            return redirect()->route('home.company');
        } else {
            return redirect()->route('home.default');
        }
    }
    
}
