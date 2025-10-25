# ERP System API Documentation for Frontend Developers

## Base URL
```
http://localhost:8000/api
```

## Authentication
All protected endpoints require a Bearer token in the Authorization header:
```
Authorization: Bearer {your-token}
```

## Response Format
All API responses follow this consistent format:

### Success Response
```json
{
    "status": true,
    "message": "Success message",
    "data": { ... }
}
```

### Error Response
```json
{
    "status": false,
    "message": "Error message",
    "data": { ... }
}
```

---

## 🔐 Authentication Endpoints

### 1. Login
**POST** `/login`

**Request Body:**
```json
{
    "email": "admin@example.com",
    "password": "password"
}
```

**Response (200):**
```json
{
    "status": true,
    "message": "Login successful.",
    "data": {
        "user": {
            "id": 1,
            "name": "Super Admin",
            "email": "admin@example.com",
            "username": "superadmin",
            "phone": null,
            "mobile": null,
            "address": null,
            "country_id": null,
            "city_id": null,
            "branch_id": null,
            "country": null,
            "city": null,
            "branch": null,
            "roles": [
                {
                    "id": 1,
                    "name": "Super Admin",
                    "guard_name": "web"
                }
            ]
        },
        "token": "1|abcdef1234567890abcdef1234567890abcdef1234567890",
        "token_type": "Bearer"
    }
}
```

**Error Response (401):**
```json
{
    "status": false,
    "message": "Invalid credentials.",
    "data": null
}
```

### 2. Logout
**POST** `/logout`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "status": true,
    "message": "Logout successful.",
    "data": null
}
```

### 3. Get Current User
**GET** `/me`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "status": true,
    "message": "User retrieved successfully.",
    "data": {
        "id": 1,
        "name": "Super Admin",
        "email": "admin@example.com",
        "username": "superadmin",
        "phone": null,
        "mobile": null,
        "address": null,
        "country_id": null,
        "city_id": null,
        "branch_id": null,
        "country": null,
        "city": null,
        "branch": null,
        "roles": [
            {
                "id": 1,
                "name": "Super Admin",
                "guard_name": "web"
            }
        ]
    }
}
```

### 4. Super Admin Impersonation
**POST** `/impersonate/{user_id}`

**Headers:** `Authorization: Bearer {token}` (Super Admin only)

**Response (200):**
```json
{
    "status": true,
    "message": "Impersonation successful.",
    "data": {
        "user": {
            "id": 2,
            "name": "John Doe",
            "email": "john@example.com",
            "username": "johndoe",
            "phone": "+1-555-0123",
            "mobile": "+1-555-0124",
            "address": "123 User St",
            "country_id": 1,
            "city_id": 1,
            "branch_id": 1,
            "country": {
                "id": 1,
                "name": "United States"
            },
            "city": {
                "id": 1,
                "name": "New York"
            },
            "branch": {
                "id": 1,
                "name": "Main Branch"
            },
            "roles": [
                {
                    "id": 4,
                    "name": "Cashier",
                    "guard_name": "web"
                }
            ]
        },
        "token": "2|xyz789abcdef1234567890abcdef1234567890",
        "token_type": "Bearer",
        "impersonated": true
    }
}
```

**Error Response (403):**
```json
{
    "status": false,
    "message": "Unauthorized. Only Super Admin can impersonate users.",
    "data": null
}
```

---

## 🌍 Country Endpoints

### 1. Get All Countries
**GET** `/countries`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "status": true,
    "message": "Countries retrieved successfully.",
    "data": [
        {
            "id": 1,
            "name": "United States",
            "status": true,
            "created_at": "2025-10-25T08:35:00.000000Z",
            "updated_at": "2025-10-25T08:35:00.000000Z",
            "cities": [
                {
                    "id": 1,
                    "name": "New York",
                    "status": true
                }
            ]
        },
        {
            "id": 2,
            "name": "Canada",
            "status": true,
            "created_at": "2025-10-25T08:35:00.000000Z",
            "updated_at": "2025-10-25T08:35:00.000000Z",
            "cities": []
        }
    ]
}
```

### 2. Create Country
**POST** `/countries`

**Headers:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
    "name": "United Kingdom",
    "status": true
}
```

