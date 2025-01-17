<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <!-- Pastikan Anda memuat jQuery dan Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>

<div class="container mt-5">
    <h2>Data Master</h2>

    <!-- Navtabs untuk memisahkan bagian -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="dataBiayaTab" data-toggle="tab" href="#dataBiaya" role="tab" aria-controls="dataBiaya" aria-selected="true">Jenis Biaya</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="tableHargaBiayaTab" data-toggle="tab" href="#tableHargaBiaya" role="tab" aria-controls="tableHargaBiaya" aria-selected="false">Harga Biaya</a>
        </li>
    </ul>

    <!-- Konten Tab -->
    <div class="tab-content" id="myTabContent">
        <!-- Tab Data Jenis Biaya -->
        <div class="tab-pane fade show active" id="dataBiaya" role="tabpanel" aria-labelledby="dataBiayaTab">
            <button class="btn btn-primary mb-3 mt-3" id="btnTambahJenisBiaya">Tambah Jenis Biaya</button>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Jenis Biaya</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="jenisBiayaTable">
                    <!-- Data akan dimuat menggunakan AJAX -->
                </tbody>
            </table>
        </div>

        <!-- Tab Data Harga Biaya -->
        <div class="tab-pane fade" id="tableHargaBiaya" role="tabpanel" aria-labelledby="tableHargaBiayaTab">
            <button class="btn btn-primary mb-3 mt-3" id="btnTambahHargaBiaya">Tambah Harga Biaya</button>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tahun Pelajaran</th>
                        <th>Jenis Biaya</th>
                        <th>Harga Biaya</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="hargaBiayaTable">
                    <!-- Data akan dimuat menggunakan AJAX -->
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Modal untuk Menambah/Edit Jenis Biaya -->
<div id="modalJenisBiaya" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah/Edit Jenis Biaya</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">    
                <div class="form-group">
                    <label for="jenis_biaya">Jenis Biaya</label>
                    <input type="text" class="form-control" id="jenis_biaya" placeholder="Masukkan jenis biaya" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary saveJenisBiayaBtn">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Menambah/Edit Jenis Biaya -->
<div class="modal" id="modalHargaBiaya" tabindex=" -1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Tambah Harga Jenis Biaya</h5>

				<button type="button" class="close " data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-user">
					<form id="formHargaBiaya" action="#" method="post" enctype="multipart/form-data">
						<input type="hidden" class="form-control" id="id" name="id" value="">
						<div class="mb-1">
							<label for="tahun_pelajaran_id" class="form-label">Tahun Pelajaran</label>
							<select class="form-control" name="tahun_pelajaran_id" id="tahun_pelajaran_id">
								<option value="">- Pilih Tahun Pelajaran -</option>

							</select>
							<div class="error-block"></div>
						</div>


						<div class="mb-1">
							<label for="jenis_biaya_id" class="form-label">Nama Jenis Biaya</label>
							<select class="form-control" id="jenis_biaya_id" name="jenis_biaya_id">
								<option value="">- Pilih Jenis Biaya -</option>
							</select>
							<div class="error-block"></div>
						</div>
						<div class="mb-1">
							<label for="harga_biaya" class="form-label">Harga</label>
							<input type="text" class="form-control" name="harga_biaya" id="harga_biaya">

							<div class="error-block"></div>
						</div>


					</form>

					<div>

					</div>

				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary saveBtn" id="saveHargaBiaya">Simpan</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>

