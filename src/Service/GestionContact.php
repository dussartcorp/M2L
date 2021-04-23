<?php

// src/service/gestionContact.php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Twig\Environment;
use Doctrine\Persistence\ManagerRegistry;
use \Mailjet\Resources;
use Mailjet\Client;

/**
 * Description of GestionContact
 *
 * @author Benoît
 */
class GestionContact {

//documentation : https://swiftmailer.symfony.com/docs/sending.html
    function __construct() {
        
    }

    public static function send($mailTo, $name, $subject, $content) {
        $mj = new Client('0843d33c52ad141defeeff5a94eb0081', '71bb0e7dddb6eec924f71afc00cad193', true, ['version' => 'v3.1']);

        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "alexisvedrenne482@gmail.com",
                        'Name' => "Alexis"
                    ],
                    'To' => [
                        [
                            'Email' => $mailTo,
                            'Name' => $name
                        ]
                    ],
                    'Subject' => $subject,
                    'TextPart' => "My first Mailjet email",
                    'HTMLPart' => $content,
                    'CustomID' => "AppGettingStartedTest"
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success();
    }

}