**Response (201):**
```json
{
    "status": true,
    "message": "Country created successfully.",
    "data": {
        "id": 3,
        "name": "United Kingdom",
        "status": true,
        "created_at": "2025-10-25T08:35:00.000000Z",
        "updated_at": "2025-10-25T08:35:00.000000Z"
    }
}
```

**Validation Error (422):**
```json
{
    "status": false,
    "message": "Validation Error",
    "data": {
        "name": ["The name field is required."]
    }
}
```

### 3. Get Single Country
**GET** `/countries/{id}`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "status": true,
    "message": "Country retrieved successfully.",
    "data": {
        "id": 1,
        "name": "United States",
        "status": true,
        "created_at": "2025-10-25T08:35:00.000000Z",
        "updated_at": "2025-10-25T08:35:00.000000Z",
        "cities": [
            {
                "id": 1,
                "name": "New York",
                "status": true
            }
        ]
    }
}
```

### 4. Update Country
**PUT** `/countries/{id}`

**Headers:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
    "name": "United States of America",
    "status": true
}
```

**Response (200):**
```json
{
    "status": true,
    "message": "Country updated successfully.",
    "data": {
        "id": 1,
        "name": "United States of America",
        "status": true,
        "created_at": "2025-10-25T08:35:00.000000Z",
        "updated_at": "2025-10-25T08:35:00.000000Z"
    }
}
```

### 5. Delete Country
**DELETE** `/countries/{id}`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "status": true,
    "message": "Country deleted successfully.",
    "data": null
}
```

**Error Response (404):**
```json
{
    "status": false,
    "message": "Country not found.",
    "data": null
}
```

---

## 🏙️ City Endpoints

### 1. Get All Cities
**GET** `/cities`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "status": true,
    "message": "Cities retrieved successfully.",
    "data": [
        {
            "id": 1,
            "country_id": 1,
            "name": "New York",
            "status": true,
            "created_at": "2025-10-25T08:35:00.000000Z",
            "updated_at": "2025-10-25T08:35:00.000000Z",
            "country": {
                "id": 1,
                "name": "United States",
                "status": true
            }
        },
        {
            "id": 2,
            "country_id": 1,
            "name": "Los Angeles",
            "status": true,
            "created_at": "2025-10-25T08:35:00.000000Z",
            "updated_at": "2025-10-25T08:35:00.000000Z",
            "country": {
                "id": 1,
                "name": "United States",
                "status": true
            }
        }
    ]
}
```

### 2. Create City
**POST** `/cities`

**Headers:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
    "country_id": 1,
    "name": "Chicago",
    "status": true
}
```

**Response (201):**
```json
{
    "status": true,
    "message": "City created successfully.",
    "data": {
        "id": 3,
        "country_id": 1,
        "name": "Chicago",
        "status": true,
        "created_at": "2025-10-25T08:35:00.000000Z",
        "updated_at": "2025-10-25T08:35:00.000000Z",
        "country": {
            "id": 1,
            "name": "United States",
            "status": true
        }
    }
}
```

**Validation Error (422):**
```json
{
    "status": false,
    "message": "Validation Error",
    "data": {
        "country_id": ["The country id field is required."],
        "name": ["The name field is required."]
    }
}
```

### 3. Get Single City
**GET** `/cities/{id}`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "status": true,
    "message": "City retrieved successfully.",
    "data": {
        "id": 1,
        "country_id": 1,
        "name": "New York",
        "status": true,
        "created_at": "2025-10-25T08:35:00.000000Z",
        "updated_at": "2025-10-25T08:35:00.000000Z",
        "country": {
            "id": 1,
            "name": "United States",
            "status": true
        }
    }
}
```

### 4. Update City
**PUT** `/cities/{id}`

**Headers:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
    "country_id": 1,
    "name": "New York City",
    "status": true
}
```

### 5. Delete City
**DELETE** `/cities/{id}`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "status": true,
    "message": "City deleted successfully.",
    "data": null
}
```

---

## 🏢 Company Endpoints

