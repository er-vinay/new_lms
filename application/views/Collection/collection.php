<?php $getVerificationdata=getVerificationdata('tbl_verification',$leadDetails->lead_id); 
//echo "<pre>";print_r($getVerificationdata);
?>
<!------- table structure for varification form ----------->





<div class="table-responsive">

<form id="insertVerification" method="post" >

<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />

        <table class="table table-hover table-striped table-bordered">

            <tr>

                <th>Loan No. </th>

                <td>NO</td>

                <th>Status</th>

                <td>NO</td>

            </tr>

            <tr>

                <th>Application No. </th>

                <td>NO</td>

                <th>CIF No </th>

                <td>NO</td>

            </tr>

            <tr>



            <tr>

                <th>Borrower Type </th>

                <td>NO</td>

                <th>Loan Applied</th>

                <td>NO</td>

            </tr>

            <tr>

            <tr>

                <th>First Name </th>

                <td> NO</td>

                <th>Middle Name </th>

                <td>NO</td>

            </tr>

            <tr>



            <tr>

                <th>Surname</th>

                <td>NO</td>

                <th>Gender</th>

                <td>NO</td>

            </tr>

           

          

        </table>

        </form>

    </div>























<!------ end for varification section ----------------------->















<div class="footer-support">

<h2 class="footer-support"><button type="button" class="btn btn-info collapse" data-toggle="collapse" data-target="#APPLOCCON">APPROVED LOCATION CONFIRMATION&nbsp;<i class="fa fa-angle-double-down"></i></button></h2>

</div>

<div id="APPLOCCON" class="collapse"> 

<!------ table for  RESIDENCE section ----------------------->



<div class="table-responsive">

        <table class="table table-hover table-striped table-bordered">

            <tr>

                <th >Present Address*</th>

                <td colspan='3'></td>

               

            </tr>

            <tr>

                <th>City </th>

                <td>NO</td>

                <th>State</th>

                <td>NO</td>

            </tr>

            <tr>



            <tr>

                <th>Pincode* </th>

                <td>NO</td>

                <th>PostOffice</th>

                <td>NO</td>

            </tr>

            <tr>

            <tr>

                <th>Present Residence Type</th>

                <td>NO</td>

                <th>Residing Since*</th>

                <td >NO</td>

            </tr>

            <tr>



            <tr>

                <th>SCM Remarks</th>

                <td colspan='3'>NO</td>

               

            </tr>

            <tr>



            <tr>

                <th colspan='4' style="text-align: center;"> <button type="Submit" id="" class="btn btn-success lead-sanction-button">Accept </button>  <button type="Submit" id="saveVarifivation" class="btn btn-success reject-button">Reject </button>    </th>

               

            </tr>

           

           

          

        </table>

    </div>

<!-- end section for the residence section ----------------->



</div>



<div class="footer-support">

<h2 class="footer-support"><button type="button" class="btn btn-info collapse" data-toggle="collapse" data-target="#RESIDENCER">FIELD VERIFICATION - RESIDENCE&nbsp;<i class="fa fa-angle-double-down"></i></button></h2>

</div>

<div id="RESIDENCER" class="collapse"> 

<!------ table for  OFFICE section ----------------------->



<div class="table-responsive">

        <table class="table table-hover table-striped table-bordered">

            <tr>

                <th>Present Address*</th>

                <td colspan='3'>NO</td>

                

            </tr>

            <tr>

                <th>City</th>

                <td>NO</td>

                <th>State</th>

                <td>NO</td>

            </tr>

            <tr>



            <tr>

                <th>Pincode </th>

                <td>NO</td>

                <th>PostOffice</th>

                <td>NO</td>

            </tr>

            <tr>

            <tr>

                <th>Present Residence Type</th>

                <td>NO</td>

                <th>Residing Since</th>

                <td>NO</td>

            </tr>

            <tr>



            <tr>

                <th>Residence CPV Initiated On</th>

                <td>NO</td>

                <th>Allocated To</th>

                <td>NO</td>

            </tr>

            <tr>



            <tr>

                <th>Allocated On</th>

                <td>NO</td>

                <th>Report Status</th>

                <td>NO</td>

            </tr>

            <tr>





            <th colspan='4' style="text-align: center;">

                <button type="Submit" id="" class="btn btn-success lead-sanction-button">Save </button> </th>

                

            </tr>

         

          

           

          

        </table>

    </div>





