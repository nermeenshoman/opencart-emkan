<?php
class Tst_bank_transfer_mail {
    public function sendMail($ob) {
        $ob->load->language('extension/payment/bank_transfer');
        $data_bank = nl2br($ob->config->get('bank_transfer_bank' . $ob->config->get('config_language_id')));
        if ($ob->customer->isLogged()) {
            $ob->load->model('account/customer');
            $customer_info = $ob->model_account_customer->getCustomer($ob->customer->getId());
            $name = $customer_info['firstname'] . ' ' . $customer_info['lastname'];
            $email = $customer_info['email'];
        } elseif (isset($ob->session->data['guest'])) {
            $name = $ob->session->data['guest']['firstname'] . ' ' . $ob->session->data['guest']['lastname'];
            $email = $ob->session->data['guest']['email'];
        }
        $ob->load->language('extension/payment/tst_bank_transfer_email');
        $message = sprintf($ob->language->get('text_dear') . $name) . ", \n\n";
        $message .= sprintf($ob->language->get('text_bank_transfer_message') . $data_bank . $ob->language->get('text_bank_transfer_message_cont')) . " \n\n";
        $message = sprintf($ob->language->get('text_thanks')) . " \n\n";

        $mail = new Mail();
        $mail->setTo($email);
        $mail->setFrom($ob->config->get('config_email'));
        $mail->setSender(html_entity_decode($name, ENT_QUOTES, 'UTF-8'));
        $mail->setSubject(sprintf($ob->language->get('text_bank_transfer_subject'), html_entity_decode($name, ENT_QUOTES, 'UTF-8')));
        $mail->setText($message);
        $mail->send();
    }

}
