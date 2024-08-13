<?php

namespace App\Controllers;
use CodeIgniter\Models\Controller;
use App\Models\M_pesan;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
date_default_timezone_set('Asia/Jakarta');
class Home extends BaseController
{
	public function index(){
		if (session()->get('level') > 0) {
		$model = new M_pesan();
		$where = array('id_user' => session()->get('id'));
		$data['dua'] = $model->getwhere('user', $where);
		$where = array('id_setting' => 1);
		$data['setting'] = $model->getwhere('setting', $where);
		echo view('header',$data);
		echo view('menu',$data);
		echo view('dashboard');
		echo view('footer');
	} else {
		return redirect()->to('Home/login');
	}
	}

	public function login(){
		$model = new M_pesan();
		$where = array('id_setting' => 1);
		$data['setting'] = $model->getwhere('setting', $where);
		echo view('header',$data);
		echo view('header');
		echo view('login');

	}

	public function aksi_login()
{
    $u = $this->request->getPost('username');
    $p = $this->request->getPost('password');

    // Verifikasi reCAPTCHA
    $recaptchaResponse = trim($this->request->getPost('g-recaptcha-response'));
    $secret = '6LeKfiAqAAAAAFkFzd_B9MmWjX76dhdJmJFb6_Vi'; // Ganti dengan Secret Key Anda
    $credential = array(
        'secret' => $secret,
        'response' => $recaptchaResponse
    );

    $verify = curl_init();
    curl_setopt($verify, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
    curl_setopt($verify, CURLOPT_POST, true);
    curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($credential));
    curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($verify);

    $status = json_decode($response, true);

    if ($status['success']) {
        // Jika reCAPTCHA valid, lanjutkan proses login
        $where = array(
            'username' => $u,
            'password' => md5($p),
            
        );
        $model = new M_pesan;
        $cek = $model->getWhere('user', $where);

        if ($cek > 0) {
			session()->set('nama', $cek->username);
			session()->set('id', $cek->id_user);
			session()->set('level', $cek->level);
			return redirect()->to('home/index');
        } else {
            session()->setFlashdata('toast_message', 'Invalid login credentials');
            session()->setFlashdata('toast_type', 'danger');
            return redirect()->to('home/login');
        }
    } else {
        // Jika reCAPTCHA tidak valid, tampilkan pesan error
        session()->setFlashdata('toast_message', 'Captcha validation failed');
        session()->setFlashdata('toast_type', 'danger');
        return redirect()->to('home/login');
    }
}

	public function logout()
	{
		session()->destroy();
		return redirect()->to('home/login');
	}

	public function signup(){
		$model = new M_pesan();
		$where = array('id_setting' => 1);
	$data['setting'] = $model->getwhere('setting', $where);
		echo view('header',$data);
		echo view('signup',$data);
	}
	
