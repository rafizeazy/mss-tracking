<?php

namespace App\Livewire\Customer;

use App\Models\ActivityLog;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
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

    public $provinces = [];

    public $cities = [];

    public string $province_id = '';

    public string $city_id = '';

    public string $name = '';

    public string $email = '';

    public string $ktp_number = '';

    public string $gender = '';

    public string $position = '';

    public string $phone = '';

    public string $company_name = '';

    public string $business_type = '';

    public string $npwp_number = '';

    public string $company_address = '';

    public string $postal_code = '';

    public string $company_phone = '';

    public string $finance_name = '';

    public string $finance_email = '';

    public string $billing_address = '';

    public string $finance_phone = '';

    public string $technical_name = '';

    public string $technical_email = '';

    public string $installation_address = '';

    public string $technical_phone = '';

    public string $service_type = 'Internet Dedicated 1:1';

    public string $bandwidth = '';

    public string $term_of_service = '1';

    public array $bandwidthOptions = [
        '100 Mbps' => 'Rp 1.225.000',
        '200 Mbps' => 'Rp 2.100.000',
        '300 Mbps' => 'Rp 3.500.000',
        '400 Mbps' => 'Rp 4.830.000',
        '500 Mbps' => 'Rp 6.160.000',
        '600 Mbps' => 'Rp 7.000.000',
        '700 Mbps' => 'Rp 8.310.000',
        '800 Mbps' => 'Rp 9.695.000',
        '900 Mbps' => 'Rp 10.920.000',
        '1000 Mbps' => 'Rp 13.300.000',
        '1500 Mbps' => 'Rp 19.500.000',
        '2000 Mbps' => 'Rp 25.200.000',
        '2500 Mbps' => 'Rp 30.000.000',
        '3000 Mbps' => 'Rp 35.550.000',
        '3500 Mbps' => 'Rp 40.250.000',
    ];

    public $ktp_file;

    public $npwp_file;

    public $nib_file;

    public $certificate_file;

    public string $password = '';

    public string $password_confirmation = '';

    public bool $accepted_terms = false;

    public function mount(): void
    {
        try {
            $this->provinces = DB::table('provinces')->orderBy('name', 'asc')->get();
        } catch (\Exception $e) {
            $this->provinces = collect();
        }
    }

    public function updatedProvinceId(string $value): void
    {
        if (! empty($value)) {
            try {
                $this->cities = DB::table('regencies')
                    ->where('province_id', $value)
                    ->orderBy('name', 'asc')
                    ->get();
            } catch (\Exception $e) {
                $this->cities = collect();
            }
        } else {
            $this->cities = collect();
        }

        $this->city_id = '';
    }

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
                'province_id' => 'required|string',
                'city_id' => 'required|string',
                'postal_code' => 'nullable|string|max:10',
                'company_phone' => 'nullable|string|max:20',
            ],
            3 => [
                'finance_name' => 'required|string|max:255',
                'finance_email' => 'required|email|max:255',
                'billing_address' => 'required|string',
                'finance_phone' => 'required|string|max:20',
                'technical_name' => 'required|string|max:255',
                'technical_email' => 'required|email|max:255',
                'technical_phone' => 'required|string|max:20',
            ],
            4 => [
                'service_type' => 'required|string|max:255',
                'bandwidth' => ['required', 'string', 'max:255', Rule::in(array_keys($this->bandwidthOptions))],
                'term_of_service' => 'required|integer|in:1,2,3',
                'installation_address' => 'required|string',
                'ktp_file' => 'required|mimes:jpg,jpeg,png,pdf|max:5120',
                'npwp_file' => 'nullable|mimes:jpg,jpeg,png,pdf|max:5120',
                'nib_file' => 'nullable|mimes:pdf|max:5120',
                'certificate_file' => 'nullable|mimes:pdf|max:5120',
                'password' => 'required|min:8|confirmed',
                'accepted_terms' => 'accepted',
            ],
            default => [],
        };
    }

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
                'province_id.required' => 'Provinsi wajib dipilih.',
                'city_id.required' => 'Kota/Kabupaten wajib dipilih.',
            ],
            3 => [
                'finance_name.required' => 'Nama PIC Keuangan wajib diisi.',
                'finance_email.required' => 'Email PIC Keuangan wajib diisi.',
                'finance_email.email' => 'Format email keuangan tidak valid.',
                'billing_address.required' => 'Alamat Penagihan wajib diisi.',
                'finance_phone.required' => 'Nomor handphone keuangan wajib diisi.',
                'technical_name.required' => 'Nama PIC Teknis wajib diisi.',
                'technical_email.required' => 'Email PIC Teknis wajib diisi.',
                'technical_email.email' => 'Format email teknis tidak valid.',
                'technical_phone.required' => 'Nomor handphone teknis wajib diisi.',
            ],
            4 => [
                'service_type.required' => 'Jenis layanan wajib dipilih.',
                'bandwidth.required' => 'Kapasitas Bandwidth wajib dipilih.',
                'term_of_service.required' => 'Jangka waktu berlangganan wajib dipilih.',
                'installation_address.required' => 'Alamat Instalasi wajib diisi.',
                'ktp_file.required' => 'File dokumen KTP wajib diunggah.',
                'ktp_file.max' => 'Ukuran file KTP maksimal 5 MB.',
                'npwp_file.max' => 'Ukuran file NPWP maksimal 5 MB.',
                'nib_file.max' => 'Ukuran file NIB maksimal 5 MB.',
                'certificate_file.max' => 'Ukuran file Sertifikat Standar maksimal 5 MB.',
                'password.required' => 'Password wajib diisi.',
                'password.min' => 'Password minimal 8 karakter.',
                'password.confirmed' => 'Konfirmasi password tidak cocok.',
                'accepted_terms.accepted' => 'Anda harus membaca dan menyetujui Syarat dan Ketentuan.',
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

    public function restoreDraft(array $draft): void
    {
        $draftFields = [
            'name',
            'email',
            'ktp_number',
            'gender',
            'position',
            'phone',
            'company_name',
            'business_type',
            'npwp_number',
            'company_address',
            'province_id',
            'city_id',
            'postal_code',
            'company_phone',
            'finance_name',
            'finance_email',
            'billing_address',
            'finance_phone',
            'technical_name',
            'technical_email',
            'technical_phone',
            'bandwidth',
            'term_of_service',
            'installation_address',
        ];

        foreach ($draftFields as $field) {
            if (array_key_exists($field, $draft)) {
                $value = $draft[$field];

                $this->{$field} = is_scalar($value) ? (string) $value : '';
            }
        }

        if (array_key_exists('accepted_terms', $draft)) {
            $this->accepted_terms = (bool) $draft['accepted_terms'];
        }

        if (array_key_exists('currentStep', $draft)) {
            $this->currentStep = max(1, min($this->totalSteps, (int) $draft['currentStep']));
        }

        if ($this->province_id !== '') {
            try {
                $this->cities = DB::table('regencies')
                    ->where('province_id', $this->province_id)
                    ->orderBy('name', 'asc')
                    ->get();
            } catch (\Exception $e) {
                $this->cities = collect();
            }
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

        $namaProvinsi = DB::table('provinces')->where('id', $this->province_id)->value('name');
        $namaKota = DB::table('regencies')->where('id', $this->city_id)->value('name');

        DB::transaction(function () use ($ktpPath, $npwpPath, $nibPath, $certPath, $namaProvinsi, $namaKota) {

            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'role' => 'customer',
                'email_verified_at' => now(),
            ]);

            $customer = Customer::create([
                'user_id' => $user->id,
                'ktp_number' => $this->ktp_number,
                'gender' => $this->gender,
                'position' => $this->position,
                'phone' => $this->phone,

                'company_name' => $this->company_name,
                'business_type' => $this->business_type,
                'npwp_number' => $this->npwp_number,
                'company_address' => $this->company_address,
                'city' => $namaKota,
                'province' => $namaProvinsi,
                'postal_code' => $this->postal_code,
                'company_phone' => $this->company_phone,

                'finance_name' => $this->finance_name,
                'finance_email' => $this->finance_email,
                'billing_address' => $this->billing_address,
                'finance_phone' => $this->finance_phone,

                'technical_name' => $this->technical_name,
                'technical_email' => $this->technical_email,
                'technical_phone' => $this->technical_phone,

                'ktp_file_path' => $ktpPath,
                'npwp_file_path' => $npwpPath,
                'nib_file_path' => $nibPath,
                'certificate_file_path' => $certPath,

                'status' => 'menunggu_verifikasi',
            ]);

            $customer->service()->create([
                'service_type' => $this->service_type,
                'bandwidth' => $this->bandwidth,
                'term_of_service' => (int) $this->term_of_service,
                'installation_address' => $this->installation_address,
                'status' => 'menunggu_verifikasi',
            ]);

            Auth::login($user);

            ActivityLog::record('registration.created', 'Pelanggan mengirim formulir registrasi layanan.', $customer);
        });

        $this->dispatch('registration-submitted');

        $this->redirect(route('customer.dashboard'));
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.customer.register');
    }
}
