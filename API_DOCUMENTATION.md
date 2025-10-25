# ERP System API Documentation

## Overview

This Laravel backend provides a comprehensive ERP system API with the following modules:
- Countries & Cities (Lookup tables)
- Companies & Branches
- Terminals
- Users with Role-based Access Control
- Super Admin Impersonation

## Authentication

The API uses Laravel Sanctum for authentication. Include the Bearer token in the Authorization header:

```
Authorization: Bearer {your-token}
```

## Base API Response Format

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

## API Endpoints

### Authentication Endpoints

#### POST /api/login
Login user and get authentication token.

**Request:**
```json
{
    "email": "admin@example.com",
    "password": "password"
}
```

**Response:**
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
        "token": "1|abcdef123456...",
        "token_type": "Bearer"
    }
}
```

#### POST /api/logout
Logout user and revoke token.

**Response:**
```json
{
    "status": true,
    "message": "Logout successful.",
    "data": null
}
```

#### GET /api/me
Get authenticated user information.

**Response:**
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

#### POST /api/impersonate/{user_id}
Super Admin impersonation endpoint.

**Response:**
```json
{
    "status": true,
    "message": "Impersonation successful.",
    "data": {
        "user": { ... },
        "token": "2|xyz789...",
        "token_type": "Bearer",
        "impersonated": true
    }
}
```

### Country Endpoints

#### GET /api/countries
Get all countries.

**Response:**
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
            "cities": []
        }
    ]
}
```

#### POST /api/countries
Create a new country.

**Request:**
```json
{
    "name": "Canada",
    "status": true
}
```

#### GET /api/countries/{id}
Get specific country.

#### PUT /api/countries/{id}
Update country.

#### DELETE /api/countries/{id}
Delete country.

### City Endpoints

#### GET /api/cities
Get all cities.

**Response:**
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
        }
    ]
}
```

#### POST /api/cities
Create a new city.

**Request:**
```json
{
    "country_id": 1,
    "name": "Los Angeles",
    "status": true
}
```

### Company Endpoints

#### GET /api/companies
Get all companies.

**Response:**
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
            "address": "123 Business St",
            "logo": null,
            "ntn": "123456789",
            "country_id": 1,
            "city_id": 1,
            "status": true,
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
            "branches": []
        }
    ]
}
```

#### POST /api/companies
Create a new company.

**Request:**
```json
{
    "name": "Tech Solutions Inc",
    "email": "info@techsolutions.com",
    "phone": "+1-555-0456",
    "address": "456 Innovation Ave",
    "logo": null,
    "ntn": "987654321",
    "country_id": 1,
    "city_id": 1,
    "status": true
}
```

### Branch Endpoints

#### GET /api/branches
Get all branches.

#### POST /api/branches
Create a new branch.

**Request:**
```json
{
    "company_id": 1,
    "name": "Downtown Branch",
    "email": "downtown@acme.com",
    "phone": "+1-555-0123",
    "mobile": "+1-555-0124",
    "address": "789 Main St",
    "logo": null,
    "ntn": "123456789",
    "country_id": 1,
    "city_id": 1,
    "status": true
}
```

### Terminal Endpoints

#### GET /api/terminals
Get all terminals.

#### POST /api/terminals
Create a new terminal.

**Request:**
```json
{
    "branch_id": 1,
    "name": "Terminal 001",
    "mac_address": "00:11:22:33:44:55",
    "serial_no": "T001-2025-001",
    "status": true
}
```

### User Endpoints

#### GET /api/users
Get all users.

#### POST /api/users
Create a new user.

**Request:**
```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "phone": "+1-555-0123",
    "mobile": "+1-555-0124",
    "address": "123 User St",
    "country_id": 1,
    "city_id": 1,
    "username": "johndoe",
    "branch_id": 1,
    "roles": ["Cashier"]
}
```

## Roles and Permissions

The system includes the following roles:
- **Super Admin**: Full system access, can impersonate any user
- **Admin**: Administrative access
- **Branch Manager**: Branch-level management
- **Cashier**: Basic operational access

## Database Structure

### Countries Table
- id
- name
- status (boolean)
- timestamps

### Cities Table
- id
- country_id (FK → countries.id)
- name
- status (boolean)
- timestamps

### Companies Table
- id
- name
- email (unique)
- phone
- address
- logo
- ntn
- country_id (FK → countries.id)
- city_id (FK → cities.id)
- status (boolean)
- timestamps

### Branches Table
- id
- company_id (FK → companies.id)
- name
- email
- phone
- mobile
- address
- logo
- ntn
- country_id (FK → countries.id)
- city_id (FK → cities.id)
- status (boolean)
- timestamps

### Terminals Table
- id
- branch_id (FK → branches.id)
- name
- mac_address (unique)
- serial_no (unique)
- status (boolean)
- timestamps

### Users Table (Extended)
- id
- name
- email (unique)
- password
- phone
- mobile
- address
- country_id (FK → countries.id)
- city_id (FK → cities.id)
- username (unique)
- branch_id (FK → branches.id)
- timestamps

## Default Super Admin

The system creates a default Super Admin user:
- **Email**: admin@example.com
- **Password**: password
- **Role**: Super Admin

## Error Handling

All endpoints return consistent error responses:

### Validation Error (422)
```json
{
    "status": false,
    "message": "Validation Error",
    "data": {
        "field_name": ["The field name is required."]
    }
}
```

### Unauthorized (401)
```json
{
    "status": false,
    "message": "Invalid credentials.",
    "data": null
}
```

### Forbidden (403)
```json
{
    "status": false,
    "message": "Unauthorized. Insufficient permissions.",
    "data": null
}
```

### Not Found (404)
```json
{
    "status": false,
    "message": "Resource not found.",
    "data": null
}
```

## Getting Started

1. Run migrations: `php artisan migrate`
2. Seed the database: `php artisan db:seed`
3. Start the server: `php artisan serve`
4. Use the API endpoints with proper authentication

## Example Usage with cURL

### Login
```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email": "admin@example.com", "password": "password"}'
```

### Get Countries (with authentication)
```bash
curl -X GET http://localhost:8000/api/countries \
  -H "Authorization: Bearer {your-token}" \
  -H "Content-Type: application/json"
```

### Create Company
```bash
curl -X POST http://localhost:8000/api/companies \
  -H "Authorization: Bearer {your-token}" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "New Company",
    "email": "contact@newcompany.com",
    "country_id": 1,
    "city_id": 1
  }'
```
