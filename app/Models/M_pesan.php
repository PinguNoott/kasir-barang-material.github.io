<?php

namespace App\Models;
use CodeIgniter\Model;

Class M_pesan extends Model
{
	public function tampil($s){
		return $this->db->table($s)
						->get()
						->getResult();

	}

    public function tampil2($s){
        return $this->db->table($s)
                        ->orderBy('jam_keluar', 'asc') // Mengurutkan berdasarkan kolom 'tanggal' secara ascending
                        ->get()
                        ->getResult();
    }
    

    public function tambah($table, $isi)
	{
			return $this->db->table($table)
						->insert($isi);
	}
    public function hapus($table, $where) {
        return $this->db->table($table)->delete($where);
    }
    public function edit($tabel, $isi, $where){
        return $this->db->table($tabel)
                        ->update($isi,$where);
    }
    public function getWhere($tabel,$where){
        return $this->db->table($tabel)
                        ->getwhere($where)
                        ->getRow();
    }
    public function tampilwhere2($tabel,$where, $where1){
        return $this->db->table($tabel)
                        ->where($where)
                        ->where($where1)
                        ->get()
                        ->getResult();
    }
    public function join($pil,$tabel1,$on,$where)
    {
        return $this->db->table($pil)
                        ->join($tabel1,$on,"right")
                        ->getWhere($where)->getResult();
                        // return $this->db->query('select * from brg_msk join barang on brg_msk.id_brg=barang.id_brg')
                        // ->getResult();
    }

    public function joinresult($pil,$tabel1,$on,$where)
    {
        return $this->db->table($pil)
                        ->join($tabel1,$on,"right")
                        ->getWhere($where)->getResult();
                        // return $this->db->query('select * from brg_msk join barang on brg_msk.id_brg=barang.id_brg')
                        // ->getResult();
    }

    public function simpantoken($email, $token) {
        $model = new M_pesan();
    
        $data = [
            'email' => $email,
            'token' => $token,
            'create_at' => date('Y-m-d H:i:s')
        ];
    
        $model->tambah('token',$data);
    }

    public function getEmailByToken($token)
    {
        $query = $this->db->table('token')->where('token', $token)->get();
        $result = $query->getRow();
        return $result ? $result->email : null;
    }

    public function updateUserStatus($email, $status)
    {
        $this->db->table('user')->where('email', $email)->update(['status' => $status]);
    }

    public function deleteToken($token)
    {
        $this->db->table('token')->where('token', $token)->delete();
    }

    public function softdelete1($table,$kolom, $noTrans)
{
    
    $this->db->table($table)->update(['delete' => '1'], [$kolom => $noTrans]);
   
}
public function softdelete2($table, $kolom, $noTrans, $where)
{
    $this->db->table($table)->update([$kolom => $noTrans], $where);
}

public function restore1($table,$kolom,$noTrans)
{
    
    $this->db->table($table)->update(['delete' => '0'], [$kolom => $noTrans]);
   
}

public function upload($file)
    {
            $imageName = $file->getName();
            $file->move(ROOTPATH . 'public/photo barang', $imageName);
    }
public function getNextCartCode() {
        // Fetch the latest cart code from the database
        $builder = $this->db->table('keranjang');
        $builder->selectMax('kode_keranjang');
        $query = $builder->get()->getRow();
    
        if ($query && $query->kode_keranjang) {
            // Extract the numeric part of the cart code and increment it
            $lastCode = $query->kode_keranjang;
            $lastNumber = (int) substr($lastCode, 4); // Extract number after 'CPP-'
            return $lastNumber + 1;
        } else {
            return 1; // Start with 1 if no previous code exists
        }
    }

    public function add_to_cart($data) {
        // Add the data to the keranjang table
        $builder = $this->db->table('keranjang');
        return $builder->insert($data);
    }

public function groupbyjoinn($table1, $table2, $onCondition)
    {
        $builder = $this->db->table($table1);
        $builder->select('keranjang.*,barang.*, SUM(keranjang.quantity * barang.harga_jual) as total_harga');
        $builder->join($table2, $onCondition, 'left');
        $builder->groupBy('keranjang.kode_keranjang');
        $builder->orderby('keranjang.create_at','DESC');
        return $builder->get()->getResult();
    }

    public function groupbyjoinn2($table1, $table2, $table3, $onCondition, $onCondition2, $where, $where1)
    {
        $builder = $this->db->table($table1);
        $builder->select('keranjang.*,barang.*, transaksi.*, SUM(keranjang.quantity * barang.harga_jual) as total_harga');
        $builder->join($table2, $onCondition, 'left');
        $builder->join($table3, $onCondition2, 'left');
        $builder->where($where);
        $builder->orWhere($where1);
        $builder->groupBy('keranjang.kode_keranjang');
        $builder->orderby('keranjang.create_at','DESC');
        return $builder->get()->getResult();
    }

    public function groupbyjoinwhere($table1, $table2, $onCondition, $where)
    {
        $builder = $this->db->table($table1);
        $builder->select('keranjang.kode_keranjang, keranjang.status,SUM(keranjang.quantity * barang.harga_jual) as total_harga');
        $builder->join($table2, $onCondition, 'left');
        $builder->where($where);
        $builder->groupBy('keranjang.kode_keranjang');
        $builder->orderby('keranjang.create_at','DESC');
        return $builder->get()->getResult();
    }

    public function groupbyjoinnwhere($table1, $table2, $onCondition, $where)
{
    $builder = $this->db->table($table1);
    $builder->select('keranjang.kode_keranjang, barang.nama_barang, keranjang.quantity, barang.harga_jual, barang.id_barang');
    $builder->join($table2, $onCondition, 'left');
    $builder->where($where);
    $builder->orderBy('keranjang.create_at', 'DESC');
    return $builder->get()->getResult();
}

public function groupbyjoinnwhere1select($table1, $table2, $onCondition, $where)
{
    $builder = $this->db->table($table1);
    $builder->select('barang.id_barang');
    $builder->join($table2, $onCondition, 'left');
    $builder->where($where);
    $builder->orderBy('keranjang.create_at', 'DESC');
    return $builder->get()->getResult();
}

public function groupbyjoinnwhere3($where, $where2, $where3)
{
    $builder = $this->db->table('transaksi');
    $builder->select('keranjang.*,barang.*,transaksi.*'); // Select unique cart code and any aggregate data
    $builder->join('keranjang', 'transaksi.kode_keranjang = keranjang.kode_keranjang', 'left');
    $builder->join('barang', 'keranjang.id_barang = barang.id_barang', 'left');
    $builder->where($where);
    
    // Start a new group for OR conditions
    $builder->groupStart();
    $builder->where($where2);
    $builder->orWhere($where3);
    $builder->groupEnd();
    
    $builder->groupBy('keranjang.kode_keranjang');
    $builder->orderBy('keranjang.create_at', 'DESC'); // Use the alias 'create_at'
    
    return $builder->get()->getResult();
}

public function join2where3($where, $where2, $where3){
    $builder = $this->db->table('transaksi');
    $builder->select('keranjang.*, transaksi.*, barang.*'); // Pilih kolom yang diinginkan
    $builder->join('keranjang', 'transaksi.kode_keranjang = keranjang.kode_keranjang', 'left');
    $builder->join('barang', 'keranjang.id_barang = barang.id_barang', 'left');
    $builder->where($where);
    $builder->where($where2);
    $builder->orWhere($where3);
    $builder->groupBy('transaksi.kode_keranjang'); // Mengelompokkan berdasarkan kode_keranjang
    
    $query = $builder->get();
    $result = $query->getResult();
    

}

public function groupbyjoinnwhere2($where2, $where3)
{
    $builder = $this->db->table('transaksi');
    $builder->join('keranjang', 'transaksi.kode_keranjang=keranjang.kode_keranjang', 'left');
    $builder->join('barang', 'keranjang.id_barang=barang.id_barang', 'left');
    
    // Start a new group for OR conditions
    $builder->groupStart();
    $builder->where($where2);
    $builder->orWhere($where3);
    $builder->groupEnd();
    $builder->groupBy('keranjang.kode_keranjang');
    $builder->orderBy('transaksi.create_at', 'DESC');
    return $builder->get()->getResult();
}

public function groupbyjoinnwhere22($where2, $where3)
{
    $builder = $this->db->table('transaksi');
    $builder->join('keranjang', 'transaksi.kode_keranjang=keranjang.kode_keranjang', 'left');
    $builder->join('barang', 'keranjang.id_barang=barang.id_barang', 'left');
    
    // Start a new group for OR conditions
    $builder->groupStart();
    $builder->where($where2);
    $builder->Where($where3);
    $builder->groupEnd();
    $builder->groupBy('keranjang.kode_keranjang');
    $builder->orderBy('transaksi.create_at', 'DESC');
    return $builder->get()->getResult();
}

public function groupbyjoinnwhere1($where, $where2)
{
    $builder = $this->db->table('transaksi');
    $builder->join('keranjang', 'transaksi.kode_keranjang=keranjang.kode_keranjang', 'left');
    $builder->join('barang', 'keranjang.id_barang=barang.id_barang', 'left');
    $builder->where($where);
    
    // Start a new group for OR conditions
    $builder->groupStart();
    $builder->where($where2);
    $builder->groupEnd();
    
    $builder->orderBy('transaksi.create_at', 'DESC');
    return $builder->get()->getResult();
}

public function groupbyjoin3where1($where, $where2)
{
    $builder = $this->db->table('keranjang');
    $builder->select('keranjang.*, barang.*, 
                      SUM(keranjang.quantity * barang.harga_jual) as total_harga');
    $builder->join('barang', 'keranjang.id_barang = barang.id_barang', 'left');
    $builder->where($where);
    $builder->where($where2);
    $builder->groupBy('keranjang.kode_keranjang'); // Hanya kelompokkan berdasarkan kode_keranjang
    $builder->orderBy('keranjang.create_at', 'DESC');
    return $builder->get()->getResult();
}

public function groupbyjoin3where($where)
{
    $builder = $this->db->table('keranjang');
    $builder->select('keranjang.*, barang.*, 
                      SUM(keranjang.quantity * barang.harga_jual) as total_harga');
    $builder->join('barang', 'keranjang.id_barang = barang.id_barang', 'left');
    $builder->where($where);
    $builder->groupBy('keranjang.kode_keranjang'); // Hanya kelompokkan berdasarkan kode_keranjang
    $builder->orderBy('keranjang.create_at', 'DESC');
    return $builder->get()->getResult();
}
public function statuskeranjang($table,$kolom,$noTrans)
{
    
    $this->db->table($table)->update(['status' => 'checkout'], [$kolom => $noTrans]);
   
}

public function getLastTransaction()
{
    $builder = $this->db->table('transaksi');
    $builder->select('no_transaksi');
    $builder->orderBy('no_transaksi', 'DESC');
    $builder->limit(1);
    
    return $builder->get()->getRow();
}

public function joinresult2($tabel,$tabel1,$on,$tabel2,$on2,$where)
    {
        return $this->db->table($tabel)
                        ->join($tabel1,$on,"right")
                        ->join($tabel2,$on2,"right")
                        ->getWhere($where)->getResult();
                        // return $this->db->query('select * from brg_msk join barang on brg_msk.id_brg=barang.id_brg')
                        // ->getResult();
    }
    public function getPassword($userId) {
    return $this->db->table('user')
                    ->select('password')
                    ->where('id_user', $userId)
                    ->get()
                    ->getRow()
                    ->password;
}
public function groupbyjoin2where1($table1, $table2, $table3, $table4, $onCondition, $onCondition2, $onCondition3, $where, $startDate = null, $endDate = null)
{
    $builder = $this->db->table($table1);
    $builder->select('keranjang.*, barang.*, transaksi.*, user.username, user.id_user, SUM(keranjang.quantity * barang.harga_jual) as total_harga');
    $builder->join($table2, $onCondition, 'left');
    $builder->join($table3, $onCondition2, 'left');
    $builder->join($table4, $onCondition3, 'left');

    // Apply existing WHERE conditions
    if ($where) {
        $builder->where($where);
    }

    // Apply date filters if provided
    if ($startDate) {
        $builder->where('transaksi.tanggal >=', $startDate);
    }
    if ($endDate) {
        $builder->where('transaksi.tanggal <=', $endDate);
    }

    $builder->groupBy('keranjang.kode_keranjang');
    $builder->orderBy('keranjang.create_at', 'ASC');
    return $builder->get()->getResult();
}

public function filterbarang($table1, $table2, $table3,$onCondition, $onCondition2, $where, $startDate = null, $endDate = null)
{
    $builder = $this->db->table($table1);
    $builder->select('barang.*, barangmasuk.*, user.username, user.id_user');
    $builder->join($table2, $onCondition, 'left');
    $builder->join($table3, $onCondition2, 'left');

    // Apply existing WHERE conditions
    if ($where) {
        $builder->where($where);
    }

    // Apply date filters if provided
    if ($startDate) {
        $builder->where('barangmasuk.tanggal >=', $startDate);
    }
    if ($endDate) {
        $builder->where('barangmasuk.tanggal <=', $endDate);
    }

    $builder->orderBy('barangmasuk.tanggal', 'ASC');
    return $builder->get()->getResult();
}

public function filterbarangk($table1, $table2, $table3,$onCondition, $onCondition2, $where, $startDate = null, $endDate = null)
{
    $builder = $this->db->table($table1);
    $builder->select('barang.*, barangkeluar.*, user.username, user.id_user');
    $builder->join($table2, $onCondition, 'left');
    $builder->join($table3, $onCondition2, 'left');

    // Apply existing WHERE conditions
    if ($where) {
        $builder->where($where);
    }

    // Apply date filters if provided
    if ($startDate) {
        $builder->where('barangkeluar.tanggal >=', $startDate);
    }
    if ($endDate) {
        $builder->where('barangkeluar.tanggal <=', $endDate);
    }

    $builder->orderBy('barangkeluar.tanggal', 'ASC');
    return $builder->get()->getResult();
}
public function groupbyabc($where)
{
    $builder = $this->db->table('keranjang');
    $builder->select('keranjang.*, barang.*, user.*, 
                      SUM(keranjang.quantity * barang.harga_jual) as total_harga');
    $builder->join('barang', 'keranjang.id_barang = barang.id_barang', 'left');
    $builder->join('user', 'keranjang.id_user = user.id_user', 'left');
    $builder->where($where);
    $builder->groupBy('keranjang.kode_keranjang'); // Hanya kelompokkan berdasarkan kode_keranjang
    $builder->orderBy('keranjang.create_at', 'DESC');
    return $builder->get()->getResult();
}
public function groupbyabc1($where)
{
    $builder = $this->db->table('keranjang');
    $builder->select('keranjang.*, barang.harga_jual, 
                      SUM(keranjang.quantity * barang.harga_jual) as total_harga');
    $builder->join('barang', 'keranjang.id_barang = barang.id_barang', 'left');
    $builder->where($where);
    $builder->groupBy('keranjang.kode_keranjang'); // Hanya kelompokkan berdasarkan kode_keranjang
    $builder->orderBy('keranjang.create_at', 'DESC');
    return $builder->get()->getResult();
}

 public function finds($table, $conditions)
    {
        return $this->db->table($table)
                        ->where($conditions)
                        ->get()
                        ->getRow();
    }

    public function inserts($table, $data)
    {
        return $this->db->table($table)
                        ->insert($data);
    }

    public function edits($table, $data, $conditions) {
        return $this->db->table($table)
                        ->update($data, $conditions);
    }
    public function groupbyjoin4where0($table1, $table2, $table3, $table4, $table5,$onCondition, $onCondition2, $onCondition3, $onCondition4, $startDate = null, $endDate = null)
{
    $builder = $this->db->table($table1);
    $builder->select('keranjang.*, barang.*, transaksi.*, nota.*, user.username, user.id_user, SUM(keranjang.quantity * barang.harga_jual) as total_harga');
    $builder->join($table2, $onCondition, 'inner');
    $builder->join($table3, $onCondition2, 'inner');
    $builder->join($table4, $onCondition3, 'inner');
    $builder->join($table5, $onCondition4, 'inner');

    // Apply existing WHERE conditions


    // Apply date filters if provided
    if ($startDate) {
        $builder->where('transaksi.tanggal >=', $startDate);
    }
    if ($endDate) {
        $builder->where('transaksi.tanggal <=', $endDate);
    }

    $builder->groupBy('keranjang.kode_keranjang');
    $builder->orderBy('keranjang.create_at', 'ASC');
    return $builder->get()->getResult();
}
public function groupbyjoin4where1($table1, $table2, $table3, $table4, $table5, $onCondition, $onCondition2, $onCondition3, $onCondition5, $where, $startDate = null, $endDate = null)
{
    $builder = $this->db->table($table1);
    $builder->select('keranjang.*, barang.*, transaksi.*, nota.*,user.username, user.id_user, SUM(keranjang.quantity * barang.harga_jual) as total_harga');
    $builder->join($table2, $onCondition, 'left');
    $builder->join($table3, $onCondition2, 'left');
    $builder->join($table4, $onCondition3, 'left');
    $builder->join($table5, $onCondition5, 'left');

    // Apply existing WHERE conditions
    if ($where) {
        $builder->where($where);
    }

    // Apply date filters if provided
    if ($startDate) {
        $builder->where('transaksi.tanggal >=', $startDate);
    }
    if ($endDate) {
        $builder->where('transaksi.tanggal <=', $endDate);
    }

    $builder->groupBy('keranjang.kode_keranjang');
    $builder->orderBy('keranjang.create_at', 'ASC');
    return $builder->get()->getResult();
}
public function groupbyjoin5where1($table1, $table2, $table3, $table4, $table5, $onCondition, $onCondition2, $onCondition3, $onCondition4, $startDate = null, $endDate = null)
{
    $builder = $this->db->table($table1);
    $builder->select('keranjang.*, barang.*, transaksi.*, nota.*,user.username, user.id_user, SUM(keranjang.quantity * barang.harga_jual) as total_harga');
    $builder->join($table2, $onCondition, 'left');
    $builder->join($table3, $onCondition2, 'left');
    $builder->join($table4, $onCondition3, 'left');
    $builder->join($table5, $onCondition4, 'left');



    // Apply date filters if provided
    if ($startDate) {
        $builder->where('transaksi.tanggal >=', $startDate);
    }
    if ($endDate) {
        $builder->where('transaksi.tanggal <=', $endDate);
    }

    $builder->groupBy('keranjang.kode_keranjang');
    $builder->orderBy('keranjang.create_at', 'ASC');
    return $builder->get()->getResult();
}
public function tampilwhere($tabel,$where){
        return $this->db->table($tabel)
                        ->getwhere($where)
                        ->getResult();
    }

    public function joinnowhere($pil,$tabel1,$on)
    {
        return $this->db->table($pil)
                        ->join($tabel1,$on,"right")
                        ->get()
                        ->getResult();
    }
    public function joinrow($pil,$tabel1,$on,$where)
    {
        return $this->db->table($pil)
                        ->join($tabel1,$on,"right")
                        ->getWhere($where)->getRow();
                        // return $this->db->query('select * from brg_msk join barang on brg_msk.id_brg=barang.id_brg')
                        // ->getResult();
    }
    public function tampilgroupby($s,$groupby){
        return $this->db->table($s)
                        ->groupBy($groupby)
                        ->get()
                        ->getResult();

    }
public function delete_item($table,$id_keranjang)
{
    return $this->table($table)->where('id_Keranjang', $id_keranjang)->delete();
}
public function resetpassword($table,$kolom,$id,$data)
{
    
    $this->db->table($table)->where($kolom, $id)->update($data);
   
}

}