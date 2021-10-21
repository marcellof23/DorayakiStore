# Aplikasi Yoshiyaki

## Deskripsi Aplikasi Web

Secara umum, sistem ini merupakan sebuah sistem informasi yang digunakan untuk melakukan manajemen / pengelolaan stok dorayaki. Berikut ada beberapa ketentuan umum
yang dimiliki oleha aplikasi kami :
1. Untuk client-side, gunakan Javascript, HTML, dan CSS. Tidak boleh
menggunakan library atau framework CSS atau JS (e.g. JQuery, lodash, atau
Bootstrap). CSS sebisa mungkin ada di file yang berbeda dengan HTML (tidak
inline styling).
2. Untuk server-side, wajib menggunakan PHP murni tanpa framework apapun (e.g
laravel, codeigniter). Harap diperhatikan, Anda harus mengimplementasikan fitur
menggunakan HTTP method yang tepat.
3. Untuk basis data, wajib menggunakan SQLite. Skema database dibebaskan,
namun dapat memenuhi seluruh fitur dari sistem. Disarankan untuk membuat
database sample yang terpisah dari database asli yang digunakan oleh sistem.
4. Sistem yang dibangun ini bersifat monolithic, artinya interface dan logika
pemrosesan digabung menjadi satu.

## Daftar Requirement

Membangun sistem yang dapat melakukan pengelolaan stok dorayaki.
1. Seluruh pengguna harus melakukan autentikasi untuk dapat mengakses seluruh
fitur lainnya. Pengguna dibedakan menjadi 2 kategori: user dan admin.
2. Admin dapat melakukan pengelolaan varian dorayaki.
3. Admin dapat melakukan manajemen stok dorayaki.
4. Admin dapat melihat riwayat perubahan stok dorayaki.
5. User dapat melihat daftar varian dorayaki
6. User dapat melakukan pembelian dorayaki
7. User dapat melihat riwayat pembelian dorayaki.

## Cara Instalasi && Cara menjalankan server

Karena sistem ini dikontenirasi dengan docker, sehingga semua dependensi sudah terinstall dan dikonfigurasi pada docker image dan docker compose, maka hanya diperlukan command sebagai berikut  : 

Untuk Linux :
```shell
./serve.sh 
```
Untuk windows : 
```shell
docker-compose up --build
```

## Screenshot tampilan aplikasi 

## Penjelasan mengenai pembagian tugas masing-masing anggota

Marcello Faria 13519086 
- Membuat model dorayaki dan order
- Membuat controller dorayaki
- Membuat styling login dan register
- Membuat api tabel
- Mengkonfigurasi dan membuat koneksi database 
- Mengkonfigurasi docker
- Menyusun struktur folder
- Membuat testing dan seeds
- Membuat beberapa file api dorayaki dan order


Michael Philip 13519121

- Membuat controller order
- Membuat paginasi 
- Membuat tabel

Frederic Ronaldi 13519134

- Membuat controller user
- Membuat controller login dan register
- 
