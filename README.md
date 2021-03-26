<p align="right">
بِسْــــــــــــــمِ اللَّهِ الرَّحْمَنِ الرَّحِيم 
</p>

# Decision Support System Fuzzy AHP Method Using PHP

Pakcage perhitungan sistem pendukung keputusan metode Fuzzy AHP menggunakan PHP. 

## Installation

- Pastikan anda sudah memiliki composer di device anda.
- Install menggunakan perintah
    ```
    composer require afrizalmy/fahp_dss
    ```
## How To Use
- Silahkan lihat pada file [ini](index.php)
- Siapkan data kriteria dan alternatif terlebih dahulu
- Lalu buat array untuk menampung data kriteria dan tiap-tiap alternatif. Silahkan lihat file [ini](percobaan.php) bagaimana caranya membuat array, logikanya seperti membuat pattern pyramid.
<b>PENTING UNTUK DIINGAT</b>.
Pastikan index array kriteria dan alternatif tidak berubah. Maksudnya adalah ketika proses pertama pemanggilan data kriteria dan alternatif akan disimpan disuatu variable, yang nantinya akan dipanggil ulang. Maka dari itu <i>Saran dari saya simpan data kriteria dan alternatif di database, lalu panggil dan buat sebuah array</i>.
- Setelah itu panggil function <i>buat_metric</i> dari class [Base](src/Base.php#L40), masukkan params kriteria, data array, dan nilai kepastian. Disini nilai kepastian bernilai ```1,1,1```.
- Panggil function FuzzyPairWise pada class [Fahp()](src/Fahp.php) untuk menghitung fuzzy pair wise. Masukkan params hasil matriks dari langkah sebelumnya.
- Setelah itu panggil function HitungGeoMetricMean pada class [Fahp()](src/Fahp.php) untuk menghitung geometric mean. Masukkan params hasil matriks dari langkah sebelumnya.
- Selanjutnya panggil function FuzzyWeight pada class [Fahp()](src/Fahp.php) untuk menghitung bobot.
- Lakukan berulang kali hingga akhir alternatif. Disini saya menyarankan untuk looping.
- Menuju ke langkah terakhir yaitu buat variable array yang didalamnya <b>HARUS ADA</b> array object bobot_kriteria dan bobot_alternatif. Silahkan lihat pada file [ini](index.php#L159). Saran dari saya gunakan looping untuk menyimpan pada object bobot_alternatif. 
- Langkah terakhir panggil static function HitungSemuaBobot dari class [Fahp()](src/Fahp.php). Masukkan 3 params seperti kriteria, array object langkah sebelumnya, dan alternatif.
- hasil akan nampak seperti berikut
    ```
    {
        "array_bobot":[0.38293967781531879079892632944392971694469451904296875,0.40943338011437979684359333987231366336345672607421875,0.07401766522882970156249626825228915549814701080322265625,0.05732509200513700997614563448223634622991085052490234375,0.076284184836334645307687196691404096782207489013671875],
        "best_alternatif":{"P2":0.40943338011437979684359333987231366336345672607421875},
        "worst_alternatif":{"P4":0.05732509200513700997614563448223634622991085052490234375}
    }
    ```
## Hitung Manual
- Silahkan lihat file [.xlsm](manual.xlsm) ini untuk perhitungan manual dari contoh file [ini](index.php).

## Disclaimer

* <b>Dilarang keras</b> di perjual-belikan, source ini saya publikasi untuk keperluan belajar saja.

## Donation

* Bagi yang ingin berdonasi terbentuknya sistem ini, siapapun, berapapun, saya ucapkan terimakasih sebanyak-banyaknya. Via Gopay / Dana.

### Gopay<br>
<img src="img/gpy.png" height="400"> <br>

### Dana<br>
<img src="img/dana.png" height="350">