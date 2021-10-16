

    <form id="formUserDocsData" method="post" enctype="multipart/form-data" style="float: left;width: 97%;margin:13px 13px 20px 0px;">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
        <input type="hidden" name="lead_id" id="lead_id" value="<?= $leadDetails->lead_id ?>">
        <input type="hidden" name="user_id" id="user_id" value="<?= $_SESSION['isUserSession']['user_id'] ?>">
        <input type="hidden" name="company_id" id="company_id" value="<?= $_SESSION['isUserSession']['company_id'] ?>">
        <input type="hidden" name="customer_id" id="customer_id" value="<?= $leadDetails->customer_id ?>">
        <div id="getDocId"></div>
        <input type="hidden" id="docuemnt_type" name="docuemnt_type" class="form-control" placeholder="Document Type" readonly="readonly" required>
        <div class="col-md-3" id="selectDocType">
            <select class="form-control" name="document_name" id="document_name" required></select>
        </div>

        <div class="col-md-3" id="selectFileType">
            <input type="file" class="form-control" name="file_name" id="file_name" accept="image/*,.jpeg, .png, .jpg,.pdf" required>
        </div>

        <div class="col-md-3">
            <input type="text" class="form-control" name="password" id="password" placeholder="Password">
        </div>

        <div class="col-md-3" id="btnDocsSave">
           <button class="btn btn-primary" id="btnSaveDocs">Save</button>
        </div></br></br> 
    </form> 

