<div id="subTitle">
	<h2 class="conWrap bg<?php echo $this->current_lnb['me_code']; ?>"><?php echo $this->title; ?></h2>
</div>

<div class="conWrap clearfix">
	<aside id="lnb">
		<nav id="lnb-nav" class="nav">

			<h2><span><?php echo $this->title; ?></span></h2>

			<ul class="lnb1ul">	
	<?php foreach ( $this->lnb as $lnb ) : ?>					
				<li class="lnb1li<?php echo ( $lnb['me_selected'] ? ' active' : '' ); ?>"><a href="<?php echo $lnb['me_link']; ?>" target="_<?php echo $lnb['me_target']; ?>" class="lnb1a"><?php echo $lnb['me_name']; ?></a>
	<?php if (count($lnb['items']) > 0) { ?>
					<ul class="lnb2ul">
					<?php foreach($lnb['items'] as $item) { ?>						
						<li class="lnb2li<?php echo ( $item['me_selected'] ? ' active' : '' ); ?>"><a href="<?php echo $item['me_link']; ?>" target="_<?php echo $item['me_target']; ?>" class="lnb2a"><?php echo $item['me_name']; ?></a></li>
					<?php } ?>	
					</ul>
	<?php } ?>
				</li>
	<?php endforeach; ?>
			</ul>
		</nav>

	</aside>

	<div id="content">

		<div id="container_title"><?php echo $this->navi[count($this->navi)-1]['me_name'] ?></div>
		
		<!-- 네비게이션 -->
		<nav id="content-navigation">
			<ul class="clearfix">
				<li><a href="/" class="home"><i class="fa fa-home"></i></a></li>
				<?php  for($i=0; $i < count($this->navi); $i++) { ?>				
				<li class="<?php echo $this->navi[$i]['me_last']; ?>"><a href="<?php echo $this->navi[$i]['me_link']; ?>"><?php echo $this->navi[$i]['me_name']; ?></a></li>
				<?php } ?>
			</ul>
		</nav>
		<!--// 네비게이션 -->