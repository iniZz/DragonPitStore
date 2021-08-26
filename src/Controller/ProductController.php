<?php

namespace App\Controller;

use App\Services\ProductService;

use App\Entity\Product;
use App\Entity\Category;

use App\Form\ProductFormType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\HttpFoundation\Request;


class ProductController extends AbstractController
{
    
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;

    }
    

    /**
     * @Route(
     *     "/new",
     *     name="newproduct",
     *     
     * )
     */
    public function newproduct(Request $request, ProductService $productService): Response
    {
      $product = new Product();
      $form = $this->createForm(ProductFormType::class, $product);
      $form->handleRequest($request);
      dump($request->getLocale());

      if ($form->isSubmitted() && $form->isValid()) {
        $productService->Insert($product);
      }

      return $this->render('product/new.html.twig', [
        'form' => $form->createView(),
        'controller_name' => $request->getLocale(),
      ]);
    }


    /**
     * @Route(
     *     "/edit/{slug}",
     *     name="editProduct",
     *     
     * )
     */
    public function editProduct(Request $request, Product $productEdit): Response
    {
      $form = $this->createFormBuilder($productEdit)
      ->add('name')
            ->add('price')
            ->add('category_id')
            ->add('description')
            ->add('save', SubmitType::class, ['label' => 'Create Task'])
      ->getForm();

      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        $this->productService->Update($productEdit);
      }

      dump($request->getLocale());
      return $this->render('product/edit.html.twig', [
        'form' => $form->createView(),
        'product' => $productEdit->getName(),
      ]);
    }


    /**
     * @Route(
     *     "/{_locale}/{code}",
     *     name="category",
     *     requirements={
     *         "_locale": "en|pl|",
     *     }
     *     
     * )
     */
    public function category(Request $request,Category $category): Response
    {

      
      dump($request->getLocale());
      return $this->render('product/category.html.twig', [
        'product' => 'product',
        'category' => $category,
      ]);
    }

    /**
     * @Route(
     *     "/{_locale}/{code}/{slug}",
     *     name="product",
     *     requirements={
     *         "_locale": "en|pl|",
     *     }
     *     
     * )
     */
    public function product(Request $request,Category $category, Product $product): Response
    {

      if ($category->getId() != $product->getCategoryId()) {
        throw $this->createNotFoundException('The product does not exist'); 
      }
      dump($request->getLocale());
      return $this->render('product/index.html.twig', [
        'product' => $product,
        'category' => $category,
      ]);
    }

    
}
