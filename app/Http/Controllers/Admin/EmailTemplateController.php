<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EmailTemplateController extends Controller
{
    public function index()
    {
        $templates = EmailTemplate::orderBy('name')->get();
        
        return Inertia::render('Admin/EmailTemplates/Index', [
            'templates' => $templates,
        ]);
    }

    public function edit(EmailTemplate $emailTemplate)
    {
        return Inertia::render('Admin/EmailTemplates/Edit', [
            'template' => $emailTemplate,
        ]);
    }

    public function update(Request $request, EmailTemplate $emailTemplate)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|array',
            'subject.en' => 'required|string|max:255',
            'subject.mk' => 'nullable|string|max:255',
            'body' => 'required|array',
            'body.en' => 'required|string',
            'body.mk' => 'nullable|string',
            'is_active' => 'boolean',
            'recipient_emails' => 'nullable|array',
            'recipient_emails.*' => 'email',
        ]);

        // Filter out empty emails
        if (isset($validated['recipient_emails'])) {
            $validated['recipient_emails'] = array_filter($validated['recipient_emails']);
        }

        $emailTemplate->update($validated);

        return redirect()->route('admin.email-templates.index')
            ->with('success', 'Email template updated successfully.');
    }

    public function preview(Request $request, EmailTemplate $emailTemplate)
    {
        $locale = $request->get('locale', 'en');
        
        // Generate sample variables
        $sampleVariables = [];
        foreach ($emailTemplate->available_variables ?? [] as $var) {
            $sampleVariables[$var] = "[Sample {$var}]";
        }
        
        return response()->json([
            'subject' => $emailTemplate->renderSubject($sampleVariables, $locale),
            'body' => $emailTemplate->renderBody($sampleVariables, $locale),
        ]);
    }
}
