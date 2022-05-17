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
}
