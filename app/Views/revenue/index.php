<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome to CodeIgniter 4!</title>
    <meta name="description" content="The small framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="/favicon.ico">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="<? base_url('assets/vendor/flatpickr/dist/flatpickr.min.css') ?>">

</head>

<body>
    <div class="mx-5 mt-5">

        <div class="row">
            <div class="col-md-12  ">
                <div class="mb-5 ">
                    <div class=" ">
                        <a class="btn btn-primary" href="/">
                            <i class="icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.25 12.2744L19.25 12.2744" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M10.2998 18.2988L4.2498 12.2748L10.2998 6.24976" stroke="currentColor"
                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </i>
                            Kembali ke Tabel Data</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="">
            <ul class="nav nav-tabs " id="custom-tabs-one-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-registrasi-tab" data-toggle="pill" href="#custom-tabs-one-registrasi" role="tab" aria-controls="custom-tabs-one-registrasi" aria-selected="false">List Data</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " id="custom-tabs-one-transaksi-tab" data-toggle="pill" href="#custom-tabs-one-transaksi" role="tab" aria-controls="custom-tabs-one-transaksi" aria-selected="true">Upload Data</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " id="custom-tabs-one-user-tab" data-toggle="pill" href="#custom-tabs-one-user" role="tab" aria-controls="custom-tabs-one-user" aria-selected="true">List User</a>
                </li>


            </ul>

        </div>
        <div class="tab-pane " id="custom-tabs-one-registrasi" role="tabpanel" aria-labelledby="custom-tabs-one-registrasi-tab">

            <div class=" mt-5">
                <table id="revenueTable" class="table table-bordered w-full">
                    <thead>
                        <tr>
                            <th rowspan="2">
                                <p>Region</p>
                            </th>
                            <th colspan="7">
                                <p style="text-align: center;">Revenue Category Average</p>
                            </th>

                        </tr>
                        <tr>
                            <th>Bla</th>
                            <th>Bron</th>
                            <th>Bron+</th>
                            <th>Sil</th>
                            <th>Gol</th>
                            <th>Pla</th>
                            <th>Dia</th>

                        </tr>

                    </thead>

                    <tbody>
                        <?php $Bla = 0;
                        $Bron = 0;
                        $Bron_plus = 0;
                        $Sil = 0;
                        $Gol = 0;
                        $Dia = 0;
                        $Pla = 0;
                        ?>
                        <?php foreach ($alldata as $key => $v) :  ?>
                            <?php $Bla += $v->Bla;
                            $Bron += $v->Bron;
                            $Bron_plus += $v->Bron_plus;
                            $Sil += $v->Sil;
                            $Gol += $v->Gol;
                            $Dia += $v->Dia;
                            $Pla += $v->Pla;
                            ?>
                            <tr>
                                <td><?= $v->regional ?></td>
                                <td><?= $v->Bla ?></td>
                                <td><?= $v->Bron ?></td>
                                <td><?= $v->Bron_plus ?></td>
                                <td><?= $v->Sil ?></td>
                                <td><?= $v->Gol ?></td>
                                <td><?= $v->Pla ?></td>
                                <td><?= $v->Dia ?></td>

                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td>Total</td>
                            <td><?= $Bla; ?></td>
                            <td><?= $Bron; ?></td>
                            <td><?= $Bron_plus; ?></td>
                            <td><?= $Sil; ?></td>
                            <td><?= $Gol; ?></td>
                            <td><?= $Pla; ?></td>
                            <td><?= $Dia; ?></td>
                        </tr>
                    </tbody>

                </table>
            </div>
            <div class="row mt-5">
                <div class="col-md-3">
                    <div class="form-group">
                        <form action="/revenue" id="myform" method="POST">
                            <!-- <label for="monthyear">Example select</label> -->
                            <select class="form-control" id="catrequest" name="catrequest">
                                <?php foreach ($filterdata as $key => $f): ?>
                                    <option value="<?= $f->category ?>" <?= $f->category == $params ? 'selected' : '' ?>><?= $f->category ?></option>
                                <?php endforeach; ?>
                            </select>
                        </form>
                    </div>
                </div>
            </div>
            <div class=" mt-5">
                <table id="revenueTable" class="table table-bordered w-full">
                    <thead>
                        <tr>
                            <th rowspan="2">
                                <p>Region</p>
                            </th>
                            <th colspan="3">
                                <p style="text-align: center;">NETWORK</p>
                            </th>
                            <th colspan="3">
                                <p style="text-align: center;">SALES</p>
                            </th>
                        </tr>
                        <tr>
                            <th>P1</th>
                            <th>P2</th>
                            <th>Non Program</th>
                            <th>P1</th>
                            <th>P2</th>
                            <th>Non Program</th>
                        </tr>

                    </thead>

                    <tbody>
                        <?php $total_P1 = 0;
                        $total_P2 = 0;
                        $total_Non_Program = 0;
                        $sales_P1 = 0;
                        $non_program_sales = 0; ?>
                        <?php foreach ($datas as $key => $value) :  ?>
                            <?php $total_P1 += $value->total_P1;
                            $total_P2 += $value->total_P2;
                            $total_Non_Program += $value->total_Non_Program;
                            $sales_P1 += $value->sales_P1;
                            $non_program_sales += $value->non_program_sales; ?>
                            <tr>
                                <td><?= $value->regional ?></td>
                                <td><?= $value->total_P1 ?></td>
                                <td><?= $value->total_P2 ?></td>
                                <td><?= $value->total_Non_Program ?></td>
                                <td><?= $value->sales_P1 ?></td>
                                <td><?= $value->total_P2 ?></td>
                                <td><?= $value->non_program_sales ?></td>

                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td>Total</td>
                            <td><?= $total_P1; ?></td>
                            <td><?= $total_P2; ?></td>
                            <td><?= $total_Non_Program; ?></td>
                            <td><?= $sales_P1; ?></td>
                            <td><?= $total_P2; ?></td>
                            <td><?= $non_program_sales; ?></td>
                        </tr>
                    </tbody>

                </table>
            </div>


        </div>
        <div class="tab-pane fade d-none" id="custom-tabs-one-transaksi" role="tabpanel" aria-labelledby="custom-tabs-one-transaksi-tab">
            <div class="card-body">
                <?php if (session()->getFlashdata('message')): ?>
                    <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('failed')): ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('failed') ?></div>
                <?php endif; ?>
                <div class=" ">

                    <form action="/revenue-import-excel" method="POST" enctype="multipart/form-data">
                        <!-- <form action="/send-email" method="POST" enctype="multipart/form-data"> -->
                        <div class="form-group row mb-2">
                            <div class="col-sm-2">
                                <label for="Upload File Dokumen " class="col-form-label"> Upload File Dokumen </label>
                            </div>
                            <div class="col-md-5 input-group mb-3">

                                <div class="custom-file">
                                    <input type="file" name="excel_file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                    <!-- <input type="file" name="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01"> -->
                                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="row d-flex">
                            <div class="col-md-6 d-flex">
                                <button class="btn btn-primary w-50" type="submit">Simpan</button>
                            </div>
                        </div>
                    </form>



                </div>
            </div>
        </div>
        <div class="tab-pane fade d-none" id="custom-tabs-one-user" role="tabpanel" aria-labelledby="custom-tabs-one-user-tab">
            <div class="container my-3 mt-5">
                <?php if (session()->getFlashdata('u_message')): ?>
                    <div class="alert alert-success"><?= session()->getFlashdata('u_message') ?></div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('u_failed')): ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('u_failed') ?></div>
                <?php endif; ?>
            </div>
            <div class="container my-3 mt-5">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                    Tambah Data
                </button>
            </div>
            <div class="container mt-5">
                <table id="documentTable" class="table table-striped w-full">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Employee</th>
                            <th>Email</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                </table>

            </div>
        </div>


    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Pegawai</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('/revenue/user-store') ?>" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="Nama-name" class="col-form-label">Nama :</label>
                            <input type="text" class="form-control required" name="nama" id="Nama-name">
                        </div>
                        <div class="form-group">
                            <label for="Email-name" class="col-form-label">Email :</label>
                            <input type="email" name="email" type="text" required class="form-control" id="Email-name">
                        </div>
                        <div class="form-group">
                            <label for="Role-name" class="col-form-label">Role :</label>
                            <select class="form-control" id="role" required name="role">
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Tabs content -->

    <!-- SCRIPTS -->
    <!-- Bootstrap 4 JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url('assets/vendor/flatpickr/dist/flatpickr.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/plugins/flatpickr.js') ?>" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        $(function() {
            $(".flatpickr_datetime").flatpickr({
                enableTime: false
            })
        })
    </script>
    <script>
        $(document).ready(function() {

            const button = document.getElementById('custom-tabs-one-registrasi-tab');
            button.click();
            $(document).on('click', '.nav-item', function() {
                toggleTabVisibility();
            });

            function toggleTabVisibility() {
                console.log('clicked');

                let elements = document.getElementsByClassName('tab-pane');

                for (let i = 0; i < elements.length; i++) {
                    let element = elements[i];

                    // Check if the element has the 'active' class
                    if (element.classList.contains('active')) {
                        // Show an action (like an alert)

                        // Remove the 'active' class
                        element.classList.remove('d-none');
                        element.classList.remove('fade');
                    } else {
                        element.classList.add('d-none');
                        element.classList.add('fade');
                    }
                }

            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#documentTable").css("width", "100%")

            let table = $('#documentTable').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 5,
                ajax: {
                    url: "<?= base_url('revenue/get-user') ?>",
                    type: "POST",
                },
                width: "100%",
                ordering: false,
                columns: [{
                        data: 'no',
                    },
                    {
                        data: 'nama'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'r'
                    }
                ],

            });
            // table.page.len(5).draw();

            function getUrlParameter(name) {
                let url = new URL(window.location.href);
                return url.searchParams.get(name);
            }

        });
    </script>
    <script>
        $(document).ready(function() {
            $(document).on("change", "#catrequest", function() {

                $(`#myform`).submit();
            });

            $.ajax({
                url: '<?= base_url("get-roles") ?>', // Sesuaikan dengan route controller
                type: 'POST',
                data: {
                    request: 'fetch'
                }, // Kirim data POST jika diperlukan
                dataType: 'json',
                success: function(data) {
                    console.log(data);

                    let select = $('#role');
                    select.empty(); // Hapus opsi lama
                    select.append('<option value="">Pilih Role</option>'); // Opsi default
                    $.each(data, function(key, value) {
                        select.append('<option value="' + value.id + '">' + value.nama_role + '</option>');
                    });
                }
            });
        });
    </script>

</body>

</html>