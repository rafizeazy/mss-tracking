<?php

namespace App\Livewire\Customer;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Registrasi Layanan Internet - PT MSS')]
#[Layout('layouts.guest')]
class Register extends Component
{
    use WithFileUploads;

    public $name, $ktp_number, $gender, $position, $email, $phone;

    public $company_name, $business_type, $npwp_number, $company_address, $city, $province, $postal_code, $company_phone;

    public $finance_name, $billing_address, $finance_position, $finance_email, $finance_phone;

    public $technical_name, $installation_address, $technical_department, $technical_position, $technical_email, $technical_phone;

    public $service_type, $term_of_service;
    public $ktp_file, $npwp_file, $nib_file, $certificate_file;

    public $password, $password_confirmation;
    public $accepted_terms = false;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'ktp_number' => 'required|numeric|digits:16',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            
            'company_name' => 'required|string|max:255',
            'company_address' => 'required|string',
            
            'service_type' => 'required|string',
            'term_of_service' => 'required|numeric',

            'ktp_file' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'npwp_file' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'nib_file' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'certificate_file' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',

            'password' => 'required|min:8|confirmed',
            'accepted_terms' => 'accepted',
        ];
    }

    public function submit()
    {
        $this->validate();

        $ktpPath = $this->ktp_file ? $this->ktp_file->store('documents/ktp', 'public') : null;
        $npwpPath = $this->npwp_file ? $this->npwp_file->store('documents/npwp', 'public') : null;
        $nibPath = $this->nib_file ? $this->nib_file->store('documents/nib', 'public') : null;
        $certPath = $this->certificate_file ? $this->certificate_file->store('documents/certificates', 'public') : null;

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => \App\Enums\Role::Customer, 
        ]);

        $user->customer()->create([
            'ktp_number' => $this->ktp_number,
            'gender' => $this->gender,
            'position' => $this->position,
            'phone' => $this->phone,
            
            'company_name' => $this->company_name,
            'business_type' => $this->business_type,
            'npwp_number' => $this->npwp_number,
            'company_address' => $this->company_address,
            'city' => $this->city,
            'province' => $this->province,
            'postal_code' => $this->postal_code,
            'company_phone' => $this->company_phone,
            
            'finance_name' => $this->finance_name,
            'billing_address' => $this->billing_address,
            'finance_position' => $this->finance_position,
            'finance_email' => $this->finance_email,
            'finance_phone' => $this->finance_phone,
            
            'technical_name' => $this->technical_name,
            'installation_address' => $this->installation_address,
            'technical_department' => $this->technical_department,
            'technical_position' => $this->technical_position,
            'technical_email' => $this->technical_email,
            'technical_phone' => $this->technical_phone,
            
            'service_type' => $this->service_type,
            'term_of_service' => $this->term_of_service,
            
            'ktp_file_path' => $ktpPath,
            'npwp_file_path' => $npwpPath,
            'nib_file_path' => $nibPath,
            'certificate_file_path' => $certPath,
            
            'status' => 'menunggu_verifikasi',
        ]);

        session()->flash('success', 'Registrasi berhasil dikirim! Silakan login untuk memantau proses aktivasi Anda.');
        
        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.customer.register');
    }
}