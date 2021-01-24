<h3><?php echo $heading_title; ?></h3>
<div class="mod_carusel">
<div id="mod_featured" class="row owl-carousel owl-theme" >
  <?php foreach ($products as $product) { ?>
  <div class="item-product-scroll col-xs-12">
    <div class="fix-height product-thumb transition">
      <div class="image transition">
		<a role="button" data-toggle="modal" id="product_link-<?php echo $product['product_id']; ?>" href="#product_<?php echo $product['product_id']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a>
		<div class="image_panel">
			<a href="<?php echo $product['href']; ?>" class="btn btn-primary btn-lg">
					<span class="fa fa-search"></span>
			</a>
		</div>
	  </div>
      <div class="caption">
          <h4><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h4>
          <div class="fix-desc"><?php echo $product['description']; ?>
            </br>
          <span class="product-read_more"><a href="<?php echo $product['href']; ?>" ><?php echo $read_more; ?></a></span>
          </div>
          <!--<?php if ($product['rating']) { ?>
          <div class="rating">
            <?php for ($i = 1; $i <= 5; $i++) { ?>
            <?php if ($product['rating'] < $i) { ?>
            <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
            <?php } else { ?>
            <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
            <?php } ?>
            <?php } ?>
          </div>
          <?php } ?>
          <!--<p class="feed-visits "><span class="glyphicon glyphicon-eye-open" title="<?php echo $text_views; ?>"></span> (<?php echo $product['viewed_total']; ?>) <span class="glyphicon glyphicon-comment" title="<?php echo $text_reviews; ?>"></span> (<?php echo $product['reviews_total']; ?>)</p>
          <?php if ($product['price']) { ?>
          <p class="price">
            <?php echo $text_price; ?>
            <?php if (!$product['special']) { ?>
            <?php echo $product['price']; ?>
            <?php } else { ?>
            <span class="price-new"><?php echo $product['special']; ?></span> <span class="price-old"><?php echo $product['price']; ?></span>
            <?php } ?>
            <?php if ($product['tax']) { ?>
            <span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
            <?php } ?>
          </p>
          <?php } ?>-->
          
        </div>
      <div class="button-group">
        <button type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-shopping-cart"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $button_cart; ?></span></button>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-exchange"></i></button>
      </div>
    </div>
  </div>

  <?php } ?>
</div>
<a href="http://www.tjanshi.com/produkciya.html" class="feed-items-link" style="font-size: 18px; font-weight: bold;"><span class="glyphicon glyphicon-tree-deciduous"> </span> <?php echo $all_products; ?></a>
</div>
	
<script type="text/javascript">
$('#mod_featured').owlCarousel({
	items: 4,
	navigation: true,
	navigationText: ['<i class="fa fa-chevron-left fa-5x"></i>', '<i class="fa fa-chevron-right fa-5x"></i>'],
	pagination: false
});


</script> 
