# API Error Response Testing

## Testing Method Not Allowed Errors

Now when you make requests with incorrect HTTP methods to API endpoints, you'll get JSON responses instead of HTML.

### Examples:

#### 1. GET request to POST endpoint
```bash
curl -X GET http://localhost:8000/api/login
```

**Response (405):**
```json
{
    "status": false,
    "message": "Method not allowed for this endpoint.",
    "data": {
        "allowed_methods": ["POST"],
        "requested_method": "GET",
        "endpoint": "api/login"
    }
}
```

#### 2. POST request to GET endpoint
```bash
curl -X POST http://localhost:8000/api/countries
```

**Response (405):**
```json
{
    "status": false,
    "message": "Method not allowed for this endpoint.",
    "data": {
        "allowed_methods": ["GET", "HEAD"],
        "requested_method": "POST",
        "endpoint": "api/countries"
    }
}
```

#### 3. Non-existent endpoint
```bash
curl -X GET http://localhost:8000/api/nonexistent
```

**Response (404):**
```json
{
    "status": false,
    "message": "Endpoint not found.",
    "data": {
        "endpoint": "api/nonexistent",
        "method": "GET"
    }
}
```

#### 4. Validation Error
```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email": "test@example.com"}'
```

**Response (422):**
```json
{
    "status": false,
    "message": "Validation Error",
    "data": {
        "password": ["The password field is required."]
    }
}
```

## Benefits

✅ **Consistent JSON Responses** - All API errors now return JSON
✅ **Better Frontend Integration** - No more HTML error pages
✅ **Detailed Error Information** - Clear error messages and context
✅ **Proper HTTP Status Codes** - Correct status codes for different error types
✅ **Debug Information** - Helpful details for development

## Error Types Handled

1. **405 Method Not Allowed** - Wrong HTTP method
2. **404 Not Found** - Non-existent endpoints
3. **422 Validation Error** - Invalid request data
4. **500 Internal Server Error** - Server errors
5. **401 Unauthorized** - Authentication errors
6. **403 Forbidden** - Permission errors

All errors now follow the consistent API response format:
```json
{
    "status": false,
    "message": "Error description",
    "data": { ... }
}
```
