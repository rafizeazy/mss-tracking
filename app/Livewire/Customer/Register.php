<?php

namespace App\Livewire\Customer;

use App\Models\User;
// use App\Models\Customer; // Buka komentar ini jika Anda sudah membuat Model Customer
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Registrasi Layanan Internet - PT MSS')]
#[Layout('layouts.guest')] // Menggunakan layout 'guest' agar sidebar admin tidak muncul
class Register extends Component
{
    use WithFileUploads; // Wajib dipanggil untuk mengaktifkan fitur upload file

    // 1. Data Pendaftar
    public $name, $ktp_number, $gender, $position, $email, $phone;

    // 2. Data Perusahaan
    public $company_name, $business_type, $npwp_number, $company_address, $city, $province, $postal_code, $company_phone;

    // 3. Penanggung Jawab Keuangan
    public $finance_name, $billing_address, $finance_position, $finance_email, $finance_phone;

    // 4. Penanggung Jawab Teknis
    public $technical_name, $installation_address, $technical_department, $technical_position, $technical_email, $technical_phone;

    // 5. Layanan & File Dokumen
    public $service_type, $term_of_service;
    public $ktp_file, $npwp_file, $nib_file, $certificate_file;

    // 6. Kredensial Akun
    public $password, $password_confirmation;
    public $accepted_terms = false;

    // Aturan Validasi
    protected function rules()
    {
        return [
            // Validasi Dasar
            'name' => 'required|string|max:255',
            'ktp_number' => 'required|numeric|digits:16',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            
            'company_name' => 'required|string|max:255',
            'company_address' => 'required|string',
            
            // Validasi Layanan
            'service_type' => 'required|string',
            'term_of_service' => 'required|numeric',

            // Validasi Upload File (Maksimal 2MB, Format: JPG, PNG, PDF)
            'ktp_file' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'npwp_file' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'nib_file' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'certificate_file' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',

            // Validasi Password & Persetujuan
            'password' => 'required|min:8|confirmed',
            'accepted_terms' => 'accepted',
        ];
    }

    public function submit()
    {
        // 1. Jalankan validasi (Jika gagal, proses berhenti di sini dan error muncul di form)
        $this->validate();

        // 2. Proses Upload Dokumen ke direktori 'storage/app/public/documents/...'
        $ktpPath = $this->ktp_file ? $this->ktp_file->store('documents/ktp', 'public') : null;
        $npwpPath = $this->npwp_file ? $this->npwp_file->store('documents/npwp', 'public') : null;
        $nibPath = $this->nib_file ? $this->nib_file->store('documents/nib', 'public') : null;
        $certPath = $this->certificate_file ? $this->certificate_file->store('documents/certificates', 'public') : null;

        // 3. Buat Akun User untuk Pelanggan Login
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            // Jika Anda membuat Role::Customer di Enum, tambahkan di sini:
            // 'role' => \App\Enums\Role::Customer, 
        ]);

        // 4. Simpan Data Formulir ke Tabel Customers (Ini contoh kerangka logikanya)
        /*
        Customer::create([
            'user_id' => $user->id,
            'ktp_number' => $this->ktp_number,
            'company_name' => $this->company_name,
            'company_address' => $this->company_address,
            'service_type' => $this->service_type,
            'status' => 'pending_verification', // Status awal workflow Anda
            // Simpan path file agar bisa dilihat oleh Finance & Admin
            'ktp_file_path' => $ktpPath,
            'npwp_file_path' => $npwpPath,
        ]);
        */

        // 5. Berikan pesan sukses dan arahkan ke halaman Login
        session()->flash('success', 'Registrasi berhasil dikirim! Silakan login untuk memantau proses aktivasi Anda.');
        
        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.customer.register');
    }
}