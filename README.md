# Packt Assignment

## API Documentation link

The APIs have been published on the postman. Click on [API Documentation](https://documenter.getpostman.com/view/8610000/2s93Xzyi9N#56b3c346-0d56-4dd6-90ec-5973a5429c16) to view the documentation for the APIs.

## API functionalities

- [https://packt.test/api/faker/books](https://packt.test/api/faker/books) : This API is used to fetch the books data from the faker api that has been provided in the assignment.
- [https://packt.test/api/books?page=1&perPage=9](https://packt.test/api/books?page=1&perPage=9) : This API is used to fetch the books data in the paginated form.
- [https://packt.test/api/books/131](https://packt.test/api/books/131) : This API is used to fetch the book's data using book id. Here we are using 131.
- [https://packt.test/api/books](https://packt.test/api/books) : This is a POST request to store a new book.
- [https://packt.test/api/books/211](https://packt.test/api/books/211): This is a PUT request to update the data for the book id 211.
- [https://packt.test/api/books/200](https://packt.test/api/books/200) : This API is used to DELETE the book based on the book id provided. Here we are using book id: 200
- [https://packt.test/api/books/filters](https://packt.test/api/books/filters): This is a GET request to fetch the filters data to be shown to the customer on the store.
- [https://packt.test/api/books/upload](https://packt.test/api/books/upload) : This is a POST request to upload the image to the system while creating/updating the book.

## How to run the project.

- Copy the .env.example to .env in the backend folder.
- Update the .env file with appropiate values.
- Run composer install.
- Cd to the frontend and then run yarn install.
- Then run yarn serve.
- Project will start running at localhost:8080. Port no. can vary.
- Test the system.

## Links

- Store: [http://localhost:8080/](http://localhost:8080/#/)
- Admin: [http://localhost:8080/#/books](http://localhost:8080/#/books)
