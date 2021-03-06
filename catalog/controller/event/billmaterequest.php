<?php

class ControllerEventBillmaterequest extends Controller
{
    const ORDER_ID_KEY = 0;

    const STATUS_ID_KEY = 1;

    /**
     * @var Helperbm
     */
    protected $helperBillmate;

    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->helperBillmate  = new Helperbm($registry);
        $this->load->model('billmate/state/modifier');
    }

    /**
     * @param $route string
     * @param $orderData float
     * @param $action
     */
    public function process($route, $orderData , $action)
    {
        ;
        if (!$this->getHelper()->isAllowedPushEvents() ||
            !isset($this->session->data['api_id'])
        ) {
            return ;
        }

        $orderId = $orderData[self::ORDER_ID_KEY];
        $newStatusId = $orderData[self::STATUS_ID_KEY];
        $this->getStateModifier()->updateBmService($orderId, $newStatusId);
    }

    /**
     * @return ModelPaymentStateModifier
     */
    protected function getStateModifier()
    {
        return $this->model_billmate_state_modifier;
    }

    /**
     * @return Helperbm
     */
    protected function getHelper()
    {
        return $this->helperBillmate;
    }
}