### 1. Get All Companies
**GET** `/companies`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "status": true,
    "message": "Companies retrieved successfully.",
    "data": [
        {
            "id": 1,
            "name": "Acme Corporation",
            "email": "contact@acme.com",
            "phone": "+1-555-0123",
            "address": "123 Business St, New York, NY 10001",
            "logo": null,
            "ntn": "123456789",
            "country_id": 1,
            "city_id": 1,
            "status": true,
            "created_at": "2025-10-25T08:35:00.000000Z",
            "updated_at": "2025-10-25T08:35:00.000000Z",
            "country": {
                "id": 1,
                "name": "United States",
                "status": true
            },
            "city": {
                "id": 1,
                "name": "New York",
                "status": true
            },
            "branches": [
                {
                    "id": 1,
                    "name": "Main Branch",
                    "email": "main@acme.com",
                    "status": true
                }
            ]
        }
    ]
}
```

### 2. Create Company
**POST** `/companies`

**Headers:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
    "name": "Tech Solutions Inc",
    "email": "info@techsolutions.com",
    "phone": "+1-555-0456",
    "address": "456 Innovation Ave, Los Angeles, CA 90210",
    "logo": null,
    "ntn": "987654321",
    "country_id": 1,
    "city_id": 2,
    "status": true
}
```

**Response (201):**
```json
{
    "status": true,
    "message": "Company created successfully.",
    "data": {
        "id": 2,
        "name": "Tech Solutions Inc",
        "email": "info@techsolutions.com",
        "phone": "+1-555-0456",
        "address": "456 Innovation Ave, Los Angeles, CA 90210",
        "logo": null,
        "ntn": "987654321",
        "country_id": 1,
        "city_id": 2,
        "status": true,
        "created_at": "2025-10-25T08:35:00.000000Z",
        "updated_at": "2025-10-25T08:35:00.000000Z",
        "country": {
            "id": 1,
            "name": "United States",
            "status": true
        },
        "city": {
            "id": 2,
            "name": "Los Angeles",
            "status": true
        },
        "branches": []
    }
}
```

**Validation Error (422):**
```json
{
    "status": false,
    "message": "Validation Error",
    "data": {
        "name": ["The name field is required."],
        "email": ["The email field is required.", "The email has already been taken."],
        "country_id": ["The country id field is required."],
        "city_id": ["The city id field is required."]
    }
}
```

### 3. Get Single Company
**GET** `/companies/{id}`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "status": true,
    "message": "Company retrieved successfully.",
    "data": {
        "id": 1,
        "name": "Acme Corporation",
        "email": "contact@acme.com",
        "phone": "+1-555-0123",
        "address": "123 Business St, New York, NY 10001",
        "logo": null,
        "ntn": "123456789",
        "country_id": 1,
        "city_id": 1,
        "status": true,
        "created_at": "2025-10-25T08:35:00.000000Z",
        "updated_at": "2025-10-25T08:35:00.000000Z",
        "country": {
            "id": 1,
            "name": "United States",
            "status": true
        },
        "city": {
            "id": 1,
            "name": "New York",
            "status": true
        },
        "branches": [
            {
                "id": 1,
                "name": "Main Branch",
                "email": "main@acme.com",
                "status": true
            }
        ]
    }
}
```

### 4. Update Company
**PUT** `/companies/{id}`

**Headers:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
    "name": "Acme Corporation Ltd",
    "email": "contact@acme.com",
    "phone": "+1-555-0123",
    "address": "123 Business St, New York, NY 10001",
    "logo": null,
    "ntn": "123456789",
    "country_id": 1,
    "city_id": 1,
    "status": true
}
```

### 5. Delete Company
**DELETE** `/companies/{id}`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "status": true,
    "message": "Company deleted successfully.",
    "data": null
}
```

---

## 🏪 Branch Endpoints

### 1. Get All Branches
**GET** `/branches`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "status": true,
    "message": "Branches retrieved successfully.",
    "data": [
        {
            "id": 1,
            "company_id": 1,
            "name": "Main Branch",
            "email": "main@acme.com",
            "phone": "+1-555-0123",
            "mobile": "+1-555-0124",
            "address": "123 Business St, New York, NY 10001",
            "logo": null,
            "ntn": "123456789",
            "country_id": 1,
            "city_id": 1,
            "status": true,
            "created_at": "2025-10-25T08:35:00.000000Z",
            "updated_at": "2025-10-25T08:35:00.000000Z",
            "company": {
                "id": 1,
                "name": "Acme Corporation",
                "email": "contact@acme.com"
            },
            "country": {
                "id": 1,
                "name": "United States"
            },
            "city": {
                "id": 1,
                "name": "New York"
            },
            "terminals": [
                {
                    "id": 1,
                    "name": "Terminal 001",
                    "mac_address": "00:11:22:33:44:55",
                    "serial_no": "T001-2025-001",
                    "status": true
                }
            ],
            "users": [
                {
                    "id": 2,
                    "name": "John Doe",
                    "email": "john@example.com",
                    "username": "johndoe"
                }
            ]
        }
    ]
}
```

