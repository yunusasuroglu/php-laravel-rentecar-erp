<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Language;
use App\Models\Translation;
use App\Models\TranslationKey;

class TranslationSeeder extends Seeder
{
    
    public function run()
    {
        // Tüm translation keys'i al
        $translationKeys = TranslationKey::all()->keyBy('key');
        
        // Dil bilgilerini al
        $languages = Language::all()->keyBy('code');
        
        // Çevirileri tanımla
        $translations = [
            'sidebar_main_menu' => [
                'en' => 'Main Menu'
            ],
            'sidebar_home' => [
                'en' => 'Home'
            ],
            'sidebar_users' => [
                'en' => 'Users'
            ],
            'sidebar_companys' => [
                'en' => 'Companies'
            ],
            'sidebar_roles' => [
                'en' => 'Roles'
            ],
            'sidebar_settings' => [
                'en' => 'Settings'
            ],
            'sidebar_languages' => [
                'en' => 'Languages'
            ],
            'sidebar_software_settings' => [
                'en' => 'Software Settings'
            ],
            'sidebar_customers' => [
                'en' => 'Customers'
            ],
            'sidebar_employees' => [
                'en' => 'Employees'
            ],
            'sidebar_add_employees' => [
                'en' => 'Add Employee'
            ],
            'sidebar_persons' => [
                'en' => 'Persons'
            ],
            'sidebar_persons_customers' => [
                'en' => 'Customers'
            ],
            'sidebar_persons_carriers' => [
                'en' => 'Carriers'
            ],
            'sidebar_add_person' => [
                'en' => 'Add Person'
            ],
            'sidebar_shipments' => [
                'en' => 'Shipments'
            ],
            'sidebar_add_shipment' => [
                'en' => 'Add Shipment'
            ],
            'sidebar_support' => [
                'en' => 'Support'
            ],
            'header_notifications' => [
                'en' => 'Notifications'
            ],
            'header_notifications_unread' => [
                'en' => 'Unread Notifications'
            ],
            'header_fast_access' => [
                'en' => 'Fast Access'
            ],
            'header_profile' => [
                'en' => 'Profile'
            ],
            'header_logout' => [
                'en' => 'Logout'
            ],
            'home_title' => [
                'en' => 'Home'
            ],
            'home_name' => [
                'en' => 'Home Name'
            ],
            'employees_table_page_title' => [
                'en' => 'Employees'
            ],
            'employees_table_name' => [
                'en' => 'Name'
            ],
            'employees_table_home' => [
                'en' => 'Home'
            ],
            'employees_table_add_employee' => [
                'en' => 'Add Employee'
            ],
            'employees_table_name_surname' => [
                'en' => 'Name Surname'
            ],
            'employees_table_phone' => [
                'en' => 'Phone'
            ],
            'employees_table_company' => [
                'en' => 'Company'
            ],
            'employees_table_email' => [
                'en' => 'Email'
            ],
            'employees_table_class' => [
                'en' => 'Class'
            ],
            'employees_table_status' => [
                'en' => 'Status', 'tr' => 'Durum', 'de' => 'Status'
            ],
            'employees_table_status_active' => [
                'en' => 'Active', 'tr' => 'Aktif', 'de' => 'Aktiv'
            ],
            'employees_table_status_approve' => [
                'en' => 'Approve', 'tr' => 'Onayla', 'de' => 'Genehmigen'
            ],
            'employees_table_detail' => [
                'en' => 'Detail', 'tr' => 'Detay', 'de' => 'Detail'
            ],
            'employees_table_conpany_not_found' => [
                'en' => 'Company Not Found', 'tr' => 'Şirket Bulunamadı', 'de' => 'Firma Nicht Gefunden'
            ],
            'employees_table_detail_edit' => [
                'en' => 'Edit', 'tr' => 'Düzenle', 'de' => 'Bearbeiten'
            ],
            'employees_table_detail_delete' => [
                'en' => 'Delete', 'tr' => 'Sil', 'de' => 'Löschen'
            ],
            'employee_title' => [
                'en' => 'Employee', 'tr' => 'Çalışan', 'de' => 'Mitarbeiter'
            ],
            'employee_add_page_title' => [
                'en' => 'Add Employee', 'tr' => 'Çalışan Ekle', 'de' => 'Mitarbeiter Hinzufügen'
            ],
            'employee_add_name' => [
                'en' => 'Name', 'tr' => 'İsim', 'de' => 'Name'
            ],
            'employee_add_employees' => [
                'en' => 'Employees', 'tr' => 'Çalışanlar', 'de' => 'Mitarbeiter'
            ],
            'employee_add_form_name' => [
                'en' => 'Name', 'tr' => 'İsim', 'de' => 'Name'
            ],
            'employee_add_form_surname' => [
                'en' => 'Surname', 'tr' => 'Soyisim', 'de' => 'Nachname'
            ],
            'employee_add_form_phone' => [
                'en' => 'Phone', 'tr' => 'Telefon', 'de' => 'Telefon'
            ],
            'employee_add_form_email' => [
                'en' => 'Email', 'tr' => 'E-posta', 'de' => 'E-Mail'
            ],
            'employee_add_form_class' => [
                'en' => 'Class', 'tr' => 'Sınıf', 'de' => 'Klasse'
            ],
            'employee_add_form_country' => [
                'en' => 'Country', 'tr' => 'Ülke', 'de' => 'Land'
            ],
            'employee_add_form_city' => [
                'en' => 'City', 'tr' => 'Şehir', 'de' => 'Stadt'
            ],
            'employee_add_form_street' => [
                'en' => 'Street', 'tr' => 'Sokak', 'de' => 'Straße'
            ],
            'employee_add_form_zip_code' => [
                'en' => 'Zip Code', 'tr' => 'Posta Kodu', 'de' => 'Postleitzahl'
            ],
            'employee_add_form_address' => [
                'en' => 'Address', 'tr' => 'Adres', 'de' => 'Adresse'
            ],
            'employee_add_form_password' => [
                'en' => 'Password', 'tr' => 'Şifre', 'de' => 'Passwort'
            ],
            'employee_add_form_password_confirm' => [
                'en' => 'Confirm Password', 'tr' => 'Şifreyi Onayla', 'de' => 'Passwort Bestätigen'
            ],
            'employee_add_form_placeholder_name' => [
                'en' => 'Enter Name', 'tr' => 'İsim Girin', 'de' => 'Name Eingeben'
            ],
            'employee_add_form_placeholder_surname' => [
                'en' => 'Enter Surname', 'tr' => 'Soyisim Girin', 'de' => 'Nachname Eingeben'
            ],
            'employee_add_form_placeholder_phone' => [
                'en' => 'Enter Phone', 'tr' => 'Telefon Girin', 'de' => 'Telefon Eingeben'
            ],
            'employee_add_form_placeholder_email' => [
                'en' => 'Enter Email', 'tr' => 'E-posta Girin', 'de' => 'E-Mail Eingeben'
            ],
            'employee_add_form_placeholder_class' => [
                'en' => 'Enter Class', 'tr' => 'Sınıf Girin', 'de' => 'Klasse Eingeben'
            ],
            'employee_add_form_placeholder_country' => [
                'en' => 'Enter Country', 'tr' => 'Ülke Girin', 'de' => 'Land Eingeben'
            ],
            'employee_add_form_placeholder_city' => [
                'en' => 'Enter City', 'tr' => 'Şehir Girin', 'de' => 'Stadt Eingeben'
            ],
            'employee_add_form_placeholder_street' => [
                'en' => 'Enter Street', 'tr' => 'Sokak Girin', 'de' => 'Straße Eingeben'
            ],
            'employee_add_form_placeholder_zip_code' => [
                'en' => 'Enter Zip Code', 'tr' => 'Posta Kodu Girin', 'de' => 'Postleitzahl Eingeben'
            ],
            'employee_add_form_placeholder_address' => [
                'en' => 'Enter Address', 'tr' => 'Adres Girin', 'de' => 'Adresse Eingeben'
            ],
            'employee_add_form_placeholder_password' => [
                'en' => 'Enter Password', 'tr' => 'Şifre Girin', 'de' => 'Passwort Eingeben'
            ],
            'employee_add_form_placeholder_password_confirm' => [
                'en' => 'Confirm Password', 'tr' => 'Şifreyi Onayla', 'de' => 'Passwort Bestätigen'
            ],
            'employee_add_form_create' => [
                'en' => 'Create', 'tr' => 'Oluştur', 'de' => 'Erstellen'
            ],
            'employee_edit_page_title' => [
                'en' => 'Edit Employee', 'tr' => 'Çalışan Düzenle', 'de' => 'Mitarbeiter Bearbeiten'
            ],
            'employee_edit_name' => [
                'en' => 'Name', 'tr' => 'İsim', 'de' => 'Name'
            ],
            'employee_edit_employees' => [
                'en' => 'Employees', 'tr' => 'Çalışanlar', 'de' => 'Mitarbeiter'
            ],
            'employee_edit_form_name' => [
                'en' => 'Name', 'tr' => 'İsim', 'de' => 'Name'
            ],
            'employee_edit_form_surname' => [
                'en' => 'Surname', 'tr' => 'Soyisim', 'de' => 'Nachname'
            ],
            'employee_edit_form_phone' => [
                'en' => 'Phone', 'tr' => 'Telefon', 'de' => 'Telefon'
            ],
            'employee_edit_form_email' => [
                'en' => 'Email', 'tr' => 'E-posta', 'de' => 'E-Mail'
            ],
            'employee_edit_form_class' => [
                'en' => 'Class', 'tr' => 'Sınıf', 'de' => 'Klasse'
            ],
            'employee_edit_form_country' => [
                'en' => 'Country', 'tr' => 'Ülke', 'de' => 'Land'
            ],
            'employee_edit_form_city' => [
                'en' => 'City', 'tr' => 'Şehir', 'de' => 'Stadt'
            ],
            'employee_edit_form_street' => [
                'en' => 'Street', 'tr' => 'Sokak', 'de' => 'Straße'
            ],
            'employee_edit_form_zip_code' => [
                'en' => 'Zip Code', 'tr' => 'Posta Kodu', 'de' => 'Postleitzahl'
            ],
            'employee_edit_form_address' => [
                'en' => 'Address', 'tr' => 'Adres', 'de' => 'Adresse'
            ],
            'employee_edit_form_placeholder_name' => [
                'en' => 'Enter Name', 'tr' => 'İsim Girin', 'de' => 'Name Eingeben'
            ],
            'employee_edit_form_placeholder_surname' => [
                'en' => 'Enter Surname', 'tr' => 'Soyisim Girin', 'de' => 'Nachname Eingeben'
            ],
            'employee_edit_form_placeholder_phone' => [
                'en' => 'Enter Phone', 'tr' => 'Telefon Girin', 'de' => 'Telefon Eingeben'
            ],
            'employee_edit_form_placeholder_email' => [
                'en' => 'Enter Email', 'tr' => 'E-posta Girin', 'de' => 'E-Mail Eingeben'
            ],
            'employee_edit_form_placeholder_class' => [
                'en' => 'Enter Class', 'tr' => 'Sınıf Girin', 'de' => 'Klasse Eingeben'
            ],
            'employee_edit_form_placeholder_country' => [
                'en' => 'Enter Country', 'tr' => 'Ülke Girin', 'de' => 'Land Eingeben'
            ],
            'employee_edit_form_placeholder_city' => [
                'en' => 'Enter City', 'tr' => 'Şehir Girin', 'de' => 'Stadt Eingeben'
            ],
            'employee_edit_form_placeholder_street' => [
                'en' => 'Enter Street', 'tr' => 'Sokak Girin', 'de' => 'Straße Eingeben'
            ],
            'employee_edit_form_placeholder_zip_code' => [
                'en' => 'Enter Zip Code', 'tr' => 'Posta Kodu Girin', 'de' => 'Postleitzahl Eingeben'
            ],
            'employee_edit_form_placeholder_address' => [
                'en' => 'Enter Address', 'tr' => 'Adres Girin', 'de' => 'Adresse Eingeben'
            ],
            'employee_edit_form_edit' => [
                'en' => 'Edit', 'tr' => 'Düzenle', 'de' => 'Bearbeiten'
            ],
            'employee_edit_password_form_name' => [
                'en' => 'Name', 'tr' => 'İsim', 'de' => 'Name'
            ],
            'employee_edit_password_form_password' => [
                'en' => 'Password', 'tr' => 'Şifre', 'de' => 'Passwort'
            ],
            'employee_edit_password_form_password_confirm' => [
                'en' => 'Confirm Password', 'tr' => 'Şifreyi Onayla', 'de' => 'Passwort Bestätigen'
            ],
            'employee_edit_password_form_placeholder_password' => [
                'en' => 'Enter Password', 'tr' => 'Şifre Girin', 'de' => 'Passwort Eingeben'
            ],
            'employee_edit_password_form_placeholder_password_confirm' => [
                'en' => 'Confirm Password', 'tr' => 'Şifreyi Onayla', 'de' => 'Passwort Bestätigen'
            ],
            'persons_page_title' => [
                'en' => 'Persons', 'tr' => 'Kişiler', 'de' => 'Personen'
            ],
            'persons_page_name' => [
                'en' => 'Persons', 'tr' => 'Kişiler', 'de' => 'Personen'
            ],
            'persons_page_home' => [
                'en' => 'Home', 'tr' => 'Anasayfa', 'de' => 'Startseite'
            ],
            'persons_person_add' => [
                'en' => 'Add Person', 'tr' => 'Kişi Ekle', 'de' => 'Person Hinzufügen'
            ],
            'persons_table_name' => [
                'en' => 'Name', 'tr' => 'İsim', 'de' => 'Name'
            ],
            'persons_table_surname' => [
                'en' => 'Surname', 'tr' => 'Soyisim', 'de' => 'Nachname'
            ],
            'persons_table_phone' => [
                'en' => 'Phone', 'tr' => 'Telefon', 'de' => 'Telefon'
            ],
            'persons_table_company' => [
                'en' => 'Company', 'tr' => 'Şirket', 'de' => 'Firma'
            ],
            'persons_table_email' => [
                'en' => 'Email', 'tr' => 'E-posta', 'de' => 'E-Mail'
            ],
            'persons_table_person_type' => [
                'en' => 'Person Type', 'tr' => 'Kişi Türü', 'de' => 'Personentyp'
            ],
            'persons_table_person_type_customer' => [
                'en' => 'Customer', 'tr' => 'Müşteri', 'de' => 'Kunde'
            ],
            'persons_table_person_type_carrier' => [
                'en' => 'Carrier', 'tr' => 'Taşıyıcı', 'de' => 'Träger'
            ],
            'persons_table_detail' => [
                'en' => 'Detail', 'tr' => 'Detay', 'de' => 'Detail'
            ],
            'persons_table_edit' => [
                'en' => 'Edit', 'tr' => 'Düzenle', 'de' => 'Bearbeiten'
            ],
            'persons_table_delete' => [
                'en' => 'Delete', 'tr' => 'Sil', 'de' => 'Löschen'
            ],
            'persons_add_page_title' => [
                'en' => 'Add Person', 'tr' => 'Kişi Ekle', 'de' => 'Person Hinzufügen'
            ],
            'persons_add_name' => [
                'en' => 'Name', 'tr' => 'İsim', 'de' => 'Name'
            ],
            'persons_add_persons' => [
                'en' => 'Persons', 'tr' => 'Kişiler', 'de' => 'Personen'
            ],
            'persons_add_form_title' => [
                'en' => 'Add Person', 'tr' => 'Kişi Ekle', 'de' => 'Person Hinzufügen'
            ],
            'persons_add_form_name_surname' => [
                'en' => 'Name Surname', 'tr' => 'Ad Soyad', 'de' => 'Name Nachname'
            ],
            'persons_add_form_phone' => [
                'en' => 'Phone', 'tr' => 'Telefon', 'de' => 'Telefon'
            ],
            'persons_add_form_company' => [
                'en' => 'Company', 'tr' => 'Şirket', 'de' => 'Firma'
            ],
            'persons_add_form_email' => [
                'en' => 'Email', 'tr' => 'E-posta', 'de' => 'E-Mail'
            ],
            'persons_add_form_person_type' => [
                'en' => 'Person Type', 'tr' => 'Kişi Türü', 'de' => 'Personentyp'
            ],
            'persons_add_form_country' => [
                'en' => 'Country', 'tr' => 'Ülke', 'de' => 'Land'
            ],
            'persons_add_form_city' => [
                'en' => 'City', 'tr' => 'Şehir', 'de' => 'Stadt'
            ],
            'persons_add_form_street' => [
                'en' => 'Street', 'tr' => 'Sokak', 'de' => 'Straße'
            ],
            'persons_add_form_zip_code' => [
                'en' => 'Zip Code', 'tr' => 'Posta Kodu', 'de' => 'Postleitzahl'
            ],
            'persons_add_form_address' => [
                'en' => 'Address', 'tr' => 'Adres', 'de' => 'Adresse'
            ],
            'persons_add_form_person_type_customer' => [
                'en' => 'Customer', 'tr' => 'Müşteri', 'de' => 'Kunde'
            ],
            'persons_add_form_person_type_carrier' => [
                'en' => 'Carrier', 'tr' => 'Taşıyıcı', 'de' => 'Träger'
            ],
            'persons_add_form_placeholder_name_surname' => [
                'en' => 'Enter Name Surname', 'tr' => 'Ad Soyad Girin', 'de' => 'Name Nachname Eingeben'
            ],
            'persons_add_form_placeholder_phone' => [
                'en' => 'Enter Phone', 'tr' => 'Telefon Girin', 'de' => 'Telefon Eingeben'
            ],
            'persons_add_form_placeholder_company' => [
                'en' => 'Enter Company', 'tr' => 'Şirket Girin', 'de' => 'Firma Eingeben'
            ],
            'persons_add_form_placeholder_email' => [
                'en' => 'Enter Email', 'tr' => 'E-posta Girin', 'de' => 'E-Mail Eingeben'
            ],
            'persons_add_form_placeholder_country' => [
                'en' => 'Enter Country', 'tr' => 'Ülke Girin', 'de' => 'Land Eingeben'
            ],
            'persons_add_form_placeholder_city' => [
                'en' => 'Enter City', 'tr' => 'Şehir Girin', 'de' => 'Stadt Eingeben'
            ],
            'persons_add_form_placeholder_street' => [
                'en' => 'Enter Street', 'tr' => 'Sokak Girin', 'de' => 'Straße Eingeben'
            ],
            'persons_add_form_placeholder_zip_code' => [
                'en' => 'Enter Zip Code', 'tr' => 'Posta Kodu Girin', 'de' => 'Postleitzahl Eingeben'
            ],
            'persons_add_form_placeholder_address' => [
                'en' => 'Enter Address', 'tr' => 'Adres Girin', 'de' => 'Adresse Eingeben'
            ],
            'persons_add_form_create' => [
                'en' => 'Create', 'tr' => 'Oluştur', 'de' => 'Erstellen'
            ],
        ];
        
        // Her bir çeviri için
        foreach ($translations as $translationKey => $values) {
            // Eğer translation key varsa devam et
            if ($translationKeys->has($translationKey)) {
                // Anahtar için id'yi al
                $translationKeyId = $translationKeys[$translationKey]->id;
                
                foreach ($values as $langCode => $value) {
                    // Dil koduna göre dil var mı kontrol et
                    if ($languages->has($langCode)) {
                        $languageId = $languages[$langCode]->id;
                        
                        // Eğer çeviri zaten varsa atla
                        if (Translation::where('key_id', $translationKeyId)
                        ->where('language_id', $languageId)
                        ->exists()) {
                            continue;
                        }
                        
                        // Yeni çeviriyi oluştur
                        Translation::create([
                            'key_id' => $translationKeyId,
                            'language_id' => $languageId,
                            'value' => $value,
                        ]);
                    }
                }
            }
        }
    }
}
