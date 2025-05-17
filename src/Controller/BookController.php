<?php

namespace App\Controller;

use App\Repository\BookRepository;
use App\Entity\Book;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

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


    #[Route("/book/creating", name: "book_creating")]
    public function drawNumber(
    ): Response {

        return $this->render('book/create.html.twig');
    }

    #[Route('/book/create', name: 'book_create', methods: ['POST'])]
    public function createBook(
        ManagerRegistry $doctrine,
    ): Response {
        $entityManager = $doctrine->getManager();

        $book = new Book();
        $book->setTitle($_POST['title']);
        $book->setWriter($_POST['writer']);
        $book->setISBN($_POST['ISBN']);
        $book->setImage($_POST['image']);

        // tell Doctrine you want to (eventually) save the Product
        // (no queries yet)
        $entityManager->persist($book);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return $this->redirectToRoute('book_view_all');
    }

    #[Route('/book/show', name: 'book_show_all', methods: ['GET'])]
    public function showAllProduct(
        BookRepository $bookRepository
    ): Response {
        $book = $bookRepository
            ->findAll();

        return $this->json($book);
    }

    #[Route('api/library/book/{isbn}', name: 'book_by_isbn')]
    public function showBookByISBN(
        BookRepository $bookRepository,
        string $isbn
    ): Response {
        $book = $bookRepository->findBookISBN($isbn);

        return $this->json($book);
    }

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

    #[Route('/book/update/{id}', name: 'update_book', methods: ['POST'])]
    public function updateBook(
        ManagerRegistry $doctrine,
        int $id,
    ): Response {
        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Book::class)->find($id);

        if (!$book) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }
        $book->setTitle($_POST['title']);
        $book->setWriter($_POST['writer']);
        $book->setISBN($_POST['ISBN']);
        $book->setImage($_POST['image']);
        $entityManager->flush();

        return $this->redirectToRoute('book_view_all');
    }
}