### 2. Create Branch
**POST** `/branches`

**Headers:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
    "company_id": 1,
    "name": "Downtown Branch",
    "email": "downtown@acme.com",
    "phone": "+1-555-0125",
    "mobile": "+1-555-0126",
    "address": "789 Main St, New York, NY 10002",
    "logo": null,
    "ntn": "123456789",
    "country_id": 1,
    "city_id": 1,
    "status": true
}
```

**Response (201):**
```json
{
    "status": true,
    "message": "Branch created successfully.",
    "data": {
        "id": 2,
        "company_id": 1,
        "name": "Downtown Branch",
        "email": "downtown@acme.com",
        "phone": "+1-555-0125",
        "mobile": "+1-555-0126",
        "address": "789 Main St, New York, NY 10002",
        "logo": null,
        "ntn": "123456789",
        "country_id": 1,
        "city_id": 1,
        "status": true,
        "created_at": "2025-10-25T08:35:00.000000Z",
        "updated_at": "2025-10-25T08:35:00.000000Z",
        "company": {
            "id": 1,
            "name": "Acme Corporation",
            "email": "contact@acme.com"
        },
        "country": {
            "id": 1,
            "name": "United States"
        },
        "city": {
            "id": 1,
            "name": "New York"
        },
        "terminals": [],
        "users": []
    }
}
```

### 3. Get Single Branch
**GET** `/branches/{id}`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "status": true,
    "message": "Branch retrieved successfully.",
    "data": {
        "id": 1,
        "company_id": 1,
        "name": "Main Branch",
        "email": "main@acme.com",
        "phone": "+1-555-0123",
        "mobile": "+1-555-0124",
        "address": "123 Business St, New York, NY 10001",
        "logo": null,
        "ntn": "123456789",
        "country_id": 1,
        "city_id": 1,
        "status": true,
        "created_at": "2025-10-25T08:35:00.000000Z",
        "updated_at": "2025-10-25T08:35:00.000000Z",
        "company": {
            "id": 1,
            "name": "Acme Corporation",
            "email": "contact@acme.com"
        },
        "country": {
            "id": 1,
            "name": "United States"
        },
        "city": {
            "id": 1,
            "name": "New York"
        },
        "terminals": [
            {
                "id": 1,
                "name": "Terminal 001",
                "mac_address": "00:11:22:33:44:55",
                "serial_no": "T001-2025-001",
                "status": true
            }
        ],
        "users": [
            {
                "id": 2,
                "name": "John Doe",
                "email": "john@example.com",
                "username": "johndoe"
            }
        ]
    }
}
```

### 4. Update Branch
**PUT** `/branches/{id}`

**Headers:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
    "company_id": 1,
    "name": "Main Branch Updated",
    "email": "main@acme.com",
    "phone": "+1-555-0123",
    "mobile": "+1-555-0124",
    "address": "123 Business St, New York, NY 10001",
    "logo": null,
    "ntn": "123456789",
    "country_id": 1,
    "city_id": 1,
    "status": true
}
```

### 5. Delete Branch
**DELETE** `/branches/{id}`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "status": true,
    "message": "Branch deleted successfully.",
    "data": null
}
```

---

## 💻 Terminal Endpoints

### 1. Get All Terminals
**GET** `/terminals`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "status": true,
    "message": "Terminals retrieved successfully.",
    "data": [
        {
            "id": 1,
            "branch_id": 1,
            "name": "Terminal 001",
            "mac_address": "00:11:22:33:44:55",
            "serial_no": "T001-2025-001",
            "status": true,
            "created_at": "2025-10-25T08:35:00.000000Z",
            "updated_at": "2025-10-25T08:35:00.000000Z",
            "branch": {
                "id": 1,
                "name": "Main Branch",
                "company_id": 1
            }
        }
    ]
}
```

### 2. Create Terminal
**POST** `/terminals`

**Headers:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
    "branch_id": 1,
    "name": "Terminal 002",
    "mac_address": "00:11:22:33:44:66",
    "serial_no": "T002-2025-001",
    "status": true
}
```

