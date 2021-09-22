---|   CATATAN UNTUK BETA TESTER CIFIRECMS V2  |---

1.  PERSYARATAN SYSTEM.

- System Minimum
+--------------+----------------------+
|  System      |  Version             |
+--------------+----------------------+
|  Web server  |  Apache >= 2.4.x     |
|  PHP         |  >= 7.x, >= 5.6.x    |
|  MySQL       |  >= 5.7.x            |
|  MariaDB     |  >= 10.3.x           |
+--------------+----------------------+

- PHP Ekstension
+--------------+----------+
|  Ekstension  |  Config  |
+--------------+----------+
|  pdo_mysql   |  ON      |
|  pdo_sqlite  |  ON      |
|  pdo_sqlite  |  ON      |
|  json        |  ON      |
|  fileinfo    |  ON      |
|  intl        |  ON      |
+--------------+----------+

	
2.  INSTALASI.

A.  Instalasi Secara Manual.
	1. Tempatkan source code cifirecms ke direktori project anda (contoh : C:/xampp/htdocs/nama-project-anda/).
	2. Buat database baru dengan konfigurasi berikut:
	   - dbname     : cifirecms
	   - collation  : utf8mb4_general_ci
	3. Import database yang ada di folder _manual_install/database.sql ke database yang baru anda buat.
	4. Copy file _manual_install/config.php ke cififrecms/application/config/
	   Edit file application/config/config.php pada line 24, ubah value $config['base_url'] sesuai url project anda.
	5. Copy file _manual_install/database.php ke cififrecms/application/config/
	   Edit file application/config/database.php sesuaikan dengan konfigurasi database anda.
	6. Extract file htaccess.zip di main direktori project anda.
	7. Login backend: http://nama-project-anda/l-admin/login
	   username : administrator
	   password : 123456

B.  Instalasi Menggunakan Installer cifirecms.
	1. Source installer berada pada folder _installer.
	2. Copy/paste source installer ke main direktori project (contoh : C:/xampp/htdocs/nama-project-anda/).
	3. Extract file htaccess.zip di main direktori project anda.
	4. Buat database baru dengan konfigurasi berikut:
	   - dbname     : cifirecms
	   - collation  : utf8mb4_general_ci
	5. Buka browser dan masuk ke url project project anda (contoh http://localhost/nama-project-anda/)
	6. Ikuti setiap langkah instalasi dengan benar.
	7. Login backend : http://nama-project-anda/l-admin/login
	   - username : sesuai input pada saat instalasi
	   - password : sesuai input pada saat instalasi
    
	
	
** NOTE:
- Report hal-hal yang ditemui pada saat tester di group cifirecms dengan format berikut :
	#version2_beta
	#bugs, #error
	<JUDUL>
	<URAIAN>
	*sertakan label topik facebook : Beta Tester Version 2 (dihruskan).
	*Sertakan screenshoot (jika ada).
	*Sertakan file (jika ada. format *.txt).
	
- Jika filemanager tidak menampilkan preview gambar, silakan hapus folder content/plugins/filemanager/ kemudian ekstrak filemanager.rar



	-- TERIMA KASIH --