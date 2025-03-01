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

</head>

<body>

    <div class="container mt-5">
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
    </div>
    <div class="container">
        <ul class="nav nav-tabs mt-5" id="custom-tabs-one-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link" id="custom-tabs-one-registrasi-tab" data-toggle="pill" href="#custom-tabs-one-registrasi" role="tab" aria-controls="custom-tabs-one-registrasi" aria-selected="false">Upload others document</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " id="custom-tabs-one-transaksi-tab" data-toggle="pill" href="#custom-tabs-one-transaksi" role="tab" aria-controls="custom-tabs-one-transaksi" aria-selected="true">List Other Document</a>
            </li>
        </ul>

    </div>
    <div class="tab-pane " id="custom-tabs-one-registrasi" role="tabpanel" aria-labelledby="custom-tabs-one-registrasi-tab">

        <div class="container">
            <div class="card-body">
                <?php if (session()->getFlashdata('message')): ?>
                    <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('failed')): ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('failed') ?></div>
                <?php endif; ?>
                <form action="/documents/store" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="form-group row mb-2">
                        <div class="col-sm-2">
                            <label for="Nama Dokumen " class="col-form-label"> Nama Dokumen </label>
                        </div>

                        <div class="col-md-5  input-group">
                            <input type="text" class="form-control " value="" id="doc_name" name="doc_name" placeholder="">
                        </div>
                        <br>
                    </div>
                    <div class="form-group row mb-2">
                        <div class="col-sm-2">
                            <label for="Upload File Dokumen " class="col-form-label"> Upload File Dokumen </label>
                        </div>
                        <div class="col-md-5 input-group mb-3">
                            <!-- <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                            </div>  -->
                            <div class="custom-file">
                                <input type="file" name="documents" class="custom-file-input form-control-file" id="inputGroupFile02" aria-describedby="inputGroupFileAddon02">
                                <label class="custom-file-label" for="inputGroupFile02">Choose file</label>
                            </div>
                            <!-- <div class="input-group-append">
                                <span class="input-group-text" id="inputGroupFileAddon02">Upload</span>
                            </div> -->
                        </div>

                    </div>
                    <!-- <div class="input-group mb-3">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="inputGroupFile02">
                            <label class="custom-file-label" for="inputGroupFile02" aria-describedby="inputGroupFileAddon02">Choose file</label>
                        </div>
                        <div class="input-group-append">
                            <span class="input-group-text" id="inputGroupFileAddon02">Upload</span>
                        </div>
                    </div> -->
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
    <div class="tab-pane fade d-none" id="custom-tabs-one-transaksi" role="tabpanel" aria-labelledby="custom-tabs-one-transaksi-tab">

        <div class="container mt-5">
            <!-- disini tabel nya -->
            <?php //view('components/table', ['datas' => $data]) 
            ?>
            <!-- <table id="documentTable" class="display"> -->
            <table id="documentTable" class="table table-striped w-full">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Dokumen</th>
                        <th>File</th>
                    </tr>
                </thead>
            </table>

            <!-- <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Dokumen</th>
                        <th scope="col">Tanggal Upload</th>
                    </tr>
                </thead>
                <tbody>
                    <?php //foreach ($datas as $key => $data): 
                    ?>
                        <tr>
                            <th scope="row"><?php // $key + 1 
                                            ?></th>
                            <td> <a href="<?php // base_url("download-document/" . $data['id']) 
                                            ?>"><?php // $data['doc_name'] 
                                                ?></a></td>
                            <td><?php // $data['idt'] 
                                ?></td>
                        </tr>
                    <?php // endforeach; 
                    ?>


                </tbody>
            </table> -->
        </div>
    </div>
    <div class="tab-pane fade d-none" id="custom-tabs-one-laporan" role="tabpanel" aria-labelledby="custom-tabs-one-laporan-tab">

        <!-- <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">First</th>
                    <th scope="col">Last</th>
                    <th scope="col">Handle</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>@fat</td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>Larry</td>
                    <td>the Bird</td>
                    <td>@twitter</td>
                </tr>
            </tbody>
        </table> -->
    </div>

    <!-- Tabs content -->

    <!-- SCRIPTS -->
    <!-- Bootstrap 4 JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url('js/custom.js') ?>"></script>

    <script>
        $(document).ready(function() {
            $("#documentTable").css("width", "100%")

            let table = $('#documentTable').DataTable({
                "processing": true,
                "serverSide": true,
                "pageLength": 5,
                "ajax": {
                    url: "<?= base_url('documents/getData') ?>",
                    type: "POST",
                    // data: function(d) {
                    //     console.log(d);

                    //     return $.extend({}, d, {
                    //         start: d.start || 0,
                    //         length: d.length || 10,
                    //         search: {
                    //             value: d.search || ''
                    //         }
                    //     });
                    // }
                },
                width: "100%",
                // paging: false,
                ordering: false,
                searching: false,
                lengthChange: false,
                // searching: false,
                // info: false,
                // pagingType: "full_numbers",
                // lengthMenu: [5, 10, 25, 50, 100],
                columns: [{
                        data: 'no',
                    },

                    {
                        "data": "doc_name",
                        "render": function(data, type, row) {
                            // console.log(row);

                            return '<a href="<?= base_url("download-document/") ?>' + row.id + '">' + row.doc_name + '</a>';
                        }
                    },
                    {
                        data: 'idt'
                    }
                ],

            });
            // table.page.len(5).draw();

            function getUrlParameter(name) {
                let url = new URL(window.location.href);
                return url.searchParams.get(name);
            }

            // Menyimpan pagination state di URL
            // table.on('draw', function() {
            //     let info = table.page.info();
            //     let params = new URLSearchParams(window.location.search);
            //     params.set('start', info.start);
            //     params.set('length', info.length);
            //     window.history.replaceState({}, '', `${window.location.pathname}?${params}`);
            // });
        });
    </script>
    <!-- -->
    <script>
        $('#inputGroupFile02').on('change', function() {

            const fileName = $(this).val();
            $(this).next('.custom-file-label').html(fileName.split('\\').pop());
        })
    </script>
    <script>
        $(document).ready(function() {
            // console.log('okai')
            // Mendapatkan elemen berdasarkan ID atau kelas
            // const tabPane = document.getElementById('myTabPane');

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

</body>

</html>