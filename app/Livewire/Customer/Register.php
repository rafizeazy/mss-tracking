<?php

namespace App\Livewire\Customer;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Registrasi Layanan')]
#[Layout('layouts.guest')]
class Register extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $accepted_terms; 

    public $company_name;
    public $ktp_number;
    public $gender;
    public $position;
    public $phone;
    public $business_type;
    public $npwp_number;
    public $company_phone;
    public $company_address;
    public $city;
    public $province;
    public $postal_code;

    public $finance_name;
    public $finance_position;
    public $finance_phone;
    public $finance_email;
    public $billing_address;

    public $technical_name;
    public $technical_department; // Field baru di desain HTML Anda
    public $technical_position;
    public $technical_phone;
    public $technical_email;
    public $installation_address;

    public $service_type;
    public $term_of_service;

    public $ktp_file;
    public $npwp_file;
    public $nib_file;
    public $certificate_file;

    public function submit()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'accepted_terms' => 'accepted',
            
            'company_name' => 'required|string|max:255',
            'ktp_number' => 'required|string|max:50',
            'gender' => 'required|in:L,P',
            'position' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'business_type' => 'nullable|string|max:255',
            'npwp_number' => 'nullable|string|max:50',
            'company_phone' => 'nullable|string|max:20',
            'company_address' => 'required|string',
            'city' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:10',
            
            'finance_name' => 'nullable|string|max:255',
            'finance_position' => 'nullable|string|max:255',
            'finance_phone' => 'nullable|string|max:20',
            'finance_email' => 'nullable|email|max:255',
            'billing_address' => 'nullable|string',
            
            'technical_name' => 'nullable|string|max:255',
            'technical_department' => 'nullable|string|max:255',
            'technical_position' => 'nullable|string|max:255',
            'technical_phone' => 'nullable|string|max:20',
            'technical_email' => 'nullable|email|max:255',
            'installation_address' => 'nullable|string',
            
            'service_type' => 'required|string|max:255',
            'term_of_service' => 'required|integer|min:1',
            
            'ktp_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'npwp_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'nib_file' => 'nullable|file|mimes:pdf|max:2048',
            'certificate_file' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $ktpPath = $this->ktp_file ? $this->ktp_file->store('documents/ktp', 'public') : null;
        $npwpPath = $this->npwp_file ? $this->npwp_file->store('documents/npwp', 'public') : null;
        $nibPath = $this->nib_file ? $this->nib_file->store('documents/nib', 'public') : null;
        $certificatePath = $this->certificate_file ? $this->certificate_file->store('documents/certificate', 'public') : null;

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => 'customer',
        ]);

        Customer::create([
            'user_id' => $user->id,
            'company_name' => $this->company_name,
            'ktp_number' => $this->ktp_number,
            'gender' => $this->gender,
            'position' => $this->position,
            'phone' => $this->phone,
            'business_type' => $this->business_type,
            'npwp_number' => $this->npwp_number,
            'company_phone' => $this->company_phone,
            'company_address' => $this->company_address,
            'city' => $this->city,
            'province' => $this->province,
            'postal_code' => $this->postal_code,
            'finance_name' => $this->finance_name,
            'finance_position' => $this->finance_position,
            'finance_phone' => $this->finance_phone,
            'finance_email' => $this->finance_email,
            'billing_address' => $this->billing_address,
            'technical_name' => $this->technical_name,
            'technical_position' => $this->technical_position,
            'technical_phone' => $this->technical_phone,
            'technical_email' => $this->technical_email,
            'installation_address' => $this->installation_address,
            'service_type' => $this->service_type,
            'term_of_service' => $this->term_of_service,
            'ktp_file_path' => $ktpPath,
            'npwp_file_path' => $npwpPath,
            'nib_file_path' => $nibPath,
            'certificate_file_path' => $certificatePath,
            'status' => 'menunggu_verifikasi',
        ]);

        Auth::login($user);

        return redirect()->route('customer.dashboard');
    }

    public function render()
    {
        return view('livewire.customer.register');
    }
}