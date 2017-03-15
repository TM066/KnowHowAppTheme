<div id="wrap">
    <div class="container">
		<?php include("topbar.php"); ?>
		<div class="row editContent">

					<div class="small-12 medium-12 large-12 columns">
					   <ul class="inline-list createIcons">
						  <li class="artIcon left"><a href="/"><img src="/sites/all/themes/knowhowapp/images/App_Icons/back.svg" alt="back" onclick="history.go(-1)"/></a></li>
					   </ul>
					</div>

					   <!--------------- Team Image ------------------->
			   <div class="small-12 medium-12 large-12 columns">

							<div class="panel contents">
								<div class="small-12 medium-12 large-12 columns fullImage">

									<div class="small-12 medium-12 large-12 columns body">
										<h2 class="title">Edit</h2>

										<?php print render($page['content']); ?>
									</div>
								</div>
							 <!--------------- end ------------------->
								<p>&nbsp;</p>

					   </div>
				</div>
			</div>
			<div id="footer" >
				 <?php include("footer.php"); ?>
			</div>

	</div>
</div>
