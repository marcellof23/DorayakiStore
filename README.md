# Dorayaki Store

Web service untuk melayani toko yoshiyaki :D

## Perubahan Skema Basis Data

Tidak ada perubahan skema, hanya perlu notes bahwa untuk menjaga integritas data antara store - parbik, maka "name" yang terdaftar pada suatu dorayaki harus unik dan kemudian "name" tersebut akan dijadikan sebagai "foreign key" yang memastikan data yang terdaftar pada toko akan selaras dengan data yang terdaftar pada pabrik.

## Perubahan Lainnya

Kami melakukan perubahan pada sisi admin dorayaki store dimana pada halaman penambahan dorayaki baru, toko hanya dapat menambahkan dorayaki dari data dorayaki yang terdaftar pada pabrik dan belum terdaftar sebagai dorayaki yang hendak dijual di toko. Jadi kami melakukan filterisasi antara data dorayaki yang saat ini sedang dijuan dengan data dorayaki yang terdaftar pada pabrik.

## Screenshot perubahan

## Halaman Admin Dorayaki

Potongan gambar halaman penambahan varian dorayaki

![Halaman Tambah Dorayaki](./public/tubes2/1.jpg)

Potongan gambar halaman edit dorayaki

![Halaman Edit Dorayaki](./public/tubes2/2.jpg)

## Pembagian Tugas

Integrasi SOAP: 13519086
Perubahan Create Dorayaki: 13519121
Perubahan Edit Dorayaki: 13519134