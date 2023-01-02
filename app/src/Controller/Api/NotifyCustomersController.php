<?php

namespace App\Controller\Api;

use App\Dto\NotifyCustomersRequest;
use App\Form\NotifyCustomersRequestForm;
use App\UseCases\NotifyAllCustomers\NotifyAllCustomersCommand;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class NotifyCustomersController extends AbstractFOSRestController
{
    public const ROUTE = 'api_notify_customers';

    public function __construct(private readonly MessageBusInterface $bus)
    {
    }

    /**
     * @todo add OpenAPI documentation
     *
     * Example:
     * curl -X POST "http://localhost/api/notify-customers" -H "accept: application/json" -H "Content-Type: application/json" -d "{\"message\":\"test\"}"
     *
     * there are 2 tests messages to try: "test" and "greetings"
     *
     * @param Request $request
     * @return Response
     */
    #[Route('/api/notify-customers', name: self::ROUTE, methods: ['POST'])]
    public function __invoke(Request $request): Response
    {
        $notifyCustomersRequest = new NotifyCustomersRequest();

        $form = $this
            ->createForm(NotifyCustomersRequestForm::class, $notifyCustomersRequest)
            ->submit($request->request->all());

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->handleView(View::create($form));
        }

        $this->bus->dispatch(new NotifyAllCustomersCommand($notifyCustomersRequest->getMessage()));

        return new JsonResponse(['status' => 'Sending in process.'], Response::HTTP_ACCEPTED);
    }
}