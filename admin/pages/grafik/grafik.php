<?php
require '../../../vendor/autoload.php';
require_once ('../../../config/connection.php');
require_once ('../../../config/ektensi.php');
use Carbon\Carbon;
?>
<style>
    .btn_show {
        color: #0d8adc;
    }
    hr {
        margin: 0px;
    }
    .collapsible_css {
        cursor: pointer;
    }

    .collapsible_css:hover {
        color: #41dc0d;
    }

    .collapsible_css:after {
        content: '\002B';
        color: white;
        font-weight: bold;
        float: right;
        margin-left: 5px;
    }

    .content_css {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.2s ease-out;
        background-color: #f1f1f1;
    }
</style>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"> GRAFIK TAHUNAN</h3>
            </div>
            <div class="box-body">
                <form method="POST" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-1 control-label">TAHUN:</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="tahun_select" id="tahun_select">
                                <?php
                                $bulan = [
                                    [
                                        "code"  => null,
                                        "tahun" => "Pilih Tahun",
                                    ],
                                    [
                                        "code"  => 2024,
                                        "tahun" => "2024",
                                    ],
                                    [
                                        "code"  => 2025,
                                        "tahun" => "2025",
                                    ],
                                    [
                                        "code"  => 2026,
                                        "tahun" => "2026",
                                    ],
                                    [
                                        "code"  => 2027,
                                        "tahun" => "2027",
                                    ],
                                ];
                                $current_year = date('Y');
                                foreach ($bulan as $item) {
                                    $set_code  = $item['code'];
                                    $set_tahun = $item['tahun'];
                                    if(intval($current_year) == $set_code){
                                        echo "<option value='$set_code' selected>$set_tahun</option>";
                                    }else{
                                        echo "<option value='$set_code'>$set_tahun</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </form>
                <div style="margin: 0.5em;">
                    <canvas style="width: 100%; height: 30em;" id="line-chart"></canvas>
                </div>

            </div>
        </div>
    </div>
</div>
<script>

    var initData = {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Juni', 'Juli', 'Agust', 'Sept', 'Okt','Nov','Des'],
            datasets: [
                {
                    label: "Pos Tambaksari",
                    data: [1,2,3,4,5,6,7,8,9,10,11,12],
                    backgroundColor : "#FF55BB",
                    borderColor : "#FF55BB",
                    borderWidth : 1,
                    fill : false
                },
            ]
        }
    };
    var context = document.getElementById('line-chart').getContext('2d');
    var chart = new Chart(context, initData);





    // $('#tahun_select').on('change', function() {
    //     var tahun_select = this.value;
    //     $.ajax({
    //         type: 'POST',
    //         url: "pages/grafik/action.php?action=grafik_perpos",
    //         data: {tahun_select: tahun_select},
    //         cache: false,
    //         success: function(response) {
    //             var json = $.parseJSON(response);
    //             var data_arr = null;
    //
    //             new Chart(document.getElementById("line-chart"), {
    //                 type: 'line',
    //                 data: {
    //                     labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Juni', 'Juli', 'Agust', 'Sept', 'Okt','Nov','Des'],
    //                     datasets: [
    //                         {
    //                         label: "Pos Tambaksari",
    //                         data: [1,2,3,4,5,6,7,8,9,10,11,12],
    //                         backgroundColor : "#FF55BB",
    //                         borderColor : "#FF55BB",
    //                         borderWidth : 3,
    //                         fill : false
    //                     },
    //                     ]
    //                 },
    //                 options: {
    //                     responsive: true,
    //                     maintainAspectRatio: false, // my new default options
    //                     legend: {
    //                         position: 'bottom'
    //                     },
    //                     tooltips: {
    //                         mode: 'index',
    //                         intersect: false,
    //                     },
    //                     hover: {
    //                         mode: 'nearest',
    //                         intersect: true
    //                     },
    //                     animation: {
    //                         onComplete: function () {
    //                             var ctx = this.chart.ctx;
    //                             ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal', Chart.defaults.global.defaultFontFamily);
    //                             ctx.fillStyle = "black";
    //                             ctx.textAlign = 'center';
    //                             ctx.textBaseline = 'bottom';
    //
    //                             this.data.datasets.forEach(function (dataset)
    //                             {
    //                                 for (var i = 0; i < dataset.data.length; i++) {
    //                                     for(var key in dataset._meta)
    //                                     {
    //                                         var model = dataset._meta[key].data[i]._model;
    //                                         ctx.fillText(dataset.data[i], model.x, model.y - 5);
    //                                     }
    //                                 }
    //                             });
    //                         }
    //                     },
    //                     scales: {
    //                         xAxes: [{
    //                             display: true,
    //                             scaleLabel: {
    //                                 display: true,
    //                             }
    //                         }],
    //                         yAxes: [{
    //                             display: true,
    //                             scaleLabel: {
    //                                 display: true,
    //                             },
    //                             ticks: {
    //                                 beginAtZero: true,
    //                                 userCallback: function(label, index, labels) {
    //                                     // when the floored value is the same as the value we have a whole number
    //                                     if (Math.floor(label) === label) {
    //                                         return label;
    //                                     }
    //
    //                                 },
    //                             }
    //                         }]
    //                     }
    //                 }
    //             });
    //         }
    //     });
    // });


                // new Chart(document.getElementById("line-chart"), {
                //     type: 'line',
                //     data: lineChartData,
                //     options: {
                //         responsive: true,
                //         maintainAspectRatio: false, // my new default options
                //         legend: {
                //             position: 'bottom'
                //         },
                //         tooltips: {
                //             mode: 'index',
                //             intersect: false,
                //         },
                //         hover: {
                //             mode: 'nearest',
                //             intersect: true
                //         },
                //         animation: {
                //             onComplete: function () {
                //                 var ctx = this.chart.ctx;
                //                 ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal', Chart.defaults.global.defaultFontFamily);
                //                 ctx.fillStyle = "black";
                //                 ctx.textAlign = 'center';
                //                 ctx.textBaseline = 'bottom';
                //
                //                 this.data.datasets.forEach(function (dataset)
                //                 {
                //                     for (var i = 0; i < dataset.data.length; i++) {
                //                         for(var key in dataset._meta)
                //                         {
                //                             var model = dataset._meta[key].data[i]._model;
                //                             ctx.fillText(dataset.data[i], model.x, model.y - 5);
                //                         }
                //                     }
                //                 });
                //             }
                //         },
                //         scales: {
                //             xAxes: [{
                //                 display: true,
                //                 scaleLabel: {
                //                     display: true,
                //                 }
                //             }],
                //             yAxes: [{
                //                 display: true,
                //                 scaleLabel: {
                //                     display: true,
                //                 },
                //                 ticks: {
                //                     beginAtZero: true,
                //                     userCallback: function(label, index, labels) {
                //                         // when the floored value is the same as the value we have a whole number
                //                         if (Math.floor(label) === label) {
                //                             return label;
                //                         }
                //
                //                     },
                //                 }
                //             }]
                //         }
                //     }
                // });








    //             new Chart(document.getElementById("line-chart"), {
    //                 type: 'line',
    //                 data: {
    //                     labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Juni', 'Juli', 'Agust', 'Sept', 'Okt','Nov','Des'],
    //                     datasets: [
    //                         {
    //                             label: "Pos Tambaksari",
    //                             data: data_arr,
    //                             backgroundColor : "#FF55BB",
    //                             borderColor : "#FF55BB",
    //                             borderWidth : 3,
    //                             fill : false
    //                         }
    //                     ]
    //                 },
    //                 options: {
    //                     responsive: true,
    //                     maintainAspectRatio: false,
    //                     legend: {
    //                         position: 'bottom'
    //                     },
    //                     tooltips: {
    //                         mode: 'index',
    //                         intersect: false,
    //                     },
    //                     hover: {
    //                         mode: 'nearest',
    //                         intersect: true
    //                     },
    //                     animation: {
    //                         onComplete: function () {
    //                             var ctx = this.chart.ctx;
    //                             ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal', Chart.defaults.global.defaultFontFamily);
    //                             ctx.fillStyle = "black";
    //                             ctx.textAlign = 'center';
    //                             ctx.textBaseline = 'bottom';
    //
    //                             this.data.datasets.forEach(function (dataset)
    //                             {
    //                                 for (var i = 0; i < dataset.data.length; i++) {
    //                                     for(var key in dataset._meta)
    //                                     {
    //                                         var model = dataset._meta[key].data[i]._model;
    //                                         ctx.fillText(dataset.data[i], model.x, model.y - 5);
    //                                     }
    //                                 }
    //                             });
    //                         }
    //                     },
    //                     scales: {
    //                         xAxes: [{
    //                             display: true,
    //                             scaleLabel: {
    //                                 display: true,
    //                             }
    //                         }],
    //                         yAxes: [{
    //                             display: true,
    //                             scaleLabel: {
    //                                 display: true,
    //                             },
    //                             ticks: {
    //                                 beginAtZero: true,
    //                                 userCallback: function(label, index, labels) {
    //                                     if (Math.floor(label) === label) {
    //                                         return label;
    //                                     }
    //
    //                                 },
    //                             }
    //                         }]
    //                     }
    //                 }
    //             });
    //         }
    //     });
    // });


    // var tahun_select = $('#tahun_select').val();
    // $.ajax({
    //     type: 'POST',
    //     url: "pages/grafik/action.php?action=grafik_perpos",
    //     data: {tahun_select: tahun_select},
    //     cache: false,
    //     success: function(response){
    //         var json = $.parseJSON(response);
    //         var div_format = "";
    //         $.each(json.data, function (key, value) {
    //             div_format += "<div class='box-body'><strong>"+value.pos+"</strong><span class='collapsible_css btn_show' style='float: right;'>Show data</span>\
    //             <div class='content_css'>\
    //             <div class='box box-solid collapsed-box'>\
    //             <table class='table table-hover'>\
    //             <thead>\
    //             <tr>\
    //             <caption>View data: "+value.pos+"</caption>\
    //             <th>Tanggal</th>\
    //             <th>Order</th>\
    //             </tr>\
    //             </thead>\
    //             <tbody>";
    //             $.each(value.detail, function (keydet, det) {
    //                 div_format += "<tr><td>"+det.date+"</td>\
    //                 <td><strong>"+det.total+"</strong> Pesanan <i class='fa fa-level-up'></i></td>";
    //             });
    //             div_format += "</tbody></table></div></div></div><hr>";
    //         });
    //         $('#list_pos_order').html(div_format);
    //
    //         var coll = document.getElementsByClassName("collapsible_css");
    //         var i;
    //
    //         for (i = 0; i < coll.length; i++) {
    //             var btnaction = coll[i];
    //             coll[i].addEventListener("click", function() {
    //                 this.classList.toggle("active");
    //                 var content = this.nextElementSibling;
    //                 if (content.style.maxHeight){
    //                     content.style.maxHeight = null;
    //                     this.textContent = 'Show data';
    //                 } else {
    //                     content.style.maxHeight = content.scrollHeight + "px";
    //                     this.textContent = 'Hidden data';
    //                 }
    //             });
    //         }
    //     }
    // });

</script>