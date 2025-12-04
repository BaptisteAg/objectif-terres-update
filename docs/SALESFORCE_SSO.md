# Salesforce SSO Authentication System

This document provides a complete overview of the Salesforce Single Sign-On (SSO) authentication system using SAML2.

## Overview

Objectif Terres uses a **dual-authentication system**:
1. **SAML2-based SSO** for Salesforce authentication (primary for staff)
2. **Forrest REST API** (`omniphx/forrest`) for Salesforce data synchronization
3. **Local Laravel authentication** for standard user login

## Architecture

```
┌─────────────────────────────────────────────────────────────────┐
│                        Objectif Terres                          │
│  ┌─────────────────┐    ┌─────────────────┐    ┌─────────────┐ │
│  │ SalesforceLogin │    │ SalesforceService│    │   Forrest   │ │
│  │   Controller    │───►│   (User Sync)   │───►│  REST API   │ │
│  └────────┬────────┘    └─────────────────┘    └──────┬──────┘ │
│           │                                           │        │
│           │ SAML2                                     │ REST   │
└───────────┼───────────────────────────────────────────┼────────┘
            │                                           │
            ▼                                           ▼
┌─────────────────────────────────────────────────────────────────┐
│                         Salesforce                               │
│  ┌─────────────────┐                      ┌─────────────────┐   │
│  │   Identity      │                      │    REST API     │   │
│  │   Provider      │                      │    (Objects)    │   │
│  └─────────────────┘                      └─────────────────┘   │
└─────────────────────────────────────────────────────────────────┘
```

---

## Configuration

### Environment Variables

#### SAML2 Configuration
```env
SAML2_SALESFORCE_SANDBOX=false
SAML2_SALESFORCE_IDP_ENTITYID=https://yoursalesforce.my.salesforce.com
SAML2_SALESFORCE_IDP_SSO_URL=https://yoursalesforce.my.salesforce.com/idp/endpoint/HttpRedirect
SAML2_SALESFORCE_IDP_SL_URL=https://yoursalesforce.my.salesforce.com/services/auth/idp/saml2/logout
SAML2_SALESFORCE_IDP_CERT_FINGERPRINT=1a2b3c4d5e6f...
```

#### Forrest REST API Configuration
```env
SF_CONSUMER_KEY=your_oauth_consumer_key
SF_CONSUMER_SECRET=your_oauth_consumer_secret
SF_LOGIN_URL=https://login.salesforce.com
SF_USERNAME=service.account@yourorg.com
SF_PASSWORD=yourpassword
SF_TOKEN=yoursecuritytoken
SF_CALLBACK_URI=https://yourdomain.com/oauth/callback
SF_SYNC_CONTACT_ACCOUNT_ID=0012000000o2X3TAAU
```

### Certificate Files

Location: `/certs/`

| File | Purpose |
|------|---------|
| `salesforce_api.pem` | Service Provider public certificate |
| `salesforce_api.key` | Service Provider private key (secret) |
| `salesforce_api_sandbox.pem` | Sandbox environment certificate |
| `salesforce_api_sandbox.key` | Sandbox private key |

> **Important**: Certificates require annual renewal.

### Configuration Files

| File | Purpose |
|------|---------|
| `config/saml2_settings.php` | SAML2 routing and middleware |
| `config/saml2/salesforce_idp_settings.php` | OneLogin SAML validation |
| `config/forrest.php` | REST API authentication |

---

## Authentication Flow

### Login Sequence

```
User                    Objectif Terres              Salesforce
  │                           │                           │
  │ 1. GET /connexion/sso     │                           │
  │──────────────────────────►│                           │
  │                           │                           │
  │                           │ 2. Create AuthnRequest    │
  │                           │    Sign with private key  │
  │                           │                           │
  │ 3. Redirect to Salesforce │                           │
  │◄──────────────────────────│                           │
  │                           │                           │
  │ 4. User authenticates     │                           │
  │───────────────────────────────────────────────────────►
  │                           │                           │
  │                           │   5. Salesforce creates   │
  │                           │      signed SAML Response │
  │                           │                           │
  │ 6. POST /saml2/salesforce/acs (SAML Response)         │
  │──────────────────────────►│◄──────────────────────────│
  │                           │                           │
  │                           │ 7. Validate signature     │
  │                           │ 8. Extract user attributes│
  │                           │ 9. Sync local user        │
  │                           │ 10. auth()->login($user)  │
  │                           │                           │
  │ 11. Redirect to /         │                           │
  │◄──────────────────────────│                           │
```

