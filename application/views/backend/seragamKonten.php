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
    <h2>Data Seragam</h2>

    <!-- Navtabs untuk memisahkan bagian -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="dataJenisSeragamTab" data-toggle="tab" href="#dataJenisSeragam" role="tab" aria-controls="dataJenisSeragam" aria-selected="true">Data Jenis Seragam</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="dataStokSeragamTab" data-toggle="tab" href="#dataStokSeragam" role="tab" aria-controls="dataStokSeragam" aria-selected="false">Data Stok Seragam</a>
        </li>
    </ul>

    <!-- Konten Tab -->
    <div class="tab-content" id="myTabContent">
        <!-- Tab Data Jenis Seragam -->
        <div class="tab-pane fade show active" id="dataJenisSeragam" role="tabpanel" aria-labelledby="dataJenisSeragamTab">
            <button class="btn btn-primary mb-3 mt-3" id="btnTambahJenisSeragam">Tambah Jenis Seragam</button>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Jenis Seragam</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="jenisSeragamTable">
                    <!-- Data akan dimuat menggunakan AJAX -->
                </tbody>
            </table>
        </div>

        <!-- Tab Data Stok Seragam -->
        <div class="tab-pane fade" id="dataStokSeragam" role="tabpanel" aria-labelledby="dataStokSeragamTab">
            <!-- Isi Konten Data Stok Seragam -->
            <h3>Data Stok Seragam</h3>
            <p>Data terkait stok seragam akan ditampilkan di sini.</p>
        </div>
    </div>
</div>

<!-- Modal untuk Menambah/Edit Jenis Seragam -->
<div id="modalJenisSeragam" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah/Edit Jenis Seragam</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="jenis_seragam_id" />
                <div class="form-group">
                    <label for="jenis_seragam">Jenis Seragam</label>
                    <input type="text" class="form-control" id="jenis_seragam" placeholder="Masukkan jenis seragam" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary saveJenisSeragamBtn">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Memuat data jenis seragam
        loadJenisSeragam();

        // Menambahkan jenis seragam baru
        $('#btnTambahJenisSeragam').click(function() {
            $('#jenis_seragam').val('');
            $('#modalJenisSeragam').data('action', 'add');
            $('#modalJenisSeragam').modal('show');
        });

        // Menyimpan atau mengedit jenis seragam
        $('.saveJenisSeragamBtn').click(function() {
            var action = $('#modalJenisSeragam').data('action');
            var jenisSeragam = $('#jenis_seragam').val();
            var jenisSeragamId = $('#jenis_seragam_id').val();

            if (jenisSeragam == "") {
                alert("Jenis Seragam tidak boleh kosong!");
                return;
            }

            var url, data;

            if (action === 'add') {
                url = 'data_seragam/saveJenisSeragam';
                data = { jenis_seragam: jenisSeragam };
            } else {
                url = 'data_seragam/editJenisSeragam';
                data = { id: jenisSeragamId, jenis_seragam: jenisSeragam };
            }

            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                success: function(response) {
                    $('#modalJenisSeragam').modal('hide');
                    loadJenisSeragam();
                }
            });
        });
    });

    // Memuat data jenis seragam ke dalam tabel
    function loadJenisSeragam() {
        $.ajax({
            url: 'data_seragam/getAllJenisSeragam',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                var tableContent = '';
                $.each(response, function(i, item) {
                    tableContent += `
                        <tr>
                            <td>${item.id}</td>
                            <td>${item.jenis_seragam}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" onclick="editJenisSeragam(${item.id})">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="deleteJenisSeragam(${item.id})">Hapus</button>
                            </td>
                        </tr>
                    `;
                });
                $('#jenisSeragamTable').html(tableContent);
            }
        });
    }

    // Mengedit jenis seragam
    function editJenisSeragam(id) {
        $.ajax({
            url: 'data_seragam/getJenisSeragamById',
            type: 'GET',
            data: { id: id },
            dataType: 'json',
            success: function(response) {
                if (response) {
                    $('#jenis_seragam_id').val(response.id);
                    $('#jenis_seragam').val(response.jenis_seragam);
                    $('#modalJenisSeragam').data('action', 'edit');
                    $('#modalJenisSeragam').modal('show');
                }
            }
        });
    }

    // Menghapus jenis seragam
    function deleteJenisSeragam(id) {
        if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
            $.ajax({
                url: 'data_seragam/deleteJenisSeragam',
                type: 'POST',
                data: { id: id },
                success: function(response) {
                    loadJenisSeragam();
                }
            });
        }
    }
</script>

<!-- Tambahkan script untuk modal -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
