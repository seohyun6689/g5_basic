<?php global $bo_table, $w; ?>
<div id="subTitle">
	<h2 class="conWrap bg<?php echo $this->current_lnb['me_code']; ?>"><?php echo $this->title; ?></h2>
</div>


<div class="conWrap clearfix">


	<aside id="lnb">
		<nav id="lnb-nav" class="nav">

			<h2><span><?php echo $this->title; ?></span></h2>

			<ul>	
	<?php 
		foreach ( $this->lnb as $lnb ) : 
			if ( $lnb['me_use'] ) :
	?>					
				<li><a href="<?php echo $lnb['me_link']; ?>" target="_<?php echo $lnb['me_target']; ?>"<?php echo ( $lnb['me_code'] == $this->current_menu['me_code'] ? ' class="active" ' : '' ); ?>><?php echo $lnb['me_name']; ?></a></li>
	<?php 		
			endif; 
		endforeach; 
	?>
			</ul>
		</nav>

		<a href="/shop/list.php?ca_id=10" class="goshop"><img src="/images/sub/btn_shop.jpg"></a>

	</aside>




	<div id="content">


		<div id="container_title"><?php echo $this->current_menu['me_name'] ?></div>


		<nav id="content-navigation">
			<ul class="clearfix">
				<li><a href="/" class="home"><i class="fa fa-home"></i></a></li>
				<li><a href="<?php echo $this->current_lnb['me_link']; ?>"><?php echo $this->current_lnb['me_name']; ?></a></li>
				<li><?php echo $this->current_menu['me_name']; ?></li>
			</ul>
		</nav>