### Logout Sequence

```
User                    Objectif Terres              Salesforce
  │                           │                           │
  │ 1. GET /deconnexion/sso   │                           │
  │──────────────────────────►│                           │
  │                           │                           │
  │                           │ 2. auth()->logout()       │
  │                           │    session()->invalidate()│
  │                           │                           │
  │                           │ 3. Create LogoutRequest   │
  │                           │    Sign with private key  │
  │                           │                           │
  │ 4. Redirect to Salesforce SLO                         │
  │◄──────────────────────────│──────────────────────────►│
  │                           │                           │
  │                           │   5. Salesforce processes │
  │                           │      logout               │
  │                           │                           │
  │ 6. GET /saml2/salesforce/sls                          │
  │──────────────────────────►│◄──────────────────────────│
  │                           │                           │
  │ 7. Redirect to /          │                           │
  │◄──────────────────────────│                           │
```

---

## User Synchronization

### Sync Process

When a user logs in via SSO, `SalesforceService::syncLocalUser()` performs:

1. **Authenticate with Salesforce REST API** (Forrest)
2. **Fetch user from Salesforce** (FirstName, LastName, Role_Objectif_Terre__c)
3. **Find or create local user** (by sf_id, then by email)
4. **Restore soft-deleted users** (sets `deleted_at = null`)
5. **Sync user attributes** (name, email, sf_id, is_sf_user)
6. **Handle email conflicts** (archive local, throw on SF conflict)
7. **Parse and sync role** from `Role_Objectif_Terre__c`
8. **Sync department assignments**

### Role Format

Salesforce stores role and departments in `Role_Objectif_Terre__c` field:

```
Format: "ROLE-DEPT1_DEPT2_DEPT3"
Example: "2-84_85" → Role 2 (Primo Accueillant), Departments 84 & 85
```

| Role | Value | Description |
|------|-------|-------------|
| PP | 0 | Porteur de projet |
| Moderator | 1 | Modérateur |
| Advisor | 2 | Primo Accueillant |
| Supervisor | 3 | Responsable Territorial |
| Admin | 4 | Administrateur (all departments) |

### Field Mapping

| Salesforce Field | Local User Field |
|------------------|------------------|
| `Id` | `sf_id` |
| `Email` | `email` |
| `FirstName` | `first_name` |
| `LastName` | `name` |
| `Role_Objectif_Terre__c` | `role` + `departments` |
| - | `is_sf_user = true` |

---

## Routes

### SAML2 Routes (Auto-generated)

| Method | Route | Purpose |
|--------|-------|---------|
| GET | `/saml2/salesforce/login` | Initiate SAML login |
| POST | `/saml2/salesforce/acs` | Assertion Consumer Service |
| GET | `/saml2/salesforce/sls` | Single Logout Service |
| GET | `/saml2/salesforce/metadata` | SP Metadata |
| GET | `/saml2/salesforce/logout` | Initiate logout |

### Custom Routes

| Method | Route | Purpose |
|--------|-------|---------|
| GET | `/connexion/sso` | SSO login entry point |
| GET | `/deconnexion/sso` | SSO logout entry point |

---

## Security

### SAML Security Settings

```php
'strict' => true,
'wantMessagesSigned' => true,      // SAML Response must be signed
'wantAssertionsSigned' => true,    // Assertions must be signed
'logoutRequestSigned' => true,     // Logout requests signed
'logoutResponseSigned' => true,    // Logout responses signed
```

### Certificate Chain

