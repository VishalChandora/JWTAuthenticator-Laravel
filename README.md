# API Routes and Description

## User Registration

**Endpoint:** `POST /user/register`

**Description:** Register a new user with the provided name, email, and password.

**Request Body:**
- `name`: The name of the user.
- `email`: The email address of the user.
- `password`: The password of the user.

**Response:**
- `201 Created`: User registered successfully.
- `422 Unprocessable Entity`: Validation failed.

---

## User Login

**Endpoint:** `POST /user/login`

**Description:** Authenticate user and generate a JWT token for further access to protected routes.

**Request Body:**
- `email`: The email address of the user.
- `password`: The password of the user.

**Response:**
- `200 OK`: User logged in successfully, returns JWT token.
- `401 Unauthorized`: Invalid login details.

---

## User Profile

**Endpoint:** `GET /user/profile`

**Description:** Retrieve the profile data of the authenticated user.

**Authorization:** JWT token in the request headers.

**Response:**
- `200 OK`: User profile retrieved successfully.
- `401 Unauthorized`: User is not authenticated.

---

## Refresh Token

**Endpoint:** `GET /user/refresh`

**Description:** Refresh the JWT token for the authenticated user.

**Authorization:** JWT token in the request headers.

**Response:**
- `200 OK`: Token refreshed successfully, returns new JWT token.
- `401 Unauthorized`: Failed to refresh token.

---

## Logout

**Endpoint:** `GET /user/logout`

**Description:** Logout the authenticated user.

**Authorization:** JWT token in the request headers.

**Response:**
- `200 OK`: User logged out successfully.
- `401 Unauthorized`: User is not authenticated.

