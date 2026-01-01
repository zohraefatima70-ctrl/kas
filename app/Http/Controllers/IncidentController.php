<?php

// app/Http/Controllers/IncidentController.php

use App\Models\Incident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncidentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'resource_id' => 'required|exists:resources,id',
            'title' => 'required|string|max:150',
            'description' => 'required|string|max:1000',
        ]);

        $incident = Incident::create([
            'user_id' => Auth::id(),
            'resource_id' => $validated['resource_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'status' => 'pending', // Statut initial
        ]);
        
        // Notification au Responsable Technique (ou à l'Admin) de la ressource concernée

        return back()->with('success', 'Incident signalé avec succès. Un responsable sera notifié.');
    }
}