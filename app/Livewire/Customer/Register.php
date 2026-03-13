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

    public int $currentStep = 1;

    public int $totalSteps = 4;

    // Step 1 — Data Pendaftar
    public string $name = '';

    public string $email = '';

    public string $ktp_number = '';

    public string $gender = '';

    public string $position = '';

    public string $phone = '';

    // Step 2 — Informasi Perusahaan
    public string $company_name = '';

    public string $business_type = '';

    public string $npwp_number = '';

    public string $company_address = '';

    public string $city = '';

    public string $province = '';

    public string $postal_code = '';

    public string $company_phone = '';

    // Step 3 — PIC Keuangan
    public string $finance_name = '';

    public string $billing_address = '';

    public string $finance_phone = '';

    // Step 3 — PIC Teknis
    public string $technical_name = '';

    public string $installation_address = '';

    public string $technical_phone = '';

    // Step 4 — Layanan & Dokumen
    public string $service_type = '';

    public string $term_of_service = '1';

    public $ktp_file;

    public $npwp_file;

    public $nib_file;

    public $certificate_file;

    // Step 4 — Kredensial
    public string $password = '';

    public string $password_confirmation = '';

    public bool $accepted_terms = false;

    /** @return array<string, string> */
    protected function rulesForStep(int $step): array
    {
        return match ($step) {
            1 => [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email',
                'ktp_number' => 'required|string|max:16',
                'gender' => 'required|in:L,P',
                'position' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
            ],
            2 => [
                'company_name' => 'required|string|max:255',
                'company_address' => 'required|string',
                'business_type' => 'nullable|string|max:255',
                'npwp_number' => 'nullable|string|max:50',
                'city' => 'nullable|string|max:100',
                'province' => 'nullable|string|max:100',
                'postal_code' => 'nullable|string|max:10',
                'company_phone' => 'nullable|string|max:20',
            ],
            3 => [
                'finance_name' => 'nullable|string|max:255',
                'billing_address' => 'nullable|string',
                'finance_phone' => 'nullable|string|max:20',
                'technical_name' => 'nullable|string|max:255',
                'installation_address' => 'nullable|string',
                'technical_phone' => 'nullable|string|max:20',
            ],
            4 => [
                'service_type' => 'required|string|max:255',
                'term_of_service' => 'required|integer|in:1,2,3',
                'ktp_file' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
                'npwp_file' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
                'nib_file' => 'nullable|mimes:pdf|max:2048',
                'certificate_file' => 'nullable|mimes:pdf|max:2048',
                'password' => 'required|min:8|confirmed',
                'accepted_terms' => 'accepted',
            ],
            default => [],
        };
    }

    /** @return array<string, string> */
    protected function messagesForStep(int $step): array
    {
        return match ($step) {
            1 => [
                'name.required' => 'Nama lengkap wajib diisi.',
                'email.required' => 'Email wajib diisi.',
                'email.unique' => 'Email sudah terdaftar.',
                'ktp_number.required' => 'Nomor KTP wajib diisi.',
                'gender.required' => 'Jenis kelamin wajib dipilih.',
                'position.required' => 'Jabatan wajib diisi.',
                'phone.required' => 'Nomor handphone wajib diisi.',
            ],
            2 => [
                'company_name.required' => 'Nama perusahaan wajib diisi.',
                'company_address.required' => 'Alamat perusahaan wajib diisi.',
            ],
            4 => [
                'service_type.required' => 'Tipe layanan wajib diisi.',
                'term_of_service.required' => 'Jangka waktu berlangganan wajib dipilih.',
                'password.required' => 'Password wajib diisi.',
                'password.min' => 'Password minimal 8 karakter.',
                'password.confirmed' => 'Konfirmasi password tidak cocok.',
                'accepted_terms.accepted' => 'Anda harus menyetujui pernyataan kebenaran data.',
            ],
            default => [],
        };
    }

    public function nextStep(): void
    {
        $this->validate(
            $this->rulesForStep($this->currentStep),
            $this->messagesForStep($this->currentStep)
        );

        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
        }
    }

    public function previousStep(): void
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function submit(): void
    {
        $this->validate(
            $this->rulesForStep(4),
            $this->messagesForStep(4)
        );

        $ktpPath = $this->ktp_file ? $this->ktp_file->store('documents/ktp', 'public') : null;
        $npwpPath = $this->npwp_file ? $this->npwp_file->store('documents/npwp', 'public') : null;
        $nibPath = $this->nib_file ? $this->nib_file->store('documents/nib', 'public') : null;
        $certPath = $this->certificate_file ? $this->certificate_file->store('documents/certificate', 'public') : null;

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        Customer::create([
            'user_id' => $user->id,
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
            'finance_phone' => $this->finance_phone,
            'technical_name' => $this->technical_name,
            'installation_address' => $this->installation_address,
            'technical_phone' => $this->technical_phone,
            'service_type' => $this->service_type,
            'term_of_service' => (int) $this->term_of_service,
            'ktp_file_path' => $ktpPath,
            'npwp_file_path' => $npwpPath,
            'nib_file_path' => $nibPath,
            'certificate_file_path' => $certPath,
            'status' => 'menunggu_verifikasi',
        ]);

        Auth::login($user);

        $this->redirect(route('customer.dashboard'));
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.customer.register');
    }
}