	public function aksi_signup(){
	$model = new M_pesan();
	$username = $this->request->getPost('username');
	$password = $this->request->getPost('password');
	$email = $this->request->getPost('email');


	$data = array(
        'username' => $username,
        'password' => md5($password),
        'email' => $email,
		'level' => '3',
		'delete' => '0',
		'foto' => 'admin.jpg'
    );
	
    $model->tambah('user', $data);
    return redirect()->to('home/login');
}

private function generateVerificationCode($length = 6)
{
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

	public function verifikasi(){
		echo view('header');
		echo view('verifikasi');
	}

public function barang(){
	if (session()->get('level') == 1) {
	$model = new M_pesan();
	$where = array('id_user' => session()->get('id'));
	$data['dua'] = $model->getwhere('user', $where);
	$where1 = array('barang.delete' => '0');
	$data['satu'] = $model->tampilWhere('barang',$where1);
	$where = array('id_setting' => 1);
	$data['setting'] = $model->getwhere('setting', $where);
	echo view('header',$data);
	echo view('menu',$data);
	echo view('barang',$data);
	echo view('footer');
} else {
	return redirect()->to('Home/notfound');
}
}

public function tbarang(){
	if (session()->get('level') == 1) {
		$model = new M_pesan();
		$where = array('id_user' => session()->get('id'));
		$data['dua'] = $model->getwhere('user', $where);
		$data['satu'] = $model->tampil('barang');
		$where = array('id_setting' => 1);
		$data['setting'] = $model->getwhere('setting', $where);
		echo view('header',$data);
		echo view('menu',$data);
		echo view('tbarang',$data);
		echo view('footer');
	} else {
		return redirect()->to('Home/notfound');
	}
}

public function aksi_tbarang(){
	$model = new M_pesan();
	$uploadedFile = $this->request->getfile('foto');
	$nbarang = $this->request->getPost('nbarang');
	$kbarang = $this->request->getPost('kbarang');
	$hbeli = $this->request->getPost('hbeli');
	$hjual = $this->request->getPost('hjual');
	$stok = $this->request->getPost('stok');
	$status = $this->request->getPost('status');

	$foto = $uploadedFile->getName();
			$model->upload($uploadedFile);

	$data = array(
        'nama_barang' => $nbarang,
        'kode_barang' => $kbarang,
        'harga_beli' => $hbeli,
        'harga_jual' => $hjual,
        'stok' => $stok,
        'status' => $status,
		'delete' => '0',
		'foto' => $foto,
    );

    $model->tambah('barang', $data);
    return redirect()->to('home/barang');
}

public function ebarang($id){
	if (session()->get('level') == 1) {
		$model = new M_pesan();
		$where = array('id_user' => session()->get('id'));
		$data['dua'] = $model->getwhere('user', $where);
		$where = array('id_barang' => $id);
		$data['satu'] = $model->getWhere('barang',$where);
		$where = array('id_setting' => 1);
		$data['setting'] = $model->getwhere('setting', $where);
		echo view('header',$data);
		echo view('menu',$data);
		echo view('ebarang',$data);
		echo view('footer');
	} else {
		return redirect()->to('Home/notfound');
	}
}
public function ebarangk($id){
	if (session()->get('level') == 1) {
		$model = new M_pesan();
		$where = array('id_user' => session()->get('id'));
		$data['dua'] = $model->getwhere('user', $where);
		$where5 = array('id_bkeluar' => $id);
		$data['satu'] = $model->getWhere('barangkeluar',$where5);
		$data['tiga'] = $model->joinnowhere('barang','barangkeluar','barang.id_barang = barangkeluar.id_barang');
		$data['empat'] = $model->tampil('barang');
		$where = array('id_setting' => 1);
		$data['setting'] = $model->getwhere('setting', $where);
		echo view('header',$data);
		echo view('menu',$data);
		echo view('ebarangk',$data);
		echo view('footer');
	
	} elseif(session()->get('level') == 2||session()->get('level') == 3) {
		return redirect()->to('Home/notfound');
	}else{
		return redirect()->to('home/login');
	}
}
public function aksi_ebarangk(){
	$model = new M_pesan();
	$nbarang = $this->request->getPost('namabarang');
	$stok = $this->request->getPost('stok');
	$tanggal = $this->request->getPost('tanggal');
	$create_at = $this->request->getPost('create_at');
	$id = $this->request->getPost('id');

	$data = array(
        'id_barang' => $nbarang,
        'jumlah' => $stok,
		'update_by' => session()->get('id'),
		'update_at' => date('Y-m-d H:i:s'),
		'create_at' => $create_at,
		'tanggal' => $tanggal,
    );
	print_r($data);
	
	$where = array('id_bkeluar' => $id);
    $model->edit('barangkeluar', $data, $where);
    return redirect()->to('home/barangkeluar');
}
public function aksi_ebarang(){
	$model = new M_pesan();
	$nbarang = $this->request->getPost('nbarang');
	$kbarang = $this->request->getPost('kbarang');
	$hbeli = $this->request->getPost('hbeli');
	$hjual = $this->request->getPost('hjual');
	$stok = $this->request->getPost('stok');
	$status = $this->request->getPost('status');
	$id = $this->request->getPost('id');

	$data = array(
        'nama_barang' => $nbarang,
        'kode_barang' => $kbarang,
        'harga_beli' => $hbeli,
        'harga_jual' => $hjual,
        'stok' => $stok,
        'status' => $status,
    );
	$where = array('id_barang' => $id);
    $model->edit('barang', $data, $where);
    return redirect()->to('home/barang');
}
public function aksi_rebarang(){
	$model = new M_pesan();
	$nbarang = $this->request->getPost('nbarang');
	$kbarang = $this->request->getPost('kbarang');
	$hbeli = $this->request->getPost('hbeli');
	$hjual = $this->request->getPost('hjual');
	$stok = $this->request->getPost('stok');
	$status = $this->request->getPost('status');
	$id = $this->request->getPost('id');

	$data = array(
        'nama_barang' => $nbarang,
        'kode_barang' => $kbarang,
        'harga_beli' => $hbeli,
        'harga_jual' => $hjual,
        'stok' => $stok,
        'status' => $status,
    );
	$where = array('id_barang' => $id);
    $model->edit('barang', $data, $where);
    return redirect()->to('home/rbarang');
}
public function hbarang($id)
	{
		$model = new M_pesan();
		$where = array('id_barang' => $id);
		$model->hapus('barang', $where);

		return redirect()->to('home/rbarang');
	}

public function sdbarang($id)
{
		$model = new M_pesan;
		// Ubah status transaksi menjadi "habis" di kedua tabel
		$model->softdelete1('barang','id_barang',$id);

		// Kirim respons (jika diperlukan)
		return redirect()->to('home/barang');
}

public function rsbarang($id){
		$model = new M_pesan;
		// Pass the where condition directly to the softdelete() function
		$model->restore1('barang','id_barang',$id);
		// print_r($id);
		// Redirect to 'home/recyclebin'
		return redirect()->to('home/rbarang');
}

public function pemesanan(){
	if (session()->get('level') > 0) {
		$model = new M_pesan();
		$where = array('id_user' => session()->get('id'));
		$data['dua'] = $model->getwhere('user', $where);
		$where1 = array('barang.delete' => '0');
	$data['satu'] = $model->tampilWhere('barang',$where1);
	$where = array('id_setting' => 1);
		$data['setting'] = $model->getwhere('setting', $where);
		echo view('header',$data);
		echo view('menu',$data);
		echo view('pemesanan',$data); 
		echo view('footer');
	} else {
		return redirect()->to('Home/login');
	}
}
public function tkeranjang(){
	if (session()->get('level') == 1 || session()->get('level') == 3) {
		$model = new M_pesan();
		$where = array('id_user' => session()->get('id'));
		$data['dua'] = $model->getwhere('user', $where);
		$where1 = array('barang.delete' => '0');
		$where2 = array('barang.status' => 'tersedia');
		$data['satu'] = $model->tampilWhere2('barang',$where1,$where2);
		$where = array('id_setting' => 1);
		$data['setting'] = $model->getwhere('setting', $where);
		echo view('header',$data);
		echo view('menu',$data);
		echo view('tkeranjang',$data);
		echo view('footer');
	} elseif(session()->get('level') == 2) {
		return redirect()->to('Home/notfound');
	}else{
		return redirect()->to('Home/login');
	}
}
public function dkeranjang($id){
	if (session()->get('level') > 0) {
		$model = new M_pesan();
		$where = array('id_user' => session()->get('id'));
		$data['dua'] = $model->getwhere('user', $where);
		$where = array('kode_keranjang' => $id);
		$data['tiga'] = $model->joinresult('keranjang','barang','keranjang.id_barang=barang.id_barang', $where);
		$data['empat'] = $model->getWhere('keranjang',$where);
		$data['satu'] = $model->groupbyjoinn('keranjang', 'barang', 'barang.id_barang = keranjang.id_barang');
		$where = array('id_setting' => 1);
		$data['setting'] = $model->getwhere('setting', $where);
		echo view('header',$data);
		echo view('menu',$data);
		echo view('dkeranjang',$data);
		echo view('footer');
		// print_r($data1);
	} else {
		return redirect()->to('Home/login');
	}
}
public function setting(){
	if (session()->get('level') == 1) {
		$model = new M_pesan();
		$where = array('id_user' => session()->get('id'));
		$data['dua'] = $model->getwhere('user', $where);
		$where = array('id_setting' => 1);
		$data['setting'] = $model->getwhere('setting', $where);
		echo view('header',$data);
		echo view('menu',$data);
		echo view('setting',$data);
		echo view('footer');
	} else {
		return redirect()->to('Home/notfound');
	}
}

public function aksi_esetting() {
    $model = new M_pesan();
    $jwebsite = $this->request->getPost('judul_website');
    $t_icon = $this->request->getFile('t_icon');
    $m_icon = $this->request->getFile('m_icon');
    $l_icon = $this->request->getFile('l_icon');
    $id = $this->request->getPost('id');

    $data = array('judul_website' => $jwebsite);

    if ($t_icon->isValid() && !$t_icon->hasMoved()) {
        $foto_t_icon = $t_icon->getName();
        $t_icon->move(ROOTPATH . 'public/images', $foto_t_icon);
        $data['tab_icon'] = $foto_t_icon;
    }
    
    if ($m_icon->isValid() && !$m_icon->hasMoved()) {
        $foto_m_icon = $m_icon->getName();
        $m_icon->move(ROOTPATH . 'public/images', $foto_m_icon);
        $data['menu_icon'] = $foto_m_icon;
    }
    
    if ($l_icon->isValid() && !$l_icon->hasMoved()) {
        $foto_l_icon = $l_icon->getName();
        $l_icon->move(ROOTPATH . 'public/images', $foto_l_icon);
        $data['login_icon'] = $foto_l_icon;
    }
    
    $where = array('id_setting' => $id);
    $model->edit('setting', $data, $where);
    
    return redirect()->to('home/setting');
}

public function aksi_euser(){
	$model = new M_pesan();
	$uploadedFile = $this->request->getfile('foto');
	$username = $this->request->getPost('username');
	$email = $this->request->getPost('email');
	$level = $this->request->getPost('level');
	$id = $this->request->getPost('id');
	$where = array('id_user' => $id);
	if ($uploadedFile->getName()) {
		$foto = $uploadedFile->getName();
		$model->upload($uploadedFile);

		
	$data = array(
        'username' => $username,
        'email' => $email,
		'foto' => $foto,
		'level' => $level
    );

	}else{
		$data = array(
			'username' => $username,
			'email' => $email,
			'level' => $level
		);
	}
	

		

    $model->edit('user', $data, $where);
    return redirect()->to('home/user');
}

 public function huser($id)
	{
		$model = new M_pesan();
		$where = array('id_user' => $id);
		$model->hapus('user', $where);

		return redirect()->to('Home/user');
	}
public function user(){
		if (session()->get('level') == 1) {
			$model = new M_pesan();
			$where = array('id_user' => session()->get('id'));
			$data['dua'] = $model->getwhere('user', $where);
			$where1 = array('delete' => '0');
			$data['satu'] = $model->tampilwhere('user',$where1);
			$where = array('id_setting' => 1);
			$data['setting'] = $model->getwhere('setting', $where);
			echo view('header',$data);
			echo view('menu',$data);
			echo view('user',$data);
			echo view('footer');
		} elseif(session()->get('level') == 2||session()->get('level') == 3) {
			return redirect()->to('home/notfound');
		}else{
			return redirect()->to('home/login');
		}
	}
	public function tuser(){
		if (session()->get('level') == 1) {
			$model = new M_pesan();
			$where = array('id_user' => session()->get('id'));
			$data['dua'] = $model->getwhere('user', $where);
			$where = array('id_setting' => 1);
			$data['setting'] = $model->getwhere('setting', $where);
			echo view('header',$data);
			echo view('menu',$data);
			echo view('tuser',$data);
			echo view('footer');
		} else {
			return redirect()->to('Home/notfound');
		}
	}
	
	public function euser($id){
		if (session()->get('level') == 1) {
			$model = new M_pesan();
			$where = array('id_user' => session()->get('id'));
			$data['dua'] = $model->getwhere('user', $where);
			$where = array('id_user' => $id);
			$data['satu'] = $model->getWhere('user',$where);
			$where = array('id_setting' => 1);
			$data['setting'] = $model->getwhere('setting', $where);
			echo view('header',$data);
			echo view('menu',$data);
			echo view('euser',$data);
			echo view('footer');
		} else {
			return redirect()->to('Home/notfound');
		}
	}
	public function aksi_tuser(){
	$model = new M_pesan();
	$uploadedFile = $this->request->getfile('foto');
	$username = $this->request->getPost('username');
	$password = $this->request->getPost('password');
	$email = $this->request->getPost('email');
	$level = $this->request->getPost('level');

	if ($uploadedFile->getName()) {
		$foto = $uploadedFile->getName();
		$model->upload($uploadedFile);

	$data = array(
        'username' => $username,
        'password' => md5($password),
        'email' => $email,
		'foto' => $foto,
		'level' => $level
    );

	}else{
		$data = array(
			'username' => $username,
			'password' => md5($password),
			'email' => $email,
			'foto' => 'admin.jpg',
			'level' => $level
		);
	}
	

		

    $model->tambah('user', $data);
    return redirect()->to('home/user');
}
public function keranjang($id){
	$model = new M_pesan();
	if (session()->get('level') == 3) {
		
		$where = array('id_user' => session()->get('id'));
		$data['dua'] = $model->getwhere('user', $where);
		$where1 = array('keranjang.deletek' => '0');
		$where2 = array('keranjang.id_user' => session()->get('id'));
		$data['satu'] = $model->groupbyjoin3where1($where1,$where2);
		$where = array('id_setting' => 1);
		$data['setting'] = $model->getwhere('setting', $where);
		echo view('header',$data);
		echo view('menu',$data);
		echo view('keranjang',$data);
		echo view('footer');

	}elseif(session()->get('level') == 1){	

	$where = array('id_user' => session()->get('id'));
	$data['dua'] = $model->getwhere('user', $where);
	$where1 = array('keranjang.deletek' => '0');
	$data['satu'] = $model->groupbyjoin3where($where1);
	$where = array('id_setting' => 1);
	$data['setting'] = $model->getwhere('setting', $where);
	echo view('header',$data);
	echo view('menu',$data);
	echo view('keranjang',$data);
	echo view('footer');

	} elseif(session()->get('level') == 2) {
		return redirect()->to('Home/notfound');
	}else{
		return redirect()->to('home/login');
	}
}
public function hpesanan(){
	$model = new M_pesan();
	if(session()->get('level') == 1 || session()->get('level') == 3){

		$where = ['id_user' => session()->get('id')];
		$data['dua'] = $model->getWhere('user', $where);
		
		// Get settings data
		$where = ['id_setting' => 1];
		$data['setting'] = $model->getWhere('setting', $where);
		
	
		$where3 = ['transaksi.id_user' => session()->get('id')];
		$where2 = array('status_transaksi' => 'Done');
		$data2['satu'] = $model->groupbyjoinnwhere22($where3,$where2);
		
		echo view('header', $data);
		echo view('menu', $data);
		echo view('hpesanan', $data2);
		echo view('footer', $data);

	}elseif(session()->get('level') == 2){

		return redirect()->to('home/notfound');
	
	} else {
		return redirect()->to('Home/login');
	}
}
public function infopesanan(){
	if (session()->get('level') > 0) {
		$model = new M_pesan();
		$where = array('id_user' => session()->get('id'));
		$data['dua'] = $model->getwhere('user', $where);
		$data['satu'] = $model->groupbyjoinn('keranjang', 'barang', 'barang.id_barang = keranjang.id_barang');
		$where = array('id_setting' => 1);
		$data['setting'] = $model->getwhere('setting', $where);
		echo view('header',$data);
		echo view('menu',$data);
		echo view('keranjang',$data);
		echo view('footer');
	} else {
		return redirect()->to('Home/login');
	}
}
public function riwayat_p() {
    if (session()->get('level') > 0) {
        $model = new M_pesan(); // Adjust namespace according to your app's structure
        $where = ['id_user' => session()->get('id')];
        $data['dua'] = $model->getWhere('user', $where); // Ensure method name matches your model's method
        $where = ['id_setting' => 1];
        $data['setting'] = $model->getWhere('setting', $where); // Ensure method name matches your model's method

        echo view('header', $data);
        echo view('menu', $data);
        echo view('riwayat_p', $data);
        echo view('footer');
    } else {
        return redirect()->to('Home/login');
    }
}
public function notfound(){
	if (session()->get('level') > 0) {
        $model = new M_pesan(); // Adjust namespace according to your app's structure
        $where = ['id_user' => session()->get('id')];
        $data['dua'] = $model->getWhere('user', $where); // Ensure method name matches your model's method
        $where = ['id_setting' => 1];
        $data['setting'] = $model->getWhere('setting', $where); // Ensure method name matches your model's method

        echo view('header', $data);
        echo view('menu', $data);
        echo view('notfound');
        // echo view('footer');
    } else {
        return redirect()->to('Home/login');
    }
}
public function save_cart() {
    $model = new M_pesan(); // Ensure you have a model for handling cart data

    // Get cart data from POST request
    $cartData = $this->request->getBody(); // Use getBody() for raw POST data

    // Log cartData for debugging
    log_message('debug', 'Cart data received: ' . $cartData);

    // Decode JSON data
    $cartData = json_decode($cartData, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid JSON data']);
    }

    // Log decoded cart data for debugging
    log_message('debug', 'Decoded cart data: ' . print_r($cartData, true));

    // Generate a unique cart code
    $cartCode = 'CPP-' . str_pad($model->getNextCartCode(), 4, '0', STR_PAD_LEFT);

    // Get user ID from session
    $userId = session()->get('id');
    if (!$userId) {
        return $this->response->setJSON(['status' => 'error', 'message' => 'User not logged in']);
    }

    // Insert each item into the cart
    foreach ($cartData['items'] as $item) {
        $data = [
            'id_user' => $userId,
            'id_barang' => $item['id'],
            'quantity' => $item['quantity'],
            'kode_keranjang' => $cartCode,
			'create_at' => date('Y-m-d H:i:s'),
			'create_by' => session()->get('id'),
			'status' => 'pending'
        ];

        if (!$model->add_to_cart($data)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to save item to cart']);
        }
    }

	session()->set('kode_keranjang', $cartCode);
    // Return success response
    return $this->response->setJSON(['status' => 'success', 'message' => 'Cart saved successfully']);
}
public function bayar() {
    try {
        if (session()->get('level') > 0) {
            $model = new M_pesan();
            
            // Get user data
            $where = ['id_user' => session()->get('id')];
            $data['dua'] = $model->getWhere('user', $where);
            $kkeranjang = $this->request->getPost('kode_keranjang');
			if (!empty($kkeranjang)) {
			session()->set('kode_keranjang', $kkeranjang);
			}else{

			}
            $where = ['id_setting' => 1];
            $data['setting'] = $model->getWhere('setting', $where);
            
            
            $kodeKeranjang = session()->get('kode_keranjang');
            $where4 = ['keranjang.kode_keranjang' => $kodeKeranjang];
            $data['satu'] = $model->groupbyjoinnwhere('keranjang', 'barang', 'barang.id_barang = keranjang.id_barang', $where4);
            
            // Pass kode_keranjang and id_user to view
            $data['kode_keranjang'] = $kodeKeranjang; // Ensure this is set
            $data['id_user'] = session()->get('id');   // Ensure this is set
            
            echo view('header', $data);
            echo view('menu', $data);
            echo view('bayar', $data);
            echo view('footer', $data);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'User not authorized']);
        }
    } catch (Exception $e) {
        log_message('error', 'An error occurred: ' . $e->getMessage());
        return $this->response->setJSON(['status' => 'error', 'message' => 'An error occurred while processing the payment.']);
    }
}