**Response (201):**
```json
{
    "status": true,
    "message": "Terminal created successfully.",
    "data": {
        "id": 2,
        "branch_id": 1,
        "name": "Terminal 002",
        "mac_address": "00:11:22:33:44:66",
        "serial_no": "T002-2025-001",
        "status": true,
        "created_at": "2025-10-25T08:35:00.000000Z",
        "updated_at": "2025-10-25T08:35:00.000000Z",
        "branch": {
            "id": 1,
            "name": "Main Branch",
            "company_id": 1
        }
    }
}
```

**Validation Error (422):**
```json
{
    "status": false,
    "message": "Validation Error",
    "data": {
        "mac_address": ["The mac address has already been taken."],
        "serial_no": ["The serial no has already been taken."]
    }
}
```

### 3. Get Single Terminal
**GET** `/terminals/{id}`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "status": true,
    "message": "Terminal retrieved successfully.",
    "data": {
        "id": 1,
        "branch_id": 1,
        "name": "Terminal 001",
        "mac_address": "00:11:22:33:44:55",
        "serial_no": "T001-2025-001",
        "status": true,
        "created_at": "2025-10-25T08:35:00.000000Z",
        "updated_at": "2025-10-25T08:35:00.000000Z",
        "branch": {
            "id": 1,
            "name": "Main Branch",
            "company_id": 1
        }
    }
}
```

### 4. Update Terminal
**PUT** `/terminals/{id}`

**Headers:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
    "branch_id": 1,
    "name": "Terminal 001 Updated",
    "mac_address": "00:11:22:33:44:55",
    "serial_no": "T001-2025-001",
    "status": false
}
```

### 5. Delete Terminal
**DELETE** `/terminals/{id}`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "status": true,
    "message": "Terminal deleted successfully.",
    "data": null
}
```

---

## 👥 User Endpoints

### 1. Get All Users
**GET** `/users`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "status": true,
    "message": "Users retrieved successfully.",
    "data": [
        {
            "id": 1,
            "name": "Super Admin",
            "email": "admin@example.com",
            "username": "superadmin",
            "phone": null,
            "mobile": null,
            "address": null,
            "country_id": null,
            "city_id": null,
            "branch_id": null,
            "created_at": "2025-10-25T08:35:00.000000Z",
            "updated_at": "2025-10-25T08:35:00.000000Z",
            "country": null,
            "city": null,
            "branch": null,
            "roles": [
                {
                    "id": 1,
                    "name": "Super Admin",
                    "guard_name": "web"
                }
            ]
        },
        {
            "id": 2,
            "name": "John Doe",
            "email": "john@example.com",
            "username": "johndoe",
            "phone": "+1-555-0123",
            "mobile": "+1-555-0124",
            "address": "123 User St, New York, NY 10001",
            "country_id": 1,
            "city_id": 1,
            "branch_id": 1,
            "created_at": "2025-10-25T08:35:00.000000Z",
            "updated_at": "2025-10-25T08:35:00.000000Z",
            "country": {
                "id": 1,
                "name": "United States"
            },
            "city": {
                "id": 1,
                "name": "New York"
            },
            "branch": {
                "id": 1,
                "name": "Main Branch"
            },
            "roles": [
                {
                    "id": 4,
                    "name": "Cashier",
                    "guard_name": "web"
                }
            ]
        }
    ]
}
```

### 2. Create User
**POST** `/users`

