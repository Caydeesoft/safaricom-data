# Safaricom Redeemable Services
This package is used to redeem data, airtime and sms bundles from safaricom. You need to request safaricom to create an application for you on the Daraja platform.
<br>
You will need a ***PRSP LICENCE*** to use this package, and activated packages on your PRSP Platform.
<br>
To install the package:
```shell
$ composer require caydeesoft/safaricom-data
```
Thereafter you will need to generate the config file, the file name will be ***data.php***.

```shell
$ php artisan vendor:publish --provider="Caydeesoft\SafaricomData\DataServiceProvider" --tag="data-config"
```
on the ***env*** file you will add
```env 
DATA_USERNAME=
DATA_PASSWORD=
DATA_CONSUMER_KEY=
DATA_CONSUMER_SECRET=
```
# FEATURES
 
## 1. Check Balance

```php
<?php
namespace App\Http\Controllers;

use Caydeesoft\SafaricomData\Libs\Data;
class DataController{
public function check_balance()
    {
        $data                   =   new Data();
        $request                =   new \StdClass();
        $request->msisdn        =   '711111111';
        $request->description   =   'LUCKYBOX_5MIN';
        return response()->json($data->balance($request));
    }
}
```

## 2. Redeem Data

```php
<?php
namespace App\Http\Controllers;

use Caydeesoft\SafaricomData\Libs\Data;
class DataController{
public function dataredeem()
    {
        $data                   =   new Data();
        $request                =   new \StdClass();
        $request->msisdn        =   '711111111';
        $request->description   =   'LUCKYBOX_5MIN';
        return response()->json($data->redemption($request));
    }
}
```

## 3. Multi Redeem

```php
<?php
namespace App\Http\Controllers;

use Caydeesoft\SafaricomData\Libs\Data;
class DataController{
public function multiredeem()
    {
        $data                       =   new Data();
        $request                    =   new \StdClass();
        $request->msisdn            =   '711111111';
        $request->sendsms           =   'no'; //Y/N
        $request->resourcetype      =   'airtime'; //Airtime/Data/SMS
        $request->accounttype       =   4500; //Account type for the resource
        $request->expiry            =   30;
        $request->redemptionvalue   =   100;
        $request->moreinfo          =   "Awarding airtime to new customer";
        
        return response()->json($data->multiredeem($request));
    }
}
```

**_Response_**
```json
{
  "ResponseId": "26772-3722832-9",
  "ResponseCode": "4000",
  "ResponseMessage": "success",
  "DetailedMessage": "operation successfully"
}
```

