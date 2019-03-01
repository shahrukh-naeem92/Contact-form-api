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
     * @Rest\Post("/inquiry")
     * @param Request $request
     * @param LoggerInterface $logger
     * @return View
     */
    public function getAction(Request $request, LoggerInterface $logger)
    {
        $inquiry = new Inquiry();
        $inquiry->setEmail($request->get('email', ''));
        $inquiry->setMessage($request->get('message', ''));
        try {
            $repository = $this->getDoctrine()->getRepository(Inquiry::class);
            /** @var AppBundle\Repository\InquiryRepository $repository */
            $repository->validateInquiry($inquiry);
            $em = $this->getDoctrine()->getManager();
            $inquiry->preInsert();
            $em->persist($inquiry);
            $em->flush();
        } catch (\InvalidArgumentException $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (\Throwable $e) {
            $logger->error($e->getMessage()); //write error to the log files
            return new View('Something went wrong. Please  try again after some time.', Response::HTTP_OK);
        }

        return new View("Message sent successfully", Response::HTTP_OK);
    }
}