public function generateTransactionNumber()
{
    $model = new M_pesan();
    $lastTransaction = $model->getLastTransaction();
    
    if ($lastTransaction) {
        $lastNumber = (int)substr($lastTransaction->no_transaksi, 4);
        $newNumber = $lastNumber + 1;
    } else {
        $newNumber = 1;
    }
    return 'CTP-' . $newNumber;
}
public function cash()
{
    $model = new M_pesan();
    $notransaksi = $this->generateTransactionNumber();
    $kode_keranjang = $this->request->getPost('kode_keranjang');
    $iduser = $this->request->getPost('id_user');
    $id_barang = $this->request->getPost('id_barang');
    $quantity = $this->request->getPost('quantity');
	$alamat = $this->request->getPost('Alamat');
	$total = $this->request->getPost('total_price');


    // Debugging: Print received data
    echo "<pre>";
    print_r($id_barang);
    print_r($quantity);
    echo "</pre>";

    $data = array(
        'no_transaksi' => $notransaksi,
        'kode_keranjang' => $kode_keranjang,
        'tanggal' => date('Y-m-d H:i:s'),
        'create_at' => date('Y-m-d H:i:s'),
        'create_by' => session()->get('id'),
		'deletet' => '0',
    );

	$data1 = array(
        'nomor_transaksi' => $notransaksi,
        'tanggal_transaksi' => date('Y-m-d'),
		'jumlah_transaksi' => $total,
        'create_at' => date('Y-m-d H:i:s'),
        'create_by' => session()->get('id'),
		'delete' => '0',
    );

    foreach ($id_barang as $index => $barang) {
        $data2 = array(
            'id_barang' => $barang,
            'jumlah' => $quantity[$index],
			'delete' => '0',
			'tanggal' => date('Y-m-d'),
            'create_at' => date('Y-m-d H:i:s'),
            'create_by' => session()->get('id'),
			'kode_keranjang' => $kode_keranjang
        );
        
        $model->tambah('barangkeluar', $data2);
    }



    $where = array('kode_keranjang' => $kode_keranjang);
    $model->tambah('transaksi', $data);
	$model->tambah('nota', $data1);
    $model->statuskeranjang('keranjang', 'kode_keranjang', $where);
    // return redirect()->to('home/pemesanan');
}
public function barangmasuk(){
	if (session()->get('level') == 1) {
	$model = new M_pesan();
	$where = array('id_user' => session()->get('id'));
	$data['dua'] = $model->getwhere('user', $where);
	$where1 = array('barangmasuk.delete' => '0');
	$data['satu'] = $model->joinresult('barangmasuk','barang','barangmasuk.id_barang = barang.id_barang',$where1);
	$where = array('id_setting' => 1);
	$data['setting'] = $model->getwhere('setting', $where);
	echo view('header',$data);
	echo view('menu',$data);
	echo view('barangmasuk',$data);
	echo view('footer');
} elseif(session()->get('level') == 2||session()->get('level') == 3) {
	return redirect()->to('Home/notfound');
}else{
	return redirect()->to('home/login');
}
}

public function tbarangm(){
	if (session()->get('level') == 1) {
		$model = new M_pesan();
		$where = array('id_user' => session()->get('id'));
		$data['dua'] = $model->getwhere('user', $where);
		$data['satu'] = $model->joinnowhere('barangmasuk','barang','barangmasuk.id_barang = barang.id_barang');
		$where = array('id_setting' => 1);
		$data['setting'] = $model->getwhere('setting', $where);
		echo view('header',$data);
		echo view('menu',$data);
		echo view('tbarangm',$data);
		echo view('footer');
	} elseif(session()->get('level') == 2||session()->get('level') == 3) {
		return redirect()->to('Home/notfound');
	}else{
		return redirect()->to('home/login');
	}
}
public function tbarangk(){
	if (session()->get('level') == 1) {
		$model = new M_pesan();
		$where = array('id_user' => session()->get('id'));
		$data['dua'] = $model->getwhere('user', $where);
		$data['satu'] = $model->joinnowhere('barangkeluar','barang','barangkeluar.id_barang = barang.id_barang');
		$data['tiga'] = $model->tampil('barang');
		$where = array('id_setting' => 1);
		$data['setting'] = $model->getwhere('setting', $where);
		echo view('header',$data);
		echo view('menu',$data);
		echo view('tbarangk',$data);
		echo view('footer');
	} elseif(session()->get('level') == 2||session()->get('level') == 3) {
		return redirect()->to('Home/notfound');
	}else{
		return redirect()->to('home/login');
	}
}

public function aksi_tbarangm(){
	$model = new M_pesan();
	
	$nbarang = $this->request->getPost('namabarang');
	$stok = $this->request->getPost('stok');

	$data = array(
        'id_barang' => $nbarang,
        'quantity' => $stok,
		'delete' => '0',
		'create_at' => date('Y-m-d H:i:s'),
		'create_by' => session()->get('id'),
    );

	$model->tambah('barangmasuk', $data);
    return redirect()->to('home/barangmasuk');
}
public function aksi_tbarangk(){
	$model = new M_pesan();
	
	$nbarang = $this->request->getPost('namabarang');
	$stok = $this->request->getPost('stok');

	$data = array(
        'id_barang' => $nbarang,
        'jumlah' => $stok,
		'delete' => '0',
		'tanggal' => date('Y-m-d'),
		'create_at' => date('Y-m-d H:i:s'),
		'create_by' => session()->get('id'),
    );

	$model->tambah('barangkeluar', $data);
    return redirect()->to('home/barangkeluar');
}
public function barangkeluar(){
	if (session()->get('level') == 1) {
	$model = new M_pesan();
	$where = array('id_user' => session()->get('id'));
	$data['dua'] = $model->getwhere('user', $where);
	$where1 = array('barangkeluar.delete' => '0');
	$data['satu'] = $model->joinresult('barangkeluar','barang','barangkeluar.id_barang = barang.id_barang',$where1);
	$where = array('id_setting' => 1);
	$data['setting'] = $model->getwhere('setting', $where);
	echo view('header',$data);
	echo view('menu',$data);
	echo view('barang',$data);
	echo view('footer');
} elseif(session()->get('level') == 2||session()->get('level') == 3) {
	return redirect()->to('Home/notfound');
}else{
	return redirect()->to('home/login');
}
}
public function pesanan(){
	$model = new M_pesan();
    if(session()->get('level') == 3){

	$where = ['id_user' => session()->get('id')];
	$data['dua'] = $model->getWhere('user', $where);
	
	// Get settings data
	$where = ['id_setting' => 1];
	$data['setting'] = $model->getWhere('setting', $where);
	

	$where3 = ['transaksi.id_user' => session()->get('id')];
	$where2 = array('status_transaksi' => 'Pending');
	$where4 = array('status_transaksi' => 'On The Way');
	$data['satu'] = $model->groupbyjoinnwhere3($where3,$where2,$where4);
	
	echo view('header', $data);
    echo view('menu', $data);
    echo view('pesanan', $data);
    echo view('footer', $data);

	}elseif(session()->get('level')==1){

	$where = ['id_user' => session()->get('id')];
	$data['dua'] = $model->getWhere('user', $where);
	
	$where = ['id_setting' => 1];
	$data['setting'] = $model->getWhere('setting', $where);
	

	$where2 = array('status_transaksi' => 'Pending');
	$where4 = array('status_transaksi' => 'On The Way');
	$data2['satu'] = $model->groupbyjoinnwhere2($where2,$where4);
	
	echo view('header', $data);
    echo view('menu', $data);
    echo view('pesanan', $data2);
    echo view('footer', $data);
	}elseif(session()->get('level')==2){

		return redirect()->to('Home/notfound');

	}else{

		return redirect()->to('home/login');

	}

}
public function statusto($id)
{
    $model = new M_pesan;
    
    // Ubah status transaksi menjadi "habis" di tabel barang
    $where = ['id_transaksi' => $id];
    $model->softdelete2('transaksi', 'status_transaksi', 'On The Way', $where);

    // Kirim respons (jika diperlukan)
    return redirect()->to('home/Pesanan');
}

