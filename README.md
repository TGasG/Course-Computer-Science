# Course Computer Science

## Anggota Kelompok

Anggota Kelompok:

1. Fadillah Anzal Nurrohmah Ardiani (1910512003)
2. Andika Hiro Pratama (1910512004)
3. Kevin Leonard Sugiman (1910512031)
4. Zidane Anvio Putra (1910512092)
5. Gustian Abrary Shidqi (1910512097)

## Deskripsi Program

<div align="justify">
Course Computer Science adalah aplikasi berbasis website yang dibangun menggunakan framework Codeigniter 4 dalam rangka menyelesaikan tugas akhir mata kuliah Pemrograman Web. Program ini merupakan platform pembelajaran bagi orang yang menekuni ilmu Computer Science. Pada platform ini User dapat mendaftar sebagai Mentor Maupun Student. Mentor dapat mendaftarkan course nya pada platform ini dengan memasukkan link youtube video pembelajaran yang nantinya Student dapat mendaftarkan diri untuk belajar pada course tersebut.
</div>

## Requirement

| Syntax      | Description |
| ----------- | ----------- |
| PHP         | >= 8.0      |
| Composer    | >= 2.1      |
| MySQL       | >= 8.0      |
| Codeigniter | >= 4.1.5    |

## Cara Menjalankan Server

1. Jalankan perintah `composer update` untuk menginstall seluruh dependencies project yang ada pada file [composer.json](composer.json).
2. Buatlah file `.env` dengan menggunakan template pada file [env](/env)
3. Masukkan beberapa variabel pada file `.env` sebagai berikut:

    - `app.baseURL` masukkan base URL website anda sebagai contoh `http://localhost:8080`
    - Masukkan atribut yang diperlukan sebagai berikut pada file `.env`

        ```
        database.default.hostname = [nama host database]
        database.default.database = [nama database]
        database.default.username = [nama username database]
        database.default.password = [password database]
        ```

    - Masukkan atribut untuk keamanan CSRF `security.csrfProtection = 'session'` pada file `.env`

4. Buat database dengan mengetikkan `php spark db:create [nama database]`
5. Migrasi database dengan mengetikkan `php spark migrate`
6. Jalankan server dengan mengetikkan `php spark serve` server akan berjalan pada [http://localhost:8080](http://localhost:8080)
