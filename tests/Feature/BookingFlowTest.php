<?php

use App\Models\Car;
use App\Models\Transaksie;
use App\Models\User;
use Illuminate\Http\UploadedFile;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;

it('menampilkan katalog mobil di landing page', function () {
    $car = Car::factory()->create();

    $this->get(route('landing'))
        ->assertSuccessful()
        ->assertSee($car->nama);
});

it('user bisa register dengan telepon dan password', function () {
    post(route('register.post'), [
        'nama' => 'Budi Santoso',
        'telepone' => '089912345678',
        'password' => 'rahasia123',
    ])->assertRedirect(route('landing'));

    $this->assertAuthenticated();

    expect(User::where('telepone', '089912345678')->first())
        ->not->toBeNull()
        ->role->toBe('user');
});

it('user yang login bisa booking mobil dan status mobil jadi dibooking', function () {
    $user = User::factory()->create(['telepone' => '089900011122']);
    $car = Car::factory()->create();

    actingAs($user)
        ->post(route('booking.store', $car), [
            'tanggal' => now()->toDateString(),
            'durasi_sewa' => 3,
        ])
        ->assertRedirect(route('riwayat'));

    expect($car->fresh()->status)->toBe('dibooking');

    $transaksie = Transaksie::where('id_car', $car->id)->first();
    expect($transaksie->status)->toBe('pending')
        ->and((float) $transaksie->total)->toEqual((float) ($car->harga * 3))
        ->and($transaksie->telepon)->toBe($user->telepone);
});

it('mobil yang sudah dibooking tidak bisa dibooking lagi', function () {
    $user = User::factory()->create();
    $car = Car::factory()->dibooking()->create();

    actingAs($user)
        ->post(route('booking.store', $car), [
            'tanggal' => now()->toDateString(),
            'durasi_sewa' => 1,
        ])
        ->assertRedirect(route('landing'));

    expect(Transaksie::count())->toBe(0);
});

it('petugas verifikasi booking dengan bukti foto dan mobil jadi disewakan', function () {
    $petugas = User::factory()->petugas()->create();
    $car = Car::factory()->dibooking()->create();
    $trx = Transaksie::create([
        'id_car' => $car->id,
        'tanggal' => now()->toDateString(),
        'telepon' => '089900011122',
        'durasi_sewa' => 2,
        'total' => $car->harga * 2,
        'status' => 'pending',
        'atas_nama' => 'Budi',
    ]);

    actingAs($petugas)
        ->post(route('petugas.transaksi.verifikasi', $trx), [
            'bukti_img' => UploadedFile::fake()->image('bukti.jpg'),
        ])
        ->assertRedirect(route('petugas.transaksi.index'));

    expect($car->fresh()->status)->toBe('disewakan')
        ->and($trx->fresh()->status)->toBe('disewakan')
        ->and($trx->fresh()->bukti_img)->not->toBeNull();
});

it('petugas menyelesaikan sewa dan mobil tersedia kembali', function () {
    $petugas = User::factory()->petugas()->create();
    $car = Car::factory()->disewakan()->create();
    $trx = Transaksie::create([
        'id_car' => $car->id,
        'tanggal' => now()->subDays(2)->toDateString(),
        'telepon' => '089900011122',
        'durasi_sewa' => 2,
        'total' => $car->harga * 2,
        'status' => 'disewakan',
        'atas_nama' => 'Budi',
    ]);

    actingAs($petugas)
        ->post(route('petugas.transaksi.selesai', $trx))
        ->assertRedirect(route('petugas.transaksi.index'));

    expect($car->fresh()->status)->toBe('tersedia')
        ->and($trx->fresh()->status)->toBe('selesai');
});

it('petugas bisa input transaksi manual dan mobil langsung disewakan', function () {
    $petugas = User::factory()->petugas()->create();
    $car = Car::factory()->create();

    actingAs($petugas)
        ->post(route('petugas.transaksi.store'), [
            'id_car' => $car->id,
            'atas_nama' => 'Walk In Customer',
            'telepon' => '081177788899',
            'tanggal' => now()->toDateString(),
            'durasi_sewa' => 1,
        ])
        ->assertRedirect(route('petugas.transaksi.index'));

    expect($car->fresh()->status)->toBe('disewakan');

    $transaksie = Transaksie::where('id_car', $car->id)->first();
    expect($transaksie->status)->toBe('disewakan')
        ->and($transaksie->atas_nama)->toBe('Walk In Customer');
});

it('role user tidak bisa akses halaman admin dan petugas', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->get(route('index-dashboard'))
        ->assertForbidden();

    actingAs($user)
        ->get(route('petugas.transaksi.index'))
        ->assertForbidden();
});
