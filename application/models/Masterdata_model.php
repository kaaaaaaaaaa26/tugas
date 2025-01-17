<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Masterdata_model extends CI_Model     
{

	protected $tableTahunPelajaran = 'data_tahun_pelajaran';
	protected $tableKelas = 'data_kelas';
	protected $tableJurusan = 'data_jurusan';
	protected $tableBiaya = 'data_biaya';
	protected $tableHarga = 'harga_biaya';
	protected $tableJenisSeragam = 'jenis_seragam';
	protected $tableStokSeragam = 'stok_seragam';




	public function __construct()
	{
		parent::__construct();
	}


	public function getAllTahunPelajaran()
	{
		return  $this->db->get($this->tableTahunPelajaran);
	}

	public function getAllTahunPelajaranNotDeleted()
	{
		$this->db->where('deleted_at', 0);
		return  $this->db->get($this->tableTahunPelajaran);
	}

	public function getJenisBiayaAktif()
	{
		$this->db->where('deleted_at', 0);
		$this->db->where('status_jenis_biaya', 1);
		return $this->db->get($this->tableBiaya);
	}
	public function getTahunPelajaranByName($nama_tahun_pelajaran)
	{
		$this->db->where('nama_tahun_pelajaran', $nama_tahun_pelajaran);
		return $this->db->get($this->tableTahunPelajaran);
	}

	public function getTahunPelajaranByID($id)
	{
		$this->db->where('id', $id);
		return $this->db->get($this->tableTahunPelajaran);
	}

	public function cekTahunPelajaranDuplicate($nama_tahun_pelajaran, $id)
	{
		if ($id) {
			$this->db->where('id !=', $id);
		}
		$this->db->where('nama_tahun_pelajaran', $nama_tahun_pelajaran);
		return $this->db->get($this->tableTahunPelajaran);
	}

	public function  saveTahunPelajaran($data)
	{
		$this->db->insert($this->tableTahunPelajaran, $data);
		return $this->db->insert_id();
	}
	public function updateTahunPelajaran($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update($this->tableTahunPelajaran, $data);
		return $this->db->affected_rows();
	}

	public function deleteTahunPelajaran($id)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->tableTahunPelajaran);
		return $this->db->affected_rows();
	}



	public function getAllJurusan()
	{
		return $this->db->get($this->tableJurusan);
	}
	public function getAllJurusanNotDeleted()
	{
		$this->db->select($this->tableJurusan . '.*, ' . $this->tableTahunPelajaran . '.nama_tahun_pelajaran');
		$this->db->join($this->tableTahunPelajaran, $this->tableTahunPelajaran . '.id = ' . $this->tableJurusan . '.id_tahun_pelajaran');
		$this->db->where($this->tableJurusan . '.deleted_at', 0);
		return $this->db->get($this->tableJurusan);
	}

	public function getJurusanByID($id)
	{
		$this->db->where('id', $id);
		return $this->db->get($this->tableJurusan);
	}

	public function getJurusanByTahunPelajaranID($id)
	{
		$this->db->where('id_tahun_pelajaran', $id);
		return $this->db->get($this->tableJurusan);
	}

	public function cekJurusanDuplicate($nama_jurusan, $id_tahun_pelajaran, $id)
	{
		if ($id) {
			$this->db->where('id !=', $id);
		}
		$this->db->where('id_tahun_pelajaran =', $id_tahun_pelajaran);
		$this->db->where('nama_jurusan', $nama_jurusan);
		return $this->db->get($this->tableJurusan);
	}

	public function saveJurusan($data)
	{
		$this->db->insert($this->tableJurusan, $data);
		return $this->db->insert_id();
	}

	public function updateJurusan($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update($this->tableJurusan, $data);
		return $this->db->affected_rows();
	}

	public function deleteJurusan($id)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->tableJurusan);
		return $this->db->affected_rows();
	}

	# code...

	public function getAllKelas()
	{
		return $this->db->get($this->tableKelas);
	}
	public function getAllKelasNotDeleted()
	{
		$this->db->select($this->tableKelas . '.*, ' . $this->tableTahunPelajaran . '.nama_tahun_pelajaran, ' . $this->tableJurusan . '.nama_jurusan');
		$this->db->join($this->tableJurusan, $this->tableJurusan . '.id = ' . $this->tableKelas . '.id_jurusan');
		$this->db->join($this->tableTahunPelajaran, $this->tableTahunPelajaran . '.id = ' . $this->tableJurusan . '.id_tahun_pelajaran');
		$this->db->where($this->tableKelas . '.deleted_at', 0);
		return $this->db->get($this->tableKelas);
	}

	public function getKelasByID($id)
	{
		$this->db->select($this->tableKelas . '.*, ' . $this->tableTahunPelajaran . '.nama_tahun_pelajaran, ' . $this->tableJurusan . '.nama_jurusan, ' . $this->tableJurusan . '.id_tahun_pelajaran');
		$this->db->join($this->tableJurusan, $this->tableJurusan . '.id = ' . $this->tableKelas . '.id_jurusan', 'left');
		$this->db->join($this->tableTahunPelajaran, $this->tableTahunPelajaran . '.id = ' . $this->tableJurusan . '.id_tahun_pelajaran', 'left');
		$this->db->where($this->tableKelas . '.deleted_at', 0);
		$this->db->where($this->tableKelas . '.id', $id);
		return $this->db->get($this->tableKelas);
	}

	public function cekKelasDuplicate($nama_kelas,  $id_jurusan, $id)
	{
		if ($id) {
			$this->db->where('id !=', $id);
		}
		$this->db->where('id_jurusan', $id_jurusan);
		$this->db->where('nama_kelas', $nama_kelas);
		return $this->db->get($this->tableKelas);
	}

	public function saveKelas($data)
	{
		$this->db->insert($this->tableKelas, $data);
		return $this->db->insert_id();
	}

	public function updateKelas($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update($this->tableKelas, $data);
		return $this->db->affected_rows();
	}

	public function deleteKelas($id)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->tableKelas);
		return $this->db->affected_rows();
	}

    // Mengecek apakah jenis biaya sudah ada di database
    public function checkJenisBiayaExist($jenis_biaya)
    {
        $this->db->where('jenis_biaya', $jenis_biaya);
        $query = $this->db->get($this->tableBiaya);
        return $query->num_rows() > 0; // Mengembalikan true jika data ditemukan
    }

    // Mendapatkan semua data jenis biaya
    public function getAllJenisBiaya()
    {
        return $this->db->get($this->tableBiaya)->result_array();
    }

    // Menyimpan data jenis biaya
    public function saveJenisBiaya($jenis_biaya)
    {
        $data = ['jenis_biaya' => $jenis_biaya];
        $this->db->insert($this->tableBiaya, $data);
    }

    // Mengupdate data jenis biaya berdasarkan ID
    public function updateJenisBiaya($id, $jenis_biaya)
    {
        $this->db->where('id', $id);
        $this->db->update($this->tableBiaya, ['jenis_biaya' => $jenis_biaya]);

        if ($this->db->affected_rows() > 0) {
            return [
                'status' => true,
                'message' => 'Jenis Biaya berhasil diperbarui!'
            ];
        } else {
            return [
                'status' => false,
                'message' => 'Gagal memperbarui jenis biaya atau data tidak ada yang berubah!'
            ];
        }
    }

    // Menghapus jenis biaya berdasarkan ID
    public function deleteJenisBiaya($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->tableBiaya);
    }

    // Mendapatkan jenis biaya berdasarkan ID untuk di-edit
    public function getJenisBiayaById($id)
    {
        return $this->db->get_where($this->tableBiaya, ['id' => $id])->row();
    }

	

	public function getAllHargaBiaya()
	{
		$this->db->select($this->tableHarga . '.*, ' . $this->tableBiaya . '.jenis_biaya ,' . $this->tableTahunPelajaran . '.nama_tahun_pelajaran');
		$this->db->join($this->tableBiaya, $this->tableBiaya . '.id = ' . $this->tableHarga . '.jenis_biaya_id', 'left');
		$this->db->join($this->tableTahunPelajaran, $this->tableTahunPelajaran . '.id = ' . $this->tableHarga . '.tahun_pelajaran_id', 'left');
		$this->db->where($this->tableHarga . '.deleted_at', 0);
		return $this->db->get($this->tableHarga);
	}

	public function getHargaBiayaByID($id)
	{
		$this->db->where('id', $id);
		return $this->db->get($this->tableHarga);
	}

	public function saveHargaBiaya($data)
	{
		$this->db->insert($this->tableHarga, $data);
		return $this->db->insert_id();
	}

	public function updateHargaBiaya($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update($this->tableHarga, $data);
		return $this->db->affected_rows();
	}

	public function getHargaBiayaByTahunPelajaranID($id)
	{
		$this->db->where('id_tahun_pelajaran', $id);
		return $this->db->get($this->tableHarga);
	} 


	// CRUD for Jenis Seragam

	public function saveJenisSeragam($data)
	{
		$this->db->insert($this->tableJenisSeragam, $data);
		return $this->db->insert_id();
	}
	public function updateJenisSeragam($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update($this->tableJenisSeragam, $data);
		return $this->db->affected_rows();
	}

	public function deleteJenisSeragam($id)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->tableJenisSeragam);
		return $this->db->affected_rows();
	}
	public function getAllJenisSeragam()
	{
		return $this->db->get($this->tableJenisSeragam);
	}
	public function getJenisSeragamByID($id)
	{
		$this->db->where('id', $id);
		return $this->db->get($this->tableJenisSeragam);
	}
	public function CekDuplicateJenisSeragam($nama_jenis_seragam, $id = null)
{
    $this->db->where('nama_jenis_seragam', $nama_jenis_seragam);
    $this->db->where('deleted_at', 0);
    if ($id) {
        $this->db->where('id !=', $id);
    }
    $query = $this->db->get('jenis_seragam');
    return $query->num_rows() > 0;
}


	public function getAllStokSeragam()
	{
		$this->db->select('stok_seragam.*, jenis_seragam.nama_jenis_seragam, jenis_seragam_harga.nama_jenis_seragam AS nama_harga');
		$this->db->join('jenis_seragam', 'stok_seragam.jenis_seragam_id = jenis_seragam.id', 'left');
		$this->db->join('jenis_seragam AS jenis_seragam_harga', 'jenis_seragam_harga.id = stok_seragam.jenis_seragam_id', 'left');
		$this->db->where('stok_seragam.deleted_at', 0);
		return $this->db->get('stok_seragam');
	}
	
	public function getStokSeragamByID($id)
	{
		$this->db->where('id', $id);
		return $this->db->get($this->tableStokSeragam);
	}

	public function getStokSeragamByUnique($jenis_seragam_id, $ukuran_seragam)
	{
		return $this->db->get_where('stok_seragam', [
			'jenis_seragam_id' => $jenis_seragam_id,
			'ukuran_seragam' => $ukuran_seragam,
			'deleted_at' => 0
		])->row();
	}
	


	public function saveStokSeragam($data)
	{
		$this->db->insert($this->tableStokSeragam, $data);
		return $this->db->insert_id();
	}

	public function updateStokSeragam($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update($this->tableStokSeragam, $data);
		return $this->db->affected_rows();
	}

	public function deleteStokSeragam($id)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->tableStokSeragam);
		return $this->db->affected_rows();
	}

	
}

	

	


/* End of file Masterdata_model.php */