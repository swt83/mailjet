<?php

namespace Travis;

class Mailjet
{
    /**
     * Method for handling API calls.
     *
     * @param   string  $apikey_public
     * @param   string  $apikey_secret
     * @param   string  $method
     * @param   string  $mode
     * @param   array   $payload
     * @param   int     $timeout
     * @return  object
     */
    public static function run($apikey_public, $apikey_secret, $method, $mode, $payload = [], $timeout=30)
    {
        // make endpoint
        $endpoint = 'https://api.mailjet.com/v3/REST/'.$method;

        // make headers
        $headers = [
            'content-type:application/json',
        ];

        // make auth
        $user = $apikey_public.':'.$apikey_secret;

        // make payload
        $payload_as_json = json_encode($payload);
        $payload_as_query = http_build_query($payload);

        // setup curl request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint.'?'.$payload_as_query);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_USERPWD, $user);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($mode));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload_as_json);
        $response = curl_exec($ch);

        // catch error...
        if (curl_errno($ch))
        {
            // report
            #$errors = curl_error($ch);

            // close
            curl_close($ch);

            // return error
            throw new \Exception('Unexpected error.');

            // return
            return false;
        }

        // close
        curl_close($ch);

        // decode response
        $response = json_decode($response);

        // catch error...
        if ((int) ex($response, 'StatusCode') >= 400)
        {
            // throw error
            throw new \Exception(ex($response, 'ErrorMessage'));

            // return false
            return false;
        }

        // return
        return $response;
    }
}