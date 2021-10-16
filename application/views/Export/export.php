<?php  $csrf = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash' => $this->security->get_csrf_hash()
);

?>
<?php $this->load->view('Layouts/header') ?>
  
<!-- section start -->

<section>

    <div class="container-fluid">

        <div class="taskPageSize taskPageSizeDashboard">

            <div class="alertMessage">

                <div class="alert alert-dismissible alert-success msg">

                    <button type="button" class="close" data-dismiss="alert">&times;</button>

                    <strong>Thanks!</strong>

                    <a href="#" class="alert-link">Add Successfully</a>

                </div>

                <div class="alert alert-dismissible alert-danger err">

                    <button type="button" class="close" data-dismiss="alert">&times;</button>

                    <strong>Failed!</strong>

                    <a href="#" class="alert-link">Try Again.</a>

                </div>

            </div>

            <div class="row">

                <div class="col-md-12">

                    <div class="page-container list-menu-view">

                        <div class="page-content">

                            <div class="main-container">

                                <div class="container-fluid">

                                    <div class="col-md-12">

                                        <div class="login-formmea">

                                            <div class="box-widget widget-module">  
                                            
                                                    <div class="widget-container">

                                                        <div class=" widget-block">

                                                            <div class="row">

                                                                <form id="ExoprtFormData" action="<?= base_url("FilterExportReports") ?>" method="post" enctype="multipart/form-data">
  
                                                                    <!--<div class="col-md-2">-->

                                                                    <!--    <label>Report</label> -->
                                                                    <!--    <select class="form-control" name="reportType" id="reportType">-->
                                                                    <!--        <option value=''>Select Report Type</option>-->
                                                                    <!--        <?php foreach($filterMenu->result() as $row) :  ?>-->
                                                                    <!--        <option value='<?= $row->name ?>'><?= $row->name ?></option>-->
                                                                    <!--        <?php endforeach; ?>-->
                                                                    <!--    </select>-->

                                                                    <!--</div>  --> 
                                                                    <div class="col-md-2">

                                                                        <label>Report Type</label> 
                                                                        <select class="form-control" name="filterType" id="filterType">
                                                                            <option value=''>Select Report</option>
                                                                            <?php foreach($filterMenu->result() as $row) :  ?>
                                                                            <option value='<?= $row->name ?>'><?= $row->name ?></option>
                                                                            <?php endforeach; ?>
                                                                        </select>

                                                                    </div> 
                                                                    
                                                                    <div class="col-md-2">

                                                                        <label>From Date</label>

                                                                        <input type="text" class="form-control" name="toDate" id="toDate" title="To Date" autocomplete="off">

                                                                    </div>



                                                                    <div class="col-md-2">

                                                                        <label>To Date</label>

                                                                        <input type="text" class="form-control" name="fromDate" id="fromDate" title="From Date" autocomplete="off">

                                                                    </div>

                                                                    <div class="col-md-2">

                                                                        <!--<button class="btn btn-info SearchForExport" style="background-color : #35b7c4;margin-top: 23px;"><i class="fa fa-search"></i> &nbsp;Search</button>-->

                                                                        <button class="btn btn-info " style="background-color : #35b7c4;margin-top: 23px;"><i class="fa fa-download" aria-hidden="true"></i></button>

                                                                    </div>  
                                                                    <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                                                                </form>



                                                                <!--action="<?= base_url('exportReport') ?>"-->

                                                            </div>

                                                        </div>

                                                    </div> 

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <!--Footer Start Here -->

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- footer -->

<?php $this->load->view('Layouts/footer') ?>

<?php $this->load->view('Tasks/task_js.php') ?>