1. **AuthnRequest**: Signed with local private key (`salesforce_api.key`)
2. **SAML Response**: Signed by Salesforce, validated with fingerprint
3. **LogoutRequest/Response**: Signed by both parties

### Session Management

```php
// Stored for logout
session()->put([
    'saml_session_index' => $samlUser->getSessionIndex(),
    'saml_name_id' => $samlUser->getNameId(),
]);
```

---

## Error Handling

### SAML Validation Errors

```php
$errors = $saml2Auth->acs();

if (!empty($errors)) {
    // Development: throw exception with details
    // Production: redirect with user-friendly message
    return redirect("/connexion")->withErrors(
        "Une erreur empêche l'identification depuis Salesforce..."
    );
}
```

### Email Conflicts

| Scenario | Resolution |
|----------|------------|
| Local-only user with same email | Archive email: `email.archived.{timestamp}` |
| Two Salesforce users same email | Throw exception (requires manual intervention) |

### Role Format Errors

```php
if (!isset($roleAndDepartments[1])) {
    throw new Exception(
        "Erreur de configuration Salesforce : le format attendu est 'role-departement' " .
        "mais '{$value}' a été trouvé."
    );
}
```

---

## Edge Cases

### Soft-Deleted User Logs In

- User is automatically restored: `$localUser->deleted_at = null`
- All attributes synced from Salesforce
- Normal login proceeds

### User Not Found in Salesforce

```php
throw new Exception("Nous n'avons pas pu vous identifier. Veuillez contacter un administrateur.");
```

### Role Changed in Salesforce

- Email notification sent to `objectif-terres@terredeliens.org`
- Local role updated
- Department assignments updated

### User Not Found Locally

- New user automatically created with Salesforce data
- Role and departments assigned from Salesforce

---

## Console Commands

### Sync All SSO Users

```bash
php artisan app:sync-salesforce-sso-users-permissions
```

Re-syncs role and departments for all users with `is_sf_user = true`.

### Other Commands

| Command | Purpose |
|---------|---------|
| `SalesforceStoreToken` | Refresh API token |
| `SalesforceCreateUser` | Create user in Salesforce |
| `SyncSalesforceAds` | Sync ads bidirectionally |

---

## Key Files

| Category | File |
|----------|------|
| **Controller** | `app/Http/Controllers/Auth/SalesforceLoginController.php` |
| **Service** | `app/Services/Salesforce/SalesforceService.php` |
| **Repository** | `app/Repositories/SalesForce/SalesForceRepository.php` |
| **Token** | `app/Repositories/SalesForce/SalesForceTokenRepository.php` |
| **Config** | `config/saml2_settings.php` |
| **Config** | `config/saml2/salesforce_idp_settings.php` |
| **Config** | `config/forrest.php` |
| **Notification** | `app/Notifications/SalesforceUserRoleChanged.php` |
| **Command** | `app/Console/Commands/SyncSalesforceSsoUsersPermissions.php` |

---

## Troubleshooting

### Common Issues

| Issue | Cause | Solution |
|-------|-------|----------|
| "Could not login" | SAML signature invalid | Check certificate fingerprint |
| "User not found" | User doesn't exist in SF | Verify SF user exists |
| "Invalid role format" | Missing department in SF | Fix `Role_Objectif_Terre__c` field |
| Token expired | API token cache expired | Tokens auto-refresh; check logs |
| Certificate error | Expired certificate | Renew certificates annually |

### Debug Mode

In development (`APP_ENV=local`), detailed exceptions are thrown.
In production, user-friendly messages are shown.

### Logs

- SAML errors: `logger()->error('Saml2 error_detail', [...])`
- Email conflicts: `logger()->warning('Salesforce SSO email conflict...')`
- API errors: Check Laravel logs for Forrest exceptions

---

## Security Checklist

- [x] SAML2 strict mode enabled
- [x] XML signatures required
- [x] Certificate fingerprint validation
- [x] Session regeneration on logout
- [x] Credentials in environment variables
- [x] Automatic token refresh
- [ ] Replay attack prevention (TODO)
- [ ] Rate limiting on SAML endpoints
