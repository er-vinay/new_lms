<?php $this->load->view('common_front/header')?>


<div id="myCarousel" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators" style="display:none;">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
    <li data-target="#myCarousel" data-slide-to="3"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <div class="item active">
      <img src="<?= base_url('public/front/')?>image-slider/4.jpg" alt="Chania" width="2500" title="Abhilash Albums - Download" height="619" style="max-height:619px;">
      
      <div class="slide-content wow zoomIn"><h3 class="texth1"> DOWNLOAD </h3> </div> 
      
    </div>
   </div>

  <!-- Left and right controls -->
  
</div>

<!--------- slider close---->


<section id="pricing-table" style="visibility: visible; animation-name: slideInDown;"> 
<div class="container"> 
 
<div class="row">
  <?php 
    $download=$this->db->where('status','Active')->order_by('id','desc')->get('download')->result_array();
    foreach($download as $d)
    {
  ?>
<div class="col-md-4"> 
<h3>SKY REPLACMENT </h3>
<p> <a href="<?= base_url('front/download_file/'.$d['image'])?>" target="_blank" style=" text-decoration:none; color:#0771bc;" class="btn btn-default"> DOWNLOAD <i class="fa fa-download" aria-hidden="true"></i> </a> </p> 

<div class="pricing">
<div class="zoomin"> 
<img src="<?= base_url('uploads/download/'.$d['image'])?>" alt="free download">
</div>
</div> 
</div> 

<?php }?>

</div>

</div> 
</section>


<?php $this->load->view('common_front/footer')?>