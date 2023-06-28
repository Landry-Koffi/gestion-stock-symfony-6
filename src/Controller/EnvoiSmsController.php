<?php

namespace App\Controller;

use App\Entity\EnvoiSms;
use App\Form\EnvoiSmsType;
use App\Repository\EnvoiSmsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dashboard/envoi/sms')]
class EnvoiSmsController extends AbstractController
{
    #[Route('/', name: 'app_envoi_sms_index', methods: ['GET'])]
    public function index(EnvoiSmsRepository $envoiSmsRepository): Response
    {
        return $this->render('envoi_sms/index.html.twig', [
            'envoi_sms' => $envoiSmsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_envoi_sms_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EnvoiSmsRepository $envoiSmsRepository): Response
    {
        $envoiSm = new EnvoiSms();
        $form = $this->createForm(EnvoiSmsType::class, $envoiSm);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $envoiSm->setCreatedAt(new \DateTimeImmutable('now'));
            $envoiSm->setUpdatedAt(new \DateTimeImmutable('now'));
            $envoiSmsRepository->save($envoiSm, true);

            return $this->redirectToRoute('app_envoi_sms_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('envoi_sms/new.html.twig', [
            'envoi_sm' => $envoiSm,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_envoi_sms_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EnvoiSms $envoiSm, EnvoiSmsRepository $envoiSmsRepository): Response
    {
        $form = $this->createForm(EnvoiSmsType::class, $envoiSm);
        $form->handleRequest($request);

        /*$curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.allmysms.com/sms/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\r\n    \"from\": \"LandrySMS\",\r\n    \"to\": \"2251053656528\",\r\n    \"text\": \"Hello this is a test SMS FROM REST API\\r\\nStop au 36180\",\r\n    \"date\" : \"2019-03-25 19:00:00\"\r\n}",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Basic AUTH_TOKEN",
                "Content-Type: application/json",
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }*/

        if ($form->isSubmitted() && $form->isValid()) {
            $envoiSmsRepository->save($envoiSm, true);

            return $this->redirectToRoute('app_envoi_sms_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('envoi_sms/edit.html.twig', [
            'envoi_sm' => $envoiSm,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_envoi_sms_delete', methods: ['POST'])]
    public function delete(Request $request, EnvoiSms $envoiSm, EnvoiSmsRepository $envoiSmsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$envoiSm->getId(), $request->request->get('_token'))) {
            $envoiSmsRepository->remove($envoiSm, true);
        }

        return $this->redirectToRoute('app_envoi_sms_index', [], Response::HTTP_SEE_OTHER);
    }
}
