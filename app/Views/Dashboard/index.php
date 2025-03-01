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
            <div class="col-md-12 mt-5 mx-5">
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

            <div class="col-md-3">
                <div class="form-group">
                    <form action="/dashboard" id="myform" method="POST">
                        <label for="monthyear">Example select</label>
                        <select class="form-control" id="monthyear" name="monthyear">
                            <?php foreach ($datafilter as $key => $f): ?>
                                <option value="<?= $f['month_year'] ?>" <?= $f['month_year'] == $endmonth ? 'selected' : '' ?>><?= tanggal_indonesia($f['month_year'], true, true) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </form>
                </div>
            </div>
            <?php if ($isempty != 0) { ?>
                <?php helper('url'); ?>
                <a href="<?= base_url('export-excel/' . str_replace('-', '', $endmonth)) ?>" target="_blank">
                    <h5 class="">Export To Excel</h5>
                </a>
            <?php } ?>

            <!-- <a href="/export-excel/<?= str_replace('-', '', $endmonth)  ?>">
                <h5 class="">Export To Excel</h5>
            </a> -->
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th rowspan="2">
                            <p>GL Account</p>
                        </th>
                        <th colspan="4">
                            <p style="text-align: center;">MoM</p>
                        </th>
                        <th colspan="4">
                            <p style="text-align: center;">Yoy</p>
                        </th>
                    </tr>
                    <tr>
                        <th><?= converTanggal($startMom) ?></th>
                        <th><?= converTanggal($endmonth) ?></th>
                        <th>Growth</th>
                        <th>Rate</th>
                        <th><?= converTanggal($startYoy) ?></th>
                        <th><?= converTanggal($endmonth) ?></th>
                        <th>Growth</th>
                        <th>Rate</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($isempty != 0) { ?>
                        <?php
                        $totalstartMom = 0;
                        $totalendMom = 0;

                        $totalstartYoy = 0;
                        $totalendYoy = 0;

                        foreach ($datas as $key => $data): ?>
                            <?php switch ($data['kode_akun_2']) {
                                case '52':
                                    $desc = 'Operations and Maintenance';
                                    break;
                                case '53':
                                    $desc = 'Personel';
                                    break;
                                case '54':
                                    $desc = 'Marketing and Sales';
                                    break;
                                case '55':
                                    $desc = 'General and Administrative';
                                    break;
                                case '56':
                                    $desc = 'Cost of Service';
                                    break;
                                default:
                                    $text = ' Default';
                                    break;
                                    // converTanggal($f['month_year'])
                            }


                            // $growthmom = $data['Feb-24'] - $data['Jan-24'];
                            // $rateMom = ceil(($growthmom / $data['Jan-24']) * 100) . '%';

                            // $growthyoy = $data['Feb-24'] - $data['Feb-23'];
                            // $rateYoy = ceil(($growthyoy / $data['Feb-23']) * 100) . '%';
                            // $startMom = $isempty != 0 ? $this->minusDate($param, 'month') : date('Y-m-d');
                            // $startYoy =  $isempty != 0 ? $this->minusDate($param, 'year') : date('Y-m-d');
                            $aliasMom = converTanggal($startMom);
                            $aliasEndmonth = converTanggal($endmonth);
                            $aliasYoy = converTanggal($startYoy);

                            $growthmom = $data[$aliasEndmonth] - $data[$aliasMom];
                            $rateMom = $data[$aliasMom] == 0 ? "-" : ceil(($growthmom / $data[$aliasMom]) * 100) . '%';

                            $growthyoy = $data[$aliasEndmonth] - $data[$aliasYoy];
                            $rateYoy = $data[$aliasYoy] == 0 ? "-" : ceil(($growthyoy / $data[$aliasYoy]) * 100) . '%';


                            $totalstartMom += $data[$aliasMom];
                            $totalendMom += $data[$aliasEndmonth];
                            // $totalgrowthMom = $totalendMom - $totalendMom;
                            $rateYoy = $data[$aliasYoy] == 0 ? "-" : ceil(($growthyoy / $data[$aliasYoy]) * 100) . '%';

                            $totalrateMom = 0;

                            $totalstartYoy += $data[$aliasYoy];
                            $totalendYoy += $data[$aliasEndmonth];
                            $totalgrowthYoy = 0;
                            $totalrateYoy = 0;
                            ?>
                            <tr>
                                <td><?= $data['kode_akun_2'] ?> - <?= $desc ?></td>
                                <td><?= formatRupiah($data[$aliasMom]) ?> </td>
                                <td><?= formatRupiah($data[$aliasEndmonth]) ?> </td>
                                <td><?= formatRupiah($growthmom) ?></td>
                                <td><?= $rateMom ?></td>
                                <td><?= formatRupiah($data[$aliasYoy]) ?></td>
                                <td><?= formatRupiah($data[$aliasEndmonth]) ?></td>
                                <td><?= formatRupiah($growthyoy) ?></td>
                                <td><?= $rateYoy ?></td>

                            </tr>


                            <!-- <tr>
                                <td><?php // $data['kode_akun_2'] 
                                    ?> - <?php // $desc 
                                            ?></td>
                                <td><?php // formatRupiah($data['Jan-24']) 
                                    ?> </td>
                                <td><?php // formatRupiah($data['Feb-24']) 
                                    ?> </td>
                                <td><?php // formatRupiah($growthmom) 
                                    ?></td>
                                <td><?php // $rateMom 
                                    ?></td>
                                <td><?php // formatRupiah($data['Feb-23']) 
                                    ?></td>
                                <td><?php // formatRupiah($data['Feb-24']) 
                                    ?></td>
                                <td><?php // formatRupiah($growthyoy) 
                                    ?></td>
                                <td><?php // $rateYoy 
                                    ?></td>

                            </tr> -->
                        <?php endforeach; ?>
                        <tr class="fw-bold">
                            <td>Total</td>
                            <td><?= formatRupiah($totalstartMom) ?></td>
                            <td><?= formatRupiah($totalendMom) ?></td>
                            <?php
                            $totalgrowthMom = $totalendMom - $totalstartMom;

                            $rateMom = $totalstartMom == 0 ? "-" : ceil(($totalgrowthMom / $totalstartMom) * 100) . '%';

                            ?>
                            <td><?= formatRupiah($totalgrowthMom) ?></td>
                            <td><?= $rateMom ?></td>
                            <td><?= formatRupiah($totalstartYoy) ?></td>
                            <td><?= formatRupiah($totalendYoy) ?></td>
                            <?php
                            $totalgrowthYoy = $totalendYoy - $totalstartYoy;

                            $rateYoy = $totalstartYoy == 0 ? "-" : ceil(($totalgrowthYoy / $totalstartYoy) * 100) . '%';

                            ?>
                            <td><?= formatRupiah($totalgrowthYoy) ?></td>
                            <td><?= $rateYoy ?></td>

                        </tr>
                    <?php } ?>

                </tbody>
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
    <script src="<?= base_url('js/custom.js') ?>"></script>
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
            $(document).on("change", "#monthyear", function() {
                // const monthyear = $(this).val();
                // console.log('monthyear');

                $(`#myform`).submit();
            });
        });
    </script>
    <!-- -->
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