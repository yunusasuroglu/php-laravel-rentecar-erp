<?php

namespace App\Http\Controllers\Company\Cars;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\CarGroup;
use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarsController extends Controller
{
    public function Cars()
    {
        $user = Auth::user();
        
        $cars = $user->company->cars;
        
        foreach ($cars as $car) {
            $currentDate = now()->toDateString(); // Bugünün tarihi
            
            // Contracts tablosunda ilgili araca ait en son biten aktif bir kira var mı kontrol et
            $lastContract = Contract::where('car_id', $car->id)
            ->where('end_date', '>=', $currentDate)
            ->orderBy('end_date', 'asc')
            ->first();
            
            // Eğer bir kira sözleşmesi varsa, araca 'Unavailable' durumunu ekle, yoksa 'Available'
            $car->status = $lastContract ? 'Unavailable' : 'Available';
            
            // En son biten kira sözleşmesinin bitiş tarihini ekle
            $car->last_usage_date = $lastContract ? $lastContract->end_date : null;
        }
        
        
        return view('company.cars.cars', compact('cars'));
    }
    public function CarDetail($id)
    {
        $user = Auth::user(); 
        
        $car = $user->company->cars()->where('id', $id)->first();
        $images = json_decode($car->images, true);
        
        $carDamages = $car->damages;
        $carInternalDamages = $car->internal_damages;
        $carGroup = $car->carGroup;
        $damagesArray = json_decode('[' . $carDamages . ']', true);
        $internalDamagesArray = json_decode('[' . $carInternalDamages . ']', true);
        if (!$car) {
            abort(404);
        }
        $options = json_decode($car->options, true);
        return view('company.cars.car-detail', compact('car','images','options','damagesArray','internalDamagesArray','carGroup'));
    }
    public function CarAdd()
    {
        $user = auth()->user();
        $companyId = $user->company_id;
        
        
        $carGroups = CarGroup::where('company_id', $companyId)->get();
        
        return view('company.cars.car-add', compact('carGroups'));
    }
    public function CarEdit($id)
    {
        $user = Auth::user(); 
        $companyId = $user->company_id;
        $car = $user->company->cars()->where('id', $id)->first();
        $images = json_decode($car->images, true);
        if (!$car) {
            abort(404);
        }
        $carGroups = CarGroup::where('company_id', $companyId)->get();
        $carDamages = $car->damages;
        
        $carInternalDamages = $car->internal_damages;
        
        $internalDamagesArray = json_decode('[' . $carInternalDamages . ']', true);
        $damagesArray = json_decode($carDamages, true);
        // dd($damagesArray);
        $options = json_decode($car->options, true);
        return view('company.cars.car-edit',compact('car','images','options','internalDamagesArray','carGroups','damagesArray'));
    }
    public function CarStore(Request $request)
    {
        // dd($request);
        $user = auth()->user();
        $companyId = $user->company_id;
        
        $validatedData = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'class2' => 'required|string|max:255',
            'class' => 'required|string|max:255',
            'price_for_additional_driver' => 'nullable',
            'price_per_extra_kilometer' => 'required|numeric|min:0',
            'daily_price' => 'required|numeric|min:0',
            'deposito' => 'required|numeric|min:0',
            'weekly_price' => 'required|numeric|min:0',
            'weekday_price' => 'required|numeric|min:0',
            'monthly_price' => 'required|numeric|min:0',
            'weekend_price' => 'required|numeric|min:0',
            'daily_kilometer' => 'required|numeric|min:0',
            'weekly_kilometer' => 'required|numeric|min:0',
            'weekday_kilometer' => 'required|numeric|min:0',
            'monthly_kilometer' => 'required|numeric|min:0',
            'weekend_kilometer' => 'required|numeric|min:0',
            'odometer' => 'required|numeric|min:0',
            'vin' => 'required|string|max:255|unique:cars,vin',
            'min_age' => 'required|integer|min:18',
            'car_group' => 'required|exists:car_groups,id',
            'desc' => 'nullable|string|max:1000',
            'number_of_doors' => 'nullable|integer',
            'horse_power' => 'nullable|numeric|min:0',
            'fuel' => 'required|string|max:50',
            'color' => 'required|string|max:50',
            'number_plate' => 'required|string|max:255|unique:cars,number_plate',
            'traffic_date' => 'required|date',
            'standard_exemption' => 'required|numeric|min:0',
            'tire_type' => 'nullable|string|max:50',
            'fuel_status' => 'required|string|max:50',
            'tire_size' => 'nullable|string|max:50',
            'rim_size' => 'nullable|string|max:50',
            'key_number' => 'nullable|string|max:50',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'options.*' => 'required',
        ], [
            'brand.required' => 'The vehicle brand field is required.',
            'model.required' => 'The vehicle model field is required.',
            'class.required' => 'The vehicle class field is required.',
            'class2.required' => 'The vehicle class field is required.',
            'price_per_extra_kilometer.required' => 'Extra kilometer fee is required.',
            'daily_price.required' => 'Daily price field is required.',
            'deposito.required' => 'Deposit field is required.',
            'weekly_price.required' => 'Weekly price is required.',
            'weekday_price.required' => 'Weekday price is required.',
            'monthly_price.required' => 'Monthly price is required.',
            'weekend_price.required' => 'Weekend price is required.',
            'daily_kilometer.required' => 'Daily kilometers are required.',
            'weekly_kilometer.required' => 'Weekly kilometers are required.',
            'weekday_kilometer.required' => 'Weekday kilometers are required.',
            'monthly_kilometer.required' => 'Monthly kilometers are required.',
            'weekend_kilometer.required' => 'Weekend kilometers are required.',
            'odometer.required' => 'Odometer is required.',
            'vin.required' => 'VIN field is required.',
            'vin.unique' => 'This VIN is already in use.',
            'min_age.required' => 'Minimum age is required.',
            'min_age.min' => 'Minimum age must be at least 18.',
            'car_group.required' => 'Car group selection is required.',
            'car_group.exists' => 'The selected car group could not be found.',
            'fuel.required' => 'Fuel type field is required.',
            'fuel_status.required' => 'Fuel Status field is required.',
            'color.required' => 'Color field is required.',
            'number_plate.required' => 'License plate field is required.',
            'number_plate.unique' => 'This license plate is already in use.',
            'traffic_date.required' => 'Traffic start date is required.',
            'traffic_date.date' => 'Please enter a valid date.',
            'standard_exemption.required' => 'Standard exemption is required.',
            'images.*.image' => 'Uploaded file must be an image.',
            'damage-description.*' => 'nullable|string|max:255',
            'x-coordinate.*' => 'nullable|numeric',
            'status' => 'nullable|numeric',
            'y-coordinate.*' => 'nullable|numeric',
            'damage-photo.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'internal_damage_description.*' => 'nullable|string|max:255',
            'internal_damage_image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'options.*.required' => 'Options field is required.',
        ]);
        
        $car = new Car();
        $car->company_id = $companyId;
        // Store the brand and model as JSON
        $car->car = json_encode([
            'brand' => $validatedData['brand'],
            'model' => $validatedData['model']
        ]);
        $car->class = $validatedData['class'];
        $car->class2 = $validatedData['class2'];
        $prices = json_encode([
            'price_for_additional_driver' => 0,
            'price_per_extra_kilometer' => $validatedData['price_per_extra_kilometer'],
            'daily_price' => $validatedData['daily_price'],
            'deposito' => $validatedData['deposito'],
            'weekly_price' => $validatedData['weekly_price'],
            'weekday_price' => $validatedData['weekday_price'],
            'monthly_price' => $validatedData['monthly_price'],
            'weekend_price' => $validatedData['weekend_price'],
        ]);
        
        $kilometers = json_encode([
            'daily_kilometer' => $validatedData['daily_kilometer'],
            'weekly_kilometer' => $validatedData['weekly_kilometer'],
            'weekday_kilometer' => $validatedData['weekday_kilometer'],
            'monthly_kilometer' => $validatedData['monthly_kilometer'],
            'weekend_kilometer' => $validatedData['weekend_kilometer'],
        ]);
        
        $internalDamages = [];
        
        // Formdaki tüm iç hasar verilerini işleyelim
        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'internal_damage_description_') !== false) {
                // Description ve file'ı al
                $damageIndex = str_replace('internal_damage_description_', '', $key);
                $description = $request->input('internal_damage_description_' . $damageIndex);
                
                // Dosya varsa işle
                if ($request->hasFile('internal_damage_image_' . $damageIndex)) {
                    $file = $request->file('internal_damage_image_' . $damageIndex);
                    // Dosyayı public klasörüne kaydet
                    $extension = $file->getClientOriginalExtension(); // Örneğin, jpg, png, vb.
                    
                    // Benzersiz dosya adı oluştur
                    $fileName = uniqid() . '.' . $extension; 
                    $file->move(public_path('assets/images/internal_damages/'), $fileName);
                    
                    // Hasar bilgilerini array içine ekleyelim
                    $internalDamages[] = [
                        'description' => $description,
                        'image' => 'internal_damages/' . $fileName,  // public/internal_damages altında saklanacak yol
                    ];
                }
            }
        }
        $existingInternalDamages = json_decode($car->internal_damages, true) ?? [];
        $mergedInternalDamages = array_merge($existingInternalDamages, $internalDamages);
        $car->internal_damages = json_encode($mergedInternalDamages);
        
        $options = json_encode($request->input('options'), JSON_UNESCAPED_UNICODE);
        $car->options = $options;
        $car->odometer = $validatedData['odometer'];
        $car->vin = $validatedData['vin'];
        $car->age = $validatedData['min_age'];
        
        $carGroup = CarGroup::find($validatedData['car_group']);
        if (!$carGroup) {
            return redirect()->back()->withErrors(['message' => 'Grup bulunamadı.']);
        }
        $car->group_id = $validatedData['car_group'];
        $car->car_group = $carGroup->name;
        
        $car->description = $validatedData['desc'];
        $car->number_of_doors = $validatedData['number_of_doors'];
        $car->horse_power = $validatedData['horse_power'];
        $car->fuel = $validatedData['fuel'];
        $car->color = $validatedData['color'];
        
        $car->status = 1;
        $car->number_plate = $validatedData['number_plate'];
        $car->date_to_traffic = $validatedData['traffic_date'];
        $car->standard_exemption = $validatedData['standard_exemption'];
        
        $car->tire_type = $validatedData['tire_type'];
        $car->fuel_status = $validatedData['fuel_status'];
        $car->tire_size = $validatedData['tire_size'];
        $car->rim_size = $validatedData['rim_size'];
        $car->key_number = $validatedData['key_number'];
        
        
        
        
        $imagePaths = [];
        if($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $extension = $image->getClientOriginalExtension(); // Dosya uzantısını al
                $filename = uniqid() . '.' . $extension; // Benzersiz bir dosya adı oluştur
                $path = $image->move(public_path('assets/images/cars'), $filename);
                $imagePaths[] = 'assets/images/cars/' . $filename;
            }
        }
        $damages = [];
        $index = 1;
        
        while ($request->has('damage-description-' . $index)) {
            $description = $request->input('damage-description-' . $index);
            $x = $request->input('x-coordinate-' . $index);
            $y = $request->input('y-coordinate-' . $index);
            
            if ($request->hasFile('damage-photo-' . $index)) {
                $photoFile = $request->file('damage-photo-' . $index);
                $fileName = 'damage_' . time() . '_' . $index . '.' . $photoFile->getClientOriginalExtension();
                $directory = public_path('assets/images/damages');
                
                if (!file_exists($directory)) {
                    mkdir($directory, 0755, true);
                }
                
                $filePath = 'assets/images/damages/' . $fileName;
                $photoFile->move($directory, $fileName);
            } else {
                $filePath = null;
            }
            
            $damages[] = [
                'coordinates' => ['x' => $x, 'y' => $y],
                'description' => $description,
                'photo' => $filePath
            ];
            
            $index++;
        }
        $car->damages = json_encode($damages);
        $car->images = json_encode($imagePaths, JSON_UNESCAPED_SLASHES);
        $car->kilometers = $kilometers;
        $car->prices = $prices;
        $car->save();
        return redirect()->route('cars')->with('success', 'Car created successfully.');
    }
    protected function sanitizeFileName($fileName)
    {
        // Türkçe karakterleri İngilizceye çevir
        $fileName = str_replace(
            ['Ç', 'ç', 'Ğ', 'ğ', 'İ', 'ı', 'Ö', 'ö', 'Ş', 'ş', 'Ü', 'ü'],
            ['C', 'c', 'G', 'g', 'I', 'i', 'O', 'o', 'S', 's', 'U', 'u'],
            $fileName
        );
        
        // Boşlukları alt çizgiye çevir ve özel karakterleri kaldır
        $fileName = preg_replace('/[^A-Za-z0-9\-_\.]/', '', str_replace(' ', '_', $fileName));
        
        // Aynı dosya uzantısını kullanmak için dosya uzantısını ayrıştır
        return pathinfo($fileName, PATHINFO_FILENAME);
    }
    public function CarUpdate(Request $request, $id)
    {
        $user = auth()->user(); 
        $companyId = $user->company_id;
        $car = Car::findOrFail($id);
        $validatedData = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'class' => 'required|string|max:255',
            'class2' => 'required|string|max:255',
            'price_for_additional_driver' => 'nullable',
            'price_per_extra_kilometer' => 'required|numeric|min:0',
            'daily_price' => 'required|numeric|min:0',
            'deposito' => 'required|numeric|min:0',
            'weekly_price' => 'required|numeric|min:0',
            'weekday_price' => 'required|numeric|min:0',
            'monthly_price' => 'required|numeric|min:0',
            'weekend_price' => 'required|numeric|min:0',
            'daily_kilometer' => 'required|numeric|min:0',
            'weekly_kilometer' => 'required|numeric|min:0',
            'weekday_kilometer' => 'required|numeric|min:0',
            'monthly_kilometer' => 'required|numeric|min:0',
            'weekend_kilometer' => 'required|numeric|min:0',
            'odometer' => 'required|numeric|min:0',
            'vin' => 'required|string|max:255',
            'min_age' => 'required|integer|min:18',
            'car_group' => 'required|exists:car_groups,id',
            'desc' => 'nullable|string|max:1000',
            'number_of_doors' => 'nullable|integer',
            'horse_power' => 'nullable|min:0',
            'fuel' => 'required|string|max:50',
            'color' => 'required|string|max:50',
            'number_plate' => 'required|string|max:255',
            'traffic_date' => 'required|date',
            'standard_exemption' => 'required|numeric|min:0',
            'tire_type' => 'nullable|string|max:50',
            'fuel_status' => 'required|string|max:50',
            'tire_size' => 'nullable|string|max:50',
            'rim_size' => 'nullable|string|max:50',
            'key_number' => 'nullable|string|max:50',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'damage-description.*' => 'nullable|string|max:255',
            'x-coordinate.*' => 'nullable|numeric',
            'status' => 'nullable|numeric',
            'y-coordinate.*' => 'nullable|numeric',
            'damage-photo.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'internal_damage_description.*' => 'nullable|string|max:255',
            'internal_damage_image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'options' => 'required',
        ], [
            'brand.required' => 'The vehicle brand field is required.',
            'model.required' => 'The vehicle model field is required.',
            'class.required' => 'The vehicle class field is required.',
            'class2.required' => 'The vehicle class field is required.',
            'price_per_extra_kilometer.required' => 'The extra kilometer price is required.',
            'daily_price.required' => 'The daily price field is required.',
            'deposito.required' => 'The deposit field is required.',
            'weekly_price.required' => 'The weekly price field is required.',
            'weekday_price.required' => 'The weekday price field is required.',
            'monthly_price.required' => 'The monthly price field is required.',
            'weekend_price.required' => 'The weekend price field is required.',
            'daily_kilometer.required' => 'The daily kilometer is required.',
            'weekly_kilometer.required' => 'The weekly kilometer is required.',
            'weekday_kilometer.required' => 'The weekday kilometer is required.',
            'monthly_kilometer.required' => 'The monthly kilometer is required.',
            'weekend_kilometer.required' => 'The weekend kilometer is required.',
            'odometer.required' => 'The odometer is required.',
            'vin.required' => 'The VIN field is required.',
            'min_age.required' => 'The minimum age is required.',
            'min_age.min' => 'The minimum age must be at least 18.',
            'car_group.required' => 'The vehicle group selection is required.',
            'car_group.exists' => 'The selected vehicle group could not be found.',
            'fuel.required' => 'The fuel type field is required.',
            'color.required' => 'The color field is required.',
            'number_plate.required' => 'The number plate field is required.',
            'traffic_date.required' => 'The traffic release date is required.',
            'traffic_date.date' => 'Please enter a valid date.',
            'standard_exemption.required' => 'The standard exemption is required.',
            'images.*.image' => 'The uploaded file must be an image.',
            'options.required' => 'The options field is required.',
        ]);
        
        $carGroup = CarGroup::findOrFail($validatedData['car_group']);
        $car->company_id = $companyId;
        $car->car = json_encode([
            'brand' => $validatedData['brand'],
            'model' => $validatedData['model']
        ]);
        $prices = json_encode([
            'price_for_additional_driver' => 0,
            'price_per_extra_kilometer' => $validatedData['price_per_extra_kilometer'],
            'daily_price' => $validatedData['daily_price'],
            'deposito' => $validatedData['deposito'],
            'standard_exemption' => $validatedData['standard_exemption'],
            'weekly_price' => $validatedData['weekly_price'],
            'weekday_price' => $validatedData['weekday_price'],
            'monthly_price' => $validatedData['monthly_price'],
            'weekend_price' => $validatedData['weekend_price'],
        ]);
        
        $kilometers = json_encode([
            'daily_kilometer' => $validatedData['daily_kilometer'],
            'weekly_kilometer' => $validatedData['weekly_kilometer'],
            'weekday_kilometer' => $validatedData['weekday_kilometer'],
            'monthly_kilometer' => $validatedData['monthly_kilometer'],
            'weekend_kilometer' => $validatedData['weekend_kilometer'],
        ]);
        
        $existingDamages = [];
        $index = 1;
        
        while ($request->has("old_description_$index")) {
            $existingDamages[] = [
                'coordinates' => [
                    'x' => $request->input("old_x_cordinate_$index"),
                    'y' => $request->input("old_y_cordinate_$index")
                ],
                'description' => $request->input("old_description_$index"),
                'photo' => $request->input("old_image_$index")
            ];
            $index++;
        }
        
        $newDamages = [];
        $index = 1;
        
        while ($request->has("damage-description-$index")) {
            $description = $request->input("damage-description-$index");
            $xCoordinate = $request->input("x-coordinate-$index");
            $yCoordinate = $request->input("y-coordinate-$index");
            $photo = $request->file("damage-photo-$index");
            
            $photoPath = null;
            if ($photo) {
                $destinationPath = public_path('assets/images/damages');
                
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }
                
                $fileName = time() . '-' . $photo->getClientOriginalName();
                $photo->move($destinationPath, $fileName);
                $photoPath = 'assets/images/damages/' . $fileName;
            }
            
            // Yeni hasar bilgilerini dizine ekle
            $newDamages[] = [
                'coordinates' => ['x' => $xCoordinate, 'y' => $yCoordinate],
                'description' => $description,
                'photo' => $photoPath,
            ];
            
            $index++;
        }
        $allDamages = array_merge($existingDamages, $newDamages);
        
        $options = json_encode($request->input('options'), JSON_UNESCAPED_UNICODE);
        
        
        
        // Veritabanına güncellenmiş hasarları kaydet
        $car->damages = json_encode($allDamages);
        $car->options = $options;
        $car->odometer = $validatedData['odometer'];
        $car->class = $validatedData['class'];
        $car->class2 = $validatedData['class2'];
        $car->vin = $validatedData['vin'];
        $car->number_of_doors = $validatedData['number_of_doors'];
        $car->age = $validatedData['min_age'];
        $car->car_group = $carGroup->name;
        $car->group_id = $validatedData['car_group'];
        $car->description = $validatedData['desc'];
        $car->horse_power = $validatedData['horse_power'];
        $car->fuel = $validatedData['fuel'];
        $car->color = $validatedData['color'];
        $car->status = $validatedData['status'];
        $car->number_plate = $validatedData['number_plate'];
        $car->date_to_traffic = $validatedData['traffic_date'];
        $car->standard_exemption = $validatedData['standard_exemption'];
        $car->tire_type = $validatedData['tire_type'];
        $car->tire_size = $validatedData['tire_size'];
        $car->rim_size = $validatedData['rim_size'];
        $car->key_number = $validatedData['key_number'];
        $car->fuel_status = $validatedData['fuel_status'];
        
        
        
        
        $imagePaths = json_decode($car->images ?? '[]', true);
        if($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $extension = $image->getClientOriginalExtension();
                $filename = uniqid() . '.' . $extension; 
                $path = $image->move(public_path('assets/images/cars'), $filename);
                $imagePaths[] = 'assets/images/cars/' . $filename;
            }
        }
        
        $internalDamages = [];
        
        // Formdaki tüm iç hasar verilerini işleyelim
        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'internal_damage_description_') !== false) {
                // Description ve file'ı al
                $damageIndex = str_replace('internal_damage_description_', '', $key);
                $description = $request->input('internal_damage_description_' . $damageIndex);
                
                // Dosya varsa işle
                if ($request->hasFile('internal_damage_image_' . $damageIndex)) {
                    $file = $request->file('internal_damage_image_' . $damageIndex);
                    
                    // Orijinal dosya adını al ve özel karakterleri temizle
                    $extension = $file->getClientOriginalExtension(); // Örneğin, jpg, png, vb.
                    
                    // Benzersiz dosya adı oluştur
                    $fileName = uniqid() . '.' . $extension; 
                    $file->move(public_path('assets/images/internal_damages/'), $fileName);
                    
                    // Hasar bilgilerini array içine ekleyelim
                    $internalDamages[] = [
                        'description' => $description,
                        'image' => 'assets/images/' . $fileName,  // public/assets/images altında saklanacak yol
                    ];
                }
            }
        }
        // Mevcut iç hasarlar varsa, yenileriyle birleştir
        $existingInternalDamages = json_decode($car->internal_damages, true) ?? [];
        $mergedInternalDamages = array_merge($existingInternalDamages, $internalDamages);
        
        // İç hasarları JSON formatında kaydet
        $car->internal_damages = json_encode($mergedInternalDamages);
        $car->images = json_encode($imagePaths, JSON_UNESCAPED_SLASHES);
        $car->kilometers = $kilometers;
        $car->prices = $prices;
        $car->save();
        return redirect()->route('cars')->with('success', 'Car updated successfully.');
    }
    public function CarDelete($id)
    {
        $user = Auth::user(); 
        $companyId = $user->company_id;
        
        $car = Car::where('id', $id)->where('company_id', $companyId)->first();
        
        if (!$car) {
            abort(404, 'Araba bulunamadı veya bu araca silme yetkiniz yok.');
        }
        
        if ($car->images) {
            $images = json_decode($car->images, true);
            foreach ($images as $image) {
                if (file_exists(public_path('path/to/images/' . $image))) {
                    unlink(public_path('path/to/images/' . $image));
                }
            }
        }
        
        $car->delete();
        
        return redirect()->route('cars')->with('success', 'Araba başarıyla silindi.');
    }
    
    public function deleteImage(Request $request)
    {
        $imagePath = $request->input('image_path');
        $carId = $request->input('car_id');
        
        $car = Car::find($carId);
        if ($car) {
            $imagePaths = json_decode($car->images ?? '[]', true);
            if (($key = array_search($imagePath, $imagePaths)) !== false) {
                unset($imagePaths[$key]);
                $car->images = json_encode(array_values($imagePaths), JSON_UNESCAPED_SLASHES);
                $car->save();
            }
            
            // Ayrıca, sunucudan dosyayı silmek isterseniz:
            if (file_exists(public_path($imagePath))) {
                unlink(public_path($imagePath));
            }
            
            return response()->json(['status' => 'success'], 200);
        }
        
        return response()->json(['status' => 'error', 'message' => 'Car not found'], 404);
    }
    public function CarCopy($id)
    {
        $car = Car::findOrFail($id);

        $newCar = $car->replicate(); 
        $newCar->id = null; 
        $newCar->save();
    
        return redirect()->back()->with('success', 'The car has been copied successfully!');
    }
    // group
    
    
    public function CarGroupAdd()
    {
        return view('company.cars.car-group-add');
    }
    public function carGroups()
    {
        $companyId = Auth::user()->company_id;
        
        $carGroups = CarGroup::where('company_id', $companyId)->get();
        return view('company.cars.car-groups',compact('carGroups'));
    }
    public function CarGroupEdit($id)
    {
        $carGroup = CarGroup::findOrFail($id);
        
        return view('company.cars.car-group-edit', compact('carGroup'));
    }
    public function CarGroupStore(Request $request)
    {
        $companyId = Auth::user()->company_id;
        $carGroup = new CarGroup();
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price_for_additional_driver' => 'nullable',
            'price_per_extra_kilometer' => 'required|numeric',
            'daily_price' => 'required|numeric',
            'deposito' => 'required|numeric',
            'standard_exemption' => 'required|numeric',
            'weekly_price' => 'required|numeric',
            'weekday_price' => 'required|numeric',
            'monthly_price' => 'required|numeric',
            'weekend_price' => 'required|numeric',
            'daily_kilometer' => 'required|numeric',
            'weekly_kilometer' => 'required|numeric',
            'weekday_kilometer' => 'required|numeric',
            'monthly_kilometer' => 'required|numeric',
            'weekend_kilometer' => 'required|numeric',
        ], [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 255 characters.',
            'price_per_extra_kilometer.required' => 'The price per extra kilometer is required.',
            'price_per_extra_kilometer.numeric' => 'The price per extra kilometer must be a number.',
            'daily_price.required' => 'The daily price is required.',
            'daily_price.numeric' => 'The daily price must be a number.',
            'deposito.required' => 'The deposit is required.',
            'deposito.numeric' => 'The deposit must be a number.',
            'standard_exemption.required' => 'The standard exemption is required.',
            'standard_exemption.numeric' => 'The standard exemption must be a number.',
            'weekly_price.required' => 'The weekly price is required.',
            'weekly_price.numeric' => 'The weekly price must be a number.',
            'weekday_price.required' => 'The weekday price is required.',
            'weekday_price.numeric' => 'The weekday price must be a number.',
            'monthly_price.required' => 'The monthly price is required.',
            'monthly_price.numeric' => 'The monthly price must be a number.',
            'weekend_price.required' => 'The weekend price is required.',
            'weekend_price.numeric' => 'The weekend price must be a number.',
            'daily_kilometer.required' => 'The daily kilometer is required.',
            'daily_kilometer.numeric' => 'The daily kilometer must be a number.',
            'weekly_kilometer.required' => 'The weekly kilometer is required.',
            'weekly_kilometer.numeric' => 'The weekly kilometer must be a number.',
            'weekday_kilometer.required' => 'The weekday kilometer is required.',
            'weekday_kilometer.numeric' => 'The weekday kilometer must be a number.',
            'monthly_kilometer.required' => 'The monthly kilometer is required.',
            'monthly_kilometer.numeric' => 'The monthly kilometer must be a number.',
            'weekend_kilometer.required' => 'The weekend kilometer is required.',
            'weekend_kilometer.numeric' => 'The weekend kilometer must be a number.',
        ]);
        
        $prices = json_encode([
            'price_for_additional_driver' => 0,
            'price_per_extra_kilometer' => $data['price_per_extra_kilometer'],
            'daily_price' => $data['daily_price'],
            'deposito' => $data['deposito'],
            'standard_exemption' => $data['standard_exemption'],
            'weekly_price' => $data['weekly_price'],
            'weekday_price' => $data['weekday_price'],
            'monthly_price' => $data['monthly_price'],
            'weekend_price' => $data['weekend_price'],
        ]);
        
        $kilometers = json_encode([
            'daily_kilometer' => $data['daily_kilometer'],
            'weekly_kilometer' => $data['weekly_kilometer'],
            'weekday_kilometer' => $data['weekday_kilometer'],
            'monthly_kilometer' => $data['monthly_kilometer'],
            'weekend_kilometer' => $data['weekend_kilometer'],
        ]);
        
        $kmPackages = [];
        
        foreach ($request->all() as $key => $value) {
            if (preg_match('/^kilometers_kilometer(_\d+)?$/', $key, $matches)) {
                $index = isset($matches[1]) ? substr($matches[1], 1) : 0;
                $kmPackages[$index]['kilometers'] = $value;
            } elseif (preg_match('/^kilometers_extra_price(_\d+)?$/', $key, $matches)) {
                $index = isset($matches[1]) ? substr($matches[1], 1) : 0;
                $kmPackages[$index]['extra_price'] = $value;
            }
        }
        
        ksort($kmPackages);
        
        $kmPackagesFormatted = [];
        foreach ($kmPackages as $index => $package) {
            $kmPackagesFormatted[] = [
                'kilometers' => isset($package['kilometers']) ? $package['kilometers'] : '',
                'extra_price' => isset($package['extra_price']) ? $package['extra_price'] : '',
            ];
        }
        
        
        
        $insurancePackages = [];
        
        foreach ($request->all() as $key => $value) {
            if (preg_match('/^insurance_deductible(_\d+)?$/', $key, $matches)) {
                $index = isset($matches[1]) ? substr($matches[1], 1) : 0;
                $insurancePackages[$index]['deductible'] = $value;
            } elseif (preg_match('/^insurance_price_day(_\d+)?$/', $key, $matches)) {
                $index = isset($matches[1]) ? substr($matches[1], 1) : 0;
                $insurancePackages[$index]['price_per_day'] = $value;
            }
        }
        
        ksort($insurancePackages);
        
        $insurancePackagesFormatted = [];
        foreach ($insurancePackages as $index => $package) {
            $insurancePackagesFormatted[] = [
                'deductible' => isset($package['deductible']) ? $package['deductible'] : '',
                'price_per_day' => isset($package['price_per_day']) ? $package['price_per_day'] : ''
            ];
        }
        
        $carGroup->name = $data['name'];
        $carGroup->prices = $prices;
        $carGroup->kilometers = $kilometers;
        $carGroup->km_packages = $kmPackagesFormatted;
        $carGroup->insurance_packages = $insurancePackages;
        $carGroup->company_id = $companyId;
        $carGroup->save();
        return redirect()->route('cars.groups')->with('success', 'Car group created successfully.');
    }
    public function CarGroupUpdate(Request $request, $id)
    {        
        $carGroup = CarGroup::findOrFail($id);
        
        $carGroup->name = $request->name;
        $request->validate([
            'name' => 'required|string|max:255',
            'price_for_additional_driver' => 'nullable',
            'price_per_extra_kilometer' => 'required|numeric',
            'daily_price' => 'required|numeric',
            'deposito' => 'required|numeric',
            'standard_exemption' => 'required|numeric',
            'weekly_price' => 'required|numeric',
            'weekday_price' => 'required|numeric',
            'monthly_price' => 'required|numeric',
            'weekend_price' => 'required|numeric',
            'daily_kilometer' => 'required|numeric',
            'weekly_kilometer' => 'required|numeric',
            'weekday_kilometer' => 'required|numeric',
            'monthly_kilometer' => 'required|numeric',
            'weekend_kilometer' => 'required|numeric',
        ], [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 255 characters.',
            'price_per_extra_kilometer.required' => 'The price per extra kilometer is required.',
            'price_per_extra_kilometer.numeric' => 'The price per extra kilometer must be a number.',
            'daily_price.required' => 'The daily price is required.',
            'daily_price.numeric' => 'The daily price must be a number.',
            'deposito.required' => 'The deposit is required.',
            'deposito.numeric' => 'The deposit must be a number.',
            'standard_exemption.required' => 'The standard exemption is required.',
            'standard_exemption.numeric' => 'The standard exemption must be a number.',
            'weekly_price.required' => 'The weekly price is required.',
            'weekly_price.numeric' => 'The weekly price must be a number.',
            'weekday_price.required' => 'The weekday price is required.',
            'weekday_price.numeric' => 'The weekday price must be a number.',
            'monthly_price.required' => 'The monthly price is required.',
            'monthly_price.numeric' => 'The monthly price must be a number.',
            'weekend_price.required' => 'The weekend price is required.',
            'weekend_price.numeric' => 'The weekend price must be a number.',
            'daily_kilometer.required' => 'The daily kilometer is required.',
            'daily_kilometer.numeric' => 'The daily kilometer must be a number.',
            'weekly_kilometer.required' => 'The weekly kilometer is required.',
            'weekly_kilometer.numeric' => 'The weekly kilometer must be a number.',
            'weekday_kilometer.required' => 'The weekday kilometer is required.',
            'weekday_kilometer.numeric' => 'The weekday kilometer must be a number.',
            'monthly_kilometer.required' => 'The monthly kilometer is required.',
            'monthly_kilometer.numeric' => 'The monthly kilometer must be a number.',
            'weekend_kilometer.required' => 'The weekend kilometer is required.',
            'weekend_kilometer.numeric' => 'The weekend kilometer must be a number.',
        ]);
        $prices = json_encode([
            'price_for_additional_driver' => 0,
            'price_per_extra_kilometer' => $request['price_per_extra_kilometer'],
            'daily_price' => $request['daily_price'],
            'deposito' => $request['deposito'],
            'standard_exemption' => $request['standard_exemption'],
            'weekly_price' => $request['weekly_price'],
            'weekday_price' => $request['weekday_price'],
            'monthly_price' => $request['monthly_price'],
            'weekend_price' => $request['weekend_price'],
        ]);
        
        $kilometers = json_encode([
            'daily_kilometer' => $request['daily_kilometer'],
            'weekly_kilometer' => $request['weekly_kilometer'],
            'weekday_kilometer' => $request['weekday_kilometer'],
            'monthly_kilometer' => $request['monthly_kilometer'],
            'weekend_kilometer' => $request['weekend_kilometer'],
        ]);
        $carGroup->prices = $prices;
        $carGroup->kilometers = $kilometers;
        
        $kmPackages = [];
        if ($request->has('kilometers')) {
            foreach ($request->kilometers as $key => $value) {
                $kmPackages[] = [
                    'kilometers' => $value['kilometer'],
                    'extra_price' => $value['extra_price']
                ];
            }
        }
        
        $insurancePackages = [];
        if ($request->has('insurance_packages')) {
            foreach ($request->insurance_packages as $key => $value) {
                $insurancePackages[] = [
                    'deductible' => $value['deductible'],
                    'price_per_day' => $value['price_per_day']
                ];
            }
        }
        $carGroup->km_packages = $kmPackages;
        $carGroup->insurance_packages = $insurancePackages;
        $carGroup->save();
        
        return redirect()->route('cars.groups')->with('success', 'Car group updated successfully.');
    }
    public function CarGroupDelete($id)
    {
        $user = Auth::user(); 
        $companyId = $user->company_id;
        
        $car = CarGroup::where('id', $id)->where('company_id', $companyId)->first();
        
        if (!$car) {
            abort(404, 'Araba Grubu bulunamadı veya bu Grubu silme yetkiniz yok.');
        }
        
        $car->delete();
        
        return redirect()->route('cars.groups')->with('success', 'Araba başarıyla silindi.');
    }
    
}
