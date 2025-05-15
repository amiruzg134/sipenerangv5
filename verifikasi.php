<?php
require 'vendor/autoload.php';
require 'config/env.php';
$client = new \GuzzleHttp\Client();
$cookieJar = new \GuzzleHttp\Cookie\CookieJar();

$response = $client->post(getenv('BASE_URL').'user-non-verif', [
        'form_params' => [
            'id' => $_GET['key'],
        ],
        'headers' => [
            'Access-Key' => getenv('ACCESS_KEY')
        ],
    ]
);
$res = json_decode($response->getBody(), true);
$email = $res['data']['email'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Verifikasi</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link id="pagestyle" href="assets/assetsform/css/soft-ui-dashboard.min.css?v=1.1.1" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="assets/assetsform/css/nucleo-icons.css" rel="stylesheet" />
    <link href="assets/assetsform/css/nucleo-svg.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="assets/assetsform/css/nucleo-svg.css" rel="stylesheet" />

    <style>
        body {
            background-color: #F8F9FA;
        }

        hr.rounded {
            width: 10%;
            border-top: 8px solid #bbb;
            border-radius: 5px;
        }

        .step {
            display: none;
        }

        .btn-grad {
            /* Frame 2609525 */
            color: white;
            background: linear-gradient(90deg, #F20487 0%, #9C1EB7 100%);

        }

        .btn-grad:hover {
            /* Frame 2609525 */
            color: white;
        }
    </style>
</head>
<body>

<div class="container">

    <div class="d-flex flex-row mt-4 mb-4 align-items-center" style="gap: 48px;">
        <div class="d-flex" style="gap: 14px;">
            <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 30px; height: 30px; background: hsl(4, 90%, 50%)">
                <span class="text-center text-white border border-white rounded-circle" style="width: 28px; height: 28px;">1</span>
            </div>
            <div class="d-flex flex-column">
                <span class="font-weight-bold text-dark">Informasi Calon Pendaki</span>
                <span>Berikan identitas Anda untuk pendataan</span>
            </div>
        </div>
        <hr class="rounded">
        <div class="d-flex" style="gap: 14px;">
            <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 30px; height: 30px; background: hsl(4, 90%, 50%)">
                <span class="text-center text-white border border-white rounded-circle" style="width: 28px; height: 28px;">2</span>
            </div>
            <div class="d-flex flex-column">
                <span class="font-weight-bold">Kontak Darurat & Riwayat Penyakit</span>
                <span>Masukan kontak darurat untuk berjaga jaga terhadap hal buruk</span>
            </div>
        </div>
    </div>

    <div class="card px-4 mb-4">
        <form method="post" action="" enctype="multipart/form-data">
            <div class="step" id="step1">
                <h5 class="mt-4">Informasi Data Diri</h5>
                <input type="hidden" id="key" name="key" value="<?php echo $_GET['key']; ?>">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label mt-4">Nama Depan</label>
                            <div class="input-group">
                                <input class="form-control" type="text" name="firstname" id="firstname" placeholder="Masukan nama depan Anda" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" style="margin-bottom: 0">
                                <label class="form-label mt-4">Nama Belakang</label>
                                <div class="input-group" >
                                    <input class="form-control" type="text" name="lastname" id="lastname" placeholder="Masukan nama belakang Anda" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" id="email" value="<?php echo $email; ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="is_wni">Kewarganegaraan</label>
                    <div class="radio d-flex gap-4" style="padding-left: 6px;">
                        <div class="d-inline-flex align-items-center gap-2">
                            <input type="radio" name="is_wni" id="is_wni_wni" value="wni" style="width: 18px; height: 18px;" /> WNI
                        </div>
                        <div class="d-inline-flex align-items-center gap-2">
                            <input type="radio" name="is_wni" id="is_wni_wna" value="wna" style="width: 18px; height: 18px;" /> WNA
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="id_card_type">Tipe kartu identitas</label>
                            <select class="form-control" name="id_card_type" id="id_card_type">
                                <option value="" selected>Pilih Tipe Kartu Identitas</option>
                                <option value="ktp">KTP</option>
                                <option value="passport">Passport</option>
                                <option value="sim">SIM</option>
                                <option value="kartu pelajar">Kartu Pelajar</option>
                                <option value="kitas">Kitas</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="id_card_number">No. Identitas</label>
                            <input type="text" class="form-control" id="id_card_number" placeholder="KTP, SIM, Kartu Pelajar, Passport" name="id_card_number" required>
                            <span id="error" class="text-danger text-sm"></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name">Upload kartu Identitas</label>
                    <input id="image" type="file" accept="image/*" name="image" onchange="loadFile(event)">
                </div>
                <div class="form-group">
                    <img id="output" style="width: 50%;margin: 10px;"/><br>
                </div>
                <div class="form-group">
                    <label for="gender">Jenis Kelamin</label>
                    <select class="form-control" name="gender" id="gender">
                        <option selected>Pilih Jenis Kelamin</option>
                        <option value="laki-laki">Laki-Laki</option>
                        <option value="perempuan">Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="phone_code_id">No. Telepon</label>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <select class="form-control border-end-0" name="phone_code_id" id="phone_code_id" style="border-top-right-radius: 0; border-bottom-right-radius: 0;">
                                    <option selected value="62">+62</option>
                                </select>
                            </div>
                            <input type="text" class="form-control" placeholder="Nomor Telp" id="phone" name="phone" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Tempat Lahir</label>
                            <div class="input-group">
                                <input class="form-control" type="text" name="place_birth" id="place_birth" placeholder="Masukan tempat lahir Anda" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" style="margin-bottom: 0">
                                <label class="form-label">Tanggal Lahir</label>
                                <div class="input-group" >
                                    <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                    <input class="form-control datetimepicker" type="text" name="date_birth" id="date_birth" placeholder="Masukan tanggal lahir Anda" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="id_card_number">Alamat</label>
                    <input type="text" class="form-control" id="address" placeholder="Masukan Alamat Anda" name="address" required>
                </div>
                <div class="form-group">
                    <label for="province_code">Provinsi</label>
                    <select class="form-control" name="province_code" id="province_code" required>
                        <option value=""></option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="city_code">Kabupaten/Kota</label>
                    <select class="form-control" name="city_code" id="city_code" required>
                        <option value="">- Pilih -</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="district_code">Kecamatan</label>
                    <select class="form-control" name="district_code" id="district_code" required>
                        <option value="">- Pilih -</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="village_code">Desa/Kelurahan</label>
                    <select class="form-control" name="village_code" id="village_code" required>
                        <option value="">- Pilih -</option>
                    </select>
                </div>

            <div class="d-grid gap-2">
                <button type="button" id="nextBtn" class="btn btn-grad mt-4">
                    Selanjutnya
                </button>
            </div>
        </div>
        <div class="step" id="step2">
            <h5 class="mt-4">Kontak darurat</h5>
            <div class="row">
                <div class="col-lg-12 col-12 mx-auto">
                    <div class="card mt-4">
                        <div class="card-body pb-3">
                            <div class="mb-4">
                                <label class="form-label mt-4">Nama Kontak Darurat </label>
                                <div class="input-group">
                                    <input class="form-control selector" type="text" name="emergency_name_one" id="emergency_name_one" placeholder="Masukan nama kontak darurat" minlength="6" pattern="[a-zA-Z'\s]+" required>
                                </div>
                            </div>
                            <div class="d-flex gap-4">
                                <div class="w-50">
                                    <label for="phone_code_id">No. Telepon</label>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <select class="form-control border-end-0" name="emergency_phone_code_id_one" id="emergency_phone_code_id_one" style="border-top-right-radius: 0; border-bottom-right-radius: 0;">
                                                    <option selected value="62">+62</option>
                                                </select>
                                            </div>
                                            <input type="text" class="form-control" placeholder="Nomor Telepon" id="emergency_phone_one" name="emergency_phone_one" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-50">
                                    <label class="form-label">Hubungan</label>
                                    <select class="form-control" name="emergency_relationship_one" id="emergency_relationship_one" required>
                                        <option value="orang tua">Orang Tua</option>
                                        <option value="saudara">Saudara</option>
                                        <option value="teman">Teman</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card mt-4">
                        <div class="card-body pb-3">
                            <div class="d-flex gap-4">
                                <div id="riwayat-penyakits" style="width: 100%;"></div>
                            </div>
                            <button class="btn btn-info" type="button" id="add-input" style="margin-top: 10px; text-transform:none;">Tambah Riwayat Penyakit</button>
                        </div>
                    </div>
                    
                    <div class="card mt-4">
                        <div class="card-body pb-3">
                            <span class="text-primary text-center">Pastikan untuk mengisi data dengan benar. Data yang sudah disimpan tidak dapat diubah.</span>
                        </div>
                    </div>

                </div>
            </div>
            <div class="d-flex flex-row gap-2 mt-4">
                <button type="button" id="prevBtn" class="btn btn-secondary w-50">Kembali</button>
                <button type="button" class="btn btn-grad w-50" id="proses">
                    <span id="btn-text-proses">Proses</span>
                    <div class="spinner-border spinner-border-sm" role="status" id="loading" style="display: none;">
                    </div>
                </button>
            </div>
        </div>


        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/nik-valid/dist/nik-valid.min.js"></script>
<script src="assets/assetsform/js/plugins/choices.min.js"></script>
<script src="assets/assetsform/js/jquery-min.js"></script>
<script src="assets/assetsform/js/plugins/choices.min.js"></script>
<script src="assets/assetsform/js/plugins/flatpickr.min.js"></script>
<script>






    var loadFile = function(event) {
        var output = document.getElementById('output');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src) // free memory
        }
    };

    function getlength(number) {
        return number.toString().length;
    }

    $(document).ready(function() {

        var currentStep = 1;

        // Show the initial step
        showStep(currentStep);

        // Function to show a specific step
        function showStep(step) {
            $(".step").hide(); // Hide all steps
            $("#step" + step).show(); // Show the specified step
        }

        // Next button click event
        $("#nextBtn").click(function(){
            if (currentStep < 3) { // Assuming there are 3 steps in total
                currentStep++;
                showStep(currentStep);
            }
        });

        // Previous button click event
        $("#prevBtn").click(function(){
            if (currentStep > 1) {
            currentStep--;
            showStep(currentStep);
            }
        });


        $('#id_card_number').on('input', function() {
            var setNumber;
            var inputValue = $(this).val();
            var id_card_type = $('#id_card_type').val();

            if (id_card_type === 'ktp') {
                setNumber = 16;
                $('#id_card_number').attr('type', 'number')
            } else if (id_card_type === 'kartu pelajar') {
                setNumber = 10;
                $('#id_card_number').attr('type', 'number')
            } else if (id_card_type === 'sim') {
                setNumber = 14;
                $('#id_card_number').attr('type', 'number')
            } else if (id_card_type === 'passport') {
                setNumber = 16;
                $('#id_card_number').attr('type', 'text')
            } else {
                setNumber = 16;
                $('#id_card_number').attr('type', 'text')
            }

            // Check if the input value exceeds the maximum number
            if (getlength(inputValue) != setNumber) {
                if (id_card_type === 'passport') {
                    $('#error').text('jumlah panjang '+id_card_type+' harus '+ setNumber+' karakter');
                } else {
                    $('#error').text('jumlah panjang '+id_card_type+' harus '+ setNumber+' digit');
                }
                $(this).val(inputValue.slice(0, setNumber)); // Remove the last character
            } else {
                $('#error').text('');
            }
        });

        const container = document.getElementById("riwayat-penyakits");
        const addButton = document.getElementById("add-input");
        function addInput() {
            const inputGroup = document.createElement("div");
            inputGroup.classList.add("input-group");
            inputGroup.style.marginBottom = "10px";

            inputGroup.innerHTML = `
            <div class="w-50">
                <input class="form-control selector" type="text" name="input_riwayat_penyakits[]" placeholder="Masukkan Riwayat Penyakit"/>
            </div>
            <div class="w-50">
                <button class="btn btn-danger delete-input" type="button" style="margin-left: 10px; text-transform:none;">Hapus</button>
            </div>
                `;

            container.appendChild(inputGroup);
            inputGroup.querySelector(".delete-input").addEventListener("click", function () {
                container.removeChild(inputGroup);
            });
        }
        addButton.addEventListener("click", addInput);

        $(document).on('click', '#proses', function() {
            const fileInput = document.getElementById("image");
            const file = fileInput.files[0];
            if (file) {
                var formData = new FormData();
                const is_wni = $('input[name="is_wni"]:checked').val();
                formData.append('image', file);
                formData.append('is_wni', is_wni);
                const riwayat_penyakits = $("input[name='input_riwayat_penyakits[]']").map(function () {
                    return $(this).val();
                }).get();
                formData.append('riwayat_penyakits', riwayat_penyakits);
                formData.append('key', $('#key').val());
                formData.append('email', $('#email').val());
                formData.append('firstname', $('#firstname').val());
                formData.append('lastname', $('#lastname').val());
                formData.append('id_card_type', $('#id_card_type').val());
                formData.append('id_card_number', $('#id_card_number').val());
                formData.append('gender', $('#gender').val());
                formData.append('phone_code_id', $('#phone_code_id').val());
                formData.append('phone', $('#phone').val());
                formData.append('place_birth', $('#place_birth').val());
                formData.append('date_birth', $('#date_birth').val());
                formData.append('province_code', $('#province_code').val());
                formData.append('city_code', $('#city_code').val());
                formData.append('district_code', $('#district_code').val());
                formData.append('village_code', $('#village_code').val());
                formData.append('address', $('#address').val());
                formData.append('emergency_name_one', $('#emergency_name_one').val());
                formData.append('emergency_phone_code_id_one', $('#emergency_phone_code_id_one').val());
                formData.append('emergency_phone_one', $('#emergency_phone_one').val());
                formData.append('emergency_relationship_one', $('#emergency_relationship_one').val());
                $.ajax({
                    type    : "POST",
                    url     : "api/proccess-verif.php",
                    data    : formData,
                    beforeSend: function() {
                        $('#btn-text-proses').hide()
                        $('#loading').show()
                        $('#proses').prop('disabled', true)
                    },
                    complete: function() {
                        $('#btn-text-proses').show()
                        $('#loading').hide()
                        $('#proses').prop('disabled', false)
                    },
                    success: function (response) {
                        var json = $.parseJSON(response);
                        if (json.error){
                            alert(json.message);
                        }else{
                            alert(json.message);
                            window.location.href = "kapasitas.php";
                        }
                    },
                    cache: false,
                    processData: false,
                    contentType: false,
                });
                return false;
            }
        });
    });



    $.ajax({
        type: 'POST',
        url: "api/provinces.php",
        cache: false,
        success: function(msg){
            $("#province_code").html(msg);
        }
    });

    $("#province_code").change(function(){
        var province = $("#province_code").val();
        $.ajax({
            type: 'POST',
            url: "api/cities.php",
            data: {province: province},
            cache: false,
            success: function(msg){
                $("#city_code").html(msg);
            }
        });
    });

    $("#city_code").change(function(){
        var district = $("#city_code").val();
        $.ajax({
            type: 'POST',
            url: "api/districts.php",
            data: {district: district},
            cache: false,
            success: function(msg){
                $("#district_code").html(msg);
            }
        });
    });

    $("#district_code").change(function(){
        var village = $("#district_code").val();
        $.ajax({
            type: 'POST',
            url: "api/villages.php",
            data: {village: village},
            cache: false,
            success: function(msg){
                $("#village_code").html(msg);
            }
        });
    });

    if (document.querySelector('.datetimepicker')) {
        flatpickr('.datetimepicker', {
            allowInput: true,
            disableMobile: "true",
            maxDate : "today",
            disable: [
                {
                    from: "2006-01-01",
                    to: "today"
                }
            ]
        });
    }

    // Validasi Wni/Wna untuk pemilihan id card type
    const radioButtons = document.querySelectorAll('input[name="is_wni"]');
    const idCardTypeSelect = document.getElementById('id_card_type');
    const allOptions = [
        { value: "ktp", text: "KTP" },
        { value: "passport", text: "Passport" },
        { value: "sim", text: "SIM" },
        { value: "kartu pelajar", text: "Kartu Pelajar" },
        { value: "kitas", text: "Kitas" },
    ];

    function updateIdCardOptions() {
        const selectedWni = document.querySelector('input[name="is_wni"]:checked')?.value;
        idCardTypeSelect.innerHTML = '<option value="" selected>Pilih Tipe Kartu Identitas</option>';

        let filteredOptions = [];
        if (selectedWni === "wni") {
            filteredOptions = allOptions.filter(option => option.value !== "passport" && option.value !== "kitas");
        } else if (selectedWni === "wna") {
            filteredOptions = allOptions.filter(option => option.value === "passport" || option.value === "kitas");
        } else {
            filteredOptions = allOptions;
        }

        filteredOptions.forEach(option => {
            const opt = document.createElement('option');
            opt.value = option.value;
            opt.textContent = option.text;
            idCardTypeSelect.appendChild(opt);
        });
    }
    radioButtons.forEach(radio => {
        radio.addEventListener('change', updateIdCardOptions);
    });
    updateIdCardOptions();


    // $("#id_card_type").change(function(){
    //     var tipe = $("#id_card_type").val();
    //     if(tipe == "ktp"){
    //         const Validator = require('nik-valid')
    //         const validator = new Validator()
    //         const result = validator.check('010203XXXXXXXXXXX')
    //     }else if(tipe == "passport"){
    //
    //     }else if(tipe == "sim"){
    //
    //     }else if(tipe == "kartu pelajar"){
    //
    //     }
    //
    // });


    // $("#id_card_number").keyup(function(){
    //     var tipe = $("#id_card_type").val();
    //     var validator_number = $("#id_card_number").val();
    //     if(tipe == "ktp"){
    //         const Validator = require('nik-valid')
    //         const validator = new Validator()
    //         const result = validator.check(validator_number)
    //         if (result){
    //             console.log("Valid");
    //         }else{
    //             console.log("Invalid");
    //         }
    //     }else if(tipe == "passport"){
    //
    //     }else if(tipe == "sim"){
    //
    //     }else if(tipe == "kartu pelajar"){
    //
    //     }
    //
    // });

</script>
</body>
</html>
