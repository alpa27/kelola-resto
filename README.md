# Restaurant POS System

Sistem kasir restoran (table service) yang dibangun dengan Laravel 12, mengimplementasikan Object-Oriented Programming (OOP) dan role-based access control.

## Fitur Utama

### 1. Sistem Autentikasi & Role-Based Access
- **Administrator**: Akses penuh ke semua fitur
- **Waiter**: Entri barang, entri order, generate laporan
- **Kasir**: Entri transaksi, generate laporan  
- **Owner**: Generate laporan

### 2. Manajemen Data
- **Menu Management**: CRUD menu dengan harga
- **Customer Management**: CRUD data pelanggan
- **Table Management**: Manajemen meja restoran
- **Order Management**: Sistem pesanan
- **Transaction Management**: Proses pembayaran

### 3. Laporan Komunikatif
- Laporan pesanan (Waiter)
- Laporan transaksi (Kasir)
- Laporan pendapatan & menu populer (Owner)

## Teknologi yang Digunakan

- **Backend**: Laravel 12, PHP 8.2+
- **Database**: SQLite (default) / MySQL
- **Frontend**: Bootstrap 5, Font Awesome
- **Authentication**: Laravel Auth
- **ORM**: Eloquent ORM

## Database Schema (PDM)

### Tabel Menu
- `idmenu` (Primary Key)
- `namamenu` (Nama Menu)
- `harga` (Harga Menu)

### Tabel Pelanggan
- `idpelanggan` (Primary Key)
- `namapelanggan` (Nama Pelanggan)
- `jeniskelamin` (Jenis Kelamin)
- `nohp` (No. HP)
- `alamat` (Alamat)

### Tabel Pesanan
- `idpesanan` (Primary Key)
- `idmenu` (Foreign Key → Menu)
- `idpelanggan` (Foreign Key → Pelanggan)
- `jumlah` (Jumlah Pesanan)
- `iduser` (Foreign Key → User)

### Tabel Transaksi
- `idtransaksi` (Primary Key)
- `idpesanan` (Foreign Key → Pesanan)
- `total` (Total Pembayaran)
- `bayar` (Jumlah Bayar)

### Tabel User (Extended)
- `id` (Primary Key)
- `name` (Nama User)
- `email` (Email)
- `password` (Password)
- `role` (Role: administrator, waiter, kasir, owner)

## Instalasi & Setup

### 1. Clone Repository
```bash
git clone <repository-url>
cd restaurant-app
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Database Setup
```bash
# Untuk SQLite (default)
touch database/database.sqlite

# Atau untuk MySQL, edit .env:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=restaurant_pos
# DB_USERNAME=root
# DB_PASSWORD=
```

### 5. Run Migrations & Seeders
```bash
php artisan migrate
php artisan db:seed --class=RestaurantSeeder
```

### 6. Start Development Server
```bash
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`

## Demo Accounts

Setelah menjalankan seeder, Anda dapat login dengan akun berikut:

| Role | Email | Password |
|------|-------|----------|
| Administrator | admin@restaurant.com | password |
| Waiter | waiter@restaurant.com | password |
| Kasir | kasir@restaurant.com | password |
| Owner | owner@restaurant.com | password |

## Struktur Aplikasi

### Models
- `User`: Model user dengan role-based methods
- `Menu`: Model menu restoran
- `Pelanggan`: Model pelanggan
- `Pesanan`: Model pesanan dengan relasi
- `Transaksi`: Model transaksi
- `Meja`: Model meja restoran

### Controllers
- `AuthController`: Handles authentication
- `DashboardController`: Dashboard dengan statistik
- `MenuController`: CRUD menu (Admin & Waiter)
- `PelangganController`: CRUD pelanggan (Admin & Waiter)
- `PesananController`: CRUD pesanan (Waiter only)
- `TransaksiController`: CRUD transaksi (Kasir only)
- `MejaController`: CRUD meja (Admin only)
- `ReportController`: Generate laporan

### Views
- Layout responsive dengan Bootstrap 5
- Role-based navigation
- Form validation dengan feedback
- Real-time calculations (JavaScript)

## Fitur OOP

### 1. Encapsulation
- Private/protected methods dalam controllers
- Data hiding dalam models

### 2. Inheritance
- Controllers extend base Controller
- Models extend Eloquent Model

### 3. Polymorphism
- Role-based method overrides
- Dynamic method calls berdasarkan role

### 4. Abstraction
- Abstract methods untuk role checking
- Interface implementation untuk authentication

## Role-Based Access Control

### Administrator
- ✅ Login/Logout
- ✅ Entri Meja
- ✅ Entri Barang
- ✅ Generate Laporan

### Waiter
- ✅ Login/Logout
- ✅ Entri Barang
- ✅ Entri Order
- ✅ Generate Laporan

### Kasir
- ✅ Login/Logout
- ✅ Entri Transaksi
- ✅ Generate Laporan

### Owner
- ✅ Login/Logout
- ✅ Generate Laporan

## API Endpoints

### Authentication
- `GET /login` - Login form
- `POST /login` - Process login
- `POST /logout` - Logout

### Protected Routes
- `GET /dashboard` - Dashboard
- `GET /menu` - Menu index
- `POST /menu` - Create menu
- `GET /pesanan` - Orders index
- `POST /pesanan` - Create order
- `GET /transaksi` - Transactions index
- `POST /transaksi` - Process transaction
- `GET /laporan` - Reports

## Database Relationships

```
User (1) → (N) Pesanan
Menu (1) → (N) Pesanan
Pelanggan (1) → (N) Pesanan
Pesanan (1) → (N) Transaksi
```

## Contributing

1. Fork repository
2. Create feature branch
3. Commit changes
4. Push to branch
5. Create Pull Request

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Support

Untuk pertanyaan atau bantuan, silakan buat issue di repository ini.