**Headers:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
    "name": "Jane Smith",
    "email": "jane@example.com",
    "password": "password123",
    "phone": "+1-555-0127",
    "mobile": "+1-555-0128",
    "address": "456 User Ave, New York, NY 10002",
    "country_id": 1,
    "city_id": 1,
    "username": "janesmith",
    "branch_id": 1,
    "roles": ["Branch Manager"]
}
```

**Response (201):**
```json
{
    "status": true,
    "message": "User created successfully.",
    "data": {
        "id": 3,
        "name": "Jane Smith",
        "email": "jane@example.com",
        "username": "janesmith",
        "phone": "+1-555-0127",
        "mobile": "+1-555-0128",
        "address": "456 User Ave, New York, NY 10002",
        "country_id": 1,
        "city_id": 1,
        "branch_id": 1,
        "created_at": "2025-10-25T08:35:00.000000Z",
        "updated_at": "2025-10-25T08:35:00.000000Z",
        "country": {
            "id": 1,
            "name": "United States"
        },
        "city": {
            "id": 1,
            "name": "New York"
        },
        "branch": {
            "id": 1,
            "name": "Main Branch"
        },
        "roles": [
            {
                "id": 3,
                "name": "Branch Manager",
                "guard_name": "web"
            }
        ]
    }
}
```

**Validation Error (422):**
```json
{
    "status": false,
    "message": "Validation Error",
    "data": {
        "name": ["The name field is required."],
        "email": ["The email field is required.", "The email has already been taken."],
        "password": ["The password field is required."],
        "username": ["The username has already been taken."]
    }
}
```

### 3. Get Single User
**GET** `/users/{id}`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "status": true,
    "message": "User retrieved successfully.",
    "data": {
        "id": 2,
        "name": "John Doe",
        "email": "john@example.com",
        "username": "johndoe",
        "phone": "+1-555-0123",
        "mobile": "+1-555-0124",
        "address": "123 User St, New York, NY 10001",
        "country_id": 1,
        "city_id": 1,
        "branch_id": 1,
        "created_at": "2025-10-25T08:35:00.000000Z",
        "updated_at": "2025-10-25T08:35:00.000000Z",
        "country": {
            "id": 1,
            "name": "United States"
        },
        "city": {
            "id": 1,
            "name": "New York"
        },
        "branch": {
            "id": 1,
            "name": "Main Branch"
        },
        "roles": [
            {
                "id": 4,
                "name": "Cashier",
                "guard_name": "web"
            }
        ]
    }
}
```

### 4. Update User
**PUT** `/users/{id}`

**Headers:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
    "name": "John Doe Updated",
    "email": "john@example.com",
    "password": "newpassword123",
    "phone": "+1-555-0123",
    "mobile": "+1-555-0124",
    "address": "123 User St, New York, NY 10001",
    "country_id": 1,
    "city_id": 1,
    "username": "johndoe",
    "branch_id": 1,
    "roles": ["Admin", "Branch Manager"]
}
```

### 5. Delete User
**DELETE** `/users/{id}`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "status": true,
    "message": "User deleted successfully.",
    "data": null
}
```

---

## 🔒 Error Responses

### 401 Unauthorized
```json
{
    "status": false,
    "message": "Invalid credentials.",
    "data": null
}
```

### 403 Forbidden
```json
{
    "status": false,
    "message": "Unauthorized. Insufficient permissions.",
    "data": null
}
```

### 404 Not Found
```json
{
    "status": false,
    "message": "Resource not found.",
    "data": null
}
```

### 422 Validation Error
```json
{
    "status": false,
    "message": "Validation Error",
    "data": {
        "field_name": ["The field name is required."]
    }
}
```

### 500 Server Error
```json
{
    "status": false,
    "message": "Internal server error.",
    "data": null
}
```

---

## 📝 Frontend Integration Examples

### JavaScript/Fetch Example
```javascript
// Login
const login = async (email, password) => {
    const response = await fetch('http://localhost:8000/api/login', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ email, password })
    });
    return await response.json();
};

// Get Countries (with authentication)
const getCountries = async (token) => {
    const response = await fetch('http://localhost:8000/api/countries', {
        headers: {
            'Authorization': `Bearer ${token}`,
            'Content-Type': 'application/json',
        }
    });
    return await response.json();
};

// Create Company
const createCompany = async (token, companyData) => {
    const response = await fetch('http://localhost:8000/api/companies', {
        method: 'POST',
        headers: {
            'Authorization': `Bearer ${token}`,
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(companyData)
    });
    return await response.json();
};
```

### Axios Example
```javascript
import axios from 'axios';

const api = axios.create({
    baseURL: 'http://localhost:8000/api',
    headers: {
        'Content-Type': 'application/json',
    }
});

// Add token to requests
api.interceptors.request.use((config) => {
    const token = localStorage.getItem('token');
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
});

// Login
const login = async (email, password) => {
    const response = await api.post('/login', { email, password });
    return response.data;
};

// Get Countries
const getCountries = async () => {
    const response = await api.get('/countries');
    return response.data;
};
```

---

## 🚀 Getting Started

1. **Start the Laravel server**: `php artisan serve`
2. **Default Super Admin**: 
   - Email: `admin@example.com`
   - Password: `password`
3. **Test the API** using the examples above
4. **Store the token** from login response for authenticated requests

---

This documentation provides everything a frontend developer needs to integrate with the ERP system API! 🎯
