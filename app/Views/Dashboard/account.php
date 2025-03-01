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


                 <table class="table table-bordered">
                     <thead>

                         <tr>
                             <th>No</th>
                             <th>G/L Account Code</th>
                             <th>G/L Account Description</th>
                             <th>Sumatera</th>
                             <th>Sumbagut</th>
                             <th>Sumbagsel</th>
                             <th>Sumbagteng</th>

                         </tr>
                     </thead>
                     <tbody>
                         <?php
                            $subtotalSumatera = 0;
                            $subtotalSumbagut = 0;
                            $subtotalSumbagsel = 0;
                            $subtotalSumbagteng = 0;

                            ?>
                         <?php foreach ($datas as $key => $value) :  ?>
                             <?php
                                $subtotalSumatera += $value['Sumatera'];
                                $subtotalSumbagut += $value['Sumbagut'];
                                $subtotalSumbagsel += $value['Sumbagsel'];
                                $subtotalSumbagteng += $value['Sumbagteng'];
                                ?>
                             <tr>
                                 <td> <?= $key + 1; ?></td>
                                 <td><?= $value['kode_akun_2']; ?></td>
                                 <td><?= $value['desc']; ?></td>
                                 <td><?= "Rp." . format_uang($value['Sumatera']) ?></td>
                                 <td><?= "Rp." . format_uang($value['Sumbagut']) ?></td>
                                 <td><?= "Rp." . format_uang($value['Sumbagsel']) ?></td>
                                 <td><?= "Rp." . format_uang($value['Sumbagteng']) ?></td>
                             </tr>
                         <?php endforeach; ?>

                         <tr>
                             <td colspan="3"><?= "Subtotal" ?></td>
                             <td> <?= "Rp." . format_uang($subtotalSumatera) ?> </td>
                             <td> <?= "Rp." . format_uang($subtotalSumbagut) ?> </td>
                             <td> <?= "Rp." . format_uang($subtotalSumbagsel) ?> </td>
                             <td> <?= "Rp." . format_uang($subtotalSumbagteng) ?> </td>
                         </tr>
                         <tr>
                             <?php $grandTotal = $subtotalSumatera + $subtotalSumbagut + $subtotalSumbagsel + $subtotalSumbagteng ?>
                             <td colspan="3"><?= "Grand Total" ?></td>
                             <td colspan="4" class="text-center"><?= "Rp." . format_uang($grandTotal)  ?></td>
                         </tr>
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