<script>
    $(document).ready(function() {
        // Memuat data jenis biaya
        loadJenisBiaya();
        tabelHargaBiaya();
        

        $('#tahun_pelajaran_id').load('<?php echo base_url('Data_biaya/getOptionTahunPelajaran'); ?>');
        $('#jenis_biaya_id').load('<?php echo base_url('Data_biaya/getOptionJenisBiayaAktif'); ?>');
        // Menambahkan jenis biaya baru
        $('#btnTambahJenisBiaya').click(function() {
            $('#jenis_biaya').val('');
            $('#modalJenisBiaya').data('action', 'add');
            $('#modalJenisBiaya').modal('show');
        });

        // Menyimpan atau mengedit jenis biaya
        $('.saveJenisBiayaBtn').click(function() {
            var action = $('#modalJenisBiaya').data('action');
            var jenisBiaya = $('#jenis_biaya').val();
            var jenisBiayaId = $('#jenis_biaya_id').val();

            if (jenisBiaya == "") {
                alert("Jenis Biaya tidak boleh kosong!");
                return;
            }

            var url, data;

            if (action === 'add') {
                url = 'data_biaya/saveJenisBiaya';
                data = { jenis_biaya: jenisBiaya };
            } else {
                url = 'data_biaya/editJenisBiaya';
                data = { id: jenisBiayaId, jenis_biaya: jenisBiaya };
            }

            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                success: function(response) {
                    $('#modalJenisBiaya').modal('hide');
                    loadJenisBiaya();
                }
            });
        });
    });

   // Memuat data jenis biaya ke dalam tabel
function loadJenisBiaya() {
    $.ajax({
        url: 'data_biaya/getAllJenisBiaya',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            var tableContent = '';
            var counter = 1; // Counter untuk ID berurutan
            $.each(response, function(i, item) {
                tableContent += `
                    <tr>
                        <td>${counter}</td> <!-- Menggunakan counter sebagai ID -->
                        <td>${item.jenis_biaya}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="editJenisBiaya(${item.id})">Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteJenisBiaya(${item.id})">Hapus</button>
                        </td>
                    </tr>
                `;
                counter++; // Increment counter untuk ID berikutnya
            });
            $('#jenisBiayaTable').html(tableContent);
        },
        error: function(xhr, status, error) {
            console.error('Error saat memuat data jenis biaya:', error);
        }
    });
}


    // Mengedit jenis biaya
    function editJenisBiaya(id) {
        $.ajax({
            url: 'data_biaya/getJenisBiayaById',
            type: 'GET',
            data: { id: id },
            dataType: 'json',
            success: function(response) {
                if (response) {
                    $('#jenis_biaya_id').val(response.id);
                    $('#jenis_biaya').val(response.jenis_biaya);
                    $('#modalJenisBiaya').data('action', 'edit');
                    $('#modalJenisBiaya').modal('show');
                }
            }
        });
    }

    // Menghapus jenis biaya
    function deleteJenisBiaya(id) {
        if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
            $.ajax({
                url: 'data_biaya/deleteJenisBiaya',
                type: 'POST',
                data: { id: id },
                success: function(response) {
                    loadJenisBiaya();
                }
            });
        }
    }


    $('#btnTambahHargaBiaya').on('click', function() {
		$('#modalHargaBiaya').modal('show');
	});

	function tabelHargaBiaya() {
		let tabel = $('#tableHargaBiaya');
		let tr = '';
		$.ajax({
			url: '<?php echo base_url('biaya/table_harga_biaya'); ?>',
			type: 'GET',

			dataType: 'json',
			success: function(response) {
				if (response.status) {
					tabel.find('tbody').html('');
					let no = 1;
					$.each(response.data, function(i, item) {
						tr = $('<tr>');

						tr.append('<td>' + no++ + '</td>');
						tr.append('<td>' + item.nama_tahun_pelajaran + '</td>');
						tr.append('<td>' + item.nama_jenis_biaya + '</td>');
						tr.append('<td>' + item.harga_biaya + '</td>');


						tr.append('<td>	<button class="btn btn-primary" onclick="editHargaBiaya(' + item.id + ')">Edit</button> <button class="btn btn-danger" onclick="deleteHargaBiaya(' + item.id + ')">Delete</button></td>');
						tabel.find('tbody').append(tr);
					});

				} else {
					tr = $('<tr>');
					tabel.find('tbody').html('');
					tr.append('<td colspan="4">' + response.message + '</td>');
				}
			}
		});
	}

    
    $('#saveHargaBiaya').on('click', function () {
    var id = $('#id').val();
    var tahun_pelajaran_id = $('#tahun_pelajaran_id').val();
    var jenis_biaya_id = $('#jenis_biaya_id').val();
    var harga_biaya = $('#harga_biaya').val();
    let url = '<?php echo base_url('Data_biaya/save_harga_biaya'); ?>';

    if (!tahun_pelajaran_id || !jenis_biaya_id || !harga_biaya) {
        alert('Semua bidang wajib diisi!');
        return;
    }

    $.ajax({
        url: url,
        type: 'POST',
        data: {
            id: id,
            tahun_pelajaran_id: tahun_pelajaran_id,
            jenis_biaya_id: jenis_biaya_id,
            harga_biaya: harga_biaya
        },
        dataType: 'json',
        success: function (response) {
            if (response.status) {
                alert(response.message);
                $('#modalHargaBiaya').modal('hide');
                tabelHargaBiaya(); // Refresh tabel setelah menyimpan data
            } else {
                alert(response.message);
            }
        }
    });
});

