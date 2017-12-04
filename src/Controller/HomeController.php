<?php

namespace App\Controller;

use App\Service\User\UserRepository;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * HomeController
 */
class HomeController extends AbstractController
{
    /**
     * @Inject
     * @var UserRepository
     */
    private $userRepo;

    /**
     * Index action
     *
     * @param Request $request
     * @param Response $response
     * @return ResponseInterface
     */
    public function indexAction(Request $request, Response $response): ResponseInterface
    {
        // Increment counter
        $counter = $this->user->get('counter', 0);
        $counter++;
        $this->user->set('counter', $counter);

        $text = [
            'Loaded successfully!' => __('Loaded successfully!')
        ];

        $viewData = $this->getViewData([
            'text' => $text,
            'counter' => $counter,
            'url' => $request->getUri(),
            'secure' => $request->getAttribute('secure') ? __('Yes') : __('No'),
        ]);

        // Render template
        return $this->render($response, 'Home/home-index.twig', $viewData);
    }

    /**
     * Action (Json)
     *
     * @param Response $response
     * @return Response Json response
     */
    public function loadAction(Response $response): ResponseInterface
    {
        $userId = $this->user->getId();
        $user = $this->userRepo->findById($userId);

        $result = [
            'message' => __('Loaded successfully!'),
            'now' => now(),
            'user' => [
                'id' => $user->id,
                'username' => $user->username
            ]
        ];

        return $response->withJson($result);
    }

    /**
     * Returns default text.
     *
     * @return array Array with translated text
     */
    protected function getText(): array
    {
        $text = parent::getText();

        $text['Current user'] = __('Current user');
        $text['User-ID'] = __('User-ID');
        $text['Username'] = __('Username');
        $text['Its'] = __("It's");

        return $text;
    }
}
