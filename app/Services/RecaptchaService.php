<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RecaptchaService
{
    /**
     * Verify a reCAPTCHA v3 token and return the result.
     *
     * @param string|null $token
     * @return array ['success' => bool, 'score' => float|null, 'error' => string|null]
     */
    public function verify(?string $token): array
    {
        // If reCAPTCHA is disabled, return success
        if (!config('messaging.recaptcha.enabled')) {
            return [
                'success' => true,
                'score' => null,
                'error' => null,
            ];
        }

        // If no token provided
        if (empty($token)) {
            return [
                'success' => false,
                'score' => null,
                'error' => 'Token reCAPTCHA manquant.',
            ];
        }

        $secretKey = config('messaging.recaptcha.secret_key');

        if (empty($secretKey)) {
            Log::warning('reCAPTCHA secret key not configured');
            return [
                'success' => true, // Allow if not configured
                'score' => null,
                'error' => null,
            ];
        }

        try {
            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $secretKey,
                'response' => $token,
                'remoteip' => request()->ip(),
            ]);

            $result = $response->json();

            if (!$result['success']) {
                Log::warning('reCAPTCHA verification failed', [
                    'error-codes' => $result['error-codes'] ?? [],
                ]);
                return [
                    'success' => false,
                    'score' => null,
                    'error' => 'Verification reCAPTCHA echouee.',
                ];
            }

            $score = $result['score'] ?? 0;
            $minScore = config('messaging.recaptcha.min_score', 0.5);

            if ($score < $minScore) {
                Log::info('reCAPTCHA score too low', [
                    'score' => $score,
                    'min_score' => $minScore,
                    'ip' => request()->ip(),
                ]);
                return [
                    'success' => false,
                    'score' => $score,
                    'error' => 'Verification de securite echouee. Veuillez reessayer.',
                ];
            }

            return [
                'success' => true,
                'score' => $score,
                'error' => null,
            ];
        } catch (\Exception $e) {
            Log::error('reCAPTCHA verification error', [
                'message' => $e->getMessage(),
            ]);
            return [
                'success' => true, // Allow on error to not block legitimate users
                'score' => null,
                'error' => null,
            ];
        }
    }

    /**
     * Check if reCAPTCHA is enabled.
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        return config('messaging.recaptcha.enabled', false)
            && !empty(config('messaging.recaptcha.site_key'))
            && !empty(config('messaging.recaptcha.secret_key'));
    }

    /**
     * Get the site key for frontend.
     *
     * @return string|null
     */
    public function getSiteKey(): ?string
    {
        return config('messaging.recaptcha.site_key');
    }
}