public function statustd($id)
{
    $model = new M_pesan;
    
    // Ubah status transaksi menjadi "habis" di tabel barang
    $where = ['id_transaksi' => $id];
    $model->softdelete2('transaksi', 'status_transaksi', 'Done', $where);

    // Kirim respons (jika diperlukan)
    return redirect()->to('home/Pesanan');
}

public function resetpassword($id){
	$model = new M_pesan;
	$where = array('id_user' =>$id );
	$table = 'user'; // Nama tabel
	$kolom = 'id_user';
	$data = array(
       
        'password' => md5('cpp123'),
    );

	$model->resetpassword($table, $kolom, $where, $data);
	return redirect()->to('Home/user');
}

public function profile(){
	if (session()->get('level') > 0) {
        $model = new M_pesan(); // Adjust namespace according to your app's structure
        $where = ['id_user' => session()->get('id')];
        $data['dua'] = $model->getWhere('user', $where); // Ensure method name matches your model's method
        $where = ['id_setting' => 1];
        $data['setting'] = $model->getWhere('setting', $where); // Ensure method name matches your model's method
		
        echo view('header', $data);
        echo view('menu', $data);
        echo view('profile', $data);
        echo view('footer');
    } else {
        return redirect()->to('Home/login');
    }
}

public function aksi_eprofile(){
	$model = new M_pesan();
	$uploadedFile = $this->request->getfile('foto');
	$username = $this->request->getPost('username');
	$email = $this->request->getPost('email');
	$notelp = $this->request->getPost('no_telp');
	$level = $this->request->getPost('level');
	$id = $this->request->getPost('id');
	$where = array('id_user' => $id);
	if ($uploadedFile->getName()) {
		$foto = $uploadedFile->getName();
		$model->upload1($uploadedFile);

		
	$data = array(
        'username' => $username,
        'email' => $email,
		'foto' => $foto,
		'no_telp' => $notelp,
		'level' => $level,
		'update_by' => session()->get('id'),
		'update_at' => date('Y-m-d H:i:s')
    );

	}else{
		$data = array(
			'username' => $username,
			'email' => $email,
			'level' => $level,
			'no_telp' => $notelp,
			'update_by' => session()->get('id'),
			'update_at' => date('Y-m-d H:i:s')
		);
	}
	

		

    $model->edit('user', $data, $where);
    return redirect()->to('home/profile');
}

public function changepassword(){
	if (session()->get('level') > 0) {
        $model = new M_pesan(); // Adjust namespace according to your app's structure
        $where = ['id_user' => session()->get('id')];
        $data['dua'] = $model->getWhere('user', $where); // Ensure method name matches your model's method
        $where = ['id_setting' => 1];
        $data['setting'] = $model->getWhere('setting', $where); // Ensure method name matches your model's method
		
        echo view('header', $data);
        echo view('menu', $data);
        echo view('changepassword', $data);
        echo view('footer');
    } else {
        return redirect()->to('Home/login');
    }
}

public function aksi_changepass() {
    $model = new M_pesan();
    $oldPassword = $this->request->getPost('old');
    $newPassword = $this->request->getPost('new');
    $userId = session()->get('id');

    // Dapatkan password lama dari database
    $currentPassword = $model->getPassword($userId);

    // Verifikasi apakah password lama cocok
    if (md5($oldPassword) !== $currentPassword) {
        // Set pesan error jika password lama salah
        session()->setFlashdata('error', 'Password lama tidak valid.');
        return redirect()->back()->withInput();
    }

    // Update password baru
    $data = [
        'password' => md5($newPassword),
        'update_by' => $userId,
        'update_at' => date('Y-m-d H:i:s')
    ];
    $where = ['id_user' => $userId];
    
    $model->edit('user', $data, $where);
    
    // Set pesan sukses
    session()->setFlashdata('success', 'Password berhasil diperbarui.');
    return redirect()->to('home/changepassword');
}
public function printnota($id) {
    $model = new M_pesan();
    if (session()->get('level') == 1 || session()->get('level') == 3) {
        $where = ['id_user' => session()->get('id')];
        $data['dua'] = $model->getWhere('user', $where);
        
        $where = ['id_setting' => 1];
        $data['setting'] = $model->getWhere('setting', $where);
        
        $where2 = ['keranjang.kode_keranjang' => $id];
		$where3 = ['transaksi.kode_keranjang' => $id];
		$data['transaksi'] = $model->getWhere('transaksi', $where3);
        $data['satu'] = $model->joinresult2('keranjang','barang','keranjang.id_barang=barang.id_barang','transaksi','transaksi.kode_keranjang=keranjang.kode_keranjang',$where2);

        echo view('print_nota', $data);

	} elseif (session()->get('level') == 2) {
        return redirect()->to('home/notfound');
    } else {
        return redirect()->to('Home/login');
    }
}
public function sdbarangm($id)
{
		$model = new M_pesan;
		// Ubah status transaksi menjadi "habis" di kedua tabel
		$model->softdelete1('barangmasuk','id_bmasuk',$id);

		// Kirim respons (jika diperlukan)
		return redirect()->to('home/barangmasuk');
}

public function rsbarangm($id){
		$model = new M_pesan;
		// Pass the where condition directly to the softdelete() function
		$model->restore1('barangmasuk','id_bmasuk',$id);
		// print_r($id);
		// Redirect to 'home/recyclebin'
		return redirect()->to('home/rbarangmasuk');
}

public function sdbarangk($id)
{
		$model = new M_pesan;
		// Ubah status transaksi menjadi "habis" di kedua tabel
		$model->softdelete1('barangkeluar','id_bkeluar',$id);

		// Kirim respons (jika diperlukan)
		return redirect()->to('home/barangkeluar');
}

public function rsbarangk($id){
		$model = new M_pesan;
		// Pass the where condition directly to the softdelete() function
		$model->restore1('barangkeluar','id_bkeluar',$id);
		// print_r($id);
		// Redirect to 'home/recyclebin'
		return redirect()->to('home/rbarangkeluar');
}

public function hbarangm($id)
	{
		$model = new M_pesan();
		$where = array('id_barang' => $id);
		$model->hapus('barangmasuk', $where);

		return redirect()->to('Home/rbarangmasuk');
	}

	public function hbarangk($id)
	{
		$model = new M_pesan();
		$where = array('id_barang' => $id);
		$model->hapus('barangkeluar', $where);

		return redirect()->to('Home/rbarangkeluar');
	}

	public function sduser($id) {
        $model = new M_pesan();
        // Ubah status transaksi menjadi "habis" di tabel user
        $model->softdelete1('user', 'id_user', $id);

        // Debugging
        if ($model->db->affectedRows() > 0) {
            // Pengalihan setelah penghapusan
            return redirect()->to('/home/user'); // Perhatikan rute ini
        } else {
            echo "Pengguna dengan ID $id tidak ditemukan atau sudah dihapus.";
        }
    }
	public function ruser(){
		if (session()->get('level') == 1) {
			$model = new M_pesan();
			$where = array('id_user' => session()->get('id'));
			$data['dua'] = $model->getwhere('user', $where);
			$where1 = array('delete' => '1');
			$data['satu'] = $model->tampilwhere('user',$where1);
			$where = array('id_setting' => 1);
			$data['setting'] = $model->getwhere('setting', $where);
			echo view('header',$data);
			echo view('menu',$data);
			echo view('user',$data);
			echo view('footer');
		} elseif(session()->get('level') == 2||session()->get('level') == 3) {
			return redirect()->to('Home/notfound');
		}else{
			return redirect()->to('home/login');
		}
	}
public function rsuser($id){
			$model = new M_pesan;
			// Pass the where condition directly to the softdelete() function
			$model->restore1('user','id_user',$id);
			// print_r($id);
			// Redirect to 'home/recyclebin'
			return redirect()->to('home/ruser');
	}

	
	public function rbarang() {
        if (session()->get('level') == 1) {
            $model = new M_pesan();
            
            // Data pengguna saat ini
            $where = ['id_user' => session()->get('id')];
            $data['dua'] = $model->getwhere('user', $where);
            
            // Data barang yang sudah dihapus (soft delete)
            $where1 = ['barang.delete' => '1'];
            $data['satu'] = $model->tampilWhere('barang', $where1);
            
            // Data setting
            $whereSetting = ['id_setting' => 1];
            $data['setting'] = $model->getwhere('setting', $whereSetting);

            // Render view
            echo view('header', $data);
            echo view('menu', $data);
            echo view('barang', $data);
            echo view('footer');
        } elseif (session()->get('level') == 2 || session()->get('level') == 3) {
            return redirect()->to('home/notfound');
        } else {
            return redirect()->to('home/login');
        }
    }

