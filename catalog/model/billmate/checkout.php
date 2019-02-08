<?php
class ModelBillmateCheckout extends Model {

    /**
     * @var HelperBillmate
     */
    protected $helperBillmate;

    /**
     * ModelBillmateCheckout constructor.
     *
     * @param $registry
     */
    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->load->model('billmate/checkout/request');
        $this->helperBillmate  = new Helperbm($registry);
    }

    /**
     * @return array
     */
    public function getCheckoutData()
    {
        $checkoutData = [];

        $bmResponse = $this->model_billmate_checkout_request->getResponse();

        if (isset($bmResponse['url'])) {
            $hash = $this->helperBillmate->getHashFromUrl($bmResponse['url']);
            if ($hash) {
                $this->helperBillmate->setSessionBmHash($hash);
            }

            $checkoutData['iframe_url'] = $bmResponse['url'];
        }

        if (isset($bmResponse['PaymentData']['url'])) {
            $checkoutData['iframe_url'] = $bmResponse['PaymentData']['url'];
        }

        if (isset($bmResponse['message'])) {
            $checkoutData['error_message'] = $bmResponse['message'];
        }

        return $checkoutData;
    }
}