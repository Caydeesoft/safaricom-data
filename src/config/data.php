<?php
return [
            'tokenurl'       =>   "oauth/v1/generate?grant_type=client_credentials",
            "username"       =>   env("DATA_USERNAME"),
            "password"       =>   env("DATA_PASSWORD"),
            "consumerkey"    =>   env("DATA_CONSUMER_KEY"),
            "consumersecret" =>   env("DATA_CONSUMER_SECRET"),
            "redemptionurl"  =>   "v2/consumer-resources/auth/billing/redemptionrequest",
            "balanceurl"     =>   "/v2/consumer-resources/auth/billing/query/balance",
            "dataurl"        =>   "v1/consumer-resources/auth/billing/redemptionrequest"
       ];
