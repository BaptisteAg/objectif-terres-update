<?php

namespace App\Http\Controllers\Api\Schemas;

/**
 * @OA\Examples(
 *     example="landOfferAdExample",
 *     summary="Land Offer Ad Response",
 *     value={
 *         "data": {
 *             {
 *                 "id": 9937,
 *                 "link": "https://objectif-terres.org/annonces/9937",
 *                 "title": "Ferme bio à transmettre (25 hectares)",
 *                 "type": "landOfferAd",
 *                 "image": "https://objectif-terres.org/storage/documents/ferme.jpg",
 *                 "department_code": "34",
 *                 "created_at": "2025-09-25T15:38:32Z",
 *                 "updated_at": "2025-09-25T17:16:25Z",
 *                 "deleted_at": null,
 *                 "status": "published",
 *                 "is_partner": false,
 *                 "accept_share_contact_infos": true,
 *                 "author_description": "Exploitation familiale depuis 3 générations",
 *                 "author": {
 *                     "id": 20522,
 *                     "first_name": "Marie",
 *                     "last_name": "Dupont",
 *                     "email": "marie.dupont@example.com",
 *                     "phone": "0612345678",
 *                     "profile": "proprietaire_vente_location",
 *                     "on_behalf_of_third_party": false
 *                 },
 *                 "moderation": {
 *                     "moderator": {
 *                         "id": 14993,
 *                         "name": "Lorane Bouvrot",
 *                         "email": "l.bouvrot@terredeliens.org",
 *                         "is_third_party": false
 *                     },
 *                     "status": "approved",
 *                     "archived_at": null,
 *                     "attributed_at": "2025-09-25T15:38:58Z"
 *                 },
 *                 "locations": {
 *                     "cities": {
 *                         {
 *                             "id": 7663,
 *                             "name": "Montpellier",
 *                             "code": "34172",
 *                             "radius": "10"
 *                         }
 *                     }
 *                 },
 *                 "land_offer": {
 *                     "surface": 25.5,
 *                     "altitude": 150,
 *                     "water_access": true,
 *                     "water_access_description": "Forage et accès rivière",
 *                     "has_buildings": true,
 *                     "has_houses": true,
 *                     "price": 450000,
 *                     "rent_price": null,
 *                     "sau_description": "20 hectares de terres cultivables, 5 hectares de prairies",
 *                     "test_description": null,
 *                     "is_activity_transfer": true,
 *                     "support_requests": {
 *                         "is_beneficiary": false,
 *                         "is_community_call": false,
 *                         "is_tdl_call": true,
 *                         "is_test_area": false
 *                     },
 *                     "offer_types": {
 *                         {
 *                             "id": 1,
 *                             "name": "Vente",
 *                             "code": "vente"
 *                         }
 *                     },
 *                     "about_land_transmission": "Cherche repreneur pour continuer l'exploitation bio",
 *                     "building": {
 *                         "id": 1,
 *                         "name": "Hangar agricole",
 *                         "description": "Hangar de 500m² avec chambre froide"
 *                     },
 *                     "house": {
 *                         "id": 2,
 *                         "name": "Maison d'habitation",
 *                         "description": "Maison de 150m² avec 4 chambres"
 *                     },
 *                     "production_type_additional": "Maraîchage et arboriculture",
 *                     "production_type_wanted_additional": null
 *                 }
 *             }
 *         },
 *         "pagination": {
 *             "current_page": 1,
 *             "per_page": 20,
 *             "total": 378
 *         },
 *         "meta": {
 *             "generated_at": "2025-09-26T12:30:00Z",
 *             "cache_expires_at": "2025-09-26T13:30:00Z",
 *             "total_filtered": 378,
 *             "filters_applied": {
 *                 "updated_since": null,
 *                 "types": {"landOfferAd"},
 *                 "region_code": null
 *             },
 *             "current_page": 1,
 *             "from": 1,
 *             "last_page": 19,
 *             "path": "https://objectif-terres.org/api/v1/ads",
 *             "per_page": 20,
 *             "to": 20,
 *             "total": 378
 *         },
 *         "links": {
 *             "first": "https://objectif-terres.org/api/v1/ads?page=1",
 *             "last": "https://objectif-terres.org/api/v1/ads?page=19",
 *             "prev": null,
 *             "next": "https://objectif-terres.org/api/v1/ads?page=2"
 *         }
 *     }
 * )
 * @OA\Examples(
 *     example="unauthorizedExample",
 *     summary="Unauthorized Response",
 *     value={
 *         "error": "unauthorized",
 *         "message": "Invalid or missing API key"
 *     }
 * )
 * @OA\Examples(
 *     example="badRequestExample",
 *     summary="Bad Request Response",
 *     value={
 *         "error": "bad_request",
 *         "message": "Invalid date format for updated_since parameter",
 *         "details": {
 *             "parameter": "updated_since",
 *             "expected_format": "YYYY-MM-DDTHH:MM:SSZ",
 *             "received": "2025-07-18"
 *         }
 *     }
 * )
 * @OA\Examples(
 *     example="rateLimitExample",
 *     summary="Rate Limit Response",
 *     value={
 *         "error": "rate_limit_exceeded",
 *         "message": "API rate limit exceeded. Please retry after 60 seconds.",
 *         "retry_after": 60
 *     }
 * )
 */
class ExampleResponses
{
    // This class only contains OpenAPI example definitions
}
