# Facebook Login Tester

## Installation
- `make run` to start the container
- `make install-dependencies` to install all packages
- `make start-dev` to run a local server
- Set your backend parameters in `.env.development`
    - By default, the API is: `http://localhost:250/api/v1`
    - Add your facebook client

## Usage
- Navigate to `https://localhost:3000` and click the button.
- You will be prompted to login into your facebook account and after that a `POST` call will be sent to `http://localhost:250/api/v1/users/facebook/authorization` with the `accessToken` required by your API to login the user.
