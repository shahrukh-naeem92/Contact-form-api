<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Inquiry;
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
        $inquiry = new Inquiry();
        $inquiry->setEmail($request->get('email', ''));  //set email for inquiry
        $inquiry->setMessage($request->get('message', ''));   //set message for inquiry

        try {

            /** @var AppBundle\Repository\InquiryRepository $repository */

            $repository = $this->getDoctrine()->getRepository(Inquiry::class);
            $repository->validateInquiry($inquiry);
            $em = $this->getDoctrine()->getManager();
            $em->persist($inquiry);
            $em->flush();
        } catch (\InvalidArgumentException $e) {
            return new View(
                [ 'message' => $e->getMessage(), 'status' => Response::HTTP_BAD_REQUEST ],
                Response::HTTP_BAD_REQUEST
            );
        } catch (\Throwable $e) {
            $logger->error($e->getMessage()); //write error to the log files
            return new View(
                [
                    'message' => 'Something went wrong. Please try again after some time.',
                    'status' => Response::HTTP_INTERNAL_SERVER_ERROR  // send 500 in the message so that respective action could be performed
                ],
                Response::HTTP_OK  // send 200 as the response code
            );
        }

        return new View(
            [ 'message' => 'Message sent successfully.', 'status' => Response::HTTP_OK ],
            Response::HTTP_OK
        );
    }
}
