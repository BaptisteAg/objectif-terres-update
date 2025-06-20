<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Omniphx\Forrest\Providers\Laravel\Facades\Forrest; // Assurez-vous que le namespace est correct pour votre version de Forrest

class SalesforceOAuthController extends Controller
{
    /**
     * Redirige l'utilisateur vers Salesforce pour l'authentification.
     */
    public function redirectToSalesforce()
    {
        // La méthode authenticate() de Forrest s'occupe de construire l'URL d'autorisation
        // et de rediriger l'utilisateur vers Salesforce.
        // Les paramètres 'display', 'immediate', 'state', 'scope', 'prompt'
        // de votre config forrest.php peuvent influencer cette redirection.
        return Forrest::authenticate();
    }

    /**
     * Gère le callback de Salesforce après l'authentification.
     * Salesforce redirige ici avec un code d'autorisation.
     */
    public function handleSalesforceCallback(Request $request)
    {
        try {
            // La méthode callback() de Forrest gère l'échange du code d'autorisation
            // contre un jeton d'accès et un jeton de rafraîchissement.
            // Elle stocke ensuite ces jetons (selon votre config 'storage').
            Forrest::callback();

            // Redirigez l'utilisateur vers une page de succès ou une page d'administration.
            // Pour une connexion API "système", cette redirection est surtout pour confirmer
            // que l'authentification initiale a fonctionné.
            return redirect('/')->with('success', 'Connexion à Salesforce établie avec succès !');
            // Ou, par exemple, vers une page spécifique :
            // return redirect()->route('admin.dashboard')->with('success', 'Salesforce connecté.');

        } catch (\Exception $e) {
            // Gérez les erreurs d'authentification ici
            // Loggez l'erreur, affichez un message à l'utilisateur, etc.
            // Par exemple :
            // Log::error('Erreur callback Salesforce: ' . $e->getMessage());
            return redirect('/')->with('error', 'Échec de la connexion à Salesforce : ' . $e->getMessage());
        }
    }

    /**
     * Optionnel : Une méthode pour tester la connexion après authentification.
     */
    public function testSalesforceConnection()
    {
        //if (!Forrest::isAuthenticated()) {
            // Si vous voulez forcer une nouvelle authentification si elle est perdue
            // return redirect()->action([SalesforceOAuthController::class, 'redirectToSalesforce']);
            //return "Non authentifié auprès de Salesforce. Veuillez vous connecter d'abord.";
        //}

        try {
            // Exemple d'appel API simple pour vérifier la connexion
            $identity = Forrest::identity();
            return response()->json([
                'message' => 'Connexion à Salesforce réussie !',
                'identity' => $identity
            ]);
        } catch (\Omniphx\Forrest\Exceptions\MissingTokenException $e) {
            // Cela peut arriver si le token n'est pas trouvé (par ex. cache expiré et pas de refresh token valide)
            // Log::error('Token Salesforce manquant : ' . $e->getMessage());
            // Rediriger vers l'authentification pourrait être une option ici
            return redirect()->action([SalesforceOAuthController::class, 'redirectToSalesforce'])
                             ->with('info', 'Session Salesforce expirée ou invalide. Veuillez vous reconnecter.');
        } catch (\Exception $e) {
            // Gérez d'autres erreurs d'API ici
            // Log::error('Erreur API Salesforce: ' . $e->getMessage());
            return response()->json([
                'message' => 'Erreur lors de la communication avec Salesforce.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Optionnel : Une méthode pour révoquer le token (déconnexion)
     * Utile pour les tests ou si vous voulez permettre une déconnexion manuelle.
     */
    public function revokeSalesforceToken()
    {
        try {
            Forrest::revoke();
            return redirect('/')->with('success', 'Déconnexion de Salesforce réussie et jeton révoqué.');
        } catch (\Exception $e) {
            // Log::error('Erreur lors de la révocation du token Salesforce: ' . $e->getMessage());
            return redirect('/')->with('error', 'Erreur lors de la déconnexion de Salesforce : ' . $e->getMessage());
        }
    }
}
