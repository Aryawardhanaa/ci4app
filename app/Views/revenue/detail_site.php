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
                        <a class="btn btn-primary" href="/revenue">
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



        <div class="container mt-5">
            <table id="mytable" class="table table-striped w-full">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Site</th>
                        <th>Revenue m1</th>
                        <th>Revenue m2</th>
                        <th>Revenue m3</th>
                        <th>Revenue m4</th>
                        <th>Revenue m5</th>
                        <th>Revenue m6</th>
                        <!-- <th>Email</th>
                        <th>Role</th> -->
                    </tr>
                </thead>
            </table>

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
            $("#mytable").css("width", "100%")

            // const paramValue = urlParams.get('regional'); // Get specific parameter

            let table = $('#mytable').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 5,
                ajax: {
                    url: "<?= base_url('revenue/get-data-site') ?>",
                    type: "POST",
                    data: function(d) {
                        const urlParams = new URLSearchParams(window.location.search);
                        console.log(urlParams.get('regional') || '');
                        console.log(urlParams.get('avail') || '');
                        console.log(urlParams.get('revenue_cat') || '');

                        d.regional = urlParams.get('regional') || ''; // Custom parameter
                        d.avail = urlParams.get('avail') || ''; // Example for date filter
                        d.revenue_cat = urlParams.get('revenue_cat') || '';
                    }
                },
                width: "100%",
                ordering: false,
                searching: false,
                lengthChange: false,
                columns: [{
                        data: 'no',
                    },
                    {
                        data: 'site_id'
                    },
                    {
                        data: 'revenue_m1'
                    },
                    {
                        data: 'revenue_m2'
                    },
                    {
                        data: 'revenue_m3'
                    },
                    {
                        data: 'revenue_m4'
                    },
                    {
                        data: 'revenue_m5'
                    },
                    {
                        data: 'revenue_m6'
                    },
                ],

            });
            // table.page.len(5).draw();

            // console.log(paramValue);

            function getUrlParameter(name) {
                let url = new URL(window.location.href);
                return url.searchParams.get(name);
            }

        });
    </script>

</body>

</html>