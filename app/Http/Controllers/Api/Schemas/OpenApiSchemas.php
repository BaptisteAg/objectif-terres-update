<?php

namespace App\Http\Controllers\Api\Schemas;

/**
 * @OA\Schema(
 *     schema="AdResource",
 *     type="object",
 *     title="Ad Resource",
 *     description="Complete ad data with all relationships",
 *     required={"id", "link", "title", "type", "status"},
 *
 *     @OA\Property(property="id", type="integer", example=9938),
 *     @OA\Property(property="link", type="string", format="url", example="https://objectif-terres.org/annonces/9938"),
 *     @OA\Property(property="title", type="string", example="Ferme bio à transmettre"),
 *     @OA\Property(property="type", type="string", enum={"land_offer", "land_seek", "job_offer", "job_seek", "associate_offer", "associate_seek"}, example="land_offer"),
 *     @OA\Property(property="image", type="string", format="url", nullable=true, example="https://objectif-terres.org/storage/documents/image.jpg"),
 *     @OA\Property(property="department_code", type="string", example="34", description="Department code (2 characters, e.g., '34' or '2A')"),
 *     @OA\Property(property="department_name", type="string", example="Hérault", description="Department name"),
 *     @OA\Property(property="region_name", type="string", example="Occitanie", description="Region name"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-09-25T16:50:59Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-09-25T17:08:33Z"),
 *     @OA\Property(property="deleted_at", type="string", format="date-time", nullable=true),
 *     @OA\Property(property="status", type="string", enum={"published", "archived", "deleted"}, example="published"),
 *     @OA\Property(property="is_partner", type="boolean", example=false),
 *     @OA\Property(property="accept_share_contact_infos", type="boolean", example=true),
 *     @OA\Property(property="author_description", type="string", nullable=true, example="Lorem ipsum dolor sit amet"),
 *     @OA\Property(property="author", ref="#/components/schemas/Author"),
 *     @OA\Property(property="moderation", ref="#/components/schemas/Moderation"),
 *     @OA\Property(property="locations", ref="#/components/schemas/Locations"),
 *     @OA\Property(property="land_offer", ref="#/components/schemas/LandOffer", description="Present only for landOfferAd type"),
 *     @OA\Property(property="land_seek", ref="#/components/schemas/LandSeek", description="Present only for landSeekAd type"),
 *     @OA\Property(property="job_offer", ref="#/components/schemas/JobOffer", description="Present only for jobOfferAd type"),
 *     @OA\Property(property="job_seek", ref="#/components/schemas/JobSeek", description="Present only for jobSeekAd type"),
 *     @OA\Property(property="associate_offer", ref="#/components/schemas/AssociateOffer", description="Present only for associateOfferAd type"),
 *     @OA\Property(property="associate_seek", ref="#/components/schemas/AssociateSeek", description="Present only for associateSeekAd type")
 * )
 *
 * @OA\Schema(
 *     schema="Author",
 *     type="object",
 *     title="Author",
 *
 *     @OA\Property(property="id", type="integer", example=456),
 *     @OA\Property(property="first_name", type="string", example="Jean"),
 *     @OA\Property(property="last_name", type="string", nullable=true, example="Dupont"),
 *     @OA\Property(property="email", type="string", format="email", example="jean.dupont@example.com"),
 *     @OA\Property(property="phone", type="string", example="0612345678"),
 *     @OA\Property(property="profile", type="string", enum={"candidat_installation", "en_recherche", "proprietaire_vente_location", "autre"}, example="candidat_installation"),
 *     @OA\Property(property="on_behalf_of_third_party", type="boolean", example=false),
 *     @OA\Property(property="deleted_at", type="string", format="date-time", nullable=true, description="Author deletion date (present if user was soft-deleted)"),
 *     @OA\Property(
 *         property="third_party",
 *         type="object",
 *         nullable=true,
 *         @OA\Property(property="id", type="integer"),
 *         @OA\Property(property="first_name", type="string"),
 *         @OA\Property(property="last_name", type="string"),
 *         @OA\Property(property="email", type="string", format="email"),
 *         @OA\Property(property="phone", type="string")
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="Moderation",
 *     type="object",
 *     title="Moderation",
 *
 *     @OA\Property(
 *         property="moderator",
 *         type="object",
 *         nullable=true,
 *         @OA\Property(property="id", type="integer", example=14993),
 *         @OA\Property(property="name", type="string", example="Lorane Bouvrot"),
 *         @OA\Property(property="email", type="string", format="email", example="l.bouvrot@terredeliens.org"),
 *         @OA\Property(property="is_third_party", type="boolean", example=false)
 *     ),
 *     @OA\Property(property="status", type="string", enum={"approved", "pending", "refused"}, example="approved"),
 *     @OA\Property(property="archived_at", type="string", format="date-time", nullable=true),
 *     @OA\Property(property="attributed_at", type="string", format="date-time", example="2025-09-25T16:51:31Z")
 * )
 *
 * @OA\Schema(
 *     schema="Locations",
 *     type="object",
 *     title="Locations",
 *
 *     @OA\Property(
 *         property="cities",
 *         type="array",
 *
 *         @OA\Items(
 *             type="object",
 *
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="name", type="string", example="Montpellier"),
 *             @OA\Property(property="code", type="string", nullable=true, example="34172", description="INSEE code"),
 *             @OA\Property(property="radius", type="string", nullable=true, example="10")
 *         )
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="LandOffer",
 *     type="object",
 *     title="Land Offer",
 *
 *     @OA\Property(property="surface", type="number", format="float", example=25.5, description="Surface in hectares"),
 *     @OA\Property(property="altitude", type="number", format="float", nullable=true, example=150.0),
 *     @OA\Property(property="water_access", type="boolean", example=true),
 *     @OA\Property(property="water_access_description", type="string", nullable=true, example="Forage privé"),
 *     @OA\Property(property="has_buildings", type="boolean", example=true),
 *     @OA\Property(property="has_houses", type="boolean", example=false),
 *     @OA\Property(property="price", type="number", format="float", nullable=true, example=150000.0),
 *     @OA\Property(property="rent_price", type="number", format="float", nullable=true),
 *     @OA\Property(property="sau_description", type="string", nullable=true, example="Terres arables de qualité"),
 *     @OA\Property(property="test_description", type="string", nullable=true),
 *     @OA\Property(property="is_activity_transfer", type="boolean", example=false),
 *     @OA\Property(
 *         property="support_requests",
 *         type="object",
 *         @OA\Property(property="is_beneficiary", type="boolean", example=false),
 *         @OA\Property(property="is_community_call", type="boolean", example=false),
 *         @OA\Property(property="is_tdl_call", type="boolean", example=true),
 *         @OA\Property(property="is_test_area", type="boolean", example=false)
 *     ),
 *     @OA\Property(
 *         property="offer_types",
 *         type="array",
 *
 *         @OA\Items(
 *             type="object",
 *
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="name", type="string", example="Vente"),
 *             @OA\Property(property="code", type="string", example="vente", enum={"vente", "location", "test_agricole", "leg_ou_donation_envisagée"})
 *         )
 *     ),
 *     @OA\Property(property="about_land_transmission", type="string", nullable=true, example="Lorem ipsum"),
 *     @OA\Property(
 *         property="building",
 *         type="object",
 *         nullable=true,
 *         @OA\Property(property="id", type="integer"),
 *         @OA\Property(property="name", type="string"),
 *         @OA\Property(property="description", type="string")
 *     ),
 *     @OA\Property(
 *         property="house",
 *         type="object",
 *         nullable=true,
 *         @OA\Property(property="id", type="integer"),
 *         @OA\Property(property="name", type="string"),
 *         @OA\Property(property="description", type="string")
 *     ),
 *     @OA\Property(property="production_type_additional", type="string", nullable=true),
 *     @OA\Property(property="production_type_wanted_additional", type="string", nullable=true)
 * )
 *
 * @OA\Schema(
 *     schema="LandSeek",
 *     type="object",
 *     title="Land Seek",
 *
 *     @OA\Property(property="surface_range_min", type="number", format="float", example=10),
 *     @OA\Property(property="surface_range_max", type="number", format="float", example=50),
 *     @OA\Property(property="price_max", type="number", format="float", nullable=true, example=200000),
 *     @OA\Property(property="rent_max", type="number", format="float", nullable=true, example=1000),
 *     @OA\Property(property="is_bio", type="boolean", example=true),
 *     @OA\Property(property="production_type_additional", type="string", nullable=true, example="Élevage"),
 *     @OA\Property(property="land_description", type="string", nullable=true, example="Recherche terrain pour maraîchage"),
 *     @OA\Property(property="experience_farming", type="string", nullable=true, example="10 ans d'expérience"),
 *     @OA\Property(
 *         property="installation_type",
 *         type="object",
 *         nullable=true,
 *         @OA\Property(property="id", type="integer", example=1),
 *         @OA\Property(property="name", type="string", example="Installation progressive"),
 *         @OA\Property(property="code", type="string", example="progressive")
 *     ),
 *     @OA\Property(
 *         property="offer_types",
 *         type="array",
 *
 *         @OA\Items(
 *             type="object",
 *
 *             @OA\Property(property="id", type="integer"),
 *             @OA\Property(property="name", type="string"),
 *             @OA\Property(property="code", type="string")
 *         )
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="JobOffer",
 *     type="object",
 *     title="Job Offer",
 *
 *     @OA\Property(property="job_description", type="string", example="Recherche ouvrier agricole"),
 *     @OA\Property(property="experience_farming", type="string", nullable=true, example="Expérience souhaitée"),
 *     @OA\Property(property="is_activity_transmission", type="boolean", example=false)
 * )
 *
 * @OA\Schema(
 *     schema="JobSeek",
 *     type="object",
 *     title="Job Seek",
 *
 *     @OA\Property(property="experience_farming", type="string", nullable=true, example="5 ans d'expérience en maraîchage")
 * )
 *
 * @OA\Schema(
 *     schema="AssociateOffer",
 *     type="object",
 *     title="Associate Offer",
 *
 *     @OA\Property(property="surface", type="number", format="float", example=30.0),
 *     @OA\Property(property="altitude", type="number", format="float", nullable=true, example=200.0),
 *     @OA\Property(property="water_access", type="integer", example=1),
 *     @OA\Property(property="has_buildings", type="boolean", example=true),
 *     @OA\Property(property="has_houses", type="boolean", example=false),
 *     @OA\Property(property="associate_description", type="string", nullable=true, example="Recherche associé motivé"),
 *     @OA\Property(property="experience_farming", type="string", nullable=true, example="15 ans d'expérience"),
 *     @OA\Property(property="is_activity_transmission", type="boolean", example=true),
 *     @OA\Property(property="accept_zip_code_use", type="boolean", example=true)
 * )
 *
 * @OA\Schema(
 *     schema="AssociateSeek",
 *     type="object",
 *     title="Associate Seek",
 *
 *     @OA\Property(property="is_land_already_found", type="boolean", example=false),
 *     @OA\Property(property="land_description", type="string", nullable=true, example="Recherche terrain adapté"),
 *     @OA\Property(property="associate_description", type="string", nullable=true, example="Recherche associé complémentaire"),
 *     @OA\Property(property="experience_farming", type="string", nullable=true, example="Débutant motivé")
 * )
 *
 * @OA\Schema(
 *     schema="Pagination",
 *     type="object",
 *     title="Pagination",
 *     description="Pagination information (only present when using page parameter)",
 *
 *     @OA\Property(property="current_page", type="integer", example=1),
 *     @OA\Property(property="per_page", type="integer", example=20),
 *     @OA\Property(property="total", type="integer", example=150)
 * )
 *
 * @OA\Schema(
 *     schema="Meta",
 *     type="object",
 *     title="Meta",
 *
 *     @OA\Property(property="generated_at", type="string", format="date-time", example="2025-09-26T12:30:00Z"),
 *     @OA\Property(property="total_filtered", type="integer", example=150, description="Total number of filtered results"),
 *     @OA\Property(
 *         property="filters_applied",
 *         type="object",
 *         @OA\Property(property="updated_since", type="string", nullable=true, example="2025-09-25T00:00:00Z"),
 *         @OA\Property(
 *             property="types",
 *             type="array",
 *             nullable=true,
 *
 *             @OA\Items(type="string")
 *         ),
 *
 *         @OA\Property(property="region_code", type="string", nullable=true)
 *     ),
 *     @OA\Property(property="current_page", type="integer", example=1, description="Only present with pagination"),
 *     @OA\Property(property="from", type="integer", example=1, description="Only present with pagination"),
 *     @OA\Property(property="last_page", type="integer", example=10, description="Only present with pagination"),
 *     @OA\Property(property="path", type="string", example="https://objectif-terres.org/api/v1/ads", description="Only present with pagination"),
 *     @OA\Property(property="per_page", type="integer", example=20, description="Only present with pagination"),
 *     @OA\Property(property="to", type="integer", example=20, description="Only present with pagination"),
 *     @OA\Property(property="total", type="integer", example=150, description="Only present with pagination")
 * )
 *
 * @OA\Schema(
 *     schema="Links",
 *     type="object",
 *     title="Links",
 *     description="Pagination links (only present when using pagination)",
 *
 *     @OA\Property(property="first", type="string", format="url", example="https://objectif-terres.org/api/v1/ads?page=1"),
 *     @OA\Property(property="last", type="string", format="url", example="https://objectif-terres.org/api/v1/ads?page=10"),
 *     @OA\Property(property="prev", type="string", format="url", nullable=true, example=null),
 *     @OA\Property(property="next", type="string", format="url", nullable=true, example="https://objectif-terres.org/api/v1/ads?page=2")
 * )
 */
class OpenApiSchemas
{
    // This class only contains OpenAPI schema definitions
}
