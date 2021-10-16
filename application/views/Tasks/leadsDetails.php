<style type="text/css">
    table{
        width: 100%;
    }
    table tr th, td{
        width: 25%;
    }
    table th{
        font-weight: bold;
    }
</style>
    <div class="table-responsive">
        <table class="table table-hover table-striped table-bordered">
            <tr>
                <th>Application No.</th>
                <td><?= ($leadDetails->application_no) ? $leadDetails->application_no :'-' ?></td>
                <th>CIF No.</th>
                <td><?= ($leadDetails->customer_id) ? $leadDetails->customer_id :'-' ?></td>
            </tr>
            <tr>
                <th>Borrower Type</th>
                <td><?= ($leadDetails->user_type) ? strtoupper($leadDetails->user_type) :'-' ?></td>
                <th>PAN</th>
                <td><?= ($leadDetails->pancard) ? strtoupper($leadDetails->pancard) :'-' ?></td>
            </tr>
            <tr>
                <th>Loan Applied</th>
                <td><?= ($leadDetails->loan_amount) ? round($leadDetails->loan_amount) :'-' ?></td>
                <th>Loan Tenure</th>
                <td><?= ($leadDetails->loan_amount) ? round($leadDetails->loan_amount) :'-' ?></td>
            </tr>
            <tr>
                <th>Loan Purpose</th>
                <td><?= strtoupper($leadDetails->purpose) ?></td>
                <th>First Name</th>
                <td><?= strtoupper($leadDetails->first_name) ?></td>
            </tr>
            <tr>
                <th>Middle Name</th>
                <td><?= ($leadDetails->middle_name) ? strtoupper($leadDetails->middle_name) :'-' ?></td>
                <th>Surname</th>
                <td><?= ($leadDetails->sur_name) ? strtoupper($leadDetails->sur_name) :'-' ?></td>
            </tr>
            <tr>
                <th>Gender</th>
                <td><?= ($leadDetails->gender) ? strtoupper($leadDetails->gender) :'-' ?></td>
                <th>DOB</th>
                <td><?= ($leadDetails->dob) ? date('d-m-Y', strtotime($leadDetails->dob)) :'-' ?></td>
            </tr>
            <tr>
                <th>Income Type</th>
                <td><?= ($leadDetails->income_type) ? strtoupper($leadDetails->income_type) :'-' ?></td>
                <th>Salary Mode</th>
                <td><?= ($leadDetails->salary_mode) ? $leadDetails->salary_mode :'-' ?></td>
            </tr>
            <tr>
                <th>Salary</th>
                <td><?= ($leadDetails->monthly_income) ? round($leadDetails->monthly_income) :'-' ?></td>
                <th>Obligations</th>
                <td><?= ($leadDetails->obligations) ? round($leadDetails->obligations) :'-' ?></td>
            </tr>
            <tr>
                <th>Pincode</th>
                <td><?= ($leadDetails->pincode) ? $leadDetails->pincode :'-' ?></td>
                <th>District</th>
                <td><?= ($leadDetails->city) ? strtoupper($leadDetails->city) :'-' ?></td>
                <!-- <th style="background: #ddd;">Post Office</th>
                <td style="background: #ddd;">-</td> -->
            </tr>
            <tr>
                <th>State</th>
                <td><?= ($leadDetails->state) ? strtoupper($leadDetails->state) :'-' ?></td>
                <th>Promo Code</th>
                <td><?= ($leadDetails->promocode) ? strtoupper($leadDetails->promocode) :'-' ?></td>
            </tr>
            <tr>
                <th>Mobile</th>
                <td><a href="tel:<?= $leadDetails->mobile ?>"><i class="fa fa-phone"></i></a>&nbsp;<?= ($leadDetails->mobile) ? $leadDetails->mobile :'-' ?></td>
                <th>Mobile Alternate</th>
                <td><a href="tel:<?= $leadDetails->alternate_mobile ?>"><i class="fa fa-phone"></i></a>&nbsp;<?= ($leadDetails->alternate_mobile) ? $leadDetails->alternate_mobile :'-' ?></td>
            </tr>
            <tr>
                <th>Email (Personal)</th>
                <td><a href="mailto:<?= $leadDetails->email ?>"><i class="fa fa-envelope"></i></a>&nbsp;<?= ($leadDetails->email) ? $leadDetails->email  :'-' ?></td>
                <th>Email (Office)</th>
                <td><a href="mailto:<?= $leadDetails->alternate_email ?>"><i class="fa fa-envelope"></i></a>&nbsp;<?= ($leadDetails->alternate_email) ? $leadDetails->alternate_email :'-' ?></td>
            </tr>
            <tr>
                <th>Lead Source</th>
                <td><?= ($leadDetails->source) ? strtoupper($leadDetails->source) :'-' ?></td>
                <th>Geo Coordinates</th>
                <td><?= ($leadDetails->coordinates) ? $leadDetails->coordinates :'-' ?></td>
            </tr>
            <tr>
                <th>Applied On</th>
                <td><?= ($leadDetails->created_on) ? date('d-m-Y h:i:s', strtotime($leadDetails->created_on)) :'-' ?></td>
                <th><?= ($leadDetails->ip) ? "IP Address" : "IMEI No." ?></th>
                <td><?= ($leadDetails->ip) ? $leadDetails->ip : $leadDetails->imei_no ?></td>
            </tr>
            <tr>
                <th colspan="2"></th>
                <th>Status</th>
                <td><?= ($leadDetails->status) ? $leadDetails->status :'-' ?></td>
            </tr>
            <tr>
                <th colspan="4">
                    <input type="checkbox" id="tnc1" name="t&c" class="lead-checkbox2"<?= ($leadDetails->term_and_condition == "YES") ? "checked" :'unchecked' ?> disabled>&nbsp;
                    I agree to Loanwalle's Terrms and Conditions and Privacy Policy and receive communication from Loanwalle via SMS, Email and Whatsapp.
                </th>
            </tr>
        </table>
    </div>