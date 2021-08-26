<?php

namespace App\Controller;

use App\Entity\ProductImages;
use App\Form\ProductImageType;
use App\Services\FileUploader;
use App\Services\Converter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

use Symfony\Component\HttpFoundation\Request;
use App\Services\WebHook;

class IndexController extends AbstractController
{

    /**
    * @Route("/", name="index")
    */
    public function index(Request $request): Response
    {
      return $this->redirectToRoute('indexLocale');
    }
  
    /**
     * @Route(
     *     "/{_locale}/",
     *     name="indexLocale",
     *     requirements={
     *         "_locale": "en|pl|",
     *     }
     * )
     */
    public function indexLocale(Request $request, WebHook $wh, SluggerInterface $slugger, Converter $converter): Response
    {
      $product = new ProductImages();
      $form = $this->createForm(ProductImageType::class, $product);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
          /** @var UploadedFile $brochureFile */
          $brochureFile = $form->get('brochure')->getData();

          // this condition is needed because the 'brochure' field is not required
          // so the PDF file must be processed only when a file is uploaded
          if ($brochureFile) {
              $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
              // this is needed to safely include the file name as part of the URL
              $safeFilename = $slugger->slug($originalFilename);
              $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

              // Move the file to the directory where brochures are stored
              try {
                  
                
                // $brochureFile = $converter->Conv($brochureFile);
                 $newbrochureFile = $brochureFile->move(
                      $this->getParameter('brochures_directory'),
                      $newFilename
                  );
                  $brochureFile = $converter->Conv($this->getParameter('brochures_directory').'/'.$newFilename);
              } catch (FileException $e) {
                  // ... handle exception if something happens during file upload
              }

              // updates the 'brochureFilename' property to store the PDF file name
              // instead of its contents
              $product->setBrochureFilename($newFilename);
          }

          // ... persist the $product variable or any other work

        //   if ($form->isSubmitted() && $form->isValid()) {
        //     /** @var UploadedFile $brochureFile */
        //     $brochureFile = $form->get('brochure')->getData();
        //     if ($brochureFile) {
        //         $brochureFileName = $fileUploader->upload($brochureFile);
        //         $product->setBrochureFilename($brochureFileName);
        //     }
    
        //     // ...
        // }

        //   return $this->redirectToRoute('app_product_list');
      }

      return $this->render('index/index.html.twig', [
          'form' => $form->createView(),
          'controller_name' => $request->getLocale(),
      ]);
    }
}
