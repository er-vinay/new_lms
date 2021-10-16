<?php $this->load->view('common_front/header')?>

<div style="min-height:50px;" class="wow fadeInDown">
<!-- Jssor Slider Begin -->
<!-- To move inline styles to css file/block, please specify a class name for each element. --> 
<!-- ================================================== -->
<div id="slider1_container" style="visibility: hidden; position: relative; margin: 0 auto;
top: 0px; left: 0px; width: 1300px; height: 464px; overflow: hidden;">
<!-- Loading Screen -->
<div u="loading" style="position: absolute; top: 0px; left: 0px;">
<div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block;
top: 0px; left: 0px; width: 100%; height: 100%;">
</div>
<div style="position: absolute; display: block; background: url(<?= base_url('public/front/')?>/img/loading.gif) no-repeat center center;
top: 0px; left: 0px; width: 100%; height: 100%;">
</div>
</div>
<!-- Slides Container -->
<div u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; width: 1300px; height: 464px; overflow: hidden;">
	<?php 

		$slider=$this->db->where('status','Active')->get('media')->result_array();
		foreach($slider as $s)
		{
	?>
<div>
<img u="image" src="<?= base_url('uploads/media/'.$s['image'])?>" />

<div class="slide-content">
<h2 class="slide-color"><?= $s['title']?></h2>
<p class="slide-text"> <?= $s['content']?> </p>

<a href="<?= base_url('contact')?>" class="btn btn-default send-3"> CONTACT US </a>
 


</div> 

</div>

<?php }?>

</div>

<!--#region Bullet Navigator Skin Begin -->

<style>
/* jssor slider bullet navigator skin 21 css */
/*
.jssorb21 div           (normal)
.jssorb21 div:hover     (normal mouseover)
.jssorb21 .av           (active)
.jssorb21 .av:hover     (active mouseover)
.jssorb21 .dn           (mousedown)
*/
.jssorb21 {
position: absolute;
}
.jssorb21 div, .jssorb21 div:hover, .jssorb21 .av {
position: absolute;
/* size of bullet elment */
width: 19px;
height: 19px;
text-align: center;
line-height: 19px;
color: white;
font-size: 12px;
background: url(<?= base_url('public/front/')?>/img/b21.png) no-repeat;
overflow: hidden;
cursor: pointer;
}
.jssorb21 div { background-position: -5px -5px; }
.jssorb21 div:hover, .jssorb21 .av:hover { background-position: -35px -5px; }
.jssorb21 .av { background-position: -65px -5px; }
.jssorb21 .dn, .jssorb21 .dn:hover { background-position: -95px -5px; }
</style>
<!-- bullet navigator container -->
<div u="navigator" class="jssorb21" style="bottom: 26px; right: 6px;">
<!-- bullet navigator item prototype -->
<div u="prototype"></div>
</div>
<!--#endregion Bullet Navigator Skin End -->


<style>

.jssora21l, .jssora21r {
display: block;
position: absolute;
/* size of arrow element */
width: 55px;
height: 55px;
cursor: pointer;
background: url(<?= base_url('public/front/')?>img/a21.png) center center no-repeat;
overflow: hidden;
}
.jssora21l { background-position: -3px -33px; }
.jssora21r { background-position: -63px -33px; }
.jssora21l:hover { background-position: -123px -33px; }
.jssora21r:hover { background-position: -183px -33px; }
.jssora21l.jssora21ldn { background-position: -243px -33px; }
.jssora21r.jssora21rdn { background-position: -303px -33px; }
</style>
<!-- Arrow Left -->
<span u="arrowleft" class="jssora21l" style="top: 123px; left: 8px;">
</span>
<!-- Arrow Right -->
<span u="arrowright" class="jssora21r" style="top: 123px; right: 8px;">
</span>
<!--#endregion Arrow Navigator Skin End -->
</div>
<!-- Jssor Slider End -->
</div>

<!--------- slider close---->

<section id="welcome" class="wow fadeInDown"> 
<div class="container">
<div class="row"> 
<div class="col-md-7"> 
	<?php 
		$sec2=$this->db->where('id',1)->get('sec2')->row_array();
	?>
<div class="welcome-top">  
<h1> <?= $sec2['title']?>  </h1>
<p> <?= $sec2['content']?>  </p> 
 
