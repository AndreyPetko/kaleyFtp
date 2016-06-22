@foreach($products as $product)
<div class="category-item fl">
	<div class="magnifier">
		<img src="{{ url('site/images/icon-loop.png') }}" alt="">
	</div>
	<div class="item-image">
		<img src="{{ url('product_images/' . $product->image) }}" alt="">
	</div>
	<div class="item-name">
		{{$product->name}}
	</div>
	<div class="item-bottom-line">
		<div class="item-price category">
			{{$product->price}} грн
		</div>
		<div class="item-heart fl">
			<img src="{{ url('site/images/ixon-wishlist.png') }}" alt="">
		</div>
		<div class="item-buy">
			<div class="item-buy-image">
				<img src="{{ url('site/images/icon-cart-main.png') }}" alt="">
			</div>
			<div class="item-buy-text">
				В корзину
			</div>
			<div class="item-buy-shadow"></div>
		</div>
	</div>
</div>
@endforeach
<?php echo $products->render(); ?>