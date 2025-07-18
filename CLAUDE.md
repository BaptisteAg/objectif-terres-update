# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Objectif Terres is a Laravel 6.x application for the non-profit organization Terre de Liens. It's primarily an ad-centered platform for agricultural land listings and job opportunities, serving as a free service to generate more "Demandes d'accompagnement" (support requests) and farm land purchase projects for the association.

**Important**: The internal CRM functionality for "Primo accueillants" (first-contact advisors) and "Projects" (support request management) has been deprecated and replaced by Salesforce. The remaining Salesforce integration focuses on SSO authentication, API usage, and ad synchronization.

## Development Environment

This project runs in a Devilbox development environment with Docker Compose. The main stack includes:
- PHP 8.0+ with Laravel 6.x framework
- MySQL/MariaDB for database
- Redis for caching
- Apache/Nginx web server
- Node.js for frontend asset compilation

## Key Commands

### PHP/Laravel Commands
```bash
# Install PHP dependencies
composer install

# Run database migrations
php artisan migrate

# Seed database with test data
php artisan db:seed

# Clear application cache
php artisan cache:clear

# Generate application key
php artisan key:generate

# Run tests
php vendor/bin/phpunit

# Run a specific test
php vendor/bin/phpunit tests/Feature/ApiTest.php

# Access Laravel Tinker REPL
php artisan tinker

# View Laravel routes
php artisan route:list
```

### Frontend Commands
```bash
# Install Node.js dependencies  
npm install

# Run development build
npm run dev

# Watch for file changes
npm run watch

# Build for production
npm run production
```

### Docker/Devilbox Commands
```bash
# Start development environment
docker-compose up -d

# Stop services
docker-compose stop

# Enter PHP container
docker-compose exec php bash

# View logs
docker-compose logs -f

# Run PHP/Artisan commands through container
docker compose exec php php /shared/httpd/objectif-terres/artisan [command]
```

## Architecture & Code Structure

### Core Domain Models
- **Ad**: Base class for all advertisements with polymorphic relationships
- **LandOfferAd/LandSeekAd**: Land buying/selling advertisements
- **JobOfferAd/JobSeekAd**: Job posting and seeking advertisements  
- **AssociateOfferAd/AssociateSeekAd**: Partnership seeking advertisements
- **User**: Multi-role user system (see User Roles section below)
- **Project**: DEPRECATED - Support request tracking now handled by Salesforce
- **AttributionAd**: Ad assignment and moderation workflow
- **Thread/Message**: Internal messaging system

### User Roles (Hierarchical System)
- **Porteur de projet (pp)** = 0: Basic user who can create ads and support requests
- **Modérateur** = 1: Ad moderator (still actively used)
- **Primo Accueillant** = 2: DEPRECATED first-contact advisor (some users retain this role; can moderate ads due to hierarchy)
- **Responsable territorial** = 3: Territorial manager handling territory-based operations
- **Admin** = 4: Full administrator access

### Locationable Polymorphic System
The **Locationable** relationship is a complex polymorphic system allowing geographic attachment to ads:
- **Cities**: Municipal-level geographic units
- **Departments**: French département-level divisions
- **Regions**: French regional divisions
- **Territories**: Terre de Liens proprietary zones (similar to old French regions but custom boundaries)

This system enables flexible geographic filtering and territorial management for ads and user assignments.

### Repository Pattern
All data access uses the Repository pattern with interfaces:
- Located in `app/Repositories/`
- Each repository has an interface (e.g., `AdRepositoryInterface`)
- Bound in service providers for dependency injection

### Service Layer
Business logic is encapsulated in services:
- `app/Services/` contains domain services
- `DocumentService` for file upload/management
- `SalesforceService` for CRM integration
- `ResearchService` for saved searches
- `ModerationService` for ad approval workflow

### Nova Admin Interface
Laravel Nova provides the admin interface:
- Nova resources in `app/Nova/`
- Custom filters, actions, and metrics
- Handles user management and content moderation

### Observer Pattern
Model observers handle side effects:
- `AdObserver` for ad state changes
- `UserObserver` for user lifecycle events
- Located in `app/Observers/`

### Multi-tenancy by Territory
The application uses soft multi-tenancy:
- Users belong to territories (regions)
- Ads can be filtered by territory
- Support requests are assigned by territory

### Salesforce Integration
Salesforce integration handles external CRM functionality:
- **SSO Authentication**: OAuth2 authentication via SAML for user login
- **Ad Synchronization**: Bi-directional sync of ads with Salesforce
- **API Integration**: Custom API endpoints for data exchange
- **Certificate-based Authentication**: Annual certificate renewal required
- **DEPRECATED**: Internal project/support request management (now handled entirely in Salesforce)

## Development Patterns

### Authentication & Authorization
- Hierarchical multi-role system (0-4) with middleware-based protection
- Higher role numbers inherit permissions from lower roles
- Salesforce SSO integration for external authentication
- Territory-based access control for regional management
- Role-based ad moderation workflow

### File Management
- Document uploads with validation
- Image processing with Intervention Image
- Storage abstraction for local/cloud storage

### Queue System
- Background job processing for notifications
- Scheduled tasks for data cleanup and alerts
- Located in `app/Jobs/`

### Testing
- Feature tests for API endpoints
- Unit tests for business logic
- Database factories for test data
- PHPUnit configuration in `phpunit.xml`

### Frontend Architecture
- Vue.js 2.x components with Bulma CSS framework
- Laravel Mix for asset compilation
- Modular JavaScript organization
- Responsive design with mobile-first approach

## Key Configuration

### Environment Variables
- Database connection settings
- Salesforce API credentials
- Mail server configuration
- Redis connection details
- Application-specific flags (coming soon mode, etc.)

### Database
- Extensive migration system with proper foreign key constraints
- Seeders for reference data
- Soft deletes for most models
- Polymorphic relationships for flexible data modeling

### Caching Strategy
- Redis for session and cache storage
- Model result caching
- Route caching for performance

## Common Development Tasks

### Adding New Ad Types
1. Create model extending base Ad class
2. Add migration with proper foreign keys and Locationable relationships
3. Create Nova resource for admin interface
4. Add observer for lifecycle events
5. Update repository and service layers
6. Configure geographic filtering via Locationable system

### Working with Locationable System
- Use polymorphic relationships for geographic attachments
- Territory assignments affect user access and ad filtering
- Cities → Departments → Regions → Territories hierarchy
- Complex queries often involve multiple geographic levels

### Salesforce Integration (Active Components)
- Certificate files in `/certs/` directory
- Annual certificate renewal process documented in README
- Ad synchronization endpoints and error handling
- SSO authentication flow maintenance

### Moderation Workflow (Still Active)
- Ad status transitions through defined states
- Email notifications for state changes
- Assignment logic for territorial moderators (role 3)
- Hierarchical role permissions for moderation access
- Audit trail through History model

### Deprecated Features (Avoid Development)
- Internal Project/Support request management
- Primo Accueillant workflows (role 2 users exist but functionality deprecated)
- Thread/Message system for internal communication
- Any CRM functionality not related to ads

### Testing Data
- Use factories for consistent test data
- Test accounts documented in README with role examples
- Separate test database configuration
- Mock Salesforce services in tests