public function rbarangmasuk(){
	if (session()->get('level') == 1) {
	$model = new M_pesan();
	$where = array('id_user' => session()->get('id'));
	$data['dua'] = $model->getwhere('user', $where);
	$where1 = array('barangmasuk.delete' => '1');
	$data['satu'] = $model->joinresult('barangmasuk','barang','barangmasuk.id_barang = barang.id_barang',$where1);
	$where = array('id_setting' => 1);
	$data['setting'] = $model->getwhere('setting', $where);
	echo view('header',$data);
	echo view('menu',$data);
	echo view('barang',$data);
	echo view('footer');
} elseif(session()->get('level') == 2||session()->get('level') == 3) {
	return redirect()->to('Home/notfound');
}else{
	return redirect()->to('home/login');
}
}

public function rbarangkeluar(){
	if (session()->get('level') == 1) {
	$model = new M_pesan();
	$where = array('id_user' => session()->get('id'));
	$data['dua'] = $model->getwhere('user', $where);
	$where1 = array('barangkeluar.delete' => '1');
	$data['satu'] = $model->joinresult('barangkeluar','barang','barangkeluar.id_barang = barang.id_barang',$where1);
	$where = array('id_setting' => 1);
	$data['setting'] = $model->getwhere('setting', $where);
	echo view('header',$data);
	echo view('menu',$data);
	echo view('barang',$data);
	echo view('footer');
} elseif(session()->get('level') == 2||session()->get('level') == 3) {
	return redirect()->to('Home/notfound');
}else{
	return redirect()->to('home/login');
}
}
public function laporantransaksi(){
	if (session()->get('level') == 1) {
		$model = new M_pesan();
		$where = array('id_user' => session()->get('id'));
		$data['dua'] = $model->getwhere('user', $where);
		$data['satu'] = $model->groupbyjoin4where0('keranjang',
			'barang',
			'transaksi',
			'user',
			'nota',
			'barang.id_barang = keranjang.id_barang',
			'transaksi.kode_keranjang = keranjang.kode_keranjang', 
			'keranjang.id_user = user.id_user',
			'transaksi.no_transaksi = nota.nomor_transaksi',
			);
		$where = array('id_setting' => 1);
		$data['setting'] = $model->getwhere('setting', $where);
		
		echo view('header',$data);
		echo view('menu',$data);
		echo view('laporantransaksi',$data);
		echo view('footer');
	} elseif(session()->get('level') == 2||session()->get('level') == 3) {
		return redirect()->to('Home/notfound');
	}else{
		return redirect()->to('home/login');
	}
}

public function filterTanggal()
    {
		if (session()->get('level') == 1) {
        // Ambil parameter tanggal dari query string
        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');

        // Set tanggal default jika tidak ada filter
        if (!$startDate) {
            $startDate = '0000-00-00'; // Atau tanggal default yang sesuai
        }
        if (!$endDate) {
            $endDate = '9999-12-31'; // Atau tanggal default yang sesuai
        }

        // Panggil model untuk mendapatkan data yang difilter
        $model = new M_pesan(); // Ganti dengan nama model Anda
		$where = array('id_user' => session()->get('id'));
		$data['dua'] = $model->getwhere('user', $where);
		$where = array('id_setting' => 1);
		$data['setting'] = $model->getwhere('setting', $where);
        $data['satu'] = $model->groupbyjoin4where1(
            'keranjang', 
            'barang', 
            'transaksi', 
            'user',
			'nota', 
            'keranjang.id_barang = barang.id_barang', 
            'transaksi.kode_keranjang = keranjang.kode_keranjang', 
            'user.id_user = transaksi.create_by',
			'transaksi.no_transaksi = nota.nomor_transaksi',
            [], // Tambahkan kondisi WHERE tambahan jika ada
            $startDate,
            $endDate
        );

        // Load view dengan data yang difilter
        echo view('header',$data);
		echo view('menu',$data);
		echo view('laporantransaksi',$data);
		echo view('footer');
	} elseif(session()->get('level') == 2||session()->get('level') == 3) {
		return redirect()->to('Home/notfound');
	}else{
		return redirect()->to('home/login');
	}
    }

	public function transaksi_pdf()
	{
		if (session()->get('level') == 1) {
		$startDate = $this->request->getGet('start_date');
		$endDate = $this->request->getGet('end_date');
	
		if (!$startDate) {
			$startDate = '0000-00-00'; // Default start date
		}
		if (!$endDate) {
			$endDate = '9999-12-31'; // Default end date
		}
	
		// Load model and fetch data
		$model = new M_pesan();
		$data['satu'] = $model->groupbyjoin5where1(
			'keranjang', 
            'barang', 
            'transaksi', 
            'user', 
			'nota',
            'keranjang.id_barang = barang.id_barang', 
            'transaksi.kode_keranjang = keranjang.kode_keranjang', 
            'user.id_user = transaksi.create_by', 
			'transaksi.no_transaksi = nota.nomor_transaksi',
			$startDate,
			$endDate
		);
	
		$data['setting'] = $model->getwhere('setting', ['id_setting' => 1]);
		$data['startDate'] = $startDate;
    $data['endDate'] = $endDate;
		// Pass data to the view
		return view('transaksipdf', $data);
	} elseif(session()->get('level') == 2||session()->get('level') == 3) {
		return redirect()->to('Home/notfound');
	}else{
		return redirect()->to('home/login');
	}
	}

	public function transaksi_excel()
	{
		if (session()->get('level') == 1) {
		$startDate = $this->request->getGet('start_date');
		$endDate = $this->request->getGet('end_date');
	
		if (!$startDate) {
			$startDate = '0000-00-00'; // Default start date
		}
		if (!$endDate) {
			$endDate = '9999-12-31'; // Default end date
		}
	
		// Load model and fetch data
		$model = new M_pesan();
		$where1 = array('transaksi.status_transaksi' => 'Done');
		$data['satu'] = $model->groupbyjoin5where1(
			'keranjang', 
            'barang', 
            'transaksi', 
            'user', 
			'nota',
            'keranjang.id_barang = barang.id_barang', 
            'transaksi.kode_keranjang = keranjang.kode_keranjang', 
            'user.id_user = transaksi.create_by', 
			'transaksi.no_transaksi = nota.nomor_transaksi',
			$startDate,
			$endDate
		);
	
		$data['setting'] = $model->getwhere('setting', ['id_setting' => 1]);
		$data['startDate'] = $startDate;
    $data['endDate'] = $endDate;
		// Pass data to the view
		return view('transaksiexcel', $data);
	} elseif(session()->get('level') == 2||session()->get('level') == 3) {
		return redirect()->to('Home/notfound');
	}else{
		return redirect()->to('home/login');
	}
	}

	public function transaksi_windows()
	{
		if (session()->get('level') == 1) {
		$startDate = $this->request->getGet('start_date');
		$endDate = $this->request->getGet('end_date');
	
		if (!$startDate) {
			$startDate = '0000-00-00'; // Default start date
		}
		if (!$endDate) {
			$endDate = '9999-12-31'; // Default end date
		}
	
		// Load model and fetch data
		$model = new M_pesan();
		$where1 = array('transaksi.status_transaksi' => 'Done');
		$data['satu'] = $model->groupbyjoin5where1(
			'keranjang', 
            'barang', 
            'transaksi', 
            'user', 
			'nota',
            'keranjang.id_barang = barang.id_barang', 
            'transaksi.kode_keranjang = keranjang.kode_keranjang', 
            'user.id_user = transaksi.create_by', 
			'transaksi.no_transaksi = nota.nomor_transaksi',
			$startDate,
			$endDate
		);
	
		$data['setting'] = $model->getwhere('setting', ['id_setting' => 1]);
		$data['startDate'] = $startDate;
    $data['endDate'] = $endDate;
		// Pass data to the view
		return view('transaksiwindows', $data);
	} elseif(session()->get('level') == 2||session()->get('level') == 3) {
		return redirect()->to('Home/notfound');
	}else{
		return redirect()->to('home/login');
	}
	}


	public function filterTanggalbm()
    {
		if (session()->get('level') == 1) {
        // Ambil parameter tanggal dari query string
        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');

        // Set tanggal default jika tidak ada filter
        if (!$startDate) {
            $startDate = '0000-00-00'; // Atau tanggal default yang sesuai
        }
        if (!$endDate) {
            $endDate = '9999-12-31'; // Atau tanggal default yang sesuai
        }

        // Panggil model untuk mendapatkan data yang difilter
        $model = new M_pesan(); // Ganti dengan nama model Anda
		$where = array('id_user' => session()->get('id'));
		$data['dua'] = $model->getwhere('user', $where);
		$where1 = array('transaksi.status_transaksi' => 'Done');
		$where = array('id_setting' => 1);
		$data['setting'] = $model->getwhere('setting', $where);
        $data['satu'] = $model->filterbarang(
			'barang', 
            'barangmasuk', 
            'user', 
            'barang.id_barang = barangmasuk.id_barang', 
            'barang.create_by = user.id_user', 

			[],
			$startDate,
			$endDate
		);

        // Load view dengan data yang difilter
        echo view('header',$data);
		echo view('menu',$data);
		echo view('laporanbarangm',$data);
		echo view('footer');
	} elseif(session()->get('level') == 2||session()->get('level') == 3) {
		return redirect()->to('Home/notfound');
	}else{
		return redirect()->to('home/login');
	}
    }

public function laporanbarangmasuk(){
	if (session()->get('level') == 1) {
		$model = new M_pesan();
		$where = array('id_user' => session()->get('id'));
		$data['dua'] = $model->getwhere('user', $where);
		$where1 = array('barangmasuk.delete' => '0');
		$data['satu'] = $model->joinresult('barangmasuk','barang','barangmasuk.id_barang = barang.id_barang',$where1);
		$where = array('id_setting' => 1);
		$data['setting'] = $model->getwhere('setting', $where);
		echo view('header',$data);
		echo view('menu',$data);
		echo view('laporanbarangm',$data);
		echo view('footer');
	} elseif(session()->get('level') == 2||session()->get('level') == 3) {
		return redirect()->to('Home/notfound');
	}else{
		return redirect()->to('home/login');
	}
}

