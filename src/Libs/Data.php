<?php

namespace Caydeesoft\SafaricomData\Libs;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;


class Data
    {
        public $header  =   ['Content-Type'=>'application/json'];
        public $saflink;
        public function setHeader($header=[])
            {
                $this->header =  array_merge($this->header,$header);
            }
        public function setSaflink()
            {
                $this->saflink = (env('APP_ENV') === 'local')?'https://apistg.safaricom.co.ke/':'https://api.safaricom.co.ke/';
            }
        public function get_token()
            {
                $credentials    =   base64_encode(config('data.consumerkey').':'.config('data.consumersecret'));
                $this->setHeader(['Authorization'=>'Basic '.$credentials]);

                $data           =   Http::withHeaders($this->header)
                                        ->withOptions(['verify' => app_path("Resources/cacert.pem"), 'http_errors' => false])
                                        ->get($this->saflink.config('data.tokenurl'));

                if($data->successful())
                    {
                        return $data->object();
                    }
            }
        public function multiredeem($request)
            {
                $this->setHeader([
                                    "SourceSystem"=>"APIGEE",
                                    "Content-Type"=>"application/json",
                                    "Accept-Language"=>"EN",
                                    "X-Source-CountryCode"=>"KE",
                                    "X-Source-Operator"=>"Safaricom",
                                    "X-Source-Division"=>"Consumer",
                                    "X-Source-System"=>"APG",
                                    "X-Source-Timestamp"=>Carbon::now('Africa/Nairobi')->getTimestamp(),
                                    "X-Source-Identity-Token-0"=>"OAuth",
                                    "X-MessageID"=>Str::uuid()->toString(),
                                    "Accept-Encoding"=>"application/json"
                                ]);
                $requestHeader                  =   new \stdClass();
                $requestHeader->SourceSystem    =   'APIGEE';
                $requestHeader->pin             =   config('data.username');
                $requestHeader->password        =   config('data.password');

                $requestBody                    =   new \stdClass();
                $requestBody->MSISDN            =   $request->msisdn;
                $requestBody->SendSMS           =   $request->sendsms;
                $requestBody->ResourceType      =   $request->resourcetype;
                $requestBody->AccountType       =   $request->accounttype;
                $requestBody->ExpiryPeriod      =   $request->expiry;
                $requestBody->RedemptionValue   =   $request->redemptionvalue;
                $requestBody->MoreInfo          =   $request->moreinfo;

                $data = Http::withHeaders($this->header)
                            ->withToken(self::get_token()->access_token)
                            ->withOptions(['verify' => app_path("Resources/cacert.pem"), 'http_errors' => false])
                            ->post($this->saflink.config('data.dataurl'),[ "ReqHeader" =>  $requestHeader,"ReqBody" => $requestBody]);
                if($data->successful())
                    {
                        return $data->object();
                    }
            }
        public function redemption($request)
            {
                $body =     [
                                "id"            => substr($request->msisdn,-9) ,
                                "description"   => $request->description ,
                                "pin"           => config('data.username') ,
                                "password"      => config('data.password')
                            ];
                $data = Http::withHeaders($this->header)
                            ->withToken($this->get_token()->access_token,'Bearer')
                            ->withOptions(['verify' => app_path("Resources/cacert.pem") , 'http_errors' => FALSE])
                            ->post($this->saflink.config('data.redemptionurl'),$body);
                if($data->successful())
                    {
                        return $data->object();
                    }
            }
        public function balance($request)
            {
                $body   =    [
                                "id"            => substr($request->msisdn,-9) ,
                                "description"   => $request->description ,
                                "pin"           => config('data.username') ,
                                "password"      => config('data.password')
                            ];
                $data   =   Http::withHeaders(["Content-Type" =>"application/json"])
                                ->withToken($this->get_token()->access_token)
                                ->withOptions(['verify' => app_path("Resources/cacert.pem"), 'http_errors' => false])
                                ->post($this->saflink.config('data.balanceurl'),$body);
                if($data->successful())
                    {
                        return $data->object();
                    }
            }
    }