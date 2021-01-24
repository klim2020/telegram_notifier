<?php
class ControllerModuleTelegram extends Controller {
	public function index($setting) {
		$this->load->language('module/telegram');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_tax'] = $this->language->get('text_tax');

		$data['button_cart'] = $this->language->get('button_cart');
		$data['button_wishlist'] = $this->language->get('button_wishlist');
		$data['button_compare'] = $this->language->get('button_compare');
		$data['read_more'] = $this->language->get('read_more');
		$data['text_views'] = $this->language->get('text_views');
		$data['text_reviews'] = $this->language->get('text_reviews');
		$data['text_price'] = $this->language->get('text_price');
		$data['all_products'] = $this->language->get('all_products');

		$this->load->model('catalog/product');
		$this->load->model('catalog/review');
		$this->load->model('tool/image');

		$data['products'] = array();

		if (!$setting['limit']) {
			$setting['limit'] = 4;
		}

		$products = array_slice($setting['product'], 0, (int)$setting['limit']);

		foreach ($products as $product_id) {
			$product_info = $this->model_catalog_product->getProduct($product_id);

			if ($product_info) {
				if ($product_info['image']) {
					$image = $this->model_tool_image->resize($product_info['image'], $setting['width'], $setting['height']);
					$image_big = $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height'));

				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
					$image_big = $this->model_tool_image->resize('placeholder.png', $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height'));
				}

				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$price = false;
				}

				if ((float)$product_info['special']) {
					$special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$special = false;
				}

				if ($this->config->get('config_tax')) {
					$tax = $this->currency->format((float)$product_info['special'] ? $product_info['special'] : $product_info['price']);
				} else {
					$tax = false;
				}

				if ($this->config->get('config_review_status')) {
					$rating = $product_info['rating'];
				} else {
					$rating = false;
				}

				$reviews_total = $this->model_catalog_review->getTotalReviewsByProductId($product_info['product_id']);
				
				$data['products'][] = array(
					'product_id'  => $product_info['product_id'],
					'thumb'       => $image,
					'image'       => $image_big,
					'name'        => $product_info['name'],
					'description' => $this->shortDesc($product_info['description']),
					'full_description' => strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')),
					'price'       => $price,
					'special'     => $special,
					'tax'         => $tax,
					'rating'      => $rating,
					'href'        => $this->url->link('product/product', 'product_id=' . $product_info['product_id']),
					'reviews_total'	  => $reviews_total,
					'viewed_total'	  => $product_info['viewed']
				);
				
				////////////////////////////////////////////////////////////////////////////////
				
				
				$galleries = $this->model_catalog_product->getProductImages($product_info['product_id']);
				
				if($galleries){
					foreach ($galleries as $gallery) {
						$data['images'][] = array(
							'popup' => $this->model_tool_image->resize($gallery['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height')),
							'thumb' => $this->model_tool_image->resize($gallery['image'], $this->config->get('config_image_additional_width'), $this->config->get('config_image_additional_height')),
							'id' => $product_info['product_id'],
						);	
					}
				}
				
				////////////////////////////////////////////////////////////////////////////////
			}
		}

		if ($data['products']) {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/telegram.tpl')) {
				return $this->load->view($this->config->get('config_template') . '/template/module/telegram.tpl', $data);
			} else {
				return $this->load->view('default/template/module/telegram.tpl', $data);
			}
		}
	}
	
	public function shortDesc($desc){
			$desc = strip_tags(html_entity_decode($desc, ENT_QUOTES, 'UTF-8'));
			$desc = substr($desc, 0, 236);
			$desc = rtrim($desc, "!,.-");
			$desc = substr($desc, 0, strrpos($desc, ' '));
			return $desc."...";
	}
}