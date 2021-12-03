# Course Computer Science

## Requirement

| Syntax      | Description |
| ----------- | ----------- |
| PHP         | >= 8.0      |
| MySQL       | >= 8.0      |
| Codeigniter | >= 4.1.5    |

## Cara Menjalankan Server

1. Buatlah file `.env` dengan menggunakan template pada file [env](/env)
2. Masukkan beberapa varible pada file `.env` sebagai berikut:

    - `app.baseURL` masukkan base URL website anda sebagai contoh `http://localhost:8080`
    - Masukkan atribut yang diperlukan sebagai berikut pada file `.env`

        ```
        database.default.hostname = [nama host database]
        database.default.database = [nama database]
        database.default.username = [nama username database]
        database.default.password = [password database]
        ```

    - Masukkan atribut untuk keamanan CSRF `security.csrfProtection = 'session'` pada file `.env`

3. Buat database dengan mengetikkan `php spark db:create [nama database]`
4. Migrasi database dengan mengetikkan `php spark migrate`
5. Jalankan server dengan mengetikkan `php spark serve` server akan berjalan pada [http://localhost:8080](http://localhost:8080)
