<?php

namespace Omnipay\Elavon\Message;

use Omnipay\Common\CreditCard;

/**
 * Elavon's Converge Abstract Request
 *
 * This class processes form post requests using the Elavon/Converge gateway as documented here:
 * https://resourcecentre.elavonpaymentgateway.com/index.php/download-developer-guide
 *
 * Also here: https://www.convergepay.com/converge-webapp/developer/#/welcome
 *
 * ### Test Mode
 *
 * In order to begin testing you will need the following parameters from Elavon/Converge:
 *
 * * merchantId, aka ssl_merchant_id
 * * username, aka ssl_user_id
 * * password, aka ssl_pin
 *
 * These parameters are issued for a short time only.  You need to contact Converge to request an extension
 * a few days before these parameters expire.
 *
 * ### Example
 *
 * #### Initialize Gateway
 *
 * <code>
 * //
 * // Put your gateway credentials here.
 * //
 * $credentials = array(
 *     'merchantId'        => '000000',
 *     'username'          => 'USERNAME',
 *     'password'          => 'PASSWORD'
 *     'testMode'          => true,            // Or false if you want to test production mode
 * );
 *
 * // Create a gateway object
 * // (routes to GatewayFactory::create)
 * $gateway = Omnipay::create('Elavon_Converge');
 *
 * // Initialise the gateway
 * $gateway->initialize($credentials);
 * </code>
 *
 * #### Direct Credit Card Payment
 *
 * <code>
 * // Create a credit card object
 * // The card number doesn't appear to matter in test mode.
 * $card = new CreditCard(array(
 *     'firstName'             => 'Example',
 *     'lastName'              => 'Customer',
 *     'number'                => '4444333322221111',
 *     'expiryMonth'           => '01',
 *     'expiryYear'            => '2020',
 *     'cvv'                   => '123',
 *     'billingAddress1'       => '1 Scrubby Creek Road',
 *     'billingCountry'        => 'AU',
 *     'billingCity'           => 'Scrubby Creek',
 *     'billingPostcode'       => '4999',
 *     'billingState'          => 'QLD',
 * ));
 *
 * // Do a purchase transaction on the gateway
 * try {
 *     $transaction = $gateway->purchase(array(
 *         'amount'        => '10.00',
 *         'currency'      => 'USD',
 *         'description'   => 'This is a test purchase transaction.',
 *         'card'          => $card,
 *     ));
 *     $response = $transaction->send();
 *     $data = $response->getData();
 *     echo "Gateway purchase response data == " . print_r($data, true) . "\n";
 *
 *     if ($response->isSuccessful()) {
 *         echo "Purchase transaction was successful!\n";
 *     }
 * } catch (\Exception $e) {
 *     echo "Exception caught while attempting purchase.\n";
 *     echo "Exception type == " . get_class($e) . "\n";
 *     echo "Message == " . $e->getMessage() . "\n";
 * }
 * </code>
 *
 * ### Endpoints
 *
 * The production and test endpoints are as shown below in the $testEndpoint and $liveEndpoint
 * class variables.
 *
 * ### Quirks
 *
 * Two additional parameters need to be sent with every request.  These should be set to defaults
 * in the Gateway class but in case they are not, set them to the following values as shown on
 * every transaction request before calling $transaction->send():
 *
 * <code>
 * $transaction->setSslShowForm('false');
 * $transaction->setSslResultFormat('ASCII');
 * </code>
 *
 * @link https://www.myvirtualmerchant.com/VirtualMerchant/
 * @link https://resourcecentre.elavonpaymentgateway.com/index.php/download-developer-guide
 * @see \Omnipay\Elavon\ConvergeGateway
 */
