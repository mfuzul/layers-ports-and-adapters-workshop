<?php
declare(strict_types=1);

namespace MeetupOrganizing\Controller;

use Doctrine\DBAL\Connection;
use Exception;
use MeetupOrganizing\CommandObject\MeetupSchedule;
use MeetupOrganizing\Entity\Meetup;
use MeetupOrganizing\Entity\MeetupRepository;
use MeetupOrganizing\Entity\ScheduledDate;
use MeetupOrganizing\Service\MeetupScheduler;
use MeetupOrganizing\Session;
use MeetupOrganizing\Validation\FormErrorCollection;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

final class ScheduleMeetupController
{
    /**
     * @var Session
     */
    private $session;

    /**
     * @var TemplateRendererInterface
     */
    private $renderer;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var MeetupRepository
     */
    private $meetupScheduler;

    public function __construct(
        Session $session,
        TemplateRendererInterface $renderer,
        RouterInterface $router,
        MeetupScheduler $meetupScheduler
    ) {
        $this->session = $session;
        $this->renderer = $renderer;
        $this->router = $router;
        $this->meetupScheduler = $meetupScheduler;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next
    ): ResponseInterface {
        $formErrors = new FormErrorCollection();
        $formData = [
            // This is a nice place to set some defaults
            'scheduleForTime' => '20:00'
        ];

        if ($request->getMethod() === 'POST') {
            $formData = $request->getParsedBody();

            $meetupSchedule = new MeetupSchedule(
                $this->session->getLoggedInUser()->userId()->asInt(),
                $formData['name'],
                $formData['description'],
                $formData['scheduleForDate'] . ' ' . $formData['scheduleForTime']
            );

            $formErrors = $meetupSchedule->validate();

            if ($formErrors->isEmpty()) {
                $meetupId = $this->meetupScheduler
                    ->schedule(
                        new MeetupSchedule(
                           $this->session->getLoggedInUser()->userId()->asInt(),
                           $formData['name'],
                           $formData['description'],
                           $formData['scheduleForDate'] . ' ' . $formData['scheduleForTime']
                        )
                    );

                $this->session->addSuccessFlash('Your meetup was scheduled successfully');

                return new RedirectResponse(
                    $this->router->generateUri(
                        'meetup_details',
                        [
                            'id' => $meetupId
                        ]
                    )
                );
            }
        }

        $response->getBody()->write(
            $this->renderer->render(
                'schedule-meetup.html.twig',
                [
                    'formData' => $formData,
                    'formErrors' => $formErrors->asArray(),
                ]
            )
        );

        return $response;
    }
}