function tabelHargaBiaya() {
    let tabel = $('#tableHargaBiaya');
    let tr = '';
    $.ajax({
        url: '<?php echo base_url('Data_biaya/table_harga_biaya'); ?>',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.status) {
                tabel.find('tbody').html('');
                let no = 1;
                $.each(response.data, function (i, item) {
                    tr = $('<tr>');
                    tr.append('<td>' + no++ + '</td>');
                    tr.append('<td>' + item.nama_tahun_pelajaran + '</td>');
                    tr.append('<td>' + item.jenis_biaya + '</td>');
                    tr.append('<td>' + item.harga_biaya + '</td>');
                    tr.append(`
                        <td>
                            <button class="btn btn-primary" onclick="editHargaBiaya(${item.id})">Edit</button>
                            <button class="btn btn-danger" onclick="deleteHargaBiaya(${item.id})">Delete</button>
                        </td>
                    `);
                    tabel.find('tbody').append(tr);
                });
            } else {
                tr = $('<tr>');
                tabel.find('tbody').html('');
                tr.append('<td colspan="5">' + response.message + '</td>');
                tabel.find('tbody').append(tr);
            }
        }
    });
}

/* function loadTahunPelajaran() {
    let select = $('#tahun_pelajaran_id');
    select.html('<option value="">-- Pilih Tahun Pelajaran --</option>'); // Reset options
    $.ajax({
        url: '<?php echo base_url('Data_biaya/getOptionTahunPelajaran'); ?>',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.status) {
                $.each(response.data, function (i, item) {
                    select.append('<option value="' + item.id + '">' + item.nama_tahun_pelajaran + '</option>');
                });
            } else {
                alert(response.message);
            }
        }
    });
}
 */
$('#btnTambahHargaBiaya').on('click', function () {
    $('#id').val('');
    $('#jenis_biaya_id').val('');
    $('#harga_biaya').val('');
    loadTahunPelajaran(); // Load options ketika modal dibuka
    $('#modalHargaBiaya').modal('show');
});


	function editHargaBiaya(id) {
		$.ajax({
			url: '<?php echo base_url('Data_biaya/edit_harga_biaya'); ?>',
			type: 'post',
			data: {
				id: id,
			},
			dataType: 'json',
			success: function(response) {
				if (response.status) {
					$('#id').val(response.data.id);
					$('#tahun_pelajaran_id').val(response.data.tahun_pelajaran_id);
					$('#jenis_biaya_id').val(response.data.jenis_biaya_id);
					$('#harga_biaya').val(response.data.harga_biaya);
					$('#modalHargaBiaya').modal('show');
				} else {
					alert(response.message);
				}
			}
		});
	}

	function deleteHargaBiaya(id) {
		$.ajax({
			url: '<?php echo base_url('Data_biaya/delete_harga_biaya'); ?>',
			type: 'POST',
			data: {
				id: id,
			},
			dataType: 'json',
			success: function(response) {
				if (response.status) {
					alert(response.message);
					tabelHargaBiaya();
				} else {
					alert(response.message);
				}
			}
		})
	}
</script>

<!-- Tambahkan script untuk modal -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
