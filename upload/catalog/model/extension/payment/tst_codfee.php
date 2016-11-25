<?php
class ModelExtensionPaymentTSTCODFEE extends Model {
	public function getMethod($address, $total) {
		$this->load->language('extension/payment/tst_codfee');

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('tst_codfee_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

		if ($this->config->get('tst_codfee_total') > 0 && $this->config->get('tst_codfee_total') > $total) {
			$status = false;
		}  elseif (isset($this->session->data['shipping_method']['code']) && $this->session->data['shipping_method']['code'] == 'tst_xlogistics.tst_xlogistics') {
                        $status = true;  
		} elseif (!$this->cart->hasShipping()) {
			$status = false;
                } elseif (!$this->config->get('tst_codfee_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}

		$method_data = array();

		if ($status) {
			$method_data = array(
				'code'       => 'tst_codfee',
				'title'      => $this->language->get('text_title_fee'),
				'terms'      => '',
				'sort_order' => $this->config->get('tst_codfee_sort_order_fee')
			);
		}

		return $method_data;
	}
}
