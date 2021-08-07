<?php
if (isset($_GET['open'])) {
	switch ($_GET['open']) {
		default:
			if (!file_exists("home.php")) die("File halaman utama tidak ada");
			include "home.php";
			break;

		case '':
			if (!file_exists("home.php")) die("File halaman utama tidak ada");
			include "home.php";
			break;


		case 'Home':
			if (!file_exists("home.php"))  die("File  tidak ada");
			include "home.php";
			break;

		case 'Logout':
			if (!file_exists("login_out.php"))  die("File tidak ada");
			include "login_out.php";
			break;
			
			//ORDER OBAT POLIKLINIK
		case 'Order-Obat-Resep':
			if (!file_exists("order_poli/order_poli_resep.php"))  die("File tidak ada");
			include "order_poli/order_poli_resep.php";
			break;

		case 'Order-Obat-Data':
			if (!file_exists("order_poli/order_poli_data.php")) die("File tidak ada");
			include "order_poli/order_poli_data.php";
			break;

		case 'Obat-Telah-Diambil':
			if (!file_exists("order_poli/obat_telah_diambil.php")) die("File tidak ada");
			include "order_poli/obat_telah_diambil.php";
			break;

		case 'Ambil-Obat-P':
			if (!file_exists("order_poli/ambil_poli_data.php"))  die("File tidak ada");
			include "order_poli/ambil_poli_data.php";
			break;



			//ORDER OBAT KOMPLEMENTER
		case 'Order-Obat-K':
			if (!file_exists("order_komp/order_komp_data.php"))  die("File tidak ada");
			include "order_komp/order_komp_data.php";
			break;

		case 'Racik-Obat-K':
			if (!file_exists("order_komp/racik_komp_data.php"))  die("File tidak ada");
			include "order_komp/racik_komp_data.php";
			break;

		case 'Siap-Obat-K':
			if (!file_exists("order_komp/siap_komp_data.php"))  die("File tidak ada");
			include "order_komp/siap_komp_data.php";
			break;


			//PENGAMBILAN OBAT KOMPLEMENTER
		case 'Ambil-Obat-K':
			if (!file_exists("ambil_komp/ambil_komp_data.php"))  die("File tidak ada");
			include "ambil_komp/ambil_komp_data.php";
			break;

		case 'Ambil-Obat-K-Proses':
			if (!file_exists("ambil_komp/ambil_komp_proses.php"))  die("File tidak ada");
			include "ambil_komp/ambil_komp_proses.php";
			break;

			// Data Obat

		case 'Data-Obat':
			if (!file_exists("obat/data_obat.php"))  die("File tidak ada");
			include "obat/data_obat.php";
			break;

		case 'Data-Obat-Habis':
			if (!file_exists("obat/data_obat_habis.php")) die("File tidak ada");
			include "obat/data_obat_habis.php";
			break;

		case 'Data_Obat_Hampir_Habis':
			if (!file_exists("obat/data_obat_hampir_habis.php")) die("File Tidak Ada");
			include "obat/data_obat_hampir_habis.php";
			break;

		case 'Data_Obat_Kadaluarsa':
			if (!file_exists("obat/data_obat_kadaluarsa.php")) die("File Tidak Ada");
			include "obat/data_obat_kadaluarsa.php";
			break;

		case 'Data_Obat_Hampir_Kadaluarsa':
			if (!file_exists("obat/data_obat_hampir_kadaluarsa.php")) die("File Tidak Ada");
			include "obat/data_obat_hampir_kadaluarsa.php";
			break;

		case 'Obat-Edit':
			if (!file_exists("obat/edit_obat.php"))  die("File tidak ada");
			include "obat/edit_obat.php";
			break;

		case 'Obat-Add':
			if (!file_exists("obat/add_obat.php"))  die("File tidak ada");
			include "obat/add_obat.php";
			break;

		case 'Obat-Delete':
			if (!file_exists("obat/delete_obat.php")) die("File tidak ada");
			include "obat/delete_obat.php";
			break;

			//  data supplier

		case 'Supplier-Data':
			if (!file_exists("supplier/supplier_data.php")) die("File tidak ada");
			include "supplier/supplier_data.php";
			break;

		case 'Supplier-Delete':
			if (!file_exists("supplier/supplier_delete.php")) die("file tidak ada");
			include "supplier/supplier_delete.php";
			break;

		case 'Pemesanan-Obat':
			if (!file_exists("supplier/supplier_beli.php")) die("file tidak ada");
			include "supplier/supplier_beli.php";
			break;

		case 'Terima-Obat':
			if (!file_exists("supplier/supplier_terima.php")) die("file tidak ada");
			include "supplier/supplier_terima.php";
			break;

		case 'Terima-Obat-Item':
			if (!file_exists("supplier/supplier_terima_item.php")) die("file tidak ada");
			include "supplier/supplier_terima_item.php";
			break;
	}
} else {
	if (!file_exists("home.php")) die("File home tidak ada");
	include "home.php";
}
