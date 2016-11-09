<?php
class ModelExtensionTotalTstCodfee extends Model {
	public function getTotal($total) {
            if ((isset($this->session->data['payment_method']['code'])&&$this->session->data['payment_method']['code'] == 'tst_codfee') 
                    &&
                (isset($this->session->data['shipping_method']['code']) && $this->session->data['shipping_method']['code'] == 'tst_xlogistics.tst_xlogistics')) {
		$this->load->language('extension/total/tst_codfee');
		$total['totals'][] = array(
			'code'       => 'tst_codfee',
			'title'      => $this->language->get('text_total'),
			'value'      => $this->config->get('tst_codfee_fee'),
			'sort_order' => $this->config->get('tst_codfee_sort_order')
		);
                $total['total'] += $this->config->get('tst_codfee_fee');
            }
	}
}