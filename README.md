# Omnipay: Elavon

**Elavon payment processing driver for the Omnipay PHP payment processing library**

*This repo is a fork of [lxrco/omnipay-elavon](https://github.com/lxrco/omnipay-elavon) that adds support for 3D Secure and Address Verification Service parameters.*


[Omnipay](https://github.com/thephpleague/omnipay)  is a framework agnostic, multi-gateway payment processing library for PHP. This package implements Elavon Payments support for Omnipay. Please see the full [Converge documentation](https://www.myvirtualmerchant.com/VirtualMerchant/download/developerGuide.pdf) for more information.

## Installation

Omnipay is installed via [Composer](http://getcomposer.org/). To install, simply require `league/omnipay` and `vulyplay/omnipay-elavon`

```bash
composer require league/omnipay vulyplay/omnipay-elavon
```

## Basic Usage

The following gateways are provided by this package:

* Converge

```php
<?php
    $gateway = \Omnipay\Omnipay::create('Elavon_Converge')->initialize([
        'merchantId' => '000000',
        'username' => 'USERNAME',
        'password' => 'PASSWORD',
        'testMode' => true,// False by default
    ]);

    $params = array(
        'amount'                => 10.00,
        'card'                  => $card,
        'ssl_invoice_number'    => 1,
        'ssl_show_form'         => 'false',
        'ssl_result_format'     => 'ASCII',

        // 3D Secure
        'ssl_eci_ind' => '...',
        'ssl_3dsecure_value' => '...',
        'ssl_program_protocol' => '...',
        'ssl_dir_server_tran_id' => '...',
        'ssl_3ds_server_trans_id' => '...',
        'ssl_3ds_message_version' => '...',
        'ssl_3ds_trans_status' => '...',
        'ssl_3ds_trans_status_reason' => '...',

        // AVS
        'ssl_avs_address' => '...',
        'ssl_avs_zip' => '...'
    );

    $response = $gateway->purchase($params)->send();

    if ($response->isSuccessful()) {
        // successful
        $reference = $response->getTransactionReference();
        // ...
    } else {
        throw new ApplicationException($response->getMessage());
    }
```

For general usage instructions, please see the main [Omnipay](https://github.com/thephpleague/omnipay)
repository.


## Support

If you are having general issues with Omnipay, we suggest posting on
[Stack Overflow](http://stackoverflow.com/). Be sure to add the
[omnipay tag](http://stackoverflow.com/questions/tagged/omnipay) so it can be easily found.

If you want to keep up to date with release anouncements, discuss ideas for the project,
or ask more detailed questions, there is also a [mailing list](https://groups.google.com/forum/#!forum/omnipay) which
you can subscribe to.

If you believe you have found a bug, please report it using the [GitHub issue tracker](https://github.com/lachlan-vuly/omnipay-elavon/issues),
or better yet, fork the library and submit a pull request.
