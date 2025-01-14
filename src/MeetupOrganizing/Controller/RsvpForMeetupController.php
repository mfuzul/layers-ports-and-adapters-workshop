<?php
declare(strict_types=1);

namespace MeetupOrganizing\Controller;

use Doctrine\DBAL\Connection;
use MeetupOrganizing\Entity\Rsvp;
use MeetupOrganizing\Entity\RsvpRepository;
use MeetupOrganizing\Session;
use PDO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RuntimeException;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Router\RouterInterface;

final class RsvpForMeetupController
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var Session
     */
    private $session;

    /**
     * @var RsvpRepository
     */
    private $rsvpRepository;

    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(
        Connection $connection,
        Session $session,
        RsvpRepository $rsvpRepository,
        RouterInterface $router
    ) {
        $this->connection = $connection;
        $this->session = $session;
        $this->rsvpRepository = $rsvpRepository;
        $this->router = $router;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next
    ): ResponseInterface {
        $postData = $request->getParsedBody();
        if (!isset($postData['meetupId'])) {
            throw new RuntimeException('Bad request');
        }

        $record = $this->connection
            ->createQueryBuilder()
            ->select('*')
            ->from('meetups')
            ->where('meetupId = :meetupId')
            ->setParameter('meetupId', (int)$postData['meetupId'])
            ->execute()
            ->fetch(PDO::FETCH_ASSOC);

        if ($record === false) {
            throw new RuntimeException('Meetup not found');
        }

        $rsvp = Rsvp::create(
            (int)$postData['meetupId'],
            $this->session->getLoggedInUser()->userId()
        );
        $this->rsvpRepository->save($rsvp);

        $this->session->addSuccessFlash('You have successfully RSVP-ed to this meetup');

        return new RedirectResponse(
            $this->router->generateUri(
                'meetup_details',
                [
                    'id' => (int)$postData['meetupId']
                ]
            )
        );
    }
}
