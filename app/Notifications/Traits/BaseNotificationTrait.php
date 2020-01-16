<?php
namespace App\Notifications\Traits;

trait BaseNotificationTrait
{

    /**
     * Wrap given parameters with global variables
     * @param  array  $params
     * @return array
     */
    public function wrapVariables($params = [])
    {
        return array_merge($this->getGlobalVariables(), $params);
    }

    /**
     * Get global notification variables
     * @return array
     */
    protected function getGlobalVariables()
    {
        return [
            'header_logo'  => url('images/logo--square.png'),
        ];
    }

    public function generatePdf($path, $order, $prefix = null, $isToCustomer)
    {
    }
}