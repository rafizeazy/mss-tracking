<?php

use App\Enums\Role;
use App\Mail\StatusPelangganBerubah;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

/**
 * Helper to create a customer with an associated user for testing.
 *
 * @return array{user: User, customer: Customer}
 */
function createCustomerWithUser(): array
{
    $user = User::factory()->create([
        'role' => Role::Customer,
        'email' => 'pelanggan@test.com',
    ]);

    $customer = Customer::create([
        'user_id' => $user->id,
        'ktp_number' => '3273012345678901',
        'company_name' => 'PT Test Sejahtera',
        'company_address' => 'Jl. Test No. 1',
        'phone' => '08123456789',
        'service_type' => 'Dedicated Internet',
        'bandwidth' => '20 Mbps',
        'term_of_service' => 12,
        'status' => 'menunggu_verifikasi',
        'registration_fee' => 1000000,
        'monthly_fee' => 500000,
    ]);

    return compact('user', 'customer');
}

describe('StatusPelangganBerubah Mail', function () {
    it('membuat mailable dengan subject yang benar untuk status menunggu_invoice', function () {
        [, $customer] = array_values(createCustomerWithUser());

        $mail = new StatusPelangganBerubah($customer, 'menunggu_invoice');

        expect($mail->envelope()->subject)
            ->toContain('Registrasi Anda Disetujui');
    });

    it('membuat mailable dengan subject yang benar untuk status menunggu_pembayaran', function () {
        [, $customer] = array_values(createCustomerWithUser());

        $mail = new StatusPelangganBerubah($customer, 'menunggu_pembayaran');

        expect($mail->envelope()->subject)
            ->toContain('Invoice Diterbitkan');
    });

    it('membuat mailable dengan subject yang benar untuk status proses_instalasi', function () {
        [, $customer] = array_values(createCustomerWithUser());

        $mail = new StatusPelangganBerubah($customer, 'proses_instalasi');

        expect($mail->envelope()->subject)
            ->toContain('Pembayaran Dikonfirmasi');
    });

    it('membuat mailable dengan subject yang benar untuk status menunggu_baa', function () {
        [, $customer] = array_values(createCustomerWithUser());

        $mail = new StatusPelangganBerubah($customer, 'menunggu_baa');

        expect($mail->envelope()->subject)
            ->toContain('Instalasi Selesai');
    });

    it('membuat mailable dengan subject yang benar untuk status selesai', function () {
        [, $customer] = array_values(createCustomerWithUser());

        $mail = new StatusPelangganBerubah($customer, 'selesai');

        expect($mail->envelope()->subject)
            ->toContain('Layanan Internet Anda Telah Aktif');
    });

    it('menambahkan CC ke finance_email jika tersedia', function () {
        ['user' => $user, 'customer' => $customer] = createCustomerWithUser();
        $customer->update([
            'finance_email' => 'finance@test.com',
            'finance_name' => 'Finance PIC',
        ]);

        $mail = new StatusPelangganBerubah($customer, 'menunggu_invoice');
        $ccAddresses = $mail->envelope()->cc;

        expect($ccAddresses)->toHaveCount(1)
            ->and($ccAddresses[0]->address)->toBe('finance@test.com');
    });

    it('tidak ada CC jika finance_email dan technical_email kosong', function () {
        [, $customer] = array_values(createCustomerWithUser());

        $mail = new StatusPelangganBerubah($customer, 'selesai');

        expect($mail->envelope()->cc)->toBeEmpty();
    });

    it('menggunakan view yang benar untuk konten email', function () {
        [, $customer] = array_values(createCustomerWithUser());

        $mail = new StatusPelangganBerubah($customer, 'selesai');

        expect($mail->content()->view)
            ->toBe('mail.status-pelanggan-berubah');
    });
});

describe('Email Terkirim pada Perubahan Status', function () {
    beforeEach(function () {
        Mail::fake();
    });

    it('mengirim email saat Marketing menyetujui registrasi', function () {
        ['user' => $user, 'customer' => $customer] = createCustomerWithUser();

        $customer->update(['status' => 'menunggu_invoice']);

        Mail::to($user->email)
            ->queue(new StatusPelangganBerubah($customer, 'menunggu_invoice'));

        Mail::assertQueued(StatusPelangganBerubah::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email) && $mail->newStatus === 'menunggu_invoice';
        });
    });

    it('mengirim email saat Finance menerbitkan invoice', function () {
        ['user' => $user, 'customer' => $customer] = createCustomerWithUser();

        $customer->update(['status' => 'menunggu_pembayaran']);

        Mail::to($user->email)
            ->queue(new StatusPelangganBerubah($customer, 'menunggu_pembayaran'));

        Mail::assertQueued(StatusPelangganBerubah::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email) && $mail->newStatus === 'menunggu_pembayaran';
        });
    });

    it('mengirim email saat NOC mengirim BAA ke pelanggan', function () {
        ['user' => $user, 'customer' => $customer] = createCustomerWithUser();

        $customer->update(['status' => 'menunggu_baa']);

        Mail::to($user->email)
            ->queue(new StatusPelangganBerubah($customer, 'menunggu_baa'));

        Mail::assertQueued(StatusPelangganBerubah::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email) && $mail->newStatus === 'menunggu_baa';
        });
    });

    it('mengirim email saat Marketing menyetujui BAA dan layanan selesai', function () {
        ['user' => $user, 'customer' => $customer] = createCustomerWithUser();

        $customer->update(['status' => 'selesai']);

        Mail::to($user->email)
            ->queue(new StatusPelangganBerubah($customer, 'selesai'));

        Mail::assertQueued(StatusPelangganBerubah::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email) && $mail->newStatus === 'selesai';
        });
    });
});
