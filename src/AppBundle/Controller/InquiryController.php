<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\EntityHandlers\Inquiry;
use Psr\Log\LoggerInterface;

/**
 * Class InquiryController
 * @package AppBundle\Controller
 */
class InquiryController extends FOSRestController
{
    /**
     * Persists contact form data in database after validation.
     *
     * @Rest\Post("/inquiry")
     *
     * @param Request $request
     * @param LoggerInterface $logger
     *
     * @return View
     */
    public function postAction(Request $request, LoggerInterface $logger) : View
    {

        try {
            $inquiryHandler = new Inquiry($this->getDoctrine()->getManager());
            if($inquiryHandler->create(
                [
                'email' => $request->get('email', ''),
                'message' => $request->get('message', ''),
                ]
            )) {
                $message = 'Message sent successfully.';
                $statusCode = $responseCode = Response::HTTP_OK;
            } else {
                $message = 'Something went wrong. Please try again after some time.';
                $statusCode =  Response::HTTP_INTERNAL_SERVER_ERROR  ;
                $responseCode =Response::HTTP_OK;
            }
        } catch (\InvalidArgumentException $e) {
            $message = $e->getMessage();
            $statusCode = $responseCode = Response::HTTP_BAD_REQUEST;
        } catch (\Throwable $e) {
            $logger->error($e->getMessage()); //write error to the log files
            $message = 'Something went wrong. Please try again after some time.';
            $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
            $responseCode = Response::HTTP_OK ;
        }

        return new View(
            [ 'message' => $message, 'status' => $statusCode ],
            $responseCode
        );
    }
}
