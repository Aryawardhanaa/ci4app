<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<?= $this->endSection() ?>


<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        console.log('asdasd');
        // $(".shf2").css("display", "none")
        // $('#task1').trigger('click');
        // $('#labeltask1').trigger('click');
        // $(".shf2").attr("style", "visibi: none !important;");
        // $(".shf2").attr("style", "display: none;");
        $(document).on("click", ".task3", function() {
            $(".shuffle-item").attr("style", "display: block;");
        });

        // const button = document.getElementById('task1');
        // console.log(button);

        // button.click();
    });
</script>
<?= $this->endSection() ?>