<script>

    $("#toDate, #fromDate").keypress(function myfunction(event) {

        var regex = new RegExp("^[0-9?=.*!@#$%^&*]+$");               

        var key = String.fromCharCode(event.charCode ? event.which : event.charCode);

         if (!regex.test(key)) {

            event.preventDefault();

            return false;

        }    
        return false; 

    }); 

    $("#fromDate").change(function(){

        var dateTo = $("#toDate").val();

        var dateFrom = $("#fromDate").val();

        if(dateTo == "" && dateFrom == "")

        {

            $(".SearchForExport").prop('disabled', true);

        }else{

            $(".SearchForExport").prop('disabled', false);

        }

    });

    $('.search').click(function(e){

        e.preventDefault();

        const filter = $('#search').serialize();

        console.log(filter);

        $.ajax({

            url : '<?= base_url("filter") ?>',

            type : 'POST',

            dataType : "json",

            data : filter,

            // async: false,

            beforeSend: function() {

                $('#btnSearch').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Processing...').addClass('disabled', true);

            },

            success : function(response){

                $(".searchResults").html(response);

                $('#search')[0].reset();

            },

            complete: function() {

                $('#btnSearch').html('Search').removeClass('disabled'); 

            },

        });

    });

    ///////////////////////////////////////////////////////// filter and export Data ///////////////////////////////////////////////////

    

    // $(document).ready(function(){

    //     $.ajax({

    //         url : '<?= base_url("filterReportType") ?>',

    //         type : 'POST',

    //         dataType : "json",

    //         success : function(response){

    //             $('#reportType').empty();

    //             $('#reportType').html('<option value="">Reports Type</option>');

    //             $.each(response, function (i, item) {

    //                 $('#reportType').append($('<option>', { 

    //                     value: item.name,

    //                     text : item.name 

    //                 }));

    //             });

    //         }

    //     });

    // });

    

    $("#reportType").change(function(){

        var name = $(this).val();

        $.ajax({

            url : '<?= base_url("filterReportFilterType") ?>',

            type : 'POST',

            dataType : "json",

            data : {name : name},

            success : function(response){

                $('#filterType').empty();

                $('#filterType').html('<option value="">Filter Type</option>');

                $.each(response, function (i, item) {

                    $('#filterType').append($('<option>', { 

                        value: item.name,

                        text : item.name 

                    }));

                });

            }

        });

    });

    

    // $('#ExoprtFormData').submit(function(e){

    //     e.preventDefault();

    //     var filter = $('#ExoprtFormData').serialize();

    //     console.log(filter);

    //     $.ajax({

    //         url : '<?= base_url("FilterExportReports") ?>',

    //         type : 'POST',

    //         dataType : "json",

    //         data : filter,

    //         success : function(response){

    //             $(".searchResults").html(response);

    //             // $('#search')[0].reset();

    //         }

    //     });

    // });

    ///////////////////////////////////////////////////////// end filter and export Data ///////////////////////////////////////////////////



    function checkLeftAmount(amount)

    {

        var totalPayableAmount = $("#totalPayableAmount").text().replace(",", "");

        var totalReceived = $("#totalReceived").text().replace(",", "");

        var payableAmount = $("#payment_amount").val();

        var total = totalPayableAmount - totalReceived;

        

        if(payableAmount > total || payableAmount < 1 || payableAmount == total){

            $("#payment_amount").val(total);

            $('#payment_type').val("Full Payment");

        } else{

            $('#payment_type').val("Part Payment");

        }

    } 



    $(document).ready(function(){

        var totalPayableAmount = $("#totalPayableAmount").val();

        var totalReceived = $("#totalReceived").val();



        $("#payment_amount").val(totalPayableAmount - totalReceived);

        $('#payment_type').val("Full Payment");



        $('#FormRecoveryAmount').submit(function(e){

            e.preventDefault();

            $.ajax({

                url : '<?= base_url("AddCollectionAmount") ?>',

                type : 'POST',

                data : new FormData(this),

                processData : false,

                contentType : false,

                cache : false,

                async : false,

                success : function(response) {

                    if(response == "name") {

                        catchError("Payment Already Added.");

                    } else {

                        catchSuccess("Payment Added Successfully.");

                        window.location.reload();

                    }

                }

            });

        });

    });



    function MIS()

    {

        $.ajax({

            url : '<?= base_url("filter") ?>',

            type : 'POST',

            dataType : "json",

            data : filter,

            async: false,

            success : function(response){

                $(".searchResults").html(response);

                // $('#search')[0].reset();

            }

        });

    }



</script>