public function barangm_pdf()
	{
		if (session()->get('level') == 1) {
		$startDate = $this->request->getGet('start_date');
		$endDate = $this->request->getGet('end_date');
	
		if (!$startDate) {
			$startDate = '0000-00-00'; // Default start date
		}
		if (!$endDate) {
			$endDate = '9999-12-31'; // Default end date
		}
	
		// Load model and fetch data
		$model = new M_pesan();
		$data['satu'] = $model->filterbarang(
			'barang', 
            'barangmasuk', 
            'user', 
            'barang.id_barang = barangmasuk.id_barang', 
            'barang.create_by = user.id_user', 

			[],
			$startDate,
			$endDate
		);
	
		$data['setting'] = $model->getwhere('setting', ['id_setting' => 1]);
		$data['startDate'] = $startDate;
    $data['endDate'] = $endDate;
		// Pass data to the view
		return view('barangmpdf', $data);
	} elseif(session()->get('level') == 2||session()->get('level') == 3) {
		return redirect()->to('Home/notfound');
	}else{
		return redirect()->to('home/login');
	}
	}
public function barangm_excel()
	{
		if (session()->get('level') == 1) {
		$startDate = $this->request->getGet('start_date');
		$endDate = $this->request->getGet('end_date');
	
		if (!$startDate) {
			$startDate = '0000-00-00'; // Default start date
		}
		if (!$endDate) {
			$endDate = '9999-12-31'; // Default end date
		}
	
		// Load model and fetch data
		$model = new M_pesan();
		$data['satu'] = $model->filterbarang(
			'barang', 
            'barangmasuk', 
            'user', 
            'barang.id_barang = barangmasuk.id_barang', 
            'barang.create_by = user.id_user', 

			[],
			$startDate,
			$endDate
		);
	
		$data['setting'] = $model->getwhere('setting', ['id_setting' => 1]);
		$data['startDate'] = $startDate;
    $data['endDate'] = $endDate;
		// Pass data to the view
		return view('barangmexcel', $data);
	} elseif(session()->get('level') == 2||session()->get('level') == 3) {
		return redirect()->to('Home/notfound');
	}else{
		return redirect()->to('home/login');
	}
	}

	public function barangm_windows()
	{
		if (session()->get('level') == 1) {
		$startDate = $this->request->getGet('start_date');
		$endDate = $this->request->getGet('end_date');
	
		if (!$startDate) {
			$startDate = '0000-00-00'; // Default start date
		}
		if (!$endDate) {
			$endDate = '9999-12-31'; // Default end date
		}
	
		// Load model and fetch data
		$model = new M_pesan();
		$data['satu'] = $model->filterbarang(
			'barang', 
            'barangmasuk', 
            'user', 
            'barang.id_barang = barangmasuk.id_barang', 
            'barang.create_by = user.id_user', 

			[],
			$startDate,
			$endDate
		);
	
		$data['setting'] = $model->getwhere('setting', ['id_setting' => 1]);
		$data['startDate'] = $startDate;
    $data['endDate'] = $endDate;
		// Pass data to the view
		return view('barangmwindows', $data);
	} elseif(session()->get('level') == 2||session()->get('level') == 3) {
		return redirect()->to('Home/notfound');
	}else{
		return redirect()->to('home/login');
	}
	}





	public function filterTanggalbk()
    {
		if (session()->get('level') == 1) {
        // Ambil parameter tanggal dari query string
        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');

        // Set tanggal default jika tidak ada filter
        if (!$startDate) {
            $startDate = '0000-00-00'; // Atau tanggal default yang sesuai
        }
        if (!$endDate) {
            $endDate = '9999-12-31'; // Atau tanggal default yang sesuai
        }

        // Panggil model untuk mendapatkan data yang difilter
        $model = new M_pesan(); // Ganti dengan nama model Anda
		$where = array('id_user' => session()->get('id'));
		$data['dua'] = $model->getwhere('user', $where);
		$where1 = array('transaksi.status_transaksi' => 'Done');
		$where = array('id_setting' => 1);
		$data['setting'] = $model->getwhere('setting', $where);
        $data['satu'] = $model->filterbarangk(
			'barang', 
            'barangkeluar', 
            'user', 
            'barang.id_barang = barangkeluar.id_barang', 
            'barang.create_by = user.id_user', 

			[],
			$startDate,
			$endDate
		);

        // Load view dengan data yang difilter
        echo view('header',$data);
		echo view('menu',$data);
		echo view('laporanbarangk',$data);
		echo view('footer');
	} elseif(session()->get('level') == 2||session()->get('level') == 3) {
		return redirect()->to('Home/notfound');
	}else{
		return redirect()->to('home/login');
	}
    }

public function laporanbarangkeluar(){
	if (session()->get('level') == 1) {
		$model = new M_pesan();
		$where = array('id_user' => session()->get('id'));
		$data['dua'] = $model->getwhere('user', $where);
		$where1 = array('barangkeluar.delete' => '0');
		$data['satu'] = $model->joinresult('barangkeluar','barang','barangkeluar.id_barang = barang.id_barang',$where1);
		$where = array('id_setting' => 1);
		$data['setting'] = $model->getwhere('setting', $where);
		echo view('header',$data);
		echo view('menu',$data);
		echo view('laporanbarangk',$data);
		echo view('footer');
	} elseif(session()->get('level') == 2||session()->get('level') == 3) {
		return redirect()->to('Home/notfound');
	}else{
		return redirect()->to('home/login');
	}
}

public function barangk_pdf()
	{
		if (session()->get('level') == 1) {
		$startDate = $this->request->getGet('start_date');
		$endDate = $this->request->getGet('end_date');
	
		if (!$startDate) {
			$startDate = '0000-00-00'; // Default start date
		}
		if (!$endDate) {
			$endDate = '9999-12-31'; // Default end date
		}
	
		// Load model and fetch data
		$model = new M_pesan();
		$data['satu'] = $model->filterbarangk(
			'barang', 
            'barangkeluar', 
            'user', 
            'barang.id_barang = barangkeluar.id_barang', 
            'barang.create_by = user.id_user', 

			[],
			$startDate,
			$endDate
		);
	
		$data['setting'] = $model->getwhere('setting', ['id_setting' => 1]);
		$data['startDate'] = $startDate;
    $data['endDate'] = $endDate;
		// Pass data to the view
		return view('barangkpdf', $data);
	} elseif(session()->get('level') == 2||session()->get('level') == 3) {
		return redirect()->to('Home/notfound');
	}else{
		return redirect()->to('home/login');
	}
	}
public function barangk_excel()
	{
		if (session()->get('level') == 1) {
		$startDate = $this->request->getGet('start_date');
		$endDate = $this->request->getGet('end_date');
	
		if (!$startDate) {
			$startDate = '0000-00-00'; // Default start date
		}
		if (!$endDate) {
			$endDate = '9999-12-31'; // Default end date
		}
	
		// Load model and fetch data
		$model = new M_pesan();
		$data['satu'] = $model->filterbarangk(
			'barang', 
            'barangkeluar', 
            'user', 
            'barang.id_barang = barangkeluar.id_barang', 
            'barang.create_by = user.id_user', 

			[],
			$startDate,
			$endDate
		);
	
		$data['setting'] = $model->getwhere('setting', ['id_setting' => 1]);
		$data['startDate'] = $startDate;
    $data['endDate'] = $endDate;
		// Pass data to the view
		return view('barangkexcel', $data);
	} elseif(session()->get('level') == 2||session()->get('level') == 3) {
		return redirect()->to('Home/notfound');
	}else{
		return redirect()->to('home/login');
	}
	}

	public function barangk_windows()
	{
		if (session()->get('level') == 1) {
		$startDate = $this->request->getGet('start_date');
		$endDate = $this->request->getGet('end_date');
	
		if (!$startDate) {
			$startDate = '0000-00-00'; // Default start date
		}
		if (!$endDate) {
			$endDate = '9999-12-31'; // Default end date
		}
	
		// Load model and fetch data
		$model = new M_pesan();
		$data['satu'] = $model->filterbarangk(
			'barang', 
            'barangkeluar', 
            'user', 
            'barang.id_barang = barangkeluar.id_barang', 
            'barang.create_by = user.id_user', 

			[],
			$startDate,
			$endDate
		);
	
		$data['setting'] = $model->getwhere('setting', ['id_setting' => 1]);
		$data['startDate'] = $startDate;
    $data['endDate'] = $endDate;
		// Pass data to the view
		return view('barangkwindows', $data);
	} elseif(session()->get('level') == 2||session()->get('level') == 3) {
		return redirect()->to('Home/notfound');
	}else{
		return redirect()->to('home/login');
	}
	}
	public function datakeranjang(){
		if (session()->get('level') == 1) {
		$model = new M_pesan();
		$where = array('id_user' => session()->get('id'));
		$data['dua'] = $model->getwhere('user', $where);
		$where1 = array('keranjang.deletek' => '0');
		$data['satu'] = $model->groupbyabc1($where1);
		$data['tiga'] = $model->tampilwhere('keranjang',$where1);
		$where = array('id_setting' => 1);
		$data['setting'] = $model->getwhere('setting', $where);
		echo view('header',$data);
		echo view('menu',$data);
		echo view('datakeranjang',$data);
		echo view('footer');
		// print_r($data['satu']);
	} elseif(session()->get('level') == 2||session()->get('level') == 3) {
		return redirect()->to('Home/notfound');
	}else{
		return redirect()->to('home/login');
	}
	}

	public function rkeranjang(){
		if (session()->get('level') == 1) {
		$model = new M_pesan();
		$where = array('id_user' => session()->get('id'));
		$data['dua'] = $model->getwhere('user', $where);
		$where1 = array('keranjang.deletek' => '1');
		$data['satu'] = $model->groupbyabc($where1);
		$where = array('id_setting' => 1);
		$data['setting'] = $model->getwhere('setting', $where);
		echo view('header',$data);
		echo view('menu',$data);
		echo view('datakeranjang',$data);
		echo view('footer');
	} elseif(session()->get('level') == 2||session()->get('level') == 3) {
		return redirect()->to('Home/notfound');
	}else{
		return redirect()->to('home/login');
	}
	}
	public function hkeranjang($id)
	{
		$model = new M_pesan();
		$where = array('kode_keranjang' => $id);
		$model->hapus('keranjang', $where);

		return redirect()->to('Home/keranjang/'.session()->get('id'));
	}