abstract class ConvergeAbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected $testEndpoint = 'https://demo.myvirtualmerchant.com/VirtualMerchantDemo';
    protected $liveEndpoint = 'https://www.myvirtualmerchant.com/VirtualMerchant';

    public function getEndpoint()
    {
        return ($this->getTestMode()) ? $this->testEndpoint : $this->liveEndpoint;
    }

    /**
     * Get the merchant ID
     *
     * @return string
     */
    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    /**
     * Set the merchant ID
     *
     * @param string $value
     * @return ConvergeAbstractRequest provides a fluent interface
     */
    public function setMerchantId($value)
    {
        return $this->setParameter('merchantId', $value);
    }

    /**
     * Get the username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->getParameter('username');
    }

    /**
     * Set the username
     *
     * @param string $value
     * @return ConvergeAbstractRequest provides a fluent interface
     */
    public function setUsername($value)
    {
        return $this->setParameter('username', $value);
    }

    /**
     * Get the password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->getParameter('password');
    }

    /**
     * Set the password
     *
     * @param string $value
     * @return ConvergeAbstractRequest provides a fluent interface
     */
    public function setPassword($value)
    {
        return $this->setParameter('password', $value);
    }

    /**
     * Get the SSL show form parameter
     *
     * @return string
     */
    public function getSslShowForm()
    {
        return $this->getParameter('ssl_show_form');
    }

    /**
     * Set the SSL show form parameter
     *
     * Should default to "true".
     *
     * @param string $value
     * @return ConvergeAbstractRequest provides a fluent interface
     */
    public function setSslShowForm($value)
    {
        return $this->setParameter('ssl_show_form', $value);
    }

    /**
     * Get the SSL result format parameter
     *
     * @return string
     */
    public function getSslResultFormat()
    {
        return $this->getParameter('ssl_result_format');
    }

    /**
     * Set the SSL result format parameter
     *
     * Should default to "ASCII".
     *
     * @param string $value
     * @return ConvergeAbstractRequest provides a fluent interface
     */
    public function setSslResultFormat($value)
    {
        return $this->setParameter('ssl_result_format', $value);
    }

    /**
     * Get the sales tax parameter
     *
     * @return string
     */
    public function getSslSalesTax()
    {
        return $this->getParameter('ssl_salestax');
    }

    /**
     * Set the sales tax parameter
     *
     * @param string $value
     * @return ConvergeAbstractRequest provides a fluent interface
     */
    public function setSslSalesTax($value)
    {
        return $this->setParameter('ssl_salestax', $value);
    }

    /**
     * Get the invoice number parameter
     *
     * @return string
     */
    public function getSslInvoiceNumber()
    {
        return $this->getParameter('ssl_invoice_number');
    }

    /**
     * Set the invoice number parameter
     *
     * @param string $value
     * @return ConvergeAbstractRequest provides a fluent interface
     */
    public function setSslInvoiceNumber($value)
    {
        return $this->setParameter('ssl_invoice_number', $value);
    }

    /**
     * Get the first name parameter
     *
     * @return string
     */
    public function getSslFirstName()
    {
        return $this->getParameter('ssl_first_name');
    }

    /**
     * Set the first name parameter
     *
     * @param string $value
     * @return ConvergeAbstractRequest provides a fluent interface
     */
    public function setSslFirstName($value)
    {
        return $this->setParameter('ssl_first_name', $value);
    }

    /**
     * Get the last name parameter
     *
     * @return string
     */
    public function getSslLastName()
    {
        return $this->getParameter('ssl_last_name');
    }

    /**
     * Set the last name parameter
     *
     * @param string $value
     * @return ConvergeAbstractRequest provides a fluent interface
     */
    public function setSslLastName($value)
    {
        return $this->setParameter('ssl_last_name', $value);
    }

    /**
     * Get the IntegrationTesting boolean value. If this is true, you can run test transactions that actually create a
     * transaction in an Elavon account so you can then run tests like a refund.
     *
     * @return bool
     */
    public function getIntegrationTesting()
    {
        return $this->getParameter('integrationTesting');
    }

    /*
     * === 3D SECURE PARAMETERS ===
     */
    public function getEciInd()
    {
        return $this->getParameter('ssl_eci_ind');
    }

    public function get3dSecureValue()
    {
        return $this->getParameter('ssl_3dsecure_value');
    }

    public function getProgramProtocol()
    {
        return $this->getParameter('ssl_program_protocol');
    }

    public function getDirServerTranId()
    {
        return $this->getParameter('ssl_dir_server_tran_id');
    }

    public function getDirServerTransId()
    {
        return $this->getParameter('ssl_3ds_server_trans_id');
    }

    public function get3dsMessageVersion()
    {
        return $this->getParameter('ssl_3ds_message_version');
    }

    public function get3dsTransStatus()
    {
        return $this->getParameter('ssl_3ds_trans_status');
    }

    public function get3dsTransStatusReason()
    {
        return $this->getParameter('ssl_3ds_trans_status_reason');
    }

    public function setEciInd($value)
    {
        return $this->setParameter('ssl_eci_ind', $value);
    }

    public function set3dSecureValue($value)
    {
        return $this->setParameter('ssl_3dsecure_value', $value);
    }

    public function setProgramProtocol($value)
    {
        return $this->setParameter('ssl_program_protocol', $value);
    }

    public function setDirServerTranId($value)
    {
        return $this->setParameter('ssl_dir_server_tran_id', $value);
    }

    public function setDirServerTransId($value)
    {
        return $this->setParameter('ssl_3ds_server_trans_id', $value);
    }

    public function set3dsMessageVersion($value)
    {
        return $this->setParameter('ssl_3ds_message_version', $value);
    }

    public function set3dsTransStatus($value)
    {
        return $this->setParameter('ssl_3ds_trans_status', $value);
    }

    public function set3dsTransStatusReason($value)
    {
        return $this->setParameter('ssl_3ds_trans_status_reason', $value);
    }

    /*
     * === AVS PARAMETERS ===
     */
    public function getAvsAddress()
    {
        return $this->getParameter('ssl_avs_address');
    }

    public function getAvsZip()
    {
        return $this->getParameter('ssl_avs_zip');
    }

    public function setAvsAddress($value)
    {
        return $this->setParameter('ssl_avs_address', $value);
    }

    public function setAvsZip($value)
    {
        return $this->setParameter('ssl_avs_zip', $value);
    }

    public function setFirstName($value)
    {
        return $this->setParameter('ssl_first_name', $value);
    }

    public function setLastName($value)
    {
        return $this->setParameter('ssl_last_name', $value);
    }

    /**
     * Set the IntegrationTesting boolean value. If this is true, you can run test transactions that actually create a
     * transaction in an Elavon account so you can then run tests like a refund.
     *
     * @param bool $value
     *
     * @return ConvergeAbstractRequest provides a fluent interface
     */
    public function setIntegrationTesting($value)
    {
        return $this->setParameter('integrationTesting', $value);
    }

    protected function createResponse($response)
    {
        return $this->response = new ConvergeResponse($this, $response);
    }

    /**
     * @return array
     */
    protected function getBaseData()
    {
        $data = array(
            'ssl_merchant_id' => $this->getMerchantId(),
            'ssl_user_id' => $this->getUsername(),
            'ssl_pin' => $this->getPassword(),
            'ssl_test_mode' => ($this->getTestMode() && !$this->getIntegrationTesting()) ? 'true' : 'false',
            'ssl_show_form' => ($this->getSslShowForm() && ($this->getSslShowForm() != 'false')) ? 'true' : 'false',
            'ssl_result_format' => $this->getSslResultFormat(),
            'ssl_invoice_number' => $this->getSslInvoiceNumber(),
        );

        if (!empty($this->get3dSecureValue())) {
            $data = array_merge($data, [
                'ssl_eci_ind' => $this->getEciInd(),
                'ssl_3dsecure_value' => $this->get3dSecureValue(),
                'ssl_program_protocol' => $this->getProgramProtocol(),
                'ssl_dir_server_tran_id' => $this->getDirServerTranId(),
                'ssl_3ds_server_trans_id' => $this->getDirServerTransId(),
                'ssl_3ds_message_version' => $this->get3dsMessageVersion(),
                'ssl_3ds_trans_status' => $this->get3dsTransStatus(),
                'ssl_3ds_trans_status_reason' => $this->get3dsTransStatusReason(),
            ]);
        }

        if (!empty($this->getAvsAddress())) {
            $data = array_merge($data, [
                'ssl_avs_address' => $this->getAvsAddress(),
                'ssl_avs_zip' => $this->getAvsZip(),
                'ssl_first_name' => $this->getSslFirstName(),
                'ssl_last_name' => $this->getSslLastName(),
            ]);
        }

        return $data;
    }

    public function sendData($data)
    {
        $httpResponse = $this->httpClient->request('POST', $this->getEndpoint() . '/process.do', [
            'Content-Type' => 'application/x-www-form-urlencoded',
        ], http_build_query($data));

        return $this->createResponse($httpResponse->getBody()->getContents());
    }
}
