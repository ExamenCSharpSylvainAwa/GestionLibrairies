<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        // Vérification de la signature GitHub
        $githubSignature = $request->header('X-Hub-Signature-256');
        $payload = $request->getContent();
        
        // Récupérer le secret depuis la configuration
        $secret = config('services.github.webhook_secret');

        // Calculer la signature
        $computedSignature = 'sha256=' . hash_hmac('sha256', $payload, $secret);

        // Comparer les signatures
        if (!hash_equals($githubSignature, $computedSignature)) {
            Log::warning('Invalid GitHub webhook signature', [
                'received' => $githubSignature,
                'computed' => $computedSignature
            ]);
            return response()->json(['error' => 'Invalid signature'], 403);
        }

        // Log détaillé de l'événement
        Log::info('GitHub Webhook received', [
            'event' => $request->header('X-GitHub-Event'),
            'delivery' => $request->header('X-GitHub-Delivery'),
            'payload' => $request->all()
        ]);

        // Gérer différents types d'événements
        $event = $request->header('X-GitHub-Event');
        switch ($event) {
            case 'ping':
                return response()->json(['message' => 'Webhook is working']);
            case 'push':
                // Logique spécifique pour les push
                break;
            // Ajouter d'autres cas selon vos besoins
        }

        return response()->json(['status' => 'success']);
    }
}