<a href="<?= base_url('aboutus')?>" class="btn btn-default send">  LEARN MORE </a>

</div> 
</div>

<div class="col-md-5"> 
<div class="about"> 

<img src="<?= base_url('uploads/media/'.$sec2['image'])?>" alt="about images" width="437" height="270">


</div>
</div>
</div>
</div>
</section>


<!---- welcome close---->

<section id="services"  class="wow fadeInLeft">
<div class="container-fluid"> 
<div class="row"> 
<?php 
		$sec3=$this->db->where('id',1)->get('sec3')->row_array();
	?>
<div class="col-md-6 row-padding"> 
<div class="box-black"> 
<h2 class="text-color"> <?= $sec3['title']?> </h2> 


<p class="white"><?= $sec3['content']?>
  </p>
  
<a href="#" class="btn btn-default send-1"> LEARN MORE </a> 


</div>
</div> 
<div class="col-md-6 pading-2"> 
<div class="icon">  

<img src="<?= base_url('uploads/media/'.$sec3['image'])?>" alt=" website design" class="img-responsive">


</div> 
</div> 
</div>
</div>
</section>

<!---- swebsite design---->


<section id="web-design"  class="wow fadeInRight"> 
<div class="container">
<div class="row"> 
<div class="col-md-6"> 
<?php 
		$sec4=$this->db->where('id',1)->get('sec4')->row_array();
	?>
<div class="row"> 
<div class="col-md-2"><img src="<?= base_url('uploads/media/'.$sec4['image1'])?>" class="img-responsive"> </div> 
<div class="col-md-10"> 
<h2 class="web-test"> <?= $sec4['title1']?> </h2>
<p> <?= $sec4['content1']?> </p> 
 </div> 


</div>

<div class="row"> 
<div class="col-md-2"><img src="<?= base_url('uploads/media/'.$sec4['image2'])?>" class="img-responsive"> </div> 
<div class="col-md-10"> 
<h2 class="web-test"> <?= $sec4['title2']?> </h2>
<p> <?= $sec4['content2']?> </p> 
 </div> 


</div>
<div class="row"> 
<div class="col-md-2"><img src="<?= base_url('uploads/media/'.$sec4['image3'])?>" class="img-responsive"> </div> 
<div class="col-md-10"> 
<h2 class="web-test"> <?= $sec4['title3']?> </h2>
<p> <?= $sec4['content3']?> </p> 
 </div> 


</div>
</div>

<div class="col-md-6"> 
<div class="about"> 
<iframe width="100%" height="327" src="<?= base_url('uploads/media/'.$sec4['video']);?>"> </iframe>


</div>
</div>
</div>
</div>
</section>


<!---- websoution ---->


<section id="web-solution" class="wow fadeInDown"> 
<div class="container">
<div class="row">
 
<div class="col-md-12"> <h2 class="text-center-1"> Success Stories  </h2> 
<img src="<?= base_url('public/front/')?>images/line-34.jpg" width="58" height="3" style="margin:0 0 10px 0;" class="img-responsive">

<p style="color:#FFF;"> We  believe that only money is not solution to every problem, but unity amongst people and understanding the pain of other human being is necessary to raise another being. <br>Our programs involve</p>

<a href="<?= base_url('aboutus')?>" class=" btn btn-default send-4"> READ MORE</a> 

</div>

</div>
</div>
</section>



<!---- portfolio ---->


<section id="portfolio" class="wow fadeInDown"> 
<div class="container">
<div class="row"> 
<div class="col-md-12"> <h1 class="text-center-1"> GALLERY  </h1> </div>
<img src="<?= base_url('public/front/')?>images/icon-line.png" width="66" height="47" style="margin:0 auto 30px;" class="img-responsive">
</div>

<div class="row"> 
<?php 
		$gal=$this->db->where('status','Active')->order_by('id','desc')->limit(6)->get('logo')->result_array();
		foreach($gal as $g)
		{
?>
<div class="col-lg-4">
<a class="lightbox thumbnail" href="<?= base_url('uploads/logo/'.$g['image'])?>" data-littlelightbox-group="gallery" title="Health care farm house"><img src="<?= base_url('uploads/logo/'.$g['image'])?>" alt="WOOD POLISH DECORS"></a>
</div>

<?php }?>



</div>



</div>
</section>

<?php $this->load->view('common_front/footer')?>