public function hdatakeranjang($id)
	{
		$model = new M_pesan();
		$where = array('kode_keranjang' => $id);
		$model->hapus('keranjang', $where);

		return redirect()->to('Home/datakeranjang/');
	}

	public function sddatakeranjang($id)
	{
			$model = new M_pesan;
			$where = array('kode_keranjang' => $id);
			// Ubah status transaksi menjadi "habis" di kedua tabel
			$model->softdelete2('keranjang', 'deletek', '1', $where);
	
			// Kirim respons (jika diperlukan)
			return redirect()->to('home/datakeranjang/');
	}

	public function rsdatakeranjang($id){
		$model = new M_pesan;
		// Pass the where condition directly to the softdelete() function
		$where = array('kode_keranjang' => $id);
			// Ubah status transaksi menjadi "habis" di kedua tabel
		$model->softdelete2('keranjang', 'deletek', '0', $where);
		
		return redirect()->to('home/rkeranjang/');
	}

	public function sdkeranjang($id)
{
		$model = new M_pesan;
		$where = array('kode_keranjang' => $id);
		// Ubah status transaksi menjadi "habis" di kedua tabel
		$model->softdelete2('keranjang', 'deletek', '1', $where);

		// Kirim respons (jika diperlukan)
		return redirect()->to('home/keranjang/'.session()->get('id'));
}

public function rskeranjang($id){
	$model = new M_pesan;
	// Pass the where condition directly to the softdelete() function
	$where = array('kode_keranjang' => $id);
		// Ubah status transaksi menjadi "habis" di kedua tabel
	$model->softdelete2('keranjang', 'deletek', '0', $where);
	
	return redirect()->to('home/keranjang/'.session()->get('id'));
}
public function etransaksi($id){
		if (session()->get('level') == 1) {
		$model = new M_pesan();
		$where = array('id_user' => session()->get('id'));
		$data['dua'] = $model->getwhere('user', $where);
		$groupby = array('keranjang.kode_keranjang');
		$data['satu'] = $model->tampilgroupby('keranjang',$groupby);
		$where = array('id_transaksi' =>$id);
		$data['tiga'] = $model->joinrow('transaksi','nota','transaksi.no_transaksi = nota.nomor_transaksi',$where);
		$where = array('id_setting' => 1);
		$data['setting'] = $model->getwhere('setting', $where);
		echo view('header',$data);
		echo view('menu',$data);
		echo view('etransaksi',$data);
		echo view('footer');
	} elseif(session()->get('level') == 2||session()->get('level') == 3) {
		return redirect()->to('Home/notfound');
	}else{
		return redirect()->to('home/login');
	}
	}

	public function aksi_etransaksi(){
		$model = new M_pesan();
		
		$keranjang = $this->request->getPost('keranjang');
		$total = $this->request->getPost('total');
		$id = $this->request->getPost('id');
		$where = array('no_transaksi' =>$id);
		$where1 = array('nomor_transaksi' =>$id);

		$data = array(
			'kode_keranjang' => $keranjang,
			'deletet' => '0',
			'tanggal' => date('Y-m-d'),
			'update_at' => date('Y-m-d H:i:s'),
			'update_by' => session()->get('id'),
		);

		$data1 = array(
			'jumlah_transaksi' => $total,
			'delete' => '0',
			'tanggal_transaksi' => date('Y-m-d'),
			'update_at' => date('Y-m-d H:i:s'),
			'update_by' => session()->get('id'),
		);
		
		$model->edit('nota', $data1, $where1);
		$model->edit('transaksi', $data, $where);
		return redirect()->to('home/transaksi');
	}

	public function sdtransaksi($id)
	{
			$model = new M_pesan;
			$where = array('id_transaksi' => $id);
			// Ubah status transaksi menjadi "habis" di kedua tabel
			$model->softdelete2('transaksi', 'deletet', '1', $where);
	
			// Kirim respons (jika diperlukan)
			return redirect()->to('home/transaksi/');
	}

	public function rstransaksi($id)
	{
			$model = new M_pesan;
			$where = array('id_transaksi' => $id);
			// Ubah status transaksi menjadi "habis" di kedua tabel
			$model->softdelete2('transaksi', 'deletet', '0', $where);
	
			// Kirim respons (jika diperlukan)
			return redirect()->to('home/rtransaksi/');
	}

	public function htransaksi($id)
	{
		$model = new M_pesan();
		$where = array('id_keranjang' => $id);
		$model->hapus('transaksi', $where);

		return redirect()->to('Home/rtransaksi');
	}

	public function rtransaksi(){
		if (session()->get('level') == 1) {
		$model = new M_pesan();
		$where = array('id_user' => session()->get('id'));
		$data['dua'] = $model->getwhere('user', $where);
		$where1 = array('transaksi.deletet' => '1');
		$data['satu'] = $model->join('transaksi','nota','transaksi.no_transaksi = nota.nomor_transaksi',$where1);
		$where = array('id_setting' => 1);
		$data['setting'] = $model->getwhere('setting', $where);
		
		echo view('header',$data);
			echo view('menu',$data);
			echo view('transaksi',$data);
			echo view('footer');
	} elseif(session()->get('level') == 2||session()->get('level') == 3) {
		return redirect()->to('Home/notfound');
	}else{
		return redirect()->to('home/login');
	}
	}

	public function edit_transaksi($id){
		if (session()->get('level') == 1 || session()->get('level') == 3) {
			$model = new M_pesan();
			$where = array('id_user' => session()->get('id'));
			$data['dua'] = $model->getwhere('user', $where);
			$where1 = array('barang.delete' => '0');
			$where2 = array('barang.status' => 'tersedia');
			$data['satu'] = $model->tampilWhere2('barang',$where1,$where2);
			$where3 = array('keranjang.kode_keranjang' => $id);
			$data['tiga'] = $model->join('keranjang','barang','keranjang.id_barang = barang.id_barang', $where3);
			$where = array('id_setting' => 1);
			$data['setting'] = $model->getwhere('setting', $where);
			echo view('header',$data);
			echo view('menu',$data);
			echo view('epemesanan',$data);
			echo view('footer');
			// print_r($data3);
		} elseif(session()->get('level') == 2) {
			return redirect()->to('Home/notfound');
		}else{
			return redirect()->to('Home/login');
		}
	}

	public function delete_cart_item($id_keranjang)
{
    $model = new M_pesan();
    $where = array('id_Keranjang' => $id_keranjang);
    
    if ($model->hapus('keranjang', $where)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error']);
    }
}

public function ekeranjang($id){
	if (session()->get('level') == 1 || session()->get('level') == 3) {
		$model = new M_pesan();
		$where = array('id_user' => session()->get('id'));
		$data['dua'] = $model->getwhere('user', $where);
		$where1 = array('barang.delete' => '0');
		$where2 = array('barang.status' => 'tersedia');
		$data['satu'] = $model->tampilWhere2('barang',$where1,$where2);
		$where3 = array('keranjang.kode_keranjang' => $id);
		$data['tiga'] = $model->join('keranjang','barang','keranjang.id_barang = barang.id_barang', $where3);
		$where4 = array('kode_keranjang' => $id);
		$data['empat'] = $model->getWhere('transaksi',$where4);
		$where = array('id_setting' => 1);
		$data['setting'] = $model->getwhere('setting', $where);
		echo view('header',$data);
		echo view('menu',$data);
		echo view('ekeranjang',$data);
		echo view('footer');
		// print_r($data['tiga']);
	} elseif(session()->get('level') == 2) {
		return redirect()->to('Home/notfound');
	}else{
		return redirect()->to('Home/login');
	}
}

public function ekeranjangp($id){
	if (session()->get('level') == 1 || session()->get('level') == 3) {
		$model = new M_pesan();
		$where = array('id_user' => session()->get('id'));
		$data['dua'] = $model->getwhere('user', $where);
		$where1 = array('barang.delete' => '0');
		$where2 = array('barang.status' => 'tersedia');
		$data['satu'] = $model->tampilWhere2('barang',$where1,$where2);
		$where3 = array('keranjang.kode_keranjang' => $id);
		$data['tiga'] = $model->join('keranjang','barang','keranjang.id_barang = barang.id_barang', $where3);
		$where4 = array('kode_keranjang' => $id);
		$data['empat'] = $model->getWhere('keranjang',$where4);
		$where = array('id_setting' => 1);
		$data['setting'] = $model->getwhere('setting', $where);
		echo view('header',$data);
		echo view('menu',$data);
		echo view('ekeranjangp',$data);
		echo view('footer');
		// print_r($data['tiga']);
	} elseif(session()->get('level') == 2) {
		return redirect()->to('Home/notfound');
	}else{
		return redirect()->to('Home/login');
	}
}

public function updateCart($id) {
    $data = json_decode(file_get_contents('php://input'), true);
    $quantity = $data['quantity'];
    $kodeKeranjang = $data['kode_keranjang'];
    $itemId = $data['item_id'];
    $idBarang = $data['id_barang'];

    // Validate quantity
    if (!is_numeric($quantity) || $quantity < 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid quantity']);
        return;
    }

    $model = new M_pesan();
    
    // Retrieve the current cart item to get kode_keranjang and id_barang
    $cartItem = $model->finds('keranjang', ['id_Keranjang' => $id]);
    if (!$cartItem) {
        echo json_encode(['success' => false, 'message' => 'Cart item not found']);
        return;
    }


    // Perform the update in keranjang table
    $updateKeranjang = $model->edit('keranjang', ['quantity' => $quantity, 'update_at' => date('Y-m-d H:i:s')
		, 'update_by' => session()->get('id')], ['id_Keranjang' => $id]);

    // Perform the update in barang_keluar table
    $updateBarangKeluar = $model->edits('barangkeluar', ['jumlah' => $quantity, 'update_at' => date('Y-m-d H:i:s')
		, 'update_by' => session()->get('id')], ['kode_keranjang' => $kodeKeranjang, 'id_barang' => $idBarang]);

    if ($updateKeranjang && $updateBarangKeluar) {
        echo json_encode(['success' => true]);
    } else {
		
        echo json_encode(['success' => false, 'message' => 'Failed to update quantity']);
		
    }
}




public function removeCart($id) {
    // Decode JSON input
    $data = json_decode(file_get_contents('php://input'), true);
    $kodeKeranjang = $data['kode_keranjang'];
    $id_barang = $data['id_barang'];

    // Assuming M_pesan model and connection are set up correctly
    $model = new M_pesan();

    try {
        // Perform deletions
        $deleteFromKeranjang = $model->hapus('keranjang', ['id_Keranjang' => $id]);
        $deleteFromBarangKeluar = $model->hapus('barangkeluar', ['kode_Keranjang' => $kodeKeranjang, 'id_barang' => $id_barang]);

        // Respond with success
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        // Respond with error
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}
public function addItem2()
{
    try {
        // Get URL-encoded data from POST request
        $itemId = $this->request->getPost('item_id');
        $quantity = $this->request->getPost('quantity');
        $kodeKeranjang = $this->request->getPost('kode_keranjang'); // Retrieve kode_keranjang

        // Validate data
        if (!is_numeric($itemId) || !is_numeric($quantity) || $quantity < 1) {
            $errorMsg = 'Invalid data: itemId=' . $itemId . ', quantity=' . $quantity;
            error_log($errorMsg);
            return $this->response->setJSON(['success' => false, 'message' => $errorMsg]);
        }

        // Load model and perform database operations
        $model = new M_pesan();
        $cartItem = $model->finds('keranjang', ['id_barang' => $itemId, 'kode_keranjang' => $kodeKeranjang]); // Adjust query

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $quantity;
            $model->edits('keranjang', ['quantity' => $newQuantity, 'update_at' => date('Y-m-d H:i:s')
		, 'update_by' => session()->get('id')], ['id_Keranjang' => $cartItem->id_Keranjang]);

            // Update quantity in barang_keluar table
            $model->edits('barangkeluar', ['jumlah' => $newQuantity, 'update_at' => date('Y-m-d H:i:s')
		, 'update_by' => session()->get('id')], ['kode_keranjang' => $kodeKeranjang, 'id_barang' => $itemId]);
        } else {
            $model->inserts('keranjang', [
                'id_barang' => $itemId,
                'quantity' => $quantity,
                'id_user' => session()->get('id'),
                'kode_keranjang' => $kodeKeranjang, // Use kode_keranjang
                'create_at' => date('Y-m-d H:i:s'), // Correct date format
                'create_by' => session()->get('id'),
                'deletek' => '0',
				'status' => 'pending'
            ]);

            // Insert into barang_keluar table
           
        }

        // Respond with success
        return $this->response->setJSON(['success' => true]);

    } catch (\Exception $e) {
        $exceptionMsg = 'Exception: ' . $e->getMessage();
        error_log($exceptionMsg);
        return $this->response->setJSON(['success' => false, 'message' => $exceptionMsg]);
    }
}

public function addItem()
{
    try {
        // Get URL-encoded data from POST request
        $itemId = $this->request->getPost('item_id');
        $quantity = $this->request->getPost('quantity');
        $kodeKeranjang = $this->request->getPost('kode_keranjang'); // Retrieve kode_keranjang

        // Validate data
        if (!is_numeric($itemId) || !is_numeric($quantity) || $quantity < 1) {
            $errorMsg = 'Invalid data: itemId=' . $itemId . ', quantity=' . $quantity;
            error_log($errorMsg);
            return $this->response->setJSON(['success' => false, 'message' => $errorMsg]);
        }

        // Load model and perform database operations
        $model = new M_pesan();
        $cartItem = $model->finds('keranjang', ['id_barang' => $itemId, 'kode_keranjang' => $kodeKeranjang]); // Adjust query

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $quantity;
            $model->edits('keranjang', ['quantity' => $newQuantity, 'update_at' => date('Y-m-d H:i:s')
		, 'update_by' => session()->get('id')], ['id_Keranjang' => $cartItem->id_Keranjang]);

            // Update quantity in barang_keluar table
            $model->edits('barangkeluar', ['jumlah' => $newQuantity, 'update_at' => date('Y-m-d H:i:s')
		, 'update_by' => session()->get('id')], ['kode_keranjang' => $kodeKeranjang, 'id_barang' => $itemId]);
        } else {
            $model->inserts('keranjang', [
                'id_barang' => $itemId,
                'quantity' => $quantity,
                'id_user' => session()->get('id'),
                'kode_keranjang' => $kodeKeranjang, // Use kode_keranjang
                'create_at' => date('Y-m-d H:i:s'), // Correct date format
                'create_by' => session()->get('id'),
                'deletek' => '0',
				'status' => 'checkout'
            ]);

            // Insert into barang_keluar table
            $model->inserts('barangkeluar', [
                'id_barang' => $itemId,
                'jumlah' => $quantity,
                'kode_keranjang' => $kodeKeranjang,
                'create_at' => date('Y-m-d H:i:s'),
                'create_by' => session()->get('id'),
				'delete' => '0',
				'tanggal' => date('Y-m-d'),
            ]);
        }

        // Respond with success
        return $this->response->setJSON(['success' => true]);

    } catch (\Exception $e) {
        $exceptionMsg = 'Exception: ' . $e->getMessage();
        error_log($exceptionMsg);
        return $this->response->setJSON(['success' => false, 'message' => $exceptionMsg]);
    }
}


public function updateTotalPrice()
{
    try {
        $nomorTransaksi = $this->request->getPost('nomor_transaksi');
        $totalPrice = $this->request->getPost('total_price');

        // Debugging
        error_log('Received nomor_transaksi: ' . $nomorTransaksi);
        error_log('Received total_price: ' . $totalPrice);

        // Validate and sanitize data
        if (!is_numeric($totalPrice)) {
            $errorMsg = 'Invalid total price: ' . $totalPrice;
            error_log($errorMsg);
            return $this->response->setJSON(['success' => false, 'message' => $errorMsg]);
        }

        // Ensure totalPrice is a valid number
        $totalPrice = floatval($totalPrice);

        // Load model and perform database update
        $model = new M_pesan(); // Ensure model is correctly named and loaded
        $updateData = [
            'jumlah_transaksi' => $totalPrice,
            'update_at' => date('Y-m-d H:i:s'),
            'update_by' => session()->get('id')
        ];

        // Perform the update operation
        $result = $model->edits('nota', $updateData, ['nomor_transaksi' => $nomorTransaksi]);

        // Check if the totalPrice is zero
        if ($totalPrice == 0) {
            // Delete rows from nota and transaksi tables if totalPrice is 0
            $model->hapus('nota', ['nomor_transaksi' => $nomorTransaksi]);
            $model->hapus('transaksi', ['no_transaksi' => $nomorTransaksi]);
			
            return $this->response->setJSON(['success' => true, 'message' => 'Rows deleted due to zero total price']);
        }

        // Check if the update was successful
        if ($result) {
            return $this->response->setJSON(['success' => true]);
        } else {
            $errorMsg = 'Update failed for nomor_transaksi: ' . $nomorTransaksi;
            error_log($errorMsg);
            return $this->response->setJSON(['success' => false, 'message' => $errorMsg]);
        }

    } catch (\Exception $e) {
        $exceptionMsg = 'Exception: ' . $e->getMessage();
        error_log($exceptionMsg);
        return $this->response->setJSON(['success' => false, 'message' => $exceptionMsg]);
    }
}

public function pay($id) {
    try {
        if (session()->get('level') > 0) {
            $model = new M_pesan();
            
            // Get user data
            $where = ['id_user' => session()->get('id')];
            $data['dua'] = $model->getWhere('user', $where);
            $kkeranjang = $this->request->getPost('kode_keranjang');
			$where3 = array('keranjang.kode_keranjang' => $id);
			


			}
            $where = ['id_setting' => 1];
            $data['setting'] = $model->getWhere('setting', $where);
            
            
            $kodeKeranjang = session()->get('kode_keranjang');
            $data['satu'] = $model->groupbyjoinnwhere('keranjang', 'barang', 'barang.id_barang = keranjang.id_barang', $where3);
            
            // Pass kode_keranjang and id_user to view
            $data['kode_keranjang'] = $kodeKeranjang; // Ensure this is set
            $data['id_user'] = session()->get('id');   // Ensure this is set
            
            echo view('header', $data);
            echo view('menu', $data);
            echo view('bayar', $data);
            echo view('footer', $data);
    } catch (Exception $e) {
        log_message('error', 'An error occurred: ' . $e->getMessage());
        return $this->response->setJSON(['status' => 'error', 'message' => 'An error occurred while processing the payment.']);
    }
}
public function transaksi(){
		if (session()->get('level') == 1) {
		$model = new M_pesan();
		$where = array('id_user' => session()->get('id'));
		$data['dua'] = $model->getwhere('user', $where);
		$where1 = array('transaksi.deletet' => '0');
		$data['satu'] = $model->join('transaksi','nota','transaksi.no_transaksi = nota.nomor_transaksi',$where1);
		$where = array('id_setting' => 1);
		$data['setting'] = $model->getwhere('setting', $where);
		echo view('header',$data);
		echo view('menu',$data);
		echo view('transaksi',$data);
		echo view('footer');
	} elseif(session()->get('level') == 2||session()->get('level') == 3) {
		return redirect()->to('Home/notfound');
	}else{
		return redirect()->to('home/login');
	}
	}
public function detailuser($id){
		if (session()->get('level') == 1 ) {
			$model = new M_pesan();
			$where = array('id_user' => session()->get('id'));
			$data['dua'] = $model->getwhere('user', $where);
			$where = array('id_user' => $id);
			$data['satu'] = $model->getWhere('user',$where);
			$where = array('id_setting' => 1);
			$data['setting'] = $model->getwhere('setting', $where);
			echo view('header',$data);
			echo view('menu',$data);
			echo view('euser',$data);
			echo view('footer');
		} elseif(session()->get('level') == 2||session()->get('level') == 3) {
			return redirect()->to('Home/notfound');
		}else{
			return redirect()->to('home/login');
		}
	}
}
