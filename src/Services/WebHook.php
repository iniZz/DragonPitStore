<?php


namespace App\Services;

use Symfony\Component\HttpFoundation\Response;

class WebHook{

    public function Send()
    {
        //=======================================================================================================
// Create new webhook in your Discord channel settings and copy&paste URL
//=======================================================================================================

$webhookurl = "https://discord.com/api/webhooks/852684323327967244/VvzKc7m-96KhETg2wdZ38Wm4c3QcKecZMR5P_aWS5LUc8hqHWAib9NKq5zx04xsW1b3p";

//=======================================================================================================
// Compose message. You can use Markdown
// Message Formatting -- https://discordapp.com/developers/docs/reference#message-formatting
//========================================================================================================

$timestamp = date("c", strtotime("now"));

$json_data = json_encode([
    // Message
    "content" => "Hello World! This is message line ;) And here is the mention, use userID <@397735584246005773>",
    
    // Username
    "username" => "store.smorczewski.pl",

    // Avatar URL.
    // Uncoment to replace image set in webhook
    //"avatar_url" => "https://ru.gravatar.com/userimage/28503754/1168e2bddca84fec2a63addb348c571d.jpg?size=512",

    // Text-to-speech
    "tts" => false,

    // File upload
    // "file" => "",

    // Embeds Array
    "embeds" => [
        [
            // Embed Title
            "title" => "PHP - Send message to Discord (embeds) via Webhook",

            // Embed Type
            "type" => "rich",

            // Embed Description
            "description" => "Description will be here, someday, you can mention users here also by calling userID <@12341234123412341>",

            // URL of title link
            "url" => "https://store.smorczewski.pl",

            // Timestamp of embed must be formatted as ISO8601
            "timestamp" => $timestamp,

            // Embed left border color in HEX
            "color" => hexdec( "3366ff" ),

            // Footer
            "footer" => [
                "text" => "/Mo45/cb0813cb8a6ebcd6524f6a36d4f8862c",
                "icon_url" => "https://cdn.discordapp.com/attachments/500344702562729984/727961529546309814/Logo.png"
            ],

            // Image to send
            "image" => [
                "url" => "https://cdn.discordapp.com/attachments/500344702562729984/727961529546309814/Logo.png"
            ],

            // Thumbnail
            //"thumbnail" => [
            //    "url" => "https://ru.gravatar.com/userimage/28503754/1168e2bddca84fec2a63addb348c571d.jpg?size=400"
            //],

            // Author
            "author" => [
                "name" => "store.smorczewski.pl",
                "url" => "https://store.smorczewski.pl"
            ],

            // Additional Fields array
            "fields" => [
                // Field 1
                [
                    "name" => "Field #1 Name",
                    "value" => "Field #1 Value",
                    "inline" => false
                ],
                // Field 2
                [
                    "name" => "Field #2 Name",
                    "value" => "Field #2 Value",
                    "inline" => true
                ]
                // Etc..
            ]
        ]
    ]

], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );


$ch = curl_init( $webhookurl );
curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
curl_setopt( $ch, CURLOPT_POST, 1);
curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_data);
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt( $ch, CURLOPT_HEADER, 0);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

$response = curl_exec( $ch );
// If you need to debug, or find out why you can't send message uncomment line below, and execute script.
// echo $response;
curl_close( $ch );
    }
}