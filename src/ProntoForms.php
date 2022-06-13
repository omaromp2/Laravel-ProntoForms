<?php

namespace omaromp2\laraprontoforms;

use Illuminate\Support\Facades\Http;

class ProntoForms
{
    // Build your next great package...
    public static function sendform(array $questions=[], ?string $formId = null, ?string $userId = null)
    {
        # snd the event to the event to Prontoforms.

        // Get the IDs
        $formId = (!$formId) ? config('prontoforms.form_id') : $formId;
        $userId = (!$userId) ? config('prontoforms.user_id') : $userId;

        $prontoData = collect();
        foreach ($questions as $key => $value) {
            // Pass the vals to a collection
            $prontoData->push([
                "label" => $key,
                "answer" => $value
            ]);
        }

        $prontoFile = [
            'formId' => $formId,
            'userId' => $userId,
            'data' => $prontoData
        ];


        // Snd the event to Prontoforms
        try {
            //Request a ProntoForms...

            $response = Http::withBasicAuth(config('prontoforms.user'), config('prontoforms.pass'))
            ->post('https://api.prontoforms.com/api/1.1/data/dispatch.json', $prontoFile);

            // Get the body of the response
            $res = $response->getBody();
            // Decode the body of the response
            $res = json_decode($res, true);
            return $res;

        } catch (\Throwable $th) {
            // Log in case of error.
            info($th->getMessage());

            return $th->getMessage();
        }
    }

    public static function fetchForm( $subId , ?string $formId = null, ?string $userId = null)
    {
        # retrieve form info...
        // Get the IDs
        $formId = (!$formId) ? config('prontoforms.form_id') : $formId;
        $userId = (!$userId) ? config('prontoforms.user_id') : $userId;

        if ($formId == null || $userId == null) {
            # value validation...
            throw new \Exception('Please enter a form ID or  user ID');
        }

        // Snd the event to Prontoforms
        try {
            //Request a ProntoForms...

            $response = Http::withBasicAuth(
                config('prontoforms.user'),
                config('prontoforms.pass')
            )
            ->get("https://api.prontoforms.com/api/1.1/data/". $subId ."/document.json");

            // Get the body of the response
            $res = $response->getBody();
            // Decode the body of the response
            $res = json_decode($res, true);
            return $res;
        } catch (\Throwable $th) {
            // Log in case of error.
            info($th->getMessage());
            return $th->getMessage();
        }
    }


    public static function fetchPDF( $subId , ?string $formId = null, ?string $userId = null)
    {
        # retrieve form info...
        // Get the IDs
        $formId = (!$formId) ? config('prontoforms.form_id') : $formId;
        $userId = (!$userId) ? config('prontoforms.user_id') : $userId;

        if ($formId == null || $userId == null) {
            # value validation...
            throw new \Exception('Please enter a form ID or  user ID');
        }

        // Snd the event to Prontoforms
        try {
            //Request a ProntoForms...

            $response = Http::withBasicAuth(
                config('prontoforms.user'),
                config('prontoforms.pass')
            )
            ->get("https://api.prontoforms.com/api/1/data/". $subId .".pdf");

            // // Get the body of the response
            $res = response()->make($response->getBody(), 200);
            $res->header('Content-Type', 'application/pdf');
            return $res;

        } catch (\Throwable $th) {
            // Log in case of error.
            info($th->getMessage());

            return $th->getMessage();
        }

    }


}
