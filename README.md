![banner](https://banners.beyondco.de/Laravel-Prontoforms.png?theme=dark&packageManager=composer+require&packageName=omaromp2%2Flaraprontoforms&pattern=boxes&style=style_1&description=Package+for+sending+forms+to+ProntoForms&md=1&showWatermark=1&fontSize=100px&images=template)
# Laravel-ProntoForms 
Package intended for sending forms to the ProntoForms app directly from a Laravel project in a clean and simple way. 
## Installation
1. Run 
``` bash
 composer require omaromp2/laraprontoforms
```
2. Add the following line to your `.env` file:
``` code
 # ProntoForms Params
PRONTO_USER=<your_auth_prontoforms_user_name>
PRONTO_PASS=<your_auth_prontoforms_user_pass>
PRONTO_FORM_ID=<your_form_id>
PRONTO_USER_ID=<your_user_id>
```

3. Run `php artisan vendor:publish` to publish the package's config file.

## Usage 
1. Add the use case to your controller:
``` php
 use omaromp2\laraprontoforms\ProntoForms;
```
2. Prepare an array with your form label as the key and the answer as the value:
``` php
$questions = [
    'Label1' => 'Answer1',
    'Label2' => 'Answer2',
]; 
```

3. Send the form:
``` php
ProntoForms::sendForm($questions);
```

4. Check your response. 