<!----- end section for the OFFICE section ----------------->

</div>







<div class="footer-support">

<h2 class="footer-support"><button type="button" class="btn btn-info collapse" data-toggle="collapse" data-target="#OFFICER">FIELD VERIFICATION - OFFICE&nbsp;<i class="fa fa-angle-double-down"></i></button></h2>

</div>

<div id="OFFICER" class="collapse"> 

<!------ table for  OFFICE section ----------------------->



<div class="table-responsive">

        <table class="table table-hover table-striped table-bordered">

            <tr>

                <th>Office/ Employer Name*</th>

                <td colspan='3'>NO</td>

                

            </tr>

            <tr>

                <th>Office Address*</th>

                <td colspan='3'>NO</td>

               

            </tr>

            <tr>



            <tr>

                <th>City </th>

                <td>NO</td>

                <th>State</th>

                <td>NO</td>

            </tr>

            <tr>

            <tr>

                <th>Industry </th>

                <td>NO</td>

                <th>Sector</th>

                <td>NO</td>

            </tr>

            <tr>



            <tr>

                <th>Department</th>

                <td>NO</td>

                <th>Designation</th>

                <td>NO</td>

            </tr>

            <tr>



            <tr>

                <th>Employed Since</th>

                <td>NO</td>

                <th>Present Service Tenure</th>

                <td>NO</td>

            </tr>

            <tr>



            

            <tr>

                <th>Office CPV Initiated On</th>

                <td>NO</td>

                <th>Allocate To</th>

                <td>NO</td>

            </tr>

            <tr>



            <tr>

                <th>Allocated On</th>

                <td>NO</td>

                <th>Report Status</th>

                <td>NO</td>

            </tr>

         

           

          

        </table>

    </div>

    </div>





    <div class="footer-support">

<h2 class="footer-support"><button type="button" class="btn btn-info collapse" data-toggle="collapse" data-target="#COLLECTION">FIELD VISIT - COLLECTION&nbsp;<i class="fa fa-angle-double-down"></i></button></h2>

</div>

<div id="COLLECTION" class="collapse"> 

<!------ table for  OFFICE section ----------------------->



<div class="table-responsive">

        <table class="table table-hover table-striped table-bordered">

           

          

            <tr>

                <th>Mobile </th>

                <td>NO</td>

                <th>Mobile Alternate</th>

                <td>NO</td>

            </tr>

            <tr>

            <tr>

                <th>Email (Personal) </th>

                <td>NO</td>

                <th>Email (Office)</th>

                <td>NO</td>

            </tr>

            <tr>



            <tr>

                <th>Loan Amount</th>

                <td>NO</td>

                <th>Tenure as on date</th>

                <td>NO</td>

            </tr>

            <tr>



            <tr>

                <th>ROI</th>

                <td>NO</td>

                <th>Interest as on date</th>

                <td>NO</td>

            </tr>

            <tr>



            

            <tr>

                <th>Disbursal Date</th>

                <td>NO</td>

                <th>Delay (days)</th>

                <td>NO</td>

            </tr>

            <tr>



            <tr>

                <th>Repay Date</th>

                <td>NO</td>

                <th>Late Payment Interest as on date</th>

                <td>NO</td>

            </tr>



            <tr>

                <th>Repay Amount</th>

                <td>NO</td>

                <th>Total Payable (Rs)</th>

                <td>NO</td>

            </tr>

            <tr>

                <th>Penal ROI</th>

                <td>NO</td>

                <th>Total Received (Rs)</th>

                <td>NO</td>

            </tr>



            <tr>

                <th></th>

                <td></td>

                <th>Total Due (Rs)</th>

                <td>NO</td>

            </tr>





            <tr>

                <th>Allocate To</th>

                <td></td>

                <th>Allocated On</th>

                <td>NO</td>

            </tr>

         

         

           

          

        </table>

    </div>





  

