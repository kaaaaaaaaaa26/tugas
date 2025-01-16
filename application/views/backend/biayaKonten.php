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
            <a class="nav-link active" id="dataBiayaTab" data-toggle="tab" href="#dataBiaya" role="tab" aria-controls="dataBiaya" aria-selected="true">Data Jenis Biaya</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="dataSeragamTab" data-toggle="tab" href="#dataSeragam" role="tab" aria-controls="dataSeragam" aria-selected="false">Data Seragam</a>
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

        <!-- Tab Data Seragam (Contoh, Anda bisa menambahkannya nanti) -->
        <div class="tab-pane fade" id="dataSeragam" role="tabpanel" aria-labelledby="dataSeragamTab">
            <!-- Isi Konten Data Seragam bisa ditambahkan di sini -->
            <h3>harga biaya</h3>
            <p>Data terkait seragam akan ditampilkan di sini.</p>
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
                <input type="hidden" id="jenis_biaya_id" />
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

<script>
    $(document).ready(function() {
        // Memuat data jenis biaya
        loadJenisBiaya();

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
                $.each(response, function(i, item) {
                    tableContent += `
                        <tr>
                            <td>${item.id}</td>
                            <td>${item.jenis_biaya}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" onclick="editJenisBiaya(${item.id})">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="deleteJenisBiaya(${item.id})">Hapus</button>
                            </td>
                        </tr>
                    `;
                });
                $('#jenisBiayaTable').html(tableContent);
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
</script>

<!-- Tambahkan script untuk modal -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
