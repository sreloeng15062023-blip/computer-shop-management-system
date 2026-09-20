# API Documentation & Postman Collections

This directory stores exported Postman / Insomnia collections and environment files for frontend integration testing.

## How to Use
1. Download and open [Postman](https://www.postman.com/).
2. Click **Import** and select the JSON collection in this folder (`computer_shop_api.postman_collection.json`).
3. Set the environment variable `baseUrl` to `http://localhost:8000/api`.
4. Authenticate using the `/auth/login` endpoint to automatically populate the `{{bearer_token}}`.
