<?php

namespace App\Controller;

use App\Repository\BookRepository;
use App\Entity\Book;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

final class BookController extends AbstractController
{
    /**
     * Route that shows all our other Routes for this Kmom.
     */
    #[Route('/book', name: 'app_book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    /**
     * Route that shows all our other Routes for this Kmom.
     */
    #[Route('/library', name: 'library')]
    public function library(
    ): Response {
        $routes = [
            [
                'route' => '/book/creating',
                'metod' => 'GET',
                'beskrivning' => 'See the form which we use to send data to create book',
                'name' => 'book_creating'
            ],
            [
                'route' => '/book/view',
                'metod' => 'GET',
                'beskrivning' => 'Visar en kortlek',
                'name' => 'book_view_all'
            ],
            [
                'route' => '/book/view/:isbn',
                'metod' => 'POST',
                'beskrivning' => 'View a book by its ISBN',
                'name' => 'book_view_one'
            ],
            [
                'route' => '/book/delete/:id',
                'metod' => 'POST',
                'beskrivning' => 'Delete a book by its id, in this case its the one with id 19',
                'name' => 'book_delete_by_id'
            ],
            [
                'route' => '/book/view/:isbn',
                'metod' => 'POST',
                'beskrivning' => 'View a book by its ISBN',
                'name' => 'book_view_one'
            ],
            [
                'route' => '/book/show/{id}',
                'metod' => 'POST',
                'beskrivning' => 'Show a form of a book where you can update the data in it, id (18)',
                'name' => 'show_book'
            ]
            ];

        $data = [
            'route' => $routes
        ];

        return $this->render('book/load.html.twig', $data);
    }

    /**
     * Route where we show a form where we can create a new book.
     */
    #[Route("/book/creating", name: "book_creating")]
    public function creatingBook(
    ): Response {

        return $this->render('book/create.html.twig');
    }

    /**
     * Route that takes the data from our form and makes a book out of it.
     */
    #[Route('/book/create', name: 'book_create', methods: ['POST'])]
    public function createBook(
        ManagerRegistry $doctrine,
        Request $request,
    ): Response {

        $form = $request->request->all();

        $entityManager = $doctrine->getManager();

        $book = new Book();
        $book->setTitle($form['title'])
            ->setWriter($form['writer'])
            ->setISBN($form['ISBN'])
            ->setImage($form['image']);

        // tell Doctrine you want to (eventually) save the Product
        // (no queries yet)
        $entityManager->persist($book);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return $this->redirectToRoute('book_view_all');
    }

    /**
     * Route that shows all our books in JSON.
     */
    #[Route('/book/show', name: 'book_show_all', methods: ['GET'])]
    public function showAllProduct(
        BookRepository $bookRepository
    ): Response {
        $book = $bookRepository
            ->findAll();

        return $this->json($book);
    }

    /**
     * Route that shows a book based on its isbn.
     */
    #[Route('api/library/book/{isbn}', name: 'book_by_isbn')]
    public function showBookByISBN(
        BookRepository $bookRepository,
        string $isbn
    ): Response {
        $book = $bookRepository->findBookISBN($isbn);

        return $this->json($book);
    }


    /**
     * Route where we can delete a book based on its id.
     */
    #[Route('/book/delete/{id}', name: 'book_delete_by_id')]
    public function deleteProductById(
        ManagerRegistry $doctrine,
        int $id
    ): Response {
        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Book::class)->find($id);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id '.$id
            );
        }

        $entityManager->remove($book);
        $entityManager->flush();

        return $this->redirectToRoute('book_view_all');
    }

    /**
     * Our "main" route where we get a table with all books.
     * We can create a button to get to the create form.
     * And we can also edit a book or delete it.
     */
    #[Route('/book/view', name: 'book_view_all')]
    public function viewAllBooks(
        BookRepository $bookRepository
    ): Response {
        $books = $bookRepository->findAll();

        $data = [
            'books' => $books
        ];

        return $this->render('book/view.html.twig', $data);
    }

    /**
     * Route that shows a certain book based on its isbn.
     */
    #[Route('/book/view/{isbn}', name: 'book_view_one')]
    public function viewOneBook(
        BookRepository $bookRepository,
        string $isbn
    ): Response {
        $books = $bookRepository->findBookISBN($isbn);

        $data = [
            'books' => $books
        ];

        return $this->render('book/one.html.twig', $data);
    }

    /**
     * Route where can update a book based on its id.
     * I picked id since its a unique value, otherwise
     * if you had the same isbn you could get the wrong book.
     * Its a form you update.
     */
    #[Route('/book/show/{id}', name: 'show_book')]
    public function updateOneBook(
        ManagerRegistry $doctrine,
        int $id
    ): Response {
        $entityManager = $doctrine->getManager();
        $books = $entityManager->getRepository(Book::class)->find($id);

        $data = [
            'books' => $books
        ];

        return $this->render('book/update.html.twig', $data);
    }

    /**
     * Where we take the updated data from the form and update it.
     * We then get redirected to the table where we see all books.
     */
    #[Route('/book/update/{id}', name: 'update_book', methods: ['POST'])]
    public function updateBook(
        ManagerRegistry $doctrine,
        Request $request,
        int $id,
    ): Response {
        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Book::class)->find($id);

        $form = $request->request->all();

        if (!$book) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $book->setTitle($form['title'])
            ->setWriter($form['writer'])
            ->setISBN($form['ISBN'])
            ->setImage($form['image']);
        $entityManager->flush();

        return $this->redirectToRoute('book_